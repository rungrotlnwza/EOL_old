<?php
ob_start();
session_start();
require_once "../config/connection.php";
if ($_SESSION["x_member_id"] && $_SESSION["x_member_admin"]) {
    if (strlen(trim($_POST["rename"])) >= 8 && strlen(trim($_POST["newpass"])) >= 8 && strlen(trim($_POST["repass"])) >= 8 &&
    strlen(trim($_POST["rename"])) <= 20 && strlen(trim($_POST["newpass"])) <= 20 && strlen(trim($_POST["repass"])) <= 20) {
        // ----- check 
        if (trim($_POST["newpass"]) == trim($_POST["repass"])) {
            $member = $conn->real_escape_string(trim($_POST["member"]));
            $rename = $conn->real_escape_string(trim($_POST["rename"]));

            // check username from tb_x_member_1year
            $SQL = "SELECT * FROM tbl_x_member_1year WHERE user = ?";
            $query = $conn->prepare($SQL);
            $query->bind_param("s", $rename);
            $query->execute();
            $result = $query->get_result();
            $is_have = $result->num_rows;
            $query->close();

            // check username from tb_x_member
            $strSQL = "SELECT * FROM tbl_x_member WHERE user = ? && !(member_id = '$member')";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("s", $rename);
            $stmt->execute();
            $result = $stmt->get_result();
            $is_same = $result->num_rows;
            $data = $result->fetch_array();

            // ---check username----//
            //--- username already---//
            if ($is_same >= 1 || $is_have >= 1 && ($data["member_id"] != $_POST["member"])) {
                echo "<font size=2 face=tahoma color=red>This username is already created.</font>";
            }

            //---- no username not already -----//
            else if ($is_same == 0 && $is_have == 0 || ($data["member_id"] == $_POST["member"])) {

                $newpass = $conn->real_escape_string(trim($_POST["newpass"]));

                $smg = "UPDATE tbl_x_member SET user = ?, pass = ? WHERE member_id = ?";
                $query = $conn->prepare($smg);
                $query->bind_param("sss", $rename, $newpass, $member);
                $is_ok = $query->execute();

                if ($is_ok) {
                    echo "OK";
                }
                else {
                    echo "Edit SubAccout fail !";
                }
            }
            //----  end no username not already -----//
            mysqli_close($conn);
        }
        else {
            echo "<font size=2 face=tahoma color=red>Re-Password is not same as your password.</font>";
        }
    }
    else {
        echo "<font size=2 face=tahoma color=red>Please Insert Username , Password , <br> Re-Password and Please use 'a-z', 'A-Z', <br> '0-9', '-', '_' or '@' as 8-20 characters long</font>";
    }
}
else {
    echo "Please login";
}

?>