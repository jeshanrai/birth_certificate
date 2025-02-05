<?php
session_start();
if (!isset($_SESSION['username'], $_SESSION['citizenship_number'])) {
    header("Location: birth_registration_login.php");
    exit;
}

$citizenship_number = $_SESSION['citizenship_number'];  // Get citizenship_number from session


// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "birth_registration";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Collect & Validate form data
$zone = $_POST['Zone'] ?? '';
$district = $_POST['District'] ?? '';
$municipality = $_POST['Municipality'] ?? '';
$ward_no = $_POST['WardNo'] ?? '';
$registrar_name = $_POST['LocalRegistrarName'] ?? '';
$employee_id = $_POST['EmployeeID'] ?? '';
$registration_date = $_POST['RegistrationDateinAd'] ?? '';
$vdc_municipality = $_POST['Municipality'] ?? '';
$informant_district = $_POST['District'] ?? '';
$full_name = $_POST['full_name'] ?? '';
$dob = $_POST['newborndob'] ?? '';
$birth_location = $_POST['BirthLocation'] ?? '';
$birth_attendant = $_POST['BirthAttendant'] ?? '';
$gender = $_POST['Gender'] ?? '';
$ethnicity = $_POST['Ethnicity'] ?? '';
$birth_type = $_POST['BirthType'] ?? '';
$physical_disability = $_POST['Physical'] ?? '';
$disability_details = $_POST['Specify'] ?? '';
$birthplace_district = $_POST['birthplaceDistrict'] ?? '';
$birthplace_vdc = $_POST['birthplaceVDC'] ?? '';
$birthplace_ward_no = $_POST['birthplaceWardNo'] ?? '';
$father_name = $_POST['parentFather'] ?? '';
$mother_name = $_POST['parentMother'] ?? '';
$grandfather_name=$_POST['newbornGrandFather'] ?? '';
$grandmother_name=$_POST['newbornGrandMother'] ?? '';
$father_district = $_POST['Fatherdistrict'] ?? '';
$mother_district = $_POST['Motherdistrict'] ?? '';
$father_vdc = $_POST['FatherVDC'] ?? '';
$mother_vdc = $_POST['MotherVDC'] ?? '';
$father_ward_no = $_POST['FatherWardNo'] ?? '';
$mother_ward_no = $_POST['MotherWardNo'] ?? '';
$father_street = $_POST['FatherStreet'] ?? '';
$mother_street = $_POST['MotherStreet'] ?? '';
$father_village = $_POST['FatherTown'] ?? '';
$mother_village = $_POST['MotherTown'] ?? '';
$father_house_no = $_POST['FatherHouseNo'] ?? '';
$mother_house_no = $_POST['MotherHouseNo'] ?? '';
$father_birthplace = $_POST['FatherPlaceofbirth'] ?? '';
$mother_birthplace = $_POST['MotherPlaceofbirth'] ?? '';
$father_country_birth = $_POST['FathercountryofBirth'] ?? '';
$mother_country_birth = $_POST['MothercountryofBirth'] ?? '';
$father_nationality = $_POST['Fathernationality'] ?? '';
$mother_nationality = $_POST['Mothernationality'] ?? '';
$father_national_id = $_POST['FatherNID'] ?? '';
$mother_national_id = $_POST['MotherNID'] ?? '';
$father_citizenship_no = $_POST['FatherCitizenshipNo'] ?? '';
$mother_citizenship_no = $_POST['MotherCitizenshipNo'] ?? '';
$father_citizenship_district = $_POST['FatherCID'] ?? '';
$mother_citizenship_district = $_POST['MotherCID'] ?? '';
$father_education = $_POST['FatherELH'] ?? '';
$mother_education = $_POST['MotherELH'] ?? '';
$father_profession = $_POST['FatherProfession'] ?? '';
$mother_profession = $_POST['MotherProfession'] ?? '';
$father_religion = $_POST['FatherReligion'] ?? '';
$mother_religion = $_POST['MotherReligion'] ?? '';
$father_mother_tongue = $_POST['FatherMT'] ?? '';
$mother_mother_tongue = $_POST['MotherMT'] ?? '';
$marriage_date = $_POST['MarriageDate'] ?? '';
$newborn_name = $_POST['NewBornFN'] ?? '';
$newborn_district = $_POST['NewBorndistrict'] ?? '';
$newborn_ward = $_POST['NewBornward'] ?? '';
$newborn_street = $_POST['NewBornstreet'] ?? '';
$newborn_village = $_POST['NewBornvillage'] ?? '';
$newborn_house = $_POST['NewBornhouse'] ?? '';
$citizenship_no = $_POST['CertificateNo'] ?? '';
$issued_date = $_POST['IssuedDate'] ?? '';
$issued_district = $_POST['IssuedDistrict'] ?? '';

// **SQL Query with 69 Columns**
$sql = "INSERT INTO registrations (
  zone, district, municipality, ward_no, registrar_name, employee_id, registration_date, 
  vdc_municipality, informant_district, full_name, dob, birth_location, birth_attendant, gender, 
  ethnicity, birth_type, physical_disability, disability_details, birthplace_district, birthplace_vdc, birthplace_ward_no, 
  father_name, mother_name,grandfather_name,grandmother_name, father_district, mother_district, father_vdc, mother_vdc, father_ward_no, mother_ward_no, 
  father_street, mother_street, father_village, mother_village, father_house_no, mother_house_no, father_birthplace, 
  mother_birthplace, father_country_birth, mother_country_birth, father_nationality, mother_nationality, father_national_id, 
  mother_national_id, father_citizenship_no, mother_citizenship_no, father_citizenship_district, mother_citizenship_district, 
  father_education, mother_education, father_profession, mother_profession, father_religion, mother_religion, 
  father_mother_tongue, mother_mother_tongue, marriage_date, newborn_name, newborn_district, newborn_ward, 
  newborn_street, newborn_village, newborn_house, citizenship_no,citizenship_number, issued_date, issued_district
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


// **Prepare Statement**
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL Error: " . $conn->error);
}

// **Bind Parameters (69 total)**
$stmt->bind_param(
  "sssisssssssssssssssssiissssssssssssssssssssssssssssssssssssssssssiss", 
  $zone, $district, $municipality, $ward_no, $registrar_name, $employee_id, $registration_date, 
  $vdc_municipality, $informant_district, $full_name, $dob, $birth_location, $birth_attendant, $gender, 
  $ethnicity, $birth_type, $physical_disability, $disability_details, $birthplace_district, $birthplace_vdc, $birthplace_ward_no, 
  $father_name, $mother_name,$grandfather_name, $grandmother_name,$father_district, $mother_district, $father_vdc, $mother_vdc, $father_ward_no, $mother_ward_no, $father_street, $mother_street, $father_village, $mother_village, $father_house_no, $mother_house_no, $father_birthplace, 
  $mother_birthplace, $father_country_birth, $mother_country_birth, $father_nationality, $mother_nationality, $father_national_id, 
  $mother_national_id, $father_citizenship_no, $mother_citizenship_no, $father_citizenship_district, $mother_citizenship_district, 
  $father_education, $mother_education, $father_profession, $mother_profession, $father_religion, $mother_religion, 
  $father_mother_tongue, $mother_mother_tongue, $marriage_date, $newborn_name, $newborn_district, $newborn_ward, 
  $newborn_street, $newborn_village, $newborn_house, $citizenship_no, $citizenship_number, $issued_date, $issued_district
);


// **Execute Query**
if ($stmt->execute()) {
    echo "Data inserted successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Birth Registration Form</title>
    <style>
      * {
  margin: 0;
  padding: 0;
}
/* General Page Styling */
body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  padding: 0 2rem;
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

/* Container */
.container {
  max-width: 800px;
  background: white;
  padding: 20px;
  max-width: 100%;
  border-radius: 8px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
  margin-top:150px;
}

.container__Dotted {
  padding: 20px 10px;
  width: 97%;
  border: 1px solid black;
  margin-top: 1rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  margin: 0 auto;
}

.container__Dotted__ {
  display: flex;
  gap: 30px;
}

.small-text {
  font-size: 14px;
  margin-bottom: .5rem;
  font-weight: normal;
}
.bold-text {
  font-weight: bold;
  margin-bottom: 1rem;
}

.local {
  display: flex;
  flex-direction: column;
}

.dashed-line {
  display: inline-block;
  width: 150px;
  border-bottom: 1px dotted black;
}

/* Title */
.title {
  text-align: center;
  font-size: 22px;
  font-weight: bold;
  border-bottom: 2px solid purple;
  padding-bottom: 5px;
}

/* Two-column layout */
.form-container {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  margin-top: 15px;
  margin-bottom: 2rem;
}

.section {
  flex: 1;
  min-width: 320px;
}

/* Section Title */
.section-title {
  font-size: 16px;
  font-weight: bold;
  margin-bottom: 5px;
  border-bottom: 1px solid #000;
  padding-bottom: 3px;
}

/* Table Styling */
table {
  width: 100%;
  border-collapse: collapse;
}

td {
  border: 1px solid #ccc;
  padding: 8px;
}

input {
  width: 95%;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

/* Informative Text */
.info-text {
  margin: 20px 0;
}

/* Button Styling */
.button-container {
  text-align: center;
  margin-top: 15px;
}

.submit-button {
  background: blue;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

.submit-button:hover {
  background: darkblue;
}

.container__details h2 {
  background-color: #ccc;
  margin-bottom: 1rem;
}

h2 {
  margin: 2px 0;
            font-size: 16px;
            font-weight: normal;
            color:black importnat!;
}

.form-group {
  display: flex;
  flex-wrap: wrap;
  margin-bottom: 15px;
}
.form-group label {
  flex: 1;
  min-width: 150px;
  font-weight: bold;
}
.form-group input,
.form-group select,
.form-group textarea {
  flex: 2;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 5px;
  resize: none;
}
.checkbox-group {
  display: flex;
  flex: 2;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: center;
  border: 1px solid #ccc;
  border-radius: 5px;
  padding: 8px;
}
.checkbox-group-box {
  display: flex;
  padding: 7px;
}
.checkbox-group label {
  font-weight: normal;
}
input[type="checkbox"] {
  margin-right: 5px;
}
@media (max-width: 600px) {
  .form-group {
    flex-direction: column;
  }
  .form-group label {
    margin-bottom: 5px;
  }
}

/* Responsive */
@media (max-width: 600px) {
  .form-container {
    flex-direction: column;
  }
}
@media (max-width: 770px) {
  .form-container {
    flex-direction: column;
  }
  .container__Dotted {
    width: 97%;
  }
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 15px;
  background: white;
}
th,
td {
  border: 1px solid black;
  padding: 10px;
  text-align: left;
}
th {
  background: #ddd;
}

.title {
  text-align: center;
  font-size: 22px;
  margin-bottom: 20px;
}

/* Form Styling */
.form-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 15px;
}

.form-group label {
  font-weight: bold;
  margin-bottom: 5px;
}

.form-group input {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.full-width {
  width: 100%;
}

.section-title {
  font-size: 18px;
  font-weight: bold;
  margin-top: 20px;
  margin-bottom: 10px;
}

/* Photo Upload Section */
.photo-section {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}

.photo-box {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.upload-box {
  width: 300px;
  height: 120px;
  border: 2px dashed #ccc;
  border-radius: 5px;
  margin-top: 5px;
  background-color: #fafafa;
}

/* Submit Button */
.submit-btn {
  width: 100%;
  background: #007bff;
  color: white;
  padding: 10px;
  font-size: 16px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-top: 20px;
}

.submit-btn:hover {
  background: #0056b3;
}
.user-icon {
    width: 20px; /* Adjust size as needed */
    height: 20px;
    vertical-align: middle;
    margin-right: 5px;
    filter: brightness(0) invert(1); /* Ensures the icon appears white */
}


/* Responsive Design */
@media (min-width: 600px) {
  .form-group {
    flex-direction: row;
    justify-content: space-between;
  }

  .form-group label {
    width: 40%;
  }

  .form-group input {
    width: 55%;
  }
}

@media (max-width: 599px) {
  .photo-section {
    flex-direction: column;
    align-items: center;
  }
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
      <!-- Title -->
      <h2 class="title">Birth Registration Form</h2>
      
      <!-- Two-column layout -->
      <div class="form-container">
        <!-- Left Section -->
        <div class="section">
          <h3 class="section-title">Local Registrar's Office</h3>
          <form action="birth_registration.php" method="POST" id="registrationForm">
          <table>
            <tr>
              <td>Zone</td>
              <td>
                <input type="text" name="Zone" placeholder="Enter the Zone"  required/>
              </td>
            </tr>
            <tr>
              <td>District</td>
              <td>
                <input
                  type="text"
                  name="District"
                  placeholder="Enter the District" required
                />
              </td>
            </tr>
            <tr>
              <td>Municipality/Rural Municipality</td>
              <td>
                <input
                  type="text"
                  name="Municipality"
                  placeholder="Enter the Municipality" required
                />
              </td>
            </tr>
            <tr>
              <td>Ward No.</td>
              <td>
                <input
                  type="number"
                  name="WardNo"
                  placeholder="Enter the WardNo" required
                />
              </td>
            </tr>
          </table>
        </div>

        <!-- Right Section -->
        <div class="section">
          <h3 class="section-title">Local Registrar's Name</h3>
          <table>
            <tr>
              <td>Local Registrar's Name</td>
              <td>
                <input
                  type="text"
                  name="LocalRegistrarName"
                  placeholder="Enter the Local Registrar's Name" required
                />
              </td>
            </tr>
            <tr>
              <td>Employee ID</td>
              <td>
                <input
                  type="text"
                  name="EmployeeID"
                  placeholder="Enter the Employee ID" required
                />
              </td>
            </tr>
            <tr>
              <td>Form Registration Date ( A.D.)</td>
              <td>
                <input
                  type="date"
                  name="RegistrationDateinAd"
                  placeholder="Enter in A.D." required
                />
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class="container__Dotted">
        <p class="small-text">(To be filled by the informant)</p>
        <span class="bold-text">Mr. Local Registration Officer,</span>
        <div class="container__Dotted__">
          <div class="local">
            <label for="VDC / Municipality">VDC / Municipality</label>
            <input
              type="text"
              name="Municipality"
              placeholder="Enter the VDC/Municipality" required
            />
          </div>
          <div class="local">
            <label for="District">District</label>
            <input
              type="text"
              name="District"
              placeholder="Enter the District" required
            />
          </div>
        </div>
      </div>

      <!-- Informative Text -->
      <p class="info-text">
        Dear Sir/Madam, <br />
        I am submitting the details below to inform about the birth of a newborn
        child. Please register the birth according to the law.
      </p>

      <div class="container__details">
        <h2>1. Newborn Baby Details</h2>

        <div class="form-group">
          <label for="full_name">Full Name:</label>
          <input
            type="text"
            name="full_name"
            placeholder="Enter the Full Name"required required
          />
        </div>

        <div class="form-group">
          <label>Date of Birth:</label>
          <input type="date" name="newborndob"required required/>
        </div>

        <div class="form-group">
          <label>Birth Location:</label>
          <div class="checkbox-group">
            <div class="checkbox-group-box">
              <label>Home</label>
              <input type="radio" value="home" name="BirthLocation" required required/>
            </div>
            <div class="checkbox-group-box">
              <label>Health Center</label>
              <input type="radio" value="healthCeter" name="BirthLocation" required required/>
            </div>
            <div class="checkbox-group-box">
              <label>Hospital</label>
              <input type="radio" value="hospital" name="BirthLocation" required required/>
            </div>
            <div class="checkbox-group-box">
              <label>Other</label>
              <input type="radio" value="other" name="BirthLocation" required required/>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Birth Attendant:</label>
          <div class="checkbox-group">
            <div class="checkbox-group-box">
              <label>Family Memeber</label>
              <input type="radio" value="familyMember" name="BirthAttendant" required required/>
            </div>
            <div class="checkbox-group-box">
              <label>Nurse</label>
              <input type="radio" value="nurse" name="BirthAttendant" required required/>
            </div>
            <div class="checkbox-group-box">
              <label>Doctor</label>
              <input type="radio" value="doctor" name="BirthAttendant" required required/>
            </div>
            <div class="checkbox-group-box">
              <label>Other</label>
              <input type="radio" value="other" name="BirthAttendant" required required/>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Gender:</label>
          <div class="checkbox-group">
            <div class="checkbox-group-box">
              <label>Male</label>
              <input type="radio" value="male" name="Gender" required required/>
            </div>
            <div class="checkbox-group-box">
              <label>Female</label>
              <input type="radio" value="female" name="Gender" required required/>
            </div>
            <div class="checkbox-group-box">
              <label>Other</label>
              <input type="radio" value="other" name="Gender" required required/>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Ethnicity / Caste:</label>
          <input type="text" placeholder="Enter the Ethnicity/Caste" required required/>
        </div>

        <div class="form-group">
          <label>Birth Type:</label>
          <div class="checkbox-group">
            <div class="checkbox-group-box">
              <label>Single</label>
              <input type="radio" value="single" name="BirthType" required required/>
            </div>
            <div class="checkbox-group-box">
              <label>Twin</label>
              <input type="radio" value="twin" name="BirthType" required required/>
            </div>
            <div class="checkbox-group-box">
              <label>Triplet or More</label>
              <input type="radio" value="tripletMore" name="BirthType" required required/>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Physical Disability:</label>
          <div class="checkbox-group">
            <div class="checkbox-group-box">
              <label>Yes</label>
              <input type="radio" value="yes" name="Physical" required required/>
            </div>
            <div class="checkbox-group-box">
              <label>No</label>
              <input type="radio" value="no" name="Physical" required required/>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>If Yes, Specify:</label>
          <input type="text" name="Specify" placeholder="Tell us more" />
        </div>

        <h2>Birthplace Address</h2>

        <div class="form-group">
          <label>District:</label>
          <input
            type="text"
            placeholder="Enter the District"
            name="birthplaceDistrict" required
          />
        </div>

        <div class="form-group">
          <label>VDC / Municipality:</label>
          <input
            type="text"
            placeholder="Enter the VDC/Municipality"
            name="birthplaceVDC" required
          />
        </div>

        <div class="form-group">
          <label>Ward No.:</label>
          <input
            type="text"
            placeholder="Enter the Ward No"
            name="birthplaceWardNo" required
          />
        </div>

        <h2>2. Parent's Information</h2>

        <div class="form-group">
          <label>Father's Full Name:</label>
          <input type="text" placeholder="Enter the Father's Full Name" name="parentFather" required />
        </div>

        <div class="form-group">
          <label>Mother's Full Name:</label>
          <input type="text" placeholder="Enter the Mother's Full Name" name="parentMother" required />
        </div>
      </div>
      <div>
        <h2>3. Newborn Baby's GrandFather and GrandMother Details</h2>
        <table>
          <tr>
            <th>Details</th>
            <th>GrandFather's Information</th>
            <th>GrandMother's Information</th>
          </tr>

          <tr>
            <td>Full Name</td>
            <td>
              <input
                type="text"
                placeholder="Enter the GrandFather's Information"
                name="newbornGrandFather" required
              />
            </td>
            <td>
              <input
                type="text"
                placeholder="Enter the GrandMother's Information"
                name="newbornGrandMother" required
              />
            </td>
          </tr>
        </table>

        <h2>Address Details</h2>
        <table>
          <tr>
            <th>Address</th>
            <th>Father's Information</th>
            <th>Mother's Information</th>
          </tr>
          <tr>
            <td>District</td>
            <td>
              <input
                type="text"
                placeholder="Enter the Father's District"
                name="Fatherdistrict" required
              />
            </td>
            <td>
              <input
                type="text"
                placeholder="Enter the Mother's District"
                name="Motherdistrict" required
              />
            </td>
          </tr>
          <tr>
            <td>Municipality / VDC</td>
            <td>
              <input
                type="text"
                placeholder="Enter the Father's Municipality/VDC"
                name="FatherVDC" required
              />
            </td>
            <td>
              <input
                type="text"
                placeholder="Enter the Mother's Municipality/VDC"
                name="MotherVDC" required
              />
            </td>
          </tr>
          <tr>
            <td>Ward No.</td>
            <td>
              <input
                type="text"
                placeholder="Enter the Father's Ward No"
                name="FatherWardNo" required
              />
            </td>
            <td>
              <input
                type="text"
                placeholder="Enter the Mother's Ward No"
                name="MotherWardNo" required
              />
            </td>
          </tr>
          <tr>
            <td>Street / Road</td>
            <td>
              <input
                type="text"
                placeholder="Enter the Father's Street/Road"
                name="FatherStreet" required
              />
            </td>
            <td>
              <input
                type="text"
                placeholder="Enter the Mother's Street/Road"
                name="MotherStreet" required
              />
            </td>
          </tr>
          <tr>
            <td>Village / Town</td>
            <td>
              <input
                type="text"
                placeholder="Enter the Father's Village/Town"
                name="FatherTown" required
              />
            </td>
            <td>
              <input
                type="text"
                placeholder="Enter the Mother's Village/Town"
                name="MotherTown" required
              />
            </td>
          </tr>
          <tr>
            <td>House No.</td>
            <td>
              <input
                type="text"
                placeholder="Enter the Father's House No"
                name="FatherHouseNo" required
              />
            </td>
            <td>
              <input
                type="text"
                placeholder="Enter the Mother's House No"
                name="MotherHouseNo" required
              />
            </td>
          </tr>

          <tr>
            <td>Place of Birth</td>
            <td>
              <input
                type="text"
                placeholder="Enter the Father's Place of Birth"
                name="FatherPlaceofbirth" required
              />
            </td>
            <td>
              <input
                type="text"
                placeholder="Enter the Mother's House No"
                name="MotherPlaceofbirth" required
              />
            </td>
          </tr>
          <tr>
            <td>Country of Birth</td>
            <td>
              <input
                type="text"
                placeholder="Enter the Father's Country of Birth"
                name="FathercountryofBirth" required
              />
            </td>
            <td>
              <input
                type="text"
                placeholder="Enter the Mother's Country of Birth"
                name="MothercountryofBirth" required
              />
            </td>
          </tr>
          <tr>
            <td>Nationality</td>
            <td>
              <input
                type="text"
                placeholder="Enter the Father's Nationality"
                name="Fathernationality" required
              />
            </td>
            <td>
              <input
                type="text"
                placeholder="Enter the Mother's Nationality"
                name="Mothernationality" required
              />
            </td>
          </tr>
          <tr>
            <td>National ID Number</td>
            <td>
              <input
                type="text"
                placeholder="Enter the Father's National ID Number"
                name="FatherNID" required
              />
            </td>
            <td>
              <input
                type="text"
                placeholder="Enter the Mother's National ID Number"
                name="MotherNID" required
              />
            </td>
          </tr>
          <tr>
            <td>Citizenship Number</td>
            <td>
              <input
                type="text"
                placeholder="Enter the Father's Citizenship Number"
                name="FatherCitizenshipNo" required
              />
            </td>
            <td>
              <input
                type="text"
                placeholder="Enter the Mother's Citizenship Number"
                name="MotherCitizenshipNo" required
              />
            </td>
          </tr>
          <tr>
            <td>Citizenship Issued District</td>
            <td>
              <input
                type="text"
                placeholder="Enter the Father's Citizenship Issued District"
                name="FatherCID" required
              />
            </td>
            <td>
              <input
                type="text"
                placeholder="Enter the Mother's Citizenship Issued District"
                name="MotherCID" required
              />
            </td>
          </tr>
          <tr>
            <td>Education Level (Highest)</td>
            <td>
              <input
                type="text"
                placeholder="Enter the Father's Highest Education Level"
                name="FatherELH" required
              />
            </td>
            <td>
              <input
                type="text"
                placeholder="Enter the Mother's Highest Education Level"
                name="MotherELH" required
              />
            </td>
          </tr>
          <tr>
            <td>Profession</td>
            <td>
              <input
                type="text"
                placeholder="Enter the Father's Profession"
                name="FatherProfession" required
              />
            </td>
            <td>
              <input
                type="text"
                placeholder="Enter the Mother's Profession"
                name="MotherProfession" required
              />
            </td>
          </tr>
          <tr>
            <td>Religion</td>
            <td>
              <input
                type="text"
                placeholder="Enter the Father's Religion"
                name="FatherReligion" required
              />
            </td>
            <td>
              <input
                type="text"
                placeholder="Enter the Mother's Religion"
                name="MotherReligion" required
              />
            </td>
          </tr>
          <tr>
            <td>Mother Tongue</td>
            <td>
              <input
                type="text"
                placeholder="Enter the Father's Mother Tongue"
                name="FatherMT" required
              />
            </td>
            <td>
              <input
                type="text"
                placeholder="Enter the Mother's Mother Tongue"
                name="MotherMT" required
              />
            </td>
          </tr>
          <tr>
            <td>Marriage Date (AD)</td>
            <td colspan="2">
              <input
                type="date"
                placeholder="Enter the Marriage Date in AD"
                name="FatherHouseNo" required
              />
            </td>
          </tr>
        </table>
        <div>
          <h2 class="title">Newborn Registration Form</h2>

          
            <!-- Name Section -->
            <div class="form-group full-width">
              <label>Full Name</label>
              <input
                type="text"
                placeholder="Enter the Newborn Full Name"
                name="NewBornFN" required
              />
            </div>

            <!-- Address Section -->
            <h3 class="section-title">Address</h3>
            <div class="form-group">
              <label>District</label>
              <input
                type="text"
                placeholder="Enter the Newborn District"
                name="NewBorndistrict" required
              />
            </div>
            <div class="form-group">
              <label>Ward No.</label>
              <input
                type="text"
                placeholder="Enter the Newborn Ward No"
                name="NewBornward" required
              />
            </div>
            <div class="form-group">
              <label>Street / Road</label>
              <input
                type="text"
                placeholder="Enter the Newborn Street / Road"
                name="NewBornstreet" required
              />
            </div>
            <div class="form-group">
              <label>Village / Town</label>
              <input
                type="text"
                placeholder="Enter the Newborn Village / Town"
                name="NewBornvillage" required
              />
            </div>
            <div class="form-group full-width">
              <label>House No.</label>
              <input
                type="text"
                placeholder="Enter the Newborn House No"
                name="NewBornhouse" required
              />
            </div>

            <!-- Citizenship Section -->
            <h3 class="section-title">Citizenship (For Nepalese Citizens)</h3>
            <div class="form-group">
              <label>Citizenship Certificate No.</label>
              <input
                type="text"
                placeholder="Enter the Citizenship Certificate No"
                name="CertificateNo" required
              />
            </div>
            <div class="form-group">
              <label>Issued Date (Year-Month-Day)</label>
              <input
                type="date"
                placeholder="Enter the Citizenship Issued Date"
                name="IssuedDate" required
              />
            </div>
            <div class="form-group full-width">
              <label>Issued District</label>
              <input
                type="text"
                placeholder="Enter the Citizenship Issued District"
                name="IssuedDistrict" required
              />
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn">Submit</button>
          </form>
        </div>
      </div>
    </div>
    <script>
   let formSubmitted = false; // Track if the form has been submitted

window.addEventListener("beforeunload", function (event) {
    if (!formSubmitted) {
        event.preventDefault();
        event.returnValue = ""; // Required for Chrome
    }
});

document.getElementById("registrationForm").addEventListener("submit", function () {
    formSubmitted = true; // Set to true when the form is submitted
});

</script>
  </body>
</html>
