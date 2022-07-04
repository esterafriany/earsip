<?php
if (defined('basepath')) exit('No direct access script allowed');

class Arsip_formulir extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('GlobalCrud', 'crud');
        $this->load->model('FormulirDataModel', 'formulir');
        if ($this->session->userdata('level') != 1) {
            redirect('login');
        }
        $this->form_validation->set_error_delimiters('', '');
    }

    function validation()
    {
        $this->form_validation->set_rules('nama_formulir', '', 'required');
        $this->form_validation->set_rules('tanggal_formulir', '', 'required');
    }

    function create()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $this->message = "Komponen Arsip Formulir Wajib Diisi !";
            $this->session->set_flashdata('warning', $this->message);
            redirect('admin/arsip-formulir');
        } else {
            $config = array(
                'upload_path' => 'files/arsip-formulir',
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
                $query = array(
                    'nama_formulir' => $this->input->post('nama_formulir'),
                    'tanggal_formulir' => $this->input->post('tanggal_formulir'),
                    'keterangan' => $this->input->post('keterangan'),
                    'file_path' => $config['upload_path'] . "/" . $file['file_name'],
                );
                $this->crud->insert('arsip_formulir', $query);
                $this->message = "Formulir & Blanko Berhasil Dibuat !";
                $this->session->set_flashdata('success', $this->message);
                redirect('admin/arsip-formulir');
            } else {
                $this->message = "Berkas gagal diupload !";
                $this->session->set_flashdata('warning', $this->message);
                redirect('admin/arsip-formulir');
            }
        }
    }

    function destroy($id)
    {
        $file = $this->crud->get('arsip_formulir', array('id_formulir' => $id))->row_array();
        unlink($file['file_path']);
        $this->crud->delete('arsip_formulir', 'id_formulir', $id);
        $this->message = "Formulir & Blanko Berhasil Dihapus";
        $this->session->set_flashdata('success', $this->message);
        redirect('admin/arsip-formulir');
    }

    function formulir_list()
    {
        $list = $this->formulir->get_datatables();
        $data = array();
        $no = $_POST['start'];
        
        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $value->id_formulir;
            $row[] = '<p class="text-wrap mb-0" style="width: 100%;">'.$value->nama_formulir.'</p>';
            $row[] = '<a href="'.base_url().$value->file_path.'" title="" alt=""><i class="fa fa-download fa-lg"></i></a>';
            $row[] = $value->tanggal_formulir;
            $row[] = $value->keterangan ? $value->keterangan:"<small style=\"color:red\">Keterangan Kosong</small>";
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary p-2" href="#" title="Hapus" onClick="view_formulir(' . "'" . $value->id_formulir . "'" . ')"><i class="fa fa-eye"></i> Lihat</a>
            <a class="btn btn-sm btn-danger p-2" href="#" title="Hapus" onClick="delete_formulir(' . "'" . $value->id_formulir . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>';

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

    function formulir_view($id)
    {
        $data = $this->formulir->get_by_id($id);
        echo json_encode($data);
    }

    function formulir_add()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'response' => 'error',
                'error'   => true,
                'nama_formulirError' => form_error('nama_formulir'),
                'tanggal_formulirError' => form_error('tanggal_formulir'),
                'file_pathError' => form_error('file_path'),
                'message' => validation_errors(),
            );
        } else {
            $config = array(
                'upload_path' => 'files/arsip-formulir',
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
                    'nama_formulir' => $this->input->post('nama_formulir'),
                    'tanggal_formulir' => $this->input->post('tanggal_formulir'),
                    'keterangan' => $this->input->post('keterangan'),
                    'file_name' => $file['file_name'],
                    'file_path' => $config['upload_path'] . "/" . $file['file_name'],
                    'created_at' => date('Y-m-d H:i:s'),
                );
                $insert = $this->formulir->save($data);
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

    function formulir_update()
    {
        $this->validation();
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'response' => 'error',
                'error'   => true,
                'nama_formulirError' => form_error('nama_formulir'),
                'keteranganError' => form_error('keterangan'),
                'message' => validation_errors(),
            );
        } else {
            $data = array(
                'nama_formulir' => $this->input->post('nama_formulir'),
                'keterangan' => $this->input->post('keterangan'),
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $this->formulir->update(array('id_formulir' => $this->input->post('id_formulir')), $data);
        }
        echo json_encode($data);
    }

    function formulir_delete($id)
    {
        $file = $this->crud->get('arsip_formulir', array('id_formulir' => $id))->row_array();
        unlink($file['file_path']);
        $this->formulir->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}
