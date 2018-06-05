<!-- breadcrumbs -->
<div class="w3ls-inner-banner">
    <div class="container">
        <h2>Админ некретнине</h2>
        <label></label>
        <div class="clearfix"></div>
    </div>
</div>
<!-- //breadcrumbs -->
    
<!-- main-content -->
<div class="main-content">
    <!-- gallery -->
    <div class="gallery" id="gallery">
        <div class="container" style="width: auto">
            <div class="blog">
                <div class="single-inline">
                    <h3 style="text-align: center"></h3>
                    <form method="POST" style="margin-bottom: 25px; margin-top: 25px">
                    <?php echo $ddlTip; ?>
                    <?php echo $ddlKategorija; ?>
                    <?php echo $ddlGrad; ?>
                    <input type="submit" class='form-control' name="btnFilter" id="btnFilter" value="Примени филтер" style='width:200px; margin-left: 40px; margin-right:40px; margin-bottom:20px; margin-top: 15px; display: inline'/>
                </form>
                <p class='form-control' style="display: inline; width: 200px"><?php echo anchor('admin/AdminNekretnine/dodaj', 'Додај некретнину');?></p>
                <p class='form-control' style="display: inline"><?php echo anchor('admin/AdminNekretnine/dodajKategoriju', 'Додај категорију');?></p>
                <p class='form-control' style="display: inline"><?php echo anchor('admin/AdminNekretnine/dodajGrad', 'Додај град');?></p>
                <p class='form-control' style="display: inline"><?php echo anchor('admin/AdminNekretnine/dodajDeoGrad', 'Додај део град');?></p>
                   
                    <?php $formLista = array('accept-charset' => 'utf-8'); ?>
                    <?php echo form_open_multipart('nekretnine/uid', $formLista )?>
                    <table class='table center-block center-block2' border='1'>
                        <tr>
                            <th>Улица</th>
                            <th>Спратност</th>
                            <th>Број соба</th>
                            <th>Грејање</th>
                            <th>Квадратура</th>
                            <th>Цена</th>
                            <th>Топ понуда</th>
                            <th>Слика</th>
                            <th>Агент</th>
                            <th>Име и презиме власника</th>
                            <th>Телефон власника</th>
                            <th>Измени / Обриши</th>
                        </tr>
                            
                            <?php foreach ($nekretnine as $n): ?>
                        <tr>
                            <td><?php echo $n->ulica_nekretnina?></td>
                            <td><?php echo $n->spratnost_nekretnina?></td>
                            <td><?php echo $n->broj_soba_nekretnina?></td>
                            <td><?php echo $n->grejanje_nekretnina?></td>
                            <td><?php echo $n->kvadratura_nekretnina?></td>
                            <td><?php echo $n->cena_nekretnina?></td>
                                
                            <td><input type='checkbox' name='chbTop' disabled id='chbTop' value='1' <?php echo ($n->top_ponuda == 1 ? "checked/></td>" : "/></td>");?>
                                    <?php 
                                        $listaNekretnineImg = array(
                                            'src' => $n->putanja_slika_nekretnina,
                                            'alt' => $n->naziv_slika_nekretnina,
                                            'height' => '5%'
                                                
                                        );
                                    ?>
                            <td><?php echo anchor('admin/AdminNekretnine/dodajSlike/'.$n->id_nekretnina, 'Додај нове слике ');?><br/><br/><?php echo img($listaNekretnineImg); ?></td>
                            <td><?php echo $n->ime_agenta." ".$n->prezime_agenta?></td>
                            <td><?php echo $n->ime_vlasnika." ".$n->prezime_vlasnika?></td>
                            <td><?php echo $n->telefon_vlasnika?></td>
                            <td>
                                        <?php echo anchor('admin/AdminNekretnine/izmeni/'.$n->id_nekretnina, 'Измени ');?>
                                /
                                        <?php echo anchor('admin/AdminNekretnine/obrisi/'.$n->id_nekretnina, ' Обриши');?>
                            </td>
                        </tr>
                            <?php endforeach; ?>
                                
                    </table>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>	
    </div>
    <!--//gallery-->
</div>