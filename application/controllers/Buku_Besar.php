<?php
	class Buku_Besar extends CI_Controller{
		public function __contruct(){
			parent::__contruct();
		}
		
		public function index(){
			if($this->session->userdata('pengguna')==NULL){
				redirect(base_url());
			}else{
				$data = array();
				$data['records'] = null;
				$data['records'] = $this->model_jurnal->getMaxYear()->result()[0]->tahun;
				$data['coa'] = $this->model_coa->getData();
				//$data['buku_besar'] =  $this->model_jurnal->getDataBukuBesar();
				$this->load->view("view_buku_besar", $data);
			}
		}
		
		public function detail(){
			$no_ref = $this->input->post('no_referensi');
			$bulan = $this->input->post('bulan');
			$tahun = $this->input->post('tahun');
			
			$data = array();
			$data['coa'] = $this->model_coa->getDataById($no_ref)[0];
			$bb = $data['coa']->detail;
			$bb = str_replace(' ','_',$bb);
			$bb = strtolower($bb);
			$bb ='bb_'.$bb;
			$data['records'] = $this->model_buku_besar->getBukuBesar($bb, $bulan, $tahun)->result();
			
			$data['saldo_awal'] = array(
				'saldo_awal' => 0,
				'tanggal' => '-',
				'no_ref' => '-'
			);
			if($this->model_buku_besar->getBukuBesar($bb, $bulan, $tahun)->num_rows()>0){
				$data['saldo_awal']['saldo_awal'] = $this->model_buku_besar->getSaldoAwal($bb, $bulan, $tahun)->saldo_awal;
				$data['saldo_awal']['tanggal'] = $this->model_buku_besar->getSaldoAwal($bb, $bulan, $tahun)->tanggal;
				$data['saldo_awal']['no_ref'] = $this->model_buku_besar->getSaldoAwal($bb, $bulan, $tahun)->no_ref;
			}
			
			
			if(($no_ref!='6101') && ($no_ref!='4102') && ($no_ref!='4101')){
				$this->load->view("view_buku_besar_detail", $data);
			}else{
				$this->load->view("view_buku_besar_detail_non", $data);
			}
		}
	}
?>