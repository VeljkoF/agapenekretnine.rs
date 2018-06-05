<!-- breadcrumbs -->
<div class="w3ls-inner-banner">
    <div class="container">
        <h2>Мени Измени</h2>
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
                    <p><a href="<?php echo base_url()?>admin/AdminMeni">Назад</a></p>
                    <h3 style="text-align: center">Измена права корисника:</h3>
                    <?php echo @$obavestenje; ?>
                    <?php foreach($rezMeni as $n) :?>
                        <?php echo form_open('admin/AdminMeni/izmeni/'.$n->id_meni, $forma_podaci); ?>
                            <fieldset class="fieldset">
                                <table class="table center-block center-block2">
                                    <tr>
                                        <td>Назив</td>
                                        <td><?php echo form_input($form_naziv);?></td>
                                    </tr>
                                    <tr>
                                        <td>Права корисника</td>
                                        <td>
                                            <select name="ddlMeni">
                                                <?php if(isset($uneti_podaci)):?>
                                                    <?php if($uneti_podaci['ddlMeni'] == 1):?>
                                                        <option value=0>НЕ</option>
                                                        <option value=1 selected="true">ДА</option>
                                                    <?php elseif($uneti_podaci['ddlMeni'] == 0): ?>
                                                        <option value=0 selected="true">НЕ</option>
                                                        <option value=1>ДА</option>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <?php if($n->korisnik == 1):?>
                                                    <option value=0>НЕ</option>
                                                    <option value=1 selected="true">ДА</option>
                                                <?php elseif($n->korisnik == 0): ?>
                                                    <option value=0 selected="true">НЕ</option>
                                                    <option value=1>ДА</option>
                                                <?php endif; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="submit"><?php echo form_submit($form_izmeni_submit);?></td>
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
