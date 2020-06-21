<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Myroom extends CI_Controller{
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
			$data['kamar'] = $this->M_CallSQL->getkamar($this->session->userdata('idhotel'));
			$view = array(
				$this->load->view('template/v_header'),
				$this->load->view('content/Myroom/v_myroom', $data),
				$this->load->view('template/v_footer')
			);
		}
	}

	function panel($index){
		$idkamar = $index;
		if($this->session->userdata('status') != "Login"){
			redirect(base_url("login"));
		}else{
			if(!$this->session->userdata('idhotel')){
				$this->session->sess_destroy();
				redirect(base_url('login'));
			}
			$result = $this->M_CallSQL->getPanelKamar($this->session->userdata('idhotel'),$idkamar);
			$data['idkamar'] = $result['k_id'];
			$data['nomorkamar'] = $result['k_nomor'];
			$data['pengunjung'] = $result['u_username'];
			$data['checkin']    = $result['m_checkin'];
			$data['checkout']   = $result['m_checkout'];
			$data['status']     = $result['m_status'];
			$data['statuspintu'] = $result['k_pintu'];
			$data['statuslampu'] = $result['k_listrik'];
			$data['statuskipas'] = $result['k_kipas'];
			$view = array(
				$this->load->view('template/v_header'),
				$this->load->view('content/myroom/v_roomcontrol', $data),
				$this->load->view('template/v_footer')
			);
		}
	}

	function confirmchout(){
		$idtransaksi = $this->input->post('idtransaksi');
		if($this->session->userdata('status') == "Login"){
			$where = array('t_id' => $idtransaksi);
			$update = array(
		    	'm_checkout' => date('Y-m-d H:i:s')
			);
			$this->db->where($where)
				 ->update('ht_transaksi',$update);
			$this->db->delete('ht_transaksi', $where);
			$result = ($this->db->affected_rows() != 1) ? 'failed' : 'success';
			if($result=='success'){
				$this->session->set_flashdata('confirm_success', 'Konfirmasi sukses!');
				redirect(base_url("hotel"));
			}else if($result=='failed'){
				$this->session->set_flashdata('confirm_failed', 'Konfirmasi gagal!');
				redirect(base_url("hotel"));
			}
		}
	}
}