<?php




$conn = mysqli_connect('localhost', 'root', '', 'voterdatabase');


$name=$_POST['name'];
$partyname=$_POST['partyname'];

$images=$_FILES['symbol']['name'];
$tmp_name=$_FILES['symbol']['tmp_name'];

$image=$_FILES['photo']['name'];
$tmp_name1=$_FILES['photo']['tmp_name'];
$discrbtion=$_POST['discrbtion'];


$insert=mysqli_query($conn,"INSERT INTO addcandidate (name,partyname,symbol,photo,discrbtion)VALUES('$name','$partyname','$images','$image','$discrbtion')");


if($insert==true){
    move_uploaded_file($tmp_name,"image/$images");
     move_uploaded_file($tmp_name1,"image/$image");


         echo '<script>
    alert("Candidate Add Seccessfuly");
    location = "AdminDashboard.php";
    </script>';
}else{
   
         echo  "Some Eror";


}








?>