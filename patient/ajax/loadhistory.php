<?php
session_start();
include('../../php/db_config.php');

$keyword = $_POST['keyword'];
$today = $_POST['date'];

$sql = "SELECT * FROM diagnosis WHERE userid = " . $_SESSION['user']['userID'] . " ORDER BY id DESC";
if ($keyword != "") {
    $sql = "SELECT * FROM diagnosis WHERE userid = " . $_SESSION['user']['userID'] . " ORDER BY id DESC";
}
$result = mysqli_query($conn, $sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output = json_decode($row['result']);

        $original_date = $row['date'];

        // Creating timestamp from given date
        $timestamp = strtotime($original_date);

        // Creating new date format from that timestamp
        $date = date("F d, h:sa", $timestamp);


        $diff = date_diff(date_create($original_date), date_create($today));
        $age = $diff->format('%r%d');
        // echo $age;

        if (count($output) != 0) {
            $tester = $output[0]->Issue->Name;
        } else $tester = "";
        if ($keyword == "") {
            if ($age >= 0) {
?>

                <div class=" bg-white p-2  border round-1 mb-3">
                    <!-- <div class="me-3 ms-2">
        <img src="../assets/images/check.png" alt="" height="30" />
    </div> -->

                    <div>
                        <a href="viewhistory.php?id=<?= $row['id'] ?>" class="text-decoration-none smallTxt float-end mb-0">View <i class="fas fa-angle-right"></i></a>
                        <div class="smallTxt mb-0"><?= $date ?></div>

                        <div class="bg-light round-2 p-2">
                            <div class="smallTxt mb-0">Symptoms:
                                <?php
                                $symp = json_decode($row['symptoms']);
                                foreach ($symp as $s) {
                                    $sql = "SELECT * FROM symptoms WHERE symptomID = $s";
                                    $res = mysqli_query($conn, $sql)->fetch_assoc();
                                    echo $res['name'] . ", ";
                                }

                                ?>
                            </div>
                            <div class="smallTxt mb-0">Top result: <span class="fw-bold"><?= (count($output) != 0) ? $output[0]->Issue->Name : "No result" ?></span></div>
                        </div>


                    </div>
                    <!-- <div class="ms-auto">View</div> -->
                </div>
            <?php
            }
        }

        if ($keyword != "" && (substr_compare(strtolower($keyword), strtolower($tester), 0) == 0 && $age >= 0)) {
            // echo substr_compare(strtolower($keyword), strtolower($tester), 0);

            ?>

            <div class=" bg-white p-2  border round-1 mb-3">
                <!-- <div class="me-3 ms-2">
                <img src="../assets/images/check.png" alt="" height="30" />
            </div> -->

                <div>
                    <a href="viewhistory.php?id=<?= $row['id'] ?>" class="text-decoration-none smallTxt float-end mb-0">View <i class="fas fa-angle-right"></i></a>
                    <div class="smallTxt mb-0"><?= $date ?></div>

                    <div class="bg-light round-2 p-2">
                        <div class="smallTxt mb-0">Symptoms:
                            <?php
                            $symp = json_decode($row['symptoms']);
                            foreach ($symp as $s) {
                                $sql = "SELECT * FROM symptoms WHERE symptomID = $s";
                                $res = mysqli_query($conn, $sql)->fetch_assoc();
                                echo $res['name'] . ", ";
                            }

                            ?>
                        </div>
                        <div class="smallTxt mb-0">Top result: <span class="fw-bold"><?= (count($output) != 0) ? $output[0]->Issue->Name : "No result" ?></span></div>
                    </div>


                </div>
                <!-- <div class="ms-auto">View</div> -->
            </div>
<?php
        }
    }
}
