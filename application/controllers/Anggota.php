<?php
	class Anggota extends CI_Controller{
		public function __contruct(){
			parent::__contruct();
		}
		
		public function index(){
			if($this->session->userdata('pengguna')==NULL){
				redirect(base_url());
			}else{
				$data = array();
				$data['jenis_anggota'] = null;
				$data['records'] = null;
				if($query = $this->model_jenis_anggota->getData()){
					$data['jenis_anggota'] = $query;
				}
				if($query = $this->model_anggota->getDataWithoutAdmin()){
					$data['records'] = $query;
				}
				$this->load->view("view_anggota", $data);
			}		
		}
		
		public function deleteData(){
			$id = $this->uri->segment(3);
			$this->model_anggota->removeData($id);
			$path = 'assets/images/'.$id.'.jpg';
			if(unlink($path)) {
				 echo 'deleted successfully';
			}else{
				 echo 'errors occured';
			}
			redirect(base_url().'Anggota/');
		}
		
		public function createData(){
			$id_anggota = $this->input->post('id_anggota');
			$data = $this->createDataAnggota();
			$pengguna = $this->createDataPengguna($data['id_anggota']);
			if($id_anggota==null){
				$data = $this->uploadFile($data);
				$this->model_anggota->setData($data);
				$this->model_pengguna->setData($pengguna);
				
				$simpanan = $this->createDataSimpanan($data);
				$this->model_simpanan->setData($simpanan);
				
				$jurnal = $this->createDataJurnal($simpanan, $simpanan['jumlah_simpanan']);
				$jurnal['id_anggota'] = $simpanan['id_anggota']; 
				$jurnal['keterangan'] = $simpanan['id_simpanan'];
				$kas = $this->kas($jurnal, $simpanan, 'Debit');
				$this->model_jurnal->setData($kas);
				$simpananPokok = $this->simpananPokok($jurnal, $simpanan, 'Kredit');
				$this->model_jurnal->setData($simpananPokok);
			}else{
				$data['id_anggota'] = $id_anggota; 
				$data = $this->uploadFile($data);
				$this->model_anggota->updateData($id_anggota, $data);
			}
			redirect(base_url().'Anggota/');
		}
		
		public function uploadFile($data){
			$config['upload_path'] 	 = 'assets/images/';
			$config['allowed_types'] = 'jpg';
			$config['file_name']     = $data['id_anggota'].'.jpg';
			$config['overwrite']     = true;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->set_allowed_types('*');
			if($this->upload->do_upload('foto')){
				$data['foto'] = 'assets/images/'.$data['id_anggota'].'.jpg';
			}
			return $data;
		}
		
		public function createDataAnggota(){
			$id_anggota = "";
			if($this->model_anggota->getID()->num_rows()>0){
				$id_anggota = "ANG-".$this->model_anggota->getID()->result()[0]->id_anggota;
			}else{
				$id_anggota = "ANG-0000000001";
			}
			$data = array(
				'id_anggota' => $id_anggota,
				'nama' => $this->input->post('nama'),
				'alamat' => $this->input->post('alamat'),
				'tanggal_masuk' => $this->input->post('tanggal_masuk'),
				'gaji' => $this->input->post('gaji'),
				'foto' => '',
				'id_jenis_anggota' => $this->input->post('id_jenis_anggota'),
				'status' => $this->input->post('status')
			);
			return $data;
		}
		
		public function createDataSimpanan($data){
			$id_simpanan = '';
			$tanggal_pembuatan = $this->input->post('tanggal_masuk');
			if($this->model_simpanan->getID($tanggal_pembuatan)->num_rows()>0){
				$id_simpanan = "SMP-".str_replace('-','',$tanggal_pembuatan).$this->model_simpanan->getID($tanggal_pembuatan)->result()[0]->id_simpanan;
			}else{
				$id_simpanan = "SMP-".str_replace('-','',$tanggal_pembuatan)."0001";
			}
			$simpanan = array(
				'id_simpanan' => $id_simpanan,
				'id_anggota' => $data['id_anggota'],
				'id_jenis_anggota' => $data['id_jenis_anggota'],
				'id_jenis_simpanan' => 'JSMP-01',
				'jumlah_simpanan' => 150000,
				'tanggal_pembuatan' => $tanggal_pembuatan,
				'jenis_pembayaran' => 'Tunai'
			);
			return $simpanan;
		}
		
		public function createDataPengguna($id_anggota){
			$pengguna = array(
				'username' => $id_anggota,
				'password' => md5($id_anggota),
				'id_level' => "LVL-02",
				'status' => 1
			);
			return $pengguna;
		}
		
		public function createDataJurnal($data, $jumlah_simpanan){
			//Simpanan Pokok 2201
			$id_jurnal = '';
			$tanggal_transaksi = $data['tanggal_pembuatan'];
			if($this->model_jurnal->getID($tanggal_transaksi)->num_rows()>0){
				$id_jurnal = "JNL-".str_replace('-','',$tanggal_transaksi).$this->model_jurnal->getID($tanggal_transaksi)->result()[0]->id_jurnal;
			}else{
				$id_jurnal = "JNL-".str_replace('-','',$tanggal_transaksi)."0001";
			}
			$jurnal = array(
				'id_jurnal' => $id_jurnal,
				'id_anggota' => '',
				'tanggal_transaksi' => $tanggal_transaksi,
				'keterangan' => '',
				'deskripsi' => '',
				'posisi' =>'',
				'jumlah' => $jumlah_simpanan,
				'no_ref' => ''
			);
			return $jurnal;
		}
		
		public function simpananPokok($jurnal, $data, $posisi){
			$jurnal['deskripsi'] = 'Simpanan Pokok '.$data['id_anggota'];
			$jurnal['posisi'] = $posisi;
			$jurnal['no_ref'] = 2201;
			return $jurnal;
		}
		
		public function kas($jurnal, $data, $posisi){
			$jurnal['deskripsi'] = 'Kas '.$data['id_anggota'];
			$jurnal['posisi'] = $posisi;
			$jurnal['no_ref'] = 1101;
			return $jurnal;
		}
		
		public function getJSON(){
			$data = array();
			if($query = $this->model_anggota->getData()){
				$data["anggota"] = $query;
			}
			if($query = $this->model_jenis_simpanan->getData()){
				$data["jenis_simpanan"] = $query;
			}
			if($query = $this->model_jenis_pinjaman->getData()){
				$data["jenis_pinjaman"] = $query;
			}
			if($query = $this->model_jenis_angsuran->getData()){
				$data["jenis_angsuran"] = $query;
			}
			if($query = $this->model_simpanan->getData()){
				$data["simpanan"] = $query;
			}
			header("content-type: application/json"); 
			echo json_encode($data);
			exit;
		}
	}
?>