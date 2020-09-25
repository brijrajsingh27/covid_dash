<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace classes;

/**
 * Description of viewCoutries
 *
 * @author Brij Raj
 */

class ViewCoutries extends Country{
    
    public function __construct() {
        parent::__construct();
    }
    public function showCountires() {
        return $coutries = $this->getCountries();
    }
}
