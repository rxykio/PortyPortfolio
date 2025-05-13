<?php
session_start();
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: /PortyPortfolio/?url=admin");
        exit();
    } else if ($_SESSION['role'] === 'user') {
        header("Location: /PortyPortfolio/?url=admin");
        exit(); 
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .square {
  
    background:rgb(255, 255, 255);
   
   
    box-shadow: 0 0 10px rgba(74, 158, 255, 0.8), 
                0 0 20px rgba(74, 158, 255, 0.6), 
                0 0 30px rgba(74, 158, 255, 0.4);
    animation: glow 2s infinite ease-in-out alternate;
}

@keyframes glow {
    0% {
        box-shadow: 0 0 10px rgba(74, 158, 255, 0.8), 
                    0 0 20px rgba(74, 158, 255, 0.6), 
                    0 0 30px rgba(74, 158, 255, 0.4);
    }
    100% {
        box-shadow: 0 0 20px rgba(74, 158, 255, 1), 
                    0 0 40px rgba(74, 158, 255, 0.8), 
                    0 0 60px rgba(74, 158, 255, 0.6);
    }
}
        </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../static/static.css">
    <script>


    async function loginUser(event) {
        event.preventDefault();
        let form = document.forms["loginForm"];
        let userData = {
            email: form["email"].value.trim(),
            password: form["password"].value.trim(),
        };

        let response = await fetch("/../PortyPortfolio/app/controllers/login_api.php", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(userData)
        });

        let result = await response.json();
        alert(result.message);
        if (result.success) {
            if (result.role === 'admin' || result.role === 'user') {
        window.location.href = "/PortyPortfolio/?url=admin";
    }
        } else {
            alert(result.message);
        }
    }
    async function registerUser(event){
        event.preventDefault();
        let form = document.forms ['registerForm'];

        let userData = {
            first_name: form['first_name'].value.trim(),
            last_name: form['last_name'].value.trim(),
            middle_name: form['mname'].value.trim(),
            email: form['email'].value.trim(),
            mobile: form['mobile'].value.trim(),
            password: form['password'].value.trim(),
            confirm_password: form['confirm_password'].value.trim(),
        };
        let response = await fetch("/PortyPortfolio/app/controllers/register_api.php", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(userData)
        });
        let result = await response.json();
        alert(result.message);
        if (result.success) window.location.href = "auth.php";
    }
    </script>
</head>
<body>
    <div class="square"></div>
    <div class="form-box">
        <form name="loginForm" onsubmit="loginUser(event)">
            <h1>LOGIN</h1>
            <div class="input-box">
                <input type="text" placeholder="Email" name="email">
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" name="password">
            </div>
            <div class="button">
                <input type="submit" value="Login">
            </div>
            <div class="text1">
                Don't have an account? <a href="#" id="register-btn">Register</a>
            </div>
        </form>
    </div>
    <div class="form-box2">
        <form name="registerForm" onsubmit="registerUser(event)">
            <h1>REGISTER</h1>
            <div class="input-box">
                <input type="text" placeholder="First Name" name="first_name">
            </div>
            <div class="input-box">
                <input type="text" placeholder="Middle Name (Optional)" name="mname">
            </div>
            <div class="input-box">
                <input type="text" placeholder="Last Name" name="last_name">
            </div>
            <div class="input-box">
                <input type="text" placeholder="Email" name="email">
            </div>
            <div class="input-box">
                <input type="tel" placeholder="Phone Number" name="mobile">
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" name="password">
            </div>
            <div class="input-box">
                <input type="password" placeholder="Confirm Password" name="confirm_password">
            </div>
            <div class="button">
                <input type="submit" value="Register" name="submit">
            </div>
            <div class="text">
                Already have an account? <a href="#" id="back-login">Login</a>
            </div>
        </form>
    </div>
    <script>
        document.getElementById("register-btn").addEventListener("click", function() {
            document.querySelector(".square").style.transform = "translate(300px)";
            document.querySelector(".form-box").style.display = "none";
            document.querySelector(".form-box2").style.display = "block";
        });
        document.getElementById("back-login").addEventListener("click", function() {
            document.querySelector(".square").style.transform = "translate(0px)";
            document.querySelector(".form-box2").style.display = "none";
            document.querySelector(".form-box").style.display = "block";
        });
    </script>
</body>
</html>