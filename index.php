<!DOCTYPE html>
<html>

<head>
	<title>Employee System</title>
	<meta http-equiv="Content-Type" content="text/html" ; charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style/main.css">

</head>

<!--NAVIGATION BAR-->
<nav>
	<ul>
		<li class="menu"><a href="index.php">Add</a></li>
		<li class="menu"><a href="employees.php">Employees</a></li>
	</ul>
</nav>

<!--PAGE CONTENT-->

<body>
	<h1>Add Employee</h1>
	<br>* Mandatory to fill.
	<form name="form" action="index.php" method="POST">
		<br><label for="fname">First Name: *</label><br>
		<input type="text" id="fname" name="fname" placeholder="Your First Name" required><br>
		<label for="mname">Middle Name:</label><br>
		<input type="text" id="mname" name="mname" placeholder="Your Middle Name"><br>
		<label for="lname">Last Name: *</label><br>
		<input type="text" id="lname" name="lname" placeholder="Your Last Name" required><br>
		<label for="email">Email: *</label><br>
		<input type="email" id="email" name="email" placeholder="e.g. issoys@ttu.ee" required><br>
		<label for="phone">Phone:</label><br>
		<input type="tel" id="phone" name="phone" placeholder="e.g. 372-530-9999" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"><br>
		<label for="hiredate">Hire Date: *</label><br>
		<input type="date" id="hiredate" name="hiredate" required><br>
		<label for="active">Active:</label><br>
		<input type="checkbox" id="active" name="active" value="YES"><br>
		<input type="submit" name="submitbutton" value="Submit">
	</form><br>

	<!--MYSQL Connection and Update-->
	<?php
	error_reporting(0);

	if (isset($_POST["submitbutton"])) {
		$link = mysqli_connect("localhost", "root", "", "employee_db", 3305);

		if ($link === false) {
			die("ERROR: Could not connect. " . mysqli_connect_error());
		}

		if ($active == "") {
			$active = "NO";
		}

		$fname = mysqli_real_escape_string($link, $_REQUEST['fname']);
		$mname = mysqli_real_escape_string($link, $_REQUEST['mname']);
		$lname = mysqli_real_escape_string($link, $_REQUEST['lname']);
		$email = mysqli_real_escape_string($link, $_REQUEST['email']);
		$phone = mysqli_real_escape_string($link, $_REQUEST['phone']);
		$hiredate = mysqli_real_escape_string($link, $_REQUEST['hiredate']);
		$active = mysqli_real_escape_string($link, $_REQUEST['active']);

		if ($active == "") {
			$active = "NO";
		}

		if ((strtotime($hiredate) ? true : false) and (explode("/", $hiredate)[0] <= 2099 ? true : false)
			and (preg_match("/^[- '\p{L}]+$/u", $fname) == 1 ? true : false)
			and ($mname != "" ? (preg_match("/^[- '\p{L}]+$/u", $mname) == 1 ? true : false) : true)
			and (preg_match("/^[- '\p{L}]+$/u", $lname) == 1 ? true : false)
		) {

			$sql = "INSERT INTO persons (fname, mname, lname, email, phone, hiredate, active) VALUES ('$fname', '$mname','$lname','$email','$phone','$hiredate','$active')";

			if (mysqli_query($link, $sql)) {
				echo "Records added successfully.";
			} else {
				echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
			}
		} else {
			print("Enter the parameters correctly");
		}
		mysqli_close($link);
	}
	?>
</body>

</html>