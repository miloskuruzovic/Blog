<?php 

/**
|| home page limit 3 ||||| done using debug_backtrace(), explore this function further
||| all posts page - pagination, limit 2(for now) ||| done!
||||| make join query with comments ||||| comments done!
* consider blog image table
|||| try to implement SimpleImage or use CI image library ||| SimpleImage done!
* make notes for config of new CI project || (database (pdo?), removing index.php from url,making new .htaccess file ..)
* resolve text formating in blog posts (post->post_content)
* finish up the add/update post page 
||| tags, search page |||| done!
||| make categories model |||| Categories pages done!
||| consider expanding footer -_- ||| expanded enough
||| polish user stuff, try making bootstrap login modal ||| login done
||| adding comments ||| done
* mb preview image for blog post
* see if you need to rework next/prev after you order posts by DESC
*/
class Blog extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('blog_posts_model');
		$this->load->model('users_model');
		$this->load->model('comments_model');
		$this->load->model('categories_model');
		$this->load->helper('url_helper');
		$this->load->helper('form');
		$this->load->library('form_validation');
		session_start();
	}
	
	public function index()
	{
		$data['posts'] = $this->blog_posts_model->get_posts();
		$data['title'] = "Blog on fire! - Home";
		$data['categories'] = $this->categories_model->get_categories();

		$previews = $this->blog_posts_model->generate_previews($data['posts'],230);
		$data['previews'] = $previews;

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav', $data);
		$this->load->view('default/index', $data);
		$this->load->view('templates/footer');
	}

	public function cat_posts($category)
	{
		$data['posts'] = $this->blog_posts_model->get_cat_posts($category);
		$data['categories'] = $this->categories_model->get_categories();
		$data['selected_cat'] = $this->categories_model->get_categories($category);
		$data['title'] = "Blog on fire! - ". $data['selected_cat']->cat_name;

		$previews = $this->blog_posts_model->generate_previews($data['posts'],230);
		$data['previews'] = $previews;

		$this->load->view('templates/header', $data);
		$this->load->view('templates/cat_nav', $data);
		$this->load->view('default/category', $data);
		$this->load->view('templates/footer');
	}

	public function cat_list()
	{
		$data['categories'] = $this->categories_model->get_categories();
		$data['title'] = "Blog on fire! - Categories";

		$this->load->view('templates/header', $data);
		$this->load->view('default/categories', $data);
		$this->load->view('templates/footer');
	}

	public function all_posts($page_num = 0)
	{
		$this->load->library('pagination');
		$config['base_url'] = base_url() . "all/";
		$config['total_rows'] = $this->blog_posts_model->count_posts();
		$config['per_page'] = 2;
		$config['full_tag_open'] = '<ul class="pagination ">';
		$config['full_tag_close'] = '</ul>';
		$config['next_link']  = 'Next';
		$config['next_tag_open'] = '<li class="next">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = 'Previous';
		$config['prev_tag_open'] = '<li class="previous">';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="disabled"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$this->pagination->initialize($config);

		$data['posts'] = $this->blog_posts_model->get_pagination_posts($config['per_page'], $page_num);
		$data['title'] = "Blog on fire! - Posts";
		$data['categories'] = $this->categories_model->get_categories();

		$previews = $this->blog_posts_model->generate_previews($data['posts'],230);
		$data['previews'] = $previews;

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav', $data);
		$this->load->view('default/all_posts', $data);
		$this->load->view('templates/footer');
	}

	public function view_post($slug = NULL)
	{
		$post_id = $this->blog_posts_model->get_post_id_from_slug($slug);
		$data['comments'] = $this->comments_model->get_comments($post_id);
		$data['post'] = $this->blog_posts_model->get_posts($slug, $data['comments']);
		$data['title'] = "Blog on fire! - ".$data['post']->post_title;
		$data['tags'] = explode("-", $data['post']->post_tags);
		$data['next'] = $this->blog_posts_model->get_next_post($post_id);
		$data['prev'] = $this->blog_posts_model->get_prev_post($post_id);

		if (empty($data['post'])) {	show_404();	}

		$this->load->view('templates/header', $data);
		$this->load->view('default/post', $data);
		$this->load->view('templates/footer');
	}

	public function search()
	{
		$data['posts'] = $this->blog_posts_model->search_posts();
		$data['term'] = $this->input->post('term');
		$data['categories'] = $this->categories_model->get_categories();
		$previews = $this->blog_posts_model->generate_previews($data['posts'],230);
		$data['previews'] = $previews;
		$data['title'] = "Blog on fire! - ".$data['term'];

		$this->load->view('templates/header', $data);
		$this->load->view('templates/search_nav', $data);
		$this->load->view('default/search', $data);
		$this->load->view('templates/footer');

	}

	public function tag_posts($tag)
	{
		$data['term'] = $tag;
		$data['title'] = "Blog on fire! - ".$tag;
		$data['posts'] = $this->blog_posts_model->get_tag_posts($tag);
		$data['categories'] = $this->categories_model->get_categories();
		$previews = $this->blog_posts_model->generate_previews($data['posts'],230);
		$data['previews'] = $previews;

		$this->load->view('templates/header', $data);
		$this->load->view('templates/search_nav', $data);
		$this->load->view('default/tag_posts', $data);
		$this->load->view('templates/footer');
	}

	public function add_post()
	{

		if (!isset($_SESSION['status']) || $_SESSION['status'] < 2) {
			redirect(base_url());
		}
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('blog_post', 'Blog Post', 'required');
		$this->form_validation->set_rules('tags', 'Tags', 'required');

		$data['title'] = "Blog on fire! - Add Post";
		$data['categories'] = $this->categories_model->get_categories();

		if ($this->form_validation->run() === FALSE) 
		{
			$this->load->view('templates/header', $data);
			$this->load->view('default/add_post', $data);
			$this->load->view('templates/footer');
		}
		else
		{
			$this->blog_posts_model->set_post();
			echo "I did it?";
		}
	}

	public function add_comment($slug)
	{
		$post_id = $this->blog_posts_model->get_post_id_from_slug($slug);

		$this->comments_model->set_comment($post_id);

		$redirect_url = base_url() . "posts/" . $slug;

		redirect($redirect_url);

	}

	public function test()
	{
		echo "Is this how it works?";
		date_default_timezone_set('Europe/Belgrade');
		$date = date('m/d/Y h:i:s a', time());
		echo "<hr>Current date and time is: " . $date;
		echo '<hr>' . date_default_timezone_get();
	}
	
}