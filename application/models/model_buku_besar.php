<?php
	class model_buku_besar extends CI_Model{
		public function setData($data){
			$this->db->insert('jurnal', $data);
		}
		
		public function getBukuBesar($bb, $bulan, $tahun){
			$this->db->select('*')
					 ->from($bb)
					 ->where('month(tanggal_transaksi)', $bulan)
					 ->where('year(tanggal_transaksi)', $tahun);
			$query = $this->db->get();
			return $query;
		}	
		public function getSaldoAwal($bb, $bulan, $tahun){
			$query = $this->db->query('SELECT no_ref, DATE_ADD(LAST_DAY(DATE_SUB(tanggal_transaksi, interval 1 month)), interval 1 day) as "tanggal" ,case when((select month(tanggal_transaksi) from '.$bb.' where year(tanggal_transaksi) = "'.$tahun.'" limit 1) = month(tanggal_transaksi)) = 1 then saldo_awal else (select saldo from '.$bb.' where year(tanggal_transaksi) = "'.$tahun.'" and month(tanggal_transaksi) = (select month(tanggal_transaksi) from '.$bb.' where year(tanggal_transaksi) = "'.$tahun.'" limit 1) order by no desc limit 1) end as "saldo_awal" FROM '.$bb.' where year(tanggal_transaksi) = "'.$tahun.'" and month(tanggal_transaksi) = "'.$bulan.'" order by no limit 1');
			return $query->row();
		}
	}
?>