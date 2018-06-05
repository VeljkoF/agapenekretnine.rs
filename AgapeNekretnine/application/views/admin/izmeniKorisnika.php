<!-- breadcrumbs -->
<div class="w3ls-inner-banner">
    <div class="container">
        <h2>Korisnici izmeni</h2>
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
                    <p><a href="<?php echo base_url()?>admin/AdminKorisnici">Назад</a></p>
                    <?php foreach ($korisnici as $k):?>
                    <h3 style="text-align: center">Izmena korisnika <?php echo $k->korisnicko_ime; ?>:</h3>
                        <?php echo @$obavestenje; ?>
                        <?php echo form_open('admin/AdminKorisnici/izmeni/'.$k->id_korisnik, $forma_podaci); ?>
                    
                        <fieldset class="fieldset">
                            <table class="table center-block tabela">
                                
                                <tr>
                                    <td>Ime korisnika:</td>
                                    <td><?php echo form_input($form_ime_korisnika);?></td>
                                </tr>
                                <tr>
                                    <td>Prezime korisnika:</td>
                                    <td><?php echo form_input($form_prezime_korisnika);?></td>
                                </tr>
                                <tr>
                                    <td>Korisničko ime:</td>
                                    <td><?php echo form_input($form_korisnicko_ime);?></td>
                                </tr>
                                <tr>
                                    <td>Lozinka:</td>
                                    <td><?php echo form_password($form_lozinka);?></td>
                                </tr>
                                <tr>
                                    <td>Ponovite lozinku:</td>
                                    <td><?php echo form_password($form_ponovo_lozinka);?></td>
                                </tr>
<!--                                <tr>
                                    <td>Telefon korisnika:</td>
                                    <td><?php //echo form_input($form_telefon_korisnika);?></td>
                                </tr>
                                <tr>
                                    <td>Mail korisnika:</td>
                                    <td><?php //echo form_input($form_mail_korisnika);?></td>
                                </tr>-->
                                </tr>
                                <tr>
                                    <td>Улога:</td>
                                    <td>
                                        <select name='ddlUloga'>
                                            <option value=0>Изабери...</option>
                                            <?php foreach($uloga as $u):?>
                                              <?php if($k->id_uloge == $u->id_uloge):?>
                                            <option value=<?php echo $u->id_uloge; ?> selected='selected'><?php echo $u->naziv_uloge?></option>  
                                            <?php else: ?>
                                              <option value=<?php echo $u->id_uloge; ?>><?php echo $u->naziv_uloge?></option>  
                                              <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="submit"><?php echo form_submit($form_dodaj_submit);?></td>
                                </tr>
                                    
                            </table>
                        </fieldset>
                    <?php echo form_close(); ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- //blogs -->
</div>
</div>
<!-- //main-content -->
