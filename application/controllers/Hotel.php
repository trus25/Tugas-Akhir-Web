<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Hotel extends CI_Controller{
 	private $url = 'http://192.168.1.102/';

	function __construct(){
		parent::__construct();
		$this->load->model('M_CallSQL');
		date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
	}
 
	function index(){
		if($this->session->userdata('status') != "Login"){
			redirect(base_url("login"));
		}else{
			if(!$this->session->userdata('idhotel')){
				$this->session->sess_destroy();
				redirect(base_url('login'));
			}
			$data['hotel'] = $this->M_CallSQL->getTransaksi($this->session->userdata('idhotel'));
			$view = array(
				$this->load->view('template/v_header'),
				$this->load->view('content/hotel/v_hotel', $data),
				$this->load->view('template/v_footer')
			);
		}
	}

	function lift(){
		if($this->session->userdata('status') != "Login"){
			redirect(base_url("login"));
		}else{
			if(!$this->session->userdata('idhotel')){
				$this->session->sess_destroy();
				redirect(base_url('login'));
			}
			// $where = array('h_id' => $this->session->userdata('idhotel'));
			$data['lift'] = $this->M_CallSQL->getPanelLift($this->session->userdata('idhotel'));
			// $data['lift'] = $this->db->get_where("ht_lift", $where)->result();
			$view = array(
				$this->load->view('template/v_header'),
				$this->load->view('content/hotel/v_lift', $data),
				$this->load->view('template/v_footer')
			);
		}
	}

	function showQR(){
		if($this->session->userdata('status') != "Login"){
			redirect(base_url("login"));
		}else{
			if(!$this->session->userdata('idhotel')){
				$this->session->sess_destroy();
				redirect(base_url('login'));
			}
			$hotel = $this->db->get("ht_hotel")->result();
			foreach ($hotel as $field) {
				$this->M_CallSQL->setQRCode($field->h_qrstring,$field->h_id);
			}
			$view = array(
				$this->load->view('template/v_header'),
				$this->load->view('content/hotel/v_qrcode'),
				$this->load->view('template/v_footer')
			);
		}
	}

	function logout(){
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}

}