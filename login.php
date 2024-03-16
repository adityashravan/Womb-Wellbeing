<?php
error_reporting(0);
session_start();
$server = "localhost";
$dbusername = "root";
$dbpassword = "";
$database = "foetus1";
$conn = mysqli_connect($server, $dbusername, $dbpassword, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Input Form Doctor And Save Into Database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if($_REQUEST['act']== "sin")
	{
		$uname = mysqli_real_escape_string($conn, $_POST['sinuser']);
		$upass = mysqli_real_escape_string($conn, $_POST['sinpass']);
		
		$sql = "select * from tbl_login where username='$uname' and password='$upass'";
		$feach = mysqli_query($conn, $sql);
		
		if(mysqli_num_rows($feach)>0)
		{
			$row = mysqli_fetch_assoc($feach);
			$ltype = $row['type'];
			$_SESSION['isLoggedIn']=true;
			$_SESSION['LoggedInUtp']=$ltype;
			$_SESSION['LoggedInUid']=$row['id'];
			$_SESSION['LoggedInUsr']=$row['username'];
			if($ltype == "Doctor")
			{
				header("location: childtable.php");
			}
			else if($ltype == "Parent")
			{
				header("location: viewchildtable.php");
			}
		}
		else
		{
			header("location: ?lmsg=fail");
		}
        
	}
	
	if($_REQUEST['act']== "sup")
	{
		$type = mysqli_real_escape_string($conn, $_POST['stype']);
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		
		$sql= "INSERT INTO `tbl_login` (`type` , `username` , `email` ,  `password`) VALUES ('$type' , '$username' , '$email' , '$password')";
		//print $sql;exit();
		$insert = mysqli_query($conn, $sql);
		header("location: ?msg=success");
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style-login.css" />
  <title>Sign in & Sign up Form</title>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
		
        <form name="signin" method="POST" action="?act=sin" class="sign-in-form">
          <h2 class="title">Sign in</h2>
		  
		  <?php if($_REQUEST['lmsg']=="fail") {?>
			<p style="color:red;">Sign in failed.</p>
		  <?php } ?>
		  
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="sinuser" placeholder="Username" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="sinpass" placeholder="Password" />
          </div>
          <input type="submit" value="Login" class="btn solid" />
          <p class="social-text">Connect with us on social platforms</p>
          <div class="social-media">
            <a href="https://github.com/pegasus200403/Fetal-Health-Classifier" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://github.com/pegasus200403/Fetal-Health-Classifier" class="social-icon">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="https://github.com/pegasus200403/Fetal-Health-Classifier" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
            <a href="https://github.com/pegasus200403/Fetal-Health-Classifier" class="social-icon">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </form>
		
		
        <form name="signup" method="POST" action="?act=sup" class="sign-up-form">
		
          <h2 class="title">Sign up</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
           <select name="stype" id="" required>
            <option value="">--Select Type--</option>
            <option value="Doctor">Doctor</option>
            <option value="Parent">Parent</option>
           </select>
          </div>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Username" required/>
          </div>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="Email" required/>
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required/>
          </div>
          <input type="submit" class="btn" value="Sign up" />
		  
          <p class="social-text">Or Sign up with social platforms</p>
          <div class="social-media">
            <a href="#" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>New here ?</h3>
          <p>
            Welcome to foetus check up,make sure your new born and the mother is healthy
          </p>
		  
			<?php if($_REQUEST['msg']=="success") {?>
				<p style="color:red;">Sign up successfull</p>
			<?php } ?>
		  
          <button class="btn transparent" id="sign-up-btn">
            Sign up
          </button>
        </div>
        <img src="Images/undraw_medicine_b-1-ol.svg" class="image" alt="Doctor image" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>One of us ?</h3>
          <p>
            Sign in and enter details to check your foetus health for free!
          </p>
          <button class="btn transparent" id="sign-in-btn">
            Sign in
          </button>
        </div>
        <img src="Images/undraw_mobile_content_xvgr.svg" class="image" alt="Register" />
      </div>
    </div>
  </div>

  <script src="app.js"></script>
</body>

</html>