<?php
	class model_pinjaman extends CI_Model{
		public function setData($data){
			$this->db->insert('pinjaman', $data);
		}
		
		public function getData(){
			$this->db->select('pinjaman.*, anggota.*, jenis_pinjaman.*, jenis_pinjaman.detail as "jenis_pinjaman", jenis_angsuran.*')
					 ->from('pinjaman')
					 ->join('jenis_pinjaman', 'jenis_pinjaman.id_jenis_pinjaman = pinjaman.id_jenis_pinjaman')
					 ->join('anggota', 'pinjaman.id_anggota = anggota.id_anggota')
					 ->join('jenis_angsuran', 'pinjaman.id_jenis_angsuran = jenis_angsuran.id_jenis_angsuran')
					 ->where('pinjaman.acc >', '0')
					 ->order_by("pinjaman.id_pinjaman", "asc"); 
			$query = $this->db->get();
			return $query->result();
		}

		public function getDataGroupBy(){
			$this->db->select('pinjaman.*, sum(pinjaman.nominal_pinjaman) as "nominal_pinjaman", count(pinjaman.id_pinjaman) as "total_pinjaman", anggota.*, jenis_pinjaman.*, jenis_pinjaman.detail as "jenis_pinjaman", jenis_angsuran.*')
					 ->from('pinjaman')
					 ->join('jenis_pinjaman', 'jenis_pinjaman.id_jenis_pinjaman = pinjaman.id_jenis_pinjaman')
					 ->join('anggota', 'pinjaman.id_anggota = anggota.id_anggota')
					 ->join('jenis_angsuran', 'pinjaman.id_jenis_angsuran = jenis_angsuran.id_jenis_angsuran')
					 ->group_by('anggota.id_anggota');
			$query = $this->db->get();
			return $query->result();
		}
		
		public function getID($tanggal_pembuatan){
			$query = $this->db->query('select CONCAT(REPEAT("0", LENGTH(substring(id_pinjaman, -4))-LENGTH(substring(id_pinjaman, -4)+1)), substring(id_pinjaman, -4)+1) as "id_pinjaman" from pinjaman where tanggal_pembuatan="'.$tanggal_pembuatan.'" order by id_pinjaman desc');
			return $query;
		}
		
		public function getDataById($id){
			$this->db->select('pinjaman.*, anggota.*, jenis_angsuran.*')
					 ->from('pinjaman')
					 ->join('anggota', 'pinjaman.id_anggota = anggota.id_anggota')
					 ->join('jenis_angsuran', 'jenis_angsuran.id_jenis_angsuran = pinjaman.id_jenis_angsuran')
					 ->where('id_pinjaman', $id)
					 ->order_by("pinjaman.id_pinjaman", "asc"); 
			$query = $this->db->get();
			return $query->result();
		}
		
		public function getDataByIdAnggota($id){
			$this->db->select('pinjaman.*, anggota.*, jenis_pinjaman.detail as "jenis_pinjaman"')
					 ->from('pinjaman')
					 ->join('anggota', 'pinjaman.id_anggota = anggota.id_anggota')
					 ->join('jenis_pinjaman', 'jenis_pinjaman.id_jenis_pinjaman = pinjaman.id_jenis_pinjaman')
					 ->where('pinjaman.id_anggota', $id)
					 ->order_by("pinjaman.id_pinjaman", "asc"); 
			$query = $this->db->get();
			return $query->result();
		}
		
		public function getDataByIdAnggotaWithoutRegret($id){
			$this->db->select('pinjaman.*, anggota.*, jenis_pinjaman.detail as "jenis_pinjaman"')
					 ->from('pinjaman')
					 ->join('anggota', 'pinjaman.id_anggota = anggota.id_anggota')
					 ->join('jenis_pinjaman', 'jenis_pinjaman.id_jenis_pinjaman = pinjaman.id_jenis_pinjaman')
					 ->where('pinjaman.id_anggota', $id)
					 ->where('pinjaman.acc !=', '0')
					 ->order_by("pinjaman.id_pinjaman", "asc"); 
			$query = $this->db->get();
			return $query->result();
		}
		
		public function getAcceptedData($id){
			$this->db->select('pinjaman.*, anggota.*, jenis_pinjaman.detail as "jenis_pinjaman"')
					 ->from('pinjaman')
					 ->join('anggota', 'pinjaman.id_anggota = anggota.id_anggota')
					 ->join('jenis_pinjaman', 'jenis_pinjaman.id_jenis_pinjaman = pinjaman.id_jenis_pinjaman')
					 ->where('pinjaman.id_anggota', $id)
					 ->where('pinjaman.acc', '1')
					 ->where('pinjaman.status_pembayaran', '0')
					 ->order_by("pinjaman.id_pinjaman", "asc"); 
			$query = $this->db->get();
			return $query->result();
		}
		
		public function getDataWithoutRegret(){
			$this->db->select('pinjaman.*, sum(pinjaman.nominal_pinjaman) as "nominal_pinjaman", count(pinjaman.id_pinjaman) as "total_pinjaman", anggota.*, jenis_pinjaman.*, jenis_pinjaman.detail as "jenis_pinjaman", jenis_angsuran.*')
					 ->from('pinjaman')
					 ->join('jenis_pinjaman', 'jenis_pinjaman.id_jenis_pinjaman = pinjaman.id_jenis_pinjaman')
					 ->join('anggota', 'pinjaman.id_anggota = anggota.id_anggota')
					 ->join('jenis_angsuran', 'pinjaman.id_jenis_angsuran = jenis_angsuran.id_jenis_angsuran')
					 ->where('pinjaman.acc !=', '0')
					 ->group_by('anggota.id_anggota');
			$query = $this->db->get();
			return $query->result();
		}
		
		public function getAccepted(){
			$query = $this->db->query('select anggota.id_anggota, anggota.nama, ifnull((select sum(nominal_pinjaman) from pinjaman p where p.id_anggota = anggota.id_anggota and acc = 1), 0) as "nominal_pinjaman", ifnull((select count(id_pinjaman) from pinjaman p where p.id_anggota = anggota.id_anggota and acc = 2), 0) as "menunggu", ifnull((select count(id_pinjaman) from pinjaman p where p.id_anggota = anggota.id_anggota and acc = 1), 0) as "diterima", ifnull((select count(id_pinjaman) from pinjaman p where p.id_anggota = anggota.id_anggota and acc = 0), 0) as "ditolak" from pinjaman join anggota on pinjaman.id_anggota = anggota.id_anggota join jenis_pinjaman on pinjaman.id_jenis_pinjaman = jenis_pinjaman.id_jenis_pinjaman join jenis_angsuran on pinjaman.id_jenis_angsuran = jenis_angsuran.id_jenis_angsuran group by anggota.id_anggota');
			return $query->result();
		}
		
		public function getDataByIdPinjaman($id){
			$query = $this->db->query('select * from pinjaman join jenis_angsuran on pinjaman.id_jenis_angsuran = jenis_angsuran.id_jenis_angsuran where id_pinjaman="'.$id.'"');
			return $query->row();
		}
		
		public function getOnlyPinjamanByIdPinjaman($id){
			$query = $this->db->query('select * from pinjaman where id_pinjaman="'.$id.'"');
			return $query->row();
		}
		public function updateData($id, $data){
			$this->db->where('id_pinjaman', $id);
			$this->db->update('pinjaman', $data);
		}
		
		public function removeData($id){
			$this->db->where('id_pinjaman', $id);
			$this->db->delete('pinjaman');
		}
	}
?>