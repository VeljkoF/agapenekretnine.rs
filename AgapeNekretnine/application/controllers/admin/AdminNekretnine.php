<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adminNekretnine
 *
 * @author Veljko
 */
class AdminNekretnine extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('meni_model');
        $this->load->model('podaci_o_firmi_model');
        $this->load->model('tip_nekretnine_model');
        $this->load->model('nekretnine_model');
        $this->load->model('agenti_model');
        $this->load->model('slika_nekretnine_model');
        $this->load->model('deo_grada_model');
        $this->load->model('kategorija_model');
        $this->load->model('grad_model');
    }

    public function index() {
        if (empty($this->session->userdata('id_uloge'))):
            redirect('pocetna');
        endif;
        $data['id_uloge'] = $this->session->userdata('id_uloge');

        if ($data['id_uloge'] == 1):

            $uslovMeni = array(
                'admin' => '1'
            );

        elseif ($data['id_uloge'] == 2):

            $uslovMeni = array(
                'korisnik' => '1'
            );

        else:

            $uslovMeni = array(
                'posetilac' => '1'
            );

        endif;

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
        $optionsTip = array(0 => 'Изабери тип некретнине...');
        foreach ($optionsTipSelect as $s):
            $optionsTip += array($s->id_tip_nekretnina => $s->naziv_tip_nekretnina);
        endforeach;

        $data['ddlTip'] = form_dropdown('ddlTip', $optionsTip);

        $optionsKategorijaSelect = $this->kategorija_model->podaci();
        $optionsKategorija = array(0 => 'Изабери категорију...');
        foreach ($optionsKategorijaSelect as $s):
            $optionsKategorija += array($s->id_kategorije => $s->naziv_kategorije);
        endforeach;

        $data['ddlKategorija'] = form_dropdown('ddlKategorija', $optionsKategorija);

        $optionsGradSelect = $this->deo_grada_model->podaci();
        $optionsGrad = array(0 => 'Изабери место...');
        foreach ($optionsGradSelect as $s):
            $optionsGrad += array($s->id_deo_grada => $s->naziv_deo_grada . ", " . $s->naziv_grada);
        endforeach;

        $data['ddlGrad'] = form_dropdown('ddlGrad', $optionsGrad);

        $is_post = $this->input->server('REQUEST_METHOD') == 'POST';
        if ($is_post):
            $dugme = $this->input->post('btnFilter');
            if ($data != ""):

                $tip_nekretnina = $this->input->post('ddlTip');
                $kategorija_nekretnina = $this->input->post('ddlKategorija');
                $lokacija_nekretnina = trim($this->input->post('ddlGrad'));

                $uslovNekretnine = array(
                    'front_slika' => '1'
                );

                if (!empty($tip_nekretnina)):
                    $uslovNekretnine['nekretnine.id_tip_nekretnina'] = $tip_nekretnina;
                endif;
                if (!empty($kategorija_nekretnina)):
                    $uslovNekretnine['nekretnine.id_kategorije'] = $kategorija_nekretnina;
                endif;
                if (!empty($lokacija_nekretnina)):
                    $uslovNekretnine['deo_grada_nekretnina'] = $lokacija_nekretnina;
                endif;

                $order_byNekretnine = "cena_nekretnina ASC";

                $this->nekretnine_model->uslov = $uslovNekretnine;

                $this->nekretnine_model->order_by = $order_byNekretnine;
                $data['nekretnine'] = $this->nekretnine_model->podaci();

//                    $data['kategorija'] = $this->kategorija_model->podaci();
//                    $data['grad'] = $this->grad_model->podaci();
//                    $data['deo_grada'] = $this->deo_grada_model->podaci();

                $optionsTipSelect = $this->tip_nekretnine_model->podaci();
                $optionsTip = array(0 => 'Изабери тип некретнине...');
                foreach ($optionsTipSelect as $s):
                    $optionsTip += array($s->id_tip_nekretnina => $s->naziv_tip_nekretnina);
                endforeach;

                @$selectedTip = $tip_nekretnina;

                $data['ddlTip'] = form_dropdown('ddlTip', $optionsTip, $selectedTip);

                $optionsKategorijaSelect = $this->kategorija_model->podaci();
                $optionsKategorija = array(0 => 'Изабери категорију...');
                foreach ($optionsKategorijaSelect as $s):
                    $optionsKategorija += array($s->id_kategorije => $s->naziv_kategorije);
                endforeach;

                @$selectedKategorija = $kategorija_nekretnina;

                $data['ddlKategorija'] = form_dropdown('ddlKategorija', $optionsKategorija, $selectedKategorija);

                $optionsGradSelect = $this->deo_grada_model->podaci();
                $optionsGrad = array(0 => 'Изабери место...');
                foreach ($optionsGradSelect as $s):
                    $optionsGrad += array($s->id_deo_grada => $s->naziv_deo_grada . ", " . $s->naziv_grada);
                endforeach;

                @$selectedGrad = $lokacija_nekretnina;

                $data['ddlGrad'] = form_dropdown('ddlGrad', $optionsGrad, $selectedGrad);
            endif;
        endif;

        $data['title'] = 'Nekretnine';
        $this->load_view('admin/nekretnineUid', $data);
    }

    public function obrisi($id = null) {
        if (empty($this->session->userdata('id_uloge'))):
            redirect('pocetna');
        endif;
        if ($id != null):

            $this->slika_nekretnine_model->id_nekretnina = $id;
            $podaciSlike = $this->slika_nekretnine_model->podaci();
            foreach ($podaciSlike as $p):
                if ($p->putanja_slika_nekretnina != "images/nekretnineNovo/podrazumevano/1.png"):
                    unlink($p->putanja_slika_nekretnina);
                endif;
            endforeach;


            $this->nekretnine_model->id_nekretnina = $id;
            $this->nekretnine_model->obrisi();
            //$uslovSlikaObrisi = array(
            //    'id_nekretnina' => $id
            //);
            //$this->slika_nekretnine_model->uslov = $uslovSlikaObrisi;

            $this->slika_nekretnine_model->obrisi();

            redirect('admin/AdminNekretnine');
        endif;
    }

    public function izmeni($id = null) {
        if (empty($this->session->userdata('id_uloge'))):
            redirect('pocetna');
        endif;

        $data['id_uloge'] = $this->session->userdata('id_uloge');
        if ($data['id_uloge'] == 1):
            $uslovMeni = array(
                'admin' => '1'
            );
        elseif ($data['id_uloge'] == 2):
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

        $data['tip_nekretnine'] = $this->tip_nekretnine_model->podaci();

        if ($id != null):

            $uslovNekretnine = array(
                'nekretnine.id_nekretnina' => $id
            );
            $this->nekretnine_model->uslov = $uslovNekretnine;
            $nekretnine = $this->nekretnine_model->podaci();
            $data['tip_nekretnine'] = $this->tip_nekretnine_model->podaci();
            $data['nekretnine'] = $nekretnine;
            $data['top'] = $nekretnine[0]->top_ponuda;
            $this->slika_nekretnine_model->id_nekretnina = $id;
            $rezSlikeNekretnine = $this->slika_nekretnine_model->podaci();
            $data['slike_nekretnine'] = $rezSlikeNekretnine;

            $data['forma_nekretnine'] = array(
                'class' => 'form',
                'accept-charset' => 'utf-8',
                'method' => 'POST'
            );

            $optionsTipSelect = $this->tip_nekretnine_model->podaci();
            $optionsTip = array(0 => 'Изабери...');
            foreach ($optionsTipSelect as $s):
                $optionsTip += array($s->id_tip_nekretnina => $s->naziv_tip_nekretnina);
            endforeach;

            @$selectedTip = $nekretnine[0]->id_tip_nekretnina;

            $data['ddlTip'] = form_dropdown('ddlTip', $optionsTip, $selectedTip);

            $optionsKategorijaSelect = $this->kategorija_model->podaci();
            $optionsKategorija = array(0 => 'Изабери...');
            foreach ($optionsKategorijaSelect as $s):
                $optionsKategorija += array($s->id_kategorije => $s->naziv_kategorije);
            endforeach;

            @$selectedKategorija = $nekretnine[0]->id_kategorije;

            $data['ddlKategorija'] = form_dropdown('ddlKategorija', $optionsKategorija, $selectedKategorija);

            $optionsGradSelect = $this->deo_grada_model->podaci();
            $optionsGrad = array(0 => 'Изабери...');
            foreach ($optionsGradSelect as $s):
                $optionsGrad += array($s->id_deo_grada => $s->naziv_deo_grada . ", " . $s->naziv_grada);
            endforeach;

            @$selectedGrad = $nekretnine[0]->deo_grada_nekretnina;

            $data['ddlGrad'] = form_dropdown('ddlGrad', $optionsGrad, $selectedGrad);


            $data['form_nekretnine_ulica'] = array(
                'class' => 'size',
                'name' => 'tbUlica',
                'value' => $nekretnine[0]->ulica_nekretnina,
                'id' => 'tbUlica',
                'placeholder' => 'Милутина Миланковића',
                'required'
            );
            $data['form_nekretnine_opis'] = array(
                'rows' => '4',
                'cols' => '50',
                'class' => 'size',
                'name' => 'tbOpis',
                'placeholder' => 'Неки опис о некретнине',
                'id' => 'tbOpis',
                'required',
                'value' => $nekretnine[0]->opis_nekretnina
            );
            $data['form_nekretnine_spratnost'] = array(
                'class' => 'size',
                'name' => 'tbSpratnost',
                'id' => 'tbSpratnost',
                'value' => $nekretnine[0]->spratnost_nekretnina,
                'placeholder' => '2/5',
                'required' => TRUE
            );
            $data['form_nekretnine_broj_soba'] = array(
                'class' => 'size',
                'name' => 'tbBrSoba',
                'id' => 'tbBrSoba',
                'placeholder' => '0.5 или 2',
                'required',
                'value' => $nekretnine[0]->broj_soba_nekretnina
            );
            $data['form_nekretnine_kvadratura'] = array(
                'class' => 'size',
                'name' => 'tbKvadratura',
                'id' => 'tbKvadratura',
                'placeholder' => 'm2',
                'required',
                'value' => $nekretnine[0]->kvadratura_nekretnina
            );
            $data['form_nekretnine_grejanje'] = array(
                'class' => 'size',
                'name' => 'tbGrejanje',
                'id' => 'tbGrejanje',
                'value' => $nekretnine[0]->grejanje_nekretnina,
                'placeholder' => 'ЦГ, ЕГ, ТА,...',
                'required' => TRUE
            );
            $data['form_nekretnine_cena'] = array(
                'class' => 'size',
                'name' => 'tbCena',
                'id' => 'tbCena',
                'placeholder' => '€',
                'required',
                'value' => $nekretnine[0]->cena_nekretnina
            );
//            $data['form_nekretnine_top_ponuda'] = array(
//                'name' => 'chbTop',
//                'id' => 'chbTop'
//            );
//            if($nekretnine[0]->top_ponuda == 1):
//                $data['form_nekretnine_top_ponuda_checked'] = array(
//                    'checked' => TRUE
//                );
//            else:
//                $data['form_nekretnine_top_ponuda_checked'] = array(
//                    'checked' => FALSE
//                );
//            endif;

            $data['form_nekretnine_radio'] = array(
                'name' => 'slika',
                'id' => 'slika'
            );


            $data['form_nekretnine_radio_checked'] = array(
                'checked' => 'checked'
            );

            $this->load->model('agenti_model', 'agenti');

            $optionsSelecta = $this->agenti->podaci();
            $options = array(0 => 'Изабери...');
            foreach ($optionsSelecta as $s):
                $options += array($s->id_agenta => $s->ime_agenta . " " . $s->prezime_agenta);
            endforeach;

            @$selected = $nekretnine[0]->id_agenta;

            $data['ddlAgenti'] = form_dropdown('ddlAgenti', $options, $selected);

            $data['form_ime_vlasnika'] = array(
                'class' => 'size',
                'name' => 'tbImeVlasnika',
                'id' => 'tbImeVlasnika',
                'value' => $nekretnine[0]->ime_vlasnika,
                'placeholder' => 'Милан',
                'required' => TRUE
            );

            $data['form_prezime_vlasnika'] = array(
                'class' => 'size',
                'name' => 'tbPrezimeVlasnika',
                'id' => 'tbPrezimeVlasnika',
                'value' => $nekretnine[0]->prezime_vlasnika,
                'placeholder' => 'Милић',
                'required' => TRUE
            );

            $data['form_telefon_vlasnika'] = array(
                'class' => 'size',
                'name' => 'tbTelefonVlasnika',
                'id' => 'tbTelefonVlasnika',
                'value' => $nekretnine[0]->telefon_vlasnika,
                'placeholder' => '+381631234567',
                'required' => TRUE
            );



            $is_post = $this->input->server('REQUEST_METHOD') == 'POST';
            if ($is_post):
                $dugme = $this->input->post('btnDodaj');
                if ($data != ""):
                    $tip_nekretnina = $this->input->post('ddlTip');
                    $ulica_nekretnina = trim($this->input->post('tbUlica'));
                    $grad_nekretnina = $this->input->post('ddlGrad');
                    $opis_nekretnina = trim($this->input->post('tbOpis'));
                    $spratnost_nekretnina = trim($this->input->post('tbSpratnost'));
                    $broj_soba_nekretnina = trim($this->input->post('tbBrSoba'));
                    $grejanje_nekretnina = trim($this->input->post('tbGrejanje'));
                    $kvadratura_nekretnina = trim($this->input->post('tbKvadratura'));
                    $cena_nekretnina = trim($this->input->post('tbCena'));
                    $top_ponuda_nekretnine = $this->input->post('chbTop');
                    $glavna_slika = $this->input->post('slika');
                    $agenti = $this->input->post('ddlAgenti');
                    $ime_vlasnika = trim($this->input->post('tbImeVlasnika'));
                    $prezime_vlasnika = trim($this->input->post('tbPrezimeVlasnika'));
                    $telefon_vlasnika = trim($this->input->post('tbTelefonVlasnika'));
                    $kategorija_nekretnina = $this->input->post('ddlKategorija');

                    $this->load->library('form_validation');

                    $this->form_validation->set_rules('ddlTip', 'тип некретиние', 'callback_proveraTip');
                    $this->form_validation->set_rules('tbUlica', 'улица некретиние', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('ddlGrad', 'град некретиние', 'callback_proveraGrad');
                    $this->form_validation->set_rules('tbOpis', 'опис некретиние', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('tbSpratnost', 'спратност некретиние', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('tbBrSoba', 'број соба некретиние', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('tbKvadratura', 'квадратура некретиние', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('tbGrejanje', 'грејање некретиние', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('tbCena', 'цена некретиние', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('chbTop', 'топ некретиние', 'callback_proveraTop');
                    $this->form_validation->set_rules('ddlAgenti', 'агента', 'callback_proveraAgent');
                    $this->form_validation->set_rules('tbImeVlasnika', 'име власник', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('tbPrezimeVlasnika', 'презиме власник', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('tbTelefonVlasnika', 'телефон власник', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('ddlKategorija', 'категорија некретиние', 'callback_proveraKategorija');

                    $this->form_validation->set_message('proveraTip', 'Морате изабрати %s!');
                    $this->form_validation->set_message('proveraGrad', 'Морате изабрати %s!');
                    $this->form_validation->set_message('proveraAgent', 'Морате изабрати %s!');
                    $this->form_validation->set_message('proveraKategorija', 'Морате изабрати %s!');
                    $this->form_validation->set_message('required', 'Поље %s је празно!');

                    if ($this->form_validation->run()):

                        $this->nekretnine_model->ulica_nekretnina = $ulica_nekretnina;
                        $this->nekretnine_model->cena_nekretnina = $cena_nekretnina;
                        $this->nekretnine_model->opis_nekretnina = $opis_nekretnina;
                        $this->nekretnine_model->spratnost_nekretnina = $spratnost_nekretnina;
                        $this->nekretnine_model->grejanje_nekretnina = $grejanje_nekretnina;
                        $this->nekretnine_model->broj_soba_nekretnina = $broj_soba_nekretnina;
                        $this->nekretnine_model->kvadratura_nekretnina = $kvadratura_nekretnina;
                        $this->nekretnine_model->top_ponuda = $top_ponuda_nekretnine;
                        $this->nekretnine_model->id_tip_nekretnina = $tip_nekretnina;
                        $this->nekretnine_model->deo_grada_nekretnina = $grad_nekretnina;
                        $this->nekretnine_model->id_nekretnina = $id;
                        $this->nekretnine_model->id_agenta = $agenti;
                        $this->nekretnine_model->ime_vlasnika = $ime_vlasnika;
                        $this->nekretnine_model->prezime_vlasnika = $prezime_vlasnika;
                        $this->nekretnine_model->telefon_vlasnika = $telefon_vlasnika;
                        $this->nekretnine_model->id_kategorije = $kategorija_nekretnina;

                        $rezIzmenaNekretnine = $this->nekretnine_model->izmeni();

                        $this->load->model('slika_nekretnine_model', 'slikaFront0');
                        $this->slikaFront0->front_slika = 0;
                        $this->slikaFront0->id_nekretnina = $id;

                        $rezIzmenaSlike0 = $this->slikaFront0->izmeni();

                        $this->load->model('slika_nekretnine_model', 'slikaFront1');
                        $this->slikaFront1->id_nekretnina = $id;
                        $this->slikaFront1->id_slika_nekretnina = $glavna_slika;
                        $this->slikaFront1->front_slika = 1;
                        $this->slikaFront1->naziv_slika_nekretnina = $ulica_nekretnina;

                        $rezIzmenaSlike1 = $this->slikaFront1->izmeni();

                        if ($rezIzmenaNekretnine == TRUE && $rezIzmenaSlike0 == TRUE && $rezIzmenaSlike1 == TRUE):
                            $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешно сте изменили!</div>";
                            $uneti_podaci['ulica_nekretnine'] = $ulica_nekretnina;
                            $uneti_podaci['grad_nekretnine'] = $grad_nekretnina;
                            $uneti_podaci['opis_nekretnine'] = $opis_nekretnina;
                            $uneti_podaci['spratnost_nekretnine'] = $spratnost_nekretnina;
                            $uneti_podaci['broj_soba_nekretnine'] = $broj_soba_nekretnina;
                            $uneti_podaci['grejanje_nekretnine'] = $grejanje_nekretnina;
                            $uneti_podaci['kvadratura_nekretnine'] = $kvadratura_nekretnina;
                            $uneti_podaci['cena_nekretnine'] = $cena_nekretnina;
                            $uneti_podaci['tip_nekretnine'] = $tip_nekretnina;
                            $uneti_podaci['top_ponuda_nekretnine'] = $top_ponuda_nekretnine;
                            $uneti_podaci['slika_nekrenineF'] = $glavna_slika;
                            $uneti_podaci['agenti'] = $agenti;
                            $uneti_podaci['ime_vlasnika'] = $ime_vlasnika;
                            $uneti_podaci['prezime_vlasnika'] = $prezime_vlasnika;
                            $uneti_podaci['telefon_vlasnika'] = $telefon_vlasnika;
                            $uneti_podaci['kategorija_nekretnina'] = $kategorija_nekretnina;

//                            $data['uneti_podaci'] = $uneti_podaci;

                            $data['forma_nekretnine'] = array(
                                'class' => 'form',
                                'accept-charset' => 'utf-8',
                                'method' => 'POST'
                            );
                            $optionsTipSelect = $this->tip_nekretnine_model->podaci();
                            $optionsTip = array(0 => 'Изабери...');
                            foreach ($optionsTipSelect as $s):
                                $optionsTip += array($s->id_tip_nekretnina => $s->naziv_tip_nekretnina);
                            endforeach;

                            @$selectedTip = $uneti_podaci['tip_nekretnine'];

                            $data['ddlTip'] = form_dropdown('ddlTip', $optionsTip, $selectedTip);

                            $optionsKategorijaSelect = $this->kategorija_model->podaci();
                            $optionsKategorija = array(0 => 'Изабери...');
                            foreach ($optionsKategorijaSelect as $s):
                                $optionsKategorija += array($s->id_kategorije => $s->naziv_kategorije);
                            endforeach;

                            @$selectedKategorija = $uneti_podaci['kategorija_nekretnina'];

                            $data['ddlKategorija'] = form_dropdown('ddlKategorija', $optionsKategorija, $selectedKategorija);

                            $optionsGradSelect = $this->deo_grada_model->podaci();
                            $optionsGrad = array(0 => 'Изабери...');
                            foreach ($optionsGradSelect as $s):
                                $optionsGrad += array($s->id_deo_grada => $s->naziv_deo_grada . ", " . $s->naziv_grada);
                            endforeach;

                            @$selectedGrad = $uneti_podaci['grad_nekretnine'];

                            $data['ddlGrad'] = form_dropdown('ddlGrad', $optionsGrad, $selectedGrad);
                            $data['form_nekretnine_ulica'] = array(
                                'class' => 'size',
                                'name' => 'tbUlica',
                                'value' => isset($uneti_podaci['ulica_nekretnine']) ? $uneti_podaci['ulica_nekretnine'] : '',
                                'id' => 'tbUlica',
                                'placeholder' => 'Милутина Миланковића',
                                'required'
                            );
                            $data['form_nekretnine_opis'] = array(
                                'rows' => '4',
                                'cols' => '50',
                                'class' => 'size',
                                'name' => 'tbOpis',
                                'placeholder' => 'Неки опис о некретнини',
                                'id' => 'tbOpis',
                                'required',
                                'value' => isset($uneti_podaci['opis_nekretnine']) ? $uneti_podaci['opis_nekretnine'] : '',
                            );
                            $data['form_nekretnine_spratnost'] = array(
                                'class' => 'size',
                                'name' => 'tbSpratnost',
                                'id' => 'tbSpratnost',
                                'value' => isset($uneti_podaci['spratnost_nekretnine']) ? $uneti_podaci['spratnost_nekretnine'] : '',
                                'placeholder' => '2/5',
                                'required' => TRUE
                            );
                            $data['form_nekretnine_broj_soba'] = array(
                                'class' => 'size',
                                'name' => 'tbBrSoba',
                                'id' => 'tbBrSoba',
                                'placeholder' => '0.5 или 2',
                                'required',
                                'value' => isset($uneti_podaci['broj_soba_nekretnine']) ? $uneti_podaci['broj_soba_nekretnine'] : '',
                            );
                            $data['form_nekretnine_grejanje'] = array(
                                'class' => 'size',
                                'name' => 'tbGrejanje',
                                'id' => 'tbGrejanje',
                                'value' => isset($uneti_podaci['grejanje_nekretnine']) ? $uneti_podaci['grejanje_nekretnine'] : '',
                                'placeholder' => 'ЦГ, ЕТ, TA,...',
                                'required' => TRUE
                            );
                            $data['form_nekretnine_kvadratura'] = array(
                                'class' => 'size',
                                'name' => 'tbKvadratura',
                                'id' => 'tbKvadratura',
                                'placeholder' => 'm2',
                                'required',
                                'value' => isset($uneti_podaci['kvadratura_nekretnine']) ? $uneti_podaci['kvadratura_nekretnine'] : '',
                            );
                            $data['form_nekretnine_cena'] = array(
                                'class' => 'size',
                                'name' => 'tbCena',
                                'id' => 'tbCena',
                                'placeholder' => '€',
                                'required',
                                'value' => isset($uneti_podaci['cena_nekretnine']) ? $uneti_podaci['cena_nekretnine'] : '',
                            );
                            $data['form_nekretnine_top_ponuda'] = array(
                                'name' => 'chbTop',
                                'id' => 'chbTop'
                            );
                            $data['top'] = $uneti_podaci['top_ponuda_nekretnine'];
//                            if($uneti_podaci['top_ponuda_nekretnine'] == 1):
//                                $data['form_nekretnine_top_ponuda_checked'] = array(
//                                    'checked' => TRUE
//                                );
//                            else:
//                                $data['form_nekretnine_top_ponuda_checked'] = array(
//                                    'checked' => FALSE
//                                );
//                            endif;
                            $data['form_nekretnine_radio'] = array(
                                'name' => 'slika',
                                'id' => 'slika'
                            );
                            $data['form_nekretnine_radio_checked'] = array(
                                'checked' => 'checked'
                            );

                            $this->load->model('agenti_model', 'agenti');

                            $optionsSelecta = $this->agenti->podaci();
                            $options = array(0 => 'Изабери...');
                            foreach ($optionsSelecta as $s):
                                $options += array($s->id_agenta => $s->ime_agenta . " " . $s->prezime_agenta);
                            endforeach;

                            @$selected = $uneti_podaci['agenti'];

                            $data['ddlAgenti'] = form_dropdown('ddlAgenti', $options, $selected);

                            $data['form_ime_vlasnika'] = array(
                                'class' => 'size',
                                'name' => 'tbImeVlasnika',
                                'id' => 'tbImeVlasnika',
                                'value' => isset($uneti_podaci['ime_vlasnika']) ? $uneti_podaci['ime_vlasnika'] : '',
                                'placeholder' => 'Милан',
                                'required' => TRUE
                            );
                            $data['form_prezima_vlasnika'] = array(
                                'class' => 'size',
                                'name' => 'tbPrezimeVlasnika',
                                'id' => 'tbPrezimeVlasnika',
                                'value' => isset($uneti_podaci['prezime_vlasnika']) ? $uneti_podaci['prezime_vlasnika'] : '',
                                'placeholder' => 'Милић',
                                'required' => TRUE
                            );
                            $data['form_telefon_vlasnika'] = array(
                                'class' => 'size',
                                'name' => 'tbTelefonVlasnika',
                                'id' => 'tbTelefonVlasnika',
                                'value' => isset($uneti_podaci['telefon_vlasnika']) ? $uneti_podaci['telefon_vlasnika'] : '',
                                'placeholder' => '+381631234567',
                                'required' => TRUE
                            );

                        else:

                            $uneti_podaci['ulica_nekretnine'] = $ulica_nekretnina;
                            $uneti_podaci['opstina_nekretnine'] = $opstina_nekretnina;
                            $uneti_podaci['grad_nekretnine'] = $grad_nekretnina;
                            $uneti_podaci['opis_nekretnine'] = $opis_nekretnina;
                            $uneti_podaci['spratnost_nekretnine'] = $spratnost_nekretnina;
                            $uneti_podaci['broj_soba_nekretnine'] = $broj_soba_nekretnina;
                            $uneti_podaci['grejanje_nekretnine'] = $grejanje_nekretnina;
                            $uneti_podaci['kvadratura_nekretnine'] = $kvadratura_nekretnina;
                            $uneti_podaci['cena_nekretnine'] = $cena_nekretnina;
                            $uneti_podaci['tip_nekretnine'] = $tip_nekretnina;
                            $uneti_podaci['top_ponuda_nekretnine'] = $top_ponuda_nekretnine;
                            $uneti_podaci['agenti'] = $agenti;
                            $uneti_podaci['ime_vlasnika'] = $ime_vlasnika;
                            $uneti_podaci['prezime_vlasnika'] = $prezime_vlasnika;
                            $uneti_podaci['telefon_vlasnika'] = $telefon_vlasnika;

                            $data['obavestenje'] = "<div class='alert alert-danger ispis'>Погрешан унос података!</div>";
                            $data['uneti_podaci'] = $uneti_podaci;
                        endif;
                    endif;
                endif;
            endif;
        endif;

        $data['title'] = 'Nekretnine';
        $this->load_view('admin/izmeniNekretnine', $data);
    }

    public function dodaj() {
        if (empty($this->session->userdata('id_uloge'))):
            redirect('pocetna');
        endif;

        $data['id_uloge'] = $this->session->userdata('id_uloge');

        if ($data['id_uloge'] == 1):
            $uslovMeni = array(
                'admin' => '1'
            );
        elseif ($data['id_uloge'] == 2):
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

        $nekretnine = $this->nekretnine_model->podaci();
        $data['tip_nekretnine'] = $this->tip_nekretnine_model->podaci();
        $data['nekretnine'] = $nekretnine;

        $is_post = $this->input->server('REQUEST_METHOD') == 'POST';
        if ($is_post):

            $dugme = $this->input->post('btnDodaj');
            if ($data != ""):
                $tip_nekretnina = $this->input->post('ddlTip');
                $kategorija_nekretnina = $this->input->post('ddlKategorija');
                $ulica_nekretnina = trim($this->input->post('tbUlica'));
                $grad_nekretnina = $this->input->post('ddlGrad');
                $opis_nekretnina = trim($this->input->post('tbOpis'));
                $spratnost_nekretnina = trim($this->input->post('tbSpratnost'));
                $broj_soba_nekretnina = trim($this->input->post('tbBrSoba'));
                $grejanje_nekretnina = trim($this->input->post('tbGrejanje'));
                $kvadratura_nekretnina = trim($this->input->post('tbKvadratura'));
                $cena_nekretnina = trim($this->input->post('tbCena'));
                $top_ponuda_nekretnine = $this->input->post('chbTop');
                $podrazumevana_slika = $this->input->post('chbDefault');
                $agenti = $this->input->post('ddlAgenti');
                $ime_vlasnika = trim($this->input->post('tbImeVlasnika'));
                $prezime_vlasnika = trim($this->input->post('tbPrezimeVlasnika'));
                $telefon_vlasnika = trim($this->input->post('tbTelefonVlasnika'));

                if ($podrazumevana_slika != '1'):

                    $config['upload_path'] = 'images/nekretnineNovo/';
                    $config['allowed_types'] = 'gif|jpg|png|JPG';
                    $config['max_size'] = '4000';
                    $config['max_width'] = '2000';
                    $config['max_height'] = '2000';
//                    
//                    if(!empty($_FILES['fSlikaGlavna'])):
//                        $data['obavestenje'] = "<div class='alert alert-danger ispis'>Додавање некретнине није успело!<br> Нисте унели слику!</div>";
//                    endif;

                    if ($_FILES['fSlikaGlavna']['type'] == 'image/jpeg'):
                        $picName = '.jpg';
                    elseif ($_FILES['fSlikaGlavna']['type'] == 'image/JPEG'):
                        $picName = '.JPG';
                    elseif ($_FILES['fSlikaGlavna']['type'] == 'image/png'):
                        $picName = '.png';
                    elseif ($_FILES['fSlikaGlavna']['type'] == 'image/PNG'):
                        $picName = '.PNG';
                    elseif ($_FILES['fSlikaGlavna']['type'] == 'image/gif'):
                        $picName = '.gif';
                    elseif ($_FILES['fSlikaGlavna']['type'] == 'image/GIF'):
                        $picName = '.GIF';
                    endif;
                    $file_name = time() . @$picName;
                    $config['file_name'] = $file_name;

                    $this->load->library('upload', $config);
                    $this->load->library('form_validation');
                    if (!$this->upload->do_upload('fSlikaGlavna')):
                        $error = array('error' => $this->upload->display_errors());
                        $data['obavestenje'] = "<div class='alert alert-danger ispis'>Додавање некретнине није успело!<br> Проверите унеру слику да ли је одговарајућих димензија!</div>";
                        $uneti_podaci['tip_nekretnine'] = $tip_nekretnina;
                        $uneti_podaci['ulica_nekretnine'] = $ulica_nekretnina;
                        $uneti_podaci['grad_nekretnine'] = $grad_nekretnina;
                        $uneti_podaci['opis_nekretnine'] = $opis_nekretnina;
                        $uneti_podaci['spratnost_nekretnine'] = $spratnost_nekretnina;
                        $uneti_podaci['broj_soba_nekretnine'] = $broj_soba_nekretnina;
                        $uneti_podaci['grejanje_nekretnine'] = $grejanje_nekretnina;
                        $uneti_podaci['kvadratura_nekretnine'] = $kvadratura_nekretnina;
                        $uneti_podaci['cena_nekretnine'] = $cena_nekretnina;
                        $uneti_podaci['agenti'] = $agenti;
                        $uneti_podaci['ime_vlasnika'] = $ime_vlasnika;
                        $uneti_podaci['prezime_vlasnika'] = $prezime_vlasnika;
                        $uneti_podaci['telefon_vlasnika'] = $telefon_vlasnika;
                        $uneti_podaci['kategorija_nekretnina'] = $kategorija_nekretnina;
                    else:
                        $data = array('upload_data' => $this->upload->data());
                        $this->form_validation->set_rules('ddlTip', 'тип некретнине', 'callback_proveraTip');
                        $this->form_validation->set_rules('ddlKategorija', 'категорија некретнине', 'callback_proveraKategorija');
                        $this->form_validation->set_rules('tbUlica', 'улица некретнине', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('ddlGrad', 'град некретнине', 'callback_proveraGrad');
                        $this->form_validation->set_rules('tbOpis', 'опис некретнине', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('tbSpratnost', 'спратност некретнине', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('tbBrSoba', 'број соба некретнине', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('tbKvadratura', 'квадратура некретнине', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('tbGrejanje', 'грејање некретнине', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('tbCena', 'цена некретнине', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('chbTop', 'топ некретнине', 'callback_proveraTop');
                        $this->form_validation->set_rules('ddlAgenti', 'агента', 'callback_proveraAgent');
                        $this->form_validation->set_rules('tbImeVlasnika', 'име власник', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('tbPrezimeVlasnika', 'презиме власник', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('tbTelefonVlasnika', 'телефон власник', 'trim|required|xss_clean');

                        $this->form_validation->set_message('proveraTip', 'Морате изабрати  %s!');
                        $this->form_validation->set_message('proveraGrad', 'Морате изабрати  %s!');
                        $this->form_validation->set_message('proveraKategorija', 'Морате изабрати  %s!');
                        $this->form_validation->set_message('proveraAgent', 'Морате изабрати %s!');
                        $this->form_validation->set_message('required', 'Поље %s је празно!');

                        if ($this->form_validation->run()):

                            //unosenje podataka o nekretnini

                            $this->nekretnine_model->ulica_nekretnina = $ulica_nekretnina;
                            $this->nekretnine_model->cena_nekretnina = $cena_nekretnina;
                            $this->nekretnine_model->opis_nekretnina = $opis_nekretnina;
                            $this->nekretnine_model->spratnost_nekretnina = $spratnost_nekretnina;
                            $this->nekretnine_model->grejanje_nekretnina = $grejanje_nekretnina;
                            $this->nekretnine_model->broj_soba_nekretnina = $broj_soba_nekretnina;
                            $this->nekretnine_model->kvadratura_nekretnina = $kvadratura_nekretnina;
                            $this->nekretnine_model->top_ponuda = $top_ponuda_nekretnine;
                            $this->nekretnine_model->id_tip_nekretnina = $tip_nekretnina;
                            $this->nekretnine_model->deo_grada_nekretnina = $grad_nekretnina;
                            $this->nekretnine_model->id_agenta = $agenti;
                            $this->nekretnine_model->ime_vlasnika = $ime_vlasnika;
                            $this->nekretnine_model->prezime_vlasnika = $prezime_vlasnika;
                            $this->nekretnine_model->telefon_vlasnika = $telefon_vlasnika;
                            $this->nekretnine_model->id_kategorije = $kategorija_nekretnina;

                            $idNekretnine = $this->nekretnine_model->unesi();

                            if ($idNekretnine != ""):
                                $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешно сте додали некретнину!</div>";
                            else:
                                $data['obavestenje'] = "<div class='alert alert-danger ispis'>Додавање некретнине није успело!</div>";
                            endif;

                            $this->slika_nekretnine_model->naziv_slika_nekretnina = $ulica_nekretnina;
                            $this->slika_nekretnine_model->putanja_slika_nekretnina = 'images/nekretnineNovo/' . $file_name;
                            $this->slika_nekretnine_model->id_nekretnina = $idNekretnine;
                            $this->slika_nekretnine_model->front_slika = 1;
                            $this->slika_nekretnine_model->glasova = 0;
                            $this->slika_nekretnine_model->rezultat = 0;

                            $rezGlavne_slike = $this->slika_nekretnine_model->unesi();

                            if ($rezGlavne_slike == true):
                                $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешно сте додали некретнину!</div>";
                            else:
                                $data['obavestenje'] = "<div class='alert alert-danger ispis'>Додаванје главне слике није успело!</div>";
                            endif;

                            if (!empty($_FILES['fSlika']['name'])):
                                $filesCount = count($_FILES['fSlika']['name']);

                                $rezSlike = null;
                                for ($i = 0; $i < $filesCount; $i++):
                                    $config['upload_path'] = 'images/nekretnineNovo/';
                                    $config['allowed_types'] = 'gif|jpg|png|JPG';
                                    $config['max_size'] = '4000';
                                    $config['max_width'] = '2000';
                                    $config['max_height'] = '2000';

                                    $_FILES['f']['type'] = $_FILES['fSlika']['type'][$i];
                                    if ($_FILES['f']['type'] == 'image/jpeg'):
                                        $picName = '.jpg';
                                    elseif ($_FILES['f']['type'] == 'image/JPEG'):
                                        $picName = '.JPG';
                                    elseif ($_FILES['f']['type'] == 'image/png'):
                                        $picName = '.png';
                                    elseif ($_FILES['f']['type'] == 'image/PNG'):
                                        $picName = '.PNG';
                                    elseif ($_FILES['f']['type'] == 'image/gif'):
                                        $picName = '.gif';
                                    elseif ($_FILES['f']['type'] == 'image/GIF'):
                                        $picName = '.GIF';
                                    endif;
                                    $file_name = time() . $i. $picName;

                                    $_FILES['f']['name'] = $file_name;
                                    $name2 = $_FILES['f']['name'];
                                    $config['file_name'] = $name2;
                                    $_FILES['f']['tmp_name'] = $_FILES['fSlika']['tmp_name'][$i];
                                    $_FILES['f']['size'] = $_FILES['fSlika']['size'][$i];
                                    $this->upload->initialize($config);
                                    $this->upload->do_upload('f');

                                    $this->slika_nekretnine_model->naziv_slika_nekretnina = $ulica_nekretnina;
                                    $this->slika_nekretnine_model->putanja_slika_nekretnina = 'images/nekretnineNovo/' . $name2;
                                    $this->slika_nekretnine_model->id_nekretnina = $idNekretnine;
                                    $this->slika_nekretnine_model->front_slika = 0;
                                    $this->slika_nekretnine_model->glasova = 0;
                                    $this->slika_nekretnine_model->rezultat = 0;
                                    $rezSlike = $this->slika_nekretnine_model->unesi();
                                endfor;
                                if ($rezSlike):
                                    $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешно сте додали слику!</div>";
                                else:
                                    $data['obavestenje'] = "<div class='alert alert-danger ispis'>Додавање слике није успело!</div>";
                                endif;
                            endif;
                        else:
                            $uneti_podaci['tip_nekretnine'] = $tip_nekretnina;
                            $uneti_podaci['ulica_nekretnine'] = $ulica_nekretnina;
                            $uneti_podaci['grad_nekretnine'] = $grad_nekretnina;
                            $uneti_podaci['opis_nekretnine'] = $opis_nekretnina;
                            $uneti_podaci['spratnost_nekretnine'] = $spratnost_nekretnina;
                            $uneti_podaci['broj_soba_nekretnine'] = $broj_soba_nekretnina;
                            $uneti_podaci['grejanje_nekretnine'] = $grejanje_nekretnina;
                            $uneti_podaci['kvadratura_nekretnine'] = $kvadratura_nekretnina;
                            $uneti_podaci['cena_nekretnine'] = $cena_nekretnina;
                            $uneti_podaci['agenti'] = $agenti;
                            $uneti_podaci['ime_vlasnika'] = $ime_vlasnika;
                            $uneti_podaci['prezime_vlasnika'] = $prezime_vlasnika;
                            $uneti_podaci['telefon_vlasnika'] = $telefon_vlasnika;
                            $uneti_podaci['kategorija_nekretnina'] = $kategorija_nekretnina;

                            $data['obavestenje'] = "<div class='alert alert-danger ispis'>Проверите да ли сте све податке исправно унели!</div>";
                        endif;
                    endif;
                else:
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('ddlTip', 'тип некретнине', 'callback_proveraTip');
                    $this->form_validation->set_rules('ddlKategorija', 'категорија некретнине', 'callback_proveraKategorija');
                    $this->form_validation->set_rules('tbUlica', 'улица некретнине', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('ddlGrad', 'град некретнине', 'callback_proveraGrad');
                    $this->form_validation->set_rules('tbOpis', 'опис некретнине', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('tbSpratnost', 'спратност некретнине', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('tbBrSoba', 'број соба некретнине', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('tbKvadratura', 'квадратура некретнине', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('tbGrejanje', 'грејање некретнине', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('tbCena', 'цена некретнине', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('chbTop', 'топ некретнине', 'callback_proveraTop');
                    $this->form_validation->set_rules('ddlAgenti', 'агента', 'callback_proveraAgent');
                    $this->form_validation->set_rules('tbImeVlasnika', 'име власник', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('tbPrezimeVlasnika', 'презиме власник', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('tbTelefonVlasnika', 'телефон власник', 'trim|required|xss_clean');

                    $this->form_validation->set_message('proveraTip', 'Морате изабрати  %s!');
                    $this->form_validation->set_message('proveraGrad', 'Морате изабрати  %s!');
                    $this->form_validation->set_message('proveraKategorija', 'Морате изабрати  %s!');
                    $this->form_validation->set_message('proveraAgent', 'Морате изабрати %s!');
                    $this->form_validation->set_message('required', 'Поље %s је празно!');

                    if ($this->form_validation->run()):

                        //unosenje podataka o nekretnini

                        $this->nekretnine_model->ulica_nekretnina = $ulica_nekretnina;
                        $this->nekretnine_model->cena_nekretnina = $cena_nekretnina;
                        $this->nekretnine_model->opis_nekretnina = $opis_nekretnina;
                        $this->nekretnine_model->spratnost_nekretnina = $spratnost_nekretnina;
                        $this->nekretnine_model->grejanje_nekretnina = $grejanje_nekretnina;
                        $this->nekretnine_model->broj_soba_nekretnina = $broj_soba_nekretnina;
                        $this->nekretnine_model->kvadratura_nekretnina = $kvadratura_nekretnina;
                        $this->nekretnine_model->top_ponuda = $top_ponuda_nekretnine;
                        $this->nekretnine_model->id_tip_nekretnina = $tip_nekretnina;
                        $this->nekretnine_model->deo_grada_nekretnina = $grad_nekretnina;
                        $this->nekretnine_model->id_agenta = $agenti;
                        $this->nekretnine_model->ime_vlasnika = $ime_vlasnika;
                        $this->nekretnine_model->prezime_vlasnika = $prezime_vlasnika;
                        $this->nekretnine_model->telefon_vlasnika = $telefon_vlasnika;
                        $this->nekretnine_model->id_kategorije = $kategorija_nekretnina;

                        $idNekretnine = $this->nekretnine_model->unesi();

                        if ($idNekretnine != ""):
                            $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешно сте додали некретнину!</div>";
                        else:
                            $data['obavestenje'] = "<div class='alert alert-danger ispis'>Додавање некретнине није успело!</div>";
                        endif;

                        $this->slika_nekretnine_model->naziv_slika_nekretnina = $ulica_nekretnina;
                        $this->slika_nekretnine_model->putanja_slika_nekretnina = 'images/nekretnineNovo/podrazumevano/1.png';
                        $this->slika_nekretnine_model->id_nekretnina = $idNekretnine;
                        $this->slika_nekretnine_model->front_slika = 1;
                        $this->slika_nekretnine_model->glasova = 0;
                        $this->slika_nekretnine_model->rezultat = 0;

                        $rezGlavne_slike = $this->slika_nekretnine_model->unesi();

                        if ($rezGlavne_slike == true):
                            $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешно сте додали некретнину!</div>";
                        else:
                            $data['obavestenje'] = "<div class='alert alert-danger ispis'>Додавање главне слике није успело!</div>";
                        endif;
                    else:
                        $uneti_podaci['tip_nekretnine'] = $tip_nekretnina;
                        $uneti_podaci['ulica_nekretnine'] = $ulica_nekretnina;
                        $uneti_podaci['grad_nekretnine'] = $grad_nekretnina;
                        $uneti_podaci['opis_nekretnine'] = $opis_nekretnina;
                        $uneti_podaci['spratnost_nekretnine'] = $spratnost_nekretnina;
                        $uneti_podaci['broj_soba_nekretnine'] = $broj_soba_nekretnina;
                        $uneti_podaci['grejanje_nekretnine'] = $grejanje_nekretnina;
                        $uneti_podaci['kvadratura_nekretnine'] = $kvadratura_nekretnina;
                        $uneti_podaci['cena_nekretnine'] = $cena_nekretnina;
                        $uneti_podaci['agenti'] = $agenti;
                        $uneti_podaci['ime_vlasnika'] = $ime_vlasnika;
                        $uneti_podaci['prezime_vlasnika'] = $prezime_vlasnika;
                        $uneti_podaci['telefon_vlasnika'] = $telefon_vlasnika;
                        $uneti_podaci['kategorija_nekretnina'] = $kategorija_nekretnina;

                        $data['obavestenje'] = "<div class='alert alert-danger ispis'>Проверите да ли сте све податке исправно унели!</div>";
                    endif;
                endif;
            endif;
        endif;
        $data['forma_podaci'] = array(
            'class' => 'form',
            'accept-charset' => 'utf-8',
            'method' => 'POST'
        );

        $optionsTipSelect = $this->tip_nekretnine_model->podaci();
        $optionsTip = array(0 => 'Изабери...');
        foreach ($optionsTipSelect as $s):
            $optionsTip += array($s->id_tip_nekretnina => $s->naziv_tip_nekretnina);
        endforeach;

        @$selectedTip = $uneti_podaci['tip_nekretnine'];

        $data['ddlTip'] = form_dropdown('ddlTip', $optionsTip, $selectedTip);

        $optionsKategorijaSelect = $this->kategorija_model->podaci();
        $optionsKategorija = array(0 => 'Изабери...');
        foreach ($optionsKategorijaSelect as $s):
            $optionsKategorija += array($s->id_kategorije => $s->naziv_kategorije);
        endforeach;

        @$selectedKategorija = $uneti_podaci['kategorija_nekretnina'];

        $data['ddlKategorija'] = form_dropdown('ddlKategorija', $optionsKategorija, $selectedKategorija);

        $data['form_ulica_nekretnine'] = array(
            'class' => 'size',
            'name' => 'tbUlica',
            'id' => 'tbUlica',
            'value' => isset($uneti_podaci['ulica_nekretnine']) ? $uneti_podaci['ulica_nekretnine'] : '',
            'placeholder' => 'Милутина Миланковића',
            'required' => TRUE
        );

        $optionsGradSelect = $this->deo_grada_model->podaci();
        $optionsGrad = array(0 => 'Изабери...');
        foreach ($optionsGradSelect as $s):
            $optionsGrad += array($s->id_deo_grada => $s->naziv_deo_grada . ", " . $s->naziv_grada);
        endforeach;

        @$selectedGrad = $uneti_podaci['grad_nekretnine'];

        $data['ddlGrad'] = form_dropdown('ddlGrad', $optionsGrad, $selectedGrad);

        $data['form_opis_nekretnine'] = array(
            'class' => 'size',
            'rows' => '4',
            'cols' => '50',
            'name' => 'tbOpis',
            'id' => 'tbOpis',
            'value' => isset($uneti_podaci['opis_nekretnine']) ? $uneti_podaci['opis_nekretnine'] : '',
            'placeholder' => 'Неки опис о некретнини',
            'required' => TRUE
        );
        $data['form_spratnost_nekretnine'] = array(
            'class' => 'size',
            'name' => 'tbSpratnost',
            'id' => 'tbSpratnost',
            'value' => isset($uneti_podaci['spratnost_nekretnine']) ? $uneti_podaci['spratnost_nekretnine'] : '',
            'placeholder' => '2/5',
            'required' => TRUE
        );
        $data['form_broj_soba_nekretnine'] = array(
            'class' => 'size',
            'name' => 'tbBrSoba',
            'id' => 'tbBrSoba',
            'value' => isset($uneti_podaci['broj_soba_nekretnine']) ? $uneti_podaci['broj_soba_nekretnine'] : '',
            'placeholder' => '0.5 или 2',
            'required' => TRUE
        );
        $data['form_grejanje_nekretnine'] = array(
            'class' => 'size',
            'name' => 'tbGrejanje',
            'id' => 'tbGrejanje',
            'value' => isset($uneti_podaci['grejanje_nekretnine']) ? $uneti_podaci['grejanje_nekretnine'] : '',
            'placeholder' => 'ЦГ, ET, TA,...',
            'required' => TRUE
        );
        $data['form_kvadratura_nekretnine'] = array(
            'class' => 'size',
            'name' => 'tbKvadratura',
            'id' => 'tbKvadratura',
            'value' => isset($uneti_podaci['kvadratura_nekretnine']) ? $uneti_podaci['kvadratura_nekretnine'] : '',
            'placeholder' => 'm2',
            'required' => TRUE
        );
        $data['form_cena_nekretnine'] = array(
            'class' => 'size',
            'name' => 'tbCena',
            'id' => 'tbCena',
            'value' => isset($uneti_podaci['cena_nekretnine']) ? $uneti_podaci['cena_nekretnine'] : '',
            'placeholder' => '€',
            'required' => TRUE
        );
        $data['form_glavna_slika_nekretnine'] = array(
            'name' => 'fSlikaGlavna',
            'size' => '30',
            'id' => 'fSlikaGlavna'
        );
        $data['form_dodaj_jos_sliku'] = array(
            'type' => 'button',
            'name' => 'btnDodajSliku',
            'id' => 'btnDodajSliku',
            'value' => 'Додај још слика'
        );
        $data['form_slika_nekretnine'] = array(
            'name' => 'fSlika[]',
            'size' => '30'
        );

        $this->load->model('agenti_model', 'agenti');

        $optionsSelecta = $this->agenti->podaci();
        $options = array(0 => 'Изабери...');
        foreach ($optionsSelecta as $s):
            $options += array($s->id_agenta => $s->ime_agenta . " " . $s->prezime_agenta);
        endforeach;

        @$selected = $uneti_podaci['agenti'];

        $data['ddlAgenti'] = form_dropdown('ddlAgenti', $options, $selected);

        $data['form_ime_vlasnika'] = array(
            'class' => 'size',
            'name' => 'tbImeVlasnika',
            'id' => 'tbImeVlasnika',
            'value' => isset($uneti_podaci['ime_vlasnika']) ? $uneti_podaci['ime_vlasnika'] : '',
            'placeholder' => 'Милан',
            'required' => TRUE
        );

        $data['form_prezima_vlasnika'] = array(
            'class' => 'size',
            'name' => 'tbPrezimeVlasnika',
            'id' => 'tbPrezimeVlasnika',
            'value' => isset($uneti_podaci['prezime_vlasnika']) ? $uneti_podaci['prezime_vlasnika'] : '',
            'placeholder' => 'Милић',
            'required' => TRUE
        );

        $data['form_telefon_vlasnika'] = array(
            'class' => 'size',
            'name' => 'tbTelefonVlasnika',
            'id' => 'tbTelefonVlasnika',
            'value' => isset($uneti_podaci['telefon_vlasnika']) ? $uneti_podaci['telefon_vlasnika'] : '',
            'placeholder' => '+381631234567',
            'required' => TRUE
        );

        $data['form_dodaj_submit'] = array(
            'name' => 'btnDodaj',
            'class' => 'right form-control',
            'id' => 'btnDodaj',
            'value' => 'Додај'
        );


        $this->meni_model->uslov = $uslovMeni;
        $data['meni'] = $this->meni_model->podaci();

        $data['podaci_preduzeca'] = $this->podaci_o_firmi_model->podaci();

        $data['id_uloge'] = $this->session->userdata('id_uloge');

        $data['id_uloge'] = $this->session->userdata('id_uloge');

        $data['title'] = 'Nekretnine';
        $this->load_view('admin/dodajNekrentinu', $data);
    }

    function dodajSlike($id = null) {
        if (empty($this->session->userdata('id_uloge'))):
            redirect('pocetna');
        endif;
        if ($id != null):

            $data['id_uloge'] = $this->session->userdata('id_uloge');

            if ($data['id_uloge'] == 1):
                $uslovMeni = array(
                    'admin' => '1'
                );
            elseif ($data['id_uloge'] == 2):
                $uslovMeni = array(
                    'korisnik' => '1'
                );
            else:
                $uslovMeni = array(
                    'posetilac' => '1'
                );
            endif;

            $uslovNekretnine = array('nekretnine.id_nekretnina' => $id);
            $this->nekretnine_model->uslov = $uslovNekretnine;
            $nekretnine = $this->nekretnine_model->podaci();


            $data['forma_podaci'] = array(
                'class' => 'form',
                'accept-charset' => 'utf-8',
                'method' => 'POST'
            );
            $data['form_hidden_ulica_nekretnine'] = array(
                'name' => 'hfUlicaGrada',
                'size' => '30',
                'type' => 'hidden',
                'id' => 'hfUlicaGrada',
                'value' => $nekretnine[0]->ulica_nekretnina,
                'required' => TRUE
            );
            $data['form_glavna_slika_nekretnine'] = array(
                'name' => 'fSlikaGlavna',
                'size' => '30',
                'id' => 'fSlikaGlavna',
                'required' => TRUE
            );
            $data['form_dodaj_jos_sliku'] = array(
                'type' => 'button',
                'name' => 'btnDodajSliku',
                'id' => 'btnDodajSliku',
                'value' => 'Додај још слика'
            );
            $data['form_slika_nekretnine'] = array(
                'name' => 'fSlika[]',
                'size' => '30'
            );
            $data['form_dodaj_submit'] = array(
                'name' => 'btnDodaj',
                'class' => 'right form-control',
                'id' => 'btnDodaj',
                'value' => 'Додај'
            );


            $is_post = $this->input->server('REQUEST_METHOD') == 'POST';
            if ($is_post):

                $dugme = $this->input->post('btnDodaj');
                if ($data != ""):

                    $ulica_nekretnina = $this->input->post('hfUlicaGrada');
                    $config['upload_path'] = 'images/nekretnineNovo/';
                    $config['allowed_types'] = 'gif|jpg|png|JPG';
                    $config['max_size'] = '4000';
                    $config['max_width'] = '2000';
                    $config['max_height'] = '2000';

                    if ($_FILES['fSlikaGlavna']['type'] == 'image/jpeg'):
                        $picName = '.jpg';
                    elseif ($_FILES['fSlikaGlavna']['type'] == 'image/JPEG'):
                        $picName = '.JPG';
                    elseif ($_FILES['fSlikaGlavna']['type'] == 'image/png'):
                        $picName = '.png';
                    elseif ($_FILES['fSlikaGlavna']['type'] == 'image/PNG'):
                        $picName = '.PNG';
                    elseif ($_FILES['fSlikaGlavna']['type'] == 'image/gif'):
                        $picName = '.gif';
                    elseif ($_FILES['fSlikaGlavna']['type'] == 'image/GIF'):
                        $picName = '.GIF';
                    endif;
                    $file_name = time() . @$picName;
                    $config['file_name'] = $file_name;

                    $this->load->library('upload', $config);
                    $this->load->library('form_validation');
                    if (!$this->upload->do_upload('fSlikaGlavna')):
                        $error = array('error' => $this->upload->display_errors());
                        $data['obavestenje'] = "<div class='alert alert-danger ispis'>Проверите унеру слику да ли је одговарајућих димензија!</div>";
                    else:
                        $data = array('upload_data' => $this->upload->data());

                        $this->slika_nekretnine_model->naziv_slika_nekretnina = $ulica_nekretnina;
                        $this->slika_nekretnine_model->putanja_slika_nekretnina = 'images/nekretnineNovo/' . $file_name;
                        $this->slika_nekretnine_model->id_nekretnina = $id;
                        $this->slika_nekretnine_model->front_slika = 0;
                        $this->slika_nekretnine_model->glasova = 0;
                        $this->slika_nekretnine_model->rezultat = 0;

                        $rezGlavne_slike = $this->slika_nekretnine_model->unesi();

                        if ($rezGlavne_slike == true):
                            $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешнно сте додали слику!</div>";

                            if (!empty($_FILES['fSlika']['name'])):
                                $filesCount = count($_FILES['fSlika']['name']);

                                $rezSlike = null;
                                for ($i = 0; $i < $filesCount; $i++):
                                    $config['upload_path'] = 'images/nekretnineNovo/';
                                    $config['allowed_types'] = 'gif|jpg|png|JPG';
                                    $config['max_size'] = '4000';
                                    $config['max_width'] = '2000';
                                    $config['max_height'] = '2000';

                                    $_FILES['f']['type'] = $_FILES['fSlika']['type'][$i];
                                    if ($_FILES['f']['type'] == 'image/jpeg'):
                                        $picName = '.jpg';
                                    elseif ($_FILES['f']['type'] == 'image/JPEG'):
                                        $picName = '.JPG';
                                    elseif ($_FILES['f']['type'] == 'image/png'):
                                        $picName = '.png';
                                    elseif ($_FILES['f']['type'] == 'image/PNG'):
                                        $picName = '.PNG';
                                    elseif ($_FILES['f']['type'] == 'image/gif'):
                                        $picName = '.gif';
                                    elseif ($_FILES['f']['type'] == 'image/GIF'):
                                        $picName = '.GIF';
                                    endif;
                                    $file_name = time() . $i.$picName;


                                    $_FILES['f']['name'] = $file_name;
                                    $name2 = $_FILES['f']['name'];
                                    $config['file_name'] = $name2;
                                    $_FILES['f']['tmp_name'] = $_FILES['fSlika']['tmp_name'][$i];
                                    $_FILES['f']['size'] = $_FILES['fSlika']['size'][$i];
                                    $this->upload->initialize($config);
                                    $this->upload->do_upload('f');

                                    $this->slika_nekretnine_model->naziv_slika_nekretnina = $ulica_nekretnina;
                                    $this->slika_nekretnine_model->putanja_slika_nekretnina = 'images/nekretnineNovo/' . $name2;
                                    $this->slika_nekretnine_model->id_nekretnina = $id;
                                    $this->slika_nekretnine_model->front_slika = 0;
                                    $this->slika_nekretnine_model->glasova = 0;
                                    $this->slika_nekretnine_model->rezultat = 0;
                                    $rezSlike = $this->slika_nekretnine_model->unesi();
                                endfor;
                                if ($rezSlike):
                                    $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешно сте додали слику!</div>";
                                else:
                                    $data['obavestenje'] = "<div class='alert alert-danger ispis'>Додавање слике није успело!</div>";
                                endif;

                            endif;
                        else:
                            $data['obavestenje'] = "<div class='alert alert-danger ispis'>Додавање слике није успело!</div>";
                        endif;
                        $data['forma_podaci'] = array(
                            'class' => 'form',
                            'accept-charset' => 'utf-8',
                            'method' => 'POST'
                        );
                        $data['form_hidden_ulica_nekretnine'] = array(
                            'name' => 'hfUlicaGrada',
                            'size' => '30',
                            'type' => 'hidden',
                            'id' => 'hfUlicaGrada',
                            'value' => $nekretnine[0]->ulica_nekretnina,
                            'required' => TRUE
                        );
                        $data['form_glavna_slika_nekretnine'] = array(
                            'name' => 'fSlikaGlavna',
                            'size' => '30',
                            'id' => 'fSlikaGlavna',
                            'required' => TRUE
                        );
                        $data['form_dodaj_jos_sliku'] = array(
                            'type' => 'button',
                            'name' => 'btnDodajSliku',
                            'id' => 'btnDodajSliku',
                            'value' => 'Додај још слика'
                        );
                        $data['form_slika_nekretnine'] = array(
                            'name' => 'fSlika[]',
                            'size' => '30'
                        );
                        $data['form_dodaj_submit'] = array(
                            'name' => 'btnDodaj',
                            'class' => 'right form-control',
                            'id' => 'btnDodaj',
                            'value' => 'Додај'
                        );
                    endif;
                endif;
            endif;


            $this->meni_model->uslov = $uslovMeni;
            $data['meni'] = $this->meni_model->podaci();

            $data['podaci_preduzeca'] = $this->podaci_o_firmi_model->podaci();

            $data['id_uloge'] = $this->session->userdata('id_uloge');


            $data['tip_nekretnine'] = $this->tip_nekretnine_model->podaci();
            $data['nekretnine'] = $nekretnine;

            $data['title'] = 'Nekretnine';
            $this->load_view('admin/dodajSlikeNekretnine', $data);

        else:
            redirect('admin/AdminNekretnine');
        endif;
    }

    function dodajKategoriju() {
        if (empty($this->session->userdata('id_uloge'))):
            redirect('pocetna');
        endif;
        $data['id_uloge'] = $this->session->userdata('id_uloge');

        if ($data['id_uloge'] == 1):

            $uslovMeni = array(
                'admin' => '1'
            );

        elseif ($data['id_uloge'] == 2):

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

        $data['forma_podaci'] = array(
            'class' => 'form',
            'accept-charset' => 'utf-8',
            'method' => 'POST'
        );
        $data['form_kategorija'] = array(
            'name' => 'tbKategorija',
            'size' => '30',
            'id' => 'tbKategorija',
            'required' => TRUE
        );
        $data['form_dodaj_submit'] = array(
            'name' => 'btnDodaj',
            'class' => 'right form-control',
            'id' => 'btnDodaj',
            'value' => 'Додај'
        );

        $is_post = $this->input->server('REQUEST_METHOD') == 'POST';
        if ($is_post):
            $dugme = $this->input->post('btnDodaj');
            if ($data != ""):

                $kategorija = trim($this->input->post('tbKategorija'));

                $this->load->library('form_validation');

                $this->form_validation->set_rules('tbKategorija', 'категорија', 'trim|required|xss_clean');

                $this->form_validation->set_message('required', 'Поље %s је празно!');

                if ($this->form_validation->run()):

                    $this->kategorija_model->naziv_kategorije = $kategorija;

                    $rezKategorija = $this->kategorija_model->unesi();

                    if ($rezKategorija != ""):
                        $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешно сте додали категорију!</div>";
                    else:
                        $data['obavestenje'] = "<div class='alert alert-danger ispis'>Додавање категорије није успело!</div>";
                    endif;
                endif;
            endif;
        endif;

        $rezKategorija = $this->kategorija_model->podaci();

        $data['kategorija'] = $rezKategorija;

        $this->load->library('table');
        $this->table->set_template(array('table_open' => '<table class="table center-block" border="1" style="width: 300px; margin-top:30px; display:table">'));
        $this->table->set_heading('Назив категорије', 'Измени');
        if ($rezKategorija != null):
            foreach ($rezKategorija as $s):
                $linkIzmeni = anchor('admin/AdminNekretnine/izmeniKategoriju/' . $s->id_kategorije, 'Измени');

                $this->table->add_row($s->naziv_kategorije, $linkIzmeni);
            endforeach;
            $data['tabela'] = $this->table->generate();
            $data['title'] = 'Категорије';
        else:
            $data['obavestenje'] = 'Грешка';
        endif;

        $data['title'] = 'Категорије';
        $this->load_view('admin/kategorijaUid', $data);
    }

    function izmeniKategoriju($id = null) {
        if (empty($this->session->userdata('id_uloge'))):
            redirect('pocetna');
        endif;

        if ($id != null):

            $data['id_uloge'] = $this->session->userdata('id_uloge');

            if ($data['id_uloge'] == 1):

                $uslovMeni = array(
                    'admin' => '1'
                );

            elseif ($data['id_uloge'] == 2):

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

            $uslovKategorije = array(
                'id_kategorije' => $id
            );
            $this->kategorija_model->uslov = $uslovKategorije;
            $rezKategorija = $this->kategorija_model->podaci();
            $data['kategorija'] = $rezKategorija;

            $data['forma_podaci'] = array(
                'class' => 'form',
                'accept-charset' => 'utf-8',
                'method' => 'POST'
            );
            $data['form_kategorija'] = array(
                'name' => 'tbKategorija',
                'size' => '30',
                'id' => 'tbKategorija',
                'value' => $rezKategorija[0]->naziv_kategorije,
                'required' => TRUE
            );
            $data['form_dodaj_submit'] = array(
                'name' => 'btnIzmeni',
                'class' => 'right form-control',
                'id' => 'btnIzmeni',
                'value' => 'Измени'
            );

            $is_post = $this->input->server('REQUEST_METHOD') == 'POST';
            if ($is_post):
                $dugme = $this->input->post('btnIzmeni');
                if ($data != ""):

                    $kategorija = trim($this->input->post('tbKategorija'));

                    $this->load->library('form_validation');

                    $this->form_validation->set_rules('tbKategorija', 'категорија', 'trim|required|xss_clean');

                    $this->form_validation->set_message('required', 'Поље %s је празно!');

                    if ($this->form_validation->run()):

                        $this->kategorija_model->naziv_kategorije = $kategorija;
                        $uslovKategorije = array('id_kategorije' => $id);
                        $this->kategorija_model->uslov = $uslovKategorije;

                        $rezKategorija = $this->kategorija_model->izmeni();

                        if ($rezKategorija != ""):
                            $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешно сте изменили категорију!</div>";
                        else:
                            $data['obavestenje'] = "<div class='alert alert-danger ispis'>Измена категорије није успела!</div>";
                        endif;
                        $data['forma_podaci'] = array(
                            'class' => 'form',
                            'accept-charset' => 'utf-8',
                            'method' => 'POST'
                        );
                        $data['form_kategorija'] = array(
                            'name' => 'tbKategorija',
                            'size' => '30',
                            'id' => 'tbKategorija',
                            'value' => $kategorija,
                            'required' => TRUE
                        );
                        $data['form_dodaj_submit'] = array(
                            'name' => 'btnIzmeni',
                            'class' => 'right form-control',
                            'id' => 'btnIzmeni',
                            'value' => 'Измени'
                        );
                    endif;
                endif;
            endif;
        else:
            redirect('admin/AdminNekretnine/dodajKategoriju');
        endif;

        $data['title'] = 'Категорије';
        $this->load_view('admin/izmeniKategoriju', $data);
    }

    function dodajGrad() {
        if (empty($this->session->userdata('id_uloge'))):
            redirect('pocetna');
        endif;
        $data['id_uloge'] = $this->session->userdata('id_uloge');

        if ($data['id_uloge'] == 1):

            $uslovMeni = array(
                'admin' => '1'
            );

        elseif ($data['id_uloge'] == 2):

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

        $data['forma_podaci'] = array(
            'class' => 'form',
            'accept-charset' => 'utf-8',
            'method' => 'POST'
        );
        $data['form_grad'] = array(
            'name' => 'tbGrad',
            'size' => '30',
            'id' => 'tbGrad',
            'required' => TRUE
        );
        $data['form_dodaj_submit'] = array(
            'name' => 'btnDodaj',
            'class' => 'right form-control',
            'id' => 'btnDodaj',
            'value' => 'Додај'
        );

        $is_post = $this->input->server('REQUEST_METHOD') == 'POST';
        if ($is_post):
            $dugme = $this->input->post('btnDodaj');
            if ($data != ""):

                $grad = trim($this->input->post('tbGrad'));

                $this->load->library('form_validation');

                $this->form_validation->set_rules('tbGrad', 'град', 'trim|required|xss_clean');

                $this->form_validation->set_message('required', 'Поље %s је празно!');

                if ($this->form_validation->run()):

                    $this->grad_model->naziv_grada = $grad;

                    $rezGrad = $this->grad_model->unesi();

                    if ($rezGrad != ""):
                        $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешно сте додали град!</div>";
                    else:
                        $data['obavestenje'] = "<div class='alert alert-danger ispis'>Додавање града није успело!</div>";
                    endif;
                endif;
            endif;
        endif;

        $rezGrad = $this->grad_model->podaci();

        $data['grad'] = $rezGrad;

        $this->load->library('table');
        $this->table->set_template(array('table_open' => '<table class="table center-block" border="1" style="width: 300px; margin-top:30px; display:table">'));
        $this->table->set_heading('Назив града', 'Измени');
        if ($rezGrad != null):
            foreach ($rezGrad as $s):
                $linkIzmeni = anchor('admin/AdminNekretnine/izmeniGrad/' . $s->id_grada, 'Измени');

                $this->table->add_row($s->naziv_grada, $linkIzmeni);
            endforeach;
            $data['tabela'] = $this->table->generate();
            $data['title'] = 'Градови';
        else:
            $data['obavestenje'] = 'Грешка';
        endif;

        $data['title'] = 'Град';
        $this->load_view('admin/gradoviUid', $data);
    }

    function izmeniGrad($id = null) {
        if (empty($this->session->userdata('id_uloge'))):
            redirect('pocetna');
        endif;

        if ($id != null):

            $data['id_uloge'] = $this->session->userdata('id_uloge');

            if ($data['id_uloge'] == 1):

                $uslovMeni = array(
                    'admin' => '1'
                );

            elseif ($data['id_uloge'] == 2):

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

            $uslovGrad = array(
                'id_grada' => $id
            );
            $this->grad_model->uslov = $uslovGrad;
            $rezGrad = $this->grad_model->podaci();
            $data['grad'] = $rezGrad;

            $data['forma_podaci'] = array(
                'class' => 'form',
                'accept-charset' => 'utf-8',
                'method' => 'POST'
            );
            $data['form_grad'] = array(
                'name' => 'tbGrad',
                'size' => '30',
                'id' => 'tbGrad',
                'value' => $rezGrad[0]->naziv_grada,
                'required' => TRUE
            );
            $data['form_dodaj_submit'] = array(
                'name' => 'btnIzmeni',
                'class' => 'right form-control',
                'id' => 'btnIzmeni',
                'value' => 'Измени'
            );

            $is_post = $this->input->server('REQUEST_METHOD') == 'POST';
            if ($is_post):
                $dugme = $this->input->post('btnIzmeni');
                if ($data != ""):

                    $grad = trim($this->input->post('tbGrad'));

                    $this->load->library('form_validation');

                    $this->form_validation->set_rules('tbGrad', 'град', 'trim|required|xss_clean');

                    $this->form_validation->set_message('required', 'Поље %s је празно!');

                    if ($this->form_validation->run()):

                        $this->grad_model->naziv_grada = $grad;
                        $uslovGrad = array('id_grada' => $id);
                        $this->grad_model->uslov = $uslovGrad;

                        $rezGrada = $this->grad_model->izmeni();

                        if ($rezGrada != ""):
                            $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешно сте изменили град!</div>";
                        else:
                            $data['obavestenje'] = "<div class='alert alert-danger ispis'>Измена града није успела!</div>";
                        endif;
                        $data['forma_podaci'] = array(
                            'class' => 'form',
                            'accept-charset' => 'utf-8',
                            'method' => 'POST'
                        );
                        $data['form_grad'] = array(
                            'name' => 'tbGrad',
                            'size' => '30',
                            'id' => 'tbGrad',
                            'value' => $grad,
                            'required' => TRUE
                        );
                        $data['form_dodaj_submit'] = array(
                            'name' => 'btnIzmeni',
                            'class' => 'right form-control',
                            'id' => 'btnIzmeni',
                            'value' => 'Измени'
                        );
                    endif;
                endif;
            endif;
        else:
            redirect('admin/AdminNekretnine/dodajGrad');
        endif;

        $data['title'] = 'Град';
        $this->load_view('admin/izmeniGrad', $data);
    }

    function dodajDeoGrad() {
        if (empty($this->session->userdata('id_uloge'))):
            redirect('pocetna');
        endif;
        $data['id_uloge'] = $this->session->userdata('id_uloge');

        if ($data['id_uloge'] == 1):

            $uslovMeni = array(
                'admin' => '1'
            );

        elseif ($data['id_uloge'] == 2):

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

        $data['forma_podaci'] = array(
            'class' => 'form',
            'accept-charset' => 'utf-8',
            'method' => 'POST'
        );

        $optionsGradSelect = $this->grad_model->podaci();
        $optionsGrad = array(0 => 'Изабери...');
        foreach ($optionsGradSelect as $s):
            $optionsGrad += array($s->id_grada => $s->naziv_grada);
        endforeach;

        $data['ddlGrad'] = form_dropdown('ddlGrad', $optionsGrad);

        $optionsGradSelect = $this->grad_model->podaci();
        $optionsGrad = array(0 => 'Изабери...');
        foreach ($optionsGradSelect as $s):
            $optionsGrad += array($s->id_grada => $s->naziv_grada);
        endforeach;

        $data['ddlDeoGrad'] = form_dropdown('ddlDeoGrad', $optionsGrad);

        $data['form_deo_grad'] = array(
            'name' => 'tbDeoGrad',
            'size' => '30',
            'id' => 'tbDeoGrad',
            'required' => TRUE
        );
        $data['form_dodaj_submit'] = array(
            'name' => 'btnDodaj',
            'class' => 'right form-control',
            'id' => 'btnDodaj',
            'value' => 'Додај'
        );
        $data['form_prikazi_submit'] = array(
            'name' => 'btnPrikazi',
            'class' => 'right form-control',
            'id' => 'btnPrikazi',
            'value' => 'Прикажи'
        );


        $is_post = $this->input->server('REQUEST_METHOD') == 'POST';
        if ($is_post):
            $dugme = $this->input->post('btnDodaj');
            $dugme2 = $this->input->post('btnPrikazi');
            if ($data != ""):

                $Grad = $this->input->post('ddlGrad');
                $deoGrad = trim($this->input->post('tbDeoGrad'));

                $this->load->library('form_validation');

                $this->form_validation->set_rules('ddlGrad', 'град', 'callback_proveraGrad');
                $this->form_validation->set_rules('tbDeoGrad', 'део града', 'trim|required|xss_clean');

                $this->form_validation->set_message('proveraGrad', 'Морате изабрати  %s!');
                $this->form_validation->set_message('required', 'Поље %s је празно!');

                if ($this->form_validation->run()):

                    $this->deo_grada_model->naziv_deo_grada = $deoGrad;
                    $this->deo_grada_model->id_grada = $Grad;

                    $rezDeoGrad = $this->deo_grada_model->unesi();

                    if ($rezDeoGrad != ""):
                        $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешно сте додали део град!</div>";
                    else:
                        $data['obavestenje'] = "<div class='alert alert-danger ispis'>Додавање дела града није успело!</div>";
                    endif;
                endif;
            endif;
            if ($dugme2 != ""):
                $selectedGrad = $this->input->post('ddlDeoGrad');

                $uslovDeoGrada = array('deo_grada_nekretnine.id_grada' => $selectedGrad);
                $this->deo_grada_model->uslov = $uslovDeoGrada;
                $rezDeoGrad = $this->deo_grada_model->podaci();

                if ($rezDeoGrad != ""):

                    $data['grad'] = $rezDeoGrad;

                    $this->load->library('table');
                    $this->table->set_template(array('table_open' => '<table class="table center-block" border="1" style="width: 300px; margin-top:30px; display:table">'));
                    $this->table->set_heading('Назив дела града', 'Измени');
                    if ($rezDeoGrad != null):
                        foreach ($rezDeoGrad as $s):
                            $linkIzmeni = anchor('admin/AdminNekretnine/izmeniDeoGrad/' . $s->id_deo_grada, 'Измени');

                            $this->table->add_row($s->naziv_deo_grada, $linkIzmeni);
                        endforeach;
                        $data['tabela'] = $this->table->generate();
                        $data['title'] = 'Део града';
                    else:
                        $data['obavestenje2'] = "<div class='alert alert-danger ispis' style='width:500px; text-align: center; margin:0px auto'>Нема те додат део града за одабран град!</div>";
                    endif;
                else:
                    $data['obavestenje'] = "<div class='alert alert-danger ispis'>Нема те део града за одабран град!</div>";
                endif;

            endif;
        endif;

        $data['title'] = 'Део града';
        $this->load_view('admin/deloviGradaUid', $data);
    }

    function izmeniDeoGrad($id = null) {
        if (empty($this->session->userdata('id_uloge'))):
            redirect('pocetna');
        endif;

        if ($id != null):

            $data['id_uloge'] = $this->session->userdata('id_uloge');

            if ($data['id_uloge'] == 1):

                $uslovMeni = array(
                    'admin' => '1'
                );

            elseif ($data['id_uloge'] == 2):

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

            $uslovDeoGrad = array(
                'id_deo_grada' => $id
            );
            $this->deo_grada_model->uslov = $uslovDeoGrad;
            $rezDeoGrad = $this->deo_grada_model->podaci();
            $data['deoGrad'] = $rezDeoGrad;

            $data['forma_podaci'] = array(
                'class' => 'form',
                'accept-charset' => 'utf-8',
                'method' => 'POST'
            );

            $optionsGradSelect = $this->grad_model->podaci();
            $optionsGrad = array(0 => 'Изабери...');
            foreach ($optionsGradSelect as $s):
                $optionsGrad += array($s->id_grada => $s->naziv_grada);
            endforeach;

            $data['ddlGrad'] = form_dropdown('ddlGrad', $optionsGrad, $rezDeoGrad[0]->id_grada);

            $data['form_deo_grad'] = array(
                'name' => 'tbDeoGrad',
                'size' => '30',
                'id' => 'tbDeoGrad',
                'value' => $rezDeoGrad[0]->naziv_deo_grada,
                'required' => TRUE
            );
            $data['form_izmeni_submit'] = array(
                'name' => 'btnIzmeni',
                'class' => 'right form-control',
                'id' => 'btnIzmeni',
                'value' => 'Измени'
            );

            $is_post = $this->input->server('REQUEST_METHOD') == 'POST';
            if ($is_post):
                $dugme = $this->input->post('btnIzmeni');
                if ($data != ""):

                    $deoGrada = trim($this->input->post('tbDeoGrad'));
                    $grad = $this->input->post('ddlGrad');

                    $this->load->library('form_validation');

                    $this->form_validation->set_rules('tbDeoGrad', 'део града', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('ddlGrad', 'град', 'callback_proveraGrad');

                    $this->form_validation->set_message('proveraGrad', 'Морате изабрати  %s!');
                    $this->form_validation->set_message('required', 'Поље %s је празно!');

                    if ($this->form_validation->run()):

                        $this->deo_grada_model->naziv_deo_grada = $deoGrada;
                        $this->deo_grada_model->id_grada = $grad;
                        $uslovDeoGrad = array('id_deo_grada' => $id);
                        $this->deo_grada_model->uslov = $uslovDeoGrad;

                        $rezDeoGrada = $this->deo_grada_model->izmeni();

                        if ($rezDeoGrada != ""):
                            $data['obavestenje'] = "<div class='alert alert-success ispis'>Успешно сте изменили део град!</div>";
                        else:
                            $data['obavestenje'] = "<div class='alert alert-danger ispis'>Измена дела града није успела!</div>";
                        endif;
                        $data['forma_podaci'] = array(
                            'class' => 'form',
                            'accept-charset' => 'utf-8',
                            'method' => 'POST'
                        );
                        $data['form_deo_grad'] = array(
                            'name' => 'tbDeoGrad',
                            'size' => '30',
                            'id' => 'tbDeoGrad',
                            'value' => $deoGrada,
                            'required' => TRUE
                        );
                        $data['form_izmeni_submit'] = array(
                            'name' => 'btnIzmeni',
                            'class' => 'right form-control',
                            'id' => 'btnIzmeni',
                            'value' => 'Измени'
                        );
                    endif;
                endif;
            endif;
        else:
            redirect('admin/AdminNekretnine/dodajGrad');
        endif;

        $data['title'] = 'Град';
        $this->load_view('admin/izmeniDeoGrad', $data);
    }

    function proveraTip($unos) {
        if ($unos == 0) {
            return false;
        }
        return true;
    }

    function proveraTop($unos) {
        if ($unos == 0) {
            return 0;
        }
        return 1;
    }

    function proveraAgent($unos) {
        if ($unos == 0) {
            return false;
        }
        return true;
    }

    function proveraGrad($unos) {
        if ($unos == 0) {
            return false;
        }
        return true;
    }

    function proveraKategorija($unos) {
        if ($unos == 0) {
            return false;
        }
        return true;
    }

}
