<!-- breadcrumbs -->
    <div class="w3ls-inner-banner">
        <div class="container">
            <h2>НАШ КОНТАКТ</h2>
            <label></label>
            <div class="clearfix"></div>
        </div>
    </div>
<!-- //breadcrumbs -->
<!-- main-content -->
    <div class="main-content">
    <!-- contact-section -->
        <!--contact-->
        <div class="w3layouts-contact-section">
	    <div class="container">
                <div class="agileits-contact-main">
                    <div class="col-md-6 w3ls-map">
                        <p class="loc">Наша локација</p>
                        <iframe width="600" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=Dalmatinska%2027&key=AIzaSyADA56EIQo5Gr007jci56Nifir85wkyHJw" allowfullscreen></iframe>
                    </div>
                    <div class="col-md-6 wthree-contact-in">
                        <p class="sed-para"> </p>
                        <p class="para1"></p>
                        <div class="w3-address"> 
                            <address>
                                <strong>
                                    <?php echo $podaci_preduzeca[0]->naziv_firme.", ".$podaci_preduzeca[0]->registracija_firme;?>
                                </strong><br>
                                    <?php echo $podaci_preduzeca[0]->adresa_firme;?><br>
                                    <?php echo $podaci_preduzeca[0]->grad_firme;?><br>
                                    <?php echo $podaci_preduzeca[0]->zemlja_firme;?><br>
                                <abbr title="Телефон">Т:</abbr>
                                    <?php echo $podaci_preduzeca[0]->telefon_firme;?>
                            </address>
                            <address>
                                <strong>Email</strong><br>
                                <a href="mailto:<?php echo $podaci_preduzeca[0]->email_firme;?>"><?php echo $podaci_preduzeca[0]->email_firme;?></a>
                            </address>
                        </div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
                <div class="agileinfo-contact-bottom">
                    <h3 class="text-center find">Пошаљите нам поруку</h3>
                    <p class="contactpara1 text-center">Сва поља морају бити попуњена!</p>
				
                    <form action="#" method="post" accept-charset='utf-8'>
                        <div class="col-md-6 w3layouts-contact-grid">
                            <p class="your-para">Ваше име:</p>
                            <input type="text" placeholder="" name="your name" required="" />
                            <p class="your-para">Ваш Mail:</p>
                            <input type="text" placeholder="" name="email" required="" />
                            <p class="your-para">Телефон:</p>
                            <input type="text" placeholder="" name="tel" required="" />		
                        </div>
                        <div class="col-md-6 w3layouts-contact-grid">
                            <p class="your-para">Наслов:</p>
                            <input type="text" placeholder="" name="sub" required="" />
                            <p class="your-para">Ваша порука:</p>
                            <textarea placeholder=""  name="Message" required=""></textarea>
                            <div class="send">
                                <input type="submit" value="Пошаљи" >
                            </div>			
                        </div>
                        <div class="clearfix"> </div>
                    </form>	
                </div>
            </div>
        </div>
        <!--//contact-->
    <!-- contact-section  -->
    </div>
<!-- //main-content -->