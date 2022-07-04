<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('GlobalCrud', 'crud');
        $this->load->model('pegawai');
        $this->load->model('UserModel', 'user');
        $this->load->model('DokumenDataModel', 'dokumen');
        $this->load->model('SuratInternal', 'internal');
        $this->load->model('SuratEksternal', 'eksternal');
        $this->load->model('BackupModel', 'backup');
        if ($this->session->userdata('level') != 1) {
            redirect('login');
        }
    }

    function index()
    {
        $destinasi_surat = array('destinasi_surat' => $this->session->userdata('id_user'));
        $asal_surat = array('jenis_surat' => 'keluar');
        $asal_eks = array('asal_surat_pengguna' => $this->session->userdata('id_user'));
        $destinasi_eks = array('jenis_surat' => 'masuk');

        $data = array(
            'title' => 'Admin',
            'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
            'view_internal_jenis' => $this->crud->view_internal_jenis()->result(),
            'view_internal_prioritas' => $this->crud->view_internal_prioritas()->result(),
            'view_internal_sifat' => $this->crud->view_internal_sifat()->result(),
            'view_internal_media' => $this->crud->view_internal_media()->result(),
            'view_eksternal_jenis' => $this->crud->view_eksternal_jenis()->result(),
            'view_eksternal_prioritas' => $this->crud->view_eksternal_prioritas()->result(),
            'view_eksternal_sifat' => $this->crud->view_eksternal_sifat()->result(),
            'view_eksternal_media' => $this->crud->view_eksternal_media()->result(),
            //'set_internal_masuk' => $this->crud->get('surat_internal',$destinasi_surat)->num_rows(),
            'set_internal_keluar' => $this->crud->get('surat_internal', $asal_surat)->num_rows(),
            //'set_eksternal_keluar' => $this->crud->get('surat_eksternal',$asal_eks)->num_rows(),
            'set_eksternal_masuk' => $this->crud->get('surat_eksternal', $destinasi_eks)->num_rows(),
            'set_akun' => $this->crud->count_table('user'),
            'set_unit' => $this->crud->count_table('unit_kerja'),
            'set_jabatan' => $this->crud->count_table('jabatan'),
            'set_pegawai' => $this->crud->count_table('pegawai')


        );

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/nav');
        $this->load->view('admin/dashboard', $data);
        $this->load->view('layouts/footer');
    }

    function akun()
    {
        $data = array(
            'title' => 'Kelola Akun',
            'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
            'set_pegawai' => $this->pegawai->join_pegawai_jabatan_unitkerja()->result(),
            'set' => $this->pegawai->join_pegawai_user()->result()

        );
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/nav');
        $this->load->view('admin/akun/kelola', $data);
        $this->load->view('layouts/footer');
    }

    function surat_internal($jenis_surat)
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

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/nav');
        $this->load->view('admin/surat-internal/kelola', $data);
        $this->load->view('layouts/footer');
    }

    function surat_eksternal($jenis_surat)
    {

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

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/nav');
        $this->load->view('admin/surat-eksternal/kelola', $data);
        $this->load->view('layouts/footer');
    }

    function arsip_formulir()
    {
        $data = array(
            'title' => 'Arsip Formulir',
            'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
            'set' => $this->crud->all('arsip_formulir')->result()
        );

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/nav');
        $this->load->view('admin/arsip-formulir/kelola', $data);
        $this->load->view('layouts/footer');
    }

    function arsip_dokumen(){
        $data = array(
            'title' => 'Arsip Dokumen',
            'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
            'set' => $this->crud->all('arsip_dokumen')->result(),
            'set_jenis' => $this->crud->all('jenis_surat')->result(),
            'set_sifat' => $this->crud->all('sifat_surat')->result(),  
            'set_dokumen' => $this->dokumen->get_list_document()  
        );


        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/nav');
        $this->load->view('admin/arsip-dokumen/kelola', $data);
        $this->load->view('layouts/footer');
    }

    function pegawai()
    {
        $this->load->model('jabatan');


        $data = array(
            'title' => 'Kelola Pegawai',
            'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
            'set' => $this->pegawai->join_pegawai_jabatan_unitkerja()->result(),
            'set_unit' => $this->crud->all('unit_kerja')->result(),
            'set_jabatan' => $this->jabatan->join_jabatan_unitkerja()->result(),
            'unit_selected' => '',
            'jabatan_selected' => ''
        );

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/nav');
        $this->load->view('admin/pegawai/kelola', $data);
        $this->load->view('layouts/footer');
    }



    function jenis_surat()
    {
        $data = array(
            'title' => 'Jenis Surat',
            'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
            'set' => $this->crud->all('jenis_surat')->result()
        );

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/nav');
        $this->load->view('admin/jenis-surat/kelola', $data);
        $this->load->view('layouts/footer');
    }

    function sifat_surat()
    {
        $data = array(
            'title' => 'Sifat Surat',
            'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
            'set' => $this->crud->all('sifat_surat')->result()
        );

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/nav');
        $this->load->view('admin/sifat-surat/kelola', $data);
        $this->load->view('layouts/footer');
    }

    function prioritas_surat()
    {
        $data = array(
            'title' => 'Prioritas Surat',
            'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
            'set' => $this->crud->all('prioritas_surat')->result()
        );

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/nav');
        $this->load->view('admin/prioritas-surat/kelola', $data);
        $this->load->view('layouts/footer');
    }

    function media_surat()
    {
        $data = array(
            'title' => 'Media Surat',
            'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
            'set' => $this->crud->all('media_surat')->result()
        );

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/nav');
        $this->load->view('admin/media-surat/kelola', $data);
        $this->load->view('layouts/footer');
    }

    function perintah_disposisi()
    {
        $data = array(
            'title' => 'Perintah Disposisi',
            'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
            'set' => $this->crud->all('perintah_disposisi')->result()
        );

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/nav');
        $this->load->view('admin/perintah-disposisi/kelola', $data);
        $this->load->view('layouts/footer');
    }



    function lokasi_surat()
    {
        $data = array(
            'title' => 'Lokasi Surat',
            'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
            'set' => $this->crud->all('lokasi_surat')->result()
        );

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/nav');
        $this->load->view('admin/lokasi-surat/kelola', $data);
        $this->load->view('layouts/footer');
    }

    function unit_kerja()
    {
        $data = array(
            'title' => 'Kelola Unit Kerja',
            'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
            'set' => $this->crud->all('unit_kerja')->result()
        );

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/nav');
        $this->load->view('admin/unit-kerja/kelola', $data);
        $this->load->view('layouts/footer');
    }

    function jabatan()
    {
        $this->load->model('Jabatan', 'jabatan');
        $data = array(
            'title' => 'Kelola Jabatan',
            'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
            'set' => $this->jabatan->join_jabatan_unitkerja()->result(),
            'set_unit' => $this->crud->all('unit_kerja')->result()
        );

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/nav');
        $this->load->view('admin/jabatan/kelola', $data);
        $this->load->view('layouts/footer');
    }

    function pengaturan()
    {
        $data = array(
            'title' => 'Pengaturan Situs',
            'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
            'set' => $this->crud->all('pengaturan')->result()
        );

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/nav');
        $this->load->view('admin/pengaturan/kelola', $data);
        $this->load->view('layouts/footer');
    }



    /**
     * Show Backup DB page
     *
     */
    public function backup()
    {
        $data = array(
            'title' => 'Backup DB',
            'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
            'set' => $this->crud->all('pengaturan')->result()
        );
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/nav');
        $this->load->view('admin/backup', $data);
        $this->load->view('layouts/footer');
    }

    public function backup_list()
    {
        $list = $this->backup->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $value->file_name;
            $row[] = '<a href="' . "" . base_url() . $value->file_path . "" . '" title="">' . "" . $value->file_path . "" . '</a>';
            $row[] = $value->created_at;

            //add html for action
            $row[] = '<a class="btn btn-danger p-2" href="#" title="Hapus" onClick="delete_backup(' . "'" . $value->id_backup . "'" . ')"><i class="fa fa-trash"></i>Hapus</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->backup->count_all(),
            "recordsFiltered" => $this->backup->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function backup_save()
    {
        $tanggal = date('Ymd-His');
        $namaFile = 'backup-' . $tanggal . '.sql.zip';
        $pathFile = 'files/backup';
        $this->load->dbutil();
        $backup = &$this->dbutil->backup();
        // Load the file helper and write the file to your server
        $this->load->helper('file');
        write_file($pathFile . '/' . $namaFile, $backup);

        $input = array(
            'file_name' => $namaFile,
            'file_path' => $pathFile . '/' . $namaFile,
            'created_at' => date('Y-m-d H:i:s')
        );

        $save = $this->crud->insert('backup', $input);

        echo json_encode(array("status" => TRUE));
    }

    public function backup_delete($id)
    {
        $query = $this->backup->get_by_id($id);
        unlink($query->file_path);

        $this->backup->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}
