<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Login extends CI_Controller{
 
	function __construct(){
		parent::__construct();
		$this->load->model('M_CallSQL');
        if($this->session->userdata('status') == "Login"){
            redirect(base_url("hotel"));
        }
	}

    function index(){
        $this->load->view('template/v_login');
    }
 
    function submit(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $userdata = array(
            'a_username' =>$username,
            'a_password' =>$password
        );
        // preg_match('/^([a-z]{2,})-?([0-9])$/i', $username, $result);
        $check = $this->db->get_where("ht_admin", $userdata)->row();
        if($check){
            $data_session = array(
                    'username' => $username,                    
                    'status' => "Login",
                    'idhotel' => $check->h_id
                    );
            $this->session->set_userdata($data_session);
            redirect(base_url("hotel"));
        } else {
            $this->session->set_flashdata('failed_login', 'Username atau Password Salah!');
            redirect(base_url('login'));
        }
    }
}