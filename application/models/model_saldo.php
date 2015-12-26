<?php
	class model_saldo extends CI_Model{
		public function setData($data){
			$this->db->insert('saldo', $data);
		}
		
		public function getData(){
			$this->db->select('*')
					 ->from('saldo');
			$query = $this->db->get();
			return $query->result();
		}		
		
		public function getID($tanggal_transaksi){
			$query = $this->db->query('select CONCAT(REPEAT("0", LENGTH(substring(id_saldo, -4))-LENGTH(substring(id_saldo, -4)+1)), substring(id_saldo, -4)+1) as "id_saldo" from saldo where tanggal_transaksi="'.$tanggal_transaksi.'" order by id_saldo desc');
			return $query;
		}	
		
	}
?>