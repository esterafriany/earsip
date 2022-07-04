<?php
if(defined('basepath')) exit ('No direct access script allowed');

class Jabatan extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('GlobalCrud','crud');
        $this->load->model('JabatanDataModel', 'jabatandata');
        if($this->session->userdata('level') != 1){
            redirect('login');
        }
        $this->form_validation->set_error_delimiters('', '');
    }

    function validation(){
        $this->form_validation->set_rules('nama_jabatan','Nama Jabatan','required');
        $this->form_validation->set_rules('keterangan','Keterangan','required');
        $this->form_validation->set_rules('id_unit','Unit Kerja','required');
    }
    
    function create(){
        $this->validation();
        if($this->form_validation->run() == FALSE){
            $this->message = "Nama Jabatan & Unit Kerja Wajib Diisi !";
            $this->session->set_flashdata('warning',$this->message);            
            redirect('admin/jabatan');
        } else {
            
            $query = array(
                'nama_jabatan' => $this->input->post('nama_jabatan'),
                'id_unit' => $this->input->post('id_unit'),
                'keterangan' => $this->input->post('keterangan')
            );
            
            $this->crud->insert('jabatan',$query);
            $this->message = "Jabatan Baru Berhasil Dibuat :)";
            $this->session->set_flashdata('success',$this->message);
            redirect('admin/jabatan');
            
        }
    }
    
    function get($id){
        
        $data = array(
            'id_jabatan' => $id
        );
        
        $result = $this->crud->get('jabatan',$data)->row();
        echo json_encode($result);
        
    }
    
    function update(){
        $this->validation();
        if($this->form_validation->run() == FALSE){
            $this->message = "Jabatan Wajib Diisi !";
            $this->session->set_flashdata('warning',$this->message);            
            redirect('admin/jabatan');
        } else {
            $query = array(
                'nama_jabatan' => $this->input->post('nama_jabatan'),
                'id_unit' => $this->input->post('id_unit'),
                'keterangan' => $this->input->post('keterangan')
            );
            
            $this->crud->update('jabatan',$query,'id_jabatan',$this->input->post('id_jabatan'));
            $this->message = "Jabatan Berhasil Diubah :)";
            $this->session->set_flashdata('success',$this->message);
            redirect('admin/jabatan');
        }
    }
    
    function destroy($id){
        $q1 = sprintf("SELECT count(id_jabatan) jml FROM pegawai WHERE id_jabatan=%d", $id);
        $jml1 = $this->db->query($q1)->row_array()['jml'];
        if ($jml1 == 0) {
            $this->message = "Jabatan Berhasil Dihapus";
            $this->crud->delete('jabatan','id_jabatan',$id);
            $this->session->set_flashdata('success',$this->message);
            redirect('admin/jabatan');
        } else {
            $this->message = "Gagal menghapus, jabatan sedang digunakan";
            $this->session->set_flashdata('warning', $this->message);
            redirect('admin/jabatan');
        }
    }

    function jabatan_list()
    {
        $list = $this->jabatandata->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $value->id_jabatan;
            $row[] = $value->nama_jabatan;
            $row[] = $value->keterangan;
            $row[] = $value->nama_unit;
            //add html for action
            $row[] = '<a class="btn btn-sm btn-warning p-2" href="#" title="Edit" onclick="edit_jabatan(' . "'" . $value->id_jabatan . "'" . ')"><i class="fa fa-pencil"></i> Edit</a>
            <a class="btn btn-sm btn-danger p-2" href="#" title="Hapus" onClick="delete_jabatan(' . "'" . $value->id_jabatan . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->jabatandata->count_all(),
            "recordsFiltered" => $this->jabatandata->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function jabatan_edit($id)
    {
        $data = $this->jabatandata->get_by_id($id);
        echo json_encode($data);
    }

    function jabatan_add()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'response' => 'error',
                'error'   => true,
                'nama_jabatanError' => form_error('nama_jabatan'),
                'keteranganError' => form_error('keterangan'),
                'id_unitError' => form_error('id_unit'),
                'message' => validation_errors(),
            );
        } else {
            $data = array(
                'nama_jabatan' => $this->input->post('nama_jabatan'),
                'keterangan' => $this->input->post('keterangan'),
                'id_unit' => $this->input->post('id_unit'),
            );
            $insert = $this->jabatandata->save($data);
        }
        echo json_encode($data);
    }

    function jabatan_update()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'response' => 'error',
                'error'   => true,
                'nama_jabatanError' => form_error('nama_jabatan'),
                'keteranganError' => form_error('keterangan'),
                'id_unitError' => form_error('id_unit'),
                'message' => validation_errors(),
            );
        } else {
            $data = array(
                'nama_jabatan' => $this->input->post('nama_jabatan'),
                'keterangan' => $this->input->post('keterangan'),
                'id_unit' => $this->input->post('id_unit'),
            );
            $this->jabatandata->update(array('id_jabatan' => $this->input->post('id_jabatan')), $data);
        }
        echo json_encode($data);
    }

    function jabatan_delete($id)
    {
        $this->jabatandata->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    
}