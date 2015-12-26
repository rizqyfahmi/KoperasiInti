<?php
	class Pengguna extends CI_Controller{
		public function __contruct(){
			parent::__contruct();
		}
		
		public function index(){
			if($this->session->userdata('pengguna')==NULL){
				redirect(base_url());
			}else{
				$data = array();
				if($query = $this->model_pengguna->getData()){
					$data['records'] = $query;
				}
				$this->load->view("view_pengguna", $data);
			}
		}
		
		public function createData(){
			$aksi = $this->input->post('aksi');
			$data = array(
				'id_pengguna' => $this->input->post('id_pengguna'),
				'detail' => $this->input->post('detail')				
			);
			if($aksi=="Simpan"){
				$this->model_pengguna->setData($data);
			}else{
				$this->model_pengguna->updateData($this->input->post('id_pengguna'), $data);
			}
			
			redirect(base_url().'Level/');
		}
		
		public function deleteData(){
			$id = $this->uri->segment(3);
			$this->model_pengguna->removeData($id);
			redirect(base_url().'Level/');
		}
	}
?>