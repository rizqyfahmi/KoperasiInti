<?php
	class model_jenis_anggota extends CI_Model{
		public function setData($data){
			$this->db->insert('jenis_anggota', $data);
		}
		
		public function getData(){
			/*$query = $this->db->get('jenis_anggota');
			return $query->result();*/
			$this->db->select('jenis_anggota.*, jenis_simpanan.*, jenis_simpanan.detail as "jenis_simpanan"')
					 ->from('jenis_anggota')
					 ->join('jenis_simpanan', 'jenis_anggota.id_jenis_simpanan = jenis_simpanan.id_jenis_simpanan');
			$query = $this->db->get();
			return $query->result();
		}		
		
		public function getID(){
			$query = $this->db->query('select CONCAT(REPEAT("0",LENGTH(SUBSTRING_INDEX(id_jenis_anggota, "-", -1)) - LENGTH(SUBSTRING_INDEX(id_jenis_anggota, "-", -1)+1 )), SUBSTRING_INDEX(id_jenis_anggota, "-", -1)+1) as "id_jenis_anggota" from jenis_anggota order by id_jenis_anggota desc');
			return $query;
		}	
		
		public function updateData($id, $data){
			$this->db->where('id_jenis_anggota', $id);
			$this->db->update('jenis_anggota', $data);
		}
		
		public function removeData($id){
			$this->db->where('id_jenis_anggota', $id);
			$this->db->delete('jenis_anggota');
		}
	}
?>