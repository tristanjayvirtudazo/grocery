<?php

require_once 'db_connect.php';

$siteKey = "59e2ba2f-a50a-414b-9dd6-dec59d778b1d";
$secretKey = "0x6eB62f2c43e0B29C090A463711d34b9868cEBCD1";

$postData = $statusMsg = '';
$status = 'error';
if(isset($_POST['postBtn'])){
    $postData = $_POST;


    if(!empty($_POST['fullName']) && !empty($_POST['email']) && !empty($_POST['comment'])){
         if(!empty($_POST['h-captcha-response'])){

            $verifyURL = 'https://hcaptcha.com/siteverify';

            $token = $_POST['h-captcha-response'];

            $data = array(
                'secret' => $secretKey,
                'response' => $token,
                'remoteip' => $_SERVER['REMOTE_ADDR']  
            );


            $curlConfig = array(
                CURLOPT_URL => $verifyURL,
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => $data
            );

            $ch = curl_init();
            curl_setopt_array($ch, $curlConfig);
            $response = curl_exec($ch);
            curl_close($ch);


            $responseData = json_decode($response);

            if($responseData->success){
                $fullName =  $_POST['fullName'];
                $email = $_POST['email'];
                $comment = $_POST['comment'];
                $branchId = $_POST['branchId'];

                $sql = "INSERT INTO reviews (branch_id, email, name, review, date) VALUES ('$branchId', '$email', '$fullName', '$comment', NOW())";

                $connect->query($sql);

                $status = 'success';
                $statusMsg = 'Your review is submitted Successfully.';
                $postData = '';
            }else{
                $status = 'danger';
                $statusMsg = 'Captcha verification failed. Please Try Again.';
            }
         }else{
            $status = 'danger';
            $statusMsg = 'Please check on Captcha box.';
         }
    }else{
        $status = 'danger';
        $statusMsg = 'Pleae fill-in the required fields.';
    }
}