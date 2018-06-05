<!-- breadcrumbs -->
<div class="w3ls-inner-banner">
    <div class="container">
        <h2>Некретнина додај</h2>
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
                    <h3 style="text-align: center">Додај нову некретнину:</h3>
                        <?php echo @$obavestenje; ?>
                    <?php echo @$bla; ?>
                        <?php echo form_open_multipart('admin/AdminNekretnine/dodaj', $forma_podaci); ?>
<!--                        <fieldset class="fieldset">-->
                            <table class="table center-block tabela">
                                
                                <tr>
                                    <td>Тип некретнине:</td>
                                    <td>
                                        <?php echo $ddlTip;?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Категорија некретнине:</td>
                                    <td>
                                        <?php echo $ddlKategorija;?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Улица:</td>
                                    <td><?php echo form_input($form_ulica_nekretnine);?></td>
                                </tr>
                                <tr>
                                    <td>Град:</td>
                                    <td>
                                        <?php echo $ddlGrad;?>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>Опис:</td>
                                    <td>
                                        <?php echo form_textarea($form_opis_nekretnine);?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Спратност:</td>
                                    <td>
                                        <?php echo form_input($form_spratnost_nekretnine);?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Број соба:</td>
                                    <td>
                                        <?php echo form_input($form_broj_soba_nekretnine);?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Грејање:</td>
                                    <td>
                                        <?php echo form_input($form_grejanje_nekretnine);?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Квадратура:</td>
                                    <td>
                                        <?php echo form_input($form_kvadratura_nekretnine);?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Цена:</td>
                                    <td>
                                        <?php echo form_input($form_cena_nekretnine);?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Топ понуда:</td>
                                    <td>
                                        <?php echo form_checkbox('chbTop', 1);?> Почетна станица
                                    </td>
                                </tr>
                                <tr>
                                    <td>Подразумевајућа слика:</td>
                                    <td>
                                        <?php if(isset($podrazumevana_slika)):?>
                                        <?php echo form_checkbox(array('name'=>'chbDefault', 'id'=>'chbDefault'), 1, $podrazumevana_slika);?>
                                        <?php else:?>
                                        <?php echo form_checkbox(array('name'=>'chbDefault', 'id'=>'chbDefault'), 1, true);?>
                                        <?php endif;?>
                                    </td>
                                </tr>
                                <tr id="glavna_slika" class="hidden">
                                    <td>Главна слика:</td>
                                    <td>
                                        <?php echo form_upload($form_glavna_slika_nekretnine);?>
                                    </td>
                                </tr>
                                <tr id="slike" class="hidden">
                                    <td>Слика:</td>
                                    <td>
                                        <?php echo form_input($form_dodaj_jos_sliku); ?>
                                        <?php //echo form_upload($form_glavna_slika_nekretnine);?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Агент:</td>
                                    <td>
                                        <?php echo $ddlAgenti;?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Име власника:</td>
                                    <td>
                                        <?php echo form_input($form_ime_vlasnika);?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Презиме власника:</td>
                                    <td>
                                        <?php echo form_input($form_prezima_vlasnika);?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Телефон власника:</td>
                                    <td>
                                        <?php echo form_input($form_telefon_vlasnika);?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="submit"><?php echo form_submit($form_dodaj_submit);?></td>
                                </tr>
                                    
                            </table>
<!--                        </fieldset>-->
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- //blogs -->
</div>
</div>
<!-- //main-content -->
