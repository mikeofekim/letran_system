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

$year = $_POST['year'];
$month = $_POST['month'];
$orientation = $_POST['orientation'];
$monthName = date('F', mktime(0, 0, 0, $month, 10));
$size = 0;
if ($orientation == "portrait") $size = 750;
else $size = 1000;
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
    <style type="text/css" media="print">
        @page {
            size: <?= $orientation ?>;
        }
    </style>
    <style>
        .container {
            max-width: <?= $size ?>px;
        }
    </style>
</head>

<body class="bg-light">

    <div class="h3 text-center fw-bold mt-5">iConsult Monthly Report</div>
    <div class="h6 text-center">Month of <?= $monthName ?></div>

    <div class="container">
        <hr>
        <div class="row">
            <div class=" col-6  databox">
                <div class="p-3 bg-white shadow-sm round-1 mb-3">
                    <div class="d-flex">
                        <div class="smallTxt text-success  mb-2 fw-bold text-wrap">Number of Diagnosis</div>

                        <div class="ms-auto h2 mb-0" id="count1">

                        </div>

                    </div>


                </div>
            </div>
            <div class="  col-6  databox">
                <div class="p-3 bg-white shadow-sm round-1 mb-3">
                    <div class="d-flex">
                        <div class="smallTxt text-warning  mb-2 fw-bold">Number of Consultations</div>
                        <div class="ms-auto h2 mb-0" id="count2">

                        </div>

                    </div>

                </div>
            </div>
            <div class="col-6 databox">
                <div class="p-3 bg-white shadow-sm round-1 mb-3" id="c1">
                    <div class="smallTxt  mb-2 fw-bold">Most Diagnosed Health Issue</div>
                    <canvas id="myChart" width="400" height="400"></canvas>


                </div>
            </div>
            <div class="col-6 databox">
                <div class="p-3 bg-white shadow-sm round-1 mb-3" id="c2">
                    <div class="smallTxt   mb-2 fw-bold">Most Selected Symptoms</div>

                    <canvas id="myChart1" width="400" height="400"></canvas>
                    <?php


                    ?>
                </div>
            </div>
            <div class="col-6 databox">
                <div class="p-3 bg-white shadow-sm round-1 mb-3" id="c3">
                    <div class="smallTxt   mb-2 fw-bold">Cases by Sex</div>

                    <canvas id="myChart2" width="400" height="400" style="max-height: 400px !important"></canvas>
                    <?php


                    ?>
                </div>
            </div>
            <div class="col-6 databox">
                <div class="p-3 bg-white shadow-sm round-1 mb-3" id="c4">
                    <div class="smallTxt   mb-2 fw-bold">Cases by Age Group</div>

                    <canvas id="myChart3" width="400" height="400" style="max-height: 400px !important"></canvas>
                    <?php


                    ?>
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


        $.post('ajax/loadreport3.php', {
            month: <?= $month ?>,
            year: <?= $year ?>
        }, function(response) {
            var result = JSON.parse(response);
            console.log(result);
            $("#count1").text(result[0]);
            $("#count2").text(result[1]);
        });


        $.post('ajax/loadreport1.php', {
            month: <?= $month ?>,
            year: <?= $year ?>
        }, function(response) {
            var result = JSON.parse(response);
            console.log(response);

            var ctx = document.getElementById('myChart1').getContext('2d');

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: result[0],
                    datasets: [{
                        label: ' Frequency',
                        data: result[1],
                        backgroundColor: colors,
                        borderColor: colors,
                        borderWidth: 0,
                        borderRadius: 5
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            display: true,
                            stacked: false,
                            ticks: {
                                min: 0,
                                stepSize: 1
                            }
                        }]
                    }
                }
            });


        });

        $.post('ajax/loadreport2.php', {
            month: <?= $month ?>,
            year: <?= $year ?>
        }, function(response) {
            var result = JSON.parse(response);

            var ctx = document.getElementById('myChart').getContext('2d');

            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: result[0],
                    datasets: [{
                        label: '# of Votes',
                        data: result[1],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.4)',
                            'rgba(153, 102, 255, 0.3)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 6)',
                            'rgba(54, 162, 235, 5)',
                            'rgba(255, 206, 86, 4)',
                            'rgba(75, 192, 192, 3)',
                            'rgba(153, 102, 255, 2)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 2,
                        borderColor: "#fff",
                        borderRadius: 10

                    }]
                }
            });


            var ctx = document.getElementById('myChart2').getContext('2d');

            var data = {
                labels: result[0],
                datasets: [{
                        label: 'Male (%)',
                        data: result[2],
                        borderColor: 'rgba(0, 0, 255, 0.3)',
                        backgroundColor: 'rgba(0, 0, 255, 0.3)',
                        borderRadius: 5
                    },
                    {
                        label: 'Female (%)',
                        data: result[3],
                        borderColor: 'rgba(255, 0, 0, 0.3)',
                        backgroundColor: 'rgba(255, 0, 0, 0.3)',
                        borderRadius: 5
                    }
                ]
            };

            var config1 = {
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
            var myChart = new Chart(ctx, config1);


            var data = {
                labels: result[0],
                datasets: [{
                        label: 'Young Adults (18-25 yrs)',
                        data: result[4],
                        borderColor: colors[1],
                        backgroundColor: colors[1],
                        borderRadius: 5
                    },
                    {
                        label: 'Adults (26-40 yrs)',
                        data: result[5],
                        borderColor: colors[5],
                        backgroundColor: colors[5],
                        borderRadius: 5
                    },
                    {
                        label: 'Middle Age Adults (41-60 yrs)',
                        data: result[6],
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

            var ctx = document.getElementById('myChart3').getContext('2d');

            var myChart = new Chart(ctx, config);

        });
        setTimeout(function() {
            window.print();
        }, 3000);
    </script>
</body>

</html>