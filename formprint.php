<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "birth_registration";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize $row as null
$row = null;

// Get the registration ID from the GET request
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $registration_id = $_GET['id'];

    // Fetch registration data
    $sql = "SELECT * FROM registrations WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $registration_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<p>No certificate found with the given ID.</p>";
    }

    $stmt->close();
} else {
    echo "<p>Invalid registration ID.</p>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Birth Registration Certificate</title>
  <style>
   @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

body {
  font-family: 'Roboto', sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f9f9f9;
}

.certificate-container {
  max-width: 800px;
  margin: 50px auto;
  padding: 30px;
  background: #fff;
  border: 1px solid #ccc;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.header {
  text-align: center;
  margin-bottom: 20px;
}

.header img {
  width: 80px;
  margin-bottom: 10px;
}

.header h1 {
  font-size: 24px;
  font-weight: 700;
  margin: 0;
}

.header h2, .header h3 {
  font-size: 18px;
  font-weight: 500;
  margin: 5px 0;
}

.certificate-content {
  line-height: 1.8;
  font-size: 16px;
}

.certificate-content strong {
  font-weight: 700;
}

.signature-section {
margin-top: 40px;
display: flex;
justify-content: flex-end;
align-items: flex-end;
}

.signature {
text-align: right;
font-size: 16px;
max-width: 300px;
}

.signature img {
max-width: 180px;
margin: 10px 0;
display: block;
margin-left:100px;
}
  </style>
</head>
<body>
  <?php if ($row): ?>
  <div class="certificate-container">
    <div class="header">
      <img src="image/government logo.png" alt="Nepal Government Logo" />
      <h1>Government of Nepal</h1>
      <h2>Ministry of Federal Affairs and Local Development</h2>
      <h3>Ward No. <?php echo htmlspecialchars($row['ward_no']); ?></h3>
    </div>
    <div class="certificate-content">
      <p><strong>Registration No.:</strong> <?php echo htmlspecialchars($row['id']); ?></p>
      <h2>Birth Registration Certificate</h2>
      <p><strong>Date of Registration:</strong> <?php echo date('Y-m-d', strtotime($row['registration_date'])); ?></p>
      <p>
        Based on the application submitted, it is certified that the child 
        <strong>Mr./Ms. <?php echo htmlspecialchars($row['newborn_name']); ?></strong>,  
        granddaughter/grandson to <strong>Mr. <?php echo htmlspecialchars($row['grandfather_name']); ?></strong>,  
        born to <strong>Mr. <?php echo htmlspecialchars($row['father_name']); ?></strong>  
        and <strong>Mrs. <?php echo htmlspecialchars($row['mother_name']); ?></strong>, resident of  
        <strong>Zone <?php echo htmlspecialchars($row['zone']); ?>, District <?php echo htmlspecialchars($row['district']); ?>, 
        Municipality <?php echo htmlspecialchars($row['municipality']); ?>, Ward No. <?php echo htmlspecialchars($row['ward_no']); ?></strong>,  
        on <strong><?php echo date('Y-m-d', strtotime($row['dob'])); ?></strong>, has been registered in accordance with the law.
      </p>
    </div>

    <div class="signature-section">
      <div class="signature">
        <span><strong>Signature of Authorized Officer:</strong></span>
        <img src="image/signature.jpg" alt="Nagar Pramukh Signature" />
        <span><strong>Name:</strong> Jeshan Rai</span><br>
        <span><strong>Designation:</strong> Nagar Pramukh</span>
      </div>
    </div>
  </div>
  <?php endif; ?>
</body>
</html>
