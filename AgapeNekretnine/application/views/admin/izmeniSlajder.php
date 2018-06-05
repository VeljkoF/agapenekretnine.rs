<!-- breadcrumbs -->
<div class="w3ls-inner-banner">
    <div class="container">
        <h2>Слајдер измени</h2>
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
                    <p><a href="<?php echo base_url()?>admin/AdminSlajder">Назад</a></p>
                    <?php foreach ($slajder as $s):?>
                    <h3 style="text-align: center">Додајте слику у слајдер:</h3>
                        <?php echo @$obavestenje; ?>
                        <?php echo form_open_multipart('admin/AdminSlajder/izmeni/'.$s->id_slajder, $forma_podaci); ?>
                        <fieldset class="fieldset">
                            <table class="table center-block tabela">
                                
                                <tr>
                                    <td>Наслов:</td>
                                    <td><?php echo form_input($form_naslov_slajder);?></td>
                                </tr>
                                <tr>
                                    <td>Опис:</td>
                                    <td><?php echo form_input($form_opis_slajder);?></td>
                                </tr>
                                <tr>
                                    <td>Слика:</td>
                                    <td>
                                        <?php echo form_upload($form_slika_slajder);?>
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
