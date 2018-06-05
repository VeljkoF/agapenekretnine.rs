<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tip_nekretnine
 *
 * @author Veljko
 */
class Tip_nekretnine_model extends CI_Model{
    
    public $id_tip_nekretnina;
    public $naziv_tip_nekretnina;
    public $uslov;
    public $order_by;
    
    public function __construct() {
        parent::__construct();
    }
    
    
    public function podaci(){
        $this->db->select('*');
        $this->db->from('tip_nekretnine');
        if($this->uslov != null):
            $this->db->join('nekretnine', 'tip_nekretnine.id_tip_nekretnina = nekretnine.id_tip_nekretnina');
            $this->db->where($this->uslov);
        endif;
        if($this->order_by != null):
            $this->db->order_by($this->order_by);
        endif;
        return $this->db->get()->result();
    }
}
