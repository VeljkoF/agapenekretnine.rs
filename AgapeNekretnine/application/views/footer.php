<!-- footer -->
<footer>	
    <!-- footer-top -->
    <div class="footer-top">
        <div class="container">
            <div class="col-md-6 footer-top-left">
                <h3><a href="<?php echo base_url();?>"><?php echo $podaci_preduzeca[0]->naziv_firme." ".$podaci_preduzeca[0]->opis_firme;?></a></h3>
                <p></p>
                <ul class="fb_icons2">
                    <li><a class="fb" href="http://www.facebook.com"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li><a class="twit" href="http://www.twiter.com"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                    <li><a class="goog" href="http://www.google.com"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                </ul>
            </div>
            <div class="col-md-3 footer-top-mid">
                <h3></h3>
                <?php 
                    if(isset($meni)):
                        
                        $meni_lista = array();
                        $meni_attributes = array(
                            'data-display' => 'mySite'
                        );
                            
                        foreach ($meni as $m):
                            $meni_lista[] = anchor(base_url().$m->putanja_meni, "<i class='fa fa-long-arrow-right' aria-hidden='true'></i>".$m->naziv_meni); 
                                //$meni_lista[] = anchor(base_url().$m->putanja_meni, "<i class='fa fa-long-arrow-right' aria-hidden='true'></i>".ucfirst(mb_convert_case($m->naziv_meni, MB_CASE_LOWER, "UTF-8")));                          
                        endforeach;
                            
//                        $meni_lista[] = anchor(base_url()."doc/dokumentacija.pdf", "<i class='fa fa-long-arrow-right' aria-hidden='true'></i>Dokumentacija");
//                        $meni_lista[] = anchor(base_url()."xml/sitemape.xml", "<i class='fa fa-long-arrow-right' aria-hidden='true'></i>Mapa sajta");
                        
                        if(@$id_uloge != NULL):
                            $meni_lista[] = anchor(base_url()."Logovanje/logout", "<i class='fa fa-long-arrow-right' aria-hidden='true'></i>ОДЈАВА");
                        else:
                            $meni_lista[] = anchor(base_url()."#", "<i class='fa fa-long-arrow-right' aria-hidden='true'></i>ПРИЈАВА", $meni_attributes);
                        endif;
                        
                        echo ul($meni_lista);
                            
                    endif;
                ?>
            </div>
            <div class="col-md-3 adress-agile">
                <h3>Адреса</h3>
                <address>
                    <ul>
                        <li><?php echo $podaci_preduzeca[0]->adresa_firme;?></li>
                        <li><?php echo $podaci_preduzeca[0]->grad_firme;?></li>
                        <li><?php echo $podaci_preduzeca[0]->zemlja_firme;?></li>
                        <li>Телефон : <?php echo $podaci_preduzeca[0]->telefon_firme;?></li>
                        <li>Телефон моб. : <?php echo $podaci_preduzeca[0]->telefon_mobilni_firme;?></li>
                        <li>Рег. број : <?php echo $podaci_preduzeca[0]->registarski_broj_firme;?></li>
                        <li>Email : <?php echo safe_mailto($podaci_preduzeca[0]->email_firme, $podaci_preduzeca[0]->email_firme);?></li>
                    </ul>
                </address>				
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- //footer-top -->
    <div class="w3layouts-copyright">
        <p class="footer"><b>&copy; 2017 <?php echo $podaci_preduzeca[0]->naziv_firme.", ". $podaci_preduzeca[0]->registracija_firme;?> | Dizajn <a href="http://veljkofridl.com/"><b>Veljko Fridl</b></a></b></p>
    </div>
</footer>
<!-- //footer -->
</body>
</html>