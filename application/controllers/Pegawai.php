<?php

if (defined('basepath')) exit('No direct access script allowed');

class Pegawai extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('GlobalCrud', 'crud');
        $this->load->model('PegawaiDataModel', 'pegawaidata');
        if ($this->session->userdata('level') != 1) {
            redirect('login');
        }
        $this->form_validation->set_error_delimiters('', '');
    }

    function validation()
    {
        $this->form_validation->set_rules('nama_pegawai', 'Nama Pegawai', 'required');
        $this->form_validation->set_rules('kontak_telepon', 'Kontak Telepon', 'required');
        $this->form_validation->set_rules('id_unit', 'Unit Kerja', 'required');
        $this->form_validation->set_rules('id_jabatan', 'Jabatan', 'required');
    }

    function create()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $this->message = "Seluruh Komponen Pegawai Wajib Diisi !";
            $this->session->set_flashdata('warning', $this->message);
            redirect('admin/pegawai');
        } else {

            $query = array(
                'nama_pegawai' => $this->input->post('nama_pegawai'),
                'kontak_telepon' => $this->input->post('kontak_telepon'),
                'id_unit' => $this->input->post('id_unit'),
                'id_jabatan' => $this->input->post('id_jabatan')
            );

            $this->crud->insert('pegawai', $query);
            $this->message = "Pegawai Baru Berhasil Dibuat, Silahkan buat Akun :)";
            $this->session->set_flashdata('success', $this->message);
            redirect('admin/akun');
        }
    }

    function get($id)
    {

        $data = array(
            'id_pegawai' => $id
        );

        $result = $this->crud->get('pegawai', $data)->row();
        echo json_encode($result);
    }

    function update()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $this->message = "Komponen Pegawai Wajib Diisi !";
            $this->session->set_flashdata('warning', $this->message);
            redirect('admin/pegawai');
        } else {
            $query = array(
                'nama_pegawai' => $this->input->post('nama_pegawai'),
                'kontak_telepon' => $this->input->post('kontak_telepon'),
                'id_unit' => $this->input->post('id_unit'),
                'id_jabatan' => $this->input->post('id_jabatan')
            );

            $this->crud->update('pegawai', $query, 'id_pegawai', $this->input->post('id_pegawai'));
            $this->message = "Pegawai Berhasil Diubah :)";
            $this->session->set_flashdata('success', $this->message);
            redirect('admin/pegawai');
        }
    }

    function destroy($id)
    {
        $this->message = "Pegawai Berhasil Dihapus :)";
        $this->crud->delete('pegawai', 'id_pegawai', $id);
        $this->session->set_flashdata('success', $this->message);
        redirect('admin/pegawai');
    }


    function pegawai_list()
    {
        $list = $this->pegawaidata->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $value->id_pegawai;
            $row[] = $value->nama_pegawai;
            $row[] = $value->kontak_telepon;
            $row[] = $value->nama_unit;
            $row[] = $value->nama_jabatan;
            //add html for action
            $row[] = '<a class="btn btn-sm btn-warning p-2" href="#" title="Edit" onclick="edit_pegawai(' . "'" . $value->id_pegawai . "'" . ')"><i class="fa fa-pencil"></i> Edit</a>
            <a class="btn btn-sm btn-danger p-2" href="#" title="Hapus" onClick="delete_pegawai(' . "'" . $value->id_pegawai . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pegawaidata->count_all(),
            "recordsFiltered" => $this->pegawaidata->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function pegawai_edit($id)
    {
        $data = $this->pegawaidata->get_by_id($id);
        echo json_encode($data);
    }

    function pegawai_add()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'response' => 'error',
                'error'   => true,
                'nama_pegawaiError' => form_error('nama_pegawai'),
                'kontak_teleponError' => form_error('kontak_telepon'),
                'id_unitError' => form_error('id_unit'),
                'id_jabatanError' => form_error('id_jabatan'),
                'message' => validation_errors(),
            );
        } else {
            $data = array(
                'nama_pegawai' => $this->input->post('nama_pegawai'),
                'kontak_telepon' => $this->input->post('kontak_telepon'),
                'id_unit' => $this->input->post('id_unit'),
                'id_jabatan' => $this->input->post('id_jabatan'),
            );
            $insert = $this->pegawaidata->save($data);
        }
        echo json_encode($data);
    }

    function pegawai_update()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'response' => 'error',
                'error'   => true,
                'nama_pegawaiError' => form_error('nama_pegawai'),
                'kontak_teleponError' => form_error('kontak_telepon'),
                'id_unitError' => form_error('id_unit'),
                'id_jabatanError' => form_error('id_jabatan'),
                'message' => validation_errors(),
            );
        } else {
            $data = array(
                'nama_pegawai' => $this->input->post('nama_pegawai'),
                'kontak_telepon' => $this->input->post('kontak_telepon'),
                'id_unit' => $this->input->post('id_unit'),
                'id_jabatan' => $this->input->post('id_jabatan'),
            );
            $this->pegawaidata->update(array('id_pegawai' => $this->input->post('id_pegawai')), $data);
        }
        echo json_encode($data);
    }

    function pegawai_delete($id)
    {
        $this->pegawaidata->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}
