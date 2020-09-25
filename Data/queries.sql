SELECT count(id) as db_record, ( SELECT DATEDIFF("2020-09-15", "2020-09-01")) as num_of_days FROM `covid_stats` WHERE country_code='IN' AND last_updated BETWEEN ('2020-09-01') AND ('2020-09-15') ORDER BY `covid_stats`.`last_updated` ASC 


SELECT count(id) as db_record, ( SELECT DATEDIFF('2020-09-24', '2020-09-01')) as num_of_days FROM `covid_stats` WHERE country_code='IN' AND last_updated BETWEEN ('2020-09-01') AND ('2020-09-24') ORDER BY `covid_stats`.`last_updated` ASC;
