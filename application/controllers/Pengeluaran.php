<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Pengeluaran extends Auth_Controller {

    public function __construct() {
        parent::__construct();
        $this->check_role(['admin', 'pengurus']);
        $this->load->model('M_Pengeluaran');
        $this->load->library(['form_validation', 'upload']);
    }

    public function index() {
        $filter = [
            'id_kategori' => $this->input->get('id_kategori'),
            'tgl_mulai'   => $this->input->get('tgl_mulai'),
            'tgl_selesai' => $this->input->get('tgl_selesai')
        ];

        $pengeluaran_list = $this->M_Pengeluaran->get_pengeluaran_list($filter);
        $kategori_list = $this->M_Pengeluaran->get_all_kategori();

        $total_nominal = 0;
        foreach ($pengeluaran_list as $p) {
            $total_nominal += $p->nominal;
        }

        $data = [
            'page_title'       => 'Pengeluaran Kas Operasional',
            'pengeluaran_list' => $pengeluaran_list,
            'kategori_list'    => $kategori_list,
            'filter'           => $filter,
            'total_nominal'    => $total_nominal
        ];
        $this->render('pengeluaran/index', $data);
    }

    public function create() {
        $this->form_validation->set_rules('id_kategori', 'Kategori', 'required');
        $this->form_validation->set_rules('nominal', 'Nominal', 'required|numeric');
        $this->form_validation->set_rules('tgl_pengeluaran', 'Tanggal Pengeluaran', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan Pengeluaran', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data = [
                'page_title'    => 'Catat Pengeluaran Kas',
                'kategori_list' => $this->M_Pengeluaran->get_all_kategori()
            ];
            $this->render('pengeluaran/create', $data);
        } else {
            // Upload Nota / Struk Bukti Pengeluaran
            $bukti_nota_filename = null;
            if (!empty($_FILES['bukti_nota']['name'])) {
                $config['upload_path']   = './uploads/nota/';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config['max_size']      = 5120;
                $config['encrypt_name']  = TRUE;

                $this->upload->initialize($config);
                if ($this->upload->do_upload('bukti_nota')) {
                    $upload_data = $this->upload->data();
                    $bukti_nota_filename = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', 'Gagal upload nota: ' . $this->upload->display_errors('', ''));
                    redirect('pengeluaran/create');
                    return;
                }
            }

            $data_insert = [
                'id_kategori'     => $this->input->post('id_kategori', TRUE),
                'nominal'         => $this->input->post('nominal', TRUE),
                'tgl_pengeluaran' => $this->input->post('tgl_pengeluaran', TRUE),
                'keterangan'      => $this->input->post('keterangan', TRUE),
                'bukti_nota'      => $bukti_nota_filename,
                'created_by'      => $this->current_user['id_user']
            ];

            $this->M_Pengeluaran->insert_pengeluaran($data_insert);
            $this->session->set_flashdata('success', 'Data pengeluaran kas berhasil disimpan.');
            redirect('pengeluaran');
        }
    }

    public function kategori() {
        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required|trim');
        if ($this->form_validation->run() == TRUE) {
            $nama_kategori = $this->input->post('nama_kategori', TRUE);
            $this->M_Pengeluaran->insert_kategori($nama_kategori);
            $this->session->set_flashdata('success', 'Kategori pengeluaran baru berhasil ditambahkan.');
        }
        redirect('pengeluaran');
    }

    public function delete($id) {
        $this->check_role(['admin']);
        $this->M_Pengeluaran->delete_pengeluaran($id);
        $this->session->set_flashdata('success', 'Data pengeluaran kas berhasil dihapus.');
        redirect('pengeluaran');
    }
}
