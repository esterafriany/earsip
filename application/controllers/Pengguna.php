<?php
if (defined('basepath')) exit('No direct access script allowed');

class Pengguna extends CI_Controller
{

    var $message;

    function __construct()
    {
        parent::__construct();
        $this->load->model('GlobalCrud', 'crud');
        $this->load->model('UserModel', 'user');
        $this->load->model('pegawai');
        if ($this->session->userdata('level') != 1) {
            redirect('login');
        }
        $this->form_validation->set_error_delimiters('', '');
    }

    function validation()
    {
        $this->form_validation->set_rules('name', 'Nama ', 'required');
        $this->form_validation->set_rules('id_pegawai', 'ID Pegawai ', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confirm', 'Konfirmasi Password', 'required|matches[password]');
    }

    function index()
    {
        $data = $this->pegawai->join_pegawai_user()->result();
        header('Content-type: application/json');
        echo json_encode($data);
    }

    function create()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'response' => 'error',
                'error'   => true,
                'nameError' => form_error('name'),
                'id_pegawaiError' => form_error('id_pegawai'),
                'emailError' => form_error('email'),
                'passwordError' => form_error('password'),
                'confirmError' => form_error('confirm'),
                'message' => validation_errors(),
            );
        } else {
            $query = array(
                'name' => $this->input->post('name', true),
                'email' => $this->input->post('email', true),
                'password' => sha1($this->input->post('password')),
                'id_pegawai' => $this->input->post('id_pegawai', true),
                'level' => '0',
                'created_at' => date('Y-m-d H:i:s')
            );
            $data = $this->crud->insert('user', $query);
        }
        header('Content-type: application/json');
        echo json_encode($data);
    }

    function update()
    {
        $this->form_validation->set_rules('email', '', 'required|valid_email');
        $this->form_validation->set_rules('name', '', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'response' => 'error',
                'error'   => true,
                'nameError' => form_error('name'),
                'id_pegawaiError' => form_error('id_pegawai'),
                'emailError' => form_error('email'),
                'message' => validation_errors(),
            );
        } else {
            $query = array(
                'name' => $this->input->post('name', true),
                'id_pegawai' => $this->input->post('id_pegawai', true),
                'email' => $this->input->post('email', true),
                'updated_at' => date('Y-m-d H:i:s')
            );
            $data = $this->crud->update('user', $query, 'id_user', $this->input->post('id_user'));
        }
        header('Content-type: application/json');
        echo json_encode($data);
    }

    function reset_password()
    {
        $this->form_validation->set_rules('old_password', '', 'required');
        $this->form_validation->set_rules('new_password', '', 'required');
        $this->form_validation->set_rules('confirm_password', '', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'response' => 'error',
                'error'   => true,
                'old_passwordError' => form_error('old_password'),
                'new_passwordError' => form_error('new_password'),
                'confirm_passwordError' => form_error('confirm_password'),
                'message' => validation_errors(),
            );
        } else {
            if ($this->input->post('new_password') == $this->input->post('confirm_password')) {
                $old_password = $this->user->reset($this->input->post('id_user'));
                if ($old_password == sha1($this->input->post('old_password'))) {
                    $query = array(
                        'password' => sha1($this->input->post('new_password'))
                    );
                    $data = $this->crud->update('user', $query, 'id_user', $this->input->post('id_user'));
                } else {
                    $data = array(
                        'response' => 'error',
                        'error'   => true,
                        'old_passwordError' => 'Password Lama Tidak Sesuai',
                        'new_passwordError' => form_error('new_password'),
                        'confirm_passwordError' => form_error('confirm_password'),
                        'message' => validation_errors(),
                    );
                }
            } else {
                $data = array(
                    'response' => 'error',
                    'error'   => true,
                    'old_passwordError' => form_error('old_password'),
                    'new_passwordError' => form_error('new_password'),
                    'confirm_passwordError' => form_error('confirm_password'),
                    'message' => validation_errors(),
                );
            }
            
        }
        header('Content-type: application/json');
        echo json_encode($data);
    }

    function delete()
    {
        $id = $this->input->post('id_user');
        $data = $this->crud->delete('user', 'id_user', $id);
        header('Content-type: application/json');
        echo json_encode($data);
    }

    function get($id)
    {
        $data = array('id_user' => $id);
        $result = $this->crud->get('user', $data)->row();
        header('Content-type: application/json');
        echo json_encode($result);
    }
}
