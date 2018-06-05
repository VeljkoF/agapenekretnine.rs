<!-- breadcrumbs -->
<div class="w3ls-inner-banner">
    <div class="container">
        <h2>Пдаци о фирми измени</h2>
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
                    <h3 style="text-align: center">Измените податке о фирми:</h3>
                    <?php echo @$obavestenje; ?>
                    <?php echo form_open('admin/AdminPodaciOFirmi', $forma_podaci); ?>
                    <fieldset class='fieldset'>
                        <table class='table center-block tabela'>
                            <tr>
                                <td>Назив фирме:</td>
                                <td>
                                    <?php echo form_input($form_naziv_firme);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Регистрација фирме:</td>
                                <td>
                                    <?php echo form_input($form_registracija_firme);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Регистаски број фирме:</td>
                                <td>
                                    <?php echo form_input($form_reg_broj);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Адреса фирме:</td>
                                <td>
                                    <?php echo form_input($form_adresa_firme);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Град фирме:</td>
                                <td>
                                    <?php echo form_input($form_grad_firme);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Земља фирме:</td>
                                <td>
                                    <?php echo form_input($form_zemlja_firme);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Телефон фирме:</td>
                                <td>
                                    <?php echo form_input($form_telefon_firme);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Радно време фирме:</td>
                                <td>
                                    <?php echo form_textarea($form_radno_vreme_firme);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Mail фирме:</td>
                                <td>
                                    <?php echo form_input($form_mail_firme);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Опис фирме:</td>
                                <td>
                                    <?php echo form_input($form_opis_firme);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Опис фирме дужи:</td>
                                <td>
                                    <?php echo form_textarea($form_opis_firme_duzi);?>
                                </td>
                            </tr>
                            <tr>
                                <td>Текст:</td>
                                <td>
                                    <?php echo form_textarea($form_tekst);?>
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
                </div>
            </div>
        </div>
    </div>
    <!-- //blogs -->
</div>
</div>
<!-- //main-content -->
