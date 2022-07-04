<?php
if (defined('basepath')) exit('No direct access script allowed');

class Pengaturan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('GlobalCrud', 'crud');
        if ($this->session->userdata('level') != 1) {
            redirect('login');
        }
    }

    function validation()
    {
        $this->form_validation->set_rules('site_title', '', 'required');
        $this->form_validation->set_rules('site_nama', '', 'required');
    }

    function get($id)
    {

        $data = array(
            'id_pengaturan' => $id
        );

        $result = $this->crud->get('pengaturan', $data)->row();
        echo json_encode($result);
    }

    function update()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $this->message = "Field Required Wajib Diisi !";
            $this->session->set_flashdata('warning', $this->message);
            redirect('admin/pengaturan');
        } else {

            if (!empty($_FILES['file_path']['name'])) {
                $config = array(
                    'upload_path' => 'assets/img',
                    'allowed_types' => 'png|jpg',
                    'file_name' => $_FILES['file_path']['name'],
                    'remove_space' => TRUE,
                    'max_size' => 50000,
                );

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file_path')) {

                    $file = $this->upload->data();

                    $query = array(
                        'site_title' => $this->input->post('site_title'),
                        'site_logo' => $config['upload_path'] . "/" . $file['file_name'],
                        'site_nama' => $this->input->post('site_nama'),
                        'site_alamat' => $this->input->post('site_alamat'),
                        'updated_at' => date('Y-m-d H:i:s')
                    );

                    $this->crud->update('pengaturan', $query, 'id_pengaturan', $this->input->post('id_pengaturan'));
                    $this->message = "Pengaturan Berhasil Diubah :)";
                    $this->session->set_flashdata('success', $this->message);
                    redirect('admin/pengaturan');
                } else {
                    $this->message = "Berkas gagal di unggah!";
                    $this->session->set_flashdata('danger', $this->message);
                    redirect('admin/pengaturan');
                }
            } else {

                $query = array(
                    'site_title' => $this->input->post('site_title'),
                    'site_nama' => $this->input->post('site_nama'),
                    'site_alamat' => $this->input->post('site_alamat'),
                    'updated_at' => date('Y-m-d H:i:s')
                );

                $this->crud->update('pengaturan', $query, 'id_pengaturan', $this->input->post('id_pengaturan'));
                $this->message = "Pengaturan Berhasil Diperbarui";
                $this->session->set_flashdata('success', $this->message);
                redirect('admin/pengaturan');
            }
        }
    }
}
