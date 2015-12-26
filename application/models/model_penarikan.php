<?php
	class model_penarikan extends CI_Model{
		public function setData($data){
			$this->db->insert('penarikan', $data);
		}
		
		public function getData(){
			$query = $this->db->get('penarikan');
			return $query->result();
		}		
		
		public function getDataByIdAnggota($id){
			$this->db->select('*, sum(jumlah_penarikan) as "jumlah_penarikan"')
					 ->from('penarikan')
					 ->where('id_anggota', $id)
					 ->group_by('id_anggota');
			$query = $this->db->get();
			return $query->result();
		}
		
		public function getDataByIdAnggota2($id){
			$this->db->select('*')
					 ->from('penarikan')
					 ->where('id_anggota', $id);
			$query = $this->db->get();
			return $query->result();
		}
		
		public function getID($tanggal_pembuatan){
			$query = $this->db->query('select CONCAT(REPEAT("0", LENGTH(substring(id_penarikan, -4))-LENGTH(substring(id_penarikan, -4)+1)), substring(id_penarikan, -4)+1) as "id_penarikan" from penarikan where tanggal_pembuatan="'.$tanggal_pembuatan.'" order by id_penarikan desc');
			return $query;
		}	
		
		public function updateData($id, $data){
			$this->db->where('id_penarikan', $id);
			$this->db->update('penarikan', $data);
		}
		
		public function removeData($id){
			$this->db->where('id_penarikan', $id);
			$this->db->delete('penarikan');
		}
	}
?>