<nav class="navbar navbar-expand-lg navbar-light bg-light d-block d-sm-block d-md-none ">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index.php"> <img src="../assets/images/logo.PNG?" alt="" height="30"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse bg-white round-1 m-2 p-2 ps-3 shadow-sm" id="navbarNav">

            <div class="d-flex flex-row align-items-center my-1">
                <div class="mb me-2  round-1"><img src="../assets/images/<?= $_SESSION['user']['imagefile'] ?>" class="round shadow-sm" height="60" width="60" alt="">
                </div>
                <div class="">
                    <div class="h5 mb-0 fw-bold text-nowrap">Dr. <?= $_SESSION['user']['firstName'] . " " . $_SESSION['user']['lastName'] ?></div>
                    <div class="h6 mb-0 "><span class="badge bg-primary">Health Professional</span></div>
                </div>
            </div>


            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <div class="d-flex align-items-center">
                            <div class="text-center" style="width: 30px"><i class="fas fa-home"></i></div>
                            <div class="h6 mb-0">Home</div>
                        </div>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="students.php">
                        <div class="d-flex align-items-center">
                            <div class="text-center" style="width: 30px"><i class="fas fa-user"></i></div>
                            <div class="h6 mb-0">Students</div>
                        </div>


                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="records.php">
                        <div class="d-flex align-items-center">
                            <div class="text-center" style="width: 30px"><i class="fas fa-list"></i></div>
                            <div class="h6 mb-0">Records</div>
                        </div>


                    </a>
                </li>
                <hr>
                <li class="nav-item">
                    <a class="nav-link" href="account.php">
                        <div class="d-flex align-items-center">
                            <div class="text-center" style="width: 30px"> <i class="fas fa-cog"></i></div>
                            <div class="h6 mb-0">Account</div>
                        </div>

                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../php/logout.php">
                        <div class="d-flex align-items-center text-danger">
                            <div class="text-center" style="width: 30px"><i class="fas fa-sign-out-alt"></i></div>
                            <div class="h6 mb-0">Logout</div>
                        </div>


                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>