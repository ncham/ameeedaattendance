<?php
if (isset($_POST['signup-submit']))
{
    require "dbconnection.php";

    $empid = $_POST['empid'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rptpassword = $_POST['rptpassword'];
    $roleid = "3";

    //Check whether the user trying to sign up is a registered Employee
    $sql = "SELECT id FROM employee where id=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        echo "Error statement preparation";
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "s", $empid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultRows = mysqli_stmt_num_rows($stmt);
        if ($resultRows > 0)    //If registered employee
        {
            //Check whether employee is already registered user
            $sql = "SELECT * FROM user WHERE empid=?";
            $stmt = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt, $sql))
            {
                mysqli_stmt_bind_param($stmt, "s", $empid);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultRows = mysqli_stmt_num_rows($stmt);
                if ($resultRows > 0)
                {
                    echo "You're already signed up Employee.";
                    exit();
                }
                else
                {
                    //Check whether the username is already taken
                    $sql = "SELECT * FROM user WHERE username=?";
                    $stmt = mysqli_stmt_init($conn);
                    if (mysqli_stmt_prepare($stmt, $sql))
                    {
                        mysqli_stmt_bind_param($stmt, "s", $username);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        $resultRows = mysqli_stmt_num_rows($stmt);
                        if ($resultRows > 0) //if username is already exists
                        {
                            echo "Username already taken";
                            exit();
                        }
                        else
                        {
                            $sql = "INSERT INTO user(roleid,empid,username,password) VALUES(?,?,?,?)";
                            $stmt = mysqli_stmt_init($conn);
                            if (mysqli_stmt_prepare($stmt, $sql))
                            {
                                mysqli_stmt_bind_param($stmt, "ssss", $roleid, $empid, $username, $password);
                                mysqli_stmt_execute($stmt);

                                session_start();
                                $_SESSION['username'] = $username;
                                $_SESSION['roleid'] = $roleid;
                                $_SESSION['empid'] = $empid;
                                header('Location: ../home.php');

                                exit();
                            }
                        }
                    }

                }
            }
        }
        else
        {
            echo "You're not a registered employee. Please contact admin division.";
            exit();
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
