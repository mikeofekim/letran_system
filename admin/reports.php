<?php
session_start();
include('../php/db_config.php');

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
    <title>iConsult | Reports</title>
    <style>
        .mygradient {
            background-image: linear-gradient(to left bottom, #ffffff, #f1feff, #d3ffff, #c0fff5, #d0ffcb);
        }

        .lowvh {
            height: calc(100vh - 315px);
        }

        .data {
            overflow-y: auto;
            height: calc(100vh - 50px);
        }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <?php include('components/navbar.php') ?>
        <div class="row m-0">
            <?php include('components/sidebar.php') ?>
            <div class="col-md-9 col-sm-12 col-12">
                <div class=" mt-4 data" id="data">
                    <div class="p-3">
                        <div class="h4 mb-0 fw-bold">Reports</div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="card border-0 round-1 shad mb-3 ">
                                    <div class="card-body p-0">

                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="row mb-3">
                                                    <div class="col-md-2 col-6 col-sm-6">
                                                        <div class="smallTxt fw-bold">Year</div>

                                                        <select name="" id="year" class="form-select round-2">
                                                            <!-- <option value="">All</option> -->
                                                            <option value="2021">2021</option>
                                                            <option value="2022">2022</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-6 col-sm-6">
                                                        <div class="smallTxt fw-bold">Month</div>

                                                        <select name="" id="month" class="form-select round-2">
                                                            <!-- <option value="0">All</option> -->
                                                            <option value="1" <?= (date("m") == 1) ? "selected" : "" ?>>January</option>
                                                            <option value="2" <?= (date("m") == 2) ? "selected" : "" ?>>February</option>
                                                            <option value="3" <?= (date("m") == 3) ? "selected" : "" ?>>March</option>
                                                            <option value="4" <?= (date("m") == 4) ? "selected" : "" ?>>April</option>
                                                            <option value="5" <?= (date("m") == 5) ? "selected" : "" ?>>May</option>
                                                            <option value="6" <?= (date("m") == 6) ? "selected" : "" ?>>June</option>
                                                            <option value="7" <?= (date("m") == 7) ? "selected" : "" ?>>July</option>
                                                            <option value="8" <?= (date("m") == 8) ? "selected" : "" ?>>August</option>
                                                            <option value="9" <?= (date("m") == 9) ? "selected" : "" ?>>September</option>
                                                            <option value="10" <?= (date("m") == 10) ? "selected" : "" ?>>October</option>
                                                            <option value="11" <?= (date("m") == 11) ? "selected" : "" ?>>November</option>
                                                            <option value="12" <?= (date("m") == 12) ? "selected" : "" ?>>December</option>
                                                        </select>
                                                    </div>
                                                    <!-- <div class="col-md-3 col-6 col-sm-6">
                                                        <div class="smallTxt fw-bold">Sex</div>
                                                        <select name="" id="gender" class="form-select round-2">
                                                            <option value="">All</option>
                                                            <option value="0">Male</option>
                                                            <option value="1">Female</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 col-6 col-sm-6">
                                                        <div class="smallTxt fw-bold">Age Group<span class="fw-light fst-italic"></span></div>
                                                        <select name="" id="age" class="form-select round-2">
                                                            <option value="">All</option>
                                                            <option value="1">Young Adults (18 -25)</option>
                                                            <option value="2">Adults (26-40)</option>
                                                            <option value="3">Middle Age Adults (41-60)</option>
                                                        </select>
                                                    </div> -->
                                                    <div class="col-md-5 col-12 col-sm-12">
                                                        <div class="smallTxt fw-bold">.<span class="fw-light fst-italic"></span></div>
                                                        <div class="d-flex align-items-center justify-content-start">
                                                            <div class="me-3">
                                                                <button class="btn btn-primary round-2 btm-sm shadow-sm fw-bold" onclick="loadreport()">Fetch <i class="fas fa-chart-pie"></i></button>
                                                            </div>
                                                            <div>
                                                                <form action="print.php" method="post" id="print-form" target="_blank">
                                                                    <input type="hidden" name="year" id="p-year" value="">
                                                                    <input type="hidden" name="month" id="p-month" value="">
                                                                    <input type="hidden" name="orientation" id="p-orientation" value="">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-secondary dropdown-toggle round-2" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                                            Print <i class="fas fa-print"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                                            <li><a class="dropdown-item pointer" onclick="printreport(1)">Portrait</a></li>
                                                                            <li><a class="dropdown-item pointer" onclick="printreport(2)">Landscape</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>




                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12   d-none" id="fetch-text">
                                                <div class="d-flex align-items-center">
                                                    <div class="spinner-border text-primary me-3" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                    <div class="h6 mb-0 text-primary">
                                                        Fetching reports..
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-5  col-6 col-sm-6 databox">
                                                <div class="p-3 bg-white shadow-sm round-1 mb-3">
                                                    <div class="d-flex">
                                                        <div class="smallTxt text-success  mb-2 fw-bold text-wrap" data-aos="flip-up">Number of Diagnosis</div>

                                                        <div class="ms-auto h2 mb-0" id="count1">

                                                        </div>

                                                    </div>


                                                </div>
                                            </div>
                                            <div class="col-md-5  col-6 col-sm-6 databox">
                                                <div class="p-3 bg-white shadow-sm round-1 mb-3">
                                                    <div class="d-flex">
                                                        <div class="smallTxt text-warning  mb-2 fw-bold">Number of Consultations</div>
                                                        <div class="ms-auto h2 mb-0" id="count2">

                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-2">

                                            </div>

                                            <div class="col-md-5 databox">
                                                <div class="p-3 bg-white shadow-sm round-1 mb-3" id="c1">
                                                    <div class="smallTxt  mb-2 fw-bold">Most Diagnosed Health Issue</div>
                                                    <canvas id="myChart" width="400" height="400"></canvas>


                                                </div>
                                            </div>
                                            <div class="col-md-5 databox">
                                                <div class="p-3 bg-white shadow-sm round-1 mb-3" id="c2">
                                                    <div class="smallTxt   mb-2 fw-bold">Most Selected Symptoms</div>

                                                    <canvas id="myChart1" width="400" height="400"></canvas>
                                                    <?php


                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-5 databox">
                                                <div class="p-3 bg-white shadow-sm round-1 mb-3" id="c3">
                                                    <div class="smallTxt   mb-2 fw-bold">Cases by Sex</div>

                                                    <canvas id="myChart2" width="400" height="400" style="max-height: 400px !important"></canvas>
                                                    <?php


                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-5 databox">
                                                <div class="p-3 bg-white shadow-sm round-1 mb-3" id="c4">
                                                    <div class="smallTxt   mb-2 fw-bold">Cases by Age Group</div>

                                                    <canvas id="myChart3" width="400" height="400" style="max-height: 400px !important"></canvas>
                                                    <?php


                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
        $("#navreports").addClass("bg-info text-white shadow");
        loadreport();
        updateScreen();
        window.addEventListener('resize', updateScreen);
        var colors = ["rgba(245, 66, 66,0.6)", "rgba(245, 173, 66,0.6)", "rgba(224, 245, 66,0.6)", "rgba(66, 200, 245,0.6)", "rgba(66, 90, 245,0.6)", "rgba(245, 66, 200,0.6)", "rgba(87, 150, 72,0.6)", "rgba(72, 149, 150,0.6)", "rgba(121, 72, 150,0.6)", "rgba(74, 72, 150,0.6)"]


        function updateScreen() {
            if (window.innerWidth < 600) {
                $("#data").removeClass('data');

            } else {
                $("#data").addClass('data');

            }
        }

        function printreport(id) {
            var month = $("#month").val();
            var year = $("#year").val();
            $("#p-month").val(month);
            $("#p-year").val(year);
            if (id == 1) $("#p-orientation").val("portrait");
            else $("#p-orientation").val("landscape");
            $("#print-form").submit();
        }

        function loadreport() {

            $("#fetch-text").removeClass("d-none");
            $(".databox").addClass("d-none");
            setTimeout(function() {

                $("#myChart").remove();
                $("#myChart1").remove();
                $("#myChart2").remove();
                $("#myChart3").remove();
                $("#c1").append(`<canvas id="myChart" width="400" height="400"></canvas>`);
                $("#c2").append(`<canvas id="myChart1" width="400" height="400"></canvas>`);
                $("#c3").append(`  <canvas id="myChart2"  width="400" height="400" style="max-height:400px !important"></canvas>`);
                $("#c4").append(`  <canvas id="myChart3"  width="400" height="400" style="max-height:400px !important"></canvas>`);
                var month = $("#month").val();
                var gender = $("#gender").val();
                var year = $("#year").val();
                var age = $("#age").val();


                $.post('ajax/loadreport3.php', {
                    month: month,
                    year: year
                }, function(response) {
                    var result = JSON.parse(response);
                    console.log(result);
                    $("#count1").text(result[0]);
                    $("#count2").text(result[1]);
                });


                $.post('ajax/loadreport1.php', {
                    month: month,
                    gender: gender,
                    year: year,
                    age: age
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
                    month: month,
                    gender: gender,
                    year: year,
                    age: age
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



                $("#fetch-text").addClass("d-none");
                $(".databox").removeClass("d-none");

            }, 1500);


        }
    </script>
</body>

</html>