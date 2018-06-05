<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MyController
 *
 * @author Veljko
 */

class MY_Controller extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $data = array();
    }
    
    public function load_view($view, $vars = array())
    {
        if($view == 'pocetna'):
            
            $this->load->view('head_poc', $vars);
            $this->load->view('header', $vars);
            $this->load->view($view, $vars);
            $this->load->view('footer_poc', $vars);
            
        else:

            $this->load->view('head', $vars);
            $this->load->view('header', $vars);
            $this->load->view($view, $vars);
            $this->load->view('footer', $vars);
            
        endif;
    }
}
