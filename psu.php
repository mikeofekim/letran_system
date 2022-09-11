<?php
session_start();
include('php/db_config.php');


// header("Location: access-denied.php");


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />

    <title>Pangasinan State University</title>
    <style>
        body {
            background-image: url('bg-psu.jpg');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
        }
    </style>
</head>

<body class="">
    <div class="container p-0">

        <div class="row m-0">

            <div class="col-md-12 col-sm-12 col-12">
                <div class="">
                    <div class="p-3">

                        <div class="row mt-3">

                            <div class="col-md-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-2">
                                        <img src="assets/images/psu.png" height="45" alt="">
                                    </div>
                                    <div>
                                        <div class="h5 mb-0 fw-bold">Pangasinan State University | <span class="fw-light">CoViD-19 Dashboard</span></div>
                                        <div class="smallTxt"><?= date('F d, Y') ?>
                                            <!-- | <a href="psu-admin.php"><i class="fas fa-cog"></i></a> -->
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="col-md-12">
                                <form action="" method="post" enctype="multipart/form-data" class="d-none">
                                    Select image to upload:
                                    <input type="file" name="fileToUpload" id="fileToUpload" accept=".csv" onchange="$('#uploadbtn').click()">
                                    <input type="submit" id="uploadbtn" value="Upload Image" name="uploadcsv">
                                </form>
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="card round-1 border-0  shadow-sm mb-3">
                                            <div class="card-body">
                                                <div class="smallTxt text-secondary text-justified lh-base fst-italic fw-light">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The COVID-19 Dashboard of Pangasinan State University highlights the most recent situation of COVID cases in the University. Data presented in this dashboard are those officially reported to the Medical and Dental Services Unit of the University. Moreover, data are consolidated and analysed by the Center for Statistics and Computing Sciences (CS)2.</div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-12">
                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active smallTxt fw-bold" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">University Data</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link smallTxt fw-bold" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Campus Data</button>
                                            </li>

                                        </ul>
                                        <div class="card round-1 border-0  shadow-sm mb-3">
                                            <div class="card-body">
                                                <div class="tab-content" id="pills-tabContent">
                                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                                        <div class="smallTxt text-primary text-capitalize mb-2 fw-bold text-secondary mb-3"><i class="fas fa-school"></i> UNIVERSITY TOTAL CASES</div>
                                                        <div class="row">
                                                            <div class="col-md-6">

                                                                <div class="row ">
                                                                    <div class="col-md-6 col-6">
                                                                        <div class="p-3 bg-white shadow-sm round-1 mb-3">
                                                                            <span class="float-end"><i class="fas fa-user-check text-warning"></i></span>
                                                                            <div class="smallTxt text-warning text-capitalize mb-2 fw-bold text-truncate">Confirmed Cases</div>
                                                                            <div class="h3  mb-0 text-end bg-light round-2 p-2 px-3" id="confirmed">0</div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-md-6 col-6">
                                                                        <div class="p-3 bg-white shadow-sm round-1 mb-3">
                                                                            <span class="float-end"><i class="fas fa-user-injured text-primary"></i></span>
                                                                            <div class="smallTxt text-primary text-capitalize mb-2 fw-bold">Active Cases</div>
                                                                            <div class="h3  mb-0 text-end bg-light round-2 p-2 px-3" id="active">0</div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-md-6 col-6">
                                                                        <div class="p-3 bg-white shadow-sm  round-1 mb-3">
                                                                            <span class="float-end"><i class="fas fa-user-clock text-success"></i></span>
                                                                            <div class="smallTxt text-success text-capitalize mb-2 fw-bold">Recovered</div>
                                                                            <div class="h3 mb-0  text-end bg-light round-2 p-2 px-3" id="recovered">0</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-6">
                                                                        <div class="p-3 bg-white shadow-sm round-1 mb-3">
                                                                            <span class="float-end"><i class="fas fa-user-slash text-danger"></i></span>
                                                                            <div class="smallTxt text-danger text-capitalize mb-2 fw-bold">Deceased</div>
                                                                            <div class="h3 mb-0  text-end bg-light round-2 p-2 px-3" id="deceased">0</div>
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                                <hr>
                                                                <div class="smallTxt text-primary text-capitalize mb-3 fw-bold text-secondary"><i class="fas fa-chart-bar"></i> CASES BY CAMPUS</div>
                                                                <canvas id="myChart" width="400" height="300" style="max-height: 400px;"></canvas>
                                                                <hr>
                                                                <div class="smallTxt text-primary text-capitalize mb-2 fw-bold text-secondary"><i class="fas fa-chart-line"></i> CASES TRENDLINE <span class="fw-light">(Last 12 months)</span> </div>
                                                                <canvas id="myChart8" width="400" height="400" style="max-height: 300px;"></canvas>
                                                                <div class="col-md-12  mt-3">
                                                                    <div class="card  round-1 border">
                                                                        <div class="card-body">
                                                                            <canvas id="m6" width="400" height="400" style="max-height: 300px;"></canvas>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <canvas id="myChart9" class="mb-5" width="400" height="400" style="max-height: 300px;"></canvas>
                                                                    <div class="col-md-6 mb-2 col-6">
                                                                        <canvas id="m1" width="400" height="400" style="max-height: 400px;"></canvas>
                                                                    </div>
                                                                    <div class="col-md-6  mb-2 col-6">
                                                                        <canvas id="m2" width="400" height="400" style="max-height: 400px;"></canvas>
                                                                    </div>
                                                                    <div class="col-md-6 mb-2 col-6">
                                                                        <canvas id="m3" width="400" height="400" style="max-height: 400px;"></canvas>
                                                                    </div>
                                                                    <div class="col-md-6  mb-2 col-6">
                                                                        <canvas id="m4" width="400" height="400" style="max-height: 400px;"></canvas>
                                                                    </div>
                                                                    <div class="col-md-6  mb-2 col-12">
                                                                        <canvas id="m5" width="400" height="400" style="max-height: 400px;"></canvas>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                                        <div class="smallTxt text-primary text-capitalize mb-2 fw-bold text-secondary">SELECTED CAMPUS</div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-4 col-6">
                                                                <select name="" id="campusname" class="form-select form-select-sm round-2 mb-2 shadow-sm border-0">
                                                                    <option value="Alaminos">Alaminos</option>
                                                                    <option value="Asingan">Asingan</option>
                                                                    <option value="Bayambang">Bayambang</option>
                                                                    <option value="Binmaley">Binmaley</option>
                                                                    <option value="Infanta">Infanta</option>
                                                                    <option value="Lingayen">Lingayen</option>
                                                                    <option value="San Carlos">San Carlos</option>
                                                                    <option value="Sta Maria">Sta Maria</option>
                                                                    <option value="Urdaneta">Urdaneta</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2 col-6">
                                                                <button class="btn btn-light text-primary btn-sm round-2 shadow-sm w-100 fw-bold" onclick="loadmeta()">Fetch <i class="fas fa-chart-pie"></i></button>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">

                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="row ">
                                                                            <div class="col-md-6 col-6">
                                                                                <div class="p-3 bg-white shadow-sm round-1 mb-3">
                                                                                    <span class="float-end"><i class="fas fa-user-check text-warning"></i></span>
                                                                                    <div class="smallTxt text-warning text-capitalize mb-2 fw-bold text-truncate">Confirmed Cases</div>
                                                                                    <div class="h3  mb-0 text-end bg-light round-2 p-2 px-3" id="confirmed1">0</div>
                                                                                </div>

                                                                            </div>
                                                                            <div class="col-md-6 col-6">
                                                                                <div class="p-3 bg-white shadow-sm round-1 mb-3">
                                                                                    <span class="float-end"><i class="fas fa-user-injured text-primary"></i></span>
                                                                                    <div class="smallTxt text-primary text-capitalize mb-2 fw-bold">Active Cases</div>
                                                                                    <div class="h3  mb-0 text-end bg-light round-2 p-2 px-3" id="active1">0</div>
                                                                                </div>

                                                                            </div>
                                                                            <div class="col-md-6 col-6">
                                                                                <div class="p-3 bg-white shadow-sm  round-1 mb-3">
                                                                                    <span class="float-end"><i class="fas fa-user-clock text-success"></i></span>
                                                                                    <div class="smallTxt text-success text-capitalize mb-2 fw-bold">Recovered</div>
                                                                                    <div class="h3 mb-0  text-end bg-light round-2 p-2 px-3" id="recovered1">0</div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6 col-6">
                                                                                <div class="p-3 bg-white shadow-sm round-1 mb-3">
                                                                                    <span class="float-end"><i class="fas fa-user-slash text-danger"></i></span>
                                                                                    <div class="smallTxt text-danger text-capitalize mb-2 fw-bold">Deceased</div>
                                                                                    <div class="h3 mb-0  text-end bg-light round-2 p-2 px-3" id="deceased1">0</div>
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="card  border round-1 mb-3">
                                                                            <div class="card-body" id="meta11">
                                                                                <canvas id="myChart6" width="400" height="400" style="max-height: 300px;"></canvas>
                                                                                <hr>
                                                                                <div class="smallTxt text-primary text-capitalize mb-2 fw-bold text-secondary"><i class="fas fa-chart-line"></i> CASES TRENDLINE <span class="fw-light">(Last 12 months)</span> </div>
                                                                                <canvas id="m7" width="400" height="400" style="max-height: 300px;"></canvas>
                                                                            </div>
                                                                        </div>



                                                                    </div>

                                                                </div>


                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row" id="meta22">
                                                                    <div class=" col-md-4 mb-2 col-6">
                                                                        <canvas id="myChart1" width="400" height="400" style="max-height: 400px;"></canvas>
                                                                    </div>
                                                                    <div class="col-md-4  mb-2 col-6">
                                                                        <canvas id="myChart2" width="400" height="400" style="max-height: 400px;"></canvas>
                                                                    </div>
                                                                    <div class="col-md-4 mb-2 col-6">
                                                                        <canvas id="myChart3" width="400" height="400" style="max-height: 400px;"></canvas>
                                                                    </div>
                                                                    <div class="col-md-6  mb-2 col-6">
                                                                        <canvas id="myChart4" width="400" height="400" style="max-height: 400px;"></canvas>
                                                                    </div>
                                                                    <div class="col-md-6  mb-2 col-12">
                                                                        <canvas id="myChart5" width="400" height="400" style="max-height: 400px;"></canvas>
                                                                    </div>
                                                                    <div class="col-md-12  mb-2">
                                                                        <div class="card  round-1 border">
                                                                            <div class="card-body">
                                                                                <canvas id="myChart7" width="400" height="400" style="max-height: 300px;"></canvas>
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
                            </div>

                        </div>
                        <div class="text-center mt-3">
                            <img src="prevention.jpg" alt="" class="round-1 shadow img-fluid">
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>

    <div class="bg-white p-3 mt-5">
        <div class="container">
            <div class="h6 mb-0"><b>Data Source</b>: Medical and Dental Services Unit</div>
            <div class="smallTxt">Feedback from you is an important part of learning to do this better. Send us your comments and suggestions to improve through psu.cscs@gmail.com</div>
        </div>

    </div>

    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    <script src="psu.js"></script>
</body>

</html>