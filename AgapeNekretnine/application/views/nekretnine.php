<!-- breadcrumbs -->
<div class="w3ls-inner-banner">
    <div class="container">
        <h2>Некретнине</h2>
        <label></label>
        <div class="clearfix"></div>
    </div>
</div>
<!-- //breadcrumbs -->
    
<!-- main-content -->
<div class="main-content">
    <!-- gallery -->
    <div class="gallery" id="gallery">
        <div class="container">
            <div class="gallery_gds">
                <h3 style="text-align: center"></h3>
                    <form method="POST" style="margin-bottom: 25px; margin-top: 25px">
                    <?php echo $ddlTip; ?>
                    <?php echo $ddlKategorija; ?>
                    <?php //echo $ddlGrad; ?>
                    <input type="submit" class='form-control' name="btnFilter" id="btnFilter" value="Примени филтер" style='width:200px; margin-left: 40px; margin-right:40px; margin-bottom:20px; margin-top: 15px; display: inline'/>
                </form>
                <!--                <ul class="simplefilter">
                                    <li class="active" data-filter="all">Све</li>
                                        
                    <?php foreach ($tip_nekretnine as $tip): ?>
                                    <li data-filter="<?php echo $tip->id_tip_nekretnina; ?>"><?php echo $tip->naziv_tip_nekretnina;?></li>
                    <?php endforeach;?>
                        
                                </ul>   -->
                <div class="filtr-container " style="padding: 0px; position: relative; height: 858px;">
                    
                    <?php foreach ($nekretnine as $n): ?>
                        
                    <div class="col-md-4 col-ms-6 jm-item first filtr-item" data-category="<?php echo $n->id_tip_nekretnina;?>" data-sort="Busy streets" style="opacity: 1; transform: scale(1) translate3d(0px, 0px, 0px); backface-visibility: hidden; perspective: 1000px; transform-style: preserve-3d; position: absolute; transition: all 0.5s ease-out 0ms; height: 375px">
                        <div class="jm-item-wrapper">
                            <div class="jm-item-image">
                                <?php 
                                    $slikaNekretnine = array(
                                        'src' => $n->putanja_slika_nekretnina,
                                        'alt' => $n->naziv_slika_nekretnina,
                                        'style' => ' width: 60%'
                                    );
                                ?>
                                <?php echo img($slikaNekretnine);?>
                                <span class="jm-item-overlay"> </span>
                                <div class="jm-item-button"><?php echo anchor(base_url()."Nekretnine/detaljnije/".$n->id_nekretnina, 'Детаљније');?></div>
                            </div>	
                            <div class="jm-item-title">€ <?php echo $n->cena_nekretnina; ?></div>
                            <?php $dateljiLink = array( 'class' => 'agile-its-property-title');?>
                            <?php echo anchor(base_url()."Nekretnine/detaljnije/".$n->id_nekretnina, $n->ulica_nekretnina.", ".$n->naziv_deo_grada.", ".$n->naziv_grada.", ".$n->kvadratura_nekretnina."<small style='text-transform:lowercase'>m</small><sup>2</sup>", $dateljiLink);?>
                            <p class="w3ls-p-text"><?php //echo $n->opis_nekretnina;?></p>
                        </div>
                    </div>
                    <?php endforeach;?>
                        
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>	
    </div>
    <!--//gallery-->
</div>
<!-- //main-content -->