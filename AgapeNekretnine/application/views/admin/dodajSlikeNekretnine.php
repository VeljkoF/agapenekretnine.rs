<!-- breadcrumbs -->
<div class="w3ls-inner-banner">
    <div class="container">
        <h2>Слика некретнине додај</h2>
        <label></label>
        <div class="clearfix"></div>
    </div>
</div>
<!-- //breadcrumbs -->
<!-- main-content -->
<div class="main-content">
    <!-- blogs -->
    <div class="agileits-blog-posts">
        <div class="container">
            <div class="blog">
                <div class="single-inline">
                    <p><a href="<?php echo base_url()?>admin/AdminNekretnine">Назад</a></p>
                    <h3 style="text-align: center">Додај нове слике: <br/><?php echo $nekretnine[0]->ulica_nekretnina.", ".$nekretnine[0]->naziv_deo_grada.", ".$nekretnine[0]->naziv_grada?></h3>
                        <?php echo @$obavestenje; ?>
                    <?php echo @$bla; ?>
                        <?php echo form_open_multipart('admin/AdminNekretnine/dodajSlike/'.$nekretnine[0]->id_nekretnina, $forma_podaci); ?>
                        <fieldset class="fieldset">
                            <table class="table center-block tabela">
                                
                                <tr>
                                    <td>Слика:</td>
                                    <td>
                                        <?php echo form_input($form_hidden_ulica_nekretnine); ?>
                                        <?php echo form_upload($form_glavna_slika_nekretnine);?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Слике:</td>
                                    <td>
                                        <?php echo form_input($form_dodaj_jos_sliku); ?>
                                        <?php //echo form_upload($form_glavna_slika_nekretnine);?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="submit"><?php echo form_submit($form_dodaj_submit);?></td>
                                </tr>
                                    
                            </table>
                        </fieldset>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- //blogs -->
</div>
</div>
<!-- //main-content -->
