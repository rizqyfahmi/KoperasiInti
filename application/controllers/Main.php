<?php
	class Main extends CI_Controller{
		public function __contruct(){
			parent::__contruct();
		}
		
		public function index(){
			if($this->session->userdata('pengguna')==NULL){
				$this->load->view("view_login");
			}else{
				$this->load->view("view_main");
			}
		}
		
		public function validate(){
			$msg = 0;
			if($query = $this->model_pengguna->getDataById($this->input->post('username'))){
				
				if(md5($this->input->post('password')) === $query[0]->password){
					$data = $this->model_anggota->getDataById($query[0]->username);
					$this->session->set_userdata('pengguna', $data[0]);
					$msg = 1;
				}
				
				//redirect(base_url());
			}
			echo $msg;
		}
		
		public function logout(){
			$this->session->unset_userdata('pengguna');
			redirect(base_url());
		}
	}
?>