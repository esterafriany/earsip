<?php
if (defined('basepath')) exit('No direct access script allowed');

class Perintah_disposisi extends CI_Controller
{

    var $message;

    function __construct()
    {
        parent::__construct();
        $this->load->model('GlobalCrud', 'crud');
        $this->load->model('PerintahDataModel', 'perintah');
        if ($this->session->userdata('level') != 1) {
            redirect('login');
        }
        $this->form_validation->set_error_delimiters('', '');
    }

    function validation()
    {
        $this->form_validation->set_rules('nama_perintah', 'Nama Perintah', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
    }

    function create()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $this->message = "Perintah Disposisi Wajib Diisi !";
            $this->session->set_flashdata('warning', $this->message);
            redirect('admin/perintah-disposisi');
        } else {

            $query = array(
                'nama_perintah' => $this->input->post('nama_perintah'),
                'keterangan' => $this->input->post('keterangan')
            );

            $this->crud->insert('perintah_disposisi', $query);
            $this->message = "Perintah Disposisi Baru Berhasil Dibuat :)";
            $this->session->set_flashdata('success', $this->message);
            redirect('admin/perintah-disposisi');
        }
    }

    function get($id)
    {

        $data = array(
            'id_perintah' => $id
        );

        $result = $this->crud->get('perintah_disposisi', $data)->row();
        echo json_encode($result);
    }

    function update()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $this->message = "Perintah Disposisi Wajib Diisi !";
            $this->session->set_flashdata('warning', $this->message);
            redirect('admin/perintah-disposisi');
        } else {
            $query = array(
                'nama_perintah' => $this->input->post('nama_perintah'),
                'keterangan' => $this->input->post('keterangan')
            );

            $this->crud->update('perintah_disposisi', $query, 'id_perintah', $this->input->post('id_perintah'));
            $this->message = "Perintah Disposisi Berhasil Diubah :)";
            $this->session->set_flashdata('success', $this->message);
            redirect('admin/perintah-disposisi');
        }
    }

    function destroy($id)
    {
        $this->message = "Perintah Disposisi Berhasil Dihapus :)";
        $this->crud->delete('perintah_disposisi', 'id_perintah', $id);
        $this->session->set_flashdata('success', $this->message);
        redirect('admin/perintah-disposisi');
    }

    function perintah_list()
    {
        $list = $this->perintah->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $value->id_perintah;
            $row[] = $value->nama_perintah;
            $row[] = $value->keterangan;
            //add html for action
            $row[] = '<a class="btn btn-sm btn-warning p-2" href="#" title="Edit" onclick="edit_perintah(' . "'" . $value->id_perintah . "'" . ')"><i class="fa fa-pencil"></i> Edit</a>
            <a class="btn btn-sm btn-danger p-2" href="#" title="Hapus" onClick="delete_perintah(' . "'" . $value->id_perintah . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->perintah->count_all(),
            "recordsFiltered" => $this->perintah->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function perintah_edit($id)
    {
        $data = $this->perintah->get_by_id($id);
        echo json_encode($data);
    }

    function perintah_add()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'response' => 'error',
                'error'   => true,
                'nama_perintahError' => form_error('nama_perintah'),
                'keteranganError' => form_error('keterangan'),
                'message' => validation_errors(),
            );
        } else {
            $data = array(
                'nama_perintah' => $this->input->post('nama_perintah'),
                'keterangan' => $this->input->post('keterangan'),
                'created_at' => date('Y-m-d H:i:s'),
            );
            $insert = $this->perintah->save($data);
        }
        echo json_encode($data);
    }

    function perintah_update()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'response' => 'error',
                'error'   => true,
                'nama_perintahError' => form_error('nama_perintah'),
                'keteranganError' => form_error('keterangan'),
                'message' => validation_errors(),
            );
        } else {
            $data = array(
                'nama_perintah' => $this->input->post('nama_perintah'),
                'keterangan' => $this->input->post('keterangan'),
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $this->perintah->update(array('id_perintah' => $this->input->post('id_perintah')), $data);
        }
        echo json_encode($data);
    }

    function perintah_delete($id)
    {
        $q1 = sprintf("SELECT count(id_prioritas) jml FROM surat_eksternal WHERE id_prioritas=%d", $id);
        $q2 = sprintf("SELECT count(id_prioritas) jml FROM surat_internal WHERE id_prioritas=%d", $id);
        $jml1 = $this->db->query($q1)->row_array()['jml'];
        $jml2 = $this->db->query($q2)->row_array()['jml'];
        if ($jml1 == 0 && $jml2 == 0) {
            $this->perintah->delete_by_id($id);
            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array('response' => 'error', "error" => TRUE));
        }
    }
}
