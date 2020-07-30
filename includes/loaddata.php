<?php
session_start();
require "dbconnection.php";

$empid = $_SESSION['empid'];
$firstdow = date('Y/m/d', strtotime("this week")); 
$lastdow = date('Y/m/d', strtotime("this week +6 days")); 
$result = mysqli_query($conn,"SELECT * FROM attendance WHERE empid=$empid AND date BETWEEN '$firstdow' AND '$lastdow'");
?>

<table id="attendancetable" class="content-table">
    <thead>
        <tr>
            <th>Type</th>
            <th>Date</th>
            <th>Check-In</th>
            <th>Break In</th>
            <th>Break Out</th>
            <th>Check-Out</th>
        </tr>
    </thead>
    <tbody>

<?php
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>出勤</td>";
        echo "<td>".$row["date"]."</td>";
        echo "<td>".$row["timein"]."</td>";
        echo "<td>".$row["qkin"]."</td>";
        echo "<td>".$row["qkout"]."</td>";
        echo "<td>".$row["timeout"]."</td>";
        echo "</tr>";
    }
}
?>
    </tbody>
</table>