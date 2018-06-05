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
class Nekretnine extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('meni_model');
        $this->load->model('podaci_o_firmi_model');
        $this->load->model('tip_nekretnine_model');
        $this->load->model('nekretnine_model');
        $this->load->model('agenti_model');
        $this->load->model('slika_nekretnine_model');
        $this->load->model('kategorija_model');
        $this->load->model('grad_model');
        $this->load->model('deo_grada_model');
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
            'front_slika' => '1'
        );
        $order_byNekretnine = "cena_nekretnina ASC";
        
        $this->meni_model->uslov = $uslovMeni;
        $data['meni'] = $this->meni_model->podaci();
        
        $data['podaci_preduzeca'] = $this->podaci_o_firmi_model->podaci();
        
        $this->nekretnine_model->uslov = $uslovNekretnine;
        $this->nekretnine_model->order_by = $order_byNekretnine;
        $data['nekretnine'] = $this->nekretnine_model->podaci();
        
        $optionsTipSelect = $this->tip_nekretnine_model->podaci();
        $optionsTip = array(0=> 'Изабери тип некретнине...');
        foreach ($optionsTipSelect as $s):
            $optionsTip += array($s->id_tip_nekretnina => $s->naziv_tip_nekretnina);
        endforeach;
          
        $data['ddlTip'] = form_dropdown('ddlTip', $optionsTip);
        
        $optionsKategorijaSelect = $this->kategorija_model->podaci();
        $optionsKategorija = array(0=> 'Изабери категорију...');
        foreach ($optionsKategorijaSelect as $s):
            $optionsKategorija += array($s->id_kategorije => $s->naziv_kategorije);
        endforeach;
        
        $data['ddlKategorija'] = form_dropdown('ddlKategorija', $optionsKategorija);
        
        $optionsGradSelect = $this->deo_grada_model->podaci();
        $optionsGrad = array(0=> 'Изабери место...');
        foreach ($optionsGradSelect as $s):
            $optionsGrad += array($s->id_deo_grada => $s->naziv_deo_grada.", ".$s->naziv_grada);
        endforeach;
        
        $data['ddlGrad'] = form_dropdown('ddlGrad', $optionsGrad);
        
        $is_post=$this->input->server('REQUEST_METHOD') == 'POST';
        if($is_post):
                $dugme = $this->input->post('btnFilter');
                if($data != ""):
                    
                    $tip_nekretnina = $this->input->post('ddlTip');
                    $kategorija_nekretnina = $this->input->post('ddlKategorija');
                    //$lokacija_nekretnina = trim($this->input->post('ddlGrad'));
                    
                    $uslovNekretnine = array(
                        'front_slika' => '1'
                    );
                    
                    if(!empty($tip_nekretnina)):
                        $uslovNekretnine['nekretnine.id_tip_nekretnina'] = $tip_nekretnina; 
                    endif;
                    if(!empty($kategorija_nekretnina)):
                        $uslovNekretnine['nekretnine.id_kategorije'] = $kategorija_nekretnina; 
                    endif;
//                    if(!empty($lokacija_nekretnina)):
//                        $uslovNekretnine['deo_grada_nekretnina'] = $lokacija_nekretnina; 
//                    endif;
                    
                    $order_byNekretnine = "cena_nekretnina ASC";
                    
                    $this->nekretnine_model->uslov = $uslovNekretnine;                  
                    
                    $this->nekretnine_model->order_by = $order_byNekretnine;
                    $data['nekretnine'] = $this->nekretnine_model->podaci();
                    
//                    $data['kategorija'] = $this->kategorija_model->podaci();
//                    $data['grad'] = $this->grad_model->podaci();
//                    $data['deo_grada'] = $this->deo_grada_model->podaci();
                    
                    $optionsTipSelect = $this->tip_nekretnine_model->podaci();
                    $optionsTip = array(0=> 'Изабери тип некретнине...');
                    foreach ($optionsTipSelect as $s):
                        $optionsTip += array($s->id_tip_nekretnina => $s->naziv_tip_nekretnina);
                    endforeach;

                    @$selectedTip = $tip_nekretnina;

                    $data['ddlTip'] = form_dropdown('ddlTip', $optionsTip, $selectedTip);

                    $optionsKategorijaSelect = $this->kategorija_model->podaci();
                    $optionsKategorija = array(0=> 'Изабери категорију...');
                    foreach ($optionsKategorijaSelect as $s):
                        $optionsKategorija += array($s->id_kategorije => $s->naziv_kategorije);
                    endforeach;

                    @$selectedKategorija = $kategorija_nekretnina;

                    $data['ddlKategorija'] = form_dropdown('ddlKategorija', $optionsKategorija, $selectedKategorija);

//                    $optionsGradSelect = $this->deo_grada_model->podaci();
//                    $optionsGrad = array(0=> 'Изабери место...');
//                    foreach ($optionsGradSelect as $s):
//                        $optionsGrad += array($s->id_deo_grada => $s->naziv_deo_grada.", ".$s->naziv_grada);
//                    endforeach;
//
//                    @$selectedGrad = $lokacija_nekretnina;
//
//                    $data['ddlGrad'] = form_dropdown('ddlGrad', $optionsGrad, $selectedGrad);
                endif;
        endif;
        
        
        
        $data['title'] = 'Некретнине';
        $this->load_view('nekretnine', $data);
    }
    
    public function detaljnije($id = NULL)
    {
        if(!empty($this->session->userdata('id_uloge'))):
            redirect('admin/AdminNekretnine');
        endif;
        
        if($id != null):
            $uslovMeni = array(
                'posetilac' => '1'
            );
            $uslovNekretnine = array(
                'front_slika' => '1'
            );
            $order_byNekretnine = "cena_nekretnina ASC";

            $this->meni_model->uslov = $uslovMeni;
            $data['meni'] = $this->meni_model->podaci();

            $data['podaci_preduzeca'] = $this->podaci_o_firmi_model->podaci();

            $data['tip_nekretnine'] = $this->tip_nekretnine_model->podaci();

            $uslovSlika = array(
                'id_nekretnina' => $id
            );
            
            $this->slika_nekretnine_model->uslov = $uslovSlika;
            $data['slikaNekretnine'] = $this->slika_nekretnine_model->podaci();
            
            $this->nekretnine_model->id_nekretnina = $id;
            $data['nekretnine'] = $this->nekretnine_model->dohvati();
            
            $data['title'] = 'Детаљи некретнине';
            $this->load_view('nekretnineDetaljnije', $data);
        endif;
    }
    
    
}
