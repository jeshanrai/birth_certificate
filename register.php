<?php
// Enable error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Establish database connection
$conn = new mysqli('localhost', 'root', '', 'birth_registration');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$errors = []; // Array to store errors

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $name = trim($_POST['name']);
    $citizenship_number = trim($_POST['citizenship_number']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Validation
    if (empty($name)) {
        $errors['name'] = "Name is required.";
    }

    if (empty($citizenship_number) || !preg_match('/^\d+$/', $citizenship_number)) {
        $errors['citizenship_number'] = "Citizenship Number must be numeric.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    if (empty($password) || strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters.";
    }

    if (empty($phone) || !preg_match('/^\d+$/', $phone)) {
        $errors['phone'] = "Phone number must contain only digits.";
    }

    if (empty($address) || strlen($address) < 5) {
        $errors['address'] = "Address must be at least 5 characters long.";
    }

    // If no errors, insert into database
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (citizenship_number, name, email, password, phone, address) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $citizenship_number, $name, $email, $hashed_password, $phone, $address);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            $errors['database'] = "Error: " . $conn->error;
        }
        $stmt->close();
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
        .government_logo{
            margin-left:20px;

        }
        .flag {
            height: 70px;
            transform: scaleX(-1);
            margin-right:20px;
        }
        .gov{
            color:white;
        }

        .container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin-top:100px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        input {
            padding: 10px;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: -5px;
            margin-bottom: 10px;
        }

        button {
            background: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #218838;
        }
    </style>
    <script>
        function validateForm(event) {
            event.preventDefault(); // Stop form from submitting initially

            let isValid = true;
            document.querySelectorAll(".error").forEach(error => error.innerText = ""); // Clear previous errors

            let name = document.getElementById('name').value.trim();
            let citizenship_number = document.getElementById('citizenship_number').value.trim();
            let email = document.getElementById('email').value.trim();
            let password = document.getElementById('password').value.trim();
            let phone = document.getElementById('phone').value.trim();
            let address = document.getElementById('address').value.trim();

            if (name === "") {
                showError('nameError', "Name is required.");
                isValid = false;
            }
            if (!/^[a-zA-Z\s]+$/.test(name)) {
    showError('nameError', "name must contain only letters and spaces.");
    isValid = false;
}


            if (!/^\d+$/.test(citizenship_number)) {
                showError('citizenshipNumberError', "Citizenship Number must be numeric.");
                isValid = false;
            }

            if (!/^\S+@\S+\.\S+$/.test(email)) {
                showError('emailError', "Invalid email format.");
                isValid = false;
            }

            if (password.length < 6) {
                showError('passwordError', "Password must be at least 6 characters.");
                isValid = false;
            }

            if (!/^\d+$/.test(phone)) {
                showError('phoneError', "Phone number must contain only digits.");
                isValid = false;
            }

            if (address.length < 5) {
                showError('addressError', "Address must be at least 5 characters.");
                isValid = false;
            }
            if (!/^[a-zA-Z\s]+$/.test(address)) {
    showError('addressError', "Address must contain only letters and spaces.");
    isValid = false;
}

            if (isValid) {
                document.getElementById('register-form').submit(); // Submit the form if no errors
            }
        }

        function showError(id, message) {
            document.getElementById(id).innerText = message;
        }
    </script>
</head>
<body>
<div class="header">
        <img src="image/government_logo.png"  class="government_logo"alt="Nepal Government Logo">
        <div class="text">
            <h1>नेपाल सरकारको आधिकारिक पोर्टल</h1>
            <h2 class="gov">The Official Portal of Government of Nepal</h2>
            <h3>NEPAL.GOV.NP</h3>
        </div>
        <img class="flag" src="image/flag.gif" alt="Nepal Flag">
    </div>
    <div class="container">
        <h2>Register</h2>
        <form id="register-form" action="register.php" method="POST" onsubmit="validateForm(event)">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name">
            <p class="error" id="nameError"></p>

            <label for="citizenship_number">Citizenship Number:</label>
            <input type="text" id="citizenship_number" name="citizenship_number">
            <p class="error" id="citizenshipNumberError"></p>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
            <p class="error" id="emailError"></p>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <p class="error" id="passwordError"></p>

            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone">
            <p class="error" id="phoneError"></p>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address">
            <p class="error" id="addressError"></p>

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
