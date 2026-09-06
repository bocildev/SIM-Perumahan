<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Laporan extends Auth_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['M_Iuran', 'M_Pengeluaran', 'M_Dashboard']);
    }

    public function index() {
        $bulan = $this->input->get('bulan') ? (int)$this->input->get('bulan') : (int)date('m');
        $tahun = $this->input->get('tahun') ? (int)$this->input->get('tahun') : (int)date('Y');

        // Pemasukan pada periode bulan & tahun tersebut
        $this->db->select('p.*, w.nama_lengkap, w.no_blok');
        $this->db->from('pemasukan_iuran p');
        $this->db->join('warga w', 'w.id_warga = p.id_warga');
        $this->db->where('p.bulan', $bulan);
        $this->db->where('p.tahun', $tahun);
        $pemasukan_list = $this->db->get()->result();

        // Pengeluaran pada periode bulan & tahun tersebut
        $this->db->select('p.*, k.nama_kategori');
        $this->db->from('pengeluaran_kas p');
        $this->db->join('kategori_pengeluaran k', 'k.id_kategori = p.id_kategori');
        $this->db->where('MONTH(p.tgl_pengeluaran)', $bulan);
        $this->db->where('YEAR(p.tgl_pengeluaran)', $tahun);
        $pengeluaran_list = $this->db->get()->result();

        $total_in = 0;
        foreach ($pemasukan_list as $in) {
            $total_in += $in->nominal;
        }

        $total_out = 0;
        foreach ($pengeluaran_list as $out) {
            $total_out += $out->nominal;
        }

        $selisih = $total_in - $total_out;

        $data = [
            'page_title'       => 'Laporan Rekapitulasi Kas Keuangan',
            'bulan'            => $bulan,
            'tahun'            => $tahun,
            'pemasukan_list'   => $pemasukan_list,
            'pengeluaran_list' => $pengeluaran_list,
            'total_in'         => $total_in,
            'total_out'        => $total_out,
            'selisih'          => $selisih,
            'saldo_kas_total'  => $this->M_Dashboard->get_total_pemasukan() - $this->M_Dashboard->get_total_pengeluaran()
        ];

        $this->render('laporan/index', $data);
    }
}
