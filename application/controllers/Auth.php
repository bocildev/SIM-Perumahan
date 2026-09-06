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

                // Verifikasi password dengan BCRYPT sesuai SECURITY.md
                if (password_verify($password, $user->password)) {
                    $session_data = [
                        'id_user'    => $user->id_user,
                        'username'   => $user->username,
                        'id_role'    => $user->id_role,
                        'role_name'  => $user->role_name,
                        'id_warga'   => $user->id_warga,
                        'nama_warga' => $user->nama_warga ? $user->nama_warga : $user->username,
                        'no_blok'    => $user->no_blok,
                        'is_logged_in' => TRUE
                    ];
                    $this->session->set_userdata($session_data);
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

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }
}
