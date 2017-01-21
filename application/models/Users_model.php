<?php 

/**
* 
*/
class Users_model extends CI_Model
{
	
	public function __construct()
	{
		$this->load->database();
	}

	public function get_users()
	{
		if ($id === FALSE) {
			$query = $this->db->get('users');
			return $query->result_array();
		}

		$query = $this->db->get_where('users', array('user_id' => $id ));
	}

	public function register_user($username, $email, $password)
	{
		$query = $this->db->query("call user_register('$email', '$password', '$username')");

		return $query->result()[0]->ODGOVOR;
	}

	public function login_user($email, $password)
	{
		$query = $this->db->query("call user_login('$email', '$password')");

		if (isset($query->result()[0])) {
			$user = $query->result()[0];

			session_start();

			$_SESSION['user_id'] = $user->user_id;
			$_SESSION['email'] = $user->email;
			$_SESSION['username'] = $user->username;
			$_SESSION['status'] = $user->status;
			$_SESSION['msg'] = "Hello $user->username!";

			echo $_SESSION['username'];
		}else{
			session_start();

			$_SESSION['msg'] = "Try again, please.";

			return $_SESSION['msg'];
		}
		
	}
}