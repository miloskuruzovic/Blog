<?php 

/**
* 
*/
class Comments_model extends CI_Model
{
	
	public function __construct()
	{
		$this->load->database();
	}

	public function get_comments($post_id)
	{
		$this->db->select('*');
		$this->db->from('comments');
		$this->db->where('comment_post', $post_id);
		$this->db->join('users', 'users.user_id = comments.comment_user');
		$query = $this->db->get();

		return $query->result();
	}

	public function set_comment($post_id)
	{
		$data = array(
			'comment_content' => $this->input->post('comment'),
			'comment_user' => $_SESSION['user_id'],
			'comment_post' => $post_id,
			'comment_status' => 1
			);

		$this->db->insert('comments', $data);
	}
}