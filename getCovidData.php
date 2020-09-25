<?php

include_once './vendor/autoload.php';

$covidStats = array();

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    

    if ($_POST['county'] == "") {
        $countyIsEmpty = true;
        
    } else {
        $country_code = $_POST['county'];
        $date_range = explode("-", $_POST['daterange']);
        $start_date = date("Y-m-d", strtotime($date_range[0]));
        $end_date = date("Y-m-d", strtotime($date_range[1]));
    }


    $covidStatsCls = new \classes\CovidStats();

    $countryDataFromDb = $covidStatsCls->getCovidStatsByCountryCode($country_code,$start_date,$end_date);
    
    if (is_array($countryDataFromDb) && !empty($countryDataFromDb)):
    // case when data is found..
        $covidStats = $countryDataFromDb;
    else:
        // no data found now fetch & add data into db & fetch to show

        // sample URL http://api.coronatracker.com/v3/analytics/newcases/country?countryCode=IN&startDate=2020-09-01&endDate=2020-09-15
        $api_url = "http://api.coronatracker.com/v3/analytics/newcases/country?countryCode=IN&startDate=$start_date&endDate=$end_date";

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $api_url);

        if ($response->getStatusCode() == 200):
            // go on..
            $responseData = $response->getBody();
            // now let us save data in db first..
        
            $dataStoredToDb = $covidStatsCls->addCovidStatusFromApi($country_code, json_decode($responseData));
            
            if($dataStoredToDb){
                $covidStats  = $covidStatsCls->getCovidStatsByCountryCode($country_code,$start_date,$end_date);
            }

        endif;
    endif;
    
//    header("Location: index.php?country_code=$country_code&start_date=$start_date&end_date=$end_date"); 
  
//exit; 
}