<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of podaci_o_firmi
 *
 * @author Veljko
 */
class Podaci_o_firmi_model extends CI_Model{
    
    public $id_podaci_preduzeca;
    public $naziv_firme;
    public $registracija_firme;
    public $opis_firme;
    public $opis_firme_duzi;
    public $otvoreni_smo_firma;
    public $adresa_firme;
    public $grad_firme;
    public $zemlja_firme;
    public $telefon_firme;
    public $email_firme;
    public $radno_vreme_firme;
    public $registarski_broj_firme;
    public $uslov;
    public $order_by;

    
    public function __construct() {
        parent::__construct();
    }
    
    public function izmeni(){
        $data = array(
            'naziv_firme' => $this->naziv_firme,
            'registracija_firme' => $this->registracija_firme,
            'opis_firme' => $this->opis_firme,
            'opis_firme_duzi' => $this->opis_firme_duzi,
            'otvoreni_smo_firma' => $this->otvoreni_smo_firma,
            'adresa_firme' => $this->adresa_firme,
            'grad_firme' => $this->grad_firme,
            'zemlja_firme' => $this->zemlja_firme,
            'telefon_firme' => $this->telefon_firme,
            'email_firme' => $this->email_firme,
            'radno_vreme_firme' => $this->radno_vreme_firme,
            'registarski_broj_firme' => $this->registarski_broj_firme
        );
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->update('podaci_preduzeca', $data);
        return true;
    }
    
    public function podaci(){
        $this->db->select('*');
        $this->db->from('podaci_preduzeca');
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        if($this->order_by != null):
            $this->db->order_by($this->order_by);
        endif;
        return $this->db->get()->result();
    }
}
