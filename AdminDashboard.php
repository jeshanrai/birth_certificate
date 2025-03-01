<?php
session_start();
if (!isset($_SESSION['email'])) {  // Checking for email in session
    header("Location: login.php");
    exit;
}

// Database connection
$servername = "localhost";
$username = "root"; // Change according to your DB credentials
$password = "";
$database = "birth_registration"; // Change to your actual database name

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get logged-in user's email
$logged_in_user_email = $_SESSION['email'];  // Use email from session

// Fetch user's citizenship number if they are not admin
if ($logged_in_user_email !== "admin@gmail.com") {
    $userQuery = "SELECT citizenship_number FROM users WHERE email = ?";
    $stmt = $conn->prepare($userQuery);
    $stmt->bind_param("s", $logged_in_user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $citizenship_number = $user['citizenship_number'];

        // Fetch registration data based on citizenship number
        $regQuery = "SELECT * FROM registrations WHERE citizenship_number = ?";
        $stmt = $conn->prepare($regQuery);
        $stmt->bind_param("s", $citizenship_number);
        $stmt->execute();
        $regResult = $stmt->get_result();
    } else {
        echo "<p>User not found.</p>";
        exit;
    }
} else {
    // Admin is logged in, so fetch registration data for all users
    $regQuery = "SELECT * FROM registrations";
    $stmt = $conn->prepare($regQuery);
    $stmt->execute();
    $regResult = $stmt->get_result();
}

$stmt->close();

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

.registration-data{
    display: flex;
    flex-direction:column;
    align-items:center;
    margin:0 auto;
    margin-top: 142px;
    font-size:1.05rem;
    background-color:rgb(195, 214, 236);
    height:100%;
    color:#fff;
}
.registration-data h2{
    color:#111;
}
.registration-row {
    display: flex;
    justify-content: space-between; /* This will separate the info and buttons */
    margin-bottom: 20px;
}

.registration-info {
    flex: 1; /* The info will take up the available space */
}

.registration-container{
    padding:1rem 2rem;
    width:500px;
    border:2px solid #ccc;
    border-radius:20px;
    display:flex;
    flex-direction:column;
    align-items:center;
    background-color: #002147;
    margin:.5rem 0;
}
.buttons {
    display: flex;
    flex-direction: column; /* Stack the buttons vertically */
    justify-content: space-evenly;
    align-items: center; /* Align buttons to the left side */
    gap: 1rem; /* Add some space between buttons */
}

.button_ID{
    width:25rem;
    display:flex;
    justify-content:space-between;
}

button {
    align-items: center;
  appearance: none;
  background-color: #3EB2FD;
  background-image: linear-gradient(1deg, #4F58FD, #149BF3 99%);
  background-size: calc(100% + 20px) calc(100% + 20px);
  border-radius: 100px;
  border-width: 0;
  box-shadow: none;
  box-sizing: border-box;
  color: #FFFFFF;
  cursor: pointer;
  display: inline-flex;
  font-family: CircularStd,sans-serif;
  font-size: 1rem;
  height: auto;
  justify-content: center;
  line-height: 1.5;
  padding: 6px 20px;
  position: relative;
  text-align: center;
  text-decoration: none;
  transition: background-color .2s,background-position .2s;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  vertical-align: top;
  white-space: nowrap;
}

button:hover {
    background-color: #004b87;
    color: white;
}

/* Optionally, you can add styles for spacing and alignment */
.registration-info p {
    margin: 5px 0;
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

<div class="registration-data">
    <h2>Registration Data</h2>

    <?php
    if ($regResult->num_rows > 0) {
        while ($row = $regResult->fetch_assoc()) {
            echo "<div class='registration-container'>";
            echo "<p><strong>Date of Registration:</strong> " . htmlspecialchars($row['registration_date']) . "</p>";
            echo "<p><strong>Child's Name:</strong> " . htmlspecialchars($row['newborn_name']) . "</p>";
            echo "<p><strong>GrandFather Name:</strong> " . htmlspecialchars($row['grandfather_name']) . "</p>";
            echo "<p><strong>Father's Name:</strong> " . htmlspecialchars($row['father_name']) . "</p>";
            echo "<p><strong>Mother's Name:</strong> " . htmlspecialchars($row['mother_name']) . "</p>";
            echo "<p><strong>Zone:</strong> " . htmlspecialchars($row['zone']) . "</p>";
            echo "<p><strong>District:</strong> " . htmlspecialchars($row['newborn_district']) . "</p>";
            echo "<p><strong>Municipality:</strong> " . htmlspecialchars($row['birthplace_vdc']) . "</p>";
            echo "<p><strong>Ward No:</strong> " . htmlspecialchars($row['newborn_ward']) . "</p>";
            echo "<p><strong>FormSubmiter Citizenship number:</strong> " . htmlspecialchars($row['citizenship_number']) . "</p>";

            // Fetch status of the current registration
            $statusQuery = "SELECT status_details FROM status WHERE registration_id = ?";
            $statusStmt = $conn->prepare($statusQuery);
            $statusStmt->bind_param("i", $row['id']);
            $statusStmt->execute();
            $statusResult = $statusStmt->get_result();
            
            // Fetch status safely and set it to 'pending' if not found
            if ($statusRow = $statusResult->fetch_assoc()) {
                $status = $statusRow['status_details'];
            } else {
                $status = 'pending';
            }
            $statusStmt->close();

            echo "<div class='buttons'>";
            if ($status == "pending") {
                echo "<form action='admin_verify.php' method='post'>";
                echo "<input type='hidden' name='registration_id' value='" . htmlspecialchars($row['id']) . "'>";
                echo "<div class='button_ID'>";
                echo "<button type='submit' name='action' value='verify'>Verify</button>";
                echo "<button type='submit' name='action' value='reject'>Reject</button>";
                echo "</div>";
                echo "</form>";
            } else {
                echo "<p><strong>Status:</strong> <span style='color: " . ($status == "verified" ? "green" : "red") . ";'>" . ucfirst($status) . "</span></p>";
            }
            echo "</div>";
            echo "<div style='clear: both;'></div>";
            echo "</div>";
        }
    } else {
        echo "<p>No registration data found.</p>";
    }
    $conn->close();
    ?>
</div>

</body>
</html>