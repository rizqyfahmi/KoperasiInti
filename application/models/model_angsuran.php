<?php
	class model_angsuran extends CI_Model{
		public function setData($data){
			$this->db->insert('angsuran', $data);
		}
		
		public function getID($tanggal_pembuatan){
			$query = $this->db->query('select CONCAT(REPEAT("0", LENGTH(substring(id_angsuran, -4))-LENGTH(substring(id_angsuran, -4)+1)), substring(id_angsuran, -4)+1) as "id_angsuran" from angsuran where tanggal_pembuatan="'.$tanggal_pembuatan.'" order by id_angsuran desc');
			return $query;
		}
		
		public function getDataById($id){
			$this->db->select('angsuran.*, pinjaman.*, anggota.*')
					 ->from('angsuran')
					 ->join('anggota', 'angsuran.id_anggota = anggota.id_anggota')
					 ->join('pinjaman', 'pinjaman.id_anggota = anggota.id_anggota')
					 ->where('angsuran.id_anggota', $id);
			$query = $this->db->get();
			return $query->result();
		}
		
		public function getTerbayar($id){
			$this->db->select('*')
					 ->from('angsuran')
					 ->where('id_pinjaman', $id);
			$query = $this->db->get();
			return $query->num_rows();
		}
		
		public function getData(){
			$query = $this->db->get('angsuran');
			return $query->result();
		}		
		
		public function updateData($id, $data){
			$this->db->where('id_angsuran', $id);
			$this->db->update('angsuran', $data);
		}
		
		public function removeData($id){
			$this->db->where('id_angsuran', $id);
			$this->db->delete('angsuran');
		}
	}
?>