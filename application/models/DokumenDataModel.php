<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DokumenDataModel extends CI_Model
{
    var $table = 'arsip_dokumen';
    var $column = array('id_dokumen', 'nama_dokumen', 'nomor_dokumen', 'id_sifat' , 'id_jenis', 'dari' , 'tujuan',  'tanggal_dokumen', 'keterangan' , 'perihal' , 'nomor_disposisi', 'file_name', 'file_path' , 'created_by' , 'created_at', 'updated_by' , 'updated_at');
    var $order = array('id_dokumen' => 'desc');

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->search = '';
    }

    private function _get_datatables_query($term = '')
    {
        //$this->db->from($this->table);

        $this->db->select("{$this->table}.*, jenis_surat.id_jenis, jenis_surat.nama_jenis, user.id_user, user.name, pegawai.nama_pegawai") ;
        $this->db->from($this->table);
        $this->db->join("jenis_surat","jenis_surat.id_jenis = {$this->table}.id_jenis");
        $this->db->join("user","user.id_user = {$this->table}.created_by");
        $this->db->join("pegawai","pegawai.id_pegawai = user.id_pegawai");
        $this->db->like("jenis_surat.nama_jenis", $term);
        $this->db->or_like("user.name", $term);
        $this->db->or_like("nomor_dokumen", $term);
        $this->db->or_like("nomor_dokumen", $term);
        $this->db->or_like("tanggal_dokumen", $term);
        $this->db->or_like("pegawai.nama_pegawai", $term);

        $i = 0;

        foreach ($this->column as $item) {
            if ($_POST['search']['value']) ($i === 0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
            $column[$i] = $item;
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables(){
        $term = $_REQUEST['search']['value'];
        $this->_get_datatables_query($term);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    private function _get_datatables_query_test()
    {
        //$this->db->from($this->table);

        $this->db->select("{$this->table}.*, jenis_surat.id_jenis, jenis_surat.nama_jenis, user.id_user, user.name, pegawai.nama_pegawai") ;
        $this->db->from($this->table);
        $this->db->join("jenis_surat","jenis_surat.id_jenis = {$this->table}.id_jenis");
        $this->db->join("user","user.id_user = {$this->table}.created_by");
        $this->db->join("pegawai","pegawai.id_pegawai = user.id_pegawai");

        $i = 0;

        foreach ($this->column as $item) {
            if ($_POST['search']['value']) ($i === 0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
            $column[$i] = $item;
            $i++;
        }

        
        if (isset($_POST['order'])) {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_test()
    {
        $this->_get_datatables_query_test();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function total_records_with_filter(){
        $this->db->select("{$this->table}.*") ;
    
        $query = $this->db->get();
        return $query->countAllResults();
    }

    function total_records($searchValue,$columnName,$columnSortOrder,$rowperpage, $start){
        $this->db->select('arsip_dokumen.id_dokumen
        , arsip_dokumen.nama_dokumen
        , arsip_dokumen.nomor_dokumen
        , jenis_surat.nama_jenis
        , arsip_dokumen.tanggal_dokumen
        , pegawai.nama_pegawai') ;
        $this->db->from($this->table);
        $this->db->join('jenis_surat', 'jenis_surat.id_jenis = arsip_dokumen.id_jenis');
        $this->db->join('user', 'user.id_user = arsip_dokumen.created_by');
        $this->db->join('pegawai', 'pegawai.id_pegawai = user.id_pegawai');
                
        $this->db->orLike('pegawai.nama_pegawai', $searchValue);
        $this->db->orderBy($columnName,$columnSortOrder);
        

        return $this->db->findAll($rowperpage, $start);  
    }


    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_by_id($id)
    {
        $this->db->select("{$this->table}.*, jenis_surat.id_jenis, jenis_surat.nama_jenis") ;
        $this->db->from($this->table);
        $this->db->join("jenis_surat","jenis_surat.id_jenis = {$this->table}.id_jenis");
        $this->db->where('id_dokumen', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_detail_document($id)
    {
        $this->db->select("{$this->table}.*, jenis_surat.id_jenis, jenis_surat.nama_jenis, sifat_surat.nama_sifat, user.name as created_by_name") ;
        $this->db->from($this->table);
        $this->db->join("jenis_surat","jenis_surat.id_jenis = {$this->table}.id_jenis");
        $this->db->join("sifat_surat","jenis_surat.id_jenis = {$this->table}.id_jenis");
        $this->db->join("user","user.id_user = {$this->table}.created_by");
        $this->db->where('id_dokumen', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id)
    {
        $this->db->where('id_dokumen', $id);
        $this->db->delete($this->table);
    }

    public function get_by_id_view($id)
    {
        $this->db->select("{$this->table}.*, jenis_surat.id_jenis, jenis_surat.nama_jenis") ;
        $this->db->from($this->table);
        $this->db->join("jenis_surat","jenis_surat.id_jenis = {$this->table}.id_jenis");
        $this->db->where('id_dokumen', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $results = $query->result();
        }
        return $results;
    }

    public function get_list_document()
    {
        $this->db->select("{$this->table}.*, jenis_surat.nama_jenis, pegawai.nama_pegawai") ;
        $this->db->from($this->table);
        $this->db->join("jenis_surat","jenis_surat.id_jenis = {$this->table}.id_jenis");
        $this->db->join("user","user.id_user = {$this->table}.created_by");
        $this->db->join("pegawai","pegawai.id_pegawai = user.id_pegawai");

        $query = $this->db->get();
        return $query->result();
    }
}
