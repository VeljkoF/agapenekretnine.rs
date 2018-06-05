<!-- breadcrumbs -->
<div class="w3ls-inner-banner">
    <div class="container">
        <h2>Градови некретнине</h2>
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
                    <h3 style="text-align: center">Додај нови град: </h3>
                        <?php echo @$obavestenje; ?>
                    <?php echo @$bla; ?>
                        <?php echo form_open_multipart('admin/AdminNekretnine/dodajGrad/', $forma_podaci); ?>
                        <fieldset class="fieldset">
                            <table class="table center-block tabela">
                                
                                <tr>
                                    <td>Назив града:</td>
                                    <td>
                                        <?php echo form_input($form_grad); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="submit"><?php echo form_submit($form_dodaj_submit);?></td>
                                </tr>
                                    
                            </table>
                        </fieldset>
                    <?php echo form_close(); ?>
                    <div id="prikaz">
                        <?php
                            if(isset($tabela)):
                                echo $tabela;
                            else:
                                echo 'greska';
                            endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //blogs -->
</div>
</div>
<!-- //main-content -->
