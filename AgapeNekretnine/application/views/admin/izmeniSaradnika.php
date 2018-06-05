<!-- breadcrumbs -->
<div class="w3ls-inner-banner">
    <div class="container">
        <h2>Сарадници измени</h2>
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
                    <?php foreach ($saradnici as $s):?>
                    <h3 style="text-align: center">Измените сарадника <?php echo $s->naziv_saradnika;?>:</h3>
                    <?php echo @$obavestenje; ?>
                    <?php echo form_open_multipart('admin/AdminSaradnici/izmeni/'.$s->id_saradnika, $forma_saradnici); ?>
                    <fieldset class='fieldset'>
                        <table class='table center-block tabela'>
                            <tr>
                                <td>Назив сарадника:</td>
                                <td>
                                    <?php echo form_input($form_naziv_saradnika);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Опис сарадника:</td>
                                <td>
                                    <?php echo form_input($form_opis_saradnika);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Нова слика сарадника:</td>
                                <td>
                                    <?php echo form_upload($form_nova_slika_saradnika);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Web сајт:</td>
                                <td>
                                    <?php echo form_input($form_web_sajt);?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2' class='submit'>
                                    <?php echo form_submit($form_izmeni_submit);?>
                                </td>
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
