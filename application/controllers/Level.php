<?php
	class Level extends CI_Controller{
		public function __contruct(){
			parent::__contruct();
		}
		
		public function index(){
			if($this->session->userdata('pengguna')==NULL){
				redirect(base_url());
			}else{
				$data = array();
				if($query = $this->model_level->getData()){
					$data['records'] = $query;
				}
				$this->load->view("view_level", $data);
			}
			
		}
		
		public function createData(){
			$aksi = $this->input->post('aksi');
			$data = array(
				'id_level' => $this->input->post('id_level'),
				'detail' => $this->input->post('detail')				
			);
			if($aksi=="Simpan"){
				$id_level = "LVL-01";
				if($this->model_level->getID()->num_rows()>0){
					$id_level = "LVL-".$this->model_level->getID()->result()[0]->id_level;
				}
				$data['id_level'] = $id_level;
				$this->model_level->setData($data);
			}else{
				$this->model_level->updateData($this->input->post('id_level'), $data);
			}
			
			redirect(base_url().'Level/');
		}
		
		public function deleteData(){
			$id = $this->uri->segment(3);
			$this->model_level->removeData($id);
			redirect(base_url().'Level/');
		}
	}
?>