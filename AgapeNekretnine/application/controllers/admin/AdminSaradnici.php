<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adminSaradnici
 *
 * @author Veljko
 */
class AdminSaradnici extends MY_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('meni_model');
        $this->load->model('podaci_o_firmi_model');
        $this->load->model('saradnici_model');
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
        
        $rezSaradnici = $this->saradnici_model->podaci();
        
        $data['saradnici'] = $rezSaradnici;
        
        $this->load->library('table'); 
        $this->table->set_template(array('table_open'=>'<table class="table center-block center-block2" border="1">'));
        $this->table->set_heading('Назив сарадника', 'Лого сарадника', 'Опис сарадника', 'Web страна сарадника', 'Измени / Обриши');
        if($rezSaradnici != null):
            foreach ($rezSaradnici as $s):
                $linkIzmeni = anchor('admin/AdminSaradnici/izmeni/'.$s->id_saradnika, 'Измени');
                $linkObrisi = anchor('admin/AdminSaradnici/obrisi/'.$s->id_saradnika, 'Обриши', array('class' => 'obrisiSaradnika','data-id' => $s->id_saradnika));
                $slika_saradnika = array(
                    'src' => $s->logo_saradnika,
                    'alt' => $s->naziv_saradnika,
                    'class' =>'img-responsive',
                    'style' => 'margin: 0px auto;width: 300px;'
                ); 
                $this->table->add_row($s->naziv_saradnika, img($slika_saradnika), $s->opis_saradnika, $s->link_saradnika, $linkIzmeni." / ".$linkObrisi);
            endforeach;
            $data['tabela'] = $this->table->generate(); 
            $data['title'] = 'Сарадници';
        else:
            $data['obavestenje'] = 'Грешка';
        endif;
        
        $this->load_view('admin/saradniciUid', $data);
    }

    public function izmeni($id = null){
        if(empty($this->session->userdata('id_uloge'))):
            redirect('pocetna');
        endif;
        $data['title'] = 'Сарадници';
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

            $this->saradnici_model->id_saradnika = $id;
            $rezSaradnici = $this->saradnici_model->podaci();
            $data['saradnici'] = $rezSaradnici;

            $uneti_podaci['naziv_saradnika'] = $rezSaradnici[0]->naziv_saradnika;
            $uneti_podaci['opis_saradnika'] = $rezSaradnici[0]->opis_saradnika;
            $uneti_podaci['link_saradnika'] = $rezSaradnici[0]->link_saradnika;
            
            $data['forma_saradnici'] = array(
                'class' => 'form',
                'accept-charset' => 'utf-8',
                'method' => 'POST'
            );

            $data['form_naziv_saradnika'] = array(
                'class' =>'size',
                'name' => 'tbNaziv',
                'value'=>isset($uneti_podaci['naziv_saradnika']) ? $uneti_podaci['naziv_saradnika'] : '',
                'id' =>'tbNaziv',
                'placeholder' =>'Назив сарадника',
                'required'
            );
            $data['form_opis_saradnika'] = array(
                'class' => 'size',
                'name' => 'tbOpis',
                'id' => 'tbOpis',
                'placeholder' =>'Опис сатадника',
                'required',
                'value'=>isset($uneti_podaci['opis_saradnika']) ? $uneti_podaci['opis_saradnika'] : '',
            );
            $data['form_nova_slika_saradnika'] = array(
                'name' => 'fSlika',
                'id' =>'fSlika'
            );
            $data['form_web_sajt'] = array(
                'class' => 'size',
                'name' => 'tbLink',
                'id' => 'tbLink',
                'placeholder' => 'www.nesto.com',
                'required',
                'value'=>isset($uneti_podaci['link_saradnika']) ? $uneti_podaci['link_saradnika'] : '',
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
                    
                    $config['upload_path'] = 'images/saradnici/';
                    $config['allowed_types'] = 'gif|jpg|png|JPG';
                    $config['max_size']	= '2000';
                    $config['max_width']  = '400';
                    $config['max_height']  = '200';
                    
                    $naziv_saradnika = $this->input->post('tbNaziv');
                    $opis_saradnika = $this->input->post('tbOpis');
                    $link_saradnika = $this->input->post('tbLink');

                    $this->load->library('form_validation');
                    
                    $this->form_validation->set_rules('tbNaziv','назив сарадника','trim|required|xss_clean');
                    $this->form_validation->set_rules('tbOpis','опис сарадника','trim|required|xss_clean');
                    $this->form_validation->set_rules('fSlika','слика сарадника','trim|xss_clean');
                    $this->form_validation->set_rules('tbLink','web сајт сарадника','trim|required|xss_clean');

                    $this->form_validation->set_message('required','Поље %s је празно.');

                    if($this->form_validation->run()):

                        $this->saradnici_model->naziv_saradnika = $naziv_saradnika;
                        $this->saradnici_model->opis_saradnika = $opis_saradnika;
                        $this->saradnici_model->link_saradnika = $link_saradnika;
                    
                        $this->load->library('upload', $config);
                        if ( ! $this->upload->do_upload('fSlika')):
                            $error = array('error' => $this->upload->display_errors());
                            $this->data['obavestenje'] = $error;
                        else:
                            $data2 = array('upload_data' => $this->upload->data());
                            $this->saradnici_model->logo_saradnika = 'images/saradnici/'.$data2['upload_data']['file_name'];
                        endif;
                        $uslovSaradnici = array(
                            'id_saradnik' => $id
                        );
                        $this->saradnici_model->uslov = $uslovSaradnici;

                        $rez = $this->saradnici_model->izmeni();
                    
                        if($rez == TRUE):
                            $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешно сте изменили сарадника!</div>";
                            $uneti_podaci['naziv_saradnika'] = $naziv_saradnika;
                            $uneti_podaci['opis_saradnika'] = $opis_saradnika;
                            $uneti_podaci['link_saradnika'] = $link_saradnika;
                            
                            $data['forma_saradnici'] = array(
                                'class' => 'form',
                                'accept-charset' => 'utf-8',
                                'method' => 'POST'
                            );

                            $data['form_naziv_saradnika'] = array(
                                'class' =>'size',
                                'name' => 'tbNaziv',
                                'value'=>isset($uneti_podaci['naziv_saradnika']) ? $uneti_podaci['naziv_saradnika'] : '',
                                'id' =>'tbNaziv',
                                'placeholder' =>'Назив сарадника',
                                'required'
                            );
                            $data['form_opis_saradnika'] = array(
                                'class' => 'size',
                                'name' => 'tbOpis',
                                'id' => 'tbOpis',
                                'placeholder' =>'Опис сарадника',
                                'required',
                                'value'=>isset($uneti_podaci['opis_saradnika']) ? $uneti_podaci['opis_saradnika'] : '',
                            );
                            $data['form_nova_slika_saradnika'] = array(
                                'name' => 'fSlika',
                                'id' =>'fSlika'
                            );
                            $data['form_web_sajt'] = array(
                                'class' => 'size',
                                'name' => 'tbLink',
                                'id' => 'tbLink',
                                'placeholder' =>'www.nesto.com',
                                'required',
                                'value'=>isset($uneti_podaci['link_saradnika']) ? $uneti_podaci['link_saradnika'] : '',
                            );
                            $data['form_izmeni_submit'] = array(
                                'name' => 'btnIzmeni',
                                'class' => 'right form-control',
                                'id' => 'btnIzmeni',
                                'value' => 'Измени'
                            );
                            $this->load_view('admin/izmeniSaradnika', $data);
                        else:
                            $data['obavestenje'] = "<div class='alert alert-danger ispis'Измена сарадника није успела!</div>";
                        endif;
                    else:
                        $uneti_podaci['naziv_saradnika'] = $naziv_saradnika;
                        $uneti_podaci['opis_saradnika'] = $opis_saradnika;
                        $uneti_podaci['link_saradnika'] = $link_saradnika;
                            
                        $data['obavestenje'] = "<div class='alert alert-danger ispis'>Погрешан унос података!</div>";
                    endif;
                endif;
            endif;
            $this->load_view('admin/izmeniSaradnika', $data);
        endif;
    }
    public function obrisi($id = null){
        if(empty($this->session->userdata('id_uloge'))):
            redirect('pocetna');
        endif;
        if($id != null):
            $poslato = $this->input->get('poslato');
            if(!empty($poslato)):

                $this->saradnici_model->id_saradnika = $id;
                $this->saradnici_model->obrisi();
                
                $this->load->model('saradnici_model', 'saradnici');
                $rezSaradnici = $this->saradnici->podaci();
                $data['saradnici'] = $rezSaradnici;
                
                $this->load->library('table'); //ucitavanje bibiliote table
                $this->table->set_template(array('table_open'=>'<table class="table center-block center-block2" border="1">'));
                 $this->table->set_heading('Назив сарадника', 'Лого сарадника', 'Опис сарадника', 'Web страна сарадника', 'Измени / Обриши');
                if($rezSaradnici != null):
                foreach ($rezSaradnici as $s):
                    $linkIzmeni = anchor('admin/AdminSaradnici/izmeni/'.$s->id_saradnika, 'Измени');
                    $linkObrisi = anchor('admin/AdminSaradnici/obrisi/'.$s->id_saradnika, 'Обриши', array('class' => 'obrisiSaradnika','data-id' => $s->id_saradnika));
                    $slika_saradnika = array(
                    'src' => $s->logo_saradnika,
                    'alt' => $s->naziv_saradnika,
                    'class' =>'img-responsive',
                    'style' => 'margin: 0px auto;width: 300px;'
                ); 
                $this->table->add_row($s->naziv_saradnika, img($slika_saradnika), $s->opis_saradnika, $s->link_saradnika, $linkIzmeni." / ".$linkObrisi);
                endforeach;
                
                $data['title'] = 'Сарадници';
        
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
        
        $rez= $this->saradnici_model->podaci();
        $data['saradnici'] = $rez;
        $is_post=$this->input->server('REQUEST_METHOD') == 'POST'; 
        if($is_post):
            $dugme = $this->input->post('btnDodaj');
            if($dugme != ""):
                $naziv_saradnika = trim($this->input->post('tbNaziv'));
                $opis_saradnika = trim($this->input->post('tbOpis'));
                $link_saradnika = trim($this->input->post('tbLink'));
                
                
                $config['upload_path'] = 'images/saradnici/';
                $config['allowed_types'] = 'gif|jpg|png|JPG';
                $config['max_size']	= '2000';
                $config['max_width']  = '400';
                $config['max_height']  = '200';
                
                $this->load->library('upload', $config);
                $this->load->library('form_validation');
                if (!$this->upload->do_upload('fSlika')):
                    $error = array('error' => $this->upload->display_errors());
                    $this->data['obavestenje'] = $error;
                else:
                    $data = array('upload_data' => $this->upload->data());
                    $this->form_validation->set_rules('tbNaziv','наѕив сарадника ','trim|required|xss_clean');
                    $this->form_validation->set_rules('tbOpis','опис сарадника','trim|required|xss_clean');
                    $this->form_validation->set_rules('tbLink','web сајт сарадника','trim|required|xss_clean');

                    $this->form_validation->set_message('required','Поље %s је празно.');

                    if($this->form_validation->run()):

                        $this->saradnici_model->naziv_saradnika = $naziv_saradnika;
                        $this->saradnici_model->opis_saradnika = $opis_saradnika;
                        $this->saradnici_model->link_saradnika = $link_saradnika;
                        $this->saradnici_model->logo_saradnika = 'images/saradnici/'.$data['upload_data']['file_name'];

                        $rez = $this->saradnici_model->unesi();
                        if($rez == TRUE):
                            $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешно сте додали сарадника!</div>";
                        else:
                            $data['obavestenje'] = "<div class='alert alert-danger ispis'>Додавање сарадника није успело!</div>";
                        endif;
                    else:
                        $uneti_podaci['naziv_saradnika'] = $naziv_saradnika;
                        $uneti_podaci['opis_saradnika'] = $opis_saradnika;
                        $uneti_podaci['link_saradnika'] = $link_saradnika;
                        $data['obavestenje'] = "<div class='alert alert-danger ispis'>Погрешан унос податак!</div>";
                    endif;
                endif;
            endif;
        endif;
        $data['forma_podaci'] = array(
            'class' => 'form',
            'accept-charset' => 'utf-8',
            'method' => 'POST'
        );

        $data['form_naziv_saradnika'] = array(
            'class' =>'size',
            'name' => 'tbNaziv',
            'id' =>'tbNaziv',
            'value'=>isset($uneti_podaci['naziv_saradnika']) ? $uneti_podaci['naziv_saradnika'] : '', 
            'placeholder' =>'Назив сарадника',
            'required' => TRUE
        );
        $data['form_opis_saradnika'] = array(
            'class' => 'size',
            'name' => 'tbOpis',
            'id' => 'tbOpis',
            'value'=>isset($uneti_podaci['opis_saradnika']) ? $uneti_podaci['opis_saradnika'] : '', 
            'placeholder' =>'Опис сарадника',
            'required'=> TRUE
        );
        $data['form_link_saradnika'] = array(
            'class' => 'size',
            'name' => 'tbLink',
            'id' => 'tbLink',
            'value'=>isset($uneti_podaci['link_saradnika']) ? $uneti_podaci['link_saradnika'] : '', 
            'placeholder' =>'www.nesto.com',
            'required'=> TRUE
        );
        $data['form_slika_saradnika'] = array(
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
        
        $data['id_uloge'] = $this->session->userdata('id_uloge');
        
        $data['podaci_preduzeca'] = $this->podaci_o_firmi_model->podaci();
        $data['title'] = 'Сарадници';
        $this->load_view('admin/dodajSaradnika', $data);
    }
}
