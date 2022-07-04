<?php
if (defined('basepath')) exit('No direct access script allowed');

class User extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('GlobalCrud', 'crud');
        $this->load->model('PemilikDokumenModel', 'pemilikDokumen');
        $this->load->model('PihakDokumenModel', 'pihakDokumen');
        $this->load->model('DokumenDataModel', 'dokumen');
        $this->load->model('SuratInternal', 'internal');
        $this->load->model('JenisDataModel', 'jenisData');
        $this->load->model('SuratEksternal', 'eksternal');
        $this->load->model('UserModel', 'user');
        if ($this->session->userdata('level') != '0') {
            redirect('login');
        }
        $this->form_validation->set_error_delimiters('', '');

    }

    function index()
    {
        $destinasi_surat = array('destinasi_surat' => $this->session->userdata('id_user'));
        $asal_surat = array('asal_surat' => $this->session->userdata('id_user'));
        $asal_eks = array('asal_surat_pengguna' => $this->session->userdata('id_user'));
        $destinasi_eks = array('tujuan_surat_pengguna' => $this->session->userdata('id_user'));
        $tujuan_disposisi = array('tujuan_disposisi' => $this->session->userdata('id_user'));

        $data = array(
            'title' => 'User',
            'name' => $this->session->userdata('name'),
            'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
            'set_internal_masuk' => $this->crud->get('surat_internal', $destinasi_surat)->num_rows(),
            'set_internal_keluar' => $this->crud->get('surat_internal', $asal_surat)->num_rows(),
            'set_eksternal_keluar' => $this->crud->get('surat_eksternal', $asal_eks)->num_rows(),
            'set_eksternal_masuk' => $this->crud->get('surat_eksternal', $destinasi_eks)->num_rows(),
            'get_disposisi_internal' => $this->crud->get('disposisi_internal', $tujuan_disposisi)->num_rows(),
            'get_disposisi_eksternal' => $this->crud->get('disposisi_eksternal', $tujuan_disposisi)->num_rows(),
        );

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/nav', $data);
        $this->load->view('user/dashboard', $data);
        $this->load->view('layouts/footer');
    }

    function validation()
    {
        $this->form_validation->set_rules('nama_dokumen', 'Nama Dokumen', 'required');
        $this->form_validation->set_rules('nomor_dokumen', 'Nomor Dokumen', 'required');
        $this->form_validation->set_rules('tanggal_dokumen', 'Tanggal Dokumen', 'required');
        //$this->form_validation->set_rules('file_path', '', 'callback_file_check');
    }

    function surat_internal($jenis_surat)
    {
        $tujuan_disposisi = array('tujuan_disposisi' => $this->session->userdata('id_user'));
        if ($jenis_surat == 'masuk') {

            $data = array(
                'title' => 'Surat Internal Masuk',
                'set' => $this->internal->get_surat_destinasi('surat_internal', array('jenis_surat' => 'keluar', 'asal_surat' => $this->session->userdata('id_user')))->result(),
                'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
                'jenis' => 'Masuk',
                'set_destinasi' => $this->user->destinasi_surat($this->session->userdata('id_user'))->result(),
                'set_jenis' => $this->crud->all('jenis_surat')->result(),
                'set_prioritas' => $this->crud->all('prioritas_surat')->result(),
                'set_sifat' => $this->crud->all('sifat_surat')->result(),
                'set_media' => $this->crud->all('media_surat')->result(),
                'pembuat' => $this->session->userdata('id_user'),
                'get_disposisi_internal' => $this->crud->get('disposisi_internal', $tujuan_disposisi)->num_rows(),
                'get_disposisi_eksternal' => $this->crud->get('disposisi_eksternal', $tujuan_disposisi)->num_rows(),
            );
        } else {

            $data = array(
                'title' => 'Surat Internal Keluar',
                'set' => $this->internal->get_surat_destinasi('surat_internal', array('jenis_surat' => 'keluar', 'asal_surat' => $this->session->userdata('id_user')))->result(),
                'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
                'jenis' => 'Keluar',
                'set_destinasi' => $this->user->destinasi_surat($this->session->userdata('id_user'))->result(),
                'set_jenis' => $this->crud->all('jenis_surat')->result(),
                'set_prioritas' => $this->crud->all('prioritas_surat')->result(),
                'set_sifat' => $this->crud->all('sifat_surat')->result(),
                'set_media' => $this->crud->all('media_surat')->result(),
                'pembuat' => $this->session->userdata('id_user'),
                'get_disposisi_internal' => $this->crud->get('disposisi_internal', $tujuan_disposisi)->num_rows(),
                'get_disposisi_eksternal' => $this->crud->get('disposisi_eksternal', $tujuan_disposisi)->num_rows(),
            );
        }

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/nav', $data);
        $this->load->view('user/surat-internal/kelola', $data);
        $this->load->view('layouts/footer');
    }

    function surat_eksternal($jenis_surat)
    {
        $tujuan_disposisi = array('tujuan_disposisi' => $this->session->userdata('id_user'));
        if ($jenis_surat == "masuk") {
            //print_r($this->eksternal->get_surat_destinasi('asal_surat_pengguna',$this->session->userdata('id_user'))->result());
            $data = array(
                'title' => 'Surat Eksternal Masuk',
                'set' => $this->eksternal->get_surat_destinasi('surat_eksternal', array('tujuan_surat_pengguna' => $this->session->userdata('id_user')))->result(),
                'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
                'jenis' => 'Masuk',
                'set_destinasi' => $this->user->destinasi_surat($this->session->userdata('id_user'))->result(),
                'set_jenis' => $this->crud->all('jenis_surat')->result(),
                'set_prioritas' => $this->crud->all('prioritas_surat')->result(),
                'set_sifat' => $this->crud->all('sifat_surat')->result(),
                'set_media' => $this->crud->all('media_surat')->result(),
                'pembuat' => $this->session->userdata('id_user'),
                'get_disposisi_internal' => $this->crud->get('disposisi_internal', $tujuan_disposisi)->num_rows(),
                'get_disposisi_eksternal' => $this->crud->get('disposisi_eksternal', $tujuan_disposisi)->num_rows(),
            );
        } else {

            $data = array(
                'title' => 'Surat Eksternal Keluar',
                'set' => $this->eksternal->get_surat_destinasi('surat_eksternal', array('asal_surat_pengguna' => $this->session->userdata('id_user')))->result(),
                'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
                'jenis' => 'Keluar',
                'set_destinasi' => $this->user->destinasi_surat($this->session->userdata('id_user'))->result(),
                'set_jenis' => $this->crud->all('jenis_surat')->result(),
                'set_prioritas' => $this->crud->all('prioritas_surat')->result(),
                'set_sifat' => $this->crud->all('sifat_surat')->result(),
                'set_media' => $this->crud->all('media_surat')->result(),
                'pembuat' => $this->session->userdata('id_user'),
                'get_disposisi_internal' => $this->crud->get('disposisi_internal', $tujuan_disposisi)->num_rows(),
                'get_disposisi_eksternal' => $this->crud->get('disposisi_eksternal', $tujuan_disposisi)->num_rows(),
            );
        }

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/nav', $data);
        $this->load->view('user/surat-eksternal/kelola', $data);
        $this->load->view('layouts/footer');
    }

    function inbox_eksternal()
    {
        $tujuan_disposisi = array('tujuan_disposisi' => $this->session->userdata('id_user'));
        //print_r($this->eksternal->set_surat($id)->result());    
        $data = array(
            'title' => 'Daftar Disposisi',
            'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
            'set' => $this->eksternal->join_disposisi_pegawai($this->session->userdata('id_user'))->result(),
            //'set_surat' => $this->eksternal->set_surat($id)->result(),
            'set_perintah' => $this->crud->all('perintah_disposisi')->result(),
            'set_unit' => $this->crud->all('unit_kerja')->result(),
            'get_disposisi_internal' => $this->crud->get('disposisi_internal', $tujuan_disposisi)->num_rows(),
            'get_disposisi_eksternal' => $this->crud->get('disposisi_eksternal', $tujuan_disposisi)->num_rows(),
            //'set_jabatan' => $this->jabatan->join_jabatan_unitkerja()->result(),
            //'set_pegawai' => $this->pegawai->join_pegawai_jabatan()->result(),
            //'pegawai_selected' => '',
            //'unit_selected' => '',
            //'jabatan_selected' => '',
            //'id_surat_eksternal' => $id, 

        );

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/nav', $data);
        $this->load->view('user/inbox/disposisi-eksternal', $data);
        $this->load->view('layouts/footer');
    }

    function inbox_internal()
    {
        $tujuan_disposisi = array('tujuan_disposisi' => $this->session->userdata('id_user'));
        //print_r($this->eksternal->set_surat($id)->result());    
        $data = array(
            'title' => 'Daftar Disposisi',
            'setting' => $this->crud->get('pengaturan', array('id_pengaturan' => '1'))->row(),
            'set' => $this->internal->join_disposisi_pegawai($this->session->userdata('id_user'))->result(),
            //'set_surat' => $this->eksternal->set_surat($id)->result(),
            'set_perintah' => $this->crud->all('perintah_disposisi')->result(),
            'set_unit' => $this->crud->all('unit_kerja')->result(),
            'get_disposisi_internal' => $this->crud->get('disposisi_internal', $tujuan_disposisi)->num_rows(),
            'get_disposisi_eksternal' => $this->crud->get('disposisi_eksternal', $tujuan_disposisi)->num_rows(),
            //'set_jabatan' => $this->jabatan->join_jabatan_unitkerja()->result(),
            //'set_pegawai' => $this->pegawai->join_pegawai_jabatan()->result(),
            //'pegawai_selected' => '',
            //'unit_selected' => '',
            //'jabatan_selected' => '',
            //'id_surat_eksternal' => $id, 

        );

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/nav', $data);
        $this->load->view('user/inbox/disposisi-internal', $data);
        $this->load->view('layouts/footer');
    }

    public function count_inbox_internal()
    {
        $tujuan_disposisi = array('tujuan_disposisi' => $this->session->userdata('id_user'));
        $tot1 = $this->crud->get('disposisi_internal', $tujuan_disposisi)->num_rows();
        $result['tot1'] = $tot1;
        $result['msg'] = 'Test';
        echo json_encode($result);
    }

    public function count_inbox_eksternal()
    {
        $tujuan_disposisi = array('tujuan_disposisi' => $this->session->userdata('id_user'));
        $tot2 = $this->crud->get('disposisi_eksternal', $tujuan_disposisi)->num_rows();
        $result['tot2'] = "{$tot2}";
        $result['msg'] = 'Test';
        echo json_encode($result);
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
        $this->load->view('user/arsip-dokumen/kelola', $data);
        $this->load->view('layouts/footer');
    }

    function dokumen_list()
    {
        $list = $this->dokumen->get_datatables();


        $data = array();
        $no = $_POST['start'];
        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $value->id_dokumen;
            $row[] = '<p class="text-wrap mb-0" style="width: 70%;">'.$value->nama_dokumen.'</p>';
            $row[] = '<p class="text-wrap mb-0" style="width: 50%;">'.$value->nama_jenis.'</p>';
            $row[] = '<p class="text-wrap mb-0" style="width: 40%;">'.$value->nomor_dokumen.'</p>';
            // $row[] = '<a href="'.base_url().$value->file_path.'" title="" alt=""><i class="fa fa-download fa-lg"></i></a>';
            $row[] = $value->tanggal_dokumen;
            $row[] = '<p class="text-wrap mb-0" style="width: 100%;">'.$value->nama_pegawai.'</p>';
            //add html for action
           
            //cek whether owner is self
            $list_dokumen_owner = $this->pemilikDokumen->get_list_owner_by_id_document($value->id_dokumen);
            $exist = 0;
            
            foreach ($list_dokumen_owner as $value1) {
                if($value1->id_unit_kerja == $this->session->userdata('id_unit')){
                  $exist = 1;
                  $temp = $value1->id_unit;
                }
            }

            if($exist == 1){
                $row[] = '
                <a class="btn btn-sm btn-success p-2" href="#" title="Hapus" onClick="update_dokumen(' . "'" . $value->id_dokumen . "'" . ')"><i class="fa fa-edit"></i> Edit</a>
                <a class="btn btn-sm btn-primary p-2" href="#" title="Hapus" onClick="view_dokumen(' . "'" . $value->id_dokumen . "'" . ')"><i class="fa fa-eye"></i>  Lihat</a>';

            }else{
                $row[] = '
                <button class="btn btn-sm btn-success p-2" href="#" title="Hapus" disabled ><i class="fa fa-eye"></i> Edit</button>
                <button class="btn btn-sm btn-primary p-2" href="#" title="Hapus" disabled ><i class="fa fa-eye"></i> Lihat</button>';
                
            }
            
            
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->dokumen->count_all(),
            "recordsFiltered" => $this->dokumen->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function dokumen_add()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'response' => 'error',
                'error'   => true,
                'nama_dokumenError' => form_error('nama_dokumen'),
                'nomor_dokumenError' => form_error('nomor_dokumen'),
                'id_jenisError' => form_error('id_jenis'),
                'jenis_dokumenError' => form_error('jenis_dokumen'),
                'tanggal_dokumenError' => form_error('tanggal_dokumen'),
                'file_pathError' => form_error('file_path'),
                'message' => validation_errors(),
                'dariError' => form_error('dari'),
                'tujuanError' => form_error('tujuan'),

            );
        } else {
            $config = array(
                'upload_path' => 'files/arsip-dokumen',
                'allowed_types' => 'png|jpg|pdf|docx|doc|xls|xlsx',
                'remove_space' => TRUE,
                'encrypt_name' => TRUE,
                'max_size' => 50000,
                'min_width' => 1,
                'min_height' => 1,
                'max_width' => 1028,
                'max_height' => 768
            );

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file_path')) {
                $file = $this->upload->data();
                $data = array(
                    'nama_dokumen' => $this->input->post('nama_dokumen'),
                    'id_jenis' => $this->input->post('id_jenis'),
                    'nomor_dokumen' => $this->input->post('nomor_dokumen'),
                    'id_sifat' => $this->input->post('id_sifat'),
                    'tanggal_dokumen' => $this->input->post('tanggal_dokumen'),
                    'nomor_disposisi' => $this->input->post('nomor_disposisi'),
                    'dari' => $this->input->post('dari'),
                    'tujuan' => $this->input->post('tujuan'),
                    'keterangan' => $this->input->post('keterangan'),
                    'file_name' => $file['file_name'],
                    'file_path' => $config['upload_path'] . "/" . $file['file_name'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('id_user'),
                );
                $inserted_id = $this->dokumen->save($data);
                
                $data = array(
                    'id_dokumen' => $inserted_id,
                    'id_unit_kerja' => $this->session->userdata('id_unit'),
                );
                $this->pemilikDokumen->save($data);

                $data['list_pihak'] = $_POST['list_pihak'];
                $list_pihak = explode("#", $_POST['list_pihak']);
                for($j = 0; $j < count($list_pihak); $j++){
                    $data = array(
                        'id_dokumen' => $inserted_id,
                        'pihak' => $list_pihak[$j],
                    );
                    $this->pihakDokumen->save($data); 
                }
            } else {
                $data = array(
                    'response' => 'error',
                    'error'   => true,
                    'file_pathError' => $this->upload->display_errors('<p class="text-danger mt-2">', '</p>'),
                    'message' => validation_errors(),
                    'list_pihak' => $_POST['list_pihak'],
                );
            }
        }

        echo json_encode($data);
    }

    // function dokumen_update(){
    //     $config = array(
    //         'upload_path' => 'files/arsip-dokumen',
    //         'allowed_types' => 'png|jpg|pdf|docx|doc|xls|xlsx',
    //         'remove_space' => TRUE,
    //         'encrypt_name' => TRUE,
    //         'max_size' => 50000,
    //         'min_width' => 1,
    //         'min_height' => 1,
    //         'max_width' => 1028,
    //         'max_height' => 768
    //     );

    //     $this->load->library('upload', $config);
    //     $this->upload->initialize($config);
    //     $this->upload->do_upload('file_path');

    //     if ($_FILES['file_path']['size'] == 0 && $_FILES['file_path']['error'] == 0){
    //         $data = array(
    //             'nama_dokumen' => $this->input->post('nama_dokumen'),
    //             'id_jenis' => $this->input->post('id_jenis'),
    //             'nomor_dokumen' => $this->input->post('nomor_dokumen'),
    //             'id_sifat' => $this->input->post('id_sifat'),
    //             'tanggal_dokumen' => $this->input->post('tanggal_dokumen'),
    //             'nomor_disposisi' => $this->input->post('nomor_disposisi'),
    //             'dari' => $this->input->post('dari'),
    //             'tujuan' => $this->input->post('tujuan'),
    //             'keterangan' => $this->input->post('keterangan'),
    //             'updated_at' => date('Y-m-d H:i:s'),
    //             'updated_by' => $this->session->userdata('id_user'),
    //         );
    //         $update = $this->dokumen->update(array('id_dokumen' => $this->input->post('id_dokumen')), $data);
    //     }else{
    //         $files = $this->crud->get('arsip_dokumen', array('id_dokumen' => $this->input->post('id_dokumen')))->row_array();
    //         unlink($files['file_path']);

    //         $file = $this->upload->data();

    //         $data = array(
    //             'nama_dokumen' => $this->input->post('nama_dokumen'),
    //             'id_jenis' => $this->input->post('id_jenis'),
    //             'nomor_dokumen' => $this->input->post('nomor_dokumen'),
    //             'id_sifat' => $this->input->post('id_sifat'),
    //             'tanggal_dokumen' => $this->input->post('tanggal_dokumen'),
    //             'nomor_disposisi' => $this->input->post('nomor_disposisi'),
    //             'dari' => $this->input->post('dari'),
    //             'tujuan' => $this->input->post('tujuan'),
    //             'keterangan' => $this->input->post('keterangan'),
    //             'file_name' => $file['file_name'],
    //             'file_path' => $config['upload_path'] . "/" . $file['file_name'],
    //             'updated_at' => date('Y-m-d H:i:s'),
    //             'updated_by' => $this->session->userdata('id_user'),
    //         );
    //         $update = $this->dokumen->update(array('id_dokumen' => $this->input->post('id_dokumen')), $data);
    //     }
            
    //         $data['list_pihak'] = $_POST['list_pihak'];

    //         //pihak 
    //         //delete
    //         $this->pihakDokumen->delete_by_id_document($this->input->post('id_dokumen'));
    //         $list_pihak = explode("#", $_POST['list_pihak']);
    //         for($j = 0; $j < count($list_pihak); $j++){
    //             $data = array(
    //                 'id_dokumen' => $this->input->post('id_dokumen'),
    //                 'pihak' => $list_pihak[$j],
    //             );

    //             $this->pihakDokumen->save($data);
    //         }

    //     echo json_encode($data);
    // }

    function dokumen_update(){
        if(empty($_FILES['file_path']['tmp_name']) || !is_uploaded_file($_FILES['file_path']['tmp_name'])){

            //if(!$_FILES['file_path']) {
                $data = array(
                    'nama_dokumen' => $this->input->post('nama_dokumen'),
                    'id_jenis' => $this->input->post('id_jenis'),
                    'nomor_dokumen' => $this->input->post('nomor_dokumen'),
                    'id_sifat' => $this->input->post('id_sifat'),
                    'tanggal_dokumen' => $this->input->post('tanggal_dokumen'),
                    'nomor_disposisi' => $this->input->post('nomor_disposisi'),
                    'dari' => $this->input->post('dari'),
                    'tujuan' => $this->input->post('tujuan'),
                    'keterangan' => $this->input->post('keterangan'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->session->userdata('id_user'),
                );
                $update = $this->dokumen->update(array('id_dokumen' => $this->input->post('id_dokumen')), $data);
    
                $data['list_pihak'] = $_POST['list_pihak'];
                
                //pihak 
                //delete
                $this->pihakDokumen->delete_by_id_document($this->input->post('id_dokumen'));
                $list_pihak = explode("#", $_POST['list_pihak']);
                for($j = 0; $j < count($list_pihak); $j++){
                    $data = array(
                        'id_dokumen' => $this->input->post('id_dokumen'),
                        'pihak' => $list_pihak[$j],
                    );
    
                    $this->pihakDokumen->save($data);
                }
        }else{
            $config = array(
                'upload_path' => 'files/arsip-dokumen',
                'allowed_types' => 'png|jpg|pdf|docx|doc|xls|xlsx',
                'remove_space' => TRUE,
                'encrypt_name' => TRUE,
                'max_size' => 50000,
                'min_width' => 1,
                'min_height' => 1,
                'max_width' => 1028,
                'max_height' => 768
            );

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            $files = $this->crud->get('arsip_dokumen', array('id_dokumen' => $this->input->post('id_dokumen')))->row_array();
            unlink($files['file_path']);

            if ($this->upload->do_upload('file_path')) {

                $file = $this->upload->data();
                $data = array(
                    'nama_dokumen' => $this->input->post('nama_dokumen'),
                    'id_jenis' => $this->input->post('id_jenis'),
                    'nomor_dokumen' => $this->input->post('nomor_dokumen'),
                    'id_sifat' => $this->input->post('id_sifat'),
                    'tanggal_dokumen' => $this->input->post('tanggal_dokumen'),
                    'nomor_disposisi' => $this->input->post('nomor_disposisi'),
                    'dari' => $this->input->post('dari'),
                    'tujuan' => $this->input->post('tujuan'),
                    'keterangan' => $this->input->post('keterangan'),
                    'file_name' => $file['file_name'],
                    'file_path' => $config['upload_path'] . "/" . $file['file_name'],
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->session->userdata('id_user'),
                );
                $update = $this->dokumen->update(array('id_dokumen' => $this->input->post('id_dokumen')), $data);
                $data['list_pihak'] = $_POST['list_pihak'];
                
                //pihak 
                //delete
                $this->pihakDokumen->delete_by_id_document($this->input->post('id_dokumen'));
                $list_pihak = explode("#", $_POST['list_pihak']);
                for($j = 0; $j < count($list_pihak); $j++){
                    $data = array(
                        'id_dokumen' => $this->input->post('id_dokumen'),
                        'pihak' => $list_pihak[$j],
                    );

                    $this->pihakDokumen->save($data);
                }
            } else {
                $data = array(
                    'response' => '--',
                    'error'   => false,
                    'file_pathError' => $this->upload->display_errors('<p class="text-danger mt-2">', '</p>'),
                    'message' => validation_errors(),
                    'list_pihak' => $_POST['list_pihak'],
                );
            }

            
        }

        echo json_encode($data);
    }


    function dokumen_delete($id)
    {
        $file = $this->crud->get('arsip_dokumen', array('id_dokumen' => $id))->row_array();
        unlink($file['file_path']);
        $this->dokumen->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    function dokumen_view($id)
    {
        $data = array(
            'data' => $this->dokumen->get_detail_document($id),
            'list_owner' => $this->pemilikDokumen->get_list_owner_by_id_document($id),
            'list_pihak' => $this->pihakDokumen->get_list_pihak_by_id_document($id),
        );

        echo json_encode($data);
    }

    function get_pihak_list($id_dokumen)
    {
        $data = $this->pihakDokumen->get_list_pihak_by_id_document($id_dokumen);
        
		echo json_encode($data);
    }
}
