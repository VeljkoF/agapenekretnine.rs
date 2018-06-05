<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of korisnici
 *
 * @author Veljko
 */
class Korisnici_model extends CI_Model{
    
    public $id_korisnik;
    public $ime_korisnika;
    public $prezime_korisnika;
    public $korisnicko_ime;
    public $lozinka_korisnika;
    public $telefon_korisnika = "neki telefon";
    public $email_korisnika = "neki mail";
    public $id_uloge;
    public $uslov;
    public $order_by;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function unesi(){
        $data = array(
            'ime_korisnika' => $this->ime_korisnika,
            'prezime_korisnika' => $this->prezime_korisnika,
            'korisnicko_ime' => $this->korisnicko_ime,
            'lozinka_korisnika' => $this->lozinka_korisnika,
            'telefon_korisnika' => $this->telefon_korisnika,
            'email_korisnika' => $this->email_korisnika,
            'id_uloge' => $this->id_uloge
        );
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->insert('korisnici', $data);
        return true;
    }
    public function obrisi(){
        if(isset($this->id_korisnik)):
            $array = array(
                'id_korisnik' => $this->id_korisnik
            );
            $this->uslov = $array;
        endif;
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->delete('korisnici');
    }
    public function izmeni(){
        $data = array(
            'ime_korisnika' => $this->ime_korisnika,
            'prezime_korisnika' => $this->prezime_korisnika,
            'korisnicko_ime' => $this->korisnicko_ime,
            'lozinka_korisnika' => $this->lozinka_korisnika,
            'telefon_korisnika' => $this->telefon_korisnika,
            'email_korisnika' => $this->email_korisnika,
            'id_uloge' => $this->id_uloge
        );
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->update('korisnici', $data);
        return true;
    }
    public function podaci(){
        if(isset($this->id_korisnik)):
            $array = array(
                'id_korisnik' => $this->id_korisnik
            );
            $this->uslov = $array;
        endif;
        $this->db->select('*');
        $this->db->from('korisnici');
        $this->db->join('uloga', 'korisnici.id_uloge = uloga.id_uloge');
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        if($this->order_by != null):
            $this->db->order_by($this->order_by);
        endif;
        return $this->db->get()->result();
    }
    
}
