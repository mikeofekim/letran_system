<?php
session_start();
include('../php/db_config.php');


if (isset($_SESSION['userType'])) {
    if ($_SESSION['userType'] != 1) {
        header('Location: ../login.php');
    }
} else {
    header('Location: ../login.php');
}

// $year = $_POST['year'];

// $start_month = date("m") - 5;
if (isset($_GET['yy'])) {
    $current_year = $_GET['yy'];
} else
    $current_year = date("Y");
$start_month = 1;
$end_month = date("m");
$months = [];
for ($x = $start_month; $x < ($start_month + $end_month); $x++) {
    array_push($months, date("M " . $current_year, mktime(0, 0, 0, $x, 10)));
}
$trends = [array(0, 0, 0, 0, 0, 0), array(0, 0, 0, 0, 0, 0), array(0, 0, 0, 0, 0, 0), array(0, 0, 0, 0, 0, 0), array(0, 0, 0, 0, 0, 0)];

date_default_timezone_set("Asia/Manila");
$arr = [];
$arr1 = [];
$sql = "SELECT * FROM diagnosis a INNER JOIN usertbl b ON a.userid = b.userID";
$result = mysqli_query($conn, $sql);
if ($result->num_rows > 0) {
    $test = [];
    while ($row = $result->fetch_assoc()) {

        $year = date('Y', strtotime($row['date']));

        if ($year == $current_year) {
            $symptoms = json_decode($row['symptoms']);
            foreach ($symptoms as $symp) {
                array_push($arr, $symp);
            }
            $diagnosis = json_decode($row['result']);
            $c = 0;
            foreach ($diagnosis as $item) {

                array_push($arr1, $item->Issue->ID);
                if (!array_key_exists("'" . strval($item->Issue->ID) . "'", $test)) {
                    $test["'" . strval($item->Issue->ID) . "'"] = array(0, 0, array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0), array(0, 0, 0));
                }
                if ($row['gender'] == 0) {
                    $test["'" . strval($item->Issue->ID) . "'"][0] =   $test["'" . strval($item->Issue->ID) . "'"][0] + 1;
                } else {
                    $test["'" . strval($item->Issue->ID) . "'"][1] =   $test["'" . strval($item->Issue->ID) . "'"][1] + 1;
                }

                $c++;



                $date = date('m', strtotime($row['date']));


                // $date = explode('-', $date);
                // $month = $date[0];
                $y = $start_month;

                $x = 0;

                for ($xx = 0, $y = $start_month; $xx <= $end_month; $xx++, $y++) {

                    if (number_format($date) == $y && $year) {
                        $test["'" . strval($item->Issue->ID) . "'"][2][$xx]++;
                        break;
                    }
                }


                $dateOfBirth = $row['birthday'];
                $today = date("Y-m-d");
                $diff = date_diff(date_create($dateOfBirth), date_create($today));
                $age = $diff->format('%Y');

                if ($age >= 18 && $age <= 25) {
                    $test["'" . strval($item->Issue->ID) . "'"][3][0]++;
                } else if ($age >= 26 && $age <= 40) {
                    $test["'" . strval($item->Issue->ID) . "'"][3][1]++;
                } else if ($age >= 41 && $age <= 60) {
                    $test["'" . strval($item->Issue->ID) . "'"][3][2]++;
                }


                if ($c == 1) break;
            }
        }
    }
    // print_r($test);
    $arr = array_count_values($arr);
    arsort($arr);
    $keys = array_keys($arr);
    $values = array_values($arr);
    $all = [];
    for ($x = 0; $x < count($keys); $x++) {
        array_push($all, array($keys[$x], $values[$x]));
    }



    $names = [];
    $count = [];
    for ($x = 0; $x < count($all); $x++) {
        if ($x == 10) break;
        $sql = "SELECT * FROM symptoms WHERE symptomID =" . $all[$x][0];
        $res = mysqli_query($conn, $sql);

        $result = $res->fetch_assoc();
        array_push($names, $result['name']);
        array_push($count, $all[$x][1]);
    }


    $arr1 = array_count_values($arr1);

    arsort($arr1);
    $keys1 = array_keys($arr1);
    $values1 = array_values($arr1);
    $all1 = [];
    for ($x = 0; $x < count($keys1); $x++) {
        array_push($all1, array($keys1[$x], $values1[$x]));
    }
    $names1 = [];
    $count1 = [];
    $sex1 = [];
    $sex2 = [];
    $trends = [];
    $age1 = [];
    $age2 = [];
    $age3 = [];

    for ($x = 0; $x < count($all1); $x++) {
        if ($x == 10) break;
        $sql = "SELECT * FROM healthissues WHERE issueID =" . $all1[$x][0];
        $result1 = mysqli_query($conn, $sql)->fetch_assoc();
        array_push($names1, $result1['issueName']);
        array_push($count1, $all1[$x][1]);

        $total =  $test["'" . $all1[$x][0] . "'"][0] +  $test["'" . $all1[$x][0] . "'"][1];
        array_push($sex1, $test["'" . $all1[$x][0] . "'"][0] / $total * 100);
        array_push($sex2, $test["'" . $all1[$x][0] . "'"][1] / $total * 100);


        array_push($trends, $test["'" . $all1[$x][0] . "'"][2]);
        array_push($age1, $test["'" . $all1[$x][0] . "'"][3][0]);
        array_push($age2, $test["'" . $all1[$x][0] . "'"][3][1]);
        array_push($age3, $test["'" . $all1[$x][0] . "'"][3][2]);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <title>Print Report</title>

    <style>
        .container {
            max-width: 700px;
        }
    </style>
</head>

<body class="bg-light">

    <div class="h3 text-center fw-bold mt-5">iConsult Annual Overall Report</div>
    <div class="h6 text-center">Year <?= $current_year; ?></div>

    <div class="container">
        <hr>
        <div class="row mb-3">

            <div class="col-12 databox">
                <div class="p-3 bg-white shadow-sm round-1 mb-3" id="c1">
                    <div class="smallTxt  mb-2 fw-bold">Most Diagnosed Health Issue</div>
                    <canvas id="myChart" width="400" height="400" style="max-height: 300px"></canvas>

                </div>
            </div>

            <div class="col-12 databox">
                <div class="p-3 bg-white shadow-sm round-1 mb-3" id="c2">
                    <div class="smallTxt  mb-2 fw-bold">Most Selected Symptoms</div>

                    <canvas id="myChart1" width="400" height="400" style="max-height: 300px"></canvas>
                    <?php


                    ?>
                </div>
            </div>
            <div class="col-12 databox">
                <div class="p-3 bg-white shadow-sm round-1 mb-3" id="c2">
                    <div class="smallTxt text-center mb-2 fw-bold">Cases Trendline</div>
                    <canvas id="myChart4" width="400" height="400" style="max-height: 300px"></canvas>
                    <?php


                    ?>
                </div>
            </div>
            <div class="col-12 databox">
                <div class="p-3 bg-white shadow-sm round-1 mb-3" id="c3">
                    <div class="smallTxt text- fw-bold">Cases by Sex</div>
                    <canvas id="myChart3" width="400" height="400" style="max-height: 300px" class="mt-3"></canvas>
                    <?php


                    ?>
                </div>
            </div>
            <div class="col-12 databox">
                <div class="p-3 bg-white shadow-sm round-1 mb-3" id="c4">
                    <div class="smallTxt text- fw-bold">Cases by Age Group</div>
                    <canvas id="myChart5" width="400" height="400" style="max-height: 600px" class="mt-3"></canvas>


                </div>
            </div>

        </div>
    </div>


    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var colors = ["rgba(245, 66, 66,0.6)", "rgba(245, 173, 66,0.6)", "rgba(224, 245, 66,0.6)", "rgba(66, 200, 245,0.6)", "rgba(66, 90, 245,0.6)", "rgba(245, 66, 200,0.6)", "rgba(87, 150, 72,0.6)", "rgba(72, 149, 150,0.6)", "rgba(121, 72, 150,0.6)", "rgba(74, 72, 150,0.6)"]



        var result = JSON.parse('<?= json_encode(array($names, $count)) ?>');

        var ctx = document.getElementById('myChart1').getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: result[0],
                datasets: [{
                    label: ' Frequency',
                    data: result[1],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132,  0.5)',
                        'rgba(54, 162, 235,  0.5)',
                        'rgba(255, 206, 86,  0.5)',
                        'rgba(75, 192, 192,  0.5)',
                        'rgba(153, 102, 255,  0.5)',
                        'rgba(255, 159, 64,  0.5)'
                    ],
                    borderWidth: 0,
                    borderRadius: 5
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var result = JSON.parse('<?= json_encode(array($names1, $count1)) ?>');
        console.log(result);

        var ctx = document.getElementById('myChart').getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: result[0],
                datasets: [{
                    label: '# of Votes',
                    data: result[1],
                    backgroundColor: colors,
                    borderColor: colors,
                    borderWidth: 2,
                    borderColor: "#fff",
                    borderRadius: 5
                }]
            }
        });


        var result = JSON.parse('<?= json_encode(array($names1, $sex1, $sex2)) ?>');
        console.log(result);

        var data = {
            labels: result[0],
            datasets: [{
                    label: 'Male (%)',
                    data: result[1],
                    borderColor: 'rgba(0, 0, 255, 0.3)',
                    backgroundColor: 'rgba(0, 0, 255, 0.3)',
                    borderRadius: 5
                },
                {
                    label: 'Female (%)',
                    data: result[2],
                    borderColor: 'rgba(255, 0, 0, 0.3)',
                    backgroundColor: 'rgba(255, 0, 0, 0.3)',
                    borderRadius: 5
                }
            ]
        };

        var config = {
            type: 'bar',
            data: data,
            options: {
                indexAxis: 'y',
                // Elements options apply to all of the options unless overridden in a dataset
                // In this case, we are setting the border of each horizontal bar to be 2px wide
                elements: {
                    bar: {
                        borderWidth: 1,
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'Cases by Sex'
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true
                    }
                }
            },
        };

        var ctx = document.getElementById('myChart3').getContext('2d');

        var myChart = new Chart(ctx, config);



        //age

        var result = JSON.parse('<?= json_encode(array($months, $names1, $trends)) ?>');
        console.log(result);

        var mydatasets = [];

        for (var x = 0; x < result[1].length; x++) {
            $a = {
                label: result[1][x],
                data: result[2][x],
                borderColor: colors[x],
                backgroundColor: colors[x],
                tension: 0.2,
            }

            mydatasets.push($a);
        }

        var data = {
            labels: result[0],
            datasets: mydatasets
        };



        var config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'Cases Trendline'
                    }
                }
            },
        };

        var ctx = document.getElementById('myChart4').getContext('2d');

        var myChart = new Chart(ctx, config);


        var result = JSON.parse('<?= json_encode(array($names1, $age1, $age2, $age3)) ?>');
        console.log(result);

        var data = {
            labels: result[0],
            datasets: [{
                    label: 'Young Adults (18-25 yrs)',
                    data: result[1],
                    borderColor: colors[1],
                    backgroundColor: colors[1],
                    borderRadius: 5
                },
                {
                    label: 'Adults (26-40 yrs)',
                    data: result[2],
                    borderColor: colors[5],
                    backgroundColor: colors[5],
                    borderRadius: 5
                },
                {
                    label: 'Middle Age Adults (41-60 yrs)',
                    data: result[3],
                    borderColor: colors[6],
                    backgroundColor: colors[6],
                    borderRadius: 5
                }
            ]
        };

        var config = {
            type: 'bar',
            data: data,
            options: {
                indexAxis: 'y',
                // Elements options apply to all of the options unless overridden in a dataset
                // In this case, we are setting the border of each horizontal bar to be 2px wide
                elements: {
                    bar: {
                        borderWidth: 1,
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'Cases by Age Group'
                    }
                }
            },
        };

        var ctx = document.getElementById('myChart5').getContext('2d');

        var myChart = new Chart(ctx, config);

        setTimeout(function() {
            window.print();
        }, 3000);
    </script>
</body>

</html>