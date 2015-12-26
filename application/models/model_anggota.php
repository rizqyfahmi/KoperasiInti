<?php
	class model_anggota extends CI_Model{
		public function setData($data){
			$this->db->insert('anggota', $data);
		}
		
		public function getData(){
			$this->db->select('anggota.*, jenis_anggota.*')
					 ->from('anggota')
					 ->join('jenis_anggota', 'anggota.id_jenis_anggota = jenis_anggota.id_jenis_anggota')
					 ->order_by("anggota.id_anggota", "asc"); 
			$query = $this->db->get();
			return $query->result();
		}
		
		public function getDataWithoutAdmin(){
			$this->db->select('anggota.*, jenis_anggota.*')
					 ->from('anggota')
					 ->join('jenis_anggota', 'anggota.id_jenis_anggota = jenis_anggota.id_jenis_anggota')
					 ->where('anggota.id_anggota !=', 'adm')
					 ->order_by("anggota.id_anggota", "asc"); 
			$query = $this->db->get();
			return $query->result();
		}

		public function getID(){
			$query = $this->db->query('select CONCAT(REPEAT("0",LENGTH(SUBSTRING_INDEX(id_anggota, "-", -1)) - LENGTH(SUBSTRING_INDEX(id_anggota, "-", -1)+1 )), SUBSTRING_INDEX(id_anggota, "-", -1)+1) as "id_anggota" from anggota where SUBSTRING_INDEX(id_anggota, "-", 1) !="ADM" order by id_anggota desc');
			return $query;
		}	
		
		public function getDataById($id){
			$this->db->select('anggota.*, jenis_anggota.*, pengguna.*, jenis_simpanan.*')
					 ->from('anggota')
					 ->join('jenis_anggota', 'anggota.id_jenis_anggota = jenis_anggota.id_jenis_anggota')
					 ->join('jenis_simpanan', 'jenis_anggota.id_jenis_simpanan = jenis_simpanan.id_jenis_simpanan')
					 ->join('pengguna', 'anggota.id_anggota = pengguna.username')
					 ->where('id_anggota', $id)
					 ->order_by("anggota.id_anggota", "asc"); 
			$query = $this->db->get();
			return $query->result();
		}
		
		public function getDataByIdAnggota($id){
			$this->db->select('*')
					 ->from('anggota')
					 ->where('id_anggota', $id);
			$query = $this->db->get();
			return $query->result();
		}
		
		public function updateData($id, $data){
			$this->db->where('id_anggota', $id);
			$this->db->update('anggota', $data);
		}
		
		public function removeData($id){
			$this->db->where('id_anggota', $id);
			$this->db->delete('anggota');
		}
	}
?>