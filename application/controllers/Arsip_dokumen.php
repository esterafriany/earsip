<?php
if (defined('basepath')) exit('No direct access script allowed');

class Arsip_dokumen extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('GlobalCrud', 'crud');
        $this->load->model('DokumenDataModel', 'dokumen');
        $this->load->model('FormulirDataModel', 'formulir');
        $this->load->model('PemilikDokumenModel', 'pemilikDokumen');
        $this->load->model('PihakDokumenModel', 'pihakDokumen');
        $this->load->model('JenisDataModel', 'jenisData');
        $this->load->model('UserModel', 'user');
        if ($this->session->userdata('level') != 1) {
            redirect('login');
        }
        $this->form_validation->set_error_delimiters('', '');
    }

    function validation()
    {
        $this->form_validation->set_rules('nama_dokumen', 'Nama Dokumen', 'required');
        $this->form_validation->set_rules('nomor_dokumen', 'Nomor Dokumen', 'required');
        $this->form_validation->set_rules('tanggal_dokumen', 'Tanggal Dokumen', 'required');
        //$this->form_validation->set_rules('file_path', '', 'callback_file_check');
    }

    function create()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $this->message = "Komponen Dokumen Wajib Diisi !";
            $this->session->set_flashdata('warning', $this->message);
            redirect('admin/arsip-dokumen');
        } else {
            $config = array(
                'upload_path' => 'files/arsip-dokumen',
                'allowed_types' => 'png|jpg|jpeg|pdf|docx|doc|xls|xlsx',
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
                $query = array(
                    'nama_dokumen' => $this->input->post('nama_dokumen'),
                    'nomor_dokumen' => $this->input->post('nomor_dokumen'),
                    'id_jenis' => $this->input->post('id_jenis'),
                    'tanggal_dokumen' => $this->input->post('tanggal_dokumen'),
                    'keterangan' => $this->input->post('keterangan'),
                    'created_by' => $this->session->userdata('id_user'),
                    'file_path' => $config['upload_path'] . "/" . $file['file_name'],
                );
                $this->crud->insert('arsip_dokumen', $query);
                $this->message = "Dokumen Berhasil Dibuat !";
                $this->session->set_flashdata('success', $this->message);
                redirect('admin/arsip-dokumen');
            } else {
                $this->message = "Berkas gagal diupload !";
                $this->session->set_flashdata('warning', $this->message);
                redirect('admin/arsip-formulir');
            }
        }
    }

    function destroy($id)
    {
        $file = $this->crud->get('arsip_dokumen', array('id_dokumen' => $id))->row_array();
        unlink($file['file_path']);
        $this->crud->delete('arsip_dokumen', 'id_dokumen', $id);
        $this->message = "Dokumen Berhasil Dihapus";
        $this->session->set_flashdata('success', $this->message);
        redirect('admin/arsip-dokumen');
    }

 
    function dokumen_list()
    {
        $list = $this->dokumen->get_datatables();
        $data = array();
        $no = $_POST['start'];
        $num = 1;
        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $num;
            $row[] = '<p class="text-wrap mb-0" style="width: 70%;">'.$value->nama_dokumen.'</p>';
            $row[] = '<p class="text-wrap mb-0" style="width: 50%;">'.$value->nama_jenis.'</p>';
            $row[] = '<p class="text-wrap mb-0" style="width: 40%;">'.$value->nomor_dokumen.'</p>';
            // $row[] = '<a href="'.base_url().$value->file_path.'" title="" alt=""><i class="fa fa-download fa-lg"></i></a>';
            $row[] = $value->tanggal_dokumen;
            //$row[] = $value->keterangan ? $value->keterangan:"<small style=\"color:red\">Keterangan Kosong</small>";
            $row[] = '<p class="text-wrap mb-0" style="width: 100%;">'.$value->nama_pegawai.'</p>';
            //add html for action
            $row[] = '
            <a class="btn btn-sm btn-success p-2" href="#" title="Hapus" onClick="update_dokumen(' . "'" . $value->id_dokumen . "'" . ')"><i class="fa fa-edit"></i> Edit</a>
            <a class="btn btn-sm btn-primary p-2" href="#" title="Hapus" onClick="view_dokumen(' . "'" . $value->id_dokumen . "'" . ')"><i class="fa fa-eye"></i> Lihat</a>
            <a class="btn btn-sm btn-danger p-2" href="#" title="Hapus" onClick="delete_dokumen(' . "'" . $value->id_dokumen . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>';

            $data[] = $row;
            $num++;

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

    function dokumen_list_test()
    {
        $list = $this->dokumen->get_datatables_test();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $value->id_dokumen;
            $row[] = '<p class="text-wrap mb-0" style="width: 70%;">'.$value->nama_dokumen.'</p>';
            $row[] = '<p class="text-wrap mb-0" style="width: 40%;">'.$value->nomor_dokumen.'</p>';
            $row[] = '<p class="text-wrap mb-0" style="width: 40%;">'.$value->nomor_dokumen.'</p>';
            $row[] = $value->tanggal_dokumen;
            //add html for action
            $row[] = '
            <a class="btn btn-sm btn-success p-2" href="#" title="Hapus" onClick="update_dokumen(' . "'" . $value->id_dokumen . "'" . ')"><i class="fa fa-edit"></i> Edit</a>
            <a class="btn btn-sm btn-primary p-2" href="#" title="Hapus" onClick="view_dokumen(' . "'" . $value->id_dokumen . "'" . ')"><i class="fa fa-eye"></i> Lihat</a>
            <a class="btn btn-sm btn-danger p-2" href="#" title="Hapus" onClick="delete_dokumen(' . "'" . $value->id_dokumen . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>';

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

    function formulir_list()
    {
        $list = $this->dokumen->get_datatables_test();
        $data = array();
        $no = $_POST['start'];
        
        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $value->id_dokumen;
            $row[] = '<p class="text-wrap mb-0" style="width: 100%;">'.$value->nama_dokumen.'</p>';
            $row[] = '<a href="'.base_url().$value->tanggal_dokumen.'" title="" alt=""><i class="fa fa-download fa-lg"></i></a>';
            $row[] = $value->tanggal_dokumen;
            $row[] = $value->keterangan ? $value->keterangan:"<small style=\"color:red\">Keterangan Kosong</small>";
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary p-2" href="#" title="Hapus" onClick="view_formulir(' . "'" . $value->id_dokumen . "'" . ')"><i class="fa fa-eye"></i> Lihat</a>
            <a class="btn btn-sm btn-danger p-2" href="#" title="Hapus" onClick="delete_formulir(' . "'" . $value->id_dokumen . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->formulir->count_all(),
            "recordsFiltered" => $this->formulir->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function dokumen_view_2($id)
    {
        $data = $this->dokumen->get_detail_document($id);
        echo json_encode($data);
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
                'allowed_types' => 'png|jpg|pdf|docx|doc|xls|xlsx|zip|rar',
                'remove_space' => TRUE,
                'encrypt_name' => TRUE,
                'max_size' => 102400,
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
                
                $data['list_unit_kerja'] = $_POST['list_unit_kerja'];
                $data['list_pihak'] = $_POST['list_pihak'];
                
                $arr = $data['list_unit_kerja'];
                $list_unit_kerja = explode("#",$arr);
                for($i = 0; $i < count($list_unit_kerja); $i++){
                    $data = array(
                        'id_dokumen' => $inserted_id,
                        'id_unit_kerja' => $list_unit_kerja[$i],
                    );
                    $this->pemilikDokumen->save($data);
                }

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

    function dokumen_add_user()
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
                );
            }
        }

        echo json_encode($data);
    }

    function dokumen_update(){
        $config = array(
            'upload_path' => 'files/arsip-dokumen',
            'allowed_types' => 'png|jpg|pdf|docx|doc|xls|xlsx|zip|rar',
            'remove_space' => TRUE,
            'encrypt_name' => TRUE,
            'max_size' => 102400,
            'min_width' => 1,
            'min_height' => 1,
            'max_width' => 1028,
            'max_height' => 768
        );

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->upload->do_upload('file_path');

        if(empty($_FILES['file_path']['tmp_name']) || !is_uploaded_file($_FILES['file_path']['tmp_name'])){
 
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

        }else{
            

            $files = $this->crud->get('arsip_dokumen', array('id_dokumen' => $this->input->post('id_dokumen')))->row_array();
            unlink($files['file_path']);
           
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

        }
                
        $data['list_unit_kerja'] = $_POST['list_unit_kerja'];
        $data['list_pihak'] = $_POST['list_pihak'];
        
        //pemilik dokumen
        //delete
        $this->pemilikDokumen->delete_by_id_document($this->input->post('id_dokumen'));
        $arr = $data['list_unit_kerja'];
        $list_unit_kerja = explode("#",$arr);
        for($i = 0; $i < count($list_unit_kerja); $i++){
            $data = array(
                'id_dokumen' => $this->input->post('id_dokumen'),
                'id_unit_kerja' => $list_unit_kerja[$i],
            );
            $this->pemilikDokumen->save($data);
        }

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

        echo json_encode($data);
    }

    function dokumen_delete($id)
    {
        $file = $this->crud->get('arsip_dokumen', array('id_dokumen' => $id))->row_array();
        unlink($file['file_path']);
        $this->dokumen->delete_by_id($id);
        $this->pemilikDokumen->delete_by_id_document($id);
        $this->pihakDokumen->delete_by_id_document($id);
        echo json_encode(array("status" => TRUE));
    }

    public function getData(){
        $request = service('request');
        $postData = $request->getPost();
        $dtpostData = $postData['data'];
        $response = array();

        ## Read value
        $draw = $dtpostData['draw'];
        $start = $dtpostData['start'];
        $rowperpage = $dtpostData['length']; // Rows display per page
        $columnIndex = $dtpostData['order'][0]['column']; // Column index
        $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
        $searchValue = $dtpostData['search']['value']; // Search value

        ## Total number of records without filtering
        $totalRecords = $this->dokumen->total_records_with_filter();

                

        ## Total number of records with filtering
        $totalRecordwithFilter = $this->dokumen->total_records_with_filter();

        ## Fetch records

        $records = $this->dokumen->total_records($searchValue,$columnName,$columnSortOrder,$rowperpage, $start) ; 
        
        $data = array();

        foreach($records as $record ){
            $data[] = array( 
                "id"=>$record['id'],
                "nama_dokumen"=>$record['nama_dokumen'],
                "tanggal_dokumen"=>$record['tanggal_dokumen'],
            ); 
        }

        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data,
            "token" => csrf_hash() // New token hash
        );
        return $this->response->setJSON($response);
    }

}
