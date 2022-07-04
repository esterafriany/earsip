<?php
if (defined('basepath')) exit('No direct access script allowed');

class Surat_eksternal extends CI_Controller
{

    var $message;

    function __construct()
    {
        parent::__construct();
        $this->load->model('GlobalCrud', 'crud');
        $this->load->model('UserModel', 'user');
        $this->load->model('SuratEksternal', 'eksternal');
        $this->form_validation->set_error_delimiters('', '');
    }

    function validation($masuk = true)
    {
        $this->form_validation->set_rules('nomor_surat', 'Nomor Surat', 'required');
        $this->form_validation->set_rules('perihal', 'Perihal', 'required');
        if ($masuk) {
            $this->form_validation->set_rules('asal_surat_luar', 'Asal Surat', 'required');
            $this->form_validation->set_rules('tujuan_surat_pengguna', 'Tujuan Surat', 'required');
        } else {
            $this->form_validation->set_rules('tujuan_surat_luar', 'Tujuan Surat', 'required');
            $this->form_validation->set_rules('asal_surat_pengguna', 'Asal Surat', 'required');
        }
        $this->form_validation->set_rules('isi_ringkas', 'Isi Ringkas', 'required');
        $this->form_validation->set_rules('tanggal_surat', 'Tanggal Surat', 'required');
        $this->form_validation->set_rules('tanggal_transaksi', 'Tanggal Transaksi', 'required');
        $this->form_validation->set_rules('lokasi_surat', 'Lokasi Surat', 'required');
    }

    function tambah($jenis_surat)
    {
        if ($this->session->userdata('level') != 1) {
            redirect('login');
        }
        if ($jenis_surat == "masuk") {

            $data = array(
                'title' => 'Surat Eksternal Masuk',
                'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
                'set' => $this->eksternal->get_surat_destinasi('surat_eksternal', array('jenis_surat' => 'masuk'))->result(),
                'jenis' => 'Masuk',
                'set_destinasi' => $this->user->destinasi_surat($this->session->userdata('id_user'))->result(),
                'set_jenis' => $this->crud->all('jenis_surat')->result(),
                'set_prioritas' => $this->crud->all('prioritas_surat')->result(),
                'set_sifat' => $this->crud->all('sifat_surat')->result(),
                'set_media' => $this->crud->all('media_surat')->result(),
                'pembuat' => $this->session->userdata('id_user')
            );
        } else {
            $data = array(
                'title' => 'Surat Eksternal Keluar',
                'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
                'set' => $this->eksternal->get_surat_destinasi('surat_eksternal', array('jenis_surat' => 'keluar'))->result(),
                'jenis' => 'Keluar',
                'set_destinasi' => $this->user->destinasi_surat($this->session->userdata('id_user'))->result(),
                'set_jenis' => $this->crud->all('jenis_surat')->result(),
                'set_prioritas' => $this->crud->all('prioritas_surat')->result(),
                'set_sifat' => $this->crud->all('sifat_surat')->result(),
                'set_media' => $this->crud->all('media_surat')->result(),
                'pembuat' => $this->session->userdata('id_user')
            );
        }

        if ($_GET['act'] == 'submit_keluar') {
            $this->validation(false);
            if ($this->form_validation->run() == FALSE) {
                $this->message = 'Semua Komponen Surat Wajib Diisi!';
                $this->session->set_flashdata('danger', $this->message);
            } else {
                $config = array(
                    'upload_path' => 'files/surat-eksternal',
                    'allowed_types' => 'pdf|jpg|jpeg|png',
                    'file_name' => $_FILES['file_path']['name'],
                    'max_size' => 500000,
                    'remove_space' => TRUE,
                    'encrypt_name' => TRUE,
                );
    
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file_path')) {
                    $file = $this->upload->data();
    
                    $query = array(
                        'nomor_surat' => $this->input->post('nomor_surat'),
                        'tujuan_surat_luar' => $this->input->post('tujuan_surat_luar'),
                        'isi_ringkas' => $this->input->post('isi_ringkas'),
                        'tanggal_surat' => $this->input->post('tanggal_surat'),
                        'tanggal_transaksi' => $this->input->post('tanggal_transaksi'),
                        'perihal' => $this->input->post('perihal'),
                        'file_path' => $config['upload_path'] . "/" . $file['file_name'],
                        'lokasi_surat' => $this->input->post('lokasi_surat'),
                        'id_jenis' => $this->input->post('id_jenis'),
                        'id_prioritas' => $this->input->post('id_prioritas'),
                        'id_sifat' => $this->input->post('id_sifat'),
                        'id_media' => $this->input->post('id_media'),
                        'asal_surat_pengguna' => $this->input->post('asal_surat_pengguna'),
                        'id_user' => $this->session->userdata('id_user'),
                        'jenis_surat' => 'keluar'
                    );
    
                    $this->crud->insert('surat_eksternal', $query);
    
                    if ($this->session->userdata('level') == 1) {
                        $this->message = "Surat Eksternal Keluar Berhasil Ditambah";
                        $this->session->userdata('success', $this->message);
                        redirect('admin/surat-eksternal/keluar');
                    } else {
                        $this->message = "Surat Eksternal Keluar Berhasil Ditambah";
                        $this->session->userdata('success', $this->message);
                        redirect('user/surat-eksternal/keluar');
                    }
                } else {
                    $this->message = "Upload Berkas Error!";
                    $this->session->set_flashdata('danger', $this->message);
                    $this->session->set_flashdata('uploadError', $this->upload->display_errors('<p class="text-danger mt-2">', '</p>'));
                }
            }
        }

        if ($_GET['act'] == 'submit_masuk') {
            $this->validation();
            if ($this->form_validation->run() == FALSE) {
                $this->message = 'Semua Komponen Surat Wajib Diisi!';
                $this->session->set_flashdata('danger', $this->message);
            } else {
    
                $config = array(
                    'upload_path' => 'files/surat-eksternal',
                    'allowed_types' => 'pdf|jpg|jpeg|png',
                    'file_name' => $_FILES['file_path']['name'],
                    'max_size' => 500000,
                    'remove_space' => TRUE,
                    'encrypt_name' => TRUE,
                );
    
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
    
                if ($this->upload->do_upload('file_path')) {
                    $file = $this->upload->data();
                    $query = array(
                        'nomor_surat' => $this->input->post('nomor_surat'),
                        'tujuan_surat_pengguna' => $this->input->post('tujuan_surat_pengguna'),
                        'isi_ringkas' => $this->input->post('isi_ringkas'),
                        'tanggal_surat' => $this->input->post('tanggal_surat'),
                        'tanggal_transaksi' => $this->input->post('tanggal_transaksi'),
                        'perihal' => $this->input->post('perihal'),
                        'file_path' => $config['upload_path'] . "/" . $file['file_name'],
                        'lokasi_surat' => $this->input->post('lokasi_surat'),
                        'id_jenis' => $this->input->post('id_jenis'),
                        'id_prioritas' => $this->input->post('id_prioritas'),
                        'id_sifat' => $this->input->post('id_sifat'),
                        'id_media' => $this->input->post('id_media'),
                        'asal_surat_luar' => $this->input->post('asal_surat_luar'),
                        'id_user' => $this->session->userdata('id_user'),
                        'jenis_surat' => 'masuk'
                    );
                    $this->crud->insert('surat_eksternal', $query);
                    if ($this->session->userdata('level') == 1) {
                        $this->message = "Surat Eksternal Masuk Berhasil Ditambah";
                        $this->session->userdata('success', $this->message);
                        redirect('admin/surat-eksternal/masuk');
                    } else {
                        $this->message = "Surat Eksternal Masuk Berhasil Ditambah";
                        $this->session->userdata('success', $this->message);
                        redirect('user/surat-eksternal/masuk');
                    }
                } else {
                    $this->message = "Upload Berkas Error!";
                    $this->session->set_flashdata('danger', $this->message);
                    $this->session->set_flashdata('uploadError', $this->upload->display_errors('<p class="text-danger mt-2">', '</p>'));
                }
            }
        }

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/nav');
        $this->load->view('admin/surat-eksternal/tambah', $data);
        $this->load->view('layouts/footer');
    }

    /* function create()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $this->message = 'Semua Komponen Surat Wajib Diisi!';
            $this->session->set_flashdata('danger', $this->message);
            if ($this->session->userdata('level') == 1) {
                redirect('admin/surat-eksternal/keluar');
            } else {
                redirect('user/surat-eksternal/keluar');
            }
        } else {
            $config = array(
                'upload_path' => 'files/surat-eksternal',
                'allowed_types' => 'pdf|jpg|jpeg|png',
                'file_name' => $_FILES['file_path']['name'],
                'max_size' => 500000,
                'remove_space' => TRUE,
                'encrypt_name' => TRUE,
            );

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file_path')) {
                $file = $this->upload->data();

                $query = array(
                    'nomor_surat' => $this->input->post('nomor_surat'),
                    'tujuan_surat_luar' => $this->input->post('tujuan_surat_luar'),
                    'isi_ringkas' => $this->input->post('isi_ringkas'),
                    'tanggal_surat' => $this->input->post('tanggal_surat'),
                    'tanggal_transaksi' => $this->input->post('tanggal_transaksi'),
                    'perihal' => $this->input->post('perihal'),
                    'file_path' => $config['upload_path'] . "/" . $file['file_name'],
                    'lokasi_surat' => $this->input->post('lokasi_surat'),
                    'id_jenis' => $this->input->post('id_jenis'),
                    'id_prioritas' => $this->input->post('id_prioritas'),
                    'id_sifat' => $this->input->post('id_sifat'),
                    'id_media' => $this->input->post('id_media'),
                    'asal_surat_pengguna' => $this->input->post('asal_surat_pengguna'),
                    'id_user' => $this->session->userdata('id_user'),
                    'jenis_surat' => 'keluar'
                );

                $this->crud->insert('surat_eksternal', $query);

                if ($this->session->userdata('level') == 1) {
                    $this->message = "Surat Eksternal Keluar Berhasil Ditambah";
                    $this->session->userdata('success', $this->message);
                    redirect('admin/surat-eksternal/keluar');
                } else {
                    $this->message = "Surat Eksternal Keluar Berhasil Ditambah";
                    $this->session->userdata('success', $this->message);
                    redirect('user/surat-eksternal/keluar');
                }
            } else {
                $this->message = "Upload Berkas Error!";
                $this->session->set_flashdata('danger', $this->message);
                if ($this->session->userdata('level') == 1) {
                    redirect('admin/surat-eksternal/keluar');
                } else {
                    redirect('user/surat-eksternal/keluar');
                }
            }
        }
    }

    function create2()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {

            $this->message = 'Semua Komponen Surat Wajib Diisi!';
            $this->session->set_flashdata('danger', $this->message);
            $this->session->set_flashdata('errors', validation_errors());
        
            if ($this->session->userdata('level') == 1) {
                redirect('surat-eksternal/tambah/masuk');
            } else {
                redirect('surat-eksternal/tambah/masuk');
            }
        } else {

            $config = array(
                'upload_path' => 'files/surat-eksternal',
                'allowed_types' => 'pdf|jpg|jpeg|png',
                'file_name' => $_FILES['file_path']['name'],
                'max_size' => 500000,
                'remove_space' => TRUE,
                'encrypt_name' => TRUE,
            );

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file_path')) {
                $file = $this->upload->data();
                $query = array(
                    'nomor_surat' => $this->input->post('nomor_surat'),
                    'tujuan_surat_pengguna' => $this->input->post('tujuan_surat_pengguna'),
                    'isi_ringkas' => $this->input->post('isi_ringkas'),
                    'tanggal_surat' => $this->input->post('tanggal_surat'),
                    'tanggal_transaksi' => $this->input->post('tanggal_transaksi'),
                    'perihal' => $this->input->post('perihal'),
                    'file_path' => $config['upload_path'] . "/" . $file['file_name'],
                    'lokasi_surat' => $this->input->post('lokasi_surat'),
                    'id_jenis' => $this->input->post('id_jenis'),
                    'id_prioritas' => $this->input->post('id_prioritas'),
                    'id_sifat' => $this->input->post('id_sifat'),
                    'id_media' => $this->input->post('id_media'),
                    'asal_surat_luar' => $this->input->post('asal_surat_luar'),
                    'id_user' => $this->session->userdata('id_user'),
                    'jenis_surat' => 'masuk'
                );
                $this->crud->insert('surat_eksternal', $query);
                if ($this->session->userdata('level') == 1) {
                    $this->message = "Surat Eksternal Masuk Berhasil Ditambah";
                    $this->session->userdata('success', $this->message);
                    redirect('admin/surat-eksternal/masuk');
                } else {
                    $this->message = "Surat Eksternal Masuk Berhasil Ditambah";
                    $this->session->userdata('success', $this->message);
                    redirect('user/surat-eksternal/masuk');
                }
            } else {
                $this->message = "Upload Berkas Error!";
                $this->session->set_flashdata('danger', $this->message);
                if ($this->session->userdata('level') == 1) {
                    redirect('admin/surat-eksternal/masuk');
                } else {
                    redirect('user/surat-eksternal/masuk');
                }
            }
        }
    } */

    function destroy($id)
    {
        $q1 = sprintf("SELECT count(id_surat_eksternal) jml FROM disposisi_eksternal WHERE id_surat_eksternal=%d", $id);
        $jml1 = $this->db->query($q1)->row_array()['jml'];
        if ($jml1 == 0) {
            $file = $this->crud->get('surat_eksternal', array('id_surat_eksternal' => $id))->row_array();
            unlink($file['file_path']);
            $this->crud->delete('surat_eksternal', 'id_surat_eksternal', $id);
            $this->message = 'Surat Eksternal Berhasil Dihapus';
            $this->session->set_flashdata('success', $this->message);
            if ($this->session->userdata('level') == 1) {
                redirect('admin/surat-eksternal/masuk');
            } else {
                redirect('admin/surat-eksternal/masuk');
            }
        } else {
            $this->message = "Gagal menghapus, surat sudah ada disposisi";
            $this->session->set_flashdata('warning', $this->message);
            redirect('admin/surat-eksternal/masuk');
        }
    }

}
