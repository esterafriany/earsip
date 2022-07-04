<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PemilikDokumenModel extends CI_Model
{
    var $table = 'pemilik_dokumen';
    var $column = array('id', 'id_dokumen', 'id_unit');

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->search = '';
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function delete_by_id_document($id)
    {
        $this->db->where('id_dokumen', $id);
        $this->db->delete($this->table);
    }

    public function get_list_owner_by_id_document($id)
    {
        $this->db->select("{$this->table}.*, unit_kerja.nama_unit") ;
        $this->db->from($this->table);
        $this->db->join("arsip_dokumen","arsip_dokumen.id_dokumen = {$this->table}.id_dokumen");
        $this->db->join("unit_kerja","unit_kerja.id_unit = {$this->table}.id_unit_kerja");
        $this->db->where('pemilik_dokumen.id_dokumen', $id);
        $query = $this->db->get();

        return $query->result();
    }

}
