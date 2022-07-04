<?php

class GlobalCrud extends CI_Model
{

    function all($table)
    {
        return $this->db->get($table);
    }

    function get($table, $id)
    {
        return $this->db->get_where($table, $id);
    }

    function insert($table, $query = [])
    {
        return $this->db->insert($table, $query);
    }

    function delete($table, $column, $id)
    {
        $this->db->where($column, $id);
        return $this->db->delete($table);
    }

    function update($table, $query, $column, $id)
    {
        $this->db->where($column, $id);
        return $this->db->update($table, $query);
    }

    function count_table($table)
    {
        return $this->db->count_all($table);
    }

    function twoTablesFusion($table1, $table2, $select, $clause)
    {
        $this->db->select($select);
        $this->db->from($table1);
        $this->db->join($table2, $clause);
        return $this->db->get();
    }

    function view_eksternal_jenis()
    {
        $query = $this->db->query("SELECT DISTINCT
        `jenis_surat`.`nama_jenis` AS 'jenis_surat', (SELECT COUNT(0) FROM `surat_eksternal` WHERE (`surat_eksternal`.`id_jenis` = `jenis_surat`.`id_jenis`)) AS 'jumlah' FROM `jenis_surat`");
        return $query;
    }

    function view_eksternal_media()
    {
        $query = $this->db->query("SELECT DISTINCT
        `media_surat`.`nama_media` AS 'media_surat', (SELECT COUNT(0) FROM `surat_eksternal` WHERE (`surat_eksternal`.`id_media` = `media_surat`.`id_media`)) AS 'jumlah' FROM `media_surat`");
        return $query;
    }

    function view_eksternal_prioritas()
    {
        $query = $this->db->query("SELECT DISTINCT
        `prioritas_surat`.`nama_prioritas` AS 'prioritas_surat', (SELECT COUNT(0) FROM `surat_eksternal` WHERE (`surat_eksternal`.`id_prioritas` = `prioritas_surat`.`id_prioritas`)) AS 'jumlah' FROM `prioritas_surat`");
        return $query;
    }

    function view_eksternal_sifat()
    {
        $query = $this->db->query("SELECT DISTINCT
        `sifat_surat`.`nama_sifat` AS 'sifat_surat', (SELECT COUNT(0) FROM `surat_eksternal` WHERE (`surat_eksternal`.`id_sifat` = `sifat_surat`.`id_sifat`)) AS 'jumlah' FROM `sifat_surat`");
        return $query;
    }

    function view_internal_jenis()
    {
        $query = $this->db->query("SELECT DISTINCT
        `jenis_surat`.`nama_jenis` AS 'jenis_surat'
        , (SELECT COUNT(*) FROM `arsip_dokumen` WHERE (`arsip_dokumen`.`id_jenis` = `jenis_surat`.`id_jenis`)) AS 'jumlah' 
FROM `jenis_surat`");
        return $query;
    }

    function view_internal_media()
    {
        $query = $this->db->query("SELECT DISTINCT
        `media_surat`.`nama_media` AS 'media_surat', (SELECT COUNT(0) FROM `surat_internal` WHERE (`surat_internal`.`id_media` = `media_surat`.`id_media`)) AS 'jumlah' FROM `media_surat`");
        return $query;
    }

    function view_internal_prioritas()
    {
        $query = $this->db->query("SELECT DISTINCT
        `prioritas_surat`.`nama_prioritas` AS 'prioritas_surat', (SELECT COUNT(0) FROM `surat_internal` WHERE (`surat_internal`.`id_prioritas` = `prioritas_surat`.`id_prioritas`)) AS 'jumlah' FROM `prioritas_surat`");
        return $query;
    }

    function view_internal_sifat()
    {
        $query = $this->db->query("SELECT DISTINCT
            `sifat_surat`.`nama_sifat` AS 'sifat_surat'
            , (SELECT COUNT(*) FROM `arsip_dokumen` WHERE (`arsip_dokumen`.`id_sifat` = `sifat_surat`.`id_sifat`)) AS 'jumlah' 
            FROM `sifat_surat`");
        return $query;
    }
}
