<?php
	class Jenis_Anggota extends CI_Controller{
		public function __contruct(){
			parent::__contruct();
		}
		
		public function index(){
			if($this->session->userdata('pengguna')==NULL){
				redirect(base_url());
			}else{
				$data = array();
				if($query = $this->model_jenis_anggota->getData()){
					$data['records'] = $query;
				}
				if($query = $this->model_jenis_simpanan->getData()){
					$data['jenis_simpanan'] = $query;
				}
				$this->load->view("view_jenis_anggota", $data);
			}			
		}
		
		public function createData(){
			$aksi = $this->input->post('aksi');
			$data = array(
				'id_jenis_anggota' => $this->input->post('id_jenis_anggota'),
				'jabatan' => $this->input->post('jabatan'),
				'id_jenis_simpanan' => $this->input->post('id_jenis_simpanan'),
				'jumlah_simpanan' => $this->input->post('jumlah_simpanan')
			);
			if($aksi=="Simpan"){
				$id_jenis_anggota = "JANG-01";
				if($this->model_jenis_anggota->getID()->num_rows()>0){
					$id_jenis_anggota = "JANG-".$this->model_jenis_anggota->getID()->result()[0]->id_jenis_anggota;
				}
				$data['id_jenis_anggota'] = $id_jenis_anggota;
				$this->model_jenis_anggota->setData($data);
			}else{
				$this->model_jenis_anggota->updateData($this->input->post('id_jenis_anggota'), $data);
			}
			
			redirect(base_url().'Jenis_Anggota/');
		}
		
		public function deleteData(){
			$id = $this->uri->segment(3);
			$this->model_jenis_anggota->removeData($id);
			redirect(base_url().'Jenis_Anggota/');
		}
	}
?>