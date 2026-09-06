<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class M_Iuran extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Mengambil matriks iuran 12 bulan untuk seluruh warga pada tahun tertentu
     */
    public function get_matriks_iuran($tahun) {
        // 1. Ambil seluruh data warga
        $this->db->order_by('no_blok', 'ASC');
        $warga_list = $this->db->get('warga')->result();

        // 2. Ambil data transaksi iuran di tahun tersebut
        $this->db->where('tahun', $tahun);
        $iuran_records = $this->db->get('pemasukan_iuran')->result();

        // 3. Mapping data per warga dan per bulan
        $iuran_map = [];
        foreach ($iuran_records as $rec) {
            $iuran_map[$rec->id_warga][$rec->bulan] = $rec;
        }

        $result = [];
        foreach ($warga_list as $w) {
            $bulan_status = [];
            for ($b = 1; $b <= 12; $b++) {
                $bulan_status[$b] = $iuran_map[$w->id_warga][$b] ?? null;
            }
            $result[] = [
                'warga' => $w,
                'bulan' => $bulan_status
            ];
        }

        return $result;
    }

    /**
     * Ambil riwayat pembayaran iuran lengkap
     */
    public function get_riwayat_iuran($tahun = null, $id_warga = null) {
        $this->db->select('p.*, w.nama_lengkap, w.no_blok, u.username as pencatat');
        $this->db->from('pemasukan_iuran p');
        $this->db->join('warga w', 'w.id_warga = p.id_warga');
        $this->db->join('users u', 'u.id_user = p.created_by', 'left');

        if ($tahun) {
            $this->db->where('p.tahun', $tahun);
        }
        if ($id_warga) {
            $this->db->where('p.id_warga', $id_warga);
        }

        $this->db->order_by('p.tgl_bayar', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Simpan pembayaran iuran multi-bulan
     */
    public function insert_pembayaran_multibulan($id_warga, $bulan_array, $tahun, $nominal_per_bulan, $tgl_bayar, $bukti_bayar, $keterangan, $created_by) {
        $this->db->trans_start();
        foreach ($bulan_array as $bulan) {
            // Cek apakah sudah pernah bayar sebelumnya
            $this->db->where('id_warga', $id_warga);
            $this->db->where('bulan', $bulan);
            $this->db->where('tahun', $tahun);
            $existing = $this->db->get('pemasukan_iuran')->row();

            if ($existing) {
                // Update
                $this->db->where('id_pemasukan', $existing->id_pemasukan);
                $this->db->update('pemasukan_iuran', [
                    'nominal'     => $nominal_per_bulan,
                    'tgl_bayar'   => $tgl_bayar,
                    'bukti_bayar' => $bukti_bayar ? $bukti_bayar : $existing->bukti_bayar,
                    'keterangan'  => $keterangan,
                    'created_by'  => $created_by
                ]);
            } else {
                // Insert baru
                $this->db->insert('pemasukan_iuran', [
                    'id_warga'    => $id_warga,
                    'bulan'       => $bulan,
                    'tahun'       => $tahun,
                    'nominal'     => $nominal_per_bulan,
                    'tgl_bayar'   => $tgl_bayar,
                    'bukti_bayar' => $bukti_bayar,
                    'keterangan'  => $keterangan,
                    'created_by'  => $created_by
                ]);
            }
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * Hapus transaksi iuran
     */
    public function delete_iuran($id_pemasukan) {
        $this->db->where('id_pemasukan', $id_pemasukan);
        return $this->db->delete('pemasukan_iuran');
    }
}
