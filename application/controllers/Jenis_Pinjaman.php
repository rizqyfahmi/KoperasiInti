<?php
	class Jenis_Pinjaman extends CI_Controller{
		public function __contruct(){
			parent::__contruct();
		}
		
		public function index(){
			if($this->session->userdata('pengguna')==NULL){
				redirect(base_url());
			}else{
				$data = array();
				if($query = $this->model_jenis_pinjaman->getData()){
					$data['records'] = $query;
				}
				$this->load->view("view_jenis_pinjaman", $data);
			}
		}
		
		public function createData(){
			$aksi = $this->input->post('aksi');
			$data = array(
				'id_jenis_pinjaman' => $this->input->post('id_jenis_pinjaman'),
				'detail' => $this->input->post('detail'),
				'jumlah_pinjaman' => $this->input->post('jumlah_pinjaman')
			);
			if($aksi=="Simpan"){
				$id_jenis_pinjaman = "JPIN-01";
				if($this->model_jenis_pinjaman->getID()->num_rows()>0){
					$id_jenis_pinjaman = "JPIN-".$this->model_jenis_pinjaman->getID()->result()[0]->id_jenis_pinjaman;
				}
				$data['id_jenis_pinjaman'] = $id_jenis_pinjaman;
				$this->model_jenis_pinjaman->setData($data);
			}else{
				$this->model_jenis_pinjaman->updateData($this->input->post('id_jenis_pinjaman'), $data);
			}
			redirect(base_url().'Jenis_Pinjaman/');
		}
		
		public function deleteData(){
			$id = $this->uri->segment(3);
			$this->model_jenis_pinjaman->removeData($id);
			redirect(base_url().'Jenis_Pinjaman/');
		}
	}
?>