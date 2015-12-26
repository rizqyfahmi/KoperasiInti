<?php
	class Simpanan extends CI_Controller{
		public function __contruct(){
			parent::__contruct();
		}
		
		public function index(){
			$pengguna = $this->session->userdata('pengguna');
			if($this->session->userdata('pengguna')==NULL){
				redirect(base_url());
			}else{
				$data = array();
				$data['records'] = null;
				$data['penarikan'] = null;
			    if($pengguna->id_level == "LVL-01"){
					$data['records'] = $this->model_simpanan->getData();
					$data['penarikan'] = $this->model_penarikan->getData();
					$data['jenis_simpanan'] = $this->model_jenis_simpanan->getDataWithoutSimpananPokok();
					$this->load->view("view_simpanan", $data);
				}else if($pengguna->id_level == "LVL-02"){
					$data = array();
					if($query = $this->model_simpanan->getDataById($pengguna->id_anggota)){
						$data['records'] = $query;
					}
					if($query = $this->model_anggota->getDataById($pengguna->id_anggota)){
						$data['anggota'] = $query;
					}
					if($query = $this->model_jenis_simpanan->getData()){
						$data['jenis_simpanan'] = $query;
					}
					$data['penarikan'] = 0;
					if($query = $this->model_penarikan->getDataByIdAnggota($pengguna->id_anggota)){
						$data['penarikan'] = $query[0]->jumlah_penarikan;
					}
					$data['history_simpanan'] = $this->model_simpanan->getDataByIdNonSum($pengguna->id_anggota);
					$data['history_penarikan'] = $this->model_penarikan->getDataByIdAnggota2($pengguna->id_anggota);
					$this->load->view("view_simpanan_anggota", $data);
				}
			}
		}
		
		public function createData(){
			$aksi = $this->input->post('aksi');
			$data = $this->createDataSimpanan();
			$this->model_simpanan->setData($data);
			
			$jurnal = $this->createDataJurnal($data, $data['jumlah_simpanan']);
			$jurnal['id_anggota'] = $data['id_anggota']; 
			$jurnal['keterangan'] = $data['id_simpanan']; 
			if($data['id_jenis_simpanan']=="JSMP-01"){
				$kas = $this->kas($jurnal, $data, 'Debit');
				$this->model_jurnal->setData($kas);
				$simpananPokok = $this->simpananPokok($jurnal, $data, 'Kredit');
				$this->model_jurnal->setData($simpananPokok);
			}else if($data['id_jenis_simpanan']=="JSMP-02"){
				$kasBank = $this->kasBank($jurnal, $data, 'Debit');
				$this->model_jurnal->setData($kasBank);
				$simpananWajib = $this->simpananWajib($jurnal, $data, 'Kredit');
				$this->model_jurnal->setData($simpananWajib);
			}else if($data['id_jenis_simpanan']=="JSMP-03"){
				$kas = $this->kas($jurnal, $data, 'Debit');
				$this->model_jurnal->setData($kas);
				$simpananSukarela = $this->simpananSukarela($jurnal, $data, 'Kredit');
				$this->model_jurnal->setData($simpananSukarela);
			}
			redirect(base_url().'Simpanan/');
		}
		
		public function createDataSimpanan(){
			$id_simpanan = '';
			$tanggal_pembuatan = $this->input->post('tanggal_pembuatan');
			if($this->model_simpanan->getID($tanggal_pembuatan)->num_rows()>0){
				$id_simpanan = "SMP-".str_replace('-','',$tanggal_pembuatan).$this->model_simpanan->getID($tanggal_pembuatan)->result()[0]->id_simpanan;
			}else{
				$id_simpanan = "SMP-".str_replace('-','',$tanggal_pembuatan)."0001";
			}
			$query = $this->model_anggota->getDataById($this->input->post('id_anggota'));
			$data = array(
				'id_simpanan' => $id_simpanan,
				'id_anggota' => $this->input->post('id_anggota'),
				'id_jenis_anggota' => $query[0]->id_jenis_anggota,
				'id_jenis_simpanan' => $this->input->post('id_jenis_simpanan'),
				'jumlah_simpanan' => $this->input->post('jumlah_simpanan'),
				'tanggal_pembuatan' => $tanggal_pembuatan,
				'jenis_pembayaran' => ""
			);
			if($data['id_jenis_simpanan']=="JSMP-01"){
				$data['jenis_pembayaran'] = "Tunai";
			}else if($data['id_jenis_simpanan']=="JSMP-02"){
				$data['jenis_pembayaran'] = "Potong Gaji";
			}else if($data['id_jenis_simpanan']=="JSMP-03"){
				$data['jenis_pembayaran'] = "Tunai";
			}
			return $data;
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
		
		public function simpananWajib($jurnal, $data, $posisi){
			$jurnal['deskripsi'] = 'Simpanan Wajib '.$data['id_anggota'];
			$jurnal['posisi'] = $posisi;
			$jurnal['no_ref'] = 2202;
			return $jurnal;
		}
		
		public function simpananSukarela($jurnal, $data, $posisi){
			$jurnal['deskripsi'] = 'Simpanan Sukarela '.$data['id_anggota'];
			$jurnal['posisi'] = $posisi;
			$jurnal['no_ref'] = 2203;
			return $jurnal;
		}
		
		public function kas($jurnal, $data, $posisi){
			$jurnal['deskripsi'] = 'Kas '.$data['id_anggota'];
			$jurnal['posisi'] = $posisi;
			$jurnal['no_ref'] = 1101;
			return $jurnal;
		}
		
		public function kasBank($jurnal, $data, $posisi){
			$jurnal['deskripsi'] = 'Kas Bank '.$data['id_anggota'];
			$jurnal['posisi'] = $posisi;
			$jurnal['no_ref'] = 1201;
			return $jurnal;
		}
		
		public function penarikan(){
			$data = $this->createDataPenarikan();
			$this->model_penarikan->setData($data);
			
			$jurnal = $this->createDataJurnal($data, $data['jumlah_penarikan']);
			$jurnal['id_anggota'] = $data['id_anggota'];
			$jurnal['keterangan'] = $data['id_penarikan'];
			$simpananWajib = $this->simpananWajib($jurnal, $data, 'Debit');
			$this->model_jurnal->setData($simpananWajib);
			$kasBank = $this->kasBank($jurnal, $data, 'Kredit');
			$this->model_jurnal->setData($kasBank);
			redirect(base_url().'Simpanan/detailSimpanan/'.$data['id_anggota']);
		}
		
		public function createDataPenarikan(){
			$id_penarikan = '';
			$tanggal_pembuatan = $this->input->post('tanggal_pembuatan');
			if($this->model_penarikan->getID($tanggal_pembuatan)->num_rows()>0){
				$id_penarikan = "PNK-".str_replace('-','',$tanggal_pembuatan).$this->model_penarikan->getID($tanggal_pembuatan)->result()[0]->id_penarikan;
			}else{
				$id_penarikan = "PNK-".str_replace('-','',$tanggal_pembuatan)."0001";
			}
			
			$data = array(
				'id_penarikan' => $id_penarikan,
				'id_anggota' => $this->input->post('id_anggota'),
				'jumlah_penarikan' => $this->input->post('jumlah_penarikan'),
				'tanggal_pembuatan' => $tanggal_pembuatan
			);
			return $data;
		}
		
		public function deleteData(){
			$id = $this->uri->segment(3);
			$this->model_simpanan->removeData($id);
			redirect(base_url().'Simpanan/');
		}
		
		public function getJSON(){
			if($query = $this->model_simpanan->getDataAll()){
				header("content-type: application/json"); 
				echo json_encode($query);
				exit;
			}
		}
		
		public function detailSimpanan(){
			$data = array();
			$id = $this->uri->segment(3);
			if($query = $this->model_simpanan->getDataById($id)){
				$data['records'] = $query;
			}
			if($query = $this->model_anggota->getDataById($id)){
				$data['anggota'] = $query;
			}
			if($query = $this->model_jenis_simpanan->getData()){
				$data['jenis_simpanan'] = $query;
			}
			$data['history_simpanan'] = $this->model_simpanan->getDataByIdNonSum($id);
			$data['history_penarikan'] = $this->model_penarikan->getDataByIdAnggota2($id);
			$data['penarikan'] = 0;
			if($query = $this->model_penarikan->getDataByIdAnggota($id)){
				$data['penarikan'] = $query[0]->jumlah_penarikan;
			}
			$this->load->view("view_simpanan_detail", $data);
		}
		
	}
?>