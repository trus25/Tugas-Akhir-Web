<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller{
 	private $url = 'http://192.168.1.100/';

	function __construct(){
		parent::__construct();
		$this->load->model('M_CallSQL');
		date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
	}

	function login(){
		$username = $this->input->post('username');
        $password = $this->input->post('password');
    	$userdata = array(
    		'u_username' =>$username,
    		'u_password' =>$password
    	);
        $check = $this->db->get_where("ht_user", $userdata)->row();
        if(!$check){
        	echo "gagal";
        }else{
        	$data = null;
            //data transaksi
            $data['id'] = $check->u_id;
            $data['username'] = $check->u_username;
            $data['nama'] = $check->u_nama;
            $data['email'] = $check->u_email;
            $data['phone'] = $check->u_phonenumber;
            $output = array(
                "userdata" => $data
            );
            //output dalam format JSON
            header('Content-Type: application/json');
            echo json_encode($output);
        }
        
	}

    function register(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $nama = $this->input->post('nama');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');

        // $username = 'test14';
        // $password = '1234';
        // $nama = 'adsads';
        // $email = 'test1@gmail.com';
        // $phone = '1231412';

        $stusername = 0;
        $stemail = 0;
        $stphone = 0;

        $checkus = $this->db->get_where("ht_user",array('u_username' => $username ))->row();

        $checkem = $this->db->get_where("ht_user",array('u_email' => $email ))->row();

        $checkph = $this->db->get_where("ht_user",array('u_phonenumber' => $phone))->row();

        if($checkus){
            $stusername = 1;
        }

        if($checkem){
            $stemail = 1;
        }

        if($checkph){
            $stphone = 1;
        }

        if($stusername==1 || $stemail==1 || $stphone==1 ){
            echo $stusername.'|'.$stemail.'|'.$stphone;
        }else{
            $register = array(
                'u_username'=>$password,
                'u_password'=>$username,
                'u_nama'=>$nama,
                'u_email'=>$email,
                'u_phonenumber'=>$phone
            );
            $this->db->insert('ht_user',$register);
            $result = ($this->db->affected_rows() != 1) ? 'failed' : 'success';
            echo $result;
        }
    }
    
	function getHotel(){
		
    	$data = null;
        $list = $this->db->get_where("ht_hotel")->result();
        foreach ($list as $field) {
            $row = array();

            $row['idhotel'] = $field->h_id;
            $row['nama'] = $field->h_nama;
            $row['alamat'] = $field->h_alamat;
 			$row['harga'] = $field->h_price;
 			$row['image'] = $this->url.$field->h_image;
            $data[] = $row;
        }
        $output = array(
            "listhotel" => $data
        );
        //output dalam format JSON
        header('Content-Type: application/json');
        echo json_encode($output);
	}

	function getAvailableRoom(){
		$idhotel = $this->input->post('idhotel');
		$checkin = $this->input->post('checkin');
		$durasi  = $this->input->post('durasi');
		$jam = '13:00:00';
		// $idhotel = '1';
		// $checkin = '2020-05-29';
		// $durasi = '1';
		$checkin = $checkin.' '.$jam;
		$checkout  = date('Y-m-d H:i:s', strtotime($checkin.'+'.$durasi.' days'));
		$checkin  = date('Y-m-d H:i:s', strtotime($checkin));
		// echo $checkin;
		// echo ' | ';
		// echo $checkout;
		$this->db->select("ht_kamar.k_id")
			  ->from('ht_kamar')
			  ->join('ht_transaksi', 'ht_transaksi.k_id = ht_kamar.k_id')
			  ->where("(m_checkin BETWEEN '".$checkin."' AND '".$checkout."'
						OR m_checkout BETWEEN '".$checkin."' AND '".$checkout."'
						OR '".$checkin."' BETWEEN m_checkin  AND m_checkout
						OR '".$checkout."' BETWEEN m_checkin AND m_checkout)");
		$where_clause = $this->db->get_compiled_select();

		$this->db->select('*');
		$this->db->from('ht_kamar');
		$this->db->where('ht_kamar.h_id', $idhotel);
		$this->db->where("ht_kamar.`k_id` NOT IN ($where_clause)", NULL, FALSE);

		$query = $this->db->get();
    	$result = $query->result();
    	if(!$result){
    		echo 'null';
    	}else{
    		$data = null;

    	foreach ($result as $field) {
    		$row = array();
    		$row['idkamar'] = $field->k_id;
    		$row['nomorkamar'] = $field->k_nomor;
    		$data[] = $row;
    	}
		//data transaksi
        
		$output = array(
            "kamartersedia" => $data
        );
        //output dalam format JSON
        header('Content-Type: application/json');
        echo json_encode($output);
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

	function getMyroom(){
		$uid = $this->input->post('id');
		$now = date('Y-m-d H:i:s');
		$data = null;
		$user = array(
			'u_id' => $uid
		);
		$this->db->select("*")
				 ->from('ht_transaksi')
				 ->join('ht_hotel', 'ht_transaksi.h_id = ht_hotel.h_id')
				 ->join('ht_kamar', 'ht_transaksi.k_id = ht_kamar.k_id')
				 ->where($user)
				 ->order_by('ht_transaksi.t_id', 'desc');
		$query = $this->db->get();
		$list = $query->result();

		foreach ($list as $field) {
			if($now<date('Y-m-d H:i:s', strtotime($field->m_checkin))){
				$row = array();
 				$row['currentstatus'] = 'N';
 				$row['idtransaksi'] = $field->t_id;
	            $row['iduser'] = $field->u_id;
	            $row['idhotel'] = $field->h_id;
	 			$row['idkamar'] = $field->k_id;
	 			$row['tanggal'] = date('Y-m-d', strtotime($field->t_tanggal));
	 			$row['checkin'] = date('Y-m-d', strtotime($field->m_checkin));
	            $row['checkout'] =date('Y-m-d', strtotime($field->m_checkout));
	 			$row['checkinstats'] = $field->m_status;
	 		
	 			//data hotel
	            $row['nama'] = $field->h_nama;
	            $row['alamat'] = $field->h_alamat;
	 			$row['image'] = $this->url.$field->h_image;

	 			$row['nomor'] = $field->k_nomor;
	 			$row['qrcode'] = $field->h_qrstring;
	            $data[] = $row;
 			}else if( ($now>=date('Y-m-d H:i:s', strtotime($field->m_checkin)) && $now<=date('Y-m-d H:i:s', strtotime($field->m_checkout))) || $field->m_status =='2') {
 				$row = array();
 				$row['currentstatus'] = 'X';
 				$row['idtransaksi'] = $field->t_id;
	            $row['iduser'] = $field->u_id;
	            $row['idhotel'] = $field->h_id;
	 			$row['idkamar'] = $field->k_id;
	 			$row['tanggal'] = date('Y-m-d', strtotime($field->t_tanggal));
	 			$row['checkin'] = date('Y-m-d', strtotime($field->m_checkin));
	            $row['checkout'] =date('Y-m-d', strtotime($field->m_checkout));
	 			$row['checkinstats'] = $field->m_status;
	 			
	 			//data hotel
	            $row['nama'] = $field->h_nama;
	            $row['alamat'] = $field->h_alamat;
	 			$row['image'] = $this->url.$field->h_image;

	 			$row['nomor'] = $field->k_nomor;
	 			$row['qrcode'] = $field->h_qrstring;
	            $data[] = $row;
 			}
		}
		$output = array(
            "myroom" => $data
        );
        //output dalam format JSON
        header('Content-Type: application/json');
        echo json_encode($output);

	}

	function getRoomSharer(){
		$tid = $this->input->post('tid');
		$this->db->select("*")
			  ->from('ht_share')
			  ->join('ht_user', 'ht_share.u_id = ht_user.u_id')
			  ->where('ht_share.t_id', $tid);
		$query = $this->db->get();
    	$result = $query->result();
    	$data = null;

    	foreach ($result as $field) {
    		$row = array();
    		$row['sid'] = $field->s_id;
    		$row['uid'] = $field->u_id;
    		$row['username'] = $field->u_username;
    		$data[] = $row;
    	}
		//data transaksi
        
		$output = array(
            "roomsharer" => $data
        );
        //output dalam format JSON
        header('Content-Type: application/json');
        echo json_encode($output);
	}

	function confirm(){
		$idtransaksi = $this->input->post('idtransaksi');
		// $idtransaksi = '2';
		$where = array('t_id' => $idtransaksi);
        $update = array(
		    'm_status' => 1,
		    'm_checkin' => date('Y-m-d H:i:s')
		);
		$this->db->where($where)
				 ->update('ht_transaksi',$update);
		$result = ($this->db->affected_rows() != 1) ? 'failed' : 'success';
		if($this->session->userdata('status') == "Login"){
			if($result=='success'){
				$this->session->set_flashdata('confirm_success', 'CHECK IN sukses!');
				redirect(base_url("hotel"));
			}else if($result=='failed'){
					$this->session->set_flashdata('confirm_failed', 'CHECK IN gagal!');
					redirect(base_url("hotel"));
			}
		}else{
			echo $result;
		}
	}

	function checkout(){
		$idtransaksi = $this->input->post('idtransaksi');
		// $idkamar = '2';
		$where = array('t_id' => $idtransaksi);
        $update = array(
		    'm_status' => 2
		);
		$this->db->where($where)
				 ->update('ht_transaksi',$update);
		$result = ($this->db->affected_rows() != 1) ? 'failed' : 'success';
		
		if($this->session->userdata('status') == "Login"){
			if($result=='success'){
				$this->session->set_flashdata('confirm_success', 'CHECK OUT sukses!');
				redirect(base_url("hotel"));
			}else if($result=='failed'){
					$this->session->set_flashdata('confirm_failed', 'CHECK OUT gagal!');
					redirect(base_url("hotel"));
			}
		}else{
			echo $result;
		}
		
	}

	function chkhandler(){
		$idtransaksi = $this->input->post('idtransaksi');
		$where = array('t_id' => $idtransaksi);
		$result = $this->db->get_where("ht_transaksi", $where)->row_array();
		// $now = date('Y-m-d H:i:s');
		// $checkout = date('Y-m-d H:i:s', strtotime($result['m_checkout']));
		if(!$result){
			echo 'true';
		}else if($result['m_status']=='2'){
			echo 'wait';
		}
	}

	function roomcond(){
		$idkamar = $this->input->post('idkamar');
		// $idkamar = '1';
		$where = array('k_id' => $idkamar);
    	$result = $this->db->get_where('ht_kamar',$where)->row_array();
    	$data = null;
		//data transaksi
        $data['pintukamar'] = $result['k_pintu'];
        $data['lampukamar'] = $result['k_listrik'];
        $data['kipaskamar'] = $result['k_kipas'];
		$output = array(
            "roomcond" => $data
        );
        //output dalam format JSON
        header('Content-Type: application/json');
        echo json_encode($output);
	}

	function setPintu($status){
		$idkamar = $this->input->post('idkamar');
		// $idkamar = '1';
		$where = array('k_id' => $idkamar);
		$response = 'ERROR';
		$update = array(
		    'k_pintu' => $status
		);
		$this->db->where($where)
				 ->update('ht_kamar',$update);
		$result = ($this->db->affected_rows() != 1) ? 'failed' : 'success';
		if($result =='success'){
			if($status=='0'){
				$response = 'MATI'; 
			}else{
				$response = 'HIDUP';
			}
		}
		echo $response;
	}

	function setLampu($status){
		$idkamar = $this->input->post('idkamar');
		// $idkamar = '1';
		$where = array('k_id' => $idkamar);
		$response = 'ERROR';
		$update = array(
		    'k_listrik' => $status
		);
		$this->db->where($where)
				 ->update('ht_kamar',$update);
		$result = ($this->db->affected_rows() != 1) ? 'failed' : 'success';
		if($result =='success'){
			if($status=='0'){
				$response = 'MATI'; 
			}else{
				$response = 'HIDUP';
			}
		}
		echo $response;
	}

	function setKipas($status){
		$idkamar = $this->input->post('idkamar');
		// $idkamar = '1';
		$where = array('k_id' => $idkamar);
		$response = 'ERROR';
		$update = array(
		    'k_kipas' => $status
		);
		$this->db->where($where)
				 ->update('ht_kamar',$update);
		$result = ($this->db->affected_rows() != 1) ? 'failed' : 'success';
		if($result =='success'){
			if($status=='0'){
				$response = 'MATI'; 
			}else{
				$response = 'HIDUP';
			}
		}
		echo $response;
	}

	function setLift($status){
		$idlift = $this->input->post('idlift');
		// $idlift = '1';
		$where = array('l_id' => $idlift);
		$check = $this->db->get_where("ht_lift",$where)->row_array();
		$currstat = $check['l_status'];
		$update = array(
		    'l_status' => $status
		);
		$this->db->where($where)
				 ->update('ht_lift',$update);
		if($status == '1' && $currstat == 0 && !$this->session->userdata('idhotel')){
			sleep(5);
			$update = array(
		    		'l_status' => 0
			);
			$this->db->where($where)
				 ->update('ht_lift',$update);
		}
		echo 'done';
	}

	function getSharedroom(){
		$uid = $this->input->post('id');
		$now = date('Y-m-d H:i:s');
		// Create where clause
		$this->db->select('t_id');
		$this->db->from('ht_transaksi');
		$this->db->where('ht_transaksi.m_checkin <= ', $now);
		$this->db->where('ht_transaksi.m_checkout >= ', $now);
		$where_clause = $this->db->get_compiled_select();

		// Create main query
		$this->db->where('ht_share.u_id', $uid); 
		$this->db->where("ht_share.`t_id` NOT IN ($where_clause)", NULL, FALSE);
		$this->db->delete('ht_share'); 

		$data = null;
		$user = array(
			'ht_share.u_id' => $uid
		);
		$this->db->select("*")
				 ->from('ht_share')
				 ->join('ht_transaksi', 'ht_transaksi.t_id = ht_share.t_id')
				 ->join('ht_hotel', 'ht_transaksi.h_id = ht_hotel.h_id')
				 ->join('ht_kamar', 'ht_transaksi.k_id = ht_kamar.k_id')
				 ->where($user);
		$query = $this->db->get();
		$list = $query->result();

		foreach ($list as $field) {
			$row = array();
			//data transaksi
            $row['idtransaksi'] = $field->t_id;
            $row['iduser'] = $field->u_id;
            $row['idhotel'] = $field->h_id;
 			$row['idkamar'] = $field->k_id;
 			$row['tanggal'] = date('Y-m-d', strtotime($field->t_tanggal));
 			$row['checkin'] = date('Y-m-d', strtotime($field->m_checkin));
            $row['checkout'] =date('Y-m-d', strtotime($field->m_checkout));
 			$row['checkinstats'] = $field->m_status;
 			if($now<date('Y-m-d H:i:s', strtotime($field->m_checkin))){
 				$row['currentstatus'] = 'N';
 			}elseif($now>date('Y-m-d H:i:s', strtotime($field->m_checkout))){
 				$row['currentstatus'] = 'E';
 			}else{
 				$row['currentstatus'] = 'X';
 			}
 			

 			//data hotel
            $row['nama'] = $field->h_nama;
            $row['alamat'] = $field->h_alamat;
 			$row['image'] = $this->url.$field->h_image;

 			$row['nomor'] = $field->k_nomor;
 			$row['qrcode'] = $field->h_qrstring;
            $data[] = $row;
		}
		$output = array(
            "share" => $data
        );
        //output dalam format JSON
        header('Content-Type: application/json');
        echo json_encode($output);

	}

	function addShare(){
		$idtransaksi = $this->input->post('tid');
		$username = $this->input->post('username');
		$uid = $this->db->get_where('ht_user',array('u_username' => $username))->row_array();
		if(!$uid){
			echo 'notexist';
		}else{
			$where = array(
					'u_id' => $uid['u_id'],
					't_id' => $idtransaksi
					);
			$check = $this->db->get_where('ht_share', $where)->row();
			if (!$check){
				$data = array(
				    'u_id' => $uid['u_id'],
				    't_id' => $idtransaksi
				);
				$this->db->insert('ht_share',$data);
				$result = ($this->db->affected_rows() != 1) ? 'failed' : 'success';
				echo $result;
		    }else{
				echo "exist";
		    }
		}
		
	}

	function delete_sharer(){
    	$idshare = $this->input->post('sid');
    	$where = array(
			's_id' => $idshare
		 );
    	$this->db->delete('ht_share', $where);
    	$result = ($this->db->affected_rows() != 1) ? 'failed' : 'success';
    	echo $result;
	}

	public function getStsArd(){
		$devid = $this->input->get('devid');
		$data = $this->db->get_where("ht_kamar",array('k_deviceid'=> $devid))->row_array();
		$lift = $this->db->get_where("ht_lift",array('l_id' => 1))->row_array();
		$statusp = (int)($data['k_pintu']);
		$statusl = (int)($data['k_listrik']);
		$statusk = (int)($data['k_kipas']);
		$statuslft = (int)($lift['l_status']);
		echo $statusp.','.$statusl.','.$statusk.','.$statuslft;
	}
}