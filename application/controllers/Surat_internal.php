<?php
if (defined('basepath')) exit('No direct access script allowed');

class Surat_internal extends CI_Controller
{
    var $message;
    function __construct()
    {
        parent::__construct();
        $this->load->model('GlobalCrud', 'crud');
        $this->load->model('UserModel', 'user');
        $this->load->model('SuratInternal', 'internal');
        $this->form_validation->set_error_delimiters('', '');
    }

    function validation($keluar = true)
    {
        $this->form_validation->set_rules('nomor_surat', 'Nomor Surat', 'required');
        $this->form_validation->set_rules('perihal', 'Perihal', 'required');
        if ($keluar) {
            $this->form_validation->set_rules('destinasi_surat', 'Destinasi Surat', 'required');
        }
        $this->form_validation->set_rules('isi_ringkas', 'Isi Ringkas', 'required');
        $this->form_validation->set_rules('tanggal_surat', 'Tanggal Surat', 'required');
        $this->form_validation->set_rules('tanggal_transaksi', 'Tanggal Transaksi', 'required');
        $this->form_validation->set_rules('lokasi_surat', 'Lokasi Surat', 'required');
    }

    function tambah($jenis_surat)
    {
        if ($jenis_surat == 'masuk') {

            $data = array(
                'title' => 'Surat Internal Masuk',
                'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
                'set' => $this->internal->get_surat_destinasi('surat_internal', array('jenis_surat' => 'masuk'))->result(),
                'jenis' => 'Masuk',
                'set_jenis' => $this->crud->all('jenis_surat')->result(),
                'set_prioritas' => $this->crud->all('prioritas_surat')->result(),
                'set_sifat' => $this->crud->all('sifat_surat')->result(),
                'set_media' => $this->crud->all('media_surat')->result(),
                'pembuat' => $this->session->userdata('id_user')
            );
        } else if ($jenis_surat == 'keluar') {

            $data = array(
                'title' => 'Surat Internal Keluar',
                'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
                'set' => $this->internal->get_surat_destinasi('surat_internal', array('jenis_surat' => 'keluar'))->result(),
                'jenis' => 'Keluar',
                'set_destinasi' => $this->user->destinasi_surat($this->session->userdata('id_user'))->result(),
                'set_jenis' => $this->crud->all('jenis_surat')->result(),
                'set_prioritas' => $this->crud->all('prioritas_surat')->result(),
                'set_sifat' => $this->crud->all('sifat_surat')->result(),
                'set_media' => $this->crud->all('media_surat')->result(),
                'pembuat' => $this->session->userdata('id_user')
            );
        }

        if ($_GET['act'] == 'submit_masuk') {

        }

        if ($_GET['act'] == 'submit_keluar') {
            $this->validation();
            if ($this->form_validation->run() == FALSE) {
                $this->message = 'Semua Komponen Surat Wajib Diisi!';
                $this->session->set_flashdata('danger', $this->message);
            } else {
                $config = array(
                    'upload_path' => 'files/surat-internal',
                    'allowed_types' => 'pdf|jpg|png',
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
                        'destinasi_surat' => $this->input->post('destinasi_surat'),
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
                        'asal_surat' => $this->input->post('asal_surat'),
                        'jenis_surat' => 'keluar'
                    );
    
                    $this->crud->insert('surat_internal', $query);
                    $this->message = "Surat Internal Keluar Berhasil Ditambah";
                    $this->session->userdata('success', $this->message);
                    if ($this->session->userdata('level') == 1) {
                        redirect('admin/surat-internal/keluar');
                    } else {
                        redirect('user/surat-internal/keluar');
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
        $this->load->view('admin/surat-internal/tambah', $data);
        $this->load->view('layouts/footer');
    }

    /* function create()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $this->message = 'Semua Komponen Surat Wajib Diisi!';
            $this->session->set_flashdata('danger', $this->message);
            if ($this->session->userdata('level') == 1) {
                redirect('surat-internal/tambah/keluar');
            } else {
                redirect('surat-internal/tambah/keluar');
            }
        } else {

            $config = array(
                'upload_path' => 'files/surat-internal',
                'allowed_types' => 'pdf|jpg|png',
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
                    'destinasi_surat' => $this->input->post('destinasi_surat'),
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
                    'asal_surat' => $this->input->post('asal_surat'),
                    'jenis_surat' => 'keluar'
                );

                $this->crud->insert('surat_internal', $query);
                $this->message = "Surat Internal Keluar Berhasil Ditambah";
                $this->session->userdata('success', $this->message);
                if ($this->session->userdata('level') == 1) {
                    redirect('admin/surat-internal/keluar');
                } else {
                    redirect('user/surat-internal/keluar');
                }
            } else {
                $this->message = "Upload Berkas Error!";
                $this->session->set_flashdata('danger', $this->message);
                if ($this->session->userdata('level') == 1) {
                    redirect('admin/surat-internal/keluar');
                } else {
                    redirect('user/surat-internal/keluar');
                }
            }
        }
    } */

    function get($id)
    {
        $query = array('id_surat_internal' => $id);

        $result = $this->crud->get('surat_internal', $query)->row();
        echo json_encode($result);
    }

    /* function update()
    {
        if (isset($_FILES['file_path']['name'])) {

            $config = array(
                'upload_path' => 'files/surat-internal',
                'allowed_types' => 'pdf|jpg|png',
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
                    'destinasi_surat' => $this->input->post('destinasi_surat'),
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
                    'asal_surat' => $this->input->post('asal_surat')
                );
                $this->crud->update('surat_internal', $query, 'id_surat_internal', $this->input->post('id_surat_internal'));
                $this->message = "Surat Keluar Berhasil Diubah :)";
                $this->session->userdata('success', $this->message);
                redirect('admin/surat-internal/keluar');
            } else {
                $this->message = "Berkas gagal di unggah!";
                $this->session->userdata('danger', $this->message);
                redirect('admin/surat-internal/keluar');
            }
        } else {

            $query = array(
                'nomor_surat' => $this->input->post('nomor_surat'),
                'destinasi_surat' => $this->input->post('destinasi_surat'),
                'isi_ringkas' => $this->input->post('isi_ringkas'),
                'tanggal_surat' => $this->input->post('tanggal_surat'),
                'tanggal_transaksi' => $this->input->post('tanggal_transaksi'),
                'perihal' => $this->input->post('perihal'),
                'lokasi_surat' => $this->input->post('lokasi_surat'),
                'id_jenis' => $this->input->post('id_jenis'),
                'id_prioritas' => $this->input->post('id_prioritas'),
                'id_sifat' => $this->input->post('id_sifat'),
                'id_media' => $this->input->post('id_media'),
                'asal_surat' => $this->input->post('asal_surat')
            );
            $this->crud->update('surat_internal', $query, 'id_surat_internal', $this->input->post('id_surat_internal'));
            $this->message = "Surat Keluar Berhasil Diubah :)";
            $this->session->userdata('success', $this->message);
            redirect('admin/surat-internal/keluar');
        }
    } */

    function destroy($id)
    {
        $q1 = sprintf("SELECT count(id_surat_internal) jml FROM disposisi_internal WHERE id_surat_internal=%d", $id);
        $jml1 = $this->db->query($q1)->row_array()['jml'];
        if ($jml1 == 0) {
            $file = $this->crud->get('surat_internal', array('id_surat_internal' => $id))->row_array();
            unlink($file['file_path']);
            $this->crud->delete('surat_internal', 'id_surat_internal', $id);
            $this->message = 'Surat Internal Berhasil Dihapus';
            $this->session->set_flashdata('success', $this->message);
            if ($this->session->userdata('level') == 1) {
                redirect('admin/surat-internal/keluar');
            } else {
                redirect('admin/surat-internal/keluar');
            }
        } else {
            $this->message = "Gagal menghapus, surat sudah ada disposisi";
            $this->session->set_flashdata('warning', $this->message);
            redirect('admin/surat-internal/keluar');
        }
    }

}
