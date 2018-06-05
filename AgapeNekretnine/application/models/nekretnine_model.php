<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of nekretnine
 *
 * @author Veljko
 */
class Nekretnine_model extends CI_Model{
    public $id_nekretnina;
    public $ulica_nekretnina;
    public $grad_nekretnina;
    public $cena_nekretnina;
    public $opis_nekretnina;
    public $broj_soba_nekretnina;
    public $kvadratura_nekretnina;
    public $top_ponuda;
    public $id_tip_nekretnina;
    public $deo_grada_nekretnina;
    public $spratnost_nekretnina;
    public $grejanje_nekretnina;
    public $id_agenta;
    public $ime_vlasnika;
    public $prezime_vlasnika;
    public $telefon_vlasnika;
    public $uslov;
    public $order_by;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function unesi(){
        $data = array(
            'ulica_nekretnina' => $this->ulica_nekretnina,
            'cena_nekretnina' => $this->cena_nekretnina,
            'opis_nekretnina' => $this->opis_nekretnina,
            'broj_soba_nekretnina' => $this->broj_soba_nekretnina,
            'kvadratura_nekretnina' => $this->kvadratura_nekretnina,
            'top_ponuda' => $this->top_ponuda,
            'id_tip_nekretnina' => $this->id_tip_nekretnina,
            'deo_grada_nekretnina' => $this->deo_grada_nekretnina,
            'spratnost_nekretnina' => $this->spratnost_nekretnina,
            'grejanje_nekretnina' => $this->grejanje_nekretnina,
            'id_agenta' => $this->id_agenta,
            'ime_vlasnika' => $this->ime_vlasnika,
            'prezime_vlasnika' => $this->prezime_vlasnika,
            'telefon_vlasnika' => $this->telefon_vlasnika,
            'id_kategorije' => $this->id_kategorije
        );
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->insert('nekretnine', $data);
        return $this->db->insert_id();
    }
    public function obrisi(){
        if(isset($this->id_nekretnina)):
            $array = array(
                'id_nekretnina' => $this->id_nekretnina
            );
            $this->uslov = $array;
        endif;
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->delete('nekretnine');
    }
    public function izmeni(){
        if($this->id_nekretnina != null):
            $array = array(
                'id_nekretnina' => $this->id_nekretnina
            );
            $this->uslov = $array;
        endif;
            $data = array(
                'ulica_nekretnina' => $this->ulica_nekretnina,
                'cena_nekretnina' => $this->cena_nekretnina,
                'opis_nekretnina' => $this->opis_nekretnina,
                'broj_soba_nekretnina' => $this->broj_soba_nekretnina,
                'kvadratura_nekretnina' => $this->kvadratura_nekretnina,
                'top_ponuda' => $this->top_ponuda,
                'id_tip_nekretnina' => $this->id_tip_nekretnina,
                'deo_grada_nekretnina' => $this->deo_grada_nekretnina,
                'spratnost_nekretnina' => $this->spratnost_nekretnina,
                'grejanje_nekretnina' => $this->grejanje_nekretnina,
                'id_agenta' => $this->id_agenta,
                'ime_vlasnika' => $this->ime_vlasnika,
                'prezime_vlasnika' => $this->prezime_vlasnika,
                'telefon_vlasnika' => $this->telefon_vlasnika,
                'id_kategorije' => $this->id_kategorije
            );
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->update('nekretnine', $data);
        return true;
    }
    public function lista(){
        $this->db->select('*');
        $this->db->from('nekretnine');
        $this->db->join('slika_nekretnine', 'slika_nekretnine.id_nekretnina = nekretnine.id_nekretnina');
        $this->db->join('tip_nekretnine', 'nekretnine.id_tip_nekretnina = tip_nekretnine.id_tip_nekretnina');
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        if($this->order_by != null):
            $this->db->order_by($this->order_by);
        endif;
        return $this->db->get()->num_rows();
    }
    public function podaci(){
        if($this->id_nekretnina != null):
            $array = array(
                'nekretnine.id_nekretnina' => $this->id_nekretnina
            );
            $this->uslov = $array;
        endif;
        $this->db->select('*');
        $this->db->from('nekretnine');
        $this->db->join('slika_nekretnine', 'slika_nekretnine.id_nekretnina = nekretnine.id_nekretnina');
        $this->db->join('tip_nekretnine', 'nekretnine.id_tip_nekretnina = tip_nekretnine.id_tip_nekretnina');
        $this->db->join('agenti', 'agenti.id_agenta = nekretnine.id_agenta');
        $this->db->join('deo_grada_nekretnine', 'nekretnine.deo_grada_nekretnina = deo_grada_nekretnine.id_deo_grada');
        $this->db->join('kategorija_nekretnine', 'nekretnine.id_kategorije = kategorija_nekretnine.id_kategorije');
        $this->db->join('grad_nekretnine', 'deo_grada_nekretnine.id_grada = grad_nekretnine.id_grada');
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        if($this->order_by != null):
            $this->db->order_by($this->order_by);
        endif;
        return $this->db->get()->result();
    }
    public function dohvati(){
        if($this->id_nekretnina != null):
            $array = array(
                'nekretnine.id_nekretnina' => $this->id_nekretnina
            );
            $this->uslov = $array;
        endif;
        $this->db->select('*');
        $this->db->from('nekretnine');
        $this->db->join('tip_nekretnine', 'nekretnine.id_tip_nekretnina = tip_nekretnine.id_tip_nekretnina');
        $this->db->join('agenti', 'agenti.id_agenta = nekretnine.id_agenta');
        $this->db->join('deo_grada_nekretnine', 'nekretnine.deo_grada_nekretnina = deo_grada_nekretnine.id_deo_grada');
        $this->db->join('kategorija_nekretnine', 'nekretnine.id_kategorije = kategorija_nekretnine.id_kategorije');
        $this->db->join('grad_nekretnine', 'deo_grada_nekretnine.id_grada = grad_nekretnine.id_grada');
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        if($this->order_by != null):
            $this->db->order_by($this->order_by);
        endif;
        return $this->db->get()->result();
    }
    
}
