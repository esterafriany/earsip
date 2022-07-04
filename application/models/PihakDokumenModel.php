<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PihakDokumenModel extends CI_Model
{
    var $table = 'pihak_dokumen';
    var $column = array('id', 'id_dokumen', 'pihak');

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

    public function get_list_pihak_by_id_document($id)
    {
        $this->db->select("{$this->table}.*") ;
        $this->db->from($this->table);
        $this->db->join("arsip_dokumen","arsip_dokumen.id_dokumen = {$this->table}.id_dokumen");
        $this->db->where('arsip_dokumen.id_dokumen', $id);
        $query = $this->db->get();

        return $query->result();
    }

    public function delete_by_id_document($id)
    {
        $this->db->where('id_dokumen', $id);
        $this->db->delete($this->table);
    }



}
