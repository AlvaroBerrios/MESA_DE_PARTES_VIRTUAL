<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*require_once APPPATH."/third_party/PHPExcel.php"; */
require_once dirname(__FILE__) . '/phpexcel/PHPExcel.php';

class pExcel extends PHPExcel { 
    public function __construct() { 
        parent::__construct(); 
    } 
}