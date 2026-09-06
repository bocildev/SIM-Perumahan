<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class M_Pengeluaran extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Ambil seluruh kategori pengeluaran
     */
    public function get_all_kategori() {
        $this->db->order_by('nama_kategori', 'ASC');
        return $this->db->get('kategori_pengeluaran')->result();
    }

    /**
     * Tambah kategori baru
     */
    public function insert_kategori($nama_kategori) {
        return $this->db->insert('kategori_pengeluaran', ['nama_kategori' => $nama_kategori]);
    }

    /**
     * Ambil seluruh data pengeluaran dengan filter opsional
     */
    public function get_pengeluaran_list($filter = []) {
        $this->db->select('p.*, k.nama_kategori, u.username as pencatat');
        $this->db->from('pengeluaran_kas p');
        $this->db->join('kategori_pengeluaran k', 'k.id_kategori = p.id_kategori');
        $this->db->join('users u', 'u.id_user = p.created_by', 'left');

        if (!empty($filter['id_kategori'])) {
            $this->db->where('p.id_kategori', $filter['id_kategori']);
        }
        if (!empty($filter['tgl_mulai']) && !empty($filter['tgl_selesai'])) {
            $this->db->where('p.tgl_pengeluaran >=', $filter['tgl_mulai']);
            $this->db->where('p.tgl_pengeluaran <=', $filter['tgl_selesai']);
        }

        $this->db->order_by('p.tgl_pengeluaran', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Detail satu pengeluaran
     */
    public function get_pengeluaran_by_id($id_pengeluaran) {
        $this->db->where('id_pengeluaran', $id_pengeluaran);
        return $this->db->get('pengeluaran_kas')->row();
    }

    /**
     * Tambah pengeluaran baru
     */
    public function insert_pengeluaran($data) {
        return $this->db->insert('pengeluaran_kas', $data);
    }

    /**
     * Hapus pengeluaran
     */
    public function delete_pengeluaran($id_pengeluaran) {
        $this->db->where('id_pengeluaran', $id_pengeluaran);
        return $this->db->delete('pengeluaran_kas');
    }
}
