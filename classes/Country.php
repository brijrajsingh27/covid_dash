<?php

namespace classes;

use classes\Db;
/**
 * Description of Country
 *
 * @author Brij Raj
 */

class Country extends Db {

    private $db;
    private $table = "countries";
    public function __construct() {
        $this->db = Db::getInstance();
    }

    public function getCountryData($country_code) {
        $where = array('code'=>$country_code);
        $countryCovidStats = $this->db->select($this->table,$where);
        print_r($countryCovidStats);die;
        return $countryCovidStats;
    }

    protected function getCountries() {
        $countries = $this->select('coutries');
        return $countries;
    }
    
    
    
}
