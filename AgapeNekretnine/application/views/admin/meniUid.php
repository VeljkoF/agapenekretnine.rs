<!-- breadcrumbs -->
<div class="w3ls-inner-banner">
    <div class="container">
        <h2>Админ мени</h2>
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
                    <h3 style="text-align: center">Измените права корисника:</h3>
                    <div id="prikaz" style="width: 300px; margin:0px auto">
                        <table class="table center-block center-block2" border="1">
                            <tr>
                                <th>Назив</th>
                                <th>Права корисника</th>
                                <th>Измени</th>
                            </tr>

                            <?php foreach($rezZaMeni as $n) :?>
                            <tr>
                                <td><?php echo $n->naziv_meni; ?></td>
                                <td>
                                    <?php
                                        if($n->korisnik == 0):
                                            echo 'НЕ';
                                        else:
                                            echo 'ДА';
                                        endif;
                                    ?>
                                </td>
                                <td><?php echo anchor('admin/AdminMeni/izmeni/'.$n->id_meni, 'Измени'); ?></td>
                            </tr>
                            <?php endforeach; ?>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //blogs -->
</div>
</div>
<!-- //main-content -->