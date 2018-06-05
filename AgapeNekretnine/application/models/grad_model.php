<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of grad_model
 *
 * @author Veljko
 */
class Grad_model extends CI_Model{
    
    public $id_grada;
    public $naziv_grada;
    
    public $uslov;
    public $order_by;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function unesi(){
        $data = array(
            'naziv_grada' => $this->naziv_grada
        );
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->insert('grad_nekretnine', $data);
        return true;
    }
    public function obrisi(){
        if(isset($this->id_grada)):
            $array = array(
                'id_grada' => $this->id_grada
            );
            $this->uslov = $array;
        endif;
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->delete('grad_nekretnine');
    }
    public function izmeni(){
        $data = array(
            'naziv_grada' => $this->naziv_grada
        );
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->update('grad_nekretnine', $data);
        return true;
    }
    public function podaci(){
        if(isset($this->id_grada)):
            $array = array(
                'id_grada' => $this->id_grada
            );
            $this->uslov = $array;
        endif;
        $this->db->select('*');
        $this->db->from('grad_nekretnine');
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        if($this->order_by != null):
            $this->db->order_by($this->order_by);
        else:
            $this->db->order_by("naziv_grada ASC");
        endif;
        return $this->db->get()->result();
    }
}
