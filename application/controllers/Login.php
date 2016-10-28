<?php

class Login extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();		
	}
	
	
	function index()
	{
		$data['main_content'] = 'login_form';
		$this->load->view('includes/template', $data);
	}
	
	function validate_credentials()
	{

		$this->load->model('membership_model');
		$query = $this->membership_model->validate();
		//echo "<pre>";
		//print_r($query);
		//die();
		if($query)
		{
			$data = array(
		'username' => $this->input->post('username'),
		'id'=>$query['id'],
		'isadmin'=>$query['isadmin'],
		'is_logged_in' => true
			);
			
			$this->session->set_userdata($data);
			if($query['isadmin'] == 1)
			{
				redirect('site/members_area/');
			}
			else
			{	 
			redirect('site/members_area/edit/' . $query['id']);
		
			}
		}
		else 
		{
	        redirect('site/index');
		}
	}
	
function signup()
   {
	$data['main_content'] = 'signup_form';
	$this->load->view('includes/template' , $data);
    }



function create_member()
{
	
	$this->load->library('form_validation');
	
	$this->form_validation->set_rules('first_name' , 'Name' , 'trim|required');
	$this->form_validation->set_rules('last_name' , 'Last Name' , 'trim|required');
	$this->form_validation->set_rules('email_address' , 'Email Address' , 'trim|required');
	
	$this->form_validation->set_rules('username', 'Username', 'required');
	$this->form_validation->set_rules('password' , 'Password' , 'required');
	$this->form_validation->set_rules('password_confirm' , 'Password Confirmation' , 'required|matches[password]');
	if($this->form_validation->run() == FALSE)
	{
		$this->signup();
	}
	else 
	{
		
		$this->load->model('membership_model');
		if($query = $this->membership_model->create_member())
		{
			$data['main_content'] = 'signup_successful';
			$this->load->view('includes/template' , $data);
			
		}
		else 
		{
			$this->load->view('signup_form');
		}
			
	}
	
}
}
