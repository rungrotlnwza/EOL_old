<?php
ob_start();
session_start();
include('../config/connection.php');
date_default_timezone_set('Asia/Bangkok');
if ($_SESSION["x_member_id"] != '') {
    $now = date("Y-m-d H:i:s");
    $member_id = $conn->real_escape_string($_SESSION["x_member_id"]);
    $strSQL = "SELECT id FROM tbl_x_log_member WHERE member_id = ? ORDER BY logdate DESC LIMIT 0,1";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_array();
    $id = $data["id"];
    $stmt->close();

    $str = "UPDATE tbl_x_log_member SET outdate = ? WHERE id = ?";

    $query = $conn->prepare($str);
    $query->bind_param("ss", $now, $id);
    // $query->execute();
    // $is_ok = $query->close();
    if ($query->execute()) {
        echo "OK";
    }
    else {
        echo "Something an error occurred";
    }
    $query->close();
    mysqli_close($conn);

}
?>