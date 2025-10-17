<?php
ob_start();
session_cache_expire(30);
session_start();
include('../config/connection.php');
if (trim($_POST["x_user"]) && trim($_POST["x_pass"])) 
{

	if ($_SESSION["x_member_1year"] != '') {
		header("Location:../1yearcourse.php");
		exit();
	}
	//----------------connect databae------------------//
	date_default_timezone_set('Asia/Bangkok');
	$date = date("Y-m-d H:i:s");
	// $enddate = date("Y-m-d H:i:s", strtotime("-30 minute", strtotime($date)));
	//$enddate = date ("Y-m-d H:i:s", strtotime());
	// set status user 
	// $table = $sql[tb_x_member_1year];	
	// $value = " status=0 ";		
	// $where = " where  time_login<='$enddate' ";
	// update($table,$value,$where);

	// $strSQL = "UPDATE tb_x_member_1year SET status=0 WHERE time_login <= '$enddate'";
	// mysqli_query($conn,$strSQL);


	//-----------------query--x member-1year-------------// 
	$user = $conn->real_escape_string(trim($_POST["x_user"]));
	$pwd = $conn->real_escape_string(trim($_POST["x_pass"]));
	// $status = 0;

	$msg = "SELECT * FROM tbl_x_member_1year WHERE user=? && pass=?";

	$stmt = $conn->prepare($msg);
	$stmt->bind_param("ss", $user, $pwd);
	$stmt->execute();
	$result = $stmt->get_result();
	$is_ok = $result->num_rows;
	if ($is_ok == 1) //---if member ture---//
	{

		$data = $result->fetch_array();
		$member_id = $data["id"];
		$member_user = $data["user"];
		$member_pass = $data["pass"];
		$end_date = $data["enddate"];
		$stmt->close();

		$session_id = session_id();
		$now = date("Y-m-d H:i:s");

		$str = "SELECT * FROM tbl_x_login_1year WHERE member_id=? ";
		$query = $conn->prepare($str);
		$query->bind_param("s", $member_id);
		$query->execute();
		$result = $query->get_result();
		$is_have = $result->num_rows;
		$query->close();

		if ($is_have == 1) {
			$smg = "UPDATE tbl_x_login_1year SET ssid=?, create_date=? WHERE member_id=?";
			$query = $conn->prepare($smg);
			$query->bind_param("sss", $session_id, $now, $member_id);
			$query->execute();
			$query->close();
		}

		if ($is_have == 0) {
			$msg = "INSERT INTO tbl_x_login_1year (member_id,ssid,create_date) VALUES(?,?,?)";
			$query = $conn->prepare($msg);
			$query->bind_param("sss", $member_id, $session_id, $now);
			$query->execute();
			$query->close();
		}

		if ($data["active"] == 1) {
			$date_end = new DateTime($end_date);
			$date_end->modify('+1 months');
			$expiry_date = $date_end->format('Y-m-d H:i:s');
			if ($now > $expiry_date && $member_id != 4) {
				echo "<script type=\"text/javascript\">
						alert('User account has expired!');
						window.location=\"logout.php\";
					 </script>";
				exit();
			}
			else {
				$status = 0;
				$strSQL = "UPDATE tbl_x_member_1year SET status=?, time_login=? WHERE id=? ";
				$query = $conn->prepare($strSQL);
				$query->bind_param("iss", $status, $now, $member_id);
				$query->execute();
				$query->close();
			}

		}
		if ($data["active"] == 0) {
			$date = date("Y-m-d H:i:s");
			$enddate = date("Y-m-d H:i:s", strtotime("+1 year +4 week", strtotime($date)));
			$status = 0;
			$active = 1;
			$admin = 0;
			$str = "UPDATE tbl_x_member_1year SET status=?, active=?, startdate=?, enddate=?, time_login=?, admin=? WHERE id=? ";
			$query = $conn->prepare($str);
			$query->bind_param("iisssis", $status, $active, $date, $enddate, $now, $admin, $member_id);
			$query->execute();
			$query->close();
		}

		//------ insert logtime member 1year-----//

		$sql = "INSERT INTO tbl_x_log_member_1year (id, logdate, outdate) VALUES (?,?,?)";
		$query = $conn->prepare($sql);
		$query->bind_param("sss", $member_id, $now, $now);
		$query->execute();
		$query->close();

		$_SESSION["x_member_1year"] = $conn->real_escape_string(trim($member_id));

		header("Location: ../1yearcourse.php");
	}
	elseif ($is_ok == 0) {
		//-----------------query--x-member-------------//
		$strSQL = "SELECT * FROM tbl_x_member WHERE user=? && pass=?";
		$stmt = $conn->prepare($strSQL);
		$stmt->bind_param("ss", $user, $pwd);
		$stmt->execute();
		$result = $stmt->get_result();
		$is_ok = $result->num_rows;

		if ($is_ok == 1) //---if member ture---//
		{
			$data = $result->fetch_array();
			$member_id = trim($data["member_id"]);
			$is_admin = trim($data['is_admin']);
			$_SESSION["x_member_id"] = $conn->real_escape_string($member_id);
			$ip = $_SERVER["REMOTE_ADDR"];

			//-- check admin corporate --//	
			if ($is_admin == 1) {
				$_SESSION['x_member_admin'] = $is_admin;
			}
			else {
				unset($_SESSION['x_member_admin']);
			}

			$session_id = session_id();
			$now = date("Y-m-d H:i:s");

			$str = "SELECT * FROM tbl_x_login WHERE member_id=? ";
			$query = $conn->prepare($str);
			$query->bind_param("s", $member_id);
			$query->execute();
			$result = $query->get_result();
			$is_have = $result->num_rows;
			$query->close();



			if ($is_have == 1) {
				$smg = "UPDATE tbl_x_login SET session_id=?, create_date=? WHERE member_id=?";
				$query = $conn->prepare($smg);
				$query->bind_param("sss", $session_id, $now, $member_id);
				$query->execute();
				$query->close();
			}

			if ($is_have == 0) {
				$msg = "INSERT INTO tbl_x_login (member_id,session_id,create_date) VALUES(?,?,?)";
				$query = $conn->prepare($msg);
				$query->bind_param("sss", $member_id, $session_id, $now);
				$query->execute();
				$query->close();
			}

			$sql = "SELECT * FROM tbl_x_member_type WHERE member_id=?";
			$query = $conn->prepare($sql);
			$query->bind_param("s", $member_id);
			$query->execute();
			$result = $query->get_result();
			$is_have = $result->num_rows;
			$query->close();

			if ($is_have == 0) {

				$logSQL = "INSERT INTO tbl_x_log_member (member_id, logdate, outdate, logip) VALUES(?, ?, ?, ?)";
				$query = $conn->prepare($logSQL);
				$query->bind_param("ssss", $member_id, $now, $now, $ip);
				$query->execute();
			}
			header("Location: ../EOL/eoltest.php?section=business");
		}
		else {
			header("Location:../index.php");
		}
	}


	//-----------------query--general-member-------------//

	$strSQL = "SELECT * FROM tbl_x_member_general WHERE user=? && pass=?";
	$stmt = $conn->prepare($strSQL);
	$stmt->bind_param("ss", $user, $pwd);
	$stmt->execute();
	$result = $stmt->get_result();
	$is_ok = $result->num_rows;
	// $stmt->close();

	if ($is_ok == 1) //---if member ture---//
	{
		$data = $result->fetch_array();
		$member_id = trim($data["member_id"]);
		$_SESSION["y_member_id"] = $member_id;
		setcookie("y_member_id", $member_id, time() + 9000, "/");
		$_SESSION["fname"] = isset($data['fname']) ? $data['fname'] : '';
		$_SESSION["lname"] = isset($data['lname']) ? $data['lname'] : '';
		$ip = $_SERVER['REMOTE_ADDR'];
		$stmt->close();
		//-- ----------------------------------------------- --//	
		$session_id = session_id();
		$now = date("Y-m-d H:i:s");

		$sql = "SELECT * FROM tbl_x_general_login WHERE member_id=?";
		$query = $conn->prepare($sql);
		$query->bind_param("s", $member_id);
		$query->execute();
		$result = $query->get_result();
		$is_have = $result->num_rows;
		$query->close();

		if ($is_have == 1) {

			$smg = "UPDATE tbl_x_general_login SET session_id = ?, create_date = ? WHERE member_id = ? ";
			$query = $conn->prepare($smg);
			$query->bind_param("sss", $session_id, $now, $member_id);
			$query->execute();
			$query->close();
		}
		if ($is_have == 0) {

			$smg = "INSERT INTO tbl_x_general_login (member_id, session_id, create_date) VALUES(?,?,?)";
			$query = $conn->prepare($smg);
			$query->bind_param("sss", $member_id, $session_id, $now);
			$query->execute();
			$query->close();
		}

		$str = "INSERT INTO tbl_x_log_member_general (member_id, logdate, outdate, logip) VALUES (?,?,?,?)";
		$query = $conn->prepare($str);
		$query->bind_param("ssss", $member_id, $now, $now, $ip);
		$query->execute();
		$query->close();

		header("Location: ../EOL/register_general.php");
	}

	
//------------------------------------------//			
	mysqli_close($conn);
//------------------------------------------//
}
else 
{
	header("Location:../index.php");
}


?>