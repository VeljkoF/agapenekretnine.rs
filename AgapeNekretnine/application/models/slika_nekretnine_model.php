<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of slikaNekretninaModel
 *
 * @author Veljko
 */
class Slika_nekretnine_model extends CI_Model{
    
    public $id_slika_nekretnina;
    public $naziv_slika_nekretnina;
    public $putanja_slika_nekretnina;
    public $id_nekretnina;
    public $front_slika;
    public $glasova;
    public $rezultat;
    public $uslov;
    public $order_by;

    public function __construct() {
        parent::__construct();
    }
    
    public function unesi(){
        $data = array(
            'naziv_slika_nekretnina' => $this->naziv_slika_nekretnina,
            'putanja_slika_nekretnina' => $this->putanja_slika_nekretnina,
            'id_nekretnina' => $this->id_nekretnina,
            'front_slika' => $this->front_slika,
            'glasova' => $this->glasova,
            'rezultat' => $this->rezultat
        );
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->insert('slika_nekretnine', $data);
        return true;
    }
    public function obrisi(){
        if(isset($this->id_slika_nekretnina)):
            $array = array(
                'id_slika_nekretnina' => $this->id_slika_nekretnina
            );
            $this->uslov = $array;
        endif;
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->delete('slika_nekretnine');
    }
    public function izmeni(){
        if($this->id_nekretnina != null):
            $array = array(
                'id_nekretnina' => $this->id_nekretnina
            );
            $this->uslov = $array;
            $data = array(
            'front_slika' => $this->front_slika
            );
        endif;
        
        if($this->id_nekretnina != null && $this->id_slika_nekretnina != null):
            $array = array(
                'id_nekretnina' => $this->id_nekretnina,
                'id_slika_nekretnina' => $this->id_slika_nekretnina
            );
            $this->uslov = $array;
            $data = array(
                'front_slika' => $this->front_slika,
                'naziv_slika_nekretnina' => $this->naziv_slika_nekretnina
            );
        endif;
        
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->update('slika_nekretnine', $data);
        return true;
    }
    public function podaci(){
        if($this->id_nekretnina != null):
            $array = array(
                'id_nekretnina' => $this->id_nekretnina
            );
            $this->uslov = $array;
        endif;
        $this->db->select('*');
        $this->db->from('slika_nekretnine');
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        if($this->order_by != null):
            $this->db->order_by($this->order_by);
        endif;
        return $this->db->get()->result();
    }
    public function galerija($limit,$start){
        $this->db->limit($limit,$start);
        $rez= $this->db->get('slika_nekretnine');
        if($rez->num_rows()>0):
            return $rez->result();
        else:
            return false;
        endif;
    }
}
