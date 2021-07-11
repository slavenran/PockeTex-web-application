<?php
session_start();

include_once '../database/Database.php';
$database = new Database();
$db = $database->connect();

if (!isset($_SESSION["username"])) {
    header("Location: ../forms/index.php");
}

if ($_SESSION["username"] != "admin") {
    header("Location: ../user/comments.php");
}
?>


<html lang="en">
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
                url: '../api/comments/read_comments.php',
                success: function (response) {
                    var comments = "<table style='width: 100%;'>";
                    for (var i = 0; i < response.length; i++) {
                        comments += "<tr>";
                        comments += "<td style='text-align: left; color: #d1e8e2; padding-top: 8px'> User "
                            + response[i].username + " said: </td>";
                        comments += "<td style='text-align: left; width: 60%;'><textarea class='form-control' style='margin-top: 20px' id='"
                            + response[i].id + "' disabled>" + response[i].text +
                            "</textarea><a href='editcomment.php?id=" + response[i].id + "'><input type='button' class='buttonz' value='Edit' name='edit'/></a>" +
                            "<a href='../api/comments/delete_comment.php?id=" + response[i].id + "'><input type='button' class='buttonz' value='Delete' name='delete'/></a></td>";

                        comments += "</tr>";
                    }
                    comments += "</table>";
                    comments += "<br/><textarea class='form-control' style='margin-bottom: 2px;' id='comment'" +
                        " placeholder='Type your comment...'></textarea>" +
                        "<input id='postComm' type='button' class='buttonz' value='Submit' name='submit'" +
                        " style='margin-bottom: 20px; float: left;'/>";
                    $('#tabela').html(comments);
                }
            });

            $('#tabela').on('click', '#postComm', function () {
                $.ajax({
                    type: 'post',
                    url: '../api/comments/create_comment.php',
                    data: {
                        comment: document.getElementById("comment").value,
                        username: "<?php echo $_SESSION['username']; ?>"
                    },
                    success: function () {
                        $.ajax({
                            type: 'get',
                            url: '../api/comments/read_comments.php',
                            success: function (response) {
                                var comments = "<table style='width: 100%;'>";
                                for (var i = 0; i < response.length; i++) {
                                    comments += "<tr>";
                                    comments += "<td style='text-align: left; color: #d1e8e2; padding-top: 8px'> User "
                                        + response[i].username + " said: </td>";
                                    comments += "<td style='text-align: left; width: 60%;'><textarea class='form-control' style='margin-top: 20px' id='"
                                        + response[i].id + "' disabled>" + response[i].text +
                                        "</textarea><a href='editcomment.php?id=" + response[i].id + "'><input type='button' class='buttonz' value='Edit' name='edit'/></a>" +
                                        "<a href='../api/comments/delete_comment.php?id=" + response[i].id + "'><input type='button' class='buttonz' value='Delete' name='delete'/></a></td>";

                                    comments += "</tr>";
                                }
                                comments += "</table>";
                                comments += "<br/><textarea class='form-control' style='margin-bottom: 2px;' id='comment'" +
                                    " placeholder='Type your comment...'></textarea>" +
                                    "<input id='postComm' type='button' class='buttonz' value='Submit' name='submit'" +
                                    " style='margin-bottom: 20px; float: left;'/>";
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
            border: 0;
            margin-top: 2px;
            padding: 3px 10px;
            float: right;
            margin-right: 3px;
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
            <img src="../images/android-png-android-png-photos-399.png" width="60px" height="60px" alt="Missing image"/>
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
        <div class="tabela container col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
            <div class="tabela" id="tabela">
            </div>
        </div>
    </form>
</div>
</body>
</html>