<?php

namespace classes;

use classes\Db;
/**
 * Description of Country
 *
 * @author Brij Raj
 */

class CovidStats extends Db {

    private $db;
    private $table = "covid_stats";
    
    public function __construct() {
        $this->db = Db::getInstance();
    }

    public function checkCovidStartDate($country_code,$start_date) {

        // SELECT * FROM `covid_stats` WHERE last_updated IN (SELECT min(last_updated) FROM covid_stats WHERE `country_code` = 'IN' ) LIMIT 1
        $qry    =   "SELECT * FROM ". $this->table. " WHERE `last_updated` IN (SELECT min(`last_updated`) FROM `".$this->table."` WHERE `country_code` = '$country_code' ) LIMIT 1 ";
        
        $countryCovidStats = $this->db->query($qry);
        if($countryCovidStats){
            return true;
        }else{
            return false;
        }
    }
    public function checkCovidEndDate($country_code,$start_date,$end_date) {

        $qry    =   "SELECT * FROM ". $this->table. " WHERE `country_code` = '$country_code' AND `last_updated` BETWEEN '$start_date' AND '$end_date' ";
        
        $countryCovidStats = $this->db->query($qry);
        if($countryCovidStats){
            return $countryCovidStats;
        }else{
            return false;
        }
    }


    public function getCovidStatsByCountryCode($country_code,$start_date,$end_date) {
//
//        // before return result lets check if selected date range is satisfied..
//        if($this->checkCovidStartDate($country_code, $start_date)):
//            // start is present in db..
//            echo "start is present in db";
//        else:
//            // start date not in the table..
//            echo "start date not in the table";
//        endif;
//        
        
        
        
        $qry    =   "SELECT * FROM ". $this->table. " WHERE `country_code` = '$country_code' AND `last_updated` BETWEEN '$start_date' AND '$end_date' ";
        
        $countryCovidStats = $this->db->query($qry);
        if($countryCovidStats){
            return $countryCovidStats;
        }else{
            return false;
        }
    }

    public function addCovidStatusFromApi($country_code,$responseData=array()) {

        if($responseData){
        foreach($responseData as $data):
//            print_r(date('',strtotime($data->last_updated));die;
            $record = array('country_code'=>$country_code,'country_name'=>$data->country,'new_infections'=>$data->new_infections,'new_deaths'=>$data->new_deaths,'new_recovered'=>$data->new_recovered,'last_updated'=>$data->last_updated);

            $this->db->insert($this->table, $record);
        endforeach;
        return true;
        }
        // once data is added return true..
    }
    
    
    
    
}
