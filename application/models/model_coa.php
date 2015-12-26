<?php
	class model_coa extends CI_Model{
		public function setData($data){
			$this->db->insert('coa', $data);
		}
		
		public function getData(){
			$query = $this->db->get('coa');
			return $query->result();
		}		
		
		public function getDataById($id){
			$this->db->select('*')
					 ->from('coa')
					 ->where('no_referensi ', $id);
			$query = $this->db->get();
			return $query->result();
		}
		
		public function getID(){
			$query = $this->db->query('select CONCAT(REPEAT("0",LENGTH(SUBSTRING_INDEX(id_coa, "-", -1)) - LENGTH(SUBSTRING_INDEX(id_coa, "-", -1)+1 )), SUBSTRING_INDEX(id_coa, "-", -1)+1) as "id_coa" from coa order by id_coa desc');
			return $query;
		}	
		
		public function updateData($id, $data){
			$this->db->where('id_coa', $id);
			$this->db->update('coa', $data);
		}
		
		public function removeData($id){
			$this->db->where('id_coa', $id);
			$this->db->delete('coa');
		}
	}
?>