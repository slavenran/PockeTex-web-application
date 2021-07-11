<?php
session_start();
if (isset($_SESSION["username"])) {
    header("Location: ../user/home.php");
}

?>

<html lang="en">
<head>
    <title>PockeTex</title>
    <link rel="stylesheet" href="style.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        function register() {
            document.getElementById("login").style.left = "-400px";
            document.getElementById("register").style.left = "35px";
            document.getElementById("btn").style.left = "110px";
        }

        function login() {
            document.getElementById("login").style.left = "35px";
            document.getElementById("register").style.left = "450px";
            document.getElementById("btn").style.left = "0";
        }

        function loginAjax() {
            $.ajax({
                type: "POST",
                url: "login.php",
                // dataType: "json,"
                data: {
                    username: $("#username").val(),
                    password: $("#password").val()
                },
                success: function (response) {
                    if (response === "Success!") {
                        window.location.replace("../user/home.php");
                    } else {
                        alert(response);
                    }
                }
            });
        }

        function registerAjax() {
            $.ajax({
                type: "POST",
                url: "register.php",
                // dataType: "json,"
                data: {
                    usernameReg: $("#usernameReg").val(),
                    email: $("#email").val(),
                    passwordReg: $("#passwordReg").val()
                },
                success: function (response) {
                    if (response === "Successfully registered! Proceed to login.") {
                        $("#usernameReg").val("");
                        $("#email").val("");
                        $("#passwordReg").val("");
                    }
                    alert(response);
                    // var re = JSON.parse(response);
                    // alert(re.message);
                }
            });
        }
    </script>
</head>
<body>
<div id="hero" class="hero">
    <div class="transparency">
        <div class="form-box">
            <div class="image-div"></div>
            <div class="button-box">
                <div id="btn"></div>
                <button id="proba" type="button" class="toggle-btn" onclick="login()">Log In</button>
                <button type="button" class="toggle-btn" style="float: right" onclick="register()">Register</button>
            </div>
            <form id="login" method="post" autocomplete="off"
                  class="input-group">
                <input id="username" name="username" type="text" class="input-field" placeholder="Username" required/>
                <input id="password" name="password" type="password" class="input-field" placeholder="Password"
                       required/>
                <input type="checkbox" class="checkbox"/><span>Remember Password</span>
                <div class="btn-bg">
                    <div class="btn-bg2">
                        <input id="btn-login" name="btn-login" type="button" onclick="loginAjax()"
                               class="submit-btn"/>
                        <div style="opacity: 0">Login</div>
                    </div>
                </div>
                <div class="persistent">Login</div>
            </form>

            <form id="register" method="post" autocomplete="off"
                  class="input-group" onsubmit="checkFormBox(this)">
                <input id="usernameReg" name="usernameReg" type="text" class="input-field" placeholder="Username"
                />
                <input id="email" name="email" type="email" class="input-field" placeholder="Email"/>
                <input id="passwordReg" name="passwordReg" type="password" class="input-field" placeholder="Password"
                />
                <input name="checkbox" type="checkbox" class="checkbox"/><span>I agree to the terms & conditions</span>
                <div class="btn-bg">
                    <div class="btn-bg2">
                        <input id="btn-register" name="btn-register" type="button" onclick="registerAjax()"
                               class="submit-btn"/>
                        <div style="opacity: 0">Register</div>
                    </div>
                </div>
                <div class="persistent per_reg">Register</div>
            </form>
        </div>
    </div>
</div>


</body>
</html>