<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Default_widget extends Widget
{
    public function __construct()
    {
        parent::__construct();
    }
    public function _remap()
    {
        echo 'No direct access allowed';
    }
    public function index()
    {
        echo 'No direct access allowed';
    }
    public function sidebar()
    {
        $this->load->view('widgets/sidebar_form');
    }
}