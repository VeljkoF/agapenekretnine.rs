<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ulogaModel
 *
 * @author Veljko
 */
class Uloga_model extends CI_Model{
    
    private $id_uloge;
    private $naziv_uloge;
    public $uslov;
    public $order_by;
    
    public function podaci(){
        
        $this->db->select('*');
        $this->db->from('uloga');
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        if($this->order_by != null):
            $this->db->order_by($this->order_by);
        endif;
        return $this->db->get()->result();
    }
}
