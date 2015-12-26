<?php
	class model_jenis_simpanan extends CI_Model{
		public function setData($data){
			$this->db->insert('jenis_simpanan', $data);
		}
		
		public function getData(){
			$query = $this->db->get('jenis_simpanan');
			return $query->result();
		}		
		
		public function getID(){
			$query = $this->db->query('select CONCAT(REPEAT("0",LENGTH(SUBSTRING_INDEX(id_jenis_simpanan, "-", -1)) - LENGTH(SUBSTRING_INDEX(id_jenis_simpanan, "-", -1)+1 )), SUBSTRING_INDEX(id_jenis_simpanan, "-", -1)+1) as "id_jenis_simpanan" from jenis_simpanan order by id_jenis_simpanan desc');
			return $query;
		}	
		
		public function getDataWithoutSimpananPokok(){
			$this->db->select('*')
					 ->from('jenis_simpanan')
					 ->where('id_jenis_simpanan !=', 'JSMP-01');
			$query = $this->db->get();
			return $query->result();
		}
		
		public function updateData($id, $data){
			$this->db->where('id_jenis_simpanan', $id);
			$this->db->update('jenis_simpanan', $data);
		}
		
		public function removeData($id){
			$this->db->where('id_jenis_simpanan', $id);
			$this->db->delete('jenis_simpanan');
		}
	}
?>