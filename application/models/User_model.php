<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class User_model extends CI_Model {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	
	public function __construct() 
	{		
		parent::__construct();
		$this->load->database();		
	}
	
	/**
	 * create_user function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $email
	 * @param mixed $password
	 * @param mixed $user_type
	 * @return bool true on success, false on failure
	 */

	public function create_user($username, $email, $password, $user_type) 
	{		
		$data = array(
			'username'   => $username,
			'email'      => $email,
			'password'   => $this->hash_password($password),
			'created_at' => date('Y-m-j H:i:s'),
		);		
		return $this->db->insert('ums_'.$user_type, $data);		
	}
	
	/**
	 * resolve_user_login function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $password
	 * @param mixed $user_type
	 * @return bool true on success, false on failure
	 */

	public function resolve_user_login($username, $password, $user_type) 
	{		
		$this->db->select('password');
		$this->db->from('ums_'.$user_type);
		$this->db->where('username', $username);
		$hash = $this->db->get()->row('password');
		$valid = $this->verify_password_hash($password, $hash);			
		if($valid) {
			$statusInt = $this->db->get_where('ums_'.$user_type,['username'=>$username])->row()->status;
			$status = $this->db->get_where('ums_status2',['id'=>$statusInt])->row()->name;
			// print_r($status);
			// die();
			if($status == 'Active') {
				return 'active';
			} else {
				return 'inactive';
			}	
		} else {
			return false;
		}
	} 	
	
	
	/**
	 * get_user_id_from_username function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $user_type
	 * @return int the user id
	 */

	public function get_user_id_from_username($username, $user_type) 
	{		
		$this->db->select('id');
		$this->db->from('ums_'.$user_type);
		$this->db->where('username', $username);
		return $this->db->get()->row('id');		
	}
	
	/**
	 * get_user function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @param mixed $user_type
	 * @return object the user object
	 */

	public function get_user($user_id, $user_type) 
	{		
		$this->db->from('ums_'.$user_type);
		$this->db->where('id', $user_id);
		return $this->db->get()->result_array();		
	}
	
	/**
	 * hash_password function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @return string|bool could be a string on success, or bool false on failure
	 */

	private function hash_password($password) 
	{		
		return password_hash($password, PASSWORD_BCRYPT);		
	}
	
	/**
	 * verify_password_hash function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @param mixed $hash
	 * @return bool
	 */

	private function verify_password_hash($password, $hash) 
	{		
		return password_verify($password, $hash);		
	}
	
}
