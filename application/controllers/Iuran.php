<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Iuran extends Auth_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['M_Iuran', 'M_Warga']);
        $this->load->library(['form_validation', 'upload']);
    }

    public function index() {
        $tahun = (int) $this->input->get('tahun');
        if (!$tahun) {
            $tahun = (int) date('Y');
        }

        $matriks = $this->M_Iuran->get_matriks_iuran($tahun);

        $data = [
            'page_title' => 'Matriks Rekap Iuran Warga',
            'tahun'      => $tahun,
            'matriks'    => $matriks
        ];
        $this->render('iuran/index', $data);
    }

    public function riwayat() {
        $tahun = $this->input->get('tahun');
        $id_warga = null;

        // Jika login sebagai warga, batasi hanya riwayat miliknya
        if ($this->current_user['role_name'] === 'warga') {
            $id_warga = $this->current_user['id_warga'];
        }

        $riwayat = $this->M_Iuran->get_riwayat_iuran($tahun, $id_warga);

        $data = [
            'page_title' => 'Riwayat Pembayaran Iuran',
            'tahun'      => $tahun,
            'riwayat'    => $riwayat
        ];
        $this->render('iuran/riwayat', $data);
    }

    public function bayar() {
        $this->check_role(['admin', 'pengurus']);

        $this->form_validation->set_rules('id_warga', 'Warga', 'required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric');
        $this->form_validation->set_rules('nominal_per_bulan', 'Nominal Per Bulan', 'required|numeric');
        $this->form_validation->set_rules('tgl_bayar', 'Tanggal Bayar', 'required');
        $this->form_validation->set_rules('bulan[]', 'Pilihan Bulan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data = [
                'page_title' => 'Form Pembayaran Iuran Warga',
                'warga_list' => $this->M_Warga->get_all_warga(),
                'default_warga' => $this->input->get('warga_id')
            ];
            $this->render('iuran/bayar', $data);
        } else {
            $id_warga = $this->input->post('id_warga', TRUE);
            $tahun = $this->input->post('tahun', TRUE);
            $nominal_per_bulan = $this->input->post('nominal_per_bulan', TRUE);
            $tgl_bayar = $this->input->post('tgl_bayar', TRUE);
            $keterangan = $this->input->post('keterangan', TRUE);
            $bulan_array = $this->input->post('bulan');

            // Handle Upload Bukti Bayar sesuai checklist SECURITY.md
            $bukti_bayar_filename = null;
            if (!empty($_FILES['bukti_bayar']['name'])) {
                $config['upload_path']   = './uploads/bukti_bayar/';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config['max_size']      = 5120; // 5MB
                $config['encrypt_name']  = TRUE; // Acak nama file anti directory traversal

                $this->upload->initialize($config);
                if ($this->upload->do_upload('bukti_bayar')) {
                    $upload_data = $this->upload->data();
                    $bukti_bayar_filename = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', 'Gagal upload bukti bayar: ' . $this->upload->display_errors('', ''));
                    redirect('iuran/bayar');
                    return;
                }
            }

            $success = $this->M_Iuran->insert_pembayaran_multibulan(
                $id_warga,
                $bulan_array,
                $tahun,
                $nominal_per_bulan,
                $tgl_bayar,
                $bukti_bayar_filename,
                $keterangan,
                $this->current_user['id_user']
            );

            if ($success) {
                $total_dibayar = count($bulan_array) * $nominal_per_bulan;
                $this->session->set_flashdata('success', 'Pembayaran iuran berhasil dicatat sejumlah Rp ' . number_format($total_dibayar, 0, ',', '.') . ' (' . count($bulan_array) . ' bulan).');
            } else {
                $this->session->set_flashdata('error', 'Terjadi kesalahan saat menyimpan data pembayaran.');
            }

            redirect('iuran?tahun=' . $tahun);
        }
    }

    public function delete($id) {
        $this->check_role(['admin']);
        $this->M_Iuran->delete_iuran($id);
        $this->session->set_flashdata('success', 'Data transaksi iuran berhasil dihapus.');
        redirect('iuran/riwayat');
    }
}
