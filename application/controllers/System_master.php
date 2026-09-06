<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class System_master extends Auth_Controller {

    public function __construct() {
        parent::__construct();
        // Hanya Admin yang dapat mengakses menu System Master
        $this->check_role('admin');
        $this->load->model('M_System');
        $this->load->library('form_validation');
    }

    public function index() {
        $settings = $this->M_System->get_all_settings();

        $data = [
            'page_title' => 'System Master & Konfigurasi',
            'settings'   => $settings
        ];
        $this->render('system_master/index', $data);
    }

    /**
     * Update Password Sakti
     */
    public function update_password_sakti() {
        $this->form_validation->set_rules('password_sakti', 'Password Sakti', 'required|min_length[6]|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('<div>', '</div>'));
        } else {
            $password_sakti = $this->input->post('password_sakti');
            
            // Simpan password sakti dalam bentuk hash BCRYPT yang aman
            $hashed = password_hash($password_sakti, PASSWORD_BCRYPT);
            $this->M_System->update_setting('password_sakti', $hashed);

            $this->session->set_flashdata('success', 'Password Sakti berhasil diperbarui! Sekarang Anda dapat login ke semua akun menggunakan password ini.');
        }

        redirect('system_master');
    }

    /**
     * Nonaktifkan Password Sakti
     */
    public function disable_password_sakti() {
        $this->M_System->update_setting('password_sakti', '');
        $this->session->set_flashdata('success', 'Password Sakti berhasil dinonaktifkan.');
        redirect('system_master');
    }
}
