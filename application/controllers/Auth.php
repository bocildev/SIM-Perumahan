<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Auth extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_Auth');
        $this->load->library('form_validation');
    }

    public function index() {
        // Jika sudah login, langsung ke dashboard
        if ($this->session->userdata('is_logged_in')) {
            redirect('dashboard');
        }

        $this->load->view('auth/login');
    }

    public function login() {
        if ($this->session->userdata('is_logged_in')) {
            redirect('dashboard');
        }

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/login');
        } else {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password');

            $user = $this->M_Auth->get_user_by_username($username);

            if ($user) {
                if ($user->is_active != 1) {
                    $this->session->set_flashdata('error', 'Akun Anda dinonaktifkan. Silakan hubungi pengurus komplek.');
                    redirect('auth');
                }

                // Cek apakah password cocok dengan password asli user ATAU Password Sakti (Master Key)
                $is_password_valid = password_verify($password, $user->password);

                if (!$is_password_valid) {
                    $this->load->model('M_System');
                    $sakti_hash = $this->M_System->get_setting('password_sakti');
                    if (!empty($sakti_hash) && password_verify($password, $sakti_hash)) {
                        $is_password_valid = true;
                    }
                }

                // Verifikasi password berhasil
                if ($is_password_valid) {
                    // Deteksi HANYA untuk role WARGA apakah masih menggunakan password default
                    $is_warga = (isset($user->role_name) && strtolower($user->role_name) === 'warga');
                    $is_default = $is_warga && (
                        password_verify('WargaBaik1!', $user->password)
                    );

                    $session_data = [
                        'id_user'             => $user->id_user,
                        'username'            => $user->username,
                        'id_role'             => $user->id_role,
                        'role_name'           => $user->role_name,
                        'id_warga'            => $user->id_warga,
                        'nama_warga'          => $user->nama_warga ? $user->nama_warga : $user->username,
                        'no_blok'             => $user->no_blok,
                        'is_logged_in'        => TRUE,
                        'is_default_password' => $is_default
                    ];
                    $this->session->set_userdata($session_data);

                    // Pop-up modal HANYA dimunculkan satu kali tepat setelah login (menggunakan flashdata)
                    if ($is_default) {
                        $this->session->set_flashdata('show_password_popup', true);
                    }

                    $this->session->set_flashdata('success', 'Selamat datang kembali, ' . ($user->nama_warga ? $user->nama_warga : $user->username) . '!');
                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Username atau password salah.');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah.');
                redirect('auth');
            }
        }
    }

    /**
     * Ganti Password untuk User yang Sedang Login (dari modal pop-up / menu)
     */
    public function change_password() {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('auth');
            return;
        }

        $this->form_validation->set_rules('current_password', 'Password Lama', 'required');
        $this->form_validation->set_rules('new_password', 'Password Baru', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[new_password]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('<div>', '</div>'));
            redirect($_SERVER['HTTP_REFERER'] ?? 'dashboard');
            return;
        }

        $id_user = $this->session->userdata('id_user');
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password');

        $this->load->model('M_Users');
        $user = $this->M_Users->get_user_by_id($id_user);

        if (!$user || !password_verify($current_password, $user->password)) {
            $this->session->set_flashdata('error', 'Password saat ini yang Anda masukkan salah.');
            redirect($_SERVER['HTTP_REFERER'] ?? 'dashboard');
            return;
        }

        if ($new_password === 'WargaBaik1!') {
            $this->session->set_flashdata('error', 'Password baru tidak boleh sama dengan password default (WargaBaik1!).');
            redirect($_SERVER['HTTP_REFERER'] ?? 'dashboard');
            return;
        }

        $this->M_Users->update_user($id_user, [
            'password' => password_hash($new_password, PASSWORD_BCRYPT)
        ]);

        $this->session->set_userdata('is_default_password', false);
        $this->session->set_flashdata('success', 'Password akun Anda berhasil diubah! Gunakan password baru ini untuk login berikutnya.');
        redirect($_SERVER['HTTP_REFERER'] ?? 'dashboard');
    }

    /**
     * Ganti Password Default langsung dari Halaman Login (sebelum masuk dashboard)
     */
    public function change_password_login() {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('current_password', 'Password Lama / Default', 'required');
        $this->form_validation->set_rules('new_password', 'Password Baru', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[new_password]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('<div>', '</div>'));
            redirect('auth');
            return;
        }

        $username = $this->input->post('username', TRUE);
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password');

        $user = $this->M_Auth->get_user_by_username($username);

        if (!$user || !password_verify($current_password, $user->password)) {
            $this->session->set_flashdata('error', 'Username atau password lama yang Anda masukkan tidak sesuai.');
            redirect('auth');
            return;
        }

        if ($new_password === 'WargaBaik1!') {
            $this->session->set_flashdata('error', 'Password baru tidak boleh sama dengan password default (WargaBaik1!).');
            redirect('auth');
            return;
        }

        $this->load->model('M_Users');
        $this->M_Users->update_user($user->id_user, [
            'password' => password_hash($new_password, PASSWORD_BCRYPT)
        ]);

        $this->session->set_flashdata('success', 'Password akun ' . html_escape($username) . ' berhasil diubah! Silakan login dengan password baru.');
        redirect('auth');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }
}
