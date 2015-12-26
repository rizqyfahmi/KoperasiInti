<?php
	class Jurnal extends CI_Controller{
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
				$this->load->view("view_jurnal", $data);
			}
		}
		
		public function getDataByMonthYear(){
			$bulan = $this->input->post('bulan');
			$tahun = $this->input->post('tahun');
			$data = array();
			$data['records'] = null;
			//$this->model_jurnal->getDataBukuBesar();
			if($query = $this->model_jurnal->getDataByMonthYear($bulan, $tahun)){
				$data['records'] = $query;
			}
			$this->load->view("view_jurnal_by_month.php", $data);
		}
	}
?>