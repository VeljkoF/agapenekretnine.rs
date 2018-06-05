<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kategorija_model
 *
 * @author Veljko
 */
class Kategorija_model extends CI_Model {
    
    public $id_kategorija;
    public $naziv_kategorije;
    
    public $uslov;
    public $order_by;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function unesi(){
        $data = array(
            'naziv_kategorije' => $this->naziv_kategorije
        );
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->insert('kategorija_nekretnine', $data);
        return true;
    }
    public function obrisi(){
        if(isset($this->id_kategorija)):
            $array = array(
                'id_kategorija' => $this->id_kategorija
            );
            $this->uslov = $array;
        endif;
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->delete('kategorija_nekretnine');
    }
    public function izmeni(){
        $data = array(
            'naziv_kategorije' => $this->naziv_kategorije
        );
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->update('kategorija_nekretnine', $data);
        return true;
    }
    public function podaci(){
        if(isset($this->id_kategorija)):
            $array = array(
                'id_kategorija' => $this->id_kategorija
            );
            $this->uslov = $array;
        endif;
        $this->db->select('*');
        $this->db->from('kategorija_nekretnine');
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        if($this->order_by != null):
            $this->db->order_by($this->order_by);
        endif;
        return $this->db->get()->result();
    }
    
}
