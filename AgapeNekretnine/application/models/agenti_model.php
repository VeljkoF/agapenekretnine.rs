<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of agenti
 *
 * @author Veljko
 */
class Agenti_model extends CI_Model{
    
    public $id_agenta;
    public $ime_agenta;
    public $prezime_agenta;
    public $telefon_agenta;
    public $mail_agenta = "neki mail";
    public $slika_agenta;
    public $uslov;
    public $order_by;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function unesi(){
        $data = array(
            'ime_agenta' => $this->ime_agenta,
            'prezime_agenta' => $this->prezime_agenta,
            'telefon_agenta' => $this->telefon_agenta,
            'mail_agenta' => $this->mail_agenta,
            'slika_agenta' => $this->slika_agenta
        );
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->insert('agenti', $data);
        return true;
    }
    public function obrisi(){
        if(isset($this->id_agenta)):
            $array = array(
                'id_agenta' => $this->id_agenta
            );
            $this->uslov = $array;
        endif;
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->delete('agenti');
    }
    public function izmeni(){
        if(isset($this->slika_agenta)):
        $data = array(
            'ime_agenta' => $this->ime_agenta,
            'prezime_agenta' => $this->prezime_agenta,
            'telefon_agenta' => $this->telefon_agenta,
            'mail_agenta' => $this->mail_agenta,
            'slika_agenta' => $this->slika_agenta
        );
        else:
           $data = array(
            'ime_agenta' => $this->ime_agenta,
            'prezime_agenta' => $this->prezime_agenta,
            'telefon_agenta' => $this->telefon_agenta,
            'mail_agenta' => $this->mail_agenta
        ); 
        endif;
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->update('agenti', $data);
        return true;
    }
    public function lista(){
        
    }
    public function podaci(){
        if(isset($this->id_agenta)):
            $array = array(
                'id_agenta' => $this->id_agenta
            );
            $this->uslov = $array;
        endif;
        $this->db->select('*');
        $this->db->from('agenti');
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        if($this->order_by != null):
            $this->db->order_by($this->order_by);
        endif;
        return $this->db->get()->result();
    }
}
