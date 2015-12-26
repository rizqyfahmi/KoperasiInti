<?php
	class Jenis_Simpanan extends CI_Controller{
		public function __contruct(){
			parent::__contruct();
		}
		
		public function index(){
			if($this->session->userdata('pengguna')==NULL){
				redirect(base_url());
			}else{
				$data = array();
				if($query = $this->model_jenis_simpanan->getData()){
					$data['records'] = $query;
				}
				$this->load->view("view_jenis_simpanan", $data);
			}			
		}
		
		public function createData(){
			$aksi = $this->input->post('aksi');
			$data = array(
				'id_jenis_simpanan' => $this->input->post('id_jenis_simpanan'),
				'detail' => $this->input->post('detail'),
				'nominal' => $this->input->post('nominal')				
			);
			if($aksi=="Simpan"){
				$id_jenis_simpanan = "JSMP-01";
				if($this->model_simpanan->getID()->num_rows()>0){
					$id_jenis_simpanan = "JSMP-".$this->model_jenis_simpanan->getID()->result()[0]->id_jenis_simpanan;
				}
				$data['id_jenis_simpanan'] = $id_jenis_simpanan;
				$this->model_jenis_simpanan->setData($data);
			}else{
				$this->model_jenis_simpanan->updateData($this->input->post('id_jenis_simpanan'), $data);
			}
			redirect(base_url().'Jenis_Simpanan/');
		}
		
		public function deleteData(){
			$id = $this->uri->segment(3);
			$this->model_jenis_simpanan->removeData($id);
			redirect(base_url().'Jenis_Simpanan/');
		}
	}
?>