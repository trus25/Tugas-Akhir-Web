<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;
class M_CallSQL extends CI_Model{	
	function where($table,$where){		
		return $this->db->get_where($table,$where);
	}

	function pswd_encode($ifpsd){
		$result=md5($ifpsd.'*&@-_#%^.Fhb+}{');
		return $result;
	}
	
	function cekrole($role){
		return $this->db->get_where("bk_role",array('r_id'=> $role));
	}

	function sessdata(){
		$data['username'] = $this->session->userdata('username');
		$data['status'] = $this->session->userdata('role');
		$data['idhotel'] = $this->session->userdata('roleid');	
		return $data;
	}

	function input_data($data,$table){
		$this->db->insert($table,$data);
	}

	function update_data($where,$data,$table){
		$this->db->where($where);
		$this->db->update($table,$data);
	}	

	function getKamar($idhotel){
		$where = array('a.h_id' => $idhotel);
			$this->db->select("a.`k_id`, a.k_nomor, a.k_deviceid, b.m_checkin, b.m_checkout, b.t_id, b.m_status")
			 		->from('ht_kamar a')
			 		->join('(SELECT * FROM ht_transaksi
					  WHERE (NOW() BETWEEN m_checkin AND m_checkout)) b', 'a.k_id = b.k_id', 'left')
			 		->where($where);
		$query = $this->db->get();
		return $query->result();
	}

	function getTransaksi($idhotel){
		$where = array('a.h_id' => $idhotel);
			$this->db->select("a.`k_id`, a.k_nomor, a.k_deviceid, b.m_checkin, b.m_checkout, b.t_id, b.m_status")
			 		->from('ht_transaksi b')
			 		->join('ht_kamar a', 'a.k_id = b.k_id')
			 		->where('(NOW() BETWEEN m_checkin AND m_checkout)')
			 		->where($where);
		$query = $this->db->get();
		return $query->result();
	}

	function getPanelKamar($idhotel,$idkamar){
		$where = array('a.h_id' => $idhotel,
				'a.k_id' => $idkamar);
		$this->db->select("a.`k_id`, a.k_nomor, c.u_username, b.m_checkin, b.m_checkout, b.m_status, a.k_pintu, a.k_listrik, a.k_kipas");
		$this->db->from('ht_kamar a');
		$this->db->join('(SELECT * FROM ht_transaksi
				  WHERE (NOW() BETWEEN m_checkin AND m_checkout)) b', 'a.k_id = b.k_id', 'left');
		$this->db->join('ht_user c','b.u_id=c.u_id','left');
		$this->db->where($where);
		$query = $this->db->get();
		if($query->num_rows() != 0)
	    {
	        return $query->row_array();
	    }
	    else
	    {
	        return false;
	    }
	}

	function getPanelLift($idhotel){
		$where = array('h_id' => $idhotel);
		$query = $this->db->get_where("ht_lift", $where);
		return $query->result();
	}

	function setQRCode($qrcode,$idhotel){
		// Create a basic QR code
		$qrCode = new QrCode($qrcode);
		$qrCode->setSize(300);

		// Set advanced options
		// $qrCode->setWriterByName('png');
		// $qrCode->setEncoding('UTF-8');
		// $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH());
		// $qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
		// $qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
		// $qrCode->setLabel('Scan the code', 16, './vendor/endroid/qr-code/assets/fonts/noto_sans.otf', LabelAlignment::CENTER());
		// $qrCode->setLogoPath('./vendor/endroid/qr-code/assets/images/symfony.png');
		// $qrCode->setLogoSize(150, 200);
		// $qrCode->setValidateResult(false);

		// Apply a margin and round block sizes to improve readability
		// Please note that rounding block sizes can result in additional margin
		$qrCode->setRoundBlockSize(true);
		$qrCode->setMargin(10); 

		// Set additional writer options (SvgWriter example)
		// $qrCode->setWriterOptions(['exclude_xml_declaration' => true]);

		// Save it to a file
		$qrCode->writeFile('./uploads/qrcode/hotel'.$idhotel.'.png');

		// Generate a data URI to include image data inline (i.e. inside an <img> tag)
		$dataUri = $qrCode->writeDataUri();

		// Directly output the QR code
		// header('Content-Type: '.$qrCode->getContentType());
		// return $qrCode->writeString();
	}

}