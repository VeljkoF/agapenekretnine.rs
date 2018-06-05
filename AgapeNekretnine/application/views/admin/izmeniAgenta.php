<!-- breadcrumbs -->
<div class="w3ls-inner-banner">
    <div class="container">
        <h2>Агенти измени</h2>
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
                    <p><a href="<?php echo base_url()?>admin/AdminAgenti">Назад</a></p>
                    <?php foreach ($agenti as $a):?>
                    <h3 style="text-align: center">Измените агента <?php echo $a->ime_agenta." ". $a->prezime_agenta; ?>:</h3>
                        <?php echo @$obavestenje; ?>
                        <?php echo form_open_multipart('admin/AdminAgenti/izmeni/'.$a->id_agenta, $forma_podaci); ?>
                        <fieldset class="fieldset">
                            <table class="table center-block tabela">
                                
                                <tr>
                                    <td>Име агента:</td>
                                    <td><?php echo form_input($form_ime_agenta);?></td>
                                </tr>
                                <tr>
                                    <td>Презиме агента:</td>
                                    <td><?php echo form_input($form_prezime_agenta);?></td>
                                </tr>
                                <tr>
                                    <td>Телефон агента:</td>
                                    <td><?php echo form_input($form_telefon_agenta);?></td>
                                </tr>
<!--                                <tr>
                                    <td>Mail агента:</td>
                                    <td><?php //echo form_input($form_mail_agenta);?></td>
                                </tr>-->
                                <tr>
                                    <td>Слика агента:</td>
                                    <td>
                                        <?php echo form_upload($form_slika_agenta);?>
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
