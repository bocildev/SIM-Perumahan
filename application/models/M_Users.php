<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class M_Users extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Ambil seluruh user dengan data role dan warga
     */
    public function get_all_users() {
        $this->db->select('u.*, r.role_name, w.nama_lengkap as nama_warga, w.no_blok');
        $this->db->from('users u');
        $this->db->join('roles r', 'r.id_role = u.id_role');
        $this->db->join('warga w', 'w.id_user = u.id_user', 'left');
        $this->db->order_by('u.id_user', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Ambil seluruh role
     */
    public function get_all_roles() {
        return $this->db->get('roles')->result();
    }

    /**
     * Insert user baru
     */
    public function insert_user($data) {
        return $this->db->insert('users', $data);
    }

    /**
     * Update user
     */
    public function update_user($id_user, $data) {
        $this->db->where('id_user', $id_user);
        return $this->db->update('users', $data);
    }

    /**
     * Ambil user by ID
     */
    public function get_user_by_id($id_user) {
        $this->db->where('id_user', $id_user);
        return $this->db->get('users')->row();
    }

    /**
     * Delete user
     */
    public function delete_user($id_user) {
        $this->db->where('id_user', $id_user);
        return $this->db->delete('users');
    }
}
