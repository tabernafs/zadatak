<?php

class Site extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
		
	}
	
	function members_crud()
	
	        {
	        		
		$this->load->library('Grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->columns('id');
		$crud->fields('first_name','last_name','user_name','password','web','email_address');
		//$crud->fields('lastName','firstName','extension','email','jobTitle');
        $crud->set_table('membership');
		return $crud;
				
				
	        }
	
	
	
	function members_area()
	{
		
		print_r($this->session->userdata('isadmin'));
		
		$crud = $this->members_crud();
		
		if( $this->session->userdata('isadmin') ==1 )
		{
			
			
			$data['output'] = $crud->render();



		$data['main_content']='members_area';
		$this->load->view('includes/template', $data);
		}
		else 
			{				   
				$state = $crud->getState();
				
				// ako korisnik nije admin ne smije na list (tablica )
				if($state != 'edit')
				 
				  {
					redirect('site/members_area/edit/' .$this->session->userdata('id'));
				  
				  }
				else {
						$state_info = $crud->getStateInfo();	
						print_r($state_info->primary_key);
						if ($state_info->primary_key !== $this->session->userdata('id'))
						  {
							redirect('site/members_area/edit/' .$this->session->userdata('id'));
						  }
						else {
						$data['output'] = $crud->render();	
						$data['main_content']='members_area';
						$this->load->view('includes/template', $data);
							
						     }
						}
			}
	}
	
	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!isset($is_logged_in) || $is_logged_in !=true)
		{
			echo 'You dont have permission to be here!!! <a href="../login">Login</a>';
			die();
		}
	}
}
