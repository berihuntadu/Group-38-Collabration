<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'voterdatabase');

$nationalidnumber = $_POST['nationalidnumber'];
$mobile = $_POST['mobile'];
$pass = $_POST['pass'];

$check = mysqli_query($conn, "SELECT * FROM Voterregistration WHERE nationalidnumber='$nationalidnumber' AND mobile='$mobile' AND pass='$pass'");

if(mysqli_num_rows($check) > 0) {
    $Voterdata = mysqli_fetch_assoc($check); // Changed to fetch_assoc for clarity
    $_SESSION['voterdata'] = $Voterdata; //this uses for echo mainly btrbro
    
    echo '<script>location="../dashboard/dashboard.php";</script>';
} else {
    echo "Login failed! Invalid credentials.";
}
?>