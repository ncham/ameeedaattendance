<?php 
    session_start();
    if (!isset($_SESSION['username']) || empty($_SESSION['username'])){
        header('Location: index.php');
    }

    include "includes/dbconnection.php";
    $empid = $_SESSION['empid'];
    
    $firstdow = strval(date('Y/m/d', strtotime("this week")));
    $lastdow = strval(date('Y/m/d', strtotime("this week +6 days")));
    $result = mysqli_query($conn, "SELECT * FROM attendance WHERE empid=$empid");
    $resultThisWeek = mysqli_query($conn, "SELECT * FROM attendance WHERE empid=$empid AND date BETWEEN '$firstdow' AND '$lastdow'");

    $resultEmp = mysqli_query($conn, "SELECT * FROM employee WHERE id=$empid");
?>

<!DOCTYPE html>

<head>
    <title>ameeeda Employee Attendance System</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="clock.css">
    <link rel="stylesheet" href="table.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <img class="logo" src="img/logo.jpg" alt="Logo">

    <div id="container">
        <ul class="nav nav-tabs" id="navigation">
            <li class="active"><a data-toggle="tab" href="#home"><span class="glyphicon glyphicon-time"></span>
                    Clock</a></li>
            <li><a data-toggle="tab" href="#menu1"><span class="glyphicon glyphicon-list-alt"></span> Attendance</a>
            </li>
            <li><a data-toggle="tab" href="#menu2"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
            <li><a data-toggle="tab" href="#menu3">Menu 3</a></li>
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <div class="row">
                    <div class="col-md-6">
                        <div id=clocksection>
                            <div id="clock">
                                <h3>Clock</h3>
                                <p><span id="date"></span></p>
                                <div id="time">
                                    <div><span id="hour">00</span></div>
                                    <div><span id="minute">00</span></div>
                                    <div><span id="second">00</span></div>
                                </div>
                            </div>
                            <div id="buttons">
                                <input type="button" value="Check-In" id="checkin" onclick="onClickCheck('CHECKIN')">
                                <input type="button" value="Break" id="break" onclick="onClickCheck('BREAK')">
                                <input type="button" value="Check-Out" id="checkout" onclick="onClickCheck('CHECKOUT')">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="schedulesection">
                            <h3>今週の出席 ( <?php echo $_SESSION['username'] ?> ) </h3>
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
                                    if (mysqli_num_rows($resultThisWeek) > 0) {
                                        while($row = mysqli_fetch_array($resultThisWeek)) {
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
                        </div>
                    </div>
                </div>
            </div>
            <div id="menu1" class="tab-pane fade">
                <h3>出席詳細</h3>
                <br/>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <input type="date" id="atndates" name="trip-start" value="2020-07-01" 
                            min="2018-01-01" max="2021-12-12">
                        <label for="atndates">:から</label>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="date" id="atndatee" name="trip-end" value="2018-07-30" 
                            min="2018-01-01" max="2021-12-12">
                        <label for="atndatee">:まで</label>
                    </div>
                </div>
                <br/>
                <table id="atndncetblall" class="content-table">
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
            </div>
            <div id="menu2" class="tab-pane fade">
                <h3>従業員の詳細</h3>
                <br/>
                <?php 
                    if (mysqli_num_rows($resultEmp) > 0) {
                        while($row = mysqli_fetch_array($resultEmp)) {
                ?>
                <div class="empcontainer" id="empcontainer" class="col-md-10">
                    <form action="employee.php" method="post" id="empfrm">
                        <div class="form-group row">
                            <label for="empid" class="col-md-2 col-form-label">Emp ID</label>
                            <div class="col-md-10">
                                <input type="text" readonly id="empid" name="empid" value="<?php echo $row ['id']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="firstname" class="col-md-2 col-form-label">Firstname</label>
                            <div class="col-md-10">
                                <input type="text" id="firstname" name="firstname"
                                    value="<?php echo $row ['firstname']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="middlename" class="col-md-2 col-form-label">Middlename</label>
                            <div class="col-md-10">
                                <input type="text" name="middlename" value="<?php echo $row ['middlename']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lastname" class="col-md-2 col-form-label">Lastname</label>
                            <div class="col-md-10">
                                <input type="text" name="lastname" value="<?php echo $row ['lastname']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-10">
                                <input type="text" name="email" value="<?php echo $row ['email']; ?>">
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" name="submit" value="Update">
                    </form>
                </div>
                <?php 
                        }
                    }
                ?>
            </div>
            <div id="menu3" class="tab-pane fade">
                <h3>Menu 3</h3>
                <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                </p>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    function clock() {
        var hours = document.getElementById('hour');
        var minutes = document.getElementById('minute');
        var seconds = document.getElementById('second');

        var d = new Date();
        var h = d.getHours();
        var m = (d.getMinutes() < 10 ? '0' : '') + d.getMinutes();
        var s = (d.getSeconds() < 10 ? '0' : '') + d.getSeconds();

        hours.innerHTML = h;
        minutes.innerHTML = m;
        seconds.innerHTML = s;
    }
    var interval = setInterval(clock, 1000);
    var dt = new Date();
    document.getElementById("date").innerHTML = dt.toLocaleDateString('ja-JP') + " " +
        dt.toLocaleDateString('ja-JP', {
            weekday: 'short'
        });

    function onClickCheck(clicktype) {
        $.ajax({
            type: 'POST',
            url: 'includes/crudattendance.php',
            data: {
                clickbutton: clicktype
            },
            success: function(data) {
                //alert(data);
            }
        })
        //data: 'date='+new Date().toLocaleDateString('ja-JP')+,

        //Refresh table once after adding record
        //Modify loaddata.php if you change the format of the table
        $(document).ready(function() {
            $("#attendancetable").load("includes/loaddata.php");
        });
    }
    </script>
</body>

</html>