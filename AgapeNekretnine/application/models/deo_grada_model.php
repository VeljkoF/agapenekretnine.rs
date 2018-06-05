<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of deo_grada_model
 *
 * @author Veljko
 */
class Deo_grada_model extends CI_Model{
    
    public $id_deo_grada;
    public $naziv_deo_grada;
    public $id_grada;
    
    public $uslov;
    public $order_by;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function unesi(){
        $data = array(
            'naziv_deo_grada' => $this->naziv_deo_grada,
            'id_grada' => $this->id_grada
        );
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->insert('deo_grada_nekretnine', $data);
        return true;
    }
    public function obrisi(){
        if(isset($this->id_deo_grada)):
            $array = array(
                'id_deo_grada' => $this->id_deo_grada
            );
            $this->uslov = $array;
        endif;
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->delete('deo_grada_nekretnine');
    }
    public function izmeni(){
        $data = array(
            'naziv_deo_grada' => $this->naziv_deo_grada,
            'id_grada' => $this->id_grada
        );
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->update('deo_grada_nekretnine', $data);
        return true;
    }
    public function podaci(){
        if(isset($this->id_deo_grada)):
            $array = array(
                'id_deo_grada' => $this->id_deo_grada
            );
            $this->uslov = $array;
        endif;
        $this->db->select('*');
        $this->db->from('deo_grada_nekretnine');
        $this->db->join('grad_nekretnine', 'deo_grada_nekretnine.id_grada = grad_nekretnine.id_grada');
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        if($this->order_by != null):
            $this->db->order_by($this->order_by);
        else:
            $this->db->order_by("naziv_deo_grada ASC");
        endif;
        return $this->db->get()->result();
    }
}
