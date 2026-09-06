<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class M_Dashboard extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Total Keseluruhan Pemasukan Iuran
     */
    public function get_total_pemasukan() {
        $this->db->select_sum('nominal');
        $query = $this->db->get('pemasukan_iuran');
        return (float) ($query->row()->nominal ?? 0);
    }

    /**
     * Total Keseluruhan Pengeluaran Kas
     */
    public function get_total_pengeluaran() {
        $this->db->select_sum('nominal');
        $query = $this->db->get('pengeluaran_kas');
        return (float) ($query->row()->nominal ?? 0);
    }

    /**
     * Total Pemasukan Iuran Bulan Ini
     */
    public function get_pemasukan_bulan_ini($bulan, $tahun) {
        $this->db->select_sum('nominal');
        $this->db->where('bulan', $bulan);
        $this->db->where('tahun', $tahun);
        $query = $this->db->get('pemasukan_iuran');
        return (float) ($query->row()->nominal ?? 0);
    }

    /**
     * Total Pengeluaran Bulan Ini
     */
    public function get_pengeluaran_bulan_ini($bulan, $tahun) {
        $this->db->select_sum('nominal');
        $this->db->where('MONTH(tgl_pengeluaran)', $bulan);
        $this->db->where('YEAR(tgl_pengeluaran)', $tahun);
        $query = $this->db->get('pengeluaran_kas');
        return (float) ($query->row()->nominal ?? 0);
    }

    /**
     * Data Tren 12 Bulan Terakhir untuk Chart.js
     */
    public function get_chart_data($tahun) {
        $data_pemasukan = array_fill(1, 12, 0);
        $data_pengeluaran = array_fill(1, 12, 0);

        // Pemasukan per bulan
        $this->db->select('bulan, SUM(nominal) as total');
        $this->db->where('tahun', $tahun);
        $this->db->group_by('bulan');
        $query_in = $this->db->get('pemasukan_iuran')->result();
        foreach ($query_in as $row) {
            $data_pemasukan[(int)$row->bulan] = (float)$row->total;
        }

        // Pengeluaran per bulan
        $this->db->select('MONTH(tgl_pengeluaran) as bulan, SUM(nominal) as total');
        $this->db->where('YEAR(tgl_pengeluaran)', $tahun);
        $this->db->group_by('MONTH(tgl_pengeluaran)');
        $query_out = $this->db->get('pengeluaran_kas')->result();
        foreach ($query_out as $row) {
            $data_pengeluaran[(int)$row->bulan] = (float)$row->total;
        }

        return [
            'pemasukan'   => array_values($data_pemasukan),
            'pengeluaran' => array_values($data_pengeluaran)
        ];
    }

    /**
     * Quick status iuran warga per blok pada bulan tertentu
     */
    public function get_quick_status_warga($bulan, $tahun) {
        $this->db->select('w.id_warga, w.nama_lengkap, w.no_blok, w.status_hunian, p.nominal, p.tgl_bayar');
        $this->db->from('warga w');
        $this->db->join('pemasukan_iuran p', "p.id_warga = w.id_warga AND p.bulan = {$bulan} AND p.tahun = {$tahun}", 'left');
        $this->db->order_by('w.no_blok', 'ASC');
        return $this->db->get()->result();
    }
}
