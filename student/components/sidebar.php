<div class=" col-md-3 col-sm-12 col-12  d-none d-sm-none d-md-block p-4">
    <div class="card bg-light border-0 round-0 shadow-sm" style="height: calc(100vh - 50px)">
        <div class="card-body">
            <div class=" py-2">
                <div class="mb-3">
                    <a href="index.php" style="text-decoration: none;"> <img src="../assets/images/letran_logo.PNG?" alt="" height="45">
                    <span class="h5 fw-bold " style="color: #1F618D;">Letran - Manaoag</span>
                    </a>
                </div>


                <div class="d-flex flex-row align-items-center my-4">
                    <div class="mb me-2"><img src="../assets/images/<?= $_SESSION['user']['imagefile'] ?>" class="round shadow-sm" height="60" width="60" alt=""></div>
                    <div class="">
                        <div class="h5 mb-0 fw-bold text-wrap"><?= $_SESSION['user']['firstName'] . " " . $_SESSION['user']['lastName'] ?></div>
                        <div class="h6 mb-0 "><span class="badge bg-primary">Student</span></div>
                    </div>
                </div>


                <div class="py-3 ">
                    <div class=" h6 d-flex align-items-center mb-2 py-3 sidebtn round-1" id="navhome" onclick="window.location.href='index.php'">
                        <div class="text-center" style="width: 50px"> <i class="fas fa-home"></i></div>
                        <div class="mb-0 fw-bold">Home</div>
                        <div class="ms-auto me-3"><i class="fas fa-chevron-right"></i></div>
                    </div>

             
                    <div class=" h6 d-flex align-items-center   mb-2 py-3 sidebtn round-1" id="navrecord" onclick="window.location.href='records.php'">
                        <div class="text-center" style="width: 50px"> <i class="fas fa-list"></i></div>
                        <div class="mb-0 fw-bold">reports</div>
                        <div class="ms-auto me-3"><i class="fas fa-chevron-right"></i></div>
                    </div>
                </div>

                <hr>
                <div class="py-3 mt-4 ">
                    <div class=" h6 d-flex align-items-center mb-2 py-3 sidebtn round-1" id="navaccount" onclick="window.location.href='account.php'">
                        <div class="text-center" style="width: 50px"><i class="fas fa-cog"></i></div>
                        <div class="mb-0 fw-bold">Account settings</div>
                        <div class="ms-auto me-3"><i class="fas fa-chevron-right"></i></div>
                    </div>
                    <div class="text-danger h6 d-flex align-items-center mb-2 py-3 sidebtn round-1" onclick="window.location.href='../php/logout.php'">
                        <div class="text-center" style="width: 50px"> <i class="fas fa-sign-out-alt"></i></div>
                        <div class="mb-0 fw-bold">Logout</div>
                    </div>
                </div>


            </div>
        </div>
    </div>

</div>