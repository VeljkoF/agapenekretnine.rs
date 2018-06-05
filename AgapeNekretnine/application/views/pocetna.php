<!-- slider -->
<script type="text/javascript">alert($greska_log);</script>
<div class="banner text-center">		
    <div class="loading-container">
        <div class="pulse"></div>
    </div>
    <div id="slides">
        
        <?php 
            $slajder_attributes = array(
                'class' => 'slides-container'
            );
            $slajder_lista;
            foreach ($slajder as $s):
                $slajder_img = array(
                    'src' => $s->putanja_slike_slajder,
                    'alt' => $s->naslov_slajder
                );
                $slajder_lista[] = img($slajder_img)."<div class='container'><h3 class='black_text'>".$s->naslov_slajder."</h3><p>".$s->opis_slajder."</p>";
            endforeach;
            
            echo ul($slajder_lista, $slajder_attributes);
        ?>
        <nav class="slides-navigation">
            <a href="#" class="next">
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </a>
            <a href="#" class="prev">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </a>
        </nav>
    </div>
</div>
<!-- //slider -->
<!-- main-content -->
<div class="main-content">
    <!-- welcome -->
    <div class="welcome-top">
        <div class="container">
            <div class="col-md-6 welcome_top_left">
                <h3>ДОБРОДОШЛИ</h3>
                <h5><?php echo $podaci_preduzeca[0]->naziv_firme." ".$podaci_preduzeca[0]->opis_firme;?></h5>
                <p><?php echo $podaci_preduzeca[0]->opis_firme_duzi;?></p>
            </div>
            <div class="col-md-6 welcome_top_right">
                <h3>ОТВОРЕНИ СМО</h3>
                <h5></h5>
                <div class="welcome_right_location">
                    <div class="location_img">
                        <img src="<?php echo base_url(); ?>images/loc.jpg" alt="">
                    </div>
                    <div class="location">
                        <p><?php echo $podaci_preduzeca[0]->otvoreni_smo_firma;?></p>
                        <p class="location_text"><span class="glyphicon glyphicon-map-marker"></span><?php echo $podaci_preduzeca[0]->adresa_firme.", ".$podaci_preduzeca[0]->grad_firme.", ".$podaci_preduzeca[0]->zemlja_firme;?></p>
                        <p class="location_text"><span class="glyphicon glyphicon-dashboard"></span><?php echo $podaci_preduzeca[0]->radno_vreme_firme;?></p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- /welcome -->
        
    <!-- properties-list -->
    <!-- <div class="properties">
        <div class="container">
            <!-- slider
            <div class="properties-list">
                <h2>Топ понуда</h2>
                <ul id="flexiselDemo3">
                <?php 
                    $top_attributes = array(
                        'id' => 'flexiselDemo3'
                    );
                    $top_lista;
                    foreach ($nekretnine as $n):
                        $top_img = array(
                            'src' => $n->putanja_slika_nekretnina,
                            'alt' => $n->naziv_slika_nekretnina,
                            'class' => 'center-block'
                        );
                ?>
                    <li>
                        <div class="col-md-6 agileits">
                             <!--Slider 
                            <div class="Pro-img-w3ls">		
                                <?php echo img($top_img); ?>
                            </div>
                             <!--Slider							
                        </div>
                        <div class="col-md-6 pro-details-w3layouts">
                            <h3><b><?php echo $n->naziv_tip_nekretnina.", ". $n->naziv_kategorije; ?></b></h3>	
                            <label></label>
                            <p class="location"><strong>Локација: </strong> <?php echo $n->naziv_deo_grada.", ".$n->naziv_grada; ?></p>
                            <ol class='agileits-prolist'>
                                <li>
                                    <i class='fa fa-long-arrow-right' aria-hidden='true'></i>
                                    <b>Улица: </b><?php echo $n->ulica_nekretnina; ?>
                                </li>
                                <li>
                                    <i class='fa fa-long-arrow-right' aria-hidden='true'></i>
                                    <b>Број соба: </b><?php echo $n->broj_soba_nekretnina; ?>
                                </li>
                                <li>
                                    <i class='fa fa-long-arrow-right' aria-hidden='true'></i>
                                    <b>Квадратура стана: </b><?php echo $n->kvadratura_nekretnina; ?>m<sup>2</sup>
                                </li>
                                <li>
                                    <i class='fa fa-long-arrow-right' aria-hidden='true'></i>
                                    <b>Опис: </b><?php echo $n->opis_nekretnina; ?>
                                </li>
                                <li><i class='fa fa-long-arrow-right' aria-hidden='true'></i>
                                    <b>Цена: </b>€ <?php echo $n->cena_nekretnina;?> </li>
                                <li>
                                    <i class='fa fa-long-arrow-right' aria-hidden='true'></i>
                                    <b>
                                        <?php echo anchor(base_url()."Nekretnine/detaljnije/".$n->id_nekretnina, 'Више');?>
                                    </b>
                                </li>
                            </ol>
                        </div>
                    <?php endforeach; ?>
                <script type="text/javascript">
                    $(window).load(function() {
                        $("#flexiselDemo3").flexisel({
                            visibleItems:1,
                            animationSpeed: 1000,
                            autoPlay: true,
                            autoPlaySpeed: 5000,    		
                            pauseOnHover: true,
                            enableResponsiveBreakpoints: true,
                            responsiveBreakpoints: { 
                                portrait: { 
                                    changePoint:480,
                                    visibleItems:1
                                }, 
                                landscape: { 
                                    changePoint:640,
                                    visibleItems:1
                                },
                                tablet: { 
                                    changePoint:768,
                                    visibleItems:1
                                }
                            }
                        });
                        
                    });
                </script>
                <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.flexisel.js"></script>
            <!--</div>   
        </div>
        <!-- //slider --
    </div> -->
    <!-- //properties-list -->
        
    <!-- clients -->
<!--    <div class="w3-our-clients">
        <div class="container">
            <h3>Наша сарадња</h3>		
            <div id="owl-demo" class="owl-carousel text-center">
                <?php 
//                    foreach ($saradnici as $s):
//                        $saradnici_attributes = array(
//                            'class' => 'client-logo'
//                        );
//                        $saradnici_img = array(
//                            'src' => $s->logo_saradnika,
//                            'alt' => $s->naziv_saradnika
//                        );
//                        echo "<div class='item'>";
//                        echo anchor($s->link_saradnika, img($saradnici_img), $saradnici_attributes);
//                        echo "</div>";
//                    endforeach;
                ?>
                
            </div>
        </div>
    </div> -->
    <!-- //clients -->
        
</div>
<!-- //main-content -->