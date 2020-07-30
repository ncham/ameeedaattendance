<?php
require "dbconnection.php";

session_start();

$clickType = $_POST['clickbutton'];
$username = $_SESSION['username'];
$empid = $_SESSION['empid'];
$stmt = "";

date_default_timezone_set("Asia/Tokyo");
$date = date("Y/m/d");
$time = date("H:i:s");

switch ($clickType)
{
    case "CHECKIN":
        $sql = "SELECT id FROM attendance where empid=? and date=?";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql))
        {
            mysqli_stmt_bind_param($stmt, "ss", $empid, $date);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultRows = mysqli_stmt_num_rows($stmt);
            if ($resultRows > 0) //If employee is already checked in
            {
                echo "You're already Checked-In";
                exit();
            }
        }

        $sql = "INSERT INTO attendance (empid, date, timein) VALUES (?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql))
        {
            mysqli_stmt_bind_param($stmt, "sss", $empid, $date, $time);
            mysqli_stmt_execute($stmt);
            exit();
        }
    break;

    case "BREAK":
        $qkout = date("H:i:s", strtotime($time)+60*60);
        $sql = "UPDATE attendance SET qkin=?, qkout=? WHERE empid=? AND date=? AND (qkin IS NULL OR qkin='' OR qkin=0)";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql))
        {
            mysqli_stmt_bind_param($stmt, "ssss", $time, $qkout, $empid, $date);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultRows = mysqli_stmt_affected_rows($stmt);
            echo $resultRows . " records were updated.";
            exit();
        }else{
            echo mysqli_error($conn);
        }
        //$sqlStatement = "UPDATE attendance SET qkin = $time, qkout=TIME()+1 
        //WHERE username=$username AND date=DATE()";
    break;

    case "CHECKOUT":
        $sql = "UPDATE attendance SET timeout=? WHERE empid=? AND date=? AND (timeout IS NULL OR timeout='' OR timeout=0)";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql))
        {
            mysqli_stmt_bind_param($stmt, "sss", $time, $empid, $date);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultRows = mysqli_stmt_affected_rows($stmt);
            echo $resultRows . " records were updated.";
            exit();
        }else{
            echo mysqli_error($conn);
        }
    break;
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
