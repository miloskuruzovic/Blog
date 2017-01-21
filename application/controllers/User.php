<?php 
/**
 * 
 */
 class User extends CI_Controller
 {
 	
 	public function __construct()
 	{
 		parent::__construct();
 		$this->load->model('users_model');
		$this->load->helper('url_helper');
 	}

 	public function register()
 	{
 		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['title'] = "Register";

		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required');

		if ($this->form_validation->run() === FALSE) 
		{
			$this->load->view('templates/header', $data);
			$this->load->view('default/register', $data);
			$this->load->view('templates/footer');
		}
		else
		{
			$username = $this->input->post('username');
			$email    = $this->input->post('email');
			$password = $this->input->post('password');

			$odgovor = $this->users_model->register_user($username, $email, $password);

			echo $odgovor;
		}
 		
 	}

 	public function login()
 	{
 		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		$data['title'] = "Login";

		if ($this->form_validation->run() === FALSE) 
		{
			//redirect(base_url());
			$this->load->view('templates/header', $data);
			$this->load->view('default/login', $data);
			$this->load->view('templates/footer');
		}
		else
		{
			$email    = $this->input->post('email');
			$password = $this->input->post('password');

			$this->users_model->login_user($email, $password);

			redirect(base_url());
		}
 	}

 	public function logout()
 	{
 		session_start();
		session_destroy();

		redirect(base_url());
 	}
 } 