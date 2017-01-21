<?php 

/**
* 
*/
class Blog_posts_model extends CI_Model
{
	
	public function __construct()
	{
		$this->load->database();
	}

	public function count_posts()
	{
		return $this->db->count_all("posts");
	}

	public function get_posts($slug = FALSE, $comments = FALSE)
	{
		if ($slug === FALSE) 
 		{
 			$this->db->select('*');
			$this->db->from('posts');
			$this->db->join('users', 'users.user_id = posts.post_author');
			if (debug_backtrace()[1]['function'] == 'index') 
			{$this->db->limit(3);}
			$this->db->order_by('post_id', 'DESC');
			$query = $this->db->get();
			//var_dump(debug_backtrace()[1]['function']); || mb not so reliable

			return $query->result_array();
 		}
 			$this->db->select('*');
			$this->db->from('posts');
			$this->db->where('post_slug', $slug);
			$this->db->join('users', 'users.user_id = posts.post_author');
			if (!empty($comments)) 
			{$this->db->join('comments', 'comments.comment_post = posts.post_id');}
			$query = $this->db->get();
			
			return $query->result()[0];
	}

	public function get_cat_posts($category)
	{
		$this->db->select('*');
		$this->db->from('posts');
		$this->db->where('post_cat', $category);
		$this->db->join('users', 'users.user_id = posts.post_author');

		$query = $this->db->get();

		return $query->result_array();
	}

	public function search_posts()
	{
		$term = $this->input->post('term');

		$this->db->select('*');
		$this->db->from('posts');
		$this->db->like('post_content', $term);
		$this->db->or_like('post_tags', $term);
		$this->db->or_like('post_title', $term);
		$this->db->join('users', 'users.user_id = posts.post_author');

		$query = $this->db->get();

		return $query->result_array();
	}

	public function get_tag_posts($tag)
	{
		$this->db->select('*');
		$this->db->from('posts');
		$this->db->like('post_tags', $tag);
		$this->db->join('users', 'users.user_id = posts.post_author');

		$query = $this->db->get();

		return $query->result_array();
	}

	public function get_next_post($id)
	{
		$query = $this->db->query("SELECT * FROM `posts` WHERE `post_id` = (SELECT min(`post_id`) FROM `posts` WHERE `post_id` > $id)");

		return isset($query->result()[0]->post_slug)?
			$query->result()[0]->post_slug:"end";
	}

	public function get_prev_post($id)
	{
		$query = $this->db->query("SELECT * FROM `posts` WHERE `post_id` = (SELECT max(`post_id`) FROM `posts` WHERE `post_id` < $id)");

		return isset($query->result()[0]->post_slug)?
			$query->result()[0]->post_slug:"end";
	}

	public function get_pagination_posts($limit, $offset = NULL)
	{
		$this->db->limit($limit, $offset);
		$this->db->from('posts');
		$this->db->join('users', 'users.user_id = posts.post_author');
		$this->db->order_by('post_id', 'DESC');
		$query = $this->db->get();

		return $query->result_array();
	}

	public function get_post_id_from_slug($slug)
	{
		$query = $this->db->get_where('posts', array('post_slug' => $slug));

		return $query->result()[0]->post_id;
	}

	public function set_post()
	{
		$this->load->helper('url');
		$this->load->helper('simpleimage');

 		$slug = url_title($this->input->post('title'), 'dash', TRUE);

 		$data = array(
 			'post_title' => $this->input->post('title'),
 			'post_slug' => $slug,
 			'post_content' => $this->input->post('blog_post'),
 			'post_cat' => $this->input->post('category'),
 			'post_author' => $_SESSION['user_id'],
 			'post_tags' => $this->input->post('tags')
 			);
		$this->db->insert('posts', $data);
		$lastId = $this->db->insert_id();

		if (!empty($_FILES['img']['tmp_name'])) {
			$simpleimage = new abeautifulsite\SimpleImage($_FILES['img']['tmp_name']);
			$simpleimage->thumbnail(500,500);
			$simpleimage->save("./img/posts/".$lastId.".jpg");
		}

 		return TRUE;
	}

	public function generate_previews($posts, $text_length)
	{
		$previews = array();
		foreach ($posts as $key=>$post) {
			$post['preview'] = '';
			for ($i=0; $i < $text_length ; $i++) 
				{
					if (!isset($post['post_content'][$i])) {break;}
					$post['preview'] .= $post['post_content'][$i];	
				}
			$previews[$key] = $post['preview'] . "..." ;
		}
		return $previews;
	}

}