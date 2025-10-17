<?php
ob_start();
session_start();
include('../config/connection.php');


if ($_SESSION['x_member_1year'] != '') 
{
	if (!empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['email']) && (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false)) {

		$fname = $conn->real_escape_string(trim($_POST["fname"]));
		$lname = $conn->real_escape_string(trim($_POST["lname"]));
		$email = $conn->real_escape_string(trim($_POST["email"]));

		$strSQL = "UPDATE tbl_x_member_1year SET fname = ?, lname = ?, email = ? WHERE id = ?";
		$stmt = $conn->prepare($strSQL);
		$stmt->bind_param("ssss", $fname, $lname, $email, $_SESSION['x_member_1year']);
		$is_ok = $stmt->execute();
		if ($is_ok) {
			$status = 'ok';
		}
		else {
			$status = 'err';
		}
		mysqli_close($conn);
		echo $status;
		die;

	}

}

?>