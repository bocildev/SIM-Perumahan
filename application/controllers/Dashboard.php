<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Dashboard extends Auth_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_Dashboard');
    }

    public function index() {
        $bulan_ini = (int) date('m');
        $tahun_ini = (int) date('Y');

        $total_in = $this->M_Dashboard->get_total_pemasukan();
        $total_out = $this->M_Dashboard->get_total_pengeluaran();
        $saldo_kas = $total_in - $total_out;

        $in_bulan_ini = $this->M_Dashboard->get_pemasukan_bulan_ini($bulan_ini, $tahun_ini);
        $out_bulan_ini = $this->M_Dashboard->get_pengeluaran_bulan_ini($bulan_ini, $tahun_ini);

        $chart_data = $this->M_Dashboard->get_chart_data($tahun_ini);
        $quick_status = $this->M_Dashboard->get_quick_status_warga($bulan_ini, $tahun_ini);

        $data = [
            'page_title'     => 'Dashboard Keuangan',
            'saldo_kas'      => $saldo_kas,
            'total_in'       => $total_in,
            'total_out'      => $total_out,
            'in_bulan_ini'   => $in_bulan_ini,
            'out_bulan_ini'  => $out_bulan_ini,
            'chart_data'     => $chart_data,
            'quick_status'   => $quick_status,
            'bulan_ini'      => $bulan_ini,
            'tahun_ini'      => $tahun_ini
        ];

        $this->render('dashboard/index', $data);
    }
}
