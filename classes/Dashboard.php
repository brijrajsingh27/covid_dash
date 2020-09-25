<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace classes;

use classes\Db;
/**
 * Description of dashboard
 *
 * @author Brij
 */
class Dashboard extends Db{

    private $db;
    public function __construct() {
        $this->db = Db::getInstance();
    }

    private $table = "countries";
    
    protected function getAllCountries() {

        $countries = $this->db->select($this->table);
        return $countries;
    }
}
