<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adminKorisnici
 *
 * @author Veljko
 */
class AdminKorisnici extends MY_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('meni_model');
        $this->load->model('podaci_o_firmi_model');
        $this->load->model('korisnici_model');
        $this->load->model('uloga_model');
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
        
        $data['podaci_preduzeca'] = $this->podaci_o_firmi_model->podaci();
        
        $rezKorisnici = $this->korisnici_model->podaci();
        
        $data['korisnici'] = $rezKorisnici;
        
        $this->load->library('table'); 
        $this->table->set_template(array('table_open'=>'<table class="table center-block center-block2" border="1">')); 
        $this->table->set_heading('Име корисника', 'Преѕиме корисника', 'Корисничко име', /*'Телефон корисника', 'Mail корисника',*/ 'Улога', 'Измени / Обриши');

        foreach ($rezKorisnici as $k):
            $linkIzmeni = anchor('admin/AdminKorisnici/izmeni/'.$k->id_korisnik, 'Измени');
            $linkObrisi = anchor('admin/AdminKorisnici/obrisi/'.$k->id_korisnik, 'Обриши', array('class' => 'obrisiKorisnik','data-id' => $k->id_korisnik));
            $this->table->add_row($k->ime_korisnika, $k->prezime_korisnika, $k->korisnicko_ime, /*$k->telefon_korisnika, $k->email_korisnika,*/ $k->naziv_uloge, $linkIzmeni." / ".$linkObrisi);
        endforeach;
                
        $data['tabela'] = $this->table->generate(); 
        
        $data['title'] = 'Корисници';
        $this->load_view('admin/korisniciUid', $data);
    }
    public function izmeni($id = null){
        if(empty($this->session->userdata('id_uloge'))):
            redirect('pocetna');
        endif;
        $data['title'] = 'Корисници';
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
            
            $data['uloga'] = $this->uloga_model->podaci();
            
            $this->korisnici_model->id_korisnik = $id;
            $rezKorisnici = $this->korisnici_model->podaci();
            $data['korisnici'] = $rezKorisnici;
            
            $uneti_podaci['ime_korisnika'] = $rezKorisnici[0]->ime_korisnika;
            $uneti_podaci['prezime_korisnika'] = $rezKorisnici[0]->prezime_korisnika;
            $uneti_podaci['korisnicko_ime'] = $rezKorisnici[0]->korisnicko_ime;
            //$uneti_podaci['telefon_korisnika'] = $rezKorisnici[0]->telefon_korisnika;
            //$uneti_podaci['mail_korisnika'] = $rezKorisnici[0]->email_korisnika;
            
            $data['forma_podaci'] = array(
                'class' => 'form',
                'accept-charset' => 'utf-8',
                'method' => 'POST'
            );

            $data['form_ime_korisnika'] = array(
                'class' =>'size',
                'name' => 'tbIme',
                'id' =>'tbIme',
                'placeholder' =>'Милан',
                'value' => isset($uneti_podaci['ime_korisnika']) ? $uneti_podaci['ime_korisnika'] : '', 
                'required' => TRUE
            );
            $data['form_prezime_korisnika'] = array(
                'class' => 'size',
                'name' => 'tbPrezime',
                'id' => 'tbPrezime',
                'placeholder' =>'Милић',
                'value'=>isset($uneti_podaci['prezime_korisnika']) ? $uneti_podaci['prezime_korisnika'] : '', 
                'required'=> TRUE
            );
            $data['form_korisnicko_ime'] = array(
                'class' => 'size',
                'name' => 'tbKorisnickoIme',
                'id' =>'tbKorisnickoIme',
                'placeholder' =>'Неко корисничко име',
                'value'=>isset($uneti_podaci['korisnicko_ime']) ? $uneti_podaci['korisnicko_ime'] : '', 
                'required'=> TRUE
            );
            $data['form_lozinka'] = array(
                'class' => 'size',
                'name' => 'tbLozinka',
                'id' => 'tbLozinka',
                'placeholder' =>'Лозинка',
                'required'=> TRUE
            );
            $data['form_ponovo_lozinka'] = array(
                'class' => 'size',
                'name' => 'tbLozinkaP',
                'id' => 'tbLozinkaP',
                'placeholder' =>'Поновите лозинку',
                'required'=> TRUE
            );
//            $data['form_telefon_korisnika'] = array(
//                'class' => 'size',
//                'name' => 'tbTelefon',
//                'id' => 'tbTelefon',
//                'value'=>isset($uneti_podaci['telefon_korisnika']) ? $uneti_podaci['telefon_korisnika'] : '', 
//                'required'=> TRUE
//            );
//            $data['form_mail_korisnika'] = array(
//                'name' => 'tbMail',
//                'class' => 'size',
//                'id' => 'tbMail',
//                'value'=>isset($uneti_podaci['mail_korisnika']) ? $uneti_podaci['mail_korisnika'] : '', 
//                'required'=> TRUE
//            );
            $data['form_dodaj_submit'] = array(
                'name' => 'btnIzmeni',
                'class' => 'right form-control',
                'id' => 'btnIzmeni',
                'value' => 'Измени'
            );
            
            $is_post=$this->input->server('REQUEST_METHOD') == 'POST'; 
            if($is_post):
                $dugme = $this->input->post('btnIzmeni');
                if($dugme != ""):
                    $ime_korisnika = trim($this->input->post('tbIme'));
                    $prezime_korisnika = trim($this->input->post('tbPrezime'));
                    $korisnicko_ime = trim($this->input->post('tbKorisnickoIme'));
                    $lozinka = md5(trim($this->input->post('tbLozinka')));
                    $loznika_ponovo = md5(trim($this->input->post('tbLozinkaP')));
                    //$telefon_korisnika = trim($this->input->post('tbTelefon'));
                    //$mail_korisnika = trim($this->input->post('tbMail'));
                    $uloga_korisnika = $this->input->post('ddlUloga');
                
                    $this->load->library('form_validation');
                
                    $this->form_validation->set_rules('tbIme','име корисника','trim|required|xss_clean');
                    $this->form_validation->set_rules('tbPrezime','презиме корисника','trim|required|xss_clean');
                    $this->form_validation->set_rules('tbKorisnickoIme','корисничко име','trim|required|xss_clean');
                    $this->form_validation->set_rules('tbLozinka','лозинка корисника','trim|required|matches[tbLozinkaP]|xss_clean');
                    $this->form_validation->set_rules('tbLozinkaP','поновњена лозинка','trim|required|xss_clean');
                    //$this->form_validation->set_rules('tbTelefon','телефон корисника','trim|required|xss_clean');
                    //$this->form_validation->set_rules('tbMail','mail корисника','trim|required|xss_clean');
                    $this->form_validation->set_rules('ddlUloga','улога корисника','callback_proveraUloge');

                    $this->form_validation->set_message('required','Поље %s је празно.');
                    $this->form_validation->set_message('matches','Поље %s и %s се не поклапају!');
                    $this->form_validation->set_message('proveraUloge','Поље %s мора бити изабрано!');
                
                    if($this->form_validation->run()):
                
                        $this->korisnici_model->ime_korisnika = $ime_korisnika;
                        $this->korisnici_model->prezime_korisnika = $prezime_korisnika;
                        $this->korisnici_model->korisnicko_ime = $korisnicko_ime;
                        $this->korisnici_model->lozinka_korisnika = $lozinka;
                        //$this->korisnici_model->telefon_korisnika = $telefon_korisnika;
                        //$this->korisnici_model->email_korisnika = $mail_korisnika;
                        $this->korisnici_model->id_uloge = $uloga_korisnika;
                        $uslovKorisnici = array(
                            'id_korisnik' => $id
                        );
                        $this->korisnici_model->uslov = $uslovKorisnici;
                        
                        $rez = $this->korisnici_model->izmeni();
                        if($rez == TRUE):
                            $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешно сте изменили корисника!</div>";
                            $uneti_podaci['ime_korisnika'] = $ime_korisnika;
                            $uneti_podaci['prezime_korisnika'] = $prezime_korisnika;
                            $uneti_podaci['korisnicko_ime'] = $korisnicko_ime;
                            //$uneti_podaci['telefon_korisnika'] = $telefon_korisnika;
                            //$uneti_podaci['mail_korisnika'] = $mail_korisnika;
                            
                            $data['forma_podaci'] = array(
                                'class' => 'form',
                                'accept-charset' => 'utf-8',
                                'method' => 'POST'
                            );
                            $data['form_ime_korisnika'] = array(
                                'class' =>'size',
                                'name' => 'tbIme',
                                'id' =>'tbIme',
                                'placeholder' =>'Милан',
                                'value' => isset($uneti_podaci['ime_korisnika']) ? $uneti_podaci['ime_korisnika'] : '', 
                                'required' => TRUE
                            );
                            $data['form_prezime_korisnika'] = array(
                                'class' => 'size',
                                'name' => 'tbPrezime',
                                'id' => 'tbPrezime',
                                'placeholder' =>'Милић',
                                'value'=>isset($uneti_podaci['prezime_korisnika']) ? $uneti_podaci['prezime_korisnika'] : '', 
                                'required'=> TRUE
                            );
                            $data['form_korisnicko_ime'] = array(
                                'class' => 'size',
                                'name' => 'tbKorisnickoIme',
                                'id' =>'tbKorisnickoIme',
                                'placeholder' =>'Неко корисничко име',
                                'value'=>isset($uneti_podaci['korisnicko_ime']) ? $uneti_podaci['korisnicko_ime'] : '', 
                                'required'=> TRUE
                            );
                            $data['form_lozinka'] = array(
                                'class' => 'size',
                                'name' => 'tbLozinka',
                                'id' => 'tbLozinka',
                                'placeholder' =>'Лоѕинка',
                                'required'=> TRUE
                            );
                            $data['form_ponovo_lozinka'] = array(
                                'class' => 'size',
                                'name' => 'tbLozinkaP',
                                'id' => 'tbLozinkaP',
                                'placeholder' =>'Поновите лозинку',
                                'required'=> TRUE
                            );
//                            $data['form_telefon_korisnika'] = array(
//                                'class' => 'size',
//                                'name' => 'tbTelefon',
//                                'id' => 'tbTelefon',
//                                'value'=>isset($uneti_podaci['telefon_korisnika']) ? $uneti_podaci['telefon_korisnika'] : '', 
//                                'required'=> TRUE
//                            );
//                            $data['form_mail_korisnika'] = array(
//                                'name' => 'tbMail',
//                                'class' => 'size',
//                                'id' => 'tbMail',
//                                'value'=>isset($uneti_podaci['mail_korisnika']) ? $uneti_podaci['mail_korisnika'] : '', 
//                                'required'=> TRUE
//                            );
                            $data['form_dodaj_submit'] = array(
                                'name' => 'btnIzmeni',
                                'class' => 'right form-control',
                                'id' => 'btnIzmeni',
                                'value' => 'Измени'
                            );
                            $this->load_view('admin/izmeniKorisnika', $data);
                        else:
                            $data['obavestenje'] = "<div class='alert alert-danger ispis'>Измена корисника није успела!</div>";
                        endif;
                    else:
                        $uneti_podaci['ime_korisnika'] = $ime_korisnika;
                        $uneti_podaci['prezime_korisnika'] = $prezime_korisnika;
                        $uneti_podaci['korisnicko_ime'] = $korisnicko_ime;
                        //$uneti_podaci['telefon_korisnika'] = $telefon_korisnika;
                        //$uneti_podaci['mail_korisnika'] = $mail_korisnika;
                        
                        $data['obavestenje'] = "<div class='alert alert-danger ispis'>Унети подаци нису исправни!</div>";
                        
                    endif;
                endif;
            endif;
            
            
            $this->load_view('admin/izmeniKorisnika', $data);

        endif;
    }
    public function obrisi($id = null){
        if(empty($this->session->userdata('id_uloge'))):
            redirect('pocetna');
        endif;
        if($id != null):
            $poslato = $this->input->get('poslato');
            if(!empty($poslato)):

                $this->korisnici_model->id_korisnik = $id;
                $this->korisnici_model->obrisi();
                
                $this->load->model('korisnici_model', 'kor');
                $rezKorisnici = $this->kor->podaci();
                $data['korisnici'] = $rezKorisnici;
                
                $this->load->library('table'); //ucitavanje bibiliote table
                $this->table->set_template(array('table_open'=>'<table class="table center-block center-block2" border="1">')); //postavljanje otvorenog taga table da bi postavili class-u za njega
                 $this->table->set_heading('Име корисника', 'Преѕиме корисника', 'Корисничко име', /*'Телефон корисника', 'Mail корисника',*/ 'Улога', 'Измени / Обриши'); //naslov kolona isto kao i th tag
                if($rezKorisnici != null):
                    foreach ($rezKorisnici as $k):
                        $linkIzmeni = anchor('admin/AdminKorisnici/izmeni/'.$k->id_korisnik, 'Измени');
                        $linkObrisi = anchor('admin/AdminKorisnici/obrisi/'.$k->id_korisnik, 'Обриши', array('class' => 'obrisiKorisnik','data-id' => $k->id_korisnik));
                        $this->table->add_row($k->ime_korisnika, $k->prezime_korisnika, $k->korisnicko_ime, /*$k->telefon_korisnika, $k->email_korisnika,*/ $k->naziv_uloge, $linkIzmeni." / ".$linkObrisi);
                    endforeach;
                
                    $data['title'] = 'Корисници';

                    $data['tabela'] = $this->table->generate(); 
                else:
                    $data['obavestenje'] = 'Грешка';
                endif;
                $this->load->view('ajax/brisanjeKorisnika', $data);
            endif;
        endif;
    }
    public function dodaj(){
        if(empty($this->session->userdata('id_uloge'))):
            redirect('pocetna');
        endif;
        $data['title'] = 'Корисници';
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
        
        //$data['korisnici'] = $this->korisnici_model->podaci();
        $data['uloga'] = $this->uloga_model->podaci();
        
        $rez= $this->korisnici_model->podaci();
        $data['korisnici'] = $rez;
        $is_post=$this->input->server('REQUEST_METHOD') == 'POST'; 
        if($is_post):
            $dugme = $this->input->post('btnDodaj');
            if($dugme != ""):
                $ime_korisnika = trim($this->input->post('tbIme'));
                $prezime_korisnika = trim($this->input->post('tbPrezime'));
                $korisnicko_ime = trim($this->input->post('tbKorisnickoIme'));
                $lozinka = md5(trim($this->input->post('tbLozinka')));
                $loznika_ponovo = md5(trim($this->input->post('tbLozinkaP')));
                //$telefon_korisnika = trim($this->input->post('tbTelefon'));
                //$mail_korisnika = trim($this->input->post('tbMail'));
                $uloga_korisnika = $this->input->post('ddlUloga');
                
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('tbIme','име корисника','trim|required|xss_clean');
                $this->form_validation->set_rules('tbPrezime','презиме корисника','trim|required|xss_clean');
                $this->form_validation->set_rules('tbKorisnickoIme','корисничко име','trim|required|xss_clean');
                $this->form_validation->set_rules('tbLozinka','лоѕинка корисника','trim|required|matches[tbLozinkaP]|xss_clean');
                $this->form_validation->set_rules('tbLozinkaP','поновљена лозинка','trim|required|xss_clean');
                //$this->form_validation->set_rules('tbTelefon','телефон корисника','trim|required|xss_clean');
                //$this->form_validation->set_rules('tbMail','mail корисника','trim|required|xss_clean');
                $this->form_validation->set_rules('ddlUloga','улога корисника','callback_proveraUloge');
                
                $this->form_validation->set_message('required','Поље %s је празно.');
                $this->form_validation->set_message('matches','Поље %s и %s се не поклапају!');
                $this->form_validation->set_message('proveraUloge','Поље %s мора бити изабрано!');
                
                if($this->form_validation->run()):
                
                    $this->korisnici_model->ime_korisnika = $ime_korisnika;
                    $this->korisnici_model->prezime_korisnika = $prezime_korisnika;
                    $this->korisnici_model->korisnicko_ime = $korisnicko_ime;
                    $this->korisnici_model->lozinka_korisnika = $lozinka;
                    //$this->korisnici_model->telefon_korisnika = $telefon_korisnika;
                    //$this->korisnici_model->email_korisnika = $mail_korisnika;
                    $this->korisnici_model->id_uloge = $uloga_korisnika;
                    
                    $rez = $this->korisnici_model->unesi();
                    if($rez == TRUE):
                        $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешно сте додали корисника!</div>";
                    else:
                        $data['obavestenje'] = "<div class='alert alert-danger ispis'>Додавање корисника није успело!</div>";
                    endif;
                else:
                    $uneti_podaci['ime_korisnika'] = $ime_korisnika;
                    $uneti_podaci['prezime_korisnika'] = $prezime_korisnika;
                    $uneti_podaci['korisnicko_ime'] = $korisnicko_ime;
                    //$uneti_podaci['telefon_korisnika'] = $telefon_korisnika;
                    //$uneti_podaci['mail_korisnika'] = $mail_korisnika;
                    
                    $data['obavestenje'] = "<div class='alert alert-danger ispis'>Унети подаци нису исправни!</div>";
                    
                endif;
            endif;
        endif;
        $data['forma_podaci'] = array(
            'class' => 'form',
            'accept-charset' => 'utf-8',
            'method' => 'POST'
        );

        $data['form_ime_korisnika'] = array(
            'class' =>'size',
            'name' => 'tbIme',
            'id' =>'tbIme',
            'value'=>isset($uneti_podaci['ime_korisnika']) ? $uneti_podaci['ime_korisnika'] : '',
            'placeholder' =>'Милан',
            'required' => TRUE
        );
        $data['form_prezime_korisnika'] = array(
            'class' => 'size',
            'name' => 'tbPrezime',
            'id' => 'tbPrezime',
            'value'=>isset($uneti_podaci['prezime_korisnika']) ? $uneti_podaci['prezime_korisnika'] : '', 
            'placeholder' =>'Милић',
            'required'=> TRUE
        );
        $data['form_korisnicko_ime'] = array(
            'class' => 'size',
            'name' => 'tbKorisnickoIme',
            'id' =>'tbKorisnickoIme',
            'value'=>isset($uneti_podaci['korisnicko_ime']) ? $uneti_podaci['korisnicko_ime'] : '',
            'placeholder' =>'Неко корисничко име',
            'required'=> TRUE
        );
        $data['form_lozinka'] = array(
            'class' => 'size',
            'name' => 'tbLozinka',
            'id' => 'tbLozinka',
            'placeholder' =>'Лозинка',
            'required'=> TRUE
        );
        $data['form_ponovo_lozinka'] = array(
            'class' => 'size',
            'name' => 'tbLozinkaP',
            'id' => 'tbLozinkaP',
            'placeholder' =>'Поновите лозинку',
            'required'=> TRUE
        );
//        $data['form_telefon_korisnika'] = array(
//            'class' => 'size',
//            'name' => 'tbTelefon',
//            'id' => 'tbTelefon',
//            'value'=>isset($uneti_podaci['telefon_korisnika']) ? $uneti_podaci['telefon_korisnika'] : '', 
//            'required'=> TRUE
//        );
//        $data['form_mail_korisnika'] = array(
//            'name' => 'tbMail',
//            'class' => 'size',
//            'id' => 'tbMail',
//            'value'=>isset($uneti_podaci['mail_korisnika']) ? $uneti_podaci['mail_korisnika'] : '', 
//            'required'=> TRUE
//        );
        $data['form_dodaj_submit'] = array(
            'name' => 'btnDodaj',
            'class' => 'right form-control',
            'id' => 'btnDodaj',
            'value' => 'Додај'
        );
        
        $data['id_uloge'] = $this->session->userdata('id_uloge');
        
        $this->load_view('admin/dodajKorisnika', $data);
    }
    function proveraUloge($unos) 
    {
        if($unos==0):
            return false;
        else:
            return true;
        endif;
    }
}
