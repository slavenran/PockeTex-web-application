<?php
session_start();

include_once '../database/Database.php';
include_once '../models/Comments.php';

$database = new Database();
$db = $database->connect();

if (!isset($_SESSION["username"])) {
    header("Location: ../forms/index.php");
}

$id = isset($_GET['id']) ? $_GET['id'] : die();

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

        $(document).ready(function () {
            $.ajax({
                type: 'get',
                url: '../api/comments/read_single_comment.php?id=' + "<?php echo $id; ?>",
                success: function (response) {
                    var comments = "<table style='width: 100%;'>";
                    comments += "<tr>";
                    comments += "<td style='text-align: left; width: 60%;'><textarea class='form-control' style='margin-top: 20px' id='update-text'>"
                        + response.text + "</textarea><input id='update' type='button' class='buttonz' value='Edit' name='edit'/>" +
                        "<a href='comments.php'><input id='back' type='button' class='buttonz' style='margin-right: 5px' value='<- Back' name='back'/></a></td>";

                    comments += "</tr>";
                    comments += "</table>";
                    $('#tabela').html(comments);
                }
            });

            $('#tabela').on('click', '#update', function () {
                $.ajax({
                    type: 'post',
                    url: '../api/comments/update_comment.php',
                    data: {
                        comment: document.getElementById("update-text").value,
                        id: "<?php echo $id; ?>"
                    },
                    success: function (response) {
                        $.ajax({
                            type: 'get',
                            url: '../api/comments/read_single_comment.php?id=' + "<?php echo $id; ?>",
                            success: function (response) {
                                alert('You successfully edited the comment.');
                                var comments = "<table style='width: 100%;'>";
                                comments += "<tr>";
                                comments += "<td style='text-align: left; width: 60%;'><textarea class='form-control' style='margin-top: 20px' id='update-text'>"
                                    + response.text + "</textarea><input id='update' type='button' class='buttonz' value='Edit' name='edit'/>" +
                                    "<a href='comments.php'><input id='back' type='button' class='buttonz' style='margin-right: 5px' value='<- Back' name='back'/></a></td>";

                                comments += "</tr>";
                                comments += "</table>";
                                $('#tabela').html(comments);
                            }
                        });
                    }
                });
            });
        });
    </script>

    <style>
        body {
            background-color: #116466;
            margin: 0;
        }

        .buttonz {
            border-radius: 10px;
            background-color: #4cae4c;
            color: white;
            border: 0px;
            margin-top: 2px;
            padding: 3px 10px;
            float: right;
        }

        .buttonz:hover {
            background-color: #3e8f3e;
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
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manufacturers.php">Manufacturers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="phones.php">Phones</a>
                </li>
                <li class="nav-item active">
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

<div class="pozadina">
    <form id="form" name="form" method="post">
        <br/><br/>
        <div class="tabela container col-xs-10 col-sm-10 col-md-7 col-lg-7 col-xl-8">
            <div class="tabela" id="tabela">
            </div>
        </div>
    </form>
</div>
</body>

