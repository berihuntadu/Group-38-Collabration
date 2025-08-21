<?php

$conn = mysqli_connect('localhost', 'root', '', 'voterdatabase');
$name=$_POST['name'];
$password=$_POST['password'];
$check = mysqli_query($conn, "SELECT * FROM adminlogin WHERE name='$name' AND password='$password'");
if(mysqli_num_rows($check)>0){
echo  '

<script>



location="AdminDashboard.php";




</script>




';
}else{


echo  '

<script>



alert("Incorect Information !! You are Not Admin!");

location="../dashboard.php";




</script>




';




}







?>