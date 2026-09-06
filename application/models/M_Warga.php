<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class M_Warga extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Ambil seluruh data warga dengan join ke user
     */
    public function get_all_warga() {
        $this->db->select('w.*, u.username, u.is_active as user_active');
        $this->db->from('warga w');
        $this->db->join('users u', 'u.id_user = w.id_user', 'left');
        $this->db->order_by('w.no_blok', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Ambil detail satu warga
     */
    public function get_warga_by_id($id_warga) {
        $this->db->where('id_warga', $id_warga);
        return $this->db->get('warga')->row();
    }

    /**
     * Tambah data warga baru
     */
    public function insert_warga($data) {
        return $this->db->insert('warga', $data);
    }

    /**
     * Update data warga
     */
    public function update_warga($id_warga, $data) {
        $this->db->where('id_warga', $id_warga);
        return $this->db->update('warga', $data);
    }

    /**
     * Hapus data warga
     */
    public function delete_warga($id_warga) {
        $this->db->where('id_warga', $id_warga);
        return $this->db->delete('warga');
    }
}
