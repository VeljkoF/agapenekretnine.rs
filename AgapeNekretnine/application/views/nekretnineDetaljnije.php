<!-- breadcrumbs -->
<div class="w3ls-inner-banner">
    <div class="container">
        <h2>Некретнине детаљи</h2>
        <label></label>
        <div class="clearfix"></div>
    </div>
</div>
<!-- //breadcrumbs -->
            
<!-- main-content -->
<div class="main-content">
    <!-- property-details -->
    <div class="agileits-property-details">
        <div class="container">
            <div class="col-md-6 w3ls-property-images">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class='carousel-indicators'>
                    <?php for ($i=0; $i< count($slikaNekretnine); $i++):?>
                        <li data-target='#carousel-example-generic' data-slide-to='<?php echo $i?>'></li>
                    <?php endfor;?>
                    </ol>
                    <!-- Wrapper for slides -->
                    <div class='carousel-inner'>
                        <?php foreach ($slikaNekretnine as  $s):?>
                            <?php if($s->front_slika):?>
                                <div class='item active'>
                                    <img class='img-responsive br' src='<?php echo base_url().$s->putanja_slika_nekretnina;?>' alt='<?php echo $s->naziv_slika_nekretnina;?>' />
                                </div>
                            
                            <?php else :?>
                                <div class='item'>
                                    <img class='img-responsive br' src='<?php echo base_url().$s->putanja_slika_nekretnina;?>' alt='<?php echo $s->naziv_slika_nekretnina;?>' />
                                </div>
                            <?php endif;?>
                        <?php endforeach;?>
                    </div>
                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                </div>
            </div>
        <div class="col-md-6 ins-details">
            <?php foreach ($nekretnine as $n):?>
                <div class='ins-name'>
                    <h3><?php echo $n->naziv_tip_nekretnina?>, <?php echo $n->naziv_kategorije?></h3>
                    <br>
                    <h4><?php echo $n->ulica_nekretnina.", ".$n->naziv_deo_grada.", ".$n->naziv_grada;?></h4>
                    <h6>Цена: €<?php echo $n->cena_nekretnina?></h6>
                    <p><?php echo $n->opis_nekretnina?></p>
                </div>
                <div class='span span2'>
                    <p class='left'>Спратност: </p>
                    <p class='right'>: <?php echo $n->spratnost_nekretnina?></p>
                    <div class='clearfix'></div>
                </div>
                <div class='span span1'>
                    <p class='left'>Број соба: </p>
                    <p class='right'>: <?php echo $n->broj_soba_nekretnina?></p>
                    <div class='clearfix'></div>
                </div>
                <div class='span span2'>
                    <p class='left'>Грејање: </p>
                    <p class='right'>: <?php echo $n->grejanje_nekretnina?></p>
                    <div class='clearfix'></div>
                </div>
                <div class='span span1'>
                    <p class='left'>Квадратура стана:</p>
                    <p class='right'>:<?php echo $n->kvadratura_nekretnina?>m<sup>2</sup></p>
                    <div class='clearfix'></div>
                </div>
<!--                <div class='span span1'>
                    <p class='left'>Kvadratura stana</p>
                    <p class='right'>:<?php echo $n->kvadratura_nekretnina?>m<sup>2</sup></p>
                    <div class='clearfix'></div>
                </div>-->
                <div class='span span1'>
                    <p class='left'>Контакт особа:</p>
                    <p class='right'>:<?php echo $n->ime_agenta." ".$n->prezime_agenta;?></p>
                    <div class='clearfix'></div>
                </div>
                <div class='span span2'>
                    <p class='left'>Телефон:</p>
                    <p class='right'>:<?php echo $n->telefon_agenta;?></p>
                    <div class='clearfix'></div>
                </div>
            <?php endforeach;?>
        </div>
        <div class="clearfix"></div>			
    </div>
</div>
<!-- property-details -->

</div>
<!-- //main-content -->