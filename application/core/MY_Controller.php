<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class MY_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
}

/**
 * Auth_Controller: Base controller untuk halaman yang membutuhkan login
 * Memeriksa session login dan menyediakan helper RBAC sesuai SECURITY.md
 */
#[\AllowDynamicProperties]
class Auth_Controller extends MY_Controller {
    protected $current_user;

    public function __construct() {
        parent::__construct();
        
        // 1. Cek sesi login
        if (!$this->session->userdata('is_logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu untuk mengakses sistem.');
            redirect('auth');
            exit;
        }

        // 2. Ambil data session user
        $this->current_user = [
            'id_user'   => $this->session->userdata('id_user'),
            'username'  => $this->session->userdata('username'),
            'id_role'   => $this->session->userdata('id_role'),
            'role_name' => $this->session->userdata('role_name'),
            'id_warga'  => $this->session->userdata('id_warga'),
            'nama_warga'=> $this->session->userdata('nama_warga'),
        ];
    }

    /**
     * Helper Role-Based Access Control (RBAC)
     * @param array|string $allowed_roles Nama role yang diperbolehkan (misal: 'admin' atau ['admin', 'pengurus'])
     */
    protected function check_role($allowed_roles) {
        if (!is_array($allowed_roles)) {
            $allowed_roles = [$allowed_roles];
        }

        $user_role = $this->session->userdata('role_name');
        if (!in_array($user_role, $allowed_roles)) {
            $this->session->set_flashdata('error', 'Akses ditolak: Anda tidak memiliki izin untuk modul ini.');
            redirect('dashboard');
            exit;
        }
    }

    /**
     * Helper untuk merender view dengan layout seragam (Header, Sidebar, Content, Footer)
     */
    protected function render($view, $data = []) {
        $data['current_user'] = $this->current_user;
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view($view, $data);
        $this->load->view('layouts/footer', $data);
    }
}
