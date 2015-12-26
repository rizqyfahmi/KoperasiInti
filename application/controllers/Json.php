<?php
	class Json extends CI_Controller{
		public function __contruct(){
			parent::__contruct();
		}
		
		public function index(){
			$data = array();
			if($query = $this->model_anggota->getDataWithoutAdmin()){
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
			if($query = $this->model_simpanan->getDataWithoutSukarela()){
				$data["simpanan_non_sukarela"] = $query;
			}		
			if($query = $this->model_pinjaman->getData()){
				$data["pinjaman"] = $query;
			}
			if($query = $this->model_angsuran->getData()){
				$data["angsuran"] = $query;
			}
			header("content-type: application/json"); 
			echo json_encode($data);
			exit;
		}
	}
?>