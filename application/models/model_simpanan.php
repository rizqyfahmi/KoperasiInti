<?php
	class model_simpanan extends CI_Model{
		public function setData($data){
			$this->db->insert('simpanan', $data);
		}
		
		public function getData(){
			$this->db->select('simpanan.id_simpanan, simpanan.id_jenis_simpanan, simpanan.tanggal_pembuatan, sum(simpanan.jumlah_simpanan) as "jumlah_simpanan", anggota.*, jenis_anggota.id_jenis_anggota, jenis_anggota.jabatan')
					 ->from('simpanan')
					 ->join('anggota', 'simpanan.id_anggota = anggota.id_anggota')
					 ->join('jenis_anggota', 'simpanan.id_jenis_anggota = jenis_anggota.id_jenis_anggota')
					 ->where('simpanan.id_jenis_simpanan !=', 'JSMP-03')
					 ->group_by('simpanan.id_anggota');
			$query = $this->db->get();
			return $query->result();
		}

		public function getDataWithoutSukarela(){
			$this->db->select('*')
					 ->from('simpanan')
					 ->where('id_jenis_simpanan !=', 'JSMP-03');
			$query = $this->db->get();
			return $query->result();
		}			
		
		public function getID($tanggal_pembuatan){
			$query = $this->db->query('select CONCAT(REPEAT("0", LENGTH(substring(id_simpanan, -4))-LENGTH(substring(id_simpanan, -4)+1)), substring(id_simpanan, -4)+1) as "id_simpanan" from simpanan where tanggal_pembuatan="'.$tanggal_pembuatan.'" order by id_simpanan desc');
			return $query;
		}
		
		public function getDataAll(){
			$this->db->select('simpanan.*')
					 ->from('simpanan');
			$query = $this->db->get();
			return $query->result();
		}		
		
		public function getDataById($id){
			$this->db->select('simpanan.*, sum(simpanan.jumlah_simpanan) as "jumlah_simpanan", anggota.*, jenis_anggota.id_jenis_anggota, jenis_anggota.jabatan, jenis_simpanan.*, jenis_simpanan.detail as "detail_jenis_simpanan"')
					 ->from('simpanan')
					 ->join('anggota', 'simpanan.id_anggota = anggota.id_anggota')
					 ->join('jenis_anggota', 'simpanan.id_jenis_anggota = jenis_anggota.id_jenis_anggota')
					 ->join('jenis_simpanan', 'simpanan.id_jenis_simpanan = jenis_simpanan.id_jenis_simpanan')
					 ->where('anggota.id_anggota', $id)
					 ->group_by('simpanan.id_jenis_simpanan');
			$query = $this->db->get();
			return $query->result();
		}
		
		public function getDataByIdNonSum($id){
			$this->db->select('simpanan.*, jenis_simpanan.*')
					 ->from('simpanan')
					 ->join('jenis_simpanan', 'simpanan.id_jenis_simpanan = jenis_simpanan.id_jenis_simpanan')
					 ->where('id_anggota', $id);
			$query = $this->db->get();
			return $query->result();
		}
		
		public function updateData($id, $data){
			$this->db->where('id_simpanan', $id);
			$this->db->update('simpanan', $data);
		}
		
		public function removeData($id){
			$this->db->where('id_simpanan', $id);
			$this->db->delete('simpanan');
		}
	}
?>