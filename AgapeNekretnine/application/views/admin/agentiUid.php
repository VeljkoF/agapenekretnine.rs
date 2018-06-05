<!-- breadcrumbs -->
<div class="w3ls-inner-banner">
    <div class="container">
        <h2>Агенти преглед</h2>
        <label></label>
        <div class="clearfix"></div>
    </div>
</div>
<!-- //breadcrumbs --><!-- main-content -->
<div class="main-content">
    <!-- OUR AGENTS -->
    <section class="team-w3ls">
        <div class="container">
            <div class="single-inline">
                <h3 style="text-align: center">Списак агента:</h3>
                <p><?php echo anchor('admin/AdminAgenti/dodaj', 'Додај новог агента');?></p>
                
                <?php foreach ($agenti as $agent): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 w3-agent">
                        <div class="hovereffect">
                            <?php $agentList = array('class'=>'img-responsive', 'src' => $agent->slika_agenta, 'alt' => $agent->ime_agenta." ".$agent->prezime_agenta);?>
                            <?php echo img($agentList);?>
                            <div class="overlay">
                                <h4><?php echo $agent->ime_agenta?></h4>
                                <p> 
                                    <a href="#" data-toggle="modal" data-target="#agent<?php echo $agent->id_agenta?>">Детаљи</a><br><br>
                                    <?php echo anchor('admin/AdminAgenti/izmeni/'.$agent->id_agenta, 'Измени ');?><br><br>
                                    <?php echo anchor('admin/AdminAgenti/obrisi/'.$agent->id_agenta, 'Обриши ', array('class' => 'obrisiAgenta','data-id' => $agent->id_agenta));?>
                                    
                                </p> 
                            </div>
                        </div>
                    </div>					
                <?php endforeach;?>     
                
                	
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
    <?php foreach ($agenti as $agent): ?>
        <!-- modal-for agent<?php echo $agent->id_agenta;?>-details -->
        <div class="modal fade modal-about" id="agent<?php echo $agent->id_agenta?>" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content"> 
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">О МЕНИ</h4>
                    </div>
                    <div class="modal-body modal-spa">
                        <div class="w3layouts-about"> 
                            <div class="col-md-4 about-left ">
                                <?php $agentLista = array('class'=>'img-responsive', 'src' => $agent->slika_agenta, 'alt' => $agent->ime_agenta." ".$agent->prezime_agenta);?>
                                <?php echo img($agentLista);?>
                            </div>
                            <div class="col-md-8 about-right wthree">
                                <h3>Поздрав, зовем се <span><?php echo $agent->ime_agenta." ".$agent->prezime_agenta;?></span></h3>
                                <h4></h4>
                                <ul class="address">									
                                    <li>
                                        <ul class="agileits-address-text">
                                            <li><b>Телефон: </b></li>
                                            <li><?php echo $agent->telefon_agenta?></li>
                                        </ul>
                                    </li>
<!--                                    <li>
                                        <ul class="agileits-address-text">
                                            <li><b>Mail: </b></li>
                                            <li><?php //echo anchor($agent->mail_agenta, $agent->mail_agenta);?></li>
                                        </ul>
                                    </li>-->
                                </ul> 
                            </div> 
                            <div class="clearfix"> </div> 
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <!-- //modal-for agent<?php echo $agent->id_agenta;?>-details -->
    <?php endforeach; ?>
    <!-- modal-for agent2-details -->
    <!-- //	OUR AGENTS -->
    
</div>
</div>
<!-- //main-content -->