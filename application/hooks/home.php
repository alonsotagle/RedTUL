<?php
if (!defined( 'BASEPATH')) exit('No direct script access allowed'); 
class home
{
    private $ci;
    public function __construct()
    {
    	$this->ci =& get_instance();
        !$this->ci->load->library('session') ? $this->ci->load->library('session') : false;
        !$this->ci->load->helper('url') ? $this->ci->load->helper('url') : false;
    }    
 
    public function check_login()
    {
        if($this->ci->uri->segment(1) != "login")
        {
            if($this->ci->session->userdata('logged') == FALSE)
            {
                redirect(site_url('login'));
            }
        }
    }
}
/*
/end hooks/home.php
*/