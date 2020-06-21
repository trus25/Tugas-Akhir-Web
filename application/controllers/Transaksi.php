<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Transaksi extends CI_Controller{
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
			$data['transaksi'] = $this->db->select("a.t_id, c.k_nomor, b.u_username, a.t_tanggal, a.m_checkin, a.m_checkout, a.m_status")
									  ->from("ht_log_transaksi a")
									  ->join("ht_user b", "a.u_id = b.u_id")
									  ->join("ht_kamar c", "a.k_id = c.k_id")
									  ->get()
									  ->result();
			$view = array(
				$this->load->view('template/v_header'),
				$this->load->view('content/transaksi/v_transaksi', $data),
				$this->load->view('template/v_footer')
			);
		}
	}

	function add(){
		if($this->session->userdata('status') != "Login"){
			redirect(base_url("login"));
		}else{
			if(!$this->session->userdata('idhotel')){
				$this->session->sess_destroy();
				redirect(base_url('login'));
			}
			$idhotel = $this->input->post('idhotel');
			$username = $this->input->post('username');
			$idkamar = $this->input->post('idkamar');
			$checkin = $this->input->post('checkin');
			$durasi = $this->input->post('durasi');
			$query = $this->db->get_where("ht_user",array('u_username' => $username))->row_array();
			$iduser = $query['u_id'];
			$query = $this->db->get_where("ht_hotel",array('h_id' => $idhotel))->row_array();
			$total = (int)$query['h_price'] * (int)$durasi;

			if($idhotel!='' && $iduser!='' && $idkamar!='' && $checkin!='' && $durasi!=''){
				// $idhotel = '1';
				// $iduser = '1';
				// $idkamar = '4';
				// $checkin = '2020-05-11';
				// $durasi = '30';
				$jam = '13:00:00';
				$checkin = $checkin.' '.$jam;
				$checkout = strtotime($checkin.'+'.$durasi.' days');
				$checkout = date('Y-m-d H:i:s', $checkout);
		        $data = array(
				    'u_id' => $iduser,
				    'h_id' => $idhotel,
				    'k_id' => $idkamar,
				    'm_checkin' => date('Y-m-d H:i:s', strtotime($checkin)),
				    'm_checkout' => $checkout,
				    't_totalbayar' => $total
				);
				$this->db->insert('ht_transaksi',$data);
				$result = ($this->db->affected_rows() != 1) ? 'failed' : 'success';
				if($result=='success'){
					$this->session->set_flashdata('transaksi_sukses', 'Data transaksi sudah ditambahkan.');
				} else { 
					$this->session->set_flashdata('transaksi_gagal', 'Silahkan cek kembali pengisian transaksi.');
				}
				redirect(base_url('transaksi/add'));
			}else{
				$view = array(
				$this->load->view('template/v_header'),
				$this->load->view('content/transaksi/v_addtransaksi'),
				$this->load->view('template/v_footer')
				);
			}
		}
	}

	function rentRoom(){
		$idhotel = $this->input->post('idhotel');
		$iduser = $this->input->post('iduser');
		$idkamar = $this->input->post('idkamar');
		$checkin = $this->input->post('checkin');
		$durasi = $this->input->post('durasi');
		$total = $this->input->post('total');
		
		// $idhotel = '1';
		// $iduser = '1';
		// $idkamar = '4';
		// $checkin = '2020-05-11';
		// $durasi = '30';
		// $jam = '13:00:00';

		
		$checkin = $checkin.' '.$jam;
		$checkout = strtotime($checkin.'+'.$durasi.' days');
		$checkout = date('Y-m-d H:i:s', $checkout);
        $data = array(
		    'u_id' => $iduser,
		    'h_id' => $idhotel,
		    'k_id' => $idkamar,
		    'm_checkin' => date('Y-m-d H:i:s', strtotime($checkin)),
		    'm_checkout' => $checkout,
		    't_totalbayar' => $total
		);
		$this->db->insert('ht_transaksi',$data);
		$result = ($this->db->affected_rows() != 1) ? 'failed' : 'success';
		echo $result;
	}
}