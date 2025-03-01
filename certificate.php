

<?php
session_start();
if (!isset($_SESSION['citizenship_number'])) {
    header("Location: login.php");
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "birth_registration";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$citizenship_number = $_SESSION['citizenship_number'];
$query = "SELECT * FROM status WHERE citizenship_number = ? ORDER BY registration_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $citizenship_number);
$stmt->execute();
$result = $stmt->get_result();
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
        .container {
            margin-top: 140px;
            text-align: center;
            width: 80%;
            background: white;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .user-icon {
    width: 20px; /* Adjust size as needed */
    height: 20px;
    vertical-align: middle;
    margin-right: 5px;
    filter: brightness(0) invert(1); /* Ensures the icon appears white */
}

.download{
    margin-top:400px;
}
.certificate-container {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 10px 0;
            border-radius: 10px;
            background-color: #fff;
        }
        .status {
            font-weight: bold;
        }
        .buttons {
            margin-top: 10px;
        }
        button {
            background-color: #3EB2FD;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #004b87;
        }
        .pending {
            color: orange;
        }
        .verified {
            color: green;
        }
        .verified_certificate{
            margin-top:180px;
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
        <h1 class="verified_certificate">Verified Certificates</h1>

        <?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='certificate-container'>";
        echo "<p><strong>Newborn Name:</strong> " . htmlspecialchars($row['newborn_name']) . "</p>";
        echo "<p><strong>Registration Date:</strong> " . htmlspecialchars($row['registration_date']) . "</p>";
        echo "<p class='status'><strong>Status:</strong> ";

        if ($row['status_details'] === 'verified') {
            echo "<span class='verified'>Verified</span></p>";
            echo "<div class='buttons'>";
            // View Certificate Button
            // View Certificate Button
echo "<form action='formprint.php' method='GET' target='_blank' style='display:inline;'>
<input type='hidden' name='id' value='" . htmlspecialchars($row['registration_id']) . "'>
<button type='submit'>View Certificate</button>
</form>";

            // Download Certificate Button
            echo "<form action='generate_pdf.php' method='GET' style='display:inline;'>
                    <input type='hidden' name='id' value='" . htmlspecialchars($row['registration_id']) . "'>
                    <button type='submit'>Download Certificate</button>
                  </form>";
            echo "</div>";
        } elseif ($row['status_details'] === 'pending') {
            echo "<span class='pending'>Pending</span></p>";
        }

        echo "</div>";
    }
} else {
    echo "<p>No certificates found for your citizenship number.</p>";
}

$stmt->close();
$conn->close();
?>

</body>
</html>