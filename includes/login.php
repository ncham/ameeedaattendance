<?php
if (isset($_POST['login-submit']))
{
    require "dbconnection.php";

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user where username=?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql))
    {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $userCount = mysqli_num_rows($result);
        if ($userCount > 0)
        {
            if ($row = mysqli_fetch_assoc($result))
            {
                if ($row['password'] == $password)
                {
                    echo "Login success";
                    session_start();
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['roleid'] = $row['roleid'];
                    $_SESSION['empid'] = $row['empid'];
                    header('Location: ../home.php');
                }else{
                    echo "Incorrect password";
                }
            }
        }else
        {
            echo "Invalid username";
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>