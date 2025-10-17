<?php
ob_start();
session_start();
include('../config/connection.php');
date_default_timezone_set('Asia/Bangkok');


//log_out_1year
if ($_SESSION["x_member_1year"] != '') {

    $member_id = $_SESSION["x_member_1year"];
    $status = 0;
    $strSQL = "UPDATE tbl_x_member_1year SET status = ? WHERE id = ? ";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("is", $status, $member_id);
    $stmt->execute();
    $stmt->close();
    //------------------update time---------------------//

    $str = "SELECT logid FROM tbl_x_log_member_1year WHERE id=? ORDER BY logdate DESC LIMIT 0,1";
    $stmt = $conn->prepare($str);
    $stmt->bind_param("s", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_array();
    $logid = $data["logid"];
    $stmt->close();

    $now = date("Y-m-d H:i:s");
    $smg = "UPDATE tbl_x_log_member_1year SET outdate=? WHERE logid=?";
    $query = $conn->prepare($smg);
    $query->bind_param("ss", $now, $logid);
    $query->execute();
    $query->close();

}

if ($_SESSION["x_member_id"] != '') {

    $now = date("Y-m-d H:i:s");
    $member_id = $_SESSION["x_member_id"];
    $strSQL = "SELECT id FROM tbl_x_log_member WHERE member_id=? ORDER BY logdate DESC LIMIT 0,1";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_array();
    $id = $data["id"];
    $stmt->close();

    $str = "UPDATE tbl_x_log_member SET outdate=? WHERE id=?";
    $query = $conn->prepare($str);
    $query->bind_param("ss", $now, $id);
    $query->execute();
    $query->close();

}

// log_out_general
if ($_SESSION["y_member_id"] != '' || $_COOKIE["y_member_id"] != '') {
    $now = date("Y-m-d H:i:s");
    $member_id = $_SESSION["y_member_id"] ? $_SESSION["y_member_id"] : $_COOKIE["y_member_id"];
    $strSQL = "SELECT id FROM tbl_x_log_member_general WHERE member_id=? ORDER BY logdate DESC LIMIT 0,1";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_array();
    $id = $data["id"];
    $stmt->close();

    $str = "UPDATE tbl_x_log_member_general SET outdate=? WHERE id=?";
    $query = $conn->prepare($str);
    $query->bind_param("ss", $now, $id);
    $query->execute();
    $query->close();

    if (isset($_COOKIE['y_member_id'])) {
        $name = 'y_member_id';
        setcookie($name, '', time() - 3600, '/');
    }
    if (isset($_COOKIE['etest'])) {
        $name = 'etest';
        setcookie($name, '', time() - 3600, '/');
    }

}

mysqli_close($conn);

// Unset all of the session variables
$_SESSION = [];

// Delete the session cookie
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}
session_destroy();

header("Location: ../index.php");
exit;

?>