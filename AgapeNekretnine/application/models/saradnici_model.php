<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of saradnici
 *
 * @author Veljko
 */
class Saradnici_model extends CI_Model{
    public $id_saradnika;
    public $naziv_saradnika;
    public $logo_saradnika;
    public $opis_saradnika;
    public $link_saradnika;
    public $uslov;
    public $order_by;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function unesi(){
        $data = array(
            'naziv_saradnika' => $this->naziv_saradnika,
            'logo_saradnika' => $this->logo_saradnika,
            'opis_saradnika' => $this->opis_saradnika,
            'link_saradnika' => $this->link_saradnika
        );
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->insert('saradnici', $data);
        return true;
    }
    public function obrisi(){
        if(isset($this->id_saradnika)):
            $array = array(
                'id_saradnika' => $this->id_saradnika
            );
            $this->uslov = $array;
        endif;
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        $this->db->delete('saradnici');
    }
    public function izmeni(){
        $data = array(
            'naziv_saradnika' => $this->naziv_saradnika,
            'logo_saradnika' => $this->logo_saradnika,
            'opis_saradnika' => $this->opis_saradnika,
            'link_saradnika' => $this->link_saradnika
        );
        
        $this->db->where('id_saradnika', $this->id_saradnika);
        $this->db->update('saradnici', $data);
        return true;
    }
    public function podaci(){
        if(isset($this->id_saradnika)):
            $array = array(
                'id_saradnika' => $this->id_saradnika
            );
            $this->uslov = $array;
        endif;
        $this->db->select('*');
        $this->db->from('saradnici');
        if($this->uslov != null):
            $this->db->where($this->uslov);
        endif;
        if($this->order_by != null):
            $this->db->order_by($this->order_by);
        endif;
        return $this->db->get()->result();
    }
}
