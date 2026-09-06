<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Warga extends Auth_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_Warga');
        $this->load->library('form_validation');
    }

    public function index() {
        $data = [
            'page_title' => 'Data Warga & Rumah',
            'warga_list' => $this->M_Warga->get_all_warga()
        ];
        $this->render('warga/index', $data);
    }

    public function create() {
        $this->check_role(['admin', 'pengurus']);

        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('no_blok', 'Nomor Blok/Rumah', 'required|trim');
        $this->form_validation->set_rules('no_hp', 'Nomor HP/WhatsApp', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data = ['page_title' => 'Tambah Data Warga'];
            $this->render('warga/create', $data);
        } else {
            $data_insert = [
                'nama_lengkap'    => $this->input->post('nama_lengkap', TRUE),
                'no_blok'         => $this->input->post('no_blok', TRUE),
                'no_hp'           => $this->input->post('no_hp', TRUE),
                'status_hunian'   => $this->input->post('status_hunian', TRUE),
                'status_penghuni' => $this->input->post('status_penghuni', TRUE),
                'nik'             => $this->input->post('nik', TRUE)
            ];

            $this->M_Warga->insert_warga($data_insert);
            $this->session->set_flashdata('success', 'Data warga berhasil ditambahkan.');
            redirect('warga');
        }
    }

    public function edit($id) {
        $this->check_role(['admin', 'pengurus']);

        $warga = $this->M_Warga->get_warga_by_id($id);
        if (!$warga) {
            $this->session->set_flashdata('error', 'Data warga tidak ditemukan.');
            redirect('warga');
        }

        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('no_blok', 'Nomor Blok/Rumah', 'required|trim');
        $this->form_validation->set_rules('no_hp', 'Nomor HP/WhatsApp', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data = [
                'page_title' => 'Edit Data Warga',
                'warga'      => $warga
            ];
            $this->render('warga/edit', $data);
        } else {
            $data_update = [
                'nama_lengkap'    => $this->input->post('nama_lengkap', TRUE),
                'no_blok'         => $this->input->post('no_blok', TRUE),
                'no_hp'           => $this->input->post('no_hp', TRUE),
                'status_hunian'   => $this->input->post('status_hunian', TRUE),
                'status_penghuni' => $this->input->post('status_penghuni', TRUE),
                'nik'             => $this->input->post('nik', TRUE)
            ];

            $this->M_Warga->update_warga($id, $data_update);
            $this->session->set_flashdata('success', 'Data warga berhasil diperbarui.');
            redirect('warga');
        }
    }

    public function delete($id) {
        $this->check_role(['admin']);
        $this->M_Warga->delete_warga($id);
        $this->session->set_flashdata('success', 'Data warga berhasil dihapus.');
        redirect('warga');
    }
}
