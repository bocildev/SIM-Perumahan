<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class M_Auth extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Cari data user berdasarkan username
     */
    public function get_user_by_username($username) {
        $this->db->select('u.*, r.role_name, w.id_warga, w.nama_lengkap as nama_warga, w.no_blok');
        $this->db->from('users u');
        $this->db->join('roles r', 'r.id_role = u.id_role');
        $this->db->join('warga w', 'w.id_user = u.id_user', 'left');
        $this->db->where('u.username', $username);
        return $this->db->get()->row();
    }

    /**
     * Update data user
     */
    public function update_user($id_user, $data) {
        $this->db->where('id_user', $id_user);
        return $this->db->update('users', $data);
    }
}
