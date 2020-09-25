<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace classes;

use classes\Dashboard;
/**
 * Description of dashboardview
 *
 * @author Brij Raj
 */
class DashboardView extends Dashboard {

    public function __construct() {
         parent::__construct();
    }
    
    public function showCountries() {
        return $this->getAllCountries();
    }
}
