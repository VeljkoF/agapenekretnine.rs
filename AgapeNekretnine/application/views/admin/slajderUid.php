<!-- breadcrumbs -->
<div class="w3ls-inner-banner">
    <div class="container">
        <h2>Админ слајдер</h2>
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
                    <h3 style="text-align: center">Измените слајдер:</h3>
                    <p><?php echo anchor('admin/AdminSlajder/dodaj', 'Додај нову слику у слајдер');?></p>
                    <div id="prikaz">
                        <?php
                            if(isset($tabela)):
                                echo $tabela;
                            else:
                                echo $obavestenje;
                            endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //blogs -->
</div>
<script type="text/javascript">
    $(document).ready(function(){
            
        $(document).on('click', '.obrisiSlajder', function(e){
            e.preventDefault();
            var id = $(this).data('id'); 

            $.ajax({
               type: 'GET',
               url: '<?php echo base_url(); ?>admin/AdminSlajder/obrisi/' + id,
               data: {poslato: true},
               success: function(podaci){
                            document.getElementById('prikaz').innerHTML = podaci;
                        }
            });
        });
    });
</script>
</div>
<!-- //main-content -->