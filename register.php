<?php
// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Establish database connection
$conn = new mysqli('localhost', 'root', '', 'birth_registration');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = ""; // Variable to store error messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Trim and sanitize inputs
    $name = trim($_POST['name']);
    $citizenship_number = trim($_POST['citizenship_number']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Input validation
    if (empty($name) || empty($citizenship_number) || empty($email) || empty($password)) {
        $error = "All fields except phone and address are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } else {
        // Check if citizenship number already exists
        $checkCitizen = $conn->prepare("SELECT citizenship_number FROM users WHERE citizenship_number = ?");
        $checkCitizen->bind_param("s", $citizenship_number);
        $checkCitizen->execute();
        $checkCitizen->store_result();

        if ($checkCitizen->num_rows > 0) {
            $error = "This Citizenship Number is already registered.";
        } else {
            // Check if email already exists
            $checkEmail = $conn->prepare("SELECT email FROM users WHERE email = ?");
            $checkEmail->bind_param("s", $email);
            $checkEmail->execute();
            $checkEmail->store_result();

            if ($checkEmail->num_rows > 0) {
                $error = "Email is already registered.";
            } else {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // Insert user into database
                $stmt = $conn->prepare("INSERT INTO users (citizenship_number, name, email, password, phone, address) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $citizenship_number, $name, $email, $hashed_password, $phone, $address);

                if ($stmt->execute()) {
                    header("Location: login.php");
                    exit;
                } else {
                    $error = "Error: " . $conn->error;
                }
                $stmt->close();
            }
            $checkEmail->close();
        }
        $checkCitizen->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
     
     body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background: linear-gradient(135deg, #f0f4fd, #c8e7f4);
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
}

.header {
    position: fixed;
   
    width: 100%;
    
    background-color: #1f5ca7;
    padding: 10px 20px;
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.container {
    background: #ffffff;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    width: 90%;
    margin-top: 120px;
}


        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #555;
        }

        input, textarea {
            padding: 0.8rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: 0.3s;
            resize: vertical;
        }

        input:focus, textarea:focus {
            border-color: #80c1e3;
            outline: none;
            box-shadow: 0 0 5px rgba(128, 193, 227, 0.5);
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 1rem;
        }

        button {
            background: #80c1e3;
            color: #fff;
            padding: 0.8rem;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #68acd8;
        }

        p {
            text-align: center;
            margin-top: 1rem;
        }

        p a {
            color: #80c1e3;
            text-decoration: none;
            font-weight: bold;
        }

        p a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .container {
                padding: 1.5rem;
            }

            h2 {
                font-size: 1.5rem;
            }

            input, textarea, button {
                font-size: 0.9rem;
            }
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
    </style>
</head>
<body>
<div class="header">
        <img src="image/government logo.png"  class="government_logo"alt="Nepal Government Logo">
        <div class="text">
            <h1>नेपाल सरकारको आधिकारिक पोर्टल</h1>
            <h2>The Official Portal of Government of Nepal</h2>
            <h3>NEPAL.GOV.NP</h3>
        </div>
        <img class="flag" src="image/flag.gif" alt="Nepal Flag">
    </div>
    <div class="container">
        <h2>Register</h2>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <form action="register.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" required>

            <label for="citizenship_number">Citizenship Number:</label>
            <input type="text" id="citizenship_number" name="citizenship_number" placeholder="Enter your citizenship number" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Create a password" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" placeholder="Enter your phone number">

            <label for="address">Address:</label>
            <textarea id="address" name="address" placeholder="Enter your address"></textarea>

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
