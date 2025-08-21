
<?php


$conn = mysqli_connect('localhost', 'root', '', 'voterdatabase');
$query="SELECT *FROM addcandidate";
$result = mysqli_query($conn,$query);








?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<style>
.nav-item a:hover{
background: red;
color: white;
border-radius: 7px;
}

.nav-item a{
    font-family: sans-serif;
    color:blue;
}

</style>
</head>
<body>
    <ul class="nav justify-content-center bg-dark"padding:20px; >
 <h1 style="font-family: sans-serif;color:green">2bnk online voting system</h1>
</ul>


<nav class="navbar navbar-expand-lg navbar-light bg-light" style="position: sticky;">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><img src="image/admin1.jpg" style="width:200px;"><b style="color: darkcyan;">Admin  Pannel</b></a>
    <button class="navbar-toggler navbar-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../dashboard.php">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#Add Candidates">Add Candidates</a>
        </li>


        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#Total">Total candidates</a>
        </li>


          <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="/dashboard/Admin Login/adminlogout.php">Logout</a>
</li>


     
      </ul>
    </div>
  </div>
</nav>



<div id="header">


<img src="image/background.jpg" width="100%" height="650px">
</div>
<br><br>
<div class="container-fluid " id="Add Candidates" style="box-shadow: 2px 2px 10px rgba(0,0,0,0.9); padding :40px;">
    <div class="row">
        <div class="col-sm-8">
<h2 style="text-align: center;"> <span style="background-color: midnightblue; color:whitesmoke;padding:10px;border-radius:10px;"> Candidate For Election</span></h2><br><br><br>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <form action="AddCandidate.php" method="post" enctype="multipart/form-data">
  <div class="mb-3" id="">
    <label for="exampleInputEmail1" class="form-label">Candidates Name</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="name">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Party Name</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="partyname">
  </div>

 <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">discrbtion</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="discrbtion">
  </div>






            </div>


           <div class="col-sm-6">
                
  <div class="mb-3">
    <label for=" candidates name" class="form-label">Select Symbol</label>
    <input type="file" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="symbol">
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label"> Select Candidates Photo</label>
    <input type="file" class="form-control" id="exampleInputPassword1 " name="photo">
  </div>
  <button type="submit" class="btn btn-primary" >Submit</button>
</form>
            </div>
 </div>
    </div>
 
        <div class="col-sm-4">
            <img src="image/background.jpg" width="100%" height="100%">
        </div>
        
    </div>
</div>















   <!-- Bootstrap JS Bundle (neseserey for toggle functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<br><br>





<div class="container" id="Total">
<div class="row">
  
  <div class="col-sm-10">
        <h2 style="text-align: center;"><span style="background: mediumblue;color:whitesmoke;padding:10px;border-radius:10px">Total  LIst Of Candidate</span></h2><br><br>

<table class="table">
  <thead>
    <tr>
      <th scope="col">Candidate Name</th>
      <th scope="col">Party</th>
      <th scope="col">Photo</th>
    </tr>
  </thead>
<?php

while($row=mysqli_fetch_assoc($result)){?>
</tbody>
    <tr>
      <td><?php echo $row['name']?></td>
      <td><?php echo $row['partyname']?></td>
      <td><img src="image/<?php echo $row['photo']?>"width="200px";></td>
    </tr>
    <?php

}


?>
  </tbody>
</table>
  </div>
</div>



</div>


















</body>

</html>