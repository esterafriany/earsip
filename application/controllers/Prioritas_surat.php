<?php
if (defined('basepath')) exit('No direct access script allowed');

class Prioritas_surat extends CI_Controller
{

    var $message;

    function __construct()
    {
        parent::__construct();
        $this->load->model('GlobalCrud', 'crud');
        $this->load->model('PrioritasDataModel', 'prioritas');
        if ($this->session->userdata('level') != 1) {
            redirect('login');
        }
        $this->form_validation->set_error_delimiters('', '');
    }

    function validation()
    {
        $this->form_validation->set_rules('nama_prioritas', 'Prioritas Surat', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
    }

    function create()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $this->message = "Prioritas Surat Wajib Diisi !";
            $this->session->set_flashdata('warning', $this->message);
            redirect('admin/prioritas-surat');
        } else {

            $query = array(
                'nama_prioritas' => $this->input->post('nama_prioritas'),
                'keterangan' => $this->input->post('keterangan')
            );

            $this->crud->insert('prioritas_surat', $query);
            $this->message = "Prioritas Surat Baru Berhasil Dibuat :)";
            $this->session->set_flashdata('success', $this->message);
            redirect('admin/prioritas-surat');
        }
    }

    function get($id)
    {

        $data = array(
            'id_prioritas' => $id
        );

        $result = $this->crud->get('prioritas_surat', $data)->row();
        echo json_encode($result);
    }

    function update()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $this->message = "Prioritas Surat Wajib Diisi !";
            $this->session->set_flashdata('warning', $this->message);
            redirect('admin/prioritas-surat');
        } else {
            $query = array(
                'nama_prioritas' => $this->input->post('nama_prioritas'),
                'keterangan' => $this->input->post('keterangan')
            );

            $this->crud->update('prioritas_surat', $query, 'id_prioritas', $this->input->post('id_prioritas'));
            $this->message = "Prioritas Surat Berhasil Diubah :)";
            $this->session->set_flashdata('success', $this->message);
            redirect('admin/prioritas-surat');
        }
    }

    function destroy($id)
    {
        $q1 = sprintf("SELECT count(id_prioritas) jml FROM surat_eksternal WHERE id_prioritas=%d", $id);
        $q2 = sprintf("SELECT count(id_prioritas) jml FROM surat_internal WHERE id_prioritas=%d", $id);
        $jml1 = $this->db->query($q1)->row_array()['jml'];
        $jml2 = $this->db->query($q2)->row_array()['jml'];
        if ($jml1 == 0 && $jml2 == 0) {
            $this->message = "Prioritas Surat Berhasil Dihapus";
            $this->crud->delete('prioritas_surat', 'id_prioritas', $id);
            $this->session->set_flashdata('success', $this->message);
            redirect('admin/prioritas-surat');
        } else {
            $this->message = "Gagal menghapus, prioritas sedang digunakan";
            $this->session->set_flashdata('warning', $this->message);
            redirect('admin/prioritas-surat');
        }
    }

    function prioritas_list()
    {
        $list = $this->prioritas->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $value->id_prioritas;
            $row[] = $value->nama_prioritas;
            $row[] = $value->keterangan;
            //add html for action
            $row[] = '<a class="btn btn-sm btn-warning p-2" href="#" title="Edit" onclick="edit_prioritas(' . "'" . $value->id_prioritas . "'" . ')"><i class="fa fa-pencil"></i> Edit</a>
            <a class="btn btn-sm btn-danger p-2" href="#" title="Hapus" onClick="delete_prioritas(' . "'" . $value->id_prioritas . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->prioritas->count_all(),
            "recordsFiltered" => $this->prioritas->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function prioritas_edit($id)
    {
        $data = $this->prioritas->get_by_id($id);
        echo json_encode($data);
    }

    function prioritas_add()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'response' => 'error',
                'error'   => true,
                'nama_prioritasError' => form_error('nama_prioritas'),
                'keteranganError' => form_error('keterangan'),
                'message' => validation_errors(),
            );
        } else {
            $data = array(
                'nama_prioritas' => $this->input->post('nama_prioritas'),
                'keterangan' => $this->input->post('keterangan'),
                'created_at' => date('Y-m-d H:i:s'),
            );
            $insert = $this->prioritas->save($data);
        }
        echo json_encode($data);
    }

    function prioritas_update()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'response' => 'error',
                'error'   => true,
                'nama_prioritasError' => form_error('nama_prioritas'),
                'keteranganError' => form_error('keterangan'),
                'message' => validation_errors(),
            );
        } else {
            $data = array(
                'nama_prioritas' => $this->input->post('nama_prioritas'),
                'keterangan' => $this->input->post('keterangan'),
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $this->prioritas->update(array('id_prioritas' => $this->input->post('id_prioritas')), $data);
        }
        echo json_encode($data);
    }

    function prioritas_delete($id)
    {
        $q1 = sprintf("SELECT count(id_prioritas) jml FROM surat_eksternal WHERE id_prioritas=%d", $id);
        $q2 = sprintf("SELECT count(id_prioritas) jml FROM surat_internal WHERE id_prioritas=%d", $id);
        $jml1 = $this->db->query($q1)->row_array()['jml'];
        $jml2 = $this->db->query($q2)->row_array()['jml'];
        if ($jml1 == 0 && $jml2 == 0) {
            $this->prioritas->delete_by_id($id);
            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array('response' => 'error', "error" => TRUE));
        }
    }
}
