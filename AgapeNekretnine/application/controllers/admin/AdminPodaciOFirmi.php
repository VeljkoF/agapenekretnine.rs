<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adminPodaciOFirmi
 *
 * @author Veljko
 */
class AdminPodaciOFirmi extends MY_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('meni_model');
        $this->load->model('podaci_o_firmi_model');
        $this->load->library('form_validation');
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
        $data['meni'] = $this->meni_model->podaci();

        $rez= $this->podaci_o_firmi_model->podaci();
        $data['podaci_preduzeca'] = $rez;
        
        $is_post=$this->input->server('REQUEST_METHOD') == 'POST'; 
        if($is_post):
            $dugme = $this->input->post('btnIzmeni');
            if($data != ""):
                $naziv_firme = $this->input->post('tbNaziv');
                $registracija_firme = $this->input->post('tbRegistracija');
                $adresa_firme = $this->input->post('tbAdresa');
                $grad_firme = $this->input->post('tbGrad');
                $zemlja_firme = $this->input->post('tbZemlja');
                $telefon_firme = $this->input->post('tbTelefon');
                $radno_vreme_firme = $this->input->post('tbRadnoVreme');
                $mail_firme = $this->input->post('tbMail');
                $opis_firme = $this->input->post('tbOpis');
                $opis_firme_duzi = $this->input->post('tbOpisDuzi');
                $tekst = $this->input->post('tbOtvoreni');
                $registarski_broj_firme = $this->input->post('tbRegBroj');
                
                $this->form_validation->set_rules('tbNaziv','назив фирме','trim|required|xss_clean');
                $this->form_validation->set_rules('tbRegistracija','регистрација фирме','trim|required|xss_clean');
                $this->form_validation->set_rules('tbAdresa','адреса фирме','trim|required|xss_clean');
                $this->form_validation->set_rules('tbGrad','град фирме','trim|required|xss_clean');
                $this->form_validation->set_rules('tbZemlja','земља фирме','trim|required|xss_clean');
                $this->form_validation->set_rules('tbTelefon','телефон фирме','trim|required|xss_clean');
                $this->form_validation->set_rules('tbRadnoVreme','радно време фирме','trim|required|xss_clean');
                $this->form_validation->set_rules('tbMail','mail фирме','trim|required|xss_clean');
                $this->form_validation->set_rules('tbOpis','опис фирме','trim|required|xss_clean');
                $this->form_validation->set_rules('tbOpisDuzi','дужи опис фирме','trim|required|xss_clean');
                $this->form_validation->set_rules('tbOtvoreni','текст','trim|required|xss_clean');
                $this->form_validation->set_rules('tbRegBroj','регистарски број фирме','trim|required|xss_clean');
                
                $this->form_validation->set_message('required','Поље %s је празно.');
                
                if($this->form_validation->run()):
                
                    $this->podaci_o_firmi_model->naziv_firme = $naziv_firme;
                    $this->podaci_o_firmi_model->registracija_firme = $registracija_firme;
                    $this->podaci_o_firmi_model->opis_firme = $opis_firme;
                    $this->podaci_o_firmi_model->opis_firme_duzi = $opis_firme_duzi;
                    $this->podaci_o_firmi_model->otvoreni_smo_firma = $tekst;
                    $this->podaci_o_firmi_model->adresa_firme = $adresa_firme;
                    $this->podaci_o_firmi_model->grad_firme = $grad_firme;
                    $this->podaci_o_firmi_model->zemlja_firme = $zemlja_firme;
                    $this->podaci_o_firmi_model->telefon_firme = $telefon_firme;
                    $this->podaci_o_firmi_model->email_firme = $mail_firme;
                    $this->podaci_o_firmi_model->radno_vreme_firme = $radno_vreme_firme;
                    $this->podaci_o_firmi_model->registarski_broj_firme = $registarski_broj_firme;
                    
                    $rez = $this->podaci_o_firmi_model->izmeni();
                    if($rez == TRUE):
                        $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешно сте изменили податке о фирми!</div>";
                    else:
                        $data['obavestenje'] = "<div class='alert alert-danger ispis'>Измена података о фирми није успела!</div>";
                    endif;
                endif;
            endif;
        endif;
        $rez= $this->podaci_o_firmi_model->podaci();
        $data['podaci_preduzeca'] = $rez;
            $data['forma_podaci'] = array(
                'class' => 'form',
                'accept-charset' => 'utf-8',
                'method' => 'POST'
            );

            $data['form_naziv_firme'] = array(
                'class' =>'size',
                'name' => 'tbNaziv',
                'value' => $rez[0]->naziv_firme,
                'id' =>'tbNaziv',
                'required'
            );
            $data['form_registracija_firme'] = array(
                'class' => 'size',
                'name' => 'tbRegistracija',
                'id' => 'tbRegistracija',
                'required',
                'value' => $rez[0]->registracija_firme
            );
            $data['form_adresa_firme'] = array(
                'class' => 'size',
                'name' => 'tbAdresa',
                'id' =>'tbAdresa',
                'required',
                'value' => $rez[0]->adresa_firme
            );
            $data['form_grad_firme'] = array(
                'class' => 'size',
                'name' => 'tbGrad',
                'id' => 'tbGrad',
                'required',
                'value' => $rez[0]->grad_firme
            );
            $data['form_zemlja_firme'] = array(
                'class' => 'size',
                'name' => 'tbZemlja',
                'id' => 'tbZemlja',
                'required',
                'value' => $rez[0]->zemlja_firme
            );
            $data['form_telefon_firme'] = array(
                'class' => 'size',
                'name' => 'tbTelefon',
                'id' => 'tbTelefon',
                'required',
                'value' => $rez[0]->telefon_firme
            );
            $data['form_radno_vreme_firme'] = array(
                'rows' => '4',
                'cols' => '50',
                'name' => 'tbRadnoVreme',
                'class' => 'size',
                'id' => 'tbRadnoVreme',
                'required',
                'value' => $rez[0]->radno_vreme_firme
            );
            $data['form_mail_firme'] = array(
                'name' => 'tbMail',
                'class' => 'size',
                'id' => 'tbMail',
                'required',
                'value' => $rez[0]->email_firme
            );
            $data['form_opis_firme'] = array(
                'name' => 'tbOpis',
                'class' => 'size',
                'id' => 'tbOpis',
                'required',
                'value' => $rez[0]->opis_firme
            );
            $data['form_opis_firme_duzi'] = array(
                'rows' => '4',
                'cols' => '50',
                'name' => 'tbOpisDuzi',
                'class' => 'size',
                'id' => 'tbOpisDuzi',
                'required',
                'value' => $rez[0]->opis_firme_duzi
            );
            $data['form_tekst'] = array(
                'rows' => '4',
                'cols' => '50',
                'name' => 'tbOtvoreni',
                'class' => 'size',
                'id' => 'tbOtvoreni',
                'required',
                'value' => $rez[0]->otvoreni_smo_firma
            );
            $data['form_reg_broj'] = array(
                'rows' => '4',
                'cols' => '50',
                'name' => 'tbRegBroj',
                'class' => 'size',
                'id' => 'tbRegBroj',
                'required',
                'value' => $rez[0]->registarski_broj_firme
            );
            $data['form_izmeni_submit'] = array(
                'name' => 'btnIzmeni',
                'class' => 'right form-control',
                'id' => 'btnIzmeni',
                'value' => 'Измени'
            );
            $data['title'] = 'Подаци о фирми';
            $this->load_view('admin/izmeniPodatke', $data);
    }
}
