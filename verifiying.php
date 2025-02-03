<?php
session_start();
if (!isset($_SESSION['username'] )) {
    header("login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birth Certificate Portal - Government of Nepal</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #1f5ca7;
            padding: 10px 20px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }
        .navbar {
            position: fixed;
            top: 80px;
            left: 0;
            width: 100%;
            background-color: #002147;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 999;
        }
        .nav-links {
            display: flex;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 14px 20px;
            font-size: 18px;
            font-weight: bold;
            transition: background 0.3s;
        }
        .nav-links a:hover {
            background-color: #004b87;
            border-radius: 5px;
        }
        .login-btn:hover {
            background-color: #e6b800;
        }
        .login-btn img {
            height: 20px;
            margin-right: 8px;
        }
        .header img {
            height: 60px;
        }
        .header .text {
            text-align: center;
        }
        .header .text h1 {
            margin: 0;
            font-size: 18px;
        }
        .header .text h2 {
            margin: 2px 0;
            font-size: 16px;
            font-weight: normal;
            color:black important!;
            
        }
        .header .text h3 {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
        }
        .flag {
            height: 70px;
            transform: scaleX(-1);
            margin-right:20px;
        }
        
        .user-name {
    color: white;
    margin-right: 10px;
    font-size: 16px;
}



.login-btn:hover, .logout-btn:hover {
    background-color: #ffaa00;
}

.user-icon {
    width: 20px; /* Adjust size as needed */
    height: 20px;
    vertical-align: middle;
    margin-right: 5px;
    filter: brightness(0) invert(1); /* Ensures the icon appears white */
}

.navbar {
    position: fixed;
    top: 80px;
    left: 0;
    width: 100%;
    background-color: #002147;
    padding: 15px 20px;
    display: flex;
    justify-content: flex-end; /* Align items to the right */
    align-items: center; /* Center items vertically */
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 999;
}

.nav-links {
    display: flex;
    margin-right: auto; /* Push nav-links to the left */
}

.nav-links a {
    color: white;
    text-decoration: none;
    padding: 14px 20px;
    font-size: 18px;
    font-weight: bold;
    transition: background 0.3s;
}

.nav-links a:hover {
    background-color: #004b87;
    border-radius: 5px;
}

.login-section {
    display: flex;
    align-items: center;
    gap: 10px; /* Add space between items */
}

.login-btn, .logout-btn {
    background-color: #ffcc00;
    color: #333;
    padding: 8px 15px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s;
    margin-right:30px;
}


.login-btn img, .user-icon {
    height: 20px;
    margin-right: 8px;
}

.user-name {
    display: flex;
    align-items: center;
    color: white;
    font-size: 18px;
    font-weight: bold;
}
.edit{
    margin-top:250px;
}

    </style>
</head>
<body>
    <div class="header">
        <img src="image/government logo.png" class="government_logo" alt="Nepal Government Logo">
        <div class="text">
            <h1>नेपाल सरकारको आधिकारिक पोर्टल</h1>
            <h2>The Official Portal of Government of Nepal</h2>
        </div>
        <img class="flag" src="image/flag.gif" alt="Nepal Flag">
    </div>
  


<div class="navbar">

    <div class="login-section">
        <?php if (isset($_SESSION['username'])): ?>
            <span class="user-name">
    <img src="image/user_icon.png" alt="User Icon" class="user-icon">
    <?php echo htmlspecialchars($_SESSION['username']); ?>
</span>

            <a href="logout.php" class="logout-btn">Logout</a>
        <?php else: ?>
            <a href="login.php" class="login-btn">
                <img src="image/login_icon.png" alt="Login Icon"> Log In
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="edit">fetech data here nirajan!!
        </div>

</body>
</html>