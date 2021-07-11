<?php
session_start();

if(!isset($_SESSION['username'])) {
    header('location: ../forms/index.php');
}

if($_SESSION['username'] == 'admin') {
    header('location: ../admin/home.php');
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

</head>
<body>

<!-- Navigation -->

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
                    <a class="nav-link" href="phones.php">Phones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="comments.php">Discussion</a>
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

<!-- Image Slider -->

<div id="slides" class="carousel slide" data-ride="carousel">
    <ul class="carousel-indicators">
        <li data-target="#slides" data-slide-to="0" class="active"></li>
        <li data-target="#slides" data-slide-to="1"></li>
        <li data-target="#slides" data-slide-to="2"></li>
    </ul>
    <div class="carousel-inner" style="overflow: hidden">
        <div class="carousel-item active">
            <img src="../images/slides/Mi-Mix-Alpha-camera-setup.jfif" style="max-height: 100%; max-width: 100%"/>
            <div>

            </div>
        </div>
        <div class="carousel-item">
            <img src="../images/slides/TJDYpZN3r8B7onh2imuNah.jfif" style="max-height: 100%; max-width: 100%"/>
        </div>
        <div class="carousel-item">
            <img src="../images/slides/nintchdbpict000287743665.jfif" style="max-height: 100%; max-width: 100%"/>
        </div>
    </div>
</div>

<!-- Jumbrotron -->
<div class="container-fluid">
    <div class="row jumbotron">
        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
            <p class="lead">Lorem ipsim me iz dipsum Lorem ipsim me iz dipsum Lorem ipsim me iz dipsum Lorem ipsim me iz dipsum
                Lorem ipsim me iz dipsum Lorem ipsim me iz dipsum Lorem ipsim me iz dipsum Lorem ipsim me iz dipsum </p>
        </div>
    </div>
</div>

<!-- Welcome Section -->
<div class="container-fluid padding">
<div class="row welcome text-center">
    <div class="col-12">
        <h1 class="display-4">Explore brand new smartphones.</h1>
    </div>
    </hr>
    <div class="col-12">
        <p class="lead">Lorem ipsim me iz dipsum Lorem ipsim me iz dipsum Lorem ipsim me iz dipsum Lorem ipsim me iz dipsum
            Lorem ipsim me iz dipsum</p>
    </div>
</div>
</div>
</body>
</html>