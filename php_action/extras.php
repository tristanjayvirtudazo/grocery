<?php
function revenueCount ($query){
		$totalRevenue = 0;
		while($row = $query->fetch_array()){
			$totalRevenue += doubleval($row[2]);
		}
		return number_format($totalRevenue, 2, '.', ',');
}


function displayLogs ($query){
	if($query->num_rows > 0){
		$row_count = 1;
		while($row = $query->fetch_array()){
			echo '<tr>';
            echo '<th scope="row">'.$row_count.'</th>';
            echo '<td>'.$row[0].'</td>';
            echo '<td>'.$row[1].'</td>';
            echo '<td>'.$row[4].'</td>';
            echo '<td>'.$row[2].'</td>';
            echo '<td>'.$row[5].'</td>';
            echo '<td>'.$row[3].'</td>';
            echo '</tr>';
		}
	}
}


function dateDiffInDays($date1, $date2) {
    
    // Calculating the difference in timestamps
    $diff = strtotime($date2) - strtotime($date1);
  
    // 1 day = 24 hours
    // 24 * 60 * 60 = 86400 seconds
    return round($diff / 86400);
}


function calculateWorkHours($startDate, $endDate) {
    $startDateTime = new DateTime($startDate);
    $endDateTime = new DateTime($endDate);

    // Calculate the difference between the start and end date/time
    $interval = $startDateTime->diff($endDateTime);

    // Get the total hours and minutes from the difference
    $hours = $interval->format('%h');
    $minutes = $interval->format('%i');

    // Calculate the total minutes
    $totalMinutes = ($hours * 60) + $minutes;

    // Calculate the hours and minutes in H:mm format
    $formattedHours = floor($totalMinutes / 60);
    $formattedMinutes = $totalMinutes % 60;

    return sprintf('%d:%02d', $formattedHours, $formattedMinutes);
}

