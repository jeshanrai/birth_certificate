<?php
session_start();
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
            color:black importnat!;
            
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

.login-btn:hover, .logout-btn:hover {
    background-color: #ffaa00;
}

.login-btn img {
    width: 20px;
    vertical-align: middle;
    margin-right: 5px;
}
.container {
    margin-top: 180px;
    max-width: 900px;
    margin-left: auto;
    margin-right: auto;
    background: #ffffff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

.container h2 {
    text-align: center;
    font-size: 28px;
    color: #333;
    margin-bottom: 20px;
    font-weight: bold;
}

.container h3 {
    font-size: 22px;
    color: #444;
    margin-top: 20px;
    font-weight: bold;
    border-left: 5px solid #007bff;
    padding-left: 10px;
}

.container p {
    font-size: 16px;
    color: #666;
    line-height: 1.8;
    text-align: justify;
}

.contact-details {
    margin-top: 20px;
    padding: 15px;
    background:rgb(237, 230, 230);
    border-left: 5px solid #007bff;
    border-radius: 8px;
}

.contact-details p {
    font-size: 16px;
    color: #555;
    margin: 5px 0;
}

.contact-details strong {
    font-size: 18px;
    color: #222;
}
.user-icon {
    width: 20px; /* Adjust size as needed */
    height: 20px;
    vertical-align: middle;
    margin-right: 5px;
    filter: brightness(0) invert(1); /* Ensures the icon appears white */
}

@media (max-width: 768px) {
    .container {
        margin-top: 100px;
        padding: 20px;
    }
    .container h2 {
        font-size: 24px;
    }
    .container h3 {
        font-size: 20px;
    }
    .container p {
        font-size: 14px;
    }
    .contact-details {
        padding: 10px;
    }
}

    </style>
</head>
<body>
    <div class="header">
        <img src="image/government_logo.png" class="government_logo" alt="Nepal Government Logo">
        <div class="text">
            <h1>नेपाल सरकारको आधिकारिक पोर्टल</h1>
            <h2>The Official Portal of Government of Nepal</h2>
        </div>
        <img class="flag" src="image/flag.gif" alt="Nepal Flag">
    </div>
  


<div class="navbar">
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="about.php">About Us</a>
        <a href="birth_registration.php">Register Birth</a>
        <a href="contact.php">Contact Us</a>
        <a href="certificate.php">Certificate</a>
    </div>

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


  
</div>
<div class="container">
        <h2>Contact Us</h2>
        <p>For any inquiries or assistance, feel free to contact us through the following channels:</p>
        <div class="contact-details">
            <p><strong>Ministry of Home Affairs, Nepal</strong></p>
            <p>Singha Durbar, Kathmandu, Nepal</p>
            <p>Email: support@birthreg.gov.np</p>
            <p>Phone: +977-1-1234567</p>
            <p>Office Hours: Sunday - Friday (10 AM - 5 PM)</p>
        </div>
    </div>
    

</body>
</html>