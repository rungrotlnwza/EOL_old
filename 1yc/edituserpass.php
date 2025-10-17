<?php
ob_start();
session_start();
include('../config/connection.php');


if ($_SESSION['x_member_1year'] != '') {
    if (!empty($_POST['user']) && !empty($_POST['pass'])) {

        $user = $conn->real_escape_string(trim($_POST["user"]));
        $pass = $conn->real_escape_string(trim($_POST["pass"]));

        // check username from tb_x_member
        $str = "SELECT * FROM tbl_x_member WHERE user = ?";
        $stmt = $conn->prepare($str);
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();
        $is_have = $result->num_rows;
        $stmt->close();

        // check username from tb_x_member_1year
        $SQL = "SELECT * FROM tbl_x_member_1year WHERE user = ?  && !(id = '$_SESSION[x_member_1year]')";
        $query = $conn->prepare($SQL);
        $query->bind_param("s", $user);
        $query->execute();
        $result = $query->get_result();
        $is_same = $result->num_rows;
        $query->close();

        // ---check username----//
        //--- username already---//
        if ($is_same >= 1 || $is_have >= 1) {
            echo '<span style="color:red;">This username is already created.</span>';
        }
        else if ($is_same == 0 && $is_have == 0) {
            $strSQL = "UPDATE tbl_x_member_1year SET user = ?, pass = ? WHERE id = ?";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("sss", $user, $pass, $_SESSION['x_member_1year']);
            $is_ok = $stmt->execute();
            if ($is_ok) {
                echo 'ok';
            }
            else {
                echo '<span style="color:red;">Some problem occurred, please try again.</span>';
            }
        }
        mysqli_close($conn);
    }
}

?>