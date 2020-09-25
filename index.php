<?php
include_once './views/includes/header.php';
?>

<?php
$dashboardCls = new \classes\DashboardView();

$countries = $dashboardCls->showCountries();

if (isset($_GET['country_code'])):
    $start_date = date("Y-m-d", strtotime($_GET['start_date']));
    $end_date = date("Y-m-d", strtotime($_GET['start_date']));
    // now show data from db...
    $covidStats = $covidStatsCls->getCovidStatsByCountryCode($country_code, $start_date, $end_date);

endif;
?>
<div class="container">
    <h1 class="title">Welcome to Covid Stats Dashboard</h1>
    <div class="row">
        <div class="col">
            <p>Kindly choose country & date range to get the covid stats </p>
        </div>
    </div>
    <form action="index.php" method="post">
        <div class="row">
            <div class="col">
                Country :   <select name="county" class="form-control" required="required">
                    <option value="">--Select Country--</option>
<?php
if ($countries):
    foreach ($countries as $c => $country) {
        ?><option value="<?php echo $country['code'] ?>" ><?php echo $country['name'] ?> </option>
                            <?php
                        }
                    endif;
                    ?>
                </select>
            </div>
            <div class="col">
                Date Range <input class="form-control" type="text" name="daterange" value="09/01/2020 - 09/15/2020" />
            </div>
            <div class="col mt-4">
                <input type="submit" class=" btn btn-primary" value="Get Covid Stats">
            </div>
        </div>

    </form>


<?php
if (count($covidStats)):
    ?>
        <div class="card-body">
            <div class="row">
            <div class="col-sm-4">
            <div class="card" style="width: 18rem;">
                <!--<img class="card-img-top" src="..." alt="Card image cap">-->
                <div class="card-body alert-warning">
                    <h5 class="card-title">Total affected</h5>
                    <p class="card-text"><?php echo number_format(array_sum(array_column($covidStats,'new_infections')),0)  ?></p>
                    <a href="#" class="btn btn-primary">read more</a>
                </div>
            </div>
                
            </div>
            <div class="col-sm-4">
            <div class="card" style="width: 18rem;">
                <!--<img class="card-img-top" src="..." alt="Card image cap">-->
                <div class="card-body alert-danger">
                    <h5 class="card-title">Total death</h5>
                    <p class="card-text"><?php echo number_format(array_sum(array_column($covidStats,'new_deaths')))  ?></p>
                    <a href="#" class="btn btn-primary">read more</a>
                </div>
            </div>
                
            </div>
            <div class="col">
            <div class="card" style="width: 18rem;">
                <!--<img class="card-img-top" src="..." alt="Card image cap">-->
                <div class="card-body alert-success">
                    <h5 class="card-title">Total recovered</h5>
                    <p class="card-text"><?php echo number_format(array_sum(array_column($covidStats,'new_recovered')))  ?></p>
                    <a href="#" class="btn btn-primary">read more</a>
                </div>
            </div>
                
            </div>
            </div>
        </div>
    <?php
endif;
?>
</div>
    <?php
    include_once './views/includes/footer.php';
    