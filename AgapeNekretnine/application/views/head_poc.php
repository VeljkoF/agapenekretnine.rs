<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $podaci_preduzeca[0]->naziv_firme.", ".$podaci_preduzeca[0]->registracija_firme.", ".$podaci_preduzeca[0]->grad_firme." | ".$title?></title>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>images/icon.png" type="image/x-icon" />
        <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" /><!-- Bootstrap stylesheet -->
        <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css" media="all" /><!-- stylesheet -->
        <link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all" /><!-- fontawesome -->
        <link href="<?php echo base_url(); ?>css/portBox.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>css/stil.css" rel="stylesheet" type="text/css"/>
        <!-- meta tags -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="description" content="Agape agencija za nekretnine u Beogradu. Pruza prodaju i izdavanje nekretnina" />
        <meta name="keywords" content="Agape, agencija za nekretnine, nekretnine, nekretnina, Beograd, Агапе, некретнине, агенција за некретнине, некретнина, Београд" />
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <!-- //meta tags -->
        <!--fonts-->
        <link href="//fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <link href="//fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <!--//fonts-->	        
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-2.1.4.min.js"></script><!-- Required-js -->
        
        <!-- requried-jsfiles-for owl -->
        <link href="<?php echo base_url(); ?>css/owl.carousel.css" rel="stylesheet" type="text/css" media="all" />
        <script src="<?php echo base_url(); ?>js/owl.carousel.js"></script>
        <script>
            $(document).ready(function() {
                $("#owl-demo").owlCarousel({
                    items : 4,
                    lazyLoad : true,
                    autoPlay : true,
                    navigation : true,
                    navigationText :  true,
                    pagination : false,
                });
            });
        </script>
        <!-- //requried-jsfiles-for owl -->	
		
        <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script><!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="<?php echo base_url(); ?>js/jquery.superslides.js" type="text/javascript" charset="utf-8"></script><!-- banner-slider-js -->  
        <script src="<?php echo base_url(); ?>js/application.js"></script><!-- banner-slider-js -->    
        <script type="text/javascript" src="<?php echo base_url(); ?>js/numscroller-1.0.js"></script>
        <script src="<?php echo base_url(); ?>js/portBox.min.js" type="text/javascript"></script>
        <script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js'></script>
        <script src="<?php echo base_url(); ?>js/js.js" type="text/javascript"></script>
    </head>