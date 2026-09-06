<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Users extends Auth_Controller {

    public function __construct() {
        parent::__construct();
        $this->check_role('admin');
        $this->load->model(['M_Users', 'M_Warga']);
        $this->load->library('form_validation');
    }

    public function index() {
        $this->db->where('id_user IS NULL', null, false);
        $this->db->or_where('id_user', 0);
        $total_tanpa_user = $this->db->count_all_results('warga');

        $data = [
            'page_title'       => 'Management User & Role',
            'users'            => $this->M_Users->get_all_users(),
            'roles'            => $this->M_Users->get_all_roles(),
            'total_tanpa_user' => $total_tanpa_user
        ];
        $this->render('users/index', $data);
    }

    public function create() {
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('id_role', 'Role Pengguna', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data = [
                'page_title' => 'Tambah Pengguna Baru',
                'roles'      => $this->M_Users->get_all_roles(),
                'warga_list' => $this->M_Warga->get_all_warga()
            ];
            $this->render('users/create', $data);
        } else {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password');
            $id_role  = $this->input->post('id_role', TRUE);
            $id_warga = $this->input->post('id_warga', TRUE);

            // Password hash BCRYPT sesuai SECURITY.md
            $data_user = [
                'username'  => $username,
                'password'  => password_hash($password, PASSWORD_BCRYPT),
                'id_role'   => $id_role,
                'is_active' => 1
            ];

            $this->M_Users->insert_user($data_user);
            $new_user_id = $this->db->insert_id();

            // Link ke warga jika dipilih
            if (!empty($id_warga)) {
                $this->M_Warga->update_warga($id_warga, ['id_user' => $new_user_id]);
            }

            $this->session->set_flashdata('success', 'User ' . html_escape($username) . ' berhasil dibuat.');
            redirect('users');
        }
    }

    public function reset_password($id_user) {
        $user = $this->M_Users->get_user_by_id($id_user);
        if (!$user) {
            $this->session->set_flashdata('error', 'User tidak ditemukan.');
            redirect('users');
        }

        $is_warga = (isset($user->role_name) && strtolower($user->role_name) === 'warga');
        $new_pass = $is_warga ? 'WargaBaik1!' : 'password123';

        $this->M_Users->update_user($id_user, [
            'password' => password_hash($new_pass, PASSWORD_BCRYPT)
        ]);

        $this->session->set_flashdata('success', 'Password user ' . html_escape($user->username) . ' berhasil direset menjadi: ' . $new_pass);
        redirect('users');
    }

    public function toggle_status($id_user) {
        $user = $this->M_Users->get_user_by_id($id_user);
        if ($user) {
            if ($user->id_user == $this->current_user['id_user']) {
                $this->session->set_flashdata('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
                redirect('users');
            }

            $new_status = ($user->is_active == 1) ? 0 : 1;
            $this->M_Users->update_user($id_user, ['is_active' => $new_status]);
            $this->session->set_flashdata('success', 'Status user berhasil diperbarui.');
        }
        redirect('users');
    }

    public function delete($id_user) {
        if ($id_user == $this->current_user['id_user']) {
            $this->session->set_flashdata('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            redirect('users');
        }

        $this->M_Users->delete_user($id_user);
        $this->session->set_flashdata('success', 'User berhasil dihapus.');
        redirect('users');
    }
}
