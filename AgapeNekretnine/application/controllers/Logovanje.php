<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of logovanje
 *
 * @author Veljko
 */
class Logovanje extends MY_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('korisnici_model');
    }
    
    public function login()
    {
        $this->load->library('form_validation');
        $is_post=$this->input->server('REQUEST_METHOD') == 'POST';
        
        if($is_post):
        
            $this->form_validation->set_rules('tbKorisnickoImeLog','korisničko ime','required|trim|xss_clean');       
            $this->form_validation->set_rules('tbLozinkaLog','lozinka','required|trim|xss_clean');
            $this->form_validation->set_message('required','Polje za %s je obavezno');
            
            if($this->form_validation->run()==FALSE):
                
                //$data['greska_log'] = "Грешка! Погрешан унос података приликом логовања. Проверите податке.";
                $this->load_view('pocetna', $data);
            
            else:
                
                $korisnicko_ime = trim($this->input->post('tbKorisnickoImeLog'));
                $lozinka = md5(trim($this->input->post('tbLozinkaLog')));
                $uslov = array(
                    'korisnicko_ime' => $korisnicko_ime,
                    'lozinka_korisnika' => $lozinka
                );
                $this->korisnici_model->uslov = $uslov;
                $provera = $this->korisnici_model->podaci();
                if($provera != FALSE):
                    $session_data=array(
                        'id_korisnik' => $provera[0]->id_korisnik,
                        'ime_korisnik' => $provera[0]->ime_korisnika,
                        'prezime_korisnika' => $provera[0]->prezime_korisnika,
                        'korisnicko_ime' => $provera[0]->korisnicko_ime,
                        'telefon_korisnika' => $provera[0]->telefon_korisnika,
                        'email_korisnika' => $provera[0]->email_korisnika,
                        'id_uloge' => $provera[0]->id_uloge
                    );
                    $flash_data=array(
                        'obavestenje' => "Успешно сте се пријавили као: ".$provera[0]->naziv_uloge
                    );
                    $id_uloge=$provera[0]->id_uloge;
                    
                    $this->session->set_flashdata($flash_data);
                    
                    $this->session->set_userdata($session_data);
                    
                    if($this->session->userdata('id_uloge') == 1):
                        redirect('admin/AdminNekretnine');
                    elseif($this->session->userdata('id_uloge') == 2):
                        redirect('admin/AdminNekretnine');
                    else:
                        redirect(base_url());
                    endif;
                else:
                    $flash_data=array(
                        'obavestenje' => "Грешка! Погрешан унос података приликом логовања. Проверите податке."
                    );
                    $this->session->set_flashdata($flash_data);
                    redirect(base_url());
                endif;
            endif;
               
        endif;
    }
    public function logout(){
        $this->session->sess_destroy();
        redirect(base_url());
    }
}
