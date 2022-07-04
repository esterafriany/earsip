<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    
   
    
    public function __construct(){
        parent::__construct();
        $this->load->model('GlobalCrud','crud');
        $this->load->model('UserModel','user');
    }

	public function index()
	{ 
        if ($this->session->userdata('logged_in') == true) {
			redirect('/admin', 'refresh');
		}

        $data = array(
            'title' => 'Login',
            'setting' => $this->crud->get('pengaturan',array('id_pengaturan' => '1'))->row()
        );
		$this->load->view('layouts/header', $data);
        $this->load->view('login', $data);
        $this->load->view('layouts/footer');
	}
    
    public function signin(){
		  $query = array(
            'email' => $this->input->post('email'),
            'password' => sha1($this->input->post('password'))
          );

        $result = $this->user->first($query);
        $result2 = $this->user->get_detail_user_login($this->input->post('email'), $this->input->post('password'));
        var_dump($result->result_array());
        
        if($result->num_rows() == 1){
            $this->session->set_flashdata('success','Login berhasil');
            $this->user->session($result);
        } else {
            $this->session->set_flashdata('danger','Username atau Password Salah');
            redirect('login');
        }
	}
    
    function signout(){
        $this->session->unset_userdata('id_user');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('id_unit');
        //$this->session->unset_userdata('password');
        $this->session->unset_userdata('level');
        $this->session->unset_userdata('logged_in');

        redirect('login', 'refresh');

    }
}
