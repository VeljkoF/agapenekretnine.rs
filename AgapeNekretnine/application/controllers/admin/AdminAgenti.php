<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adminAgenti
 *
 * @author Veljko
 */
class AdminAgenti extends MY_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('meni_model');
        $this->load->model('podaci_o_firmi_model');
        $this->load->model('agenti_model');
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
        
        $data['agenti'] = $this->agenti_model->podaci();
        
        $data['title'] = 'Agenti';
        $this->load_view('admin/agentiUid', $data);
    }
    public function izmeni($id = null){
        if(empty($this->session->userdata('id_uloge'))):
            redirect('pocetna');
        endif;
        $data['title'] = 'Agenti';
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
            
            $this->agenti_model->id_agenta = $id;
            $rezAgenti = $this->agenti_model->podaci();
            $data['agenti'] = $rezAgenti;
            
            $uneti_podaci['ime_agenta'] = $rezAgenti[0]->ime_agenta;
            $uneti_podaci['prezime_agenta'] = $rezAgenti[0]->prezime_agenta;
            $uneti_podaci['telefon_agenta'] = $rezAgenti[0]->telefon_agenta;
            //$uneti_podaci['mail_agenta'] = $rezAgenti[0]->mail_agenta;
            
            $data['forma_podaci'] = array(
            'class' => 'form',
            'accept-charset' => 'utf-8',
            'method' => 'POST'
            );

            $data['form_ime_agenta'] = array(
                'class' =>'size',
                'name' => 'tbIme',
                'id' =>'tbIme',
                'placeholder' =>'Милан',
                'value'=>isset($uneti_podaci['ime_agenta']) ? $uneti_podaci['ime_agenta'] : '', 
                'required' => TRUE
            );
            $data['form_prezime_agenta'] = array(
                'class' => 'size',
                'name' => 'tbPrezime',
                'id' => 'tbPrezime',
                'placeholder' =>'Милић',
                'value'=>isset($uneti_podaci['prezime_agenta']) ? $uneti_podaci['prezime_agenta'] : '', 
                'required'=> TRUE
            );
            $data['form_telefon_agenta'] = array(
                'class' => 'size',
                'name' => 'tbTelefon',
                'id' => 'tbTelefon',
                'placeholder' =>'+381631234567',
                'value'=>isset($uneti_podaci['telefon_agenta']) ? $uneti_podaci['telefon_agenta'] : '', 
                'required'=> TRUE
            );
//            $data['form_mail_agenta'] = array(
//                'name' => 'tbMail',
//                'class' => 'size',
//                'id' => 'tbMail',
//                'value'=>isset($uneti_podaci['mail_agenta']) ? $uneti_podaci['mail_agenta'] : '', 
//                'required'=> TRUE
//            );
            $data['form_slika_agenta'] = array(
                'name' => 'fSlika',
                'class' => 'size',
                'id' => 'fSlika'
            );
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
                    
                    $config['upload_path'] = 'images/agenti/';
                    $config['allowed_types'] = 'gif|jpg|png|JPG';
                    $config['max_size']	= '2000';
                    $config['max_width']  = '300';
                    $config['max_height']  = '300';

                    $ime_agenta = trim($this->input->post('tbIme'));
                    $prezime_agenta = trim($this->input->post('tbPrezime'));
                    $telefon_agenta = trim($this->input->post('tbTelefon'));
                    //$mail_agenta = trim($this->input->post('tbMail'));
                    
                    $this->load->library('form_validation');
                        
                    $this->form_validation->set_rules('tbIme','име корисника','trim|required|xss_clean');
                    $this->form_validation->set_rules('tbPrezime','презиме корисника','trim|required|xss_clean');
                    $this->form_validation->set_rules('tbTelefon','телефон корисника','trim|required|xss_clean');
                    //$this->form_validation->set_rules('tbMail','mail корисника','trim|required|xss_clean');

                    $this->form_validation->set_message('required','Поље %s је празно.');

                    if($this->form_validation->run()):

                        $this->agenti_model->ime_agenta = $ime_agenta;
                        $this->agenti_model->prezime_agenta = $prezime_agenta;
                        $this->agenti_model->telefon_agenta = $telefon_agenta;
                        //$this->agenti_model->mail_agenta = $mail_agenta;
                        
                        $this->load->library('upload', $config);
                        if (!$this->upload->do_upload('fSlika')):
                            $error = array('error' => $this->upload->display_errors());
                            $this->data['obavestenje'] = $error;
                        else:
                            
                            $data2 = array('upload_data' => $this->upload->data());
                            $this->agenti_model->slika_agenta = 'images/agenti/'.$data2['upload_data']['file_name'];
                        
                        endif;
                        $uslovAgenti = array(
                            'id_agenta' => $id
                        );
                        $this->agenti_model->uslov = $uslovAgenti;

                        $rez = $this->agenti_model->izmeni();

                        if($rez == TRUE):
                            $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешно сте изменили агента!</div>";
                            $uneti_podaci['ime_agenta'] = $ime_agenta;
                            $uneti_podaci['prezime_agenta'] = $prezime_agenta;
                            $uneti_podaci['telefon_agenta'] = $telefon_agenta;
                            //$uneti_podaci['mail_agenta'] = $mail_agenta;

                            $data['forma_podaci'] = array(
                            'class' => 'form',
                            'accept-charset' => 'utf-8',
                            'method' => 'POST'
                            );

                            $data['form_ime_agenta'] = array(
                                'class' =>'size',
                                'name' => 'tbIme',
                                'id' =>'tbIme',
                                'placeholder' =>'Милан',
                                'value'=>isset($uneti_podaci['ime_agenta']) ? $uneti_podaci['ime_agenta'] : '', 
                                'required' => TRUE
                            );
                            $data['form_prezime_agenta'] = array(
                                'class' => 'size',
                                'name' => 'tbPrezime',
                                'id' => 'tbPrezime',
                                'placeholder' =>'Милић',
                                'value'=>isset($uneti_podaci['prezime_agenta']) ? $uneti_podaci['prezime_agenta'] : '', 
                                'required'=> TRUE
                            );
                            $data['form_telefon_agenta'] = array(
                                'class' => 'size',
                                'name' => 'tbTelefon',
                                'id' => 'tbTelefon',
                                'placeholder' =>'+381631234567',
                                'value'=>isset($uneti_podaci['telefon_agenta']) ? $uneti_podaci['telefon_agenta'] : '', 
                                'required'=> TRUE
                            );
//                            $data['form_mail_agenta'] = array(
//                                'name' => 'tbMail',
//                                'class' => 'size',
//                                'id' => 'tbMail',
//                                'value'=>isset($uneti_podaci['mail_agenta']) ? $uneti_podaci['mail_agenta'] : '', 
//                                'required'=> TRUE
//                            );
                            $data['form_slika_agenta'] = array(
                                'name' => 'fSlika',
                                'class' => 'size',
                                'id' => 'fSlika'
                            );
                            $data['form_dodaj_submit'] = array(
                                'name' => 'btnIzmeni',
                                'class' => 'right form-control',
                                'id' => 'btnIzmeni',
                                'value' => 'Измени'
                            );
                            $this->load_view('admin/izmeniAgenta', $data);
                        else:
                            $data['obavestenje'] = "<div class='alert alert-danger ispis'>Измена агента није успела!</div>";
                        endif;
                    else:
                        $uneti_podaci['ime_agenta'] = $ime_agenta;
                        $uneti_podaci['prezime_agenta'] = $prezime_agenta;
                        $uneti_podaci['telefon_agenta'] = $telefon_agenta;
                        //$uneti_podaci['mail_agenta'] = $mail_agenta;

                        $data['obavestenje'] = "<div class='alert alert-danger ispis'>Погрешан унос података!</div>";

                    endif;
                endif;
            endif;
            $this->load_view('admin/izmeniAgenta', $data);
        endif;
    }
    public function obrisi($id = null){
        if(empty($this->session->userdata('id_uloge'))):
            redirect('pocetna');
        endif;
        if($id != null):

            $this->agenti_model->id_agenta = $id;
            $this->agenti_model->obrisi();

            redirect('admin/AdminAgenti');
        endif;
    }
    public function dodaj(){
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
        
        $rez= $this->agenti_model->podaci();
        $data['agenti'] = $rez;
        
        $is_post=$this->input->server('REQUEST_METHOD') == 'POST'; 
        if($is_post):
            $dugme = $this->input->post('btnDodaj');
            if($dugme != ""):
                $ime_agenta = trim($this->input->post('tbIme'));
                $prezime_agenta = trim($this->input->post('tbPrezime'));
                $telefon_agenta = trim($this->input->post('tbTelefon'));
                //$mail_agenta = trim($this->input->post('tbMail'));
                
                $config['upload_path'] = 'images/agenti/';
                $config['allowed_types'] = 'gif|jpg|png|JPG';
                $config['max_size']	= '2000';
                $config['max_width']  = '300';
                $config['max_height']  = '300';
                
                $this->load->library('upload', $config);
                
                $this->load->library('form_validation');
                
                if (!$this->upload->do_upload('fSlika')):
                    $error = array('error' => $this->upload->display_errors());
                    $this->data['obavestenje'] = $error;
                else:
                    $data = array('upload_data' => $this->upload->data());
                    $this->form_validation->set_rules('tbIme','име корисника','trim|required|xss_clean');
                    $this->form_validation->set_rules('tbPrezime','презиме корисника','trim|required|xss_clean');
                    $this->form_validation->set_rules('tbTelefon','телефон корисника','trim|required|xss_clean');
                    //$this->form_validation->set_rules('tbMail','mail корисника','trim|required|xss_clean');

                    $this->form_validation->set_message('required','Поље %s је празно.');

                    if($this->form_validation->run()):

                        $this->agenti_model->ime_agenta = $ime_agenta;
                        $this->agenti_model->prezime_agenta = $prezime_agenta;
                        $this->agenti_model->telefon_agenta = $telefon_agenta;
                        //$this->agenti_model->mail_agenta = $mail_agenta;
                        $this->agenti_model->slika_agenta = 'images/agenti/'.$data['upload_data']['file_name'];

                        $rez = $this->agenti_model->unesi();
                        if($rez == TRUE):
                            $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешно сте додали агента!</div>";
                        else:
                            $data['obavestenje'] = "<div class='alert alert-danger ispis'>Додавање агента није успело!</div>";
                        endif;
                    else:
                        $uneti_podaci['ime_agenta'] = $ime_agenta;
                        $uneti_podaci['prezime_agenta'] = $prezime_agenta;
                        $uneti_podaci['telefon_agenta'] = $telefon_agenta;
                        //$uneti_podaci['mail_agenta'] = $mail_agenta;
                        $data['obavestenje'] = "<div class='alert alert-danger ispis'>Погрешан унос података!</div>";
                    endif;
                endif;
            endif;
        endif;
        $data['forma_podaci'] = array(
            'class' => 'form',
            'accept-charset' => 'utf-8',
            'method' => 'POST'
        );

        $data['form_ime_agenta'] = array(
            'class' =>'size',
            'name' => 'tbIme',
            'id' =>'tbIme',
            'placeholder' =>'Милан',
            'value'=>isset($uneti_podaci['ime_agenta']) ? $uneti_podaci['ime_agenta'] : '', 
            'required' => TRUE
        );
        $data['form_prezime_agenta'] = array(
            'class' => 'size',
            'name' => 'tbPrezime',
            'id' => 'tbPrezime',
            'placeholder' =>'Милић',
            'value'=>isset($uneti_podaci['prezime_agenta']) ? $uneti_podaci['prezime_agenta'] : '', 
            'required'=> TRUE
        );
        $data['form_telefon_agenta'] = array(
            'class' => 'size',
            'name' => 'tbTelefon',
            'id' => 'tbTelefon',
            'placeholder' =>'+381631234567',
            'value'=>isset($uneti_podaci['telefon_agenta']) ? $uneti_podaci['telefon_agenta'] : '', 
            'required'=> TRUE
        );
//        $data['form_mail_agenta'] = array(
//            'name' => 'tbMail',
//            'class' => 'size',
//            'id' => 'tbMail',
//            'value'=>isset($uneti_podaci['mail_agenta']) ? $uneti_podaci['mail_agenta'] : '', 
//            'required'=> TRUE
//        );
        $data['form_slika_agenta'] = array(
            'name' => 'fSlika',
            'class' => 'size',
            'id' => 'fSlika',
            'required'=> TRUE
        );
        $data['form_dodaj_submit'] = array(
            'name' => 'btnDodaj',
            'class' => 'right form-control',
            'id' => 'btnDodaj',
            'value' => 'Dodaj'
        );
        
        $this->meni_model->uslov = $uslovMeni;
        $data['meni'] = $this->meni_model->podaci();
        
        $data['podaci_preduzeca'] = $this->podaci_o_firmi_model->podaci();
        
        $data['id_uloge'] = $this->session->userdata('id_uloge');
        
        $data['title'] = 'Агенти';
        $this->load_view('admin/dodajAgenta', $data);
    }
}
