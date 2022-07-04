<?php
if(defined('basepath')) exit ('No direct access script allowed');

class Unit_kerja extends CI_Controller {
    
    var $message;
    
    function __construct(){
        parent::__construct();
        $this->load->model('GlobalCrud','crud');
        $this->load->model('UnitkerjaDataModel', 'unitkerjadata');
        $this->load->model('PihakDokumenModel', 'pihakdokumendata');
        $this->load->model('PemilikDokumenModel', 'pemilikdokumendata');
        if($this->session->userdata('level') != 1){
            redirect('login');
        }
        $this->form_validation->set_error_delimiters('', '');
    }

    function validation(){
        $this->form_validation->set_rules('nama_unit','Nama Unit','required');
        $this->form_validation->set_rules('kepala_unit','Kepala Unit','required');
        $this->form_validation->set_rules('keterangan','Keterangan','required');
    }
    
    function create(){
        $this->validation();
        if($this->form_validation->run() == FALSE){
            $this->message = "Nama Unit & Kepala Unit Wajib Diisi !";
            $this->session->set_flashdata('warning',$this->message);            
            redirect('admin/unit-kerja');
        } else {
            
            $query = array(
                'nama_unit' => $this->input->post('nama_unit'),
                'kepala_unit' => $this->input->post('kepala_unit'),
                'keterangan' => $this->input->post('keterangan')
            );
            
            $this->crud->insert('unit_kerja',$query);
            $this->message = "Unit Kerja Baru Berhasil Dibuat :)";
            $this->session->set_flashdata('success',$this->message);
            redirect('admin/unit-kerja');
            
        }
    }
    
    function get($id){
        
        $data = array(
            'id_unit' => $id
        );
        
        $result = $this->crud->get('unit_kerja',$data)->row();
        echo json_encode($result);
        
    }
    
    function update(){
        $this->validation();
        if($this->form_validation->run() == FALSE){
            $this->message = "Nama Unit dan Kepala Unit Wajib Diisi !";
            $this->session->set_flashdata('warning',$this->message);            
            redirect('admin/unit-kerja');
        } else {
            $query = array(
                'nama_unit' => $this->input->post('nama_unit'),
                'kepala_unit' => $this->input->post('kepala_unit'),
                'keterangan' => $this->input->post('keterangan')
            );
            
            $this->crud->update('unit_kerja',$query,'id_unit',$this->input->post('id_unit'));
            $this->message = "Unit Kerja Berhasil Diubah :)";
            $this->session->set_flashdata('success',$this->message);
            redirect('admin/unit-kerja');
        }
    }
    
    function destroy($id){
        $q1 = sprintf("SELECT count(id_unit) jml FROM pegawai WHERE id_unit=%d", $id);
        $q2 = sprintf("SELECT count(id_unit) jml FROM jabatan WHERE id_unit=%d", $id);
        $jml1 = $this->db->query($q1)->row_array()['jml'];
        $jml2 = $this->db->query($q2)->row_array()['jml'];
        if ($jml1 == 0 && $jml2 == 0) {
            $this->message = "Unit Kerja Berhasil Dihapus";
            $this->crud->delete('unit_kerja','id_unit',$id);
            $this->session->set_flashdata('success',$this->message);
            redirect('admin/unit-kerja');
        } else {
            $this->message = "Gagal menghapus, unit sedang digunakan";
            $this->session->set_flashdata('warning', $this->message);
            redirect('admin/unit-kerja');
        }
    }

    function unitkerja_list()
    {
        $list = $this->unitkerjadata->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $value->id_unit;
            $row[] = $value->nama_unit;
            $row[] = $value->kepala_unit;
            $row[] = $value->keterangan;
            //add html for action
            $row[] = '<a class="btn btn-sm btn-warning p-2" href="#" title="Edit" onclick="edit_unit(' . "'" . $value->id_unit . "'" . ')"><i class="fa fa-pencil"></i> Edit</a>
            <a class="btn btn-sm btn-danger p-2" href="#" title="Hapus" onClick="delete_unit(' . "'" . $value->id_unit . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->unitkerjadata->count_all(),
            "recordsFiltered" => $this->unitkerjadata->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function unitkerja_edit($id)
    {
        $data = $this->unitkerjadata->get_by_id($id);
        echo json_encode($data);
    }

    function unitkerja_add()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'response' => 'error',
                'error'   => true,
                'nama_unitError' => form_error('nama_unit'),
                'kepala_unitError' => form_error('kepala_unit'),
                'keteranganError' => form_error('keterangan'),
                'message' => validation_errors(),
            );
        } else {
            $data = array(
                'nama_unit' => $this->input->post('nama_unit'),
                'kepala_unit' => $this->input->post('kepala_unit'),
                'keterangan' => $this->input->post('keterangan'),
                'created_at' => date('Y-m-d H:i:s'),
            );
            $insert = $this->unitkerjadata->save($data);
        }
        echo json_encode($data);
    }

    function unitkerja_update()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'response' => 'error',
                'error'   => true,
                'nama_unitError' => form_error('nama_unit'),
                'kepala_unitError' => form_error('kepala_unit'),
                'keteranganError' => form_error('keterangan'),
                'message' => validation_errors(),
            );
        } else {
            $data = array(
                'nama_unit' => $this->input->post('nama_unit'),
                'kepala_unit' => $this->input->post('kepala_unit'),
                'keterangan' => $this->input->post('keterangan'),
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $this->unitkerjadata->update(array('id_unit' => $this->input->post('id_unit')), $data);
        }
        echo json_encode($data);
    }

    function unitkerja_delete($id)
    {
        $this->unitkerjadata->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    function get_unit_kerja_list()
    {
        $data = $this->unitkerjadata->get_data_unitkerja();
        
		echo json_encode($data);
    }

    function get_pihak_list($id_dokumen)
    {
        $data = $this->pihakdokumendata->get_list_pihak_by_id_document($id_dokumen);
        
		echo json_encode($data);
    }
}