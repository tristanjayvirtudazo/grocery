<?php

require_once 'core.php';
require_once 'extras.php';
// Assuming you have retrieved the start and end dates from the HTML form
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];

$start_date = date('Y-m-d', strtotime($start_date));
$end_date = date('Y-m-d', strtotime($end_date));

$branch = $_SESSION['branch'];
$role = $_SESSION['role_type'];

// Construct the SQL query with the dynamic dates
if($role != 'admin'){
    $sql = "SELECT u.full_name, u.branch_name, a.time_in, a.time_out, a.date
    FROM attendance a
    JOIN users u ON a.user_id = u.user_id
    WHERE u.branch_name = '$branch' AND a.date BETWEEN '$start_date' AND '$end_date'";
}else{
    $sql = "SELECT u.full_name, u.branch_name, a.time_in, a.time_out, a.date
    FROM attendance a
    JOIN users u ON a.user_id = u.user_id
    WHERE a.date BETWEEN '$start_date' AND '$end_date'";
}


// Execute the query
$result = $connect->query($sql);

// Check if the query was successful
if ($result) {
    // Create an array to store the fetched data
    $data = array();

    // Fetch the rows and add them to the data array
    while ($row = $result->fetch_assoc()) {
        $row['workHours'] = calculateWorkHours($row['time_in'], $row['time_out']);
        $data[] = $row;
    }

    // Convert the data array to JSON format
    $json_data = json_encode($data);

    // Return the JSON response
    header('Content-Type: application/json');
    echo $json_data;
} else {
    echo "Error executing query: " . $connect->error;
}

// Close the database connection
$connect->close();



