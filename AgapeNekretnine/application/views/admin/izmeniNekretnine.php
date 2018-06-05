<!-- breadcrumbs -->
<div class="w3ls-inner-banner">
    <div class="container">
        <h2>Некретнине измени</h2>
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
                    <h3 style="text-align: center">Измените некретнину:</h3>
                    <?php echo @$obavestenje;?>
                    <?php echo form_open_multipart('admin/AdminNekretnine/izmeni/'.$nekretnine[0]->id_nekretnina, $forma_nekretnine); ?>
                    <fieldset class='fieldset'>
                        <table class='table center-block tabela'>
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
                            </tr>
                                        
                            <tr>
                                <td>Улица:</td>
                                <td>
                                        <?php echo form_input($form_nekretnine_ulica);?>
                                </td>
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
                                        <?php echo form_textarea($form_nekretnine_opis);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Спратност:</td>
                                <td>
                                        <?php echo form_input($form_nekretnine_spratnost);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Број соба:</td>
                                <td>
                                        <?php echo form_input($form_nekretnine_broj_soba);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Грејање:</td>
                                <td>
                                        <?php echo form_input($form_nekretnine_grejanje);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Квадратура:</td>
                                <td>
                                        <?php echo form_input($form_nekretnine_kvadratura);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Цена:</td>
                                <td>
                                        <?php echo form_input($form_nekretnine_cena);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Топ понуда:</td>
                                <td>
                                        <?php if($top == 1):?>
                                            <?php echo form_checkbox("chbTop", 1, array("checked" => TRUE));?> Почетна станица
                                        <?php else:?>
                                            <?php echo form_checkbox("chbTop", 1);?> Почетна станица
                                        <?php endif;?>
<!--                                        <input type='checkbox' name='chbTopPonuda' value='1' id='chbTopPonuda'".($red['top_ponuda'] == 1 ? "checked/> Početna stranica</td>" : "/> Početna stranica</td>");-->
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
                                        <?php echo form_input($form_prezime_vlasnika);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Телефон власника:</td>
                                <td>
                                        <?php echo form_input($form_telefon_vlasnika);?>
                                </td>
                            </tr>
                            <table class='table center-block tabela' >
                                <tr>
                                    <th>Главна слика</th>
                                    <th>Slika</th>
                                </tr>
                                    <?php if(isset($uneti_podaci)):?>
                                        <?php foreach ($slike_nekretnine as $s):?>
                                <tr>
                                    <td>
                                                    <?php if($uneti_podaci['slika_nekrenineF'] == $s->id_slika_nekretnina): ?>
                                                        <?php echo form_radio($form_nekretnine_radio, $s->id_slika_nekretnina, @$form_nekretnine_radio_checked );
                                                    else:
                                                        echo form_radio($form_nekretnine_radio, $s->id_slika_nekretnina);
                                                    endif;?>
                                    </td>
                                    <td>
                                                    <?php 
                                                        $slika = array(
                                                            'src' => $s->putanja_slika_nekretnina,
                                                            'alt' => $s->naziv_slika_nekretnina,
                                                            'height' => '10%'
                                                        );
                                                    ?>
                                                    <?php echo img($slika);?>
                                    </td>
                                </tr>
                                        <?php endforeach; ?>
                                    <?php else:?>
                                        <?php foreach ($slike_nekretnine as $s):?>
                                <tr>
                                    <td>
                                                    <?php if($s->front_slika == 1): ?>
                                                        <?php echo form_radio($form_nekretnine_radio, $s->id_slika_nekretnina, @$form_nekretnine_radio_checked );
                                                    else:
                                                        echo form_radio($form_nekretnine_radio, $s->id_slika_nekretnina);
                                                    endif;?>
                                    </td>
                                    <td>
                                                    <?php 
                                                        $slika = array(
                                                            'src' => $s->putanja_slika_nekretnina,
                                                            'alt' => $s->naziv_slika_nekretnina,
                                                            'height' => '10%'
                                                        );
                                                    ?>
                                                    <?php echo img($slika);?>
                                    </td>
                                </tr>
                                        <?php endforeach; ?>
                                            <?php endif;?>
                            </table>
                                    
                            <tr>
                                <td colspan='2' class='submit'>
                                    <input type='submit' class='right form-control'  style='width:100px; margin-right:40px; margin-bottom:20px;' name='btnIzmeni' id='btnIzmeni' value='Izmeni'/>
                                </td>
                            </tr>
                                    
                        </table>
                    </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- //blogs -->
</div>
</div>
<!-- //main-content -->