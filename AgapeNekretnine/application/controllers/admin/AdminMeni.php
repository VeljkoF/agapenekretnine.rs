<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adminMeni
 *
 * @author Veljko
 */
class AdminMeni extends MY_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('meni_model');
        $this->load->model('podaci_o_firmi_model');
    }
    
    public function index(){
        if(empty($this->session->userdata('id_uloge'))):
            redirect('pocetna');
        endif;
        $data['id_uloge'] = $this->session->userdata('id_uloge');
        
        if($data['id_uloge'] == 1):
            $uslovMeni = array(
                'admin' => '1'
            );
        elseif($data['id_uloge'] == 2):
            $uslovMeni = array(
                'korisnik' => '1'
            );
        else:
            $uslovMeni = array(
                'posetilac' => '1'
            );
        endif;
        $this->meni_model->uslov = $uslovMeni;
        $rezMeni = $this->meni_model->podaci();
        $data['meni'] = $rezMeni;
        
        $data['podaci_preduzeca'] = $this->podaci_o_firmi_model->podaci();
        
        
        
                
        $this->load->model('meni_model', 'meniM');
        $uslovZaMeni = array(
            'admin' => '1'
        );
        $this->meniM->uslov = $uslovZaMeni;
        $rezZaMeni = $this->meniM->podaci();
        $data['rezZaMeni'] = $rezZaMeni;
        
        $data['title'] = 'Meni';
        $this->load_view('admin/meniUid', $data);
    }
    
    public function izmeni($id = null){
        if(empty($this->session->userdata('id_uloge'))):
            redirect('pocetna');
        endif;
        $data['title'] = 'Мени';
        if($id != null):
            
            $data['id_uloge'] = $this->session->userdata('id_uloge');

            if($data['id_uloge'] == 1):
                $uslovMeni = array(
                    'admin' => '1'
                );
            elseif($data['id_uloge'] == 2):
                $uslovMeni = array(
                    'korisnik' => '1'
                );
            else:
                $uslovMeni = array(
                    'posetilac' => '1'
                );
            endif;
            $this->meni_model->uslov = $uslovMeni;
            $data['meni'] = $this->meni_model->podaci();

            $data['podaci_preduzeca'] = $this->podaci_o_firmi_model->podaci();
            
            $this->load->model('meni_model', 'meniIzmeni');
            
            $uslovMeniIzmeni = array(
                'admin' => '1'
            );
            $this->meniIzmeni->uslov = $uslovMeniIzmeni;
            $this->meniIzmeni->id_meni = $id;
            
            $rezMeni = $this->meniIzmeni->podaci();
            
            $data['rezMeni'] = $rezMeni;
            
            $data['forma_podaci'] = array(
                'class' => 'form',
                'accept-charset' => 'utf-8',
                'method' => 'POST'
            );
            $data['form_naziv'] = array(
                'class' =>'size',
                'name' => 'tbNaziv',
                'id' =>'tbNaziv',
                'value' => $rezMeni[0]->naziv_meni, 
                'required' => TRUE
            );
            $data['form_izmeni_submit'] = array(
                'name' => 'btnIzmeni',
                'class' => 'right form-control',
                'id' => 'btnIzmeni',
                'value' => 'Измени'
            );
            
            $is_post=$this->input->server('REQUEST_METHOD') == 'POST'; 
            if($is_post):
                $dugme = $this->input->post('btnIzmeni');
                if($dugme != ""):
                    $naziv_meni = trim($this->input->post('tbNaziv'));
                    $korisnikMeni = $this->input->post('ddlMeni');
                
                    $this->load->library('form_validation');
                
                    $this->form_validation->set_rules('tbNaziv','име корисника','trim|required|xss_clean');

                    $this->form_validation->set_message('required','Поље %s је празно.');
                
                    if($this->form_validation->run()):
                        
                        $this->meniIzmeni->naziv_meni = $naziv_meni;
                        $this->meniIzmeni->korisnik = $korisnikMeni;
                        $rez = $this->meniIzmeni->izmeni();
                        
                        if($rez == TRUE):
                            $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешно сте променили права корисника!</div>";
                            $uneti_podaci['naziv_meni'] = $naziv_meni;
                            $uneti_podaci['ddlMeni'] = $korisnikMeni;
                            
                            $data['forma_podaci'] = array(
                                'class' => 'form',
                                'accept-charset' => 'utf-8',
                                'method' => 'POST'
                            );
                            $data['form_naziv'] = array(
                                'class' =>'size',
                                'name' => 'tbNaziv',
                                'id' =>'tbNaziv',
                                'value' => isset($uneti_podaci['naziv_meni']) ? $uneti_podaci['naziv_meni'] : '', 
                                'required' => TRUE
                            );
                            $data['form_izmeni_submit'] = array(
                                'name' => 'btnIzmeni',
                                'class' => 'right form-control',
                                'id' => 'btnIzmeni',
                                'value' => 'Измени'
                            );
                            
                        else:
                            $data['obavestenje'] = "<div class='alert alert-danger ispis'>Измена права корисника није успела!</div>";
                        endif;
                        
                    else:
                        $uneti_podaci['naziv_meni'] = $naziv_meni;
                        $uneti_podaci['ddlMeni'] = $korisnikMeni;
                        
                        $data['obavestenje'] = "<div class='alert alert-danger ispis'>Унети подави нису исправни!</div>";
                        
                    endif;
                    $data['uneti_podaci'] = $uneti_podaci;
//                    $this->load_view('admin/izmeniMeni', $data);
                endif;
            endif;
        endif;
        $this->load_view('admin/izmeniMeni', $data);
    }    
}
