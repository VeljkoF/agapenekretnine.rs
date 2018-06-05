<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Meni
 *
 * @author Veljko
 */
class Meni_model extends CI_Model {
    
    public $id_meni;
    public $naziv_meni;
    public $putanja_meni;
    public $posetilac;
    public $admin;
    public $korisnik;
    public $roditelj;
    public $uslov;
    public $order_by;

    public function __construct() {
        parent::__construct();
    }
    
    public function izmeni(){
        if($this->id_meni != null):
            $array = array(
                'id_meni' => $this->id_meni
            );
            $this->uslov = $array;
        endif;
        $data = array(
            'naziv_meni' => $this->naziv_meni,
            'korisnik' => $this->korisnik
        );
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->update('meni', $data);
        return true;
    }
    
    public function podaci(){
        if($this->id_meni != null):
            $array = array(
                'id_meni' => $this->id_meni
            );
            $this->uslov = $array;
        endif;
        $this->db->select('*');
        $this->db->from('meni');
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        if($this->order_by != null):
            $this->db->order_by($this->order_by);
        endif;
        return $this->db->get()->result();
    }
}
