<?php
	class model_pengguna extends CI_Model{
		public function setData($data){
			$this->db->insert('pengguna', $data);
		}
		
		public function getData(){
			$this->db->select('pengguna.*, anggota.*, level.*')
					 ->from('pengguna')
					 ->join('anggota', 'pengguna.username = anggota.id_anggota')
					 ->join('level', 'pengguna.id_level = level.id_level');
			$query = $this->db->get();
			return $query->result();
		}		
		
		public function getDataById($id){
			$this->db->where('username', $id);
			$query = $this->db->get('pengguna');
			return $query->result();
		}
		
		public function updateData($id, $data){
			$this->db->where('id_pengguna', $id);
			$this->db->update('pengguna', $data);
		}
		
		public function removeData($id){
			$this->db->where('id_pengguna', $id);
			$this->db->delete('pengguna');
		}
	}
?>