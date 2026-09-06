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
        $warga_list = $this->M_Warga->get_all_warga();

        // Perlindungan Privasi Data Pribadi:
        // Jika pengguna adalah warga biasa, NIK warga lain dikosongkan agar tidak terekspos
        if ($this->current_user['role_name'] === 'warga') {
            foreach ($warga_list as $w) {
                if ($w->id_warga != $this->current_user['id_warga']) {
                    $w->nik = null;
                }
            }
        }

        $total_tanpa_user = 0;
        foreach ($warga_list as $w) {
            if (empty($w->id_user)) {
                $total_tanpa_user++;
            }
        }

        $data = [
            'page_title'       => 'Data Warga & Rumah',
            'warga_list'       => $warga_list,
            'total_tanpa_user' => $total_tanpa_user
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
            $nama_lengkap    = $this->input->post('nama_lengkap', TRUE);
            $no_blok         = $this->input->post('no_blok', TRUE);
            $no_hp           = $this->input->post('no_hp', TRUE);
            $status_hunian   = $this->input->post('status_hunian', TRUE);
            $status_penghuni = $this->input->post('status_penghuni', TRUE);
            $nik             = $this->input->post('nik', TRUE);

            $new_user_id = null;
            $username_created = null;

            // Fitur Buat Akun Login Warga Otomatis
            if ($this->input->post('auto_create_user')) {
                $custom_username = trim($this->input->post('username', TRUE));

                if (!empty($custom_username)) {
                    $clean_user = strtolower(preg_replace('/[^a-zA-Z0-9_]/', '', str_replace([' ', '-'], '_', $custom_username)));
                } else {
                    $nama_parts = explode(' ', trim($nama_lengkap));
                    $first_name = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $nama_parts[0] ?? 'warga'));
                    $clean_blok = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $no_blok));
                    $clean_user = (!empty($first_name) && !empty($clean_blok)) ? $first_name . '_' . $clean_blok : ($first_name ?: $clean_blok);
                }

                if (empty($clean_user) || $clean_user === '_') {
                    $clean_user = 'warga_' . time();
                }

                // Cek keunikan username di database, bila kembar tambahkan suffix angka
                $candidate_user = $clean_user;
                $counter = 1;
                while ($this->db->get_where('users', ['username' => $candidate_user])->num_rows() > 0) {
                    $candidate_user = $clean_user . '_' . $counter;
                    $counter++;
                }
                $username_created = $candidate_user;

                // Ambil id_role untuk warga
                $role_warga = $this->db->get_where('roles', ['role_name' => 'warga'])->row();
                $id_role_warga = $role_warga ? $role_warga->id_role : 3;

                // Buat user baru dengan BCRYPT hash password default WargaBaik1!
                $this->load->model('M_Users');
                $user_data = [
                    'username'  => $username_created,
                    'password'  => password_hash('WargaBaik1!', PASSWORD_BCRYPT),
                    'id_role'   => $id_role_warga,
                    'is_active' => 1
                ];
                $this->M_Users->insert_user($user_data);
                $new_user_id = $this->db->insert_id();
            }

            $data_insert = [
                'id_user'         => $new_user_id,
                'nama_lengkap'    => $nama_lengkap,
                'no_blok'         => $no_blok,
                'no_hp'           => $no_hp,
                'status_hunian'   => $status_hunian,
                'status_penghuni' => $status_penghuni,
                'nik'             => $nik
            ];

            $this->M_Warga->insert_warga($data_insert);

            if ($new_user_id) {
                $this->session->set_flashdata('success', 'Data warga berhasil ditambahkan dan akun login warga otomatis dibuat: <strong>' . html_escape($username_created) . '</strong> (Password Default: <code>WargaBaik1!</code>).');
            } else {
                $this->session->set_flashdata('success', 'Data warga berhasil ditambahkan.');
            }
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
        $warga = $this->M_Warga->get_warga_by_id($id);
        $id_user = $warga ? $warga->id_user : null;

        $this->M_Warga->delete_warga($id);
        if ($id_user) {
            $this->load->model('M_Users');
            $this->M_Users->delete_user($id_user);
        }

        $this->session->set_flashdata('success', 'Data warga dan akun login berhasil dihapus.');
        redirect('warga');
    }

    /**
     * Buat Akun Login untuk Warga yang Belum Memiliki Akun (1-Click Action)
     */
    public function generate_user($id_warga) {
        $this->check_role(['admin', 'pengurus']);

        $warga = $this->M_Warga->get_warga_by_id($id_warga);
        if (!$warga) {
            $this->session->set_flashdata('error', 'Data warga tidak ditemukan.');
            redirect('warga');
        }

        if (!empty($warga->id_user)) {
            $this->session->set_flashdata('error', 'Warga ini sudah memiliki akun login.');
            redirect('warga');
        }

        // Generate username otomatis dari nama dan nomor blok
        $nama_parts = explode(' ', trim($warga->nama_lengkap));
        $first_name = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $nama_parts[0] ?? 'warga'));
        $clean_blok = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $warga->no_blok));
        $clean_user = (!empty($first_name) && !empty($clean_blok)) ? $first_name . '_' . $clean_blok : ($first_name ?: $clean_blok);

        if (empty($clean_user) || $clean_user === '_') {
            $clean_user = 'warga_' . time();
        }

        $candidate_user = $clean_user;
        $counter = 1;
        while ($this->db->get_where('users', ['username' => $candidate_user])->num_rows() > 0) {
            $candidate_user = $clean_user . '_' . $counter;
            $counter++;
        }
        $username_created = $candidate_user;

        // Ambil role warga
        $role_warga = $this->db->get_where('roles', ['role_name' => 'warga'])->row();
        $id_role_warga = $role_warga ? $role_warga->id_role : 3;

        // Insert ke users dengan BCRYPT hash WargaBaik1!
        $this->load->model('M_Users');
        $user_data = [
            'username'  => $username_created,
            'password'  => password_hash('WargaBaik1!', PASSWORD_BCRYPT),
            'id_role'   => $id_role_warga,
            'is_active' => 1
        ];
        $this->M_Users->insert_user($user_data);
        $new_user_id = $this->db->insert_id();

        // Kaitkan id_user ke tabel warga
        $this->M_Warga->update_warga($id_warga, ['id_user' => $new_user_id]);

        $this->session->set_flashdata('success', 'Akun login untuk warga ' . html_escape($warga->nama_lengkap) . ' berhasil dibuat: <strong>' . html_escape($username_created) . '</strong> (Password Default: <code>WargaBaik1!</code>).');
        redirect('warga');
    }

    /**
     * Buatkan Akun Login untuk SEMUA Warga yang Belum Memiliki Akun (Batch Sinkron)
     */
    public function generate_all_users() {
        $this->check_role(['admin', 'pengurus']);

        $this->db->select('id_warga, nama_lengkap, no_blok');
        $this->db->from('warga');
        $this->db->group_start();
        $this->db->where('id_user IS NULL', null, false);
        $this->db->or_where('id_user', 0);
        $this->db->group_end();
        $warga_tanpa_user = $this->db->get()->result();

        if (empty($warga_tanpa_user)) {
            $this->session->set_flashdata('error', 'Seluruh warga sudah memiliki akun login pengguna.');
            redirect($_SERVER['HTTP_REFERER'] ?? 'warga');
            return;
        }

        // Ambil role warga
        $role_warga = $this->db->get_where('roles', ['role_name' => 'warga'])->row();
        $id_role_warga = $role_warga ? $role_warga->id_role : 3;

        $this->load->model(['M_Users', 'M_Warga']);
        $hashed_pass = password_hash('WargaBaik1!', PASSWORD_BCRYPT);
        $created_count = 0;

        foreach ($warga_tanpa_user as $w) {
            // Generate username unik dari nama & no_blok
            $nama_parts = explode(' ', trim($w->nama_lengkap));
            $first_name = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $nama_parts[0] ?? 'warga'));
            $clean_blok = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $w->no_blok));
            $clean_user = (!empty($first_name) && !empty($clean_blok)) ? $first_name . '_' . $clean_blok : ($first_name ?: $clean_blok);

            if (empty($clean_user) || $clean_user === '_') {
                $clean_user = 'warga_' . $w->id_warga;
            }

            $candidate_user = $clean_user;
            $counter = 1;
            while ($this->db->get_where('users', ['username' => $candidate_user])->num_rows() > 0) {
                $candidate_user = $clean_user . '_' . $counter;
                $counter++;
            }

            $user_data = [
                'username'  => $candidate_user,
                'password'  => $hashed_pass,
                'id_role'   => $id_role_warga,
                'is_active' => 1
            ];
            $this->M_Users->insert_user($user_data);
            $new_user_id = $this->db->insert_id();

            // Kaitkan id_user ke data warga
            $this->M_Warga->update_warga($w->id_warga, ['id_user' => $new_user_id]);
            $created_count++;
        }

        $this->session->set_flashdata('success', 'Berhasil membuat <strong>' . $created_count . ' akun login baru</strong> untuk semua warga yang belum memiliki akun! Password Default: <code>WargaBaik1!</code>');
        redirect($_SERVER['HTTP_REFERER'] ?? 'warga');
    }
}
