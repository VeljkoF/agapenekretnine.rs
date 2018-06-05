<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pocetna
 *
 * @author Veljko
 */
class pocetna extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('meni_model');
        $this->load->model('podaci_o_firmi_model');
        $this->load->model('slajder_pocetna_model');
        $this->load->model('nekretnine_model');
        $this->load->model('saradnici_model');
       
    }
	
    public function index()
    {
        if(!empty($this->session->userdata('id_uloge'))):
            redirect('admin/AdminNekretnine');
        endif;
        
        $uslovMeni = array(
            'posetilac' => '1'
        );
        $uslovNekretnine = array(
            'top_ponuda' => '1',
            'front_slika' => '1'
        );
        $order_byNekretnine = "cena_nekretnina ASC";
        
        $this->meni_model->uslov = $uslovMeni;
        $data['meni'] = $this->meni_model->podaci();
        
        $data['podaci_preduzeca'] = $this->podaci_o_firmi_model->podaci();
        
        $order_bySlajder = "id_slajder ASC";
        $this->slajder_pocetna_model->order_by = $order_bySlajder;
        $data['slajder'] = $this->slajder_pocetna_model->podaci();
        
        $this->nekretnine_model->uslov = $uslovNekretnine;
        $this->nekretnine_model->order_by = $order_byNekretnine;
        $data['nekretnine'] = $this->nekretnine_model->podaci();
        
        $data['saradnici'] = $this->saradnici_model->podaci();
        
        $data['title'] = 'Почетна';
        $this->load_view('pocetna', $data);
    }
}
