<?php

require_once 'core.php';

date_default_timezone_set("Asia/Manila");

$data = $_POST['data'];
$qrContent = $_POST['qrData'];
$validator = md5($_POST['validator']);

$employeeQuery = "SELECT * FROM users WHERE full_name = '$qrContent' LIMIT 1";
$output = $connect->query($employeeQuery);

$dateNow = date("Y-m-d H:i:s");

if($output->num_rows > 0) {
    $value = $output->fetch_assoc();
    $user = $value['user_id'];
    $userFullName = $value['full_name'];

    if($value['password'] == $validator){
        if($data == 'Time-in'){
            $sql = "INSERT INTO attendance (user_id, time_in, date) VALUES ('$user', '$dateNow', '$dateNow')";
            if($connect->query($sql) === TRUE) {
                $valid['success'] = true;
                $valid['messages'] = "Successfully Added";
                $valid['greeting'] = "Good morning";
                $valid['name'] = $userFullName;	
            } else {
                $valid['success'] = false;
                $valid['messages'] = "Error while adding attendance";
            }
        }else{
            $sql = "UPDATE attendance SET time_out = '$dateNow' WHERE user_id = '$user' ORDER BY id DESC LIMIT 1";
            if($connect->query($sql) === TRUE) {
                $valid['success'] = true;
                $valid['messages'] = "Successfully Added";
                $valid['greeting'] = "Goodbye";
                $valid['end_greet'] = "Take care.";
                $valid['name'] = $userFullName;		
            } else {
                $valid['success'] = false;
                $valid['messages'] = "Error while adding attendance";
            }
        }
    }else{
         $valid['success'] = false;
         $valid['messages'] = "Invalid QRCode/Password. Please provide the correct one.";
    }
}else{
    $valid['success'] = false;
    $valid['messages'] = "QRCode is fake. Please contact the administrator";
}







$connect->close();

echo json_encode($valid);
