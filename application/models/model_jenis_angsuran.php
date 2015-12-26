<?php
	class model_jenis_angsuran extends CI_Model{
		public function setData($data){
			$this->db->insert('jenis_angsuran', $data);
		}
		
		public function getData(){
			$query = $this->db->get('jenis_angsuran');
			return $query->result();
		}		
		
		public function getID(){
			$query = $this->db->query('select CONCAT(REPEAT("0",LENGTH(SUBSTRING_INDEX(id_jenis_angsuran, "-", -1)) - LENGTH(SUBSTRING_INDEX(id_jenis_angsuran, "-", -1)+1 )), SUBSTRING_INDEX(id_jenis_angsuran, "-", -1)+1) as "id_jenis_angsuran" from jenis_angsuran order by id_jenis_angsuran desc');
			return $query;
		}	
		
		public function updateData($id, $data){
			$this->db->where('id_jenis_angsuran', $id);
			$this->db->update('jenis_angsuran', $data);
		}
		
		public function removeData($id){
			$this->db->where('id_jenis_angsuran', $id);
			$this->db->delete('jenis_angsuran');
		}
	}
?>