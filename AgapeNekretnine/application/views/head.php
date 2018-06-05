<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $podaci_preduzeca[0]->naziv_firme.", ".$podaci_preduzeca[0]->registracija_firme.", ".$podaci_preduzeca[0]->grad_firme." | ".$title?></title>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>images/icon.png" type="image/x-icon" />
        <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" /><!-- Bootstrap stylesheet -->
        <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css" media="all" /><!-- stylesheet -->
        <link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all" /><!-- fontawesome -->
        <link href="<?php echo base_url(); ?>css/portBox.css" rel="stylesheet" type="text/css"/>
        <?php if($title ==  'Галерија'): ?>
            <link href="<?php echo base_url(); ?>css/lightbox.css" rel="stylesheet" type="text/css"/>
        <?php endif; ?>
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
         <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script><!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="<?php echo base_url(); ?>js/portBox.min.js" type="text/javascript"></script> 
        <script src="<?php echo base_url(); ?>js/js.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/numscroller-1.0.js"></script>
        <!-- Include jQuery & Filterizr -->
        <?php if($title ==  'Галерија'): ?>
            <script src="<?php echo base_url(); ?>js/lightbox.min.js" type="text/javascript"></script>
        <?php endif; ?>
        <?php if($title ==  'Некретнине'): ?>
        <script src="<?php echo base_url(); ?>js/jquery.filterizr.js"></script>
        <script src="<?php echo base_url(); ?>js/controls.js"></script>
            
        <!-- Kick off Filterizr -->
        
        <script type="text/javascript">
            $(function() {
                //Initialize filterizr with default options
                $('.filtr-container').filterizr();
            });
        </script>
        <?php endif; ?>
        <!-- here stars scrolling icon -->
        <script type="text/javascript">
            $(document).ready(function() {
                /*
                                var defaults = {
                                containerID: 'toTop', // fading element id
                                containerHoverID: 'toTopHover', // fading element hover id
                                scrollSpeed: 1200,
                                easingType: 'linear' 
                                };
                 */
                
                $().UItoTop({ easingType: 'easeOutQuart' });
                
            });
        </script>
        <!-- start-smoth-scrolling -->
        <script type="text/javascript" src="<?php echo base_url(); ?>js/move-top.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/easing.js"></script>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $(".scroll").click(function(event){		
                    event.preventDefault();
                    $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
                });
            });
        </script>
        <!-- start-smoth-scrolling -->
        <!-- //here ends scrolling icon -->
        <script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js'></script>
        
    </head>