<?php
// Include Dompdf library
require 'libs/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

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

// Convert logo image to Base64
$logoPath = __DIR__ . "/image/government_logo.png"; // Adjust path if necessary
if (file_exists($logoPath)) {
    $logoBase64 = base64_encode(file_get_contents($logoPath));
    $logoSrc = 'data:image/png;base64,' . $logoBase64;
} else {
    $logoSrc = ''; // Fallback if the image is missing
}

// Convert signature image to Base64
$signaturePath = __DIR__ . "/image/signature.jpg"; // Adjust path if necessary
if (file_exists($signaturePath)) {
    $signatureBase64 = base64_encode(file_get_contents($signaturePath));
    $signatureSrc = 'data:image/jpeg;base64,' . $signatureBase64;
} else {
    $signatureSrc = ''; // Fallback if the image is missing
}


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

        // Create an instance of Dompdf
        $dompdf = new Dompdf();

        // HTML content for the certificate
        $html = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Birth Registration Certificate</title>
            <style>
                body { font-family: "Roboto", sans-serif; background-color: #fff; }
                .certificate-container { padding: 20px; border: 1px solid #ccc; border-radius: 10px; }
                .header { text-align: center; }
                img { width: 80px; }
                .certificate-content { line-height: 1.8; font-size: 16px; }
                .signature-section { margin-top: 60px; text-align: right; }
                .signature img { width: 250px; }
            </style>
        </head>
        <body>
            <div class="certificate-container">
                <div class="header">
                    <img src="' . $logoSrc . '" alt="Nepal Government Logo">

                    <h1>Government of Nepal</h1>
                    <h2>Ministry of Federal Affairs and Local Development</h2>
                    <h3>Ward No. ' . htmlspecialchars($row['ward_no']) . '</h3>
                </div>
                <div class="certificate-content">
                    <p><strong>Registration No.:</strong> ' . htmlspecialchars($row['id']) . '</p>
                    <h2>Birth Registration Certificate</h2>
                    <p><strong>Date of Registration:</strong> ' . date('Y-m-d', strtotime($row['registration_date'])) . '</p>
                    <p>
                        Based on the application submitted, it is certified that the child 
                        <strong>Mr./Ms. ' . htmlspecialchars($row['newborn_name']) . '</strong>,  
                        granddaughter/grandson to <strong>Mr. ' . htmlspecialchars($row['grandfather_name']) . '</strong>,  
                        born to <strong>Mr. ' . htmlspecialchars($row['father_name']) . '</strong>  
                        and <strong>Mrs. ' . htmlspecialchars($row['mother_name']) . '</strong>, resident of  
                        <strong>Zone ' . htmlspecialchars($row['zone']) . ', District ' . htmlspecialchars($row['district']) . ', 
                        Municipality ' . htmlspecialchars($row['municipality']) . ', Ward No. ' . htmlspecialchars($row['ward_no']) . '</strong>,  
                        on <strong>' . date('Y-m-d', strtotime($row['dob'])) . '</strong>, has been registered in accordance with the law.
                    </p>
                </div>
                <div class="signature-section">
                    <img src="' . $signatureSrc . '" alt="Signature">
                    <p><strong>Name:</strong> Jeshan Rai</p>
                    <p><strong>Designation:</strong> Nagar Pramukh</p>
                </div>
            </div>
        </body>
        </html>';

        // Load HTML into Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF (downloadable)
        $dompdf->stream("birth_certificate_" . $registration_id . ".pdf", ["Attachment" => true]);
    } else {
        echo "<p>No certificate found with the given ID.</p>";
    }

    $stmt->close();
} else {
    echo "<p>Invalid registration ID.</p>";
}

$conn->close();
?>