<?php
session_start();

if(!isset($_SESSION['username']) || $_SESSION['username'] != 'admin') {
    header('location: ../forms/index.php');
}
?>

<html>
<head>
    <title>PockeTex</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/44e18238b5.js"></script>
    <style>
        body {
            background-color: #116466;
            margin: 0;
        }

        .pozadina {
            position: relative;
            margin: auto;
            margin-top: 10px;
            margin-bottom: 10px;
            display: table;
        }

        .hello{
            color: #3d3b3c;
            background-color: white;
            height: 600px;
            display: table-cell;
            background-size: cover;
        }

        p {
            color: #2c3531;
            font-size: 40px;
            margin-top: 10px;
            margin-left: 10px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" style="margin: -10px" href="home.php">
            <img src="../images/android-png-android-png-photos-399.png" width="60px" height="60px"/>
            <h3 style="color: #116466; float: right; margin: 10px 21px 10px 15px; font-weight: bold">PockeTex</h3>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manufacturers.php">Manufacturers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="phones.php">Phones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="comments.php">Discussion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="users.php">Users</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../forms/logout.php"><span class="fas fa-sign-out-alt"></span> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="pozadina col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
    <div class="hello container"><p>Welcome to the admin panel! </p>
    </div>
</div>
</body>
</html>