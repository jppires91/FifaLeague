<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {

    public function getUserById($idUser) {
        $this->load->database();
        $data['IDUser'] = $idUser;
        $query = $this->db->get_where('User', $data);


        return $query->row();
    }
}