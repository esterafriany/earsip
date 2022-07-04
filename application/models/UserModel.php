<?php

class UserModel extends CI_Model {
    
    var $table = 'user';
    
    function first($query){
        //return $this->db->get_where($this->table,$query);

        return $this->db->join("pegawai","pegawai.id_pegawai = {$this->table}.id_pegawai")
        ->get_where($this->table,$query);
    }

    function get_detail_user_login($email, $password){
        $this->db->select("id_unit") ;
        $this->db->from($this->table);
        $this->db->join("pegawai","pegawai.id_pegawai = {$this->table}.id_pegawai");
        $this->db->where('email', $email);
        return $this->db->get()->row();
        
    }
    
    function session($query){
        foreach($query->result() as $row){
            $createSession = array(
                'id_user' => $row->id_user,
                'name' => $row->name,
                'email' => $row->email,
                'id_unit' => $row->id_unit,
                //'password' => $row->password,
                'level' => $row->level,
                'logged_in' => true
            );
        }
        
        $this->session->set_userdata($createSession);
        if($this->session->userdata('level') == 1){
            redirect('admin');
        } else if($this->session->userdata('level') == 0){
            redirect('user');
        }
        
    }
    
    function insert($query){
        $this->db->insert($this->table,$query);
    }
    
    function get($id){
        return $this->db->get_where($this->table,$id);
    }
    
    function delete($id){
        $this->db->where('id_user',$id);
        $this->db->delete($this->table);
    }
    
    function update($id,$query){
        $this->db->where('id_user',$id);
        $this->db->update($this->table,$query);
    }
    
    /*****************
    * Custom Query
    *****************/
    
    function reset($id){
        $this->db->select('*');
        $this->db->where('id_user',$id);
        $result = $this->db->get($this->table)->result();
        
        foreach($result as $row){
            $password = $row->password;
        }
        
        return $password;
    }
    
    function destinasi_surat($id){
        $this->db->select('id_user, name, email, level, nama_pegawai, nama_jabatan, nama_unit');
        $this->db->from('user');
        $this->db->join('pegawai','pegawai.id_pegawai = user.id_pegawai');
        $this->db->join('jabatan','pegawai.id_jabatan = jabatan.id_jabatan');
        $this->db->join('unit_kerja','pegawai.id_unit = unit_kerja.id_unit');
        $this->db->where('id_user !=',$id);
        return $this->db->get();
    }
    
    
}