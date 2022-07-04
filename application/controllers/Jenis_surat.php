<?php
if (defined('basepath')) exit('No direct access script allowed');

class Jenis_surat extends CI_Controller
{

    var $message;

    function __construct()
    {
        parent::__construct();
        $this->load->model('GlobalCrud', 'crud');
        $this->load->model('JenisDataModel', 'jenis');
        if ($this->session->userdata('level') != 1) {
            redirect('login');
        }
        $this->form_validation->set_error_delimiters('', '');
    }

    function validation()
    {
        $this->form_validation->set_rules('nama_jenis', 'Jenis Surat', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
    }

    function create()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $this->message = "Jenis Surat Wajib Diisi !";
            $this->session->set_flashdata('warning', $this->message);
            redirect('admin/jenis-surat');
        } else {

            $query = array(
                'nama_jenis' => $this->input->post('nama_jenis'),
                'keterangan' => $this->input->post('keterangan')
            );

            $this->crud->insert('jenis_surat', $query);
            $this->message = "Jenis Surat Baru Berhasil Dibuat :)";
            $this->session->set_flashdata('success', $this->message);
            redirect('admin/jenis-surat');
        }
    }

    function get($id)
    {

        $data = array(
            'id_jenis' => $id
        );

        $result = $this->crud->get('jenis_surat', $data)->row();
        echo json_encode($result);
    }

    function update()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $this->message = "Jenis Surat Wajib Diisi !";
            $this->session->set_flashdata('warning', $this->message);
            redirect('admin/jenis-surat');
        } else {
            $query = array(
                'nama_jenis' => $this->input->post('nama_jenis'),
                'keterangan' => $this->input->post('keterangan')
            );

            $this->crud->update('jenis_surat', $query, 'id_jenis', $this->input->post('id_jenis'));
            $this->message = "Jenis Surat Berhasil Diubah :)";
            $this->session->set_flashdata('success', $this->message);
            redirect('admin/jenis-surat');
        }
    }

    function destroy($id)
    {
        $q1 = sprintf("SELECT count(id_jenis) jml FROM surat_eksternal WHERE id_jenis=%d", $id);
        $q2 = sprintf("SELECT count(id_jenis) jml FROM surat_internal WHERE id_jenis=%d", $id);
        $jml1 = $this->db->query($q1)->row_array()['jml'];
        $jml2 = $this->db->query($q2)->row_array()['jml'];
        if ($jml1 == 0 && $jml2 == 0) {
            $this->message = "Jenis Surat Berhasil Dihapus";
            $this->crud->delete('jenis_surat', 'id_jenis', $id);
            $this->session->set_flashdata('success', $this->message);
            redirect('admin/jenis-surat');
        } else {
            $this->message = "Gagal menghapus, jenis sedang digunakan";
            $this->session->set_flashdata('warning', $this->message);
            redirect('admin/jenis-surat');
        }
    }

    function jenis_list()
    {
        $list = $this->jenis->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $value->id_jenis;
            $row[] = $value->nama_jenis;
            $row[] = $value->keterangan;
            //add html for action
            $row[] = '<a class="btn btn-sm btn-warning p-2" href="#" title="Edit" onclick="edit_jenis(' . "'" . $value->id_jenis . "'" . ')"><i class="fa fa-pencil"></i> Edit</a>
            <a class="btn btn-sm btn-danger p-2" href="#" title="Hapus" onClick="delete_jenis(' . "'" . $value->id_jenis . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->jenis->count_all(),
            "recordsFiltered" => $this->jenis->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function jenis_edit($id)
    {
        $data = $this->jenis->get_by_id($id);
        echo json_encode($data);
    }

    function jenis_add()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'response' => 'error',
                'error'   => true,
                'nama_jenisError' => form_error('nama_jenis'),
                'keteranganError' => form_error('keterangan'),
                'message' => validation_errors(),
            );
        } else {
            $data = array(
                'nama_jenis' => $this->input->post('nama_jenis'),
                'keterangan' => $this->input->post('keterangan'),
                'created_at' => date('Y-m-d H:i:s'),
            );
            $insert = $this->jenis->save($data);
        }
        echo json_encode($data);
    }

    function jenis_update()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'response' => 'error',
                'error'   => true,
                'nama_jenisError' => form_error('nama_jenis'),
                'keteranganError' => form_error('keterangan'),
                'message' => validation_errors(),
            );
        } else {
            $data = array(
                'nama_jenis' => $this->input->post('nama_jenis'),
                'keterangan' => $this->input->post('keterangan'),
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $this->jenis->update(array('id_jenis' => $this->input->post('id_jenis')), $data);
        }
        echo json_encode($data);
    }

    function jenis_delete($id)
    {
        $q1 = sprintf("SELECT count(id_jenis) jml FROM surat_eksternal WHERE id_jenis=%d", $id);
        $q2 = sprintf("SELECT count(id_jenis) jml FROM surat_internal WHERE id_jenis=%d", $id);
        $jml1 = $this->db->query($q1)->row_array()['jml'];
        $jml2 = $this->db->query($q2)->row_array()['jml'];
        if ($jml1 == 0 && $jml2 == 0) {
            $this->jenis->delete_by_id($id);
            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array('response' => 'error', "error" => TRUE));
        }
    }
}
