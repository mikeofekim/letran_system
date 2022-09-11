<?php
session_start();
include('php/db_config.php');
date_default_timezone_set("Asia/Manila");
$arr = [];
$filename = "psu-data.csv";

$campuses = [array("Alaminos", 0, 0, 0), array("Asingan", 0, 0, 0), array("Bayambang", 0, 0, 0), array("Binmaley", 0, 0, 0), array("Infanta", 0, 0, 0), array("Lingayen", 0, 0, 0), array("San Carlos", 0, 0, 0), array("Sta Maria", 0, 0, 0), array("Urdaneta", 0, 0, 0)];
$overall = [0, 0, 0];
$trends = [array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0), array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0), array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0), array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0), array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0), array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0), array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0), array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0), array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0), array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)];
$row = 1;


$sex = [0, 0];
$comorbidity = [0, 0];
$teaching = [0, 0];
$quarantine = [0, 0, 0];
$vaccine = [0, 0, 0];
$age = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

$start_month = date("m") - 11;
$months = [];


for ($x = $start_month; $x < ($start_month + 12); $x++) {
    array_push($months, date("M Y", mktime(0, 0, 0, $x, 10)));
}

if (($handle = fopen("uploads/" . $filename, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        $row++;
        if ($row == 2) continue;

        else {
            for ($x = 0; $x < count($campuses); $x++) {

                if ($campuses[$x][0] == $data[1]) {
                    if (trim($data[15]) == "Active" || trim($data[15]) == "") {
                        $campuses[$x][1]++;
                        $overall[0]++;
                    } else if (trim($data[15]) == "Recovered") {
                        $campuses[$x][2]++;
                        $overall[1]++;
                    } else if (trim($data[15]) == "Deceased") {
                        $campuses[$x][3]++;
                        $overall[2]++;
                    }



                    //

                    $date = $data[12];
                    $date = explode('/', $date);
                    $month = $date[0];

                    for ($xx = 0, $y = $start_month; $xx < 12; $xx++, $y++) {

                        if (number_format($month) == $y) {
                            $trends[$x][$xx]++;
                            $trends[9][$xx]++;
                            break;
                        }
                    }

                    if ($data[4] == "Male") {
                        $sex[0]++;
                    } else if ($data[4] == "Female") {
                        $sex[1]++;
                    }


                    if ($data[8] == "Yes") {
                        $comorbidity[0]++;
                    } else if ($data[8] == "No" || $data[7] == "") {
                        $comorbidity[1]++;
                    }

                    if ($data[5] == "Teaching") {
                        $teaching[0]++;
                    } else if ($data[5] == "Non-teaching") {
                        $teaching[1]++;
                    }


                    if ($data[11] == "Home") {
                        $quarantine[0]++;
                    } else if ($data[11] == "Work") {
                        $quarantine[1]++;
                    } else if ($data[11] == "Unknown") {
                        $quarantine[2]++;
                    }

                    if ($data[10] == "Unvaccinated") {
                        $vaccine[0]++;
                    } else if ($data[10] == "Vaccinated(1st Dose)") {
                        $vaccine[1]++;
                    } else if ($data[10] == "Vaccinated(Fully)") {
                        $vaccine[2]++;
                    }

                    // 25 - 29
                    // 30 - 34
                    // 35 - 39
                    // 40 - 44
                    // 45 - 49
                    // 50 - 54
                    // 55 - 59
                    // 60 - 64
                    if (trim($data[3]) == "20-24") {
                        $age[0]++;
                    } else if (trim($data[3]) == "25-29") {
                        $age[1]++;
                    } else if (trim($data[3]) == "30-34") {
                        $age[2]++;
                    } else if (trim($data[3]) == "35-39") {
                        $age[3]++;
                    } else if (trim($data[3]) == "40-44") {
                        $age[4]++;
                    } else if (trim($data[3]) == "45-49") {
                        $age[5]++;
                    } else if (trim($data[3]) == "50-54") {
                        $age[6]++;
                    } else if (trim($data[3]) == "55-59") {
                        $age[7]++;
                    } else if (trim($data[3]) == "60-64") {
                        $age[8]++;
                    } else $age[8]++;
                    break;
                }
            }
        }
    }
    fclose($handle);
}


// exit(json_encode(array($names, $count)));
$campus_name = [];
$active_cases = [];
$recovered_cases = [];
$deceased_cases = [];
foreach ($campuses as $campus) {
    array_push($campus_name, $campus[0]);
    array_push($active_cases, $campus[1]);
    array_push($recovered_cases, $campus[2]);
    array_push($deceased_cases, $campus[3]);
}


exit(json_encode(array($campus_name, $active_cases, $recovered_cases, $deceased_cases, $overall, $trends, $months, array($sex, $comorbidity, $teaching, $quarantine, $vaccine, $age))));
