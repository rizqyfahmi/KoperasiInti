<?php
	class model_level extends CI_Model{
		public function setData($data){
			$this->db->insert('level', $data);
		}
		
		public function getData(){
			$query = $this->db->get('level');
			return $query->result();
		}		
		
		public function getID(){
			$query = $this->db->query('select CONCAT(REPEAT("0",LENGTH(SUBSTRING_INDEX(id_level, "-", -1)) - LENGTH(SUBSTRING_INDEX(id_level, "-", -1)+1 )), SUBSTRING_INDEX(id_level, "-", -1)+1) as "id_level" from level order by id_level desc');
			return $query;
		}	
		
		public function updateData($id, $data){
			$this->db->where('id_level', $id);
			$this->db->update('level', $data);
		}
		
		public function removeData($id){
			$this->db->where('id_level', $id);
			$this->db->delete('level');
		}
	}
?>