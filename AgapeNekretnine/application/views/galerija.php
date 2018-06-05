<!-- breadcrumbs -->
<div class="w3ls-inner-banner">
    <div class="container">
        <h2>Galerija</h2>
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
                <div class="filtr-container " style="padding: 0px; position: relative; height: auto;">
                    
                    <div class='navigator centar'>
                        <?php echo $paginacija; ?>
                    </div>      
                    <?php for($i=0;$i<count($slike);$i++): ?>
                    <div class='col-md-4 col-ms-6 jm-item first filtr-item' data-category='<?php echo $slike[$i]->id_slika_nekretnina; ?>' data-sort='Busy streets'>
                         <div class='jm-item-wrapper'>
                            <div class='jm-item-image'>
                                <div class='gslika'>
                                    <?php 
                                        $galerijaLink = array(
                                        'href' => $slike[$i]->putanja_slika_nekretnina, 
                                        'data-lightbox' => 'galerija', 
                                        'data-title' => $slike[$i]->naziv_slika_nekretnina
                                        );
                                    ?>
                                    <?php 
                                        $galerijaImg = array(
                                            'src' =>$slike[$i]->putanja_slika_nekretnina,
                                            'alt' =>$slike[$i]->naziv_slika_nekretnina
                                        );
                                    ?>
                                    <?php echo anchor($slike[$i]->putanja_slika_nekretnina, img($galerijaImg), $galerijaLink);?>
                                </div>	

                            </div>
                        </div>
                    </div>
                    <?php endfor; ?>  
                </div>
                <div class='cisti'></div>
                <div id='prikaz2' class='centar'></div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>	
</div>
<!--//gallery-->
<!-- //main-content -->