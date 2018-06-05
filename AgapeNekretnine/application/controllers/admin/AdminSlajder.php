<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adminSlajder
 *
 * @author Veljko
 */
class AdminSlajder extends MY_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('meni_model');
        $this->load->model('podaci_o_firmi_model');
        $this->load->model('slajder_pocetna_model');
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
        
        $rezSlajder = $this->slajder_pocetna_model->podaci();
        
        $data['slajder'] = $rezSlajder;
        
        $this->load->library('table'); 
        $this->table->set_template(array('table_open'=>'<table class="table center-block center-block2" border="1">')); 
        $this->table->set_heading('Наслов', 'Опис', 'Слика', 'Измени / Обриши');

        foreach ($rezSlajder as $s):
            $linkIzmeni = anchor('admin/AdminSlajder/izmeni/'.$s->id_slajder, 'Измени');
            $linkObrisi = anchor('admin/AdminSlajder/obrisi/'.$s->id_slajder, 'Обриши', array('class' => 'obrisiSlajder','data-id' => $s->id_slajder));
            $slika_slajder = array(
                'src' => $s->putanja_slike_slajder,
                'alt' => $s->naslov_slajder,
                'class' =>'img-responsive',
                'style' => 'margin: 0px auto; width: 300px;'
            ); 
            $this->table->add_row($s->naslov_slajder, $s->opis_slajder, img($slika_slajder), $linkIzmeni." / ".$linkObrisi);
        endforeach;
                
        $data['tabela'] = $this->table->generate(); 
        
        $data['title'] = 'Слајдер';
        $this->load_view('admin/slajderUid', $data);
    }
    public function izmeni($id = null){
        if(empty($this->session->userdata('id_uloge'))):
            redirect('pocetna');
        endif;
        $data['title'] = 'Слајдер';
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

            $this->slajder_pocetna_model->id_slajder = $id;
            $rezSlajder = $this->slajder_pocetna_model->podaci();
            $data['slajder'] =$rezSlajder;
            
            $uneti_podaci['naslov_slajder'] = $rezSlajder[0]->naslov_slajder;
            $uneti_podaci['opis_slajder'] = $rezSlajder[0]->opis_slajder;
            
            $data['forma_podaci'] = array(
            'class' => 'form',
            'accept-charset' => 'utf-8',
            'method' => 'POST'
            );

            $data['form_naslov_slajder'] = array(
                'class' =>'size',
                'name' => 'tbNaslov',
                'id' =>'tbNaslov',
                'value'=>isset($uneti_podaci['naslov_slajder']) ? $uneti_podaci['naslov_slajder'] : '', 
                'placeholder' =>'Наслов',
                'required' => TRUE
            );
            $data['form_opis_slajder'] = array(
                'class' => 'size',
                'name' => 'tbOpis',
                'id' => 'tbOpis',
                'placeholder' =>'Опис неки',
                'value'=>isset($uneti_podaci['opis_slajder']) ? $uneti_podaci['opis_slajder'] : '', 
                'required'=> TRUE
            );
            $data['form_slika_slajder'] = array(
                'name' => 'fSlika',
                'class' => 'size',
                'id' => 'fSlika',
                'required'=> TRUE
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
                    
                    $config['upload_path'] = 'images/slajder/';
                    $config['allowed_types'] = 'gif|jpg|png|JPG';
                    $config['max_size']	= '6000';
                    
                    $naslov_slajder = trim($this->input->post('tbNaslov'));
                    $opis_slajder = trim($this->input->post('tbOpis'));
                    
                    $this->load->library('form_validation');
                    
                    $this->form_validation->set_rules('tbNaslov','наслов слајдера','trim|required|xss_clean');
                    $this->form_validation->set_rules('tbOpis','опис слајдера','trim|required|xss_clean');

                    $this->form_validation->set_message('required','Поље %s је празно.');

                    if($this->form_validation->run()):

                        $this->slajder_pocetna_model->naslov_slajder = $naslov_slajder;
                        $this->slajder_pocetna_model->opis_slajder = $opis_slajder;
                        
                        $this->load->library('upload', $config);
                        if ( ! $this->upload->do_upload('fSlika')):
                            $error = array('error' => $this->upload->display_errors());
                            $this->data['obavestenje'] = $error;
                        else:
                            $data2 = array('upload_data' => $this->upload->data());
                            $this->slajder_pocetna_model->putanja_slike_slajder = 'images/slajder/'.$data2['upload_data']['file_name'];
                        endif;
                        $uslovSlajder = array(
                            'id_slajder' => $id
                        );
                        $this->slajder_pocetna_model->uslov = $uslovSlajder;

                        $rez = $this->slajder_pocetna_model->izmeni();
                        
                        if($rez == TRUE):
                            $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешно сте изменили слику у слајдеру!</div>";
                            $uneti_podaci['naslov_slajder'] = $naslov_slajder;
                            $uneti_podaci['opis_slajder'] = $opis_slajder;
                            
                            $data['forma_podaci'] = array(
                                'class' => 'form',
                                'accept-charset' => 'utf-8',
                                'method' => 'POST'
                            );

                            $data['form_naslov_slajder'] = array(
                                'class' =>'size',
                                'name' => 'tbNaslov',
                                'id' =>'tbNaslov',
                                'placeholder' =>'Наслов',
                                'value'=>isset($uneti_podaci['naslov_slajder']) ? $uneti_podaci['naslov_slajder'] : '', 
                                'required' => TRUE
                            );
                            $data['form_opis_slajder'] = array(
                                'class' => 'size',
                                'name' => 'tbOpis',
                                'id' => 'tbOpis',
                                'placeholder' =>'Опис неки',
                                'value'=>isset($uneti_podaci['opis_slajder']) ? $uneti_podaci['opis_slajder'] : '', 
                                'required'=> TRUE
                            );
                            $data['form_slika_slajder'] = array(
                                'name' => 'fSlika',
                                'class' => 'size',
                                'id' => 'fSlika',
                                'required'=> TRUE
                            );
                            $data['form_dodaj_submit'] = array(
                                'name' => 'btnIzmeni',
                                'class' => 'right form-control',
                                'id' => 'btnIzmeni',
                                'value' => 'Измени'
                            );
                            $this->load_view('admin/izmeniSlajder', $data);
                        else:
                            $data['obavestenje'] = "<div class='alert alert-danger ispis'>Измена слике у слајдеру није успела!</div>";
                        endif;
                    else:
                        $uneti_podaci['naslov_slajder'] = $naslov_slajder;
                        $uneti_podaci['opis_slajder'] = $opis_slajder;
                            
                        $data['obavestenje'] = "<div class='alert alert-danger ispis'>Погрешан унос података!</div>";
                    endif;
                endif;
            endif;
            $this->load_view('admin/izmeniSlajder', $data);
        endif;
    }
    public function obrisi($id = null){
        if(empty($this->session->userdata('id_uloge'))):
            redirect('pocetna');
        endif;
        if($id != null):
            $poslato = $this->input->get('poslato');
            if(!empty($poslato)):

                $this->slajder_pocetna_model->id_slajder = $id;
                $this->slajder_pocetna_model->obrisi();
                
                $this->load->model('slajder_pocetna_model', 'slajder');
                $rezSlajder = $this->slajder->podaci();
                $data['slajder'] = $rezSlajder;
                
                $this->load->library('table'); 
                $this->table->set_template(array('table_open'=>'<table class="table center-block center-block2" border="1">')); 
                $this->table->set_heading('Наслов', 'Опис', 'Слика', 'Измени / Обриши');

                if($rezSlajder != null):
                    foreach ($rezSlajder as $s):
                        $linkIzmeni = anchor('admin/AdminSlajder/izmeni/'.$s->id_slajder, 'Измени');
                        $linkObrisi = anchor('admin/AdminSlajder/obrisi/'.$s->id_slajder, 'Обриши', array('class' => 'obrisiSlajder','data-id' => $s->id_slajder));
                        $slika_slajder = array(
                            'src' => $s->putanja_slike_slajder,
                            'alt' => $s->naslov_slajder,
                            'class' =>'img-responsive',
                            'style' => 'margin: 0px auto; width: 300px;'
                        ); 
                        $this->table->add_row($s->naslov_slajder, $s->opis_slajder, img($slika_slajder), $linkIzmeni." / ".$linkObrisi);
                    endforeach;
                    
                    $data['title'] = 'Слајдер';
                    
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
        
        
        //$data['korisnici'] = $this->korisniciModel->podaci();
        
        $rez= $this->slajder_pocetna_model->podaci();
        $data['slajder'] = $rez;
        $is_post=$this->input->server('REQUEST_METHOD') == 'POST'; 
        if($is_post):
            $dugme = $this->input->post('btnDodaj');
            if($dugme != ""):
                $naslov_slajder = trim($this->input->post('tbNaslov'));
                $opis_slajder = trim($this->input->post('tbOpis'));
                
                
                $config['upload_path'] = 'images/slajder/';
                $config['allowed_types'] = 'gif|jpg|png|JPG';
                $config['max_size']	= '4000';
                
                $this->load->library('upload', $config);
                $this->load->library('form_validation');
                if (!$this->upload->do_upload('fSlika')):
                    $error = array('error' => $this->upload->display_errors());
                    $this->data['obavestenje'] = $error;
                else:
                    $data = array('upload_data' => $this->upload->data());
                    $this->form_validation->set_rules('tbNaslov','наслов слајдера','trim|required|xss_clean');
                    $this->form_validation->set_rules('tbOpis','опис слајдера','trim|required|xss_clean');

                    $this->form_validation->set_message('required','Поље %s је празно.');

                    if($this->form_validation->run()):

                        $this->slajder_pocetna_model->naslov_slajder = $naslov_slajder;
                        $this->slajder_pocetna_model->opis_slajder = $opis_slajder;
                        $this->slajder_pocetna_model->putanja_slike_slajder = 'images/slajder/'.$data['upload_data']['file_name'];

                        $rez = $this->slajder_pocetna_model->unesi();
                        if($rez == TRUE):
                            $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешно сте додали слику у слајдер!</div>";
                        else:
                            $data['obavestenje'] = "<div class='alert alert-danger ispis'>Додавање слике у слајдер није успело!</div>";
                        endif;
                    else:
                        $uneti_podaci['naslov_slajder'] = $naziv_saradnika;
                        $uneti_podaci['opis_slajder'] = $opis_saradnika;
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

        $data['form_naslov_slajder'] = array(
            'class' =>'size',
            'name' => 'tbNaslov',
            'id' =>'tbNaslov',
            'placeholder' =>'Наслов',
            'value'=>isset($uneti_podaci['naslov_slajder']) ? $uneti_podaci['naslov_slajder'] : '', 
            'required' => TRUE
        );
        $data['form_opis_slajder'] = array(
            'class' => 'size',
            'name' => 'tbOpis',
            'id' => 'tbOpis',
            'placeholder' =>'Опис неки',
            'value'=>isset($uneti_podaci['opis_slajder']) ? $uneti_podaci['opis_slajder'] : '', 
            'required'=> TRUE
        );
        $data['form_slika_slajder'] = array(
            'name' => 'fSlika',
            'class' => 'size',
            'id' => 'fSlika',
            'required'=> TRUE
        );
        $data['form_dodaj_submit'] = array(
            'name' => 'btnDodaj',
            'class' => 'right form-control',
            'id' => 'btnDodaj',
            'value' => 'Додај'
        );
        $this->meni_model->uslov = $uslovMeni;
        $data['meni'] = $this->meni_model->podaci();
        
        $data['id_uloge'] = $this->session->userdata('id_uloge');
        
        $data['podaci_preduzeca'] = $this->podaci_o_firmi_model->podaci();
        $data['title'] = 'Слајдер';
        $this->load_view('admin/dodajSlajder', $data);
    }
    
}
