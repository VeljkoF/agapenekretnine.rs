<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of galerija
 *
 * @author Veljko
 */
class Galerija extends MY_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('meni_model');
        $this->load->model('podaci_o_firmi_model');
        $this->load->model('slika_nekretnine_model');
        $this->load->library('pagination');
    }
    public function index()
    {
        if(!empty($this->session->userdata('id_uloge'))):
            redirect('admin/AdminNekretnine');
        endif;
        
        $uslovMeni = array(
        'posetilac' => '1'
        );
        $order_byNekretnine = "cena_nekretnina ASC";

        $this->meni_model->uslov = $uslovMeni;
        $data['meni'] = $this->meni_model->podaci();

        $data['podaci_preduzeca'] = $this->podaci_o_firmi_model->podaci();

        $data['nekretnine'] = $this->slika_nekretnine_model->podaci();

        $config['base_url'] = base_url()."Galerija/index";
        $config['total_rows'] = $this->db->count_all('slika_nekretnine');
        $config['per_page'] = '6';
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->load->model('slika_nekretnine_model', 'slika');
        $data['slike'] = $this->slika->galerija($config["per_page"], $data['page']);
        $data['paginacija'] = $this->pagination->create_links();        
        
        $data['title'] = 'Galerija';
        $this->load_view('galerija', $data);    
    }
    
}
