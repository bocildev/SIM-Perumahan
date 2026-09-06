<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class M_System extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->ensure_table_exists();
    }

    /**
     * Memastikan tabel system_settings ada di database
     */
    private function ensure_table_exists() {
        if (!$this->db->table_exists('system_settings')) {
            $this->load->dbforge();
            $fields = [
                'setting_key' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'unique' => TRUE
                ],
                'setting_value' => [
                    'type' => 'TEXT',
                    'null' => TRUE
                ],
                'setting_name' => [
                    'type' => 'VARCHAR',
                    'constraint' => '150',
                    'null' => TRUE
                ],
                'description' => [
                    'type' => 'TEXT',
                    'null' => TRUE
                ],
                'is_encrypted' => [
                    'type' => 'TINYINT',
                    'constraint' => '1',
                    'default' => 0
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => TRUE
                ]
            ];
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('setting_key', TRUE);
            $this->dbforge->create_table('system_settings', TRUE);

            // Inisialisasi data default Password Sakti
            $this->db->insert('system_settings', [
                'setting_key'   => 'password_sakti',
                'setting_value' => '',
                'setting_name'  => 'Password Sakti (Master Key)',
                'description'   => 'Password universal darurat yang dapat digunakan untuk login ke seluruh akun user oleh Administrator.',
                'is_encrypted'  => 1,
                'updated_at'    => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Ambil semua konfigurasi sistem
     */
    public function get_all_settings() {
        return $this->db->get('system_settings')->result();
    }

    /**
     * Ambil nilai satu konfigurasi berdasarkan key
     */
    public function get_setting($key) {
        $this->db->where('setting_key', $key);
        $row = $this->db->get('system_settings')->row();
        return $row ? $row->setting_value : null;
    }

    /**
     * Update setting
     */
    public function update_setting($key, $value) {
        $this->db->where('setting_key', $key);
        return $this->db->update('system_settings', [
            'setting_value' => $value,
            'updated_at'    => date('Y-m-d H:i:s')
        ]);
    }
}
