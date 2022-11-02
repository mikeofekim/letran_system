<?php
session_start();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <link rel="icon" href="favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link href="http://fonts.cdnfonts.com/css/old-english-five" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css" />

    <title>Colegio de San Juan de Letran - Manaoag</title>

    <style>
        body{
           
            background-image: url("assets/images/bg.jpg") ;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-position: 0 50px;
            
        }

         a{
            
            text-decoration: none;
        }

         


     

        .container {
            max-width: 950px;
        }
    
        .logo{
            font-family: 'Old English Five', sans-serif;
            top: 3px;
            color:#1F618D;
            position: relative;
            vertical-align:center;
            font-weight:bold; 
            margin-left: 5px;
        }



        @media only screen and (max-width: 700px) {
            
            .logo{
                
                display: none;
            }


            .ref::before{
                color:#1f618d;
                font-family: 'Old English Five', sans-serif;
                position: relative;
                font-weight: bold;
                top: 3px;
                margin-left: 5px;
                content: "Letran - Manaoag";
            }
        }


       
    
    </style>
</head>

<body>
    
    <div class=" py-3 bg-light p-2 py-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="">
                    <a href="#" > 
                        <img src="assets/images/letran_logo.PNG?" alt="" height="60" width="60" />
                        <span class="ref"></span><span class="logo"> Colegio de San Juan de Letran - Manaoag</span>
                        
                      </a>


                </div>
                <div class="d-flex align-items-center">
               
                    <div class="fw-bold text-primary">
                        <a href="signin.php" class=" text-decoration-none btn btn-outline-primary smallTxt fw-bold round-1 px-3">
                            <?php

                            if (isset($_SESSION['userType'])) {
                                echo  $_SESSION['user']['firstName'] . " " . $_SESSION['user']['lastName'] . ' <i class="ms-2 fas fa-user-circle"></i>';
                            } else echo 'Login <i class="fas fa-sign-in-alt ms-2"></i>';


                            ?>

                        </a>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <div class="background"></div>
    <div class="further"></div>
    

   
    <footer class="" style="position: absolute; width: 100%; bottom: 0;">
        <div class="bg-light text-center p-2 py-3">
            <div class="smallTxt fw-light">Copyright &copy; 2022, Letran - Manaoag. All Rights Reserved.</div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $("#navcheck").addClass("bg-info text-white");
        $("#mySymptoms").load("../ajax/loadMySymptoms.php");
    </script>
</body>

</html>