<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 * 
 * @extends CI_Controller
 */
class Teacher extends CI_Controller {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	private $user_type;
	private $depertment;
	private $teacher_id;
	public function __construct() {
		
		parent::__construct();
		$this->load->model('teacher_model');		
		if(empty($_SESSION['user_type'])) {			
			redirect('login');
		}
		$this->user_type = $_SESSION['user_type'];
		$this->depertment = $_SESSION['user']['dept_id'];
		$this->teacher_id = $_SESSION['user']['id'];
		$this->load->library('grocery_CRUD');
	}
	
	/**
	* index function
	*
	* @access public
	* @return void
	*/
	
	public function index() 
	{		
		$this->loadview('Dashboard', 'dashboard', '');		
	}

	/**
	 * teachers_page function
	 *
	 * @access public
	 * @return void 
	 */
	
	public function teachers_page()
	{
		$crud = new grocery_CRUD();
		//$crud->set_theme('datatables');
		$crud->where('dept_id',$this->depertment);
		$crud->set_table('ums_teacher')
				->set_subject('Teacher')
				->columns('name','address','phone','email','avatar','status');				
		$crud->set_relation('status','ums_status2','name');
		$crud->set_field_upload('avatar','assets/uploads/teacher');
		$crud->unset_operations();
		$output = $crud->render();
		$this->loadview('Teachers', 'teachers', $output);
	}

	/**
	 * subject_page function
	 *
	 * @access public
	 * @return void 
	 */

	public function subject_page() 
	{				
		$batch_id = $this->uri->segment(3);
		$subject_id = $this->uri->segment(4);
		$crud = new grocery_CRUD();
		$crud->where('ums_teacher_assign_subject_notice.dept_id',$this->depertment);
		$crud->where('batch_id',$batch_id);
		//$crud->set_theme('datatables');
		$crud->set_table('ums_teacher_assign_subject_notice')
				->set_subject('Subject Notice')
				->columns('title','description','created_at','updated_at');
		$crud->add_fields('dept_id','batch_id','subject_id','title','description','created_at');
		$crud->edit_fields('dept_id','batch_id','subject_id','title','description','updated_at');
		$crud->change_field_type('dept_id', 'hidden', $this->depertment);
		$crud->change_field_type('batch_id', 'hidden', $batch_id);
		$crud->change_field_type('subject_id', 'hidden', $subject_id);		
		$crud->set_rules('title','Title','required');
		$crud->set_rules('description','Description','required');		
		$crud->set_rules('created_at','Created At','required');
		$crud->set_rules('updated_at','Updated At','required');
		// $crud->set_field_upload('file','assets/uploads/files');
		$output = $crud->render();		
		$this->loadview('Subject Page', 'SubjectPage', $output);		
	}


	/**
	 * notice_page function
	 *
	 * @access public
	 * @return void 
	 */

	public function notice_page() 
	{
		$crud = new grocery_CRUD();
		$crud->where('dept_id',$this->depertment);
		$crud->where('status',2);
		//$crud->set_theme('datatables');
		$crud->set_table('ums_notice')
				->set_subject('Notice')
				->columns('dept_id','name','file','created_at');
		$crud->display_as('dept_id','Depertment');			
		$crud->set_relation('dept_id','ums_dept_list','name',['id'=>$this->depertment]);		
		$crud->set_relation('status','ums_status2','name');		
		$crud->set_field_upload('file','assets/uploads/files');
		$crud->unset_operations();
		$output = $crud->render();
		$this->loadview('Notices', 'notices', $output);
	}

	/**
	 * report function
	 *
	 * @access public
	 * @return void 
	 */

	public function report() 
	{
		$crud = new grocery_CRUD();
		$crud->where('dept_id',$this->depertment);
		$crud->where('teacher_id',$this->teacher_id);
		//$crud->set_theme('datatables');
		$crud->set_table('ums_teacher_report')
				->set_subject('Report')
				->columns('title','description','created_at');	
		$crud->add_fields('dept_id','teacher_id','title','description','created_at');
		$crud->change_field_type('dept_id','hidden',$this->depertment);
		$crud->change_field_type('teacher_id','hidden',$this->teacher_id);
		$crud->set_rules('title','Title','required');
		$crud->set_rules('description','Description','required');
		$crud->set_rules('created_at','Created At','required');
		$crud->unset_edit();
		$crud->unset_clone();
		$crud->unset_delete();
		$output = $crud->render();
		$this->loadview('Report', 'report', $output);
	}

	/**
	 * viewload function
	 *
	 * @access public
	 * @param string $pageTitle
	 * @param string $pageName
	 * @param string $pageData 
	 * @return void
	 */
	
	public function loadview($pageTitle,$pageName,$pageData = '')
	{
		$title['title'] = $pageTitle;
		$data['header']  = $this->load->view('inc/back_header',$title,true);
		$data['sidebar'] = $this->load->view($this->user_type.'/'.'sidebar','',true);
		$data['footer']  = $this->load->view('inc/back_footer','',true);
		$data['content'] = $this->load->view($this->user_type.'/'.$pageName,$pageData,true);
		$this->load->view('back_master',$data);
	}
	
	
}
