<!-- breadcrumbs -->
<div class="w3ls-inner-banner">
    <div class="container">
        <h2>О нама</h2>
        <label></label>
        <div class="clearfix"></div>
    </div>
</div>
<!-- //breadcrumbs -->
            
<!-- main-content -->
<div class="main-content">
    <!-- about-page -->
    <!-- welcome -->
    <div class="welcome-top">
        <div class="container">
            <div class="col-md-6 welcome_top_left">
                <h3>ДОБРОДОШЛИ</h3>
                <h5><?php echo $podaci_preduzeca[0]->naziv_firme." ".$podaci_preduzeca[0]->registracija_firme;?></h5>
                <p>
                    <?php echo $podaci_preduzeca[0]->opis_firme_duzi;?>
                </p>
            </div>
            <div class="col-md-6 welcome_top_right">
                <h3>ОТВОРЕНИ СМО</h3>
<!--                <h5>In Sed Ut perspiciatis Street</h5>-->
                <div class="welcome_right_location">
                    <div class="location_img">
                        <?php $loc = array('src' => 'images/loc.jpg', 'alt' => 'zaposleni slika');?>
                        <?php echo img($loc);?>
                    </div>
                    <div class="location">
                        <p><?php echo $podaci_preduzeca[0]->otvoreni_smo_firma;?></p>
                        <p class="location_text"><span class="glyphicon glyphicon-map-marker"></span><?php echo $podaci_preduzeca[0]->adresa_firme.", ".$podaci_preduzeca[0]->grad_firme.", ".$podaci_preduzeca[0]->zemlja_firme;?><br></p>
                            <p class="location_text"><span class="glyphicon glyphicon-dashboard"></span><?php echo $podaci_preduzeca[0]->radno_vreme_firme;?></p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- /welcome -->
    <!-- OUR AGENTS -->
    <section class="team-w3ls">
        <div class="container">
            <div class="agileits-team text-center">
                <h3>НАШЕ КОНТАКТ ОСОБЕ</h3>
                <p></p>
                
                <?php foreach ($agenti as $agent): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 w3-agent">
                        <div class="hovereffect">
                            <?php $agentList = array('class'=>'img-responsive', 'src' => $agent->slika_agenta, 'alt' => $agent->ime_agenta." ".$agent->prezime_agenta);?>
                            <?php echo img($agentList);?>
                            <div class="overlay">
                                <h4><?php echo $agent->ime_agenta?></h4>
                                <p> 
                                    <a href="#" data-toggle="modal" data-target="#agent<?php echo $agent->id_agenta?>">Контакт особа</a>
                                </p> 
                            </div>
                        </div>
                    </div>					
                <?php endforeach;?>     
                
                	
                <div class="clearfix"></div>
            </div>
        </div>
    </section>	
    <?php foreach ($agenti as $agent): ?>
        <!-- modal-for agent<?php echo $agent->id_agenta;?>-details -->
        <div class="modal fade modal-about" id="agent<?php echo $agent->id_agenta?>" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content"> 
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">О МЕНИ</h4>
                    </div>
                    <div class="modal-body modal-spa">
                        <div class="w3layouts-about"> 
                            <div class="col-md-4 about-left ">
                                <?php $agentLista = array('class'=>'img-responsive', 'src' => $agent->slika_agenta, 'alt' => $agent->ime_agenta." ".$agent->prezime_agenta);?>
                                <?php echo img($agentLista);?>
                            </div>
                            <div class="col-md-8 about-right wthree">
                                <h3>Поздрав, зовем се <span><?php echo $agent->ime_agenta." ".$agent->prezime_agenta;?></span></h3>
                                <h4></h4>
                                <ul class="address">									
                                    <li>
                                        <ul class="agileits-address-text">
                                            <li><b>Телефон: </b></li>
                                            <li><?php echo $agent->telefon_agenta?></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul class="agileits-address-text">
                                            <li><b>Mail: </b></li>
                                            <li><?php echo anchor($agent->mail_agenta, $agent->mail_agenta);?></li>
                                        </ul>
                                    </li>
                                </ul> 
                            </div> 
                            <div class="clearfix"> </div> 
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <!-- //modal-for agent<?php echo $agent->id_agenta;?>-details -->
    <?php endforeach; ?>
    <!-- modal-for agent2-details -->
    <!-- //	OUR AGENTS -->
    <!-- //about-page -->
</div>
<!-- //main-content -->