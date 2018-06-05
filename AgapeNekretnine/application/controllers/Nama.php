<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of onama
 *
 * @author Veljko
 */
class Nama extends MY_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('meni_model');
        $this->load->model('podaci_o_firmi_model');
        $this->load->model('agenti_model');
    }
    
    public function onama()
    {
        if(!empty($this->session->userdata('id_uloge'))):
            redirect('admin/AdminNekretnine');
        endif;       
        
        $uslovMeni = array(
            'posetilac' => '1'
        );
        
        $this->meni_model->uslov = $uslovMeni;
        $data['meni'] = $this->meni_model->podaci();
        
        $data['podaci_preduzeca'] = $this->podaci_o_firmi_model->podaci();
        
        $data['agenti'] = $this->agenti_model->podaci();
        
        $data['title'] = 'О нама';
        $this->load_view('onama', $data);
    }
    
    public function autor()
    {
        if(!empty($this->session->userdata('id_uloge'))):
            redirect('admin/AdminNekretnine');
        endif;
        
        $uslovMeni = array(
            'posetilac' => '1'
        );
        
        $this->meni_model->uslov = $uslovMeni;
        $data['meni'] = $this->meni_model->podaci();
        
        $data['podaci_preduzeca'] = $this->podaci_o_firmi_model->podaci();
        
        
        $data['title'] = 'Autor';
        $this->load_view('autor', $data);
    }
    
    public function kontakt()
    {
        if(!empty($this->session->userdata('id_uloge'))):
            redirect('admin/AdminNekretnine');
        endif;
        
        $uslovMeni = array(
            'posetilac' => '1'
        );
        
        $this->meni_model->uslov = $uslovMeni;
        $data['meni'] = $this->meni_model->podaci();
        
        $data['podaci_preduzeca'] = $this->podaci_o_firmi_model->podaci();
        
        $data['title'] = 'Контакт';
        $this->load_view('kontakt', $data);
    }
}
