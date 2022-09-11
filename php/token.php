<?php
// include 'db_config';
require 'token_generator.php';

class token {



    public function getTokenNow($conn) {

        $sql = "SELECT * FROM tokens WHERE no_request < 100";
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {



                if ($row['date_ended'] == null) {


                    $live_username = $row['live_username'];
                    $live_password = $row['live_password'];
                    $tokenGenerator = new TokenGenerator('Ke7z5_DWGTCM_COM_AUT', 'x8TKi7g2B3QeGw96W', 'https://authservice.priaid.ch/login');
                    // $tokenGenerator = new TokenGenerator($live_username, $live_password, 'https://authservice.priaid.ch/login');
                    $token = $tokenGenerator->loadToken();
                    return array($row['tokenID'], $token->Token);
                    break;
                } else {
                    $date1 = date_create($row['date_ended']);
                    $date2 = date_create(date('Y-m-d'));
                    $diff = date_diff($date1, $date2);
                    $diff = number_format($diff->format("%R%a"));
                    if ($diff > 31) {
                        $tokenID = $row['tokenID'];
                        $sql = "UPDATE tokens SET  date_ended = null WHERE tokenID = $tokenID";
                        mysqli_query($conn, $sql);

                        $live_username = $row['live_username'];
                        $live_password = $row['live_password'];
                        $tokenGenerator = new TokenGenerator('Ke7z5_DWGTCM_COM_AUT', 'x8TKi7g2B3QeGw96W', 'https://authservice.priaid.ch/login');
                        // $tokenGenerator = new TokenGenerator($live_username, $live_password, 'https://authservice.priaid.ch/login');
                        $token = $tokenGenerator->loadToken();
                        return array($row['tokenID'], $token->Token);
                        break;
                    } else {
                        continue;
                    }
                }
            }
        }
    }
}
