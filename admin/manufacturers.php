<?php
session_start();

include_once '../database/Database.php';
$database = new Database();
$db = $database->connect();

if (!isset($_SESSION["username"])) {
    header("Location: ../forms/index.php");
}

if (!$_SESSION["username"] == "admin") {
    header("Location: ../user/home.php");
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

    <script>

        function fetch_data() {
            $.ajax({
                type: 'get',
                url: '../api/manufacturers/read_manufacturers.php',
                success: function (response) {
                    var htmlString = "<table class='table table-striped' style='width: 100%; height: 100%; color: #3d3b3c'>" +
                        "<tr><td style='background-color:  #d1e8e2; text-align: center'>Manufacturer</td>" +
                        "<td style='background-color:  #d1e8e2;  text-align: center'>Country</td>" +
                        "<td style='background-color:  #d1e8e2;  text-align: center'>Options</td></tr>";
                    for(var i = 0; i < response.length; i++) {
                        htmlString += "<tr>";
                        htmlString += "<td style='text-align: center'>" + response[i].name + "</td>";
                        htmlString += "<td style='text-align: center'>" + response[i].country + "</td>";
                        htmlString += "<td style='text-align: center'><a href='http://localhost/php/HALPv2/api/manufacturers/delete_manufacturer.php?id=" + response[i].id + "'><input type='button' class='buttonz' value='Delete'/></a></td>";
                        htmlString += "</tr>";
                    }
                    htmlString += "<tr><td style='text-align: center'>" +
                        "<input type='text' name='manuText' id='manuText'/></td>" +
                        "<td style='text-align: center'>" +
                        "<input type='text' name='country' id='country'/></td>" +
                        "<td style='text-align: center'><input type='button' value='Create' id='submitManu' class='buttonz'" +
                        "style='font-weight: bold; height: 30px; width: 100px;'" +
                        "onclick='post_data()'/></td></tr>";
                    htmlString += "</table>";
                    $('#tabela').html(htmlString);
                }
            });
        }

        function post_data() {
            $.ajax({
                type: 'post',
                url: '../api/manufacturers/create_manufacturer.php',
                data: {
                    name: $('#manuText').val(),
                    country: $('#country').val()
                },
                success: function (response) {
                    var message = JSON.parse(response);
                    alert(message.message);
                    fetch_data();
                }
            });
        }
    </script>

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

        .hello {
            color: #3d3b3c;
            background-color: white;
            height: 600px;
            display: table-cell;
        }

        .buttonz {
            border-radius: 10px;
            background-color: #4cae4c;
            color: white;
            border: 0px;
            margin-top: 2px;
            padding: 3px 10px;
            box-shadow: 2px 3px 6px -3px black;
        }

        .buttonz:hover{
            background-color: #3e8f3e;
        }
    </style>
</head>
<body onload="fetch_data()">
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
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="manufacturers.php">Manufacturers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Phones.php">Phones</a>
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
<div class="pozadina  col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
    <div class="hello container">
        <form id="form" name="form" method="post">
            <br/>
            <br/>
            <div class="tabela table-responsive container" id="tabela" style="padding-top: 50px">


            </div>
        </form>


    </div>
</div>
</body>
</html>
