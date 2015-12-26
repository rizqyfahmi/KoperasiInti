<?php
	class model_jenis_pinjaman extends CI_Model{
		public function setData($data){
			$this->db->insert('jenis_pinjaman', $data);
		}
		
		public function getData(){
			$query = $this->db->get('jenis_pinjaman');
			return $query->result();
		}		
		
		public function getID(){
			$query = $this->db->query('select CONCAT(REPEAT("0",LENGTH(SUBSTRING_INDEX(id_jenis_pinjaman, "-", -1)) - LENGTH(SUBSTRING_INDEX(id_jenis_pinjaman, "-", -1)+1 )), SUBSTRING_INDEX(id_jenis_pinjaman, "-", -1)+1) as "id_jenis_pinjaman" from jenis_pinjaman order by id_jenis_pinjaman desc');
			return $query;
		}	
		
		public function updateData($id, $data){
			$this->db->where('id_jenis_pinjaman', $id);
			$this->db->update('jenis_pinjaman', $data);
		}
		
		public function removeData($id){
			$this->db->where('id_jenis_pinjaman', $id);
			$this->db->delete('jenis_pinjaman');
		}
	}
?>