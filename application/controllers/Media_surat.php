<?php
if(defined('basepath')) exit ('No direct access script allowed');

class Media_surat extends CI_Controller {
    
    var $message;
    
    function __construct(){
        parent::__construct();
        $this->load->model('GlobalCrud','crud');
        $this->load->model('MediaDataModel', 'media');
        if($this->session->userdata('level') != 1){
            redirect('login');
        }
        $this->form_validation->set_error_delimiters('', '');
    }

    function validation(){
        $this->form_validation->set_rules('nama_media','Media Surat','required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
    }
    
    function create(){
        $this->validation();
        if($this->form_validation->run() == FALSE){
            $this->message = "Media Pengiriman Surat Wajib Diisi !";
            $this->session->set_flashdata('warning',$this->message);            
            redirect('admin/media-surat');
        } else {
            
            $query = array(
                'nama_media' => $this->input->post('nama_media'),
                'keterangan' => $this->input->post('keterangan')
            );
            
            $this->crud->insert('media_surat',$query);
            $this->message = "Media Pengiriman Surat Baru Berhasil Dibuat :)";
            $this->session->set_flashdata('success',$this->message);
            redirect('admin/media-surat');
            
        }
    }
    
    function get($id){
        
        $data = array(
            'id_media' => $id
        );
        
        $result = $this->crud->get('media_surat',$data)->row();
        echo json_encode($result);
        
    }
    
    function update(){
        $this->validation();
        if($this->form_validation->run() == FALSE){
            $this->message = "Media Pengiriman Surat Wajib Diisi !";
            $this->session->set_flashdata('warning',$this->message);            
            redirect('admin/media-surat');
        } else {
            $query = array(
                'nama_media' => $this->input->post('nama_media'),
                'keterangan' => $this->input->post('keterangan')
            );
            
            $this->crud->update('media_surat',$query,'id_media',$this->input->post('id_media'));
            $this->message = "Media Pengiriman Surat Berhasil Diubah :)";
            $this->session->set_flashdata('success',$this->message);
            redirect('admin/media-surat');
        }
    }
    
    function destroy($id){
        $q1 = sprintf("SELECT count(id_media) jml FROM surat_eksternal WHERE id_media=%d", $id);
        $q2 = sprintf("SELECT count(id_media) jml FROM surat_internal WHERE id_media=%d", $id);
        $jml1 = $this->db->query($q1)->row_array()['jml'];
        $jml2 = $this->db->query($q2)->row_array()['jml'];
        if ($jml1 == 0 && $jml2 == 0) {
            $this->message = "Media Pengiriman Surat Berhasil Dihapus";
            $this->crud->delete('media_surat','id_media',$id);
            $this->session->set_flashdata('success',$this->message);
            redirect('admin/media-surat');
        } else {
            $this->message = "Gagal menghapus, media sedang digunakan";
            $this->session->set_flashdata('warning', $this->message);
            redirect('admin/media-surat');
        }
    }

    function media_list()
    {
        $list = $this->media->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $value->id_media;
            $row[] = $value->nama_media;
            $row[] = $value->keterangan;
            //add html for action
            $row[] = '<a class="btn btn-sm btn-warning p-2" href="#" title="Edit" onclick="edit_media(' . "'" . $value->id_media . "'" . ')"><i class="fa fa-pencil"></i> Edit</a>
            <a class="btn btn-sm btn-danger p-2" href="#" title="Hapus" onClick="delete_media(' . "'" . $value->id_media . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->media->count_all(),
            "recordsFiltered" => $this->media->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function media_edit($id)
    {
        $data = $this->media->get_by_id($id);
        echo json_encode($data);
    }

    function media_add()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'response' => 'error',
                'error'   => true,
                'nama_mediaError' => form_error('nama_media'),
                'keteranganError' => form_error('keterangan'),
                'message' => validation_errors(),
            );
        } else {
            $data = array(
                'nama_media' => $this->input->post('nama_media'),
                'keterangan' => $this->input->post('keterangan'),
                'created_at' => date('Y-m-d H:i:s'),
            );
            $insert = $this->media->save($data);
        }
        echo json_encode($data);
    }

    function media_update()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'response' => 'error',
                'error'   => true,
                'nama_mediaError' => form_error('nama_media'),
                'keteranganError' => form_error('keterangan'),
                'message' => validation_errors(),
            );
        } else {
            $data = array(
                'nama_media' => $this->input->post('nama_media'),
                'keterangan' => $this->input->post('keterangan'),
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $this->media->update(array('id_media' => $this->input->post('id_media')), $data);
        }
        echo json_encode($data);
    }

    function media_delete($id)
    {
        $q1 = sprintf("SELECT count(id_media) jml FROM surat_eksternal WHERE id_media=%d", $id);
        $q2 = sprintf("SELECT count(id_media) jml FROM surat_internal WHERE id_media=%d", $id);
        $jml1 = $this->db->query($q1)->row_array()['jml'];
        $jml2 = $this->db->query($q2)->row_array()['jml'];
        if ($jml1 == 0 && $jml2 == 0) {
            $this->media->delete_by_id($id);
            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array('response' => 'error', "error" => TRUE));
        }
    }
}