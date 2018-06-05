<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of slajder_pocetna
 *
 * @author Veljko
 */
class Slajder_pocetna_model extends CI_Model{
    public $id_slajder;
    public $putanja_slike_slajder;
    public $naslov_slajder;
    public $opis_slajder;
    public $uslov;
    public $order_by;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function unesi(){
        $data = array(
            'putanja_slike_slajder' => $this->putanja_slike_slajder,
            'naslov_slajder' => $this->naslov_slajder,
            'opis_slajder' => $this->opis_slajder,
        );
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->insert('slajder_pocetna', $data);
        return true;
    }
    public function obrisi(){
        if(isset($this->id_slajder)):
            $array = array(
                'id_slajder' => $this->id_slajder
            );
            $this->uslov = $array;
        endif;
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->delete('slajder_pocetna');
    }
    public function izmeni(){
        if(isset($this->putanja_slike_slajder)):
        $data = array(
            'putanja_slike_slajder' => $this->putanja_slike_slajder,
            'naslov_slajder' => $this->naslov_slajder,
            'opis_slajder' => $this->opis_slajder
        );
        else:
           $data = array(
            'naslov_slajder' => $this->naslov_slajder,
            'opis_slajder' => $this->opis_slajder
        ); 
        endif;
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->update('slajder_pocetna', $data);
        return true;
    }
    public function podaci(){
        if(isset($this->id_slajder)):
            $array = array(
                'id_slajder' => $this->id_slajder
            );
            $this->uslov = $array;
        endif;
        $this->db->select('*');
        $this->db->from('slajder_pocetna');
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        if($this->order_by != null):
            $this->db->order_by($this->order_by);
        endif;
        return $this->db->get()->result();
    }
}
