<?php 

$conn = mysqli_connect('localhost', 'root', '', 'voterdatabase');

$name = $_POST['name'];
$dob = $_POST['dob'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$gender = $_POST['gender'];
$image = $_FILES['photo']['name'];
$tmp_name = $_FILES['photo']['tmp_name'];
$idtype = $_POST['idtype'];
$nationalidnumber = $_POST['nationalidnumber'];
$region = $_POST['region'];
$wereda = $_POST['wereda'];
$city = $_POST['city'];
$regdate = $_POST['regdate'];
$pass = $_POST['pass'];
$cpass = $_POST['cpass'];

if($pass == $cpass){
    move_uploaded_file($tmp_name,"../VoterImage/$image");

    $insert = mysqli_query($conn, "
        INSERT INTO voterregistration (
            name, dob, email, mobile, gender, photo, idtype, nationalidnumber, region, wereda, city, regdate, pass, cpass, status, votes
        ) VALUES (
            '$name', '$dob', '$email', '$mobile', '$gender', '$image', '$idtype', '$nationalidnumber', '$region', '$wereda', '$city', '$regdate', '$pass', '$cpass', 0, 0
        )
    ");

    echo '<script>
    alert("Forem Submited Successfuly");
    location="../Voter login Form/index.html";
    </script>';

} else {
    echo '<script>
    alert("Password and Confirm Password does not match");
    location.href = "../Voter Registration From/index.html";
    </script>';
}

?>
