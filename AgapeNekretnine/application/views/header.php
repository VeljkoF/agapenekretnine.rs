<body>
    <?php 
        if(!empty($this->session->flashdata('obavestenje'))):
            $obav = $this->session->flashdata('obavestenje');
            echo "<script type='text/javascript'>alert('".$obav."');</script>";
        endif;
    ?>
    <!-- header -->
<!--    <script type='text/javascript'>alert("veljko");</script>-->
    <header>
        <div class="container">
            <!-- nav -->
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <div class="logo">
                            <h1><a href="<?php echo base_url(); ?>"><?php echo $podaci_preduzeca[0]->naziv_firme." ".$podaci_preduzeca[0]->opis_firme;?></a></h1>
                        </div>	
                    </div>
                                    
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <?php 
                                if(isset($meni)):
                                    foreach ($meni as $m):
                                        if(uri_string() == $m->putanja_meni || strtolower($title) == $m->putanja_meni):
                                            echo "<li class = 'active'>".anchor(base_url().$m->putanja_meni, $m->naziv_meni)."</li>";
                                        else :
                                            echo "<li>".anchor(base_url().$m->putanja_meni, $m->naziv_meni)."</li>";
                                        endif;
                                    endforeach;
                                    
                                    if(@$id_uloge != NULL):
                                        echo "<li>";
                                        echo "<a href='".base_url()."Logovanje/logout' '>ОДЈАВА</a>";
                                        echo "</li>";
                                    else:
                                        echo "<li>";
                                        echo "<a href='#' data-display='mySite' style='display:none;'>ПРИЈАВА</a>";
                                        echo "</li>";
                                    endif;
                                endif;
                            ?>
                        </ul>
                        <?php 
                            echo "<div id='mySite' class='portBox' style='display:none;'>";
                            echo "<form method='post' action='".base_url()."Logovanje/login'>";
                            echo "<table class='tablePrijava'>";
                            echo "<tr>";
                            echo "<td class='ispis'>Корисничко име: </td>";
                            echo "<td>";
                            echo "<input type='text' class='inputtag' name='tbKorisnickoImeLog' id='tbKorisnickoImeLog' required/>";
                            echo "</td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td class='ispis'>Лозинка:</td>";
                            echo "<td>";
                            echo "<input type='password' class='inputtag' name='tbLozinkaLog' id='tbLozinkaLog' required/>";
                            echo "</td>";
                            echo "</tr>";
                            echo "<tr class='prijavaRegistracija'>";
                            echo "<td colspan='2'>";
                            echo "<input type='submit' class='inputtagg' id='btnPrijavi' name='btnPrijavi' value='Пријава'/>";
                            echo "</td>";
                            echo "</tr>";
                            echo "</table>";
                            echo "</form>";					
                            echo "</div>";
                        ?>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container-fluid -->
            </nav> 
            <script src="<?php echo base_url(); ?>js/nav.js"></script><!-- nav-js --> 
            <!-- //nav -->
        </div>
    </header>
    <!-- //header -->