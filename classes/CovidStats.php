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

    public function checkCovidStartDate($country_code, $start_date) {

        // SELECT * FROM `covid_stats` WHERE last_updated IN (SELECT min(last_updated) FROM covid_stats WHERE `country_code` = 'IN' ) LIMIT 1
        $qry = "SELECT * FROM " . $this->table . " WHERE `last_updated` IN (SELECT min(`last_updated`) FROM `" . $this->table . "` WHERE `country_code` = '$country_code' ) LIMIT 1 ";

        $countryCovidStats = $this->db->query($qry);
        if ($countryCovidStats) {
            return true;
        } else {
            return false;
        }
    }

    public function checkCovidDateCount($country_code, $start_date, $end_date) {

        $qry = "SELECT count(id) as db_record, ( SELECT DATEDIFF('$end_date', '$start_date')) as num_of_days FROM `covid_stats` WHERE country_code='$country_code' AND last_updated BETWEEN ('$start_date') AND ('$end_date')  
ORDER BY `covid_stats`.`last_updated`  ASC";

        $countryCovidStats = $this->db->query($qry);
//        print_r($countryCovidStats[0]['db_record']);print_r($countryCovidStats[0]['num_of_days']);
        if ($countryCovidStats[0]['db_record'] == 0 ||
                ($countryCovidStats[0]['db_record'] < $countryCovidStats[0]['num_of_days'])) {
            return false;
        } else {
            return true;
        }
    }

    public function checkCovidEndDate($country_code, $start_date, $end_date) {

        $qry = "SELECT * FROM " . $this->table . " WHERE `country_code` = '$country_code' AND `last_updated` BETWEEN '$start_date' AND '$end_date' ";

        $countryCovidStats = $this->db->query($qry);
        if ($countryCovidStats) {
            return $countryCovidStats;
        } else {
            return false;
        }
    }

    public function getCovidStatsByCountryCode($country_code, $start_date, $end_date) {
//
        // before return result lets check if selected date range is satisfied..
        if ($this->checkCovidDateCount($country_code, $start_date, $end_date)):
            // start is present in db.. so now fetch the record & return..
            $qry = "SELECT * FROM " . $this->table . " WHERE `country_code` = '$country_code' AND `last_updated` BETWEEN '$start_date' AND '$end_date' ";

            $countryCovidStats = $this->db->query($qry);
            if ($countryCovidStats) {
                return $countryCovidStats;
            } else {
                return false;
            }
        else:
            // start date not in the table.. now we need to add the record..
            return false;
        endif;
    }

    public function addCovidStatusFromApi($country_code, $responseData = array()) {

        if ($responseData) {
            foreach ($responseData as $data):
//            print_r(date('',strtotime($data->last_updated));die;
                $record = array('country_code' => $country_code, 'country_name' => $data->country, 'new_infections' => $data->new_infections, 'new_deaths' => $data->new_deaths, 'new_recovered' => $data->new_recovered, 'last_updated' => $data->last_updated);

                // before insert let us check if same record is present in the db or not...
                $select = $this->db->select($this->table, array('country_code' => $country_code, 'country_name' => $data->country, 'last_updated' => date("Y-m-d", strtotime($data->last_updated))));
                if (!$select) {
                    // now insert only if the record is not present in the database
                    $this->db->insert($this->table, $record);
                }
            endforeach;
            return true;
        }
        // once data is added return true..
    }

}
