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
                type: 'post',
                url: '../api/phones/read_phones.php',
                data: {
                    id: $('#manufacturer').val()
                },
                success: function (response) {

                    var htmlString = "";
                    htmlString += "<table class='table table-striped' style='width: 100%; height: 100%; color: #3d3b3c'>";
                    htmlString += "<tr><td style='background-color:  #d1e8e2; text-align: center'>Model</td>" +
                        "<td style='background-color:  #d1e8e2;  text-align: center'>Year</td>" +
                        "<td style='background-color:  #d1e8e2;  text-align: center'>Options</td></tr>";
                    for (var i = 0; i < response.length; i++) {
                        htmlString += "<tr>";
                        htmlString += "<td style='text-align: center'>" + response[i].model + "</td>";
                        htmlString += "<td style='text-align: center'>" + response[i].year + "</td>";
                        htmlString += "<td style='text-align: center'><a href='http://localhost/php/HALPv2/api/phones/delete_phone.php?id=" + response[i].id + "'><input type='button' class='buttonz' value='Delete'/></a></td>";
                        htmlString += "</tr>";
                    }
                    htmlString += "</table>";
                    $('#tabela').html(htmlString);
                }
            });
        }

        function post_data() {
            $.ajax({
                type: 'post',
                url: '../api/phones/create_phone.php',
                data: {
                    model: $('#modelText').val(),
                    year: $('#year').val(),
                    manuId: $('#manufacturer').val()
                },
                success: function (response) {
                    var message = JSON.parse(response);
                    alert(message.message);
                    fetch_data();
                }
            });
        }

        function enablePhone() {
            document.getElementById("modelText").disabled = false;
            document.getElementById("submitPhone").disabled = false;
            document.getElementById("year").disabled = false;
        }

        function disablePhone() {
            document.getElementById("modelText").disabled = true;
            document.getElementById("submitPhone").disabled = true;
            document.getElementById("year").disabled = true;
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

        .buttonz:hover {
            background-color: #3e8f3e;
        }

        .select-css {
            font-size: 14px;
            font-family: sans-serif;
            color: white;
            box-sizing: border-box;
            width: 120px;
            margin: 0;
            border: 2px solid #4cae4c;
            box-shadow: 0 1px 0 1px rgba(0, 0, 0, .04);
            border-radius: .5em;
            -moz-appearance: none;
            -webkit-appearance: none;
            appearance: none;
            background-color: #fff;
            background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23007CB2%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'),
            linear-gradient(to bottom, #4cae4c 40%, #4cae4c 100%);
            background-repeat: no-repeat, repeat;
            background-position: right .7em top 50%, 0 0;
            background-size: .65em auto, 100%;
        }

        .select-css::-ms-expand {
            display: none;
        }

        .select-css:hover {
            border-color: #3e8f3e;
        }

        .select-css:focus {
            color: white;
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
                <li class="nav-item">
                    <a class="nav-link" href="manufacturers.php">Manufacturers</a>
                </li>
                <li class="nav-item active">
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
            <table align="center">
                <tr>
                    <td colspan='3' align="center"><select id="manufacturer" class="select-css" style="margin-left: -70px; margin-bottom: 10px" onchange="fetch_data(), enablePhone()">
                            <option value="ori" onclick="disablePhone()">Manufacturer...</option>
                            <?php
                            $sql = "SELECT * FROM manufacturers";
                            $stmt = $db->prepare($sql);
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                            }
                            ?>
                        </select></td>
                </tr>
                <tr>
                    <td>Model:</td>
                    <td colspan='2'>Year:</td>
                </tr>
                <tr>
                    <td style='text-align: center'>
                        <input type='text' name='modelText' id='modelText' disabled/></td>
                    <td style='text-align: center'>
                        <input type='text' name='year' id='year' disabled/></td>
                    <td style='text-align: center'><input type='button' value='Create' id='submitPhone' class='buttonz'
                                                          style='font-weight: bold; height: 30px; width: 100px;'
                                                          onclick='post_data()' disabled/></td>
                </tr>
            </table>
            </br></br>
            <div class="tabela table-responsive container" id="tabela" style="padding-top: 50px">


            </div>
        </form>


    </div>
</div>
</body>
</html>
