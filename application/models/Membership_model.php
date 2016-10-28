<?php 

class Membership_model extends CI_Model {
	
	function validate()
	{
	// provjera podataka za login u bazi	
	$this->db->where('username', $this->input->post('username'));
	$this->db->where('password', md5($this->input->post('password')));
	$query = $this->db->get('membership');
	
	// koliko ima rezultata
	// ako 0 -> vrati da ne znas tko je
	// ako 1 vrati mi redak i spremi u session podatke o ulogiranom useru
	
	
	if ($query->num_rows() == 1)
		{
			return $query->row_array();
		}
	
	else return false;
	
	
			
	
	/*print_r($query->row());
    //if ($query->isadmin = 1)
	     {
	     	//print_r($this->session->userdata());
			//$this->load->library('Grocery_CRUD');
			$crud = new grocery_CRUD();
			$crud->columns('id');
			$crud->fields('first_name','last_name','user_name','password','web','email_address');
        	$crud->set_table('membership');
			$data['output'] = $crud->render();
			$this->load->view('members_area', $data);
		
	     }
		 else if($query->num_rows() == 1)
			 {
	      		return $query->row()->id;
	 		 }
		 else return false;*/
}
	
	function create_member()
	{
		$new_member_insert_data = array(
		     'first_name' => $this->input->post('first_name'),
		     'last_name' => $this->input->post('last_name'),
		     'email_address' => $this->input->post('email_address'),
		     'username' => $this->input->post('username'),
		     'password' => md5($this->input->post('password')),
		     'web' => $this->input->post('web'),
		     'isadmin' => $this->input->post('isadmin')
		);
		
		$insert = $this->db->insert('membership' , $new_member_insert_data);
		return $insert;
		
	}
		
}		
      