<?php
	class Pinjaman extends CI_Controller{
		public function __contruct(){
			parent::__contruct();
		}
		
		public function index(){
			$pengguna = $this->session->userdata('pengguna');
			if($pengguna==NULL){
				redirect(base_url());
			}else{
				$data = array();
				$data['records'] = null;
			    if($pengguna->id_level == "LVL-01"){
					if($query = $this->model_anggota->getData()){
						$data['anggota'] = $query;
					}
					if($query = $this->model_pinjaman->getAccepted()){
						$data['records'] = $query;
					}
					$this->load->view("view_pinjaman", $data);
				}else if($pengguna->id_level == "LVL-02"){
					$data['records'] = $query = $this->model_pinjaman->getDataByIdAnggota($pengguna->username);
					$this->load->view("view_pinjaman_anggota", $data);
				}
				//$this->load->view("view_pinjaman", $data);
			}
		}
		
		public function createData(){
			$tanggal_pembuatan = date("Y-m-d");
			$id_pinjaman = '';
			if($this->model_pinjaman->getID($tanggal_pembuatan)->num_rows()>0){
				$id_pinjaman = "PIN-".str_replace('-','',$tanggal_pembuatan).$this->model_pinjaman->getID($tanggal_pembuatan)->result()[0]->id_pinjaman;
			}else{
				$id_pinjaman = "PIN-".str_replace('-','',$tanggal_pembuatan)."0001";
			}
			$data = array(
				'id_pinjaman' => $id_pinjaman,
				'id_anggota' => $this->input->post('id_anggota'),
				'id_jenis_pinjaman' => $this->input->post('id_jenis_pinjaman'),
				'id_jenis_angsuran' => $this->input->post('id_jenis_angsuran'),
				'nominal_pinjaman' => $this->input->post('nominal_pinjaman'),
				'angsuran_pokok' => $this->input->post('angsuran_pokok'),
				'angsuran_bunga' => $this->input->post('angsuran_bunga'),
				'acc' => $this->input->post('acc'),
				'status_pembayaran' => $this->input->post('status_pembayaran'),
				'tanggal_pembuatan' =>$tanggal_pembuatan
			);
			$this->model_pinjaman->setData($data);
				
			redirect(base_url().'Pinjaman/');
		}
		
		public function detailPinjaman(){
			$data = array();
			$data['id_anggota'] = null;
			$data['id_anggota'] = $this->input->get('id_anggota');
			$data['records'] = null;
			$data['records'] = $this->model_pinjaman->getDataByIdAnggotaWithoutRegret($data['id_anggota']);
			$data['totalAngsuran'] = $this->getTotalAngsuran();
			$data['anggota'] = $this->model_anggota->getDataById($this->input->get('id_anggota'))[0];
			$data['takeHomePay'] = $this->getTakeHomePay($this->getTotalAngsuran());
			$this->load->view("view_pinjaman_detail", $data);
		}
		
		public function getTotalAngsuran(){
			$id_anggota = $this->input->get('id_anggota');
			$takeHomePay = array();
			foreach($this->model_pinjaman->getAcceptedData($id_anggota) as $row){
				$part = $this->createDataDetailPinjaman($row->id_pinjaman, 'Pinjaman', $row->angsuran_pokok+$row->angsuran_bunga);
				array_push($takeHomePay, $part);
			}
			$row = $this->model_anggota->getDataById($id_anggota)[0];
			$part = $this->createDataDetailPinjaman($row->id_jenis_simpanan, 'Simpanan Wajib', $row->jumlah_simpanan);
			array_push($takeHomePay, $part);
			return $takeHomePay;
		}
		
		public function getTakeHomePay($totalAngsuran){
			$id_anggota = $this->input->get('id_anggota');
			$takeHomePay = $this->model_anggota->getDataById($id_anggota)[0]->gaji;
			foreach($totalAngsuran as $row){
				$takeHomePay -= $row['jumlah'];
			}
			return $takeHomePay;
		}
		
		public function createDataDetailPinjaman($id, $detail, $jumlah){
			$data = array(
				'id' => $id, 
				'detail' => $detail,
				'jumlah' => $jumlah 
			);
			return $data;
		}
		
		public function konfirmasiPinjaman(){
			$acc = $this->input->get('acc');
			$status_pembayaran = '';
			if($acc==1) $status_pembayaran = 0;
			$id_pinjaman = $this->input->get('id_pinjaman');
			$query = $this->model_pinjaman->getDataById($id_pinjaman);
			$data = array(
				'id_pinjaman' => $id_pinjaman,
				'id_anggota' => $query[0]->id_anggota,
				'id_jenis_pinjaman' => $query[0]->id_jenis_pinjaman,
				'id_jenis_angsuran' => $query[0]->id_jenis_angsuran,
				'nominal_pinjaman' => $query[0]->nominal_pinjaman,
				'angsuran_pokok' => $query[0]->angsuran_pokok,
				'angsuran_bunga' => $query[0]->angsuran_bunga,
				'acc' => $acc,
				'status_pembayaran' => $status_pembayaran,
				'tanggal_pembuatan' =>date("Y-m-d")
			);
			$this->model_pinjaman->updateData($id_pinjaman, $data);
			$id_jenis_pinjaman = $query[0]->id_jenis_pinjaman;
			if($id_jenis_pinjaman=='JPIN-01'){//Pinjaman Koperasi
				$this->pinjamanKoperasi($data);
			}else if($id_jenis_pinjaman=='JPIN-02'){//Pinjaman Bank
				$this->pinjamanBank($data);
			}
			redirect(base_url().'Pinjaman/');
		}
		
		public function deleteData(){
			$id = $this->uri->segment(3);
			$this->model_pinjaman->removeData($id);
			redirect(base_url().'Pinjaman/');
		}
		
		public function pinjamanKoperasi($data){
			$query = $this->model_pinjaman->getDataById($data['id_pinjaman']);
			$jurnal = $this->createDataJurnal($data, 0);
			$jurnal['id_anggota'] = $data['id_anggota']; 
			$jurnal['keterangan'] = $data['id_pinjaman']; 
			//KAS BANK
			$jurnal['jumlah'] = $query[0]->nominal_pinjaman;
			$kasBank = $this->kasBank($jurnal, $data, 'Debit');
			$this->model_jurnal->setData($kasBank);
			
			//UTANG BANK
			$jurnal['jumlah'] = $query[0]->nominal_pinjaman;
			$utangBank = $this->utangBank($jurnal, $data, 'Kredit');
			$this->model_jurnal->setData($utangBank);
			
			//BEBAN DITANGGUHKAN
			$jurnal['jumlah'] = $query[0]->angsuran_bunga * $query[0]->jumlah_angsuran;
			$bebanDiTangguhkan = $this->bebanDiTangguhkan($jurnal, $data, 'Debit');
			$this->model_jurnal->setData($bebanDiTangguhkan);
			
			//UTANG BUNGA BANK
			$jurnal['jumlah'] = $query[0]->angsuran_bunga * $query[0]->jumlah_angsuran;
			$utangBungaBank = $this->utangBungaBank($jurnal, $data, 'Kredit');
			$this->model_jurnal->setData($utangBungaBank);
			
			//PIUTANG REGULER
			$jurnal['jumlah'] = $query[0]->nominal_pinjaman;
			$piutangReguler = $this->piutangReguler($jurnal, $data, 'Debit');
			$this->model_jurnal->setData($piutangReguler);
			
			//KAS BANK
			$jurnal['jumlah'] = $query[0]->nominal_pinjaman;
			$kasBank = $this->kasBank($jurnal, $data, 'Kredit');
			$this->model_jurnal->setData($kasBank);
		}
		
		public function pinjamanBank($data){
			$query = $this->model_pinjaman->getDataById($data['id_pinjaman']);
			$jurnal = $this->createDataJurnal($data, 0);
			$jurnal['id_anggota'] = $data['id_anggota']; 
			$jurnal['keterangan'] = $data['id_pinjaman']; 
			//PIUTANG BANK
			$jurnal['jumlah'] = $query[0]->nominal_pinjaman;
			$piutangBank = $this->piutangBank($jurnal, $data, 'Debit');
			$this->model_jurnal->setData($piutangBank);
			//KAS BANK
			$jurnal['jumlah'] = $query[0]->nominal_pinjaman;
			$kasBank = $this->kasBank($jurnal, $data, 'Kredit');
			$this->model_jurnal->setData($kasBank);
			//PIUTANG BUNGA BANK
			$jurnal['jumlah'] = $query[0]->angsuran_bunga * $query[0]->jumlah_angsuran;
			$piutangBungaBank = $this->piutangBungaBank($jurnal, $data, 'Debit');
			$this->model_jurnal->setData($piutangBungaBank);
			//PENDAPATAN DITANGGUHKAN
			$jurnal['jumlah'] = $query[0]->angsuran_bunga * $query[0]->jumlah_angsuran;
			$pendapatanDitangguhkan = $this->pendapatanDitangguhkan($jurnal, $data, 'Kredit');
			$this->model_jurnal->setData($pendapatanDitangguhkan);
		}
		
		public function createDataJurnal($data, $jumlah){
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
				'jumlah' => $jumlah,
				'no_ref' => ''
			);
			return $jurnal;
		}
		
		public function kasBank($jurnal, $data, $posisi){
			$jurnal['deskripsi'] = 'Kas Bank '.$data['id_anggota'];
			$jurnal['posisi'] = $posisi;
			$jurnal['no_ref'] = 1201;
			return $jurnal;
		}
		
		public function utangBank($jurnal, $data, $posisi){
			$jurnal['deskripsi'] = 'Utang Bank '.$data['id_anggota'];
			$jurnal['posisi'] = $posisi;
			$jurnal['no_ref'] = 2204;
			return $jurnal;
		}
		
		public function bebanDiTangguhkan($jurnal, $data, $posisi){
			$jurnal['deskripsi'] = 'Beban Ditangguhkan '.$data['id_anggota'];
			$jurnal['posisi'] = $posisi;
			$jurnal['no_ref'] = 6101;
			return $jurnal;
		}
		
		public function utangBungaBank($jurnal, $data, $posisi){
			$jurnal['deskripsi'] = 'Utang Bunga Bank '.$data['id_anggota'];
			$jurnal['posisi'] = $posisi;
			$jurnal['no_ref'] = 2205;
			return $jurnal;
		}
		
		public function piutangReguler($jurnal, $data, $posisi){
			$jurnal['deskripsi'] = 'Piutang Reguler '.$data['id_anggota'];
			$jurnal['posisi'] = $posisi;
			$jurnal['no_ref'] = 1202;
			return $jurnal;
		}
		
		public function piutangBank($jurnal, $data, $posisi){
			$jurnal['deskripsi'] = 'Piutang Bank '.$data['id_anggota'];
			$jurnal['posisi'] = $posisi;
			$jurnal['no_ref'] = 1203;
			return $jurnal;
		}
		
		public function piutangBungaBank($jurnal, $data, $posisi){
			$jurnal['deskripsi'] = 'Piutang Bunga Bank '.$data['id_anggota'];
			$jurnal['posisi'] = $posisi;
			$jurnal['no_ref'] = 1204;
			return $jurnal;
		}
		
		public function piutangPokok($jurnal, $data, $posisi){
			$jurnal['deskripsi'] = 'Piutang Pokok '.$data['id_anggota'];
			$jurnal['posisi'] = $posisi;
			$jurnal['no_ref'] = 1205;
			return $jurnal;
		}
			
		public function pendapatanDitangguhkan($jurnal, $data, $posisi){
			$jurnal['deskripsi'] = 'Pendapatan Ditangguhkan '.$data['id_anggota'];
			$jurnal['posisi'] = $posisi;
			$jurnal['no_ref'] = 4102;
			return $jurnal;
		}
	}
?>