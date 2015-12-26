<?php
	class model_jurnal extends CI_Model{
		public function setData($data){
			$this->db->insert('jurnal', $data);
		}
		
		public function getData(){
			$this->db->select('jurnal.*, coa.*')
					 ->from('jurnal')
					 ->join('coa', 'jurnal.no_ref = coa.no_referensi')
					 ->order_by('jurnal.no');
			$query = $this->db->get();
			return $query->result();
		}		
		
		public function getID($tanggal_transaksi){
			$query = $this->db->query('select CONCAT(REPEAT("0", LENGTH(substring(id_jurnal, -4))-LENGTH(substring(id_jurnal, -4)+1)), substring(id_jurnal, -4)+1) as "id_jurnal" from jurnal where tanggal_transaksi="'.$tanggal_transaksi.'" order by id_jurnal desc');
			return $query;
		}	
		
		public function getDataByMonthYear($bulan, $tahun){
			$this->db->select('*')
					 ->from('jurnal')
					 ->where('month(tanggal_transaksi)', $bulan)
					 ->where('year(tanggal_transaksi)', $tahun);
			$query = $this->db->get();
			return $query->result();
		}
		
		public function getDataByNoRef($no_ref){
			$this->db->select('*')
					 ->from('jurnal')
					 ->where('no_ref', $no_ref);
			$query = $this->db->get();
			return $query->result();
		}
		
		public function getDataBukuBesar(){
			$this->db->query('SET @jml = (select jumlah from saldo)')
					 ->query('SELECT id_anggota, tanggal_transaksi, keterangan, deskripsi, CASE WHEN posisi = "Debit" then jumlah else "-" END as "Debit"');
			$query = $this->db->get();
			return $query;
		}
		
		public function getMaxYear(){
			$query = $this->db->query('SELECT max(year(tanggal_transaksi)) as "tahun" FROM jurnal');
			return $query;
		}
		
		public function updateData($id, $data){
			$this->db->where('id_jurnal', $id);
			$this->db->update('jurnal', $data);
		}
		
		public function removeData($id){
			$this->db->where('id_jurnal', $id);
			$this->db->delete('jurnal');
		}
		
		
	}
?>