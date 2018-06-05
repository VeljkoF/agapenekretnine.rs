<!-- breadcrumbs -->
<div class="w3ls-inner-banner">
    <div class="container">
        <h2>Сарадници додај</h2>
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
                    <p><a href="<?php echo base_url()?>admin/AdminSaradnici">Назад</a></p>
                    <h3 style="text-align: center">Додајте сарадника:</h3>
                        <?php echo @$obavestenje; ?>
                        <?php echo form_open_multipart('admin/AdminSaradnici/dodaj', $forma_podaci); ?>
                        <fieldset class="fieldset">
                            <table class="table center-block tabela">
                                
                                <tr>
                                    <td>Назив сарадника:</td>
                                    <td><?php echo form_input($form_naziv_saradnika);?></td>
                                </tr>
                                <tr>
                                    <td>Опис сарадника:</td>
                                    <td><?php echo form_input($form_opis_saradnika);?></td>
                                </tr>
                                <tr>
                                    <td>Web сајт:</td>
                                    <td><?php echo form_input($form_link_saradnika);?></td>
                                </tr>
                                </tr>
                                <tr>
                                    <td>Слика сарадника:</td>
                                    <td>
                                        <?php echo form_upload($form_slika_saradnika);?>
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
