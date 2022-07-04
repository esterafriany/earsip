<?php
if(defined('basepath')) exit ('No direct access script allowed');

class Sifat_surat extends CI_Controller {
    
    var $message;
    
    function __construct(){
        parent::__construct();
        $this->load->model('GlobalCrud','crud');
        $this->load->model('SifatDataModel', 'sifat');
        if($this->session->userdata('level') != 1){
            redirect('login');
        }
        $this->form_validation->set_error_delimiters('', '');
    }

    function validation(){
        $this->form_validation->set_rules('nama_sifat','Nama Sifat','required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
    }
    
    function create(){
        $this->validation();
        if($this->form_validation->run() == FALSE){
            $this->message = "Sifat Surat Wajib Diisi !";
            $this->session->set_flashdata('warning',$this->message);            
            redirect('admin/sifat-surat');
        } else {
            
            $query = array(
                'nama_sifat' => $this->input->post('nama_sifat'),
                'keterangan' => $this->input->post('keterangan')
            );
            
            $this->crud->insert('sifat_surat',$query);
            $this->message = "Sifat Surat Baru Berhasil Dibuat :)";
            $this->session->set_flashdata('success',$this->message);
            redirect('admin/sifat-surat');
            
        }
    }
    
    function get($id){
        
        $data = array(
            'id_sifat' => $id
        );
        
        $result = $this->crud->get('sifat_surat',$data)->row();
        echo json_encode($result);
        
    }
    
    function update(){
        $this->validation();
        if($this->form_validation->run() == FALSE){
            $this->message = "Sifat Surat Wajib Diisi !";
            $this->session->set_flashdata('warning',$this->message);            
            redirect('admin/sifat-surat');
        } else {
            $query = array(
                'nama_sifat' => $this->input->post('nama_sifat'),
                'keterangan' => $this->input->post('keterangan')
            );
            
            $this->crud->update('sifat_surat',$query,'id_sifat',$this->input->post('id_sifat'));
            $this->message = "Sifat Surat Berhasil Diubah :)";
            $this->session->set_flashdata('success',$this->message);
            redirect('admin/sifat-surat');
        }
    }
    
    function destroy($id){
        $q1 = sprintf("SELECT count(id_sifat) jml FROM surat_eksternal WHERE id_sifat=%d", $id);
        $q2 = sprintf("SELECT count(id_sifat) jml FROM surat_internal WHERE id_sifat=%d", $id);
        $jml1 = $this->db->query($q1)->row_array()['jml'];
        $jml2 = $this->db->query($q2)->row_array()['jml'];
        if ($jml1 == 0 && $jml2 == 0) {
            $this->message = "Sifat Surat Berhasil Dihapus";
            $this->crud->delete('sifat_surat','id_sifat',$id);
            $this->session->set_flashdata('success',$this->message);
            redirect('admin/sifat-surat');
        } else {
            $this->message = "Gagal menghapus, sifat sedang digunakan";
            $this->session->set_flashdata('warning', $this->message);
            redirect('admin/sifat-surat');
        }
    
        
    }

    function sifat_list()
    {
        $list = $this->sifat->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $value->id_sifat;
            $row[] = $value->nama_sifat;
            $row[] = $value->keterangan;
            //add html for action
            $row[] = '<a class="btn btn-sm btn-warning p-2" href="#" title="Edit" onclick="edit_sifat(' . "'" . $value->id_sifat . "'" . ')"><i class="fa fa-pencil"></i> Edit</a>
            <a class="btn btn-sm btn-danger p-2" href="#" title="Hapus" onClick="delete_sifat(' . "'" . $value->id_sifat . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->sifat->count_all(),
            "recordsFiltered" => $this->sifat->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function sifat_edit($id)
    {
        $data = $this->sifat->get_by_id($id);
        echo json_encode($data);
    }

    function sifat_add()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'response' => 'error',
                'error'   => true,
                'nama_sifatError' => form_error('nama_sifat'),
                'keteranganError' => form_error('keterangan'),
                'message' => validation_errors(),
            );
        } else {
            $data = array(
                'nama_sifat' => $this->input->post('nama_sifat'),
                'keterangan' => $this->input->post('keterangan'),
                'created_at' => date('Y-m-d H:i:s'),
            );
            $insert = $this->sifat->save($data);
        }
        echo json_encode($data);
    }

    function sifat_update()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'response' => 'error',
                'error'   => true,
                'nama_sifatError' => form_error('nama_sifat'),
                'keteranganError' => form_error('keterangan'),
                'message' => validation_errors(),
            );
        } else {
            $data = array(
                'nama_sifat' => $this->input->post('nama_sifat'),
                'keterangan' => $this->input->post('keterangan'),
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $this->sifat->update(array('id_sifat' => $this->input->post('id_sifat')), $data);
        }
        echo json_encode($data);
    }

    function sifat_delete($id)
    {
        $q1 = sprintf("SELECT count(id_sifat) jml FROM surat_eksternal WHERE id_sifat=%d", $id);
        $q2 = sprintf("SELECT count(id_sifat) jml FROM surat_internal WHERE id_sifat=%d", $id);
        $jml1 = $this->db->query($q1)->row_array()['jml'];
        $jml2 = $this->db->query($q2)->row_array()['jml'];
        if ($jml1 == 0 && $jml2 == 0) {
            $this->sifat->delete_by_id($id);
            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array('response' => 'error', "error" => TRUE));
        }
    }
}