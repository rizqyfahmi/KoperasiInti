<?php
	class Profil extends CI_Controller{
		public function __contruct(){
			parent::__contruct();
		}
		
		public function index(){
			if($this->session->userdata('pengguna')==NULL){
				$this->load->view("view_login");
			}else{
				$pengguna = $this->session->userdata('pengguna');
				$data = array();
				$data['anggota'] = $this->model_anggota->getDataById($pengguna->id_anggota)[0];
				$this->load->view("view_profil", $data);
			}
		}
		
		public function updateData(){
			$pengguna = $this->session->userdata('pengguna');
			$data = $this->model_anggota->getDataByIdAnggota($pengguna->id_anggota)[0];
			$data->nama = $this->input->post('nama');
			$data->alamat = $this->input->post('alamat');
			
			$data = $this->uploadFile($data);
			$this->model_anggota->updateData($pengguna->id_anggota, $data);
			redirect(base_url().'Profil/');
		}
		
		public function updatePassword(){
			$pengguna = $this->session->userdata('pengguna');
			$data = $this->model_pengguna->getDataById($pengguna->id_anggota)[0];
			$data->password = md5($this->input->post('password'));
			redirect(base_url().'Profil/');
		}
		
		public function uploadFile($data){
			$config['upload_path'] 	 = 'assets/images/';
			$config['allowed_types'] = 'jpg';
			$config['file_name']     = $data->id_anggota.'.jpg';
			$config['overwrite']     = true;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->set_allowed_types('*');
			if($this->upload->do_upload('foto')){
				$data->foto = 'assets/images/'.$data->id_anggota.'.jpg';
			}
			return $data;
		}
	}
?>