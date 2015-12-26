<?php
	class Angsuran extends CI_Controller{
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
					if($query = $this->model_pinjaman->getDataGroupBy()){
						$data['records'] = $query;
					}
					$this->load->view("view_angsuran", $data);
				}else if($pengguna->id_level == "LVL-02"){
					if($query = $this->model_angsuran->getDataById($pengguna->id_anggota)){
						$data['records'] = $query;
					}
					$this->load->view("view_angsuran_anggota", $data);
				}
				
			}
		}
		
		public function createData(){
			$aksi = $this->input->post('aksi');
			$id_angsuran = '';
			$tanggal_pembuatan = $this->input->post('tanggal_pembuatan');
			if($this->model_angsuran->getID($tanggal_pembuatan)->num_rows()>0){
				$id_angsuran = "ANS-".str_replace('-','',$tanggal_pembuatan).$this->model_angsuran->getID($tanggal_pembuatan)->result()[0]->id_angsuran;
			}else{
				$id_angsuran = "ANS-".str_replace('-','',$tanggal_pembuatan)."0001";
			}
			$data = array(
				'id_angsuran' => $id_angsuran,
				'id_pinjaman' => $this->input->post('id_pinjaman'),
				'id_anggota' => $this->input->post('id_anggota'),
				'tanggal_pembuatan' => $this->input->post('tanggal_pembuatan'),
				'sisa_pembayaran' => 0,
			);
			$row = $this->model_pinjaman->getDataByIdPinjaman($data['id_pinjaman']);
			$data['sisa_pembayaran'] = $row->jumlah_angsuran - (1+$this->model_angsuran->getTerbayar($data['id_pinjaman']));
			$this->model_angsuran->setData($data);
			if($data['sisa_pembayaran']==0){
				$pinjaman = $this->model_pinjaman->getOnlyPinjamanByIdPinjaman($data['id_pinjaman']);
				$pinjaman->status_pembayaran = 1;
				$this->model_pinjaman->updateData($pinjaman->id_pinjaman, $pinjaman);
			}	
			$id_jenis_pinjaman = $row->id_jenis_pinjaman;
			if($id_jenis_pinjaman=='JPIN-01'){//Pinjaman Koperasi
				$this->pinjamanKoperasi($data);
			}else if($id_jenis_pinjaman=='JPIN-02'){//Pinjaman Bank
				$this->pinjamanBank($data);
			}
			//echo base_url().'Pinjaman/detailPinjaman?id_anggota='.$this->input->post('id_anggota');
			redirect(base_url().'Pinjaman/detailPinjaman?id_anggota='.$this->input->post('id_anggota'));
		}
		
		public function deleteData(){
			$id = $this->uri->segment(3);
			$this->model_jenis_pinjaman->removeData($id);
			redirect(base_url().'Angsuran/');
		}
		
		public function pinjamanKoperasi($data){
			$query = $this->model_pinjaman->getDataById($data['id_pinjaman']);
			$jurnal = $this->createDataJurnal($data, 0);
			$jurnal['id_anggota'] = $data['id_anggota']; 
			$jurnal['keterangan'] = $data['id_angsuran'];
			//KAS BANK
			$jurnal['jumlah'] = $query[0]->angsuran_pokok + $query[0]->angsuran_bunga;
			$kasBank = $this->kasBank($jurnal, $data, 'Debit');
			$this->model_jurnal->setData($kasBank);
			
			//PIUTANG REGULER
			$jurnal['jumlah'] = $query[0]->angsuran_pokok;
			$piutangReguler = $this->piutangReguler($jurnal, $data, 'Kredit');
			$this->model_jurnal->setData($piutangReguler);
			
			//HASIL PENJUALAN BUNGA BANK
			$jurnal['jumlah'] = $query[0]->angsuran_bunga;
			$hasilPenjualanBungaBank = $this->hasilPenjualanBungaBank($jurnal, $data, 'Kredit');
			$this->model_jurnal->setData($hasilPenjualanBungaBank);
			
			//UTANG BANK
			$jurnal['jumlah'] = $query[0]->angsuran_pokok;
			$utangBank = $this->utangBank($jurnal, $data, 'Debit');
			$this->model_jurnal->setData($utangBank);
			
			//UTANG BUNGA BANK
			$jurnal['jumlah'] = $jurnal['jumlah'] = $query[0]->angsuran_bunga;
			$utangBungaBank = $this->utangBungaBank($jurnal, $data, 'Debit');
			$this->model_jurnal->setData($utangBungaBank);
			
			//KAS BANK
			$jurnal['jumlah'] = $query[0]->angsuran_pokok + $query[0]->angsuran_bunga;
			$kasBank = $this->kasBank($jurnal, $data, 'Kredit');
			$this->model_jurnal->setData($kasBank);
			
			//HPP BANK
			$jurnal['jumlah'] = $query[0]->nominal_pinjaman;
			$hppBank = $this->hppBank($jurnal, $data, 'Debit');
			$this->model_jurnal->setData($hppBank);
			
			//BEBAN DITANGGUHKAN
			$jurnal['jumlah'] = $query[0]->nominal_pinjaman;
			$bebanDiTangguhkan = $this->bebanDiTangguhkan($jurnal, $data, 'Kredit');
			$this->model_jurnal->setData($bebanDiTangguhkan);
		}
		
		public function pinjamanBank($data){
			$query = $this->model_pinjaman->getDataById($data['id_pinjaman']);
			$jurnal = $this->createDataJurnal($data, 0);
			$jurnal['id_anggota'] = $data['id_anggota']; 
			$jurnal['keterangan'] = $data['id_angsuran']; 
			//KAS BANK
			$jurnal['jumlah'] = $query[0]->angsuran_pokok + $query[0]->angsuran_bunga;
			$kasBank = $this->kasBank($jurnal, $data, 'Debit');
			$this->model_jurnal->setData($kasBank);
			
			//PIUTANG POKOK
			$jurnal['jumlah'] = $query[0]->angsuran_pokok;
			$piutangPokok = $this->piutangPokok($jurnal, $data, 'Kredit');
			$this->model_jurnal->setData($piutangPokok);
			
			//PIUTANG BUNGA BANK
			$jurnal['jumlah'] =  $query[0]->angsuran_bunga;
			$piutangBungaBank = $this->piutangBungaBank($jurnal, $data, 'Kredit');
			$this->model_jurnal->setData($piutangBungaBank);
			
			//PIUTANG BUNGA BANK
			$jurnal['jumlah'] =  $query[0]->angsuran_bunga;
			$piutangBungaBank = $this->piutangBungaBank($jurnal, $data, 'Debit');
			$this->model_jurnal->setData($piutangBungaBank);
			
			//PENDAPATAN DITANGGUHKAN
			$jurnal['jumlah'] = $query[0]->angsuran_bunga;
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
		
		public function hasilPenjualanBungaBank($jurnal, $data, $posisi){
			$jurnal['deskripsi'] = 'Hasil Penjualan Bunga Bank '.$data['id_anggota'];
			$jurnal['posisi'] = $posisi;
			$jurnal['no_ref'] = 4101;
			return $jurnal;
		}
		
		public function hppBank($jurnal, $data, $posisi){
			$jurnal['deskripsi'] = 'HPP Bank '.$data['id_anggota'];
			$jurnal['posisi'] = $posisi;
			$jurnal['no_ref'] = 5101;
			return $jurnal;
		}
	}
?>