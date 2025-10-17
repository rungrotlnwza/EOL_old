<?php
ob_start();
session_start();
include('../config/connection.php');
date_default_timezone_set('Asia/Bangkok');
class info
{

    public function loadinfo($txtOpt)
    {
        include('../config/connection.php');
        include('./config/connection.php');

        if ($_SESSION["x_member_id"]) {

            if ($_SESSION["x_member_id"]) {
                $member_id = trim($_SESSION["x_member_id"]);
            }
            $strSQL = "SELECT * FROM tbl_x_member WHERE member_id=?";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("s", $member_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $is_ok = $result->num_rows;

            if ($is_ok == 1) {
                $data = $result->fetch_array();
                $gender = $data["gender"];
                $fname = $data["fname"];
                $lname = $data["lname"];
                //--------------switch option menu--------------//

                $img_path = "../2010/member_images/$member_id.jpg";
                $data_image = @getimagesize($img_path);

                if ($data_image[0] >= 1 && $data_image[0] - $data_image[0] == 0) {
                    $msg_image = "../2010/member_images/" . $member_id . ".jpg";
                }
                else { // no image profile 
                    if ($gender == 0) {
                        $gender = 1;
                    }
                    $msg_image = "../2010/member_images/icon_user_0" . $gender . ".jpg";
                }
                $img = '<div id="pic_profile">
                            <img src="' . $msg_image . '" height="100"  width="100"/>
                       </div>
                       <div id="user_text">
                            <p style="margin-left:20px;font-weight:bold;">' . $fname . '&nbsp;&nbsp;&nbsp;&nbsp;' . $lname . ' </p>
                                ' . $this->profile($this->check_master()) . '
                       </div>';
?>


<?php
                $stmt->close();
            }
        }
        else { // NO Login
            // check form for normal page or test page 
            // echo "Don't have member id!!!";
            if ($txtOpt == 'normal') {
?>
<form method=post action="https://www.engtest.net/inc/login.php">
    <div style="display:inline-block;border:0px solid blue;line-height:8px;vertical-align: top !important;">
        <input type="text" tabindex="1" name="x_user" id="x_user" class="form-control" style="width:180px;"
            placeholder="Username" required><BR>
        <a href="https://www.engtest.net/register/register_account.php" class="over_a" id="signup"><span
                style="font-size:14px;color:#ffffff;">Sign Up / Register</span></a>
    </div>
    <div style="display:inline-block;border:0px solid blue;line-height:8px;vertical-align: top !important;">
        <input type="password" tabindex="2" name="x_pass" id="x_pass" class="form-control" style="width:180px;"
            placeholder="Password" autocomplete="on" required><BR>
        <a href="https://www.engtest.net/register/send_email.php" class="over_a" id="forgot"><span
                style="font-size:14px;color:#ffffff;">Forgot Password?</span></a>
    </div>
    <div style="display:inline-block;vertical-align: top !important;">
        <input type="submit" tabindex="3" id="login" class="btn"
            style="width:80px;background:#f75b1e !important;color:#ffffff;" value="LOGIN">
    </div>
</form>
<?php
            }

        }
        mysqli_close($conn);
        return $img;
    }

    private function check_master()
    {
        //check corporate amount//
        include('./config/connection.php');
        include('../config/connection.php');
        $type = "";

        if ($_SESSION["x_member_id"]) {
            $member_id = $_SESSION["x_member_id"];
        }

        $strSQL = "SELECT * FROM tbl_x_member_amount WHERE member_id=?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $member_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $is_ok = $result->num_rows;
        $stmt->close();
        // if corporate user
        if ($is_ok == 1) {
            $type = "master";
        }

        // check if personal user
        if ($is_ok == 0) {

            $strSQL = "SELECT * FROM tbl_x_member WHERE member_id=?";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("s", $member_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $is_member = $result->num_rows;
            $stmt->close();

            if ($is_member == 1) {
                $type = "personal";
                $refill = 0;
                $number = 1;
                //---------------------------------------------------------------------------------------//

                $msg = "SELECT a.sub_id,a.master_id,b.amount FROM tbl_x_member_sub AS a,tbl_x_member_amount AS b WHERE a.sub_id=? && a.master_id=b.member_id && b.amount >= ? && a.status=?";
                $query = $conn->prepare($msg);
                $query->bind_param("sii", $member_id, $number, $number);
                $query->execute();
                $result = $query->get_result();
                $is_sub = $result->num_rows;

                // check subuser 
                if ($is_sub == 1) {
                    if (isset($_SESSION['sub_member'])) {
                        unset($_SESSION['sub_member']);
                        $_SESSION['sub_member'] = true;
                    }
                    else {
                        $_SESSION['sub_member'] = true;
                    }
                    $data = $result->fetch_array();
                    $master_id = $data["master_id"];
                    $sub_id = $data["sub_id"];
                    $amount = $data["amount"];
                    $query->close();
                    

                    $now = date("Y-m-d H:i:s");
                    $strSQL = "SELECT * FROM tbl_x_member_time WHERE member_id=? && start<=? && stop>=?";
                    $stmt = $conn->prepare($strSQL);
                    $stmt->bind_param("sss", $member_id, $now, $now);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $is_available = $result->num_rows;
                    $stmt->close();

                    if ($is_available == 0) {
                        $k = 1;
                        

                        $msg = "SELECT * FROM tbl_x_member_spacial WHERE member_id=? && start <= ? && stop >= ?";
                        $query = $conn->prepare($msg);
                        $query->bind_param("sss", $master_id, $now, $now);
                        $query->execute();
                        $result = $query->get_result();
                        $is_sp = $result->num_rows;
                        $query->close();

                        if ($is_sp == 1) {
                            $k = 0;
                        }
                        

                        $strSQL = "UPDATE tbl_x_member_amount SET amount='" . ($amount - $k) . "' WHERE member_id =?";
                        $sub_query = $conn->prepare($strSQL);
                        $sub_query->bind_param("s", $master_id);
                        $sub_query->execute();
                        $sub_query->close();
                        //----------------------//
                        $start = date("Y-m-d H:i:s");
                        $stop = date("Y-m-d H:i:s", time() + (60 * 60 * 24 * 1));
                        $card_id = 0;
                        $sql = "INSERT INTO tbl_x_member_time (member_id, card_id, start, stop, create_date) VALUES (?,?,?,?,?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("sisss", $member_id, $card_id, $start, $stop, $start);
                        $stmt->execute();
                        $stmt->close();

                        $refill = 1;
                    }
                }
                // check personal user
                if ($refill == 0) {
                    $_SESSION['personal'] = true;
                    // $_SESSION['sub_member'] = false;

                    $strSQL = "SELECT * FROM tbl_x_member_total WHERE member_id=? && amount >= '1' ";
                    $sub_stmt = $conn->prepare($strSQL);
                    $sub_stmt->bind_param("s", $member_id);
                    $sub_stmt->execute();
                    $result = $sub_stmt->get_result();
                    $is_have = $result->num_rows;
                    $sub_stmt->close();
                    if ($is_have == 1) {
                        
                        $now = date("Y-m-d H:i:s");
                        $msg = "SELECT * FROM tbl_x_member_time WHERE member_id=? && start <= ? && stop >= ?";
                        $query = $conn->prepare($msg);
                        $query->bind_param("sss", $member_id, $now, $now);
                        $query->execute();
                        $result = $query->get_result();
                        $is_available = $result->num_rows;
                        $query->close();
                        if ($is_available == 0) {

                            $strSQL = " UPDATE tbl_x_member_total SET amount=(amount-1) WHERE member_id=? ";
                            $stmt = $conn->prepare($strSQL);
                            $stmt->bind_param("s", $member_id);
                            $stmt->execute();
                            $stmt->close();
                            //----------------------//
                            $start = date("Y-m-d H:i:s");
                            $stop = date("Y-m-d H:i:s", time() + (60 * 60 * 24 * 1));
                            $card_id = -1;
                            $sql = "INSERT INTO tbl_x_member_time (member_id, card_id, start, stop, create_date) VALUES (?,?,?,?,?)";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("sisss", $member_id, $card_id, $start, $stop, $start);
                            $stmt->execute();
                            $stmt->close();
                        }
                    }
                }
            }
        }

        if (!trim($type)) {
            session_destroy();
            header("Location:?section=$_GET[section]");
        }
        mysqli_close($conn);
        return $type;
    }

    public function profile($check_master)
    {
        include('./config/connection.php');
        include('../config/connection.php');
        //-------------------------------------------------------//
        if ($_SESSION["x_member_id"]) {
            $member_id = $_SESSION["x_member_id"];
        }
        $strSQL = "SELECT * FROM tbl_x_member WHERE member_id=?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $member_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $is_have = $result->num_rows;

        if ($is_have == 1) {
            $data = $result->fetch_array();
            $fname = $data["fname"];
            $lname = $data["lname"];
            $stmt->close();
            if (($_GET["status"] != "edit_profile" || $_GET["status"] != "edit_profile" || $_GET["status"] != "edit_profile") && !trim($fname) && !trim($lname)) {
                $profile_display = 0;
                header("Location:?section=$_GET[section]&&status=edit_profile");
            }
            else {
                if (!trim($fname) && !trim($lname)) {
                    $profile_display = 0;
                }
                else {
                    $profile_display = 1;
                }
            }
            if ($profile_display == 1) {
                $now = date("Y-m-d H:i:s");
                if ($check_master == "personal") {

                    $msg = "SELECT * FROM tbl_x_member_time WHERE member_id=? && stop >= ? ORDER BY stop DESC LIMIT 0,1 ";
                    $query = $conn->prepare($msg);
                    $query->bind_param("ss", $member_id, $now);
                    $query->execute();
                    $result = $query->get_result();
                    $is_have = $result->num_rows;
                    if ($is_have == 1) {
                        $data = $result->fetch_array();
                        $stop = $data["stop"];
                        $msg_air_time = "<b><font size=2 face=tahoma color=white>Available Time : $stop </font></b>";
                    }
                    else {

                        $strSQL = "SELECT * FROM tbl_x_member_time WHERE member_id=? ORDER BY stop DESC LIMIT 0,1 ";
                        $stmt = $conn->prepare($strSQL);
                        $stmt->bind_param("s", $member_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $sub_have = $result->num_rows;
                        if ($sub_have == 1) {
                            $data = $result->fetch_array();
                            $stop = $data["stop"];
                            $msg_air_time = "<b><font size=2 face=tahoma color=white>Available Time : $stop </font></b>";
                        }
                        else {
                            $no_day = 0;
                            $msg_air_time = "<b><font size=2 face=tahoma color=white>Available Time : - </font></b>";

                        }

                    }

                    $msg = "SELECT * FROM tbl_x_member_total WHERE member_id=?";
                    $stmt = $conn->prepare($msg);
                    $stmt->bind_param("s", $member_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $is_have = $result->num_rows;
                    if ($is_have == 1) {
                        $total_data = $result->fetch_array();
                        $available = $total_data["amount"];
                        if ($total_data["amount"] >= 1) {
                            $total_msg = "<b><font color=white face=tahoma size=2>Total Available Day : $available days </font></b>";
                        }
                        if ($total_data["amount"] == 0) {
                            $total_msg = "<b><font color=white face=tahoma size=2>Total Available Day : $available days </font></b>";
                        }
                    }
                    if ($is_have == 0) {
                        // $total_msg = "<b><font color=white face=tahoma size=2>Total Available Day : 0 days </font></b>";
                        // $total_msg = "<b><font color=white face=tahoma size=2>Days remaining depends on the Master Account</font></b>";
                        if($_SESSION['sub_member'] == true){
                            $total_msg = "<b><font color=white face=tahoma size=2> Days remaining depends on the Master Account </font></b>";
                        }else{
                            $total_msg = "<b><font color=white face=tahoma size=2> Total Available Day : - days </font></b>";
                        }
                    }
                    $query->close();
                    $stmt->close();
                    $text = "
							<table align=center width=90% cellpadding=0 cellspacing=0 border=0>
								<tr height=25>
									<td width=65% align=left> $msg_air_time </td>
								</tr>
								<tr height=25>
									<td align=left>$total_msg </td>
								</tr>
							</table>";

                }
                if ($check_master == "master") {

                    $strSQL = "SELECT * FROM tbl_x_member_amount WHERE member_id=?";
                    $query = $conn->prepare($strSQL);
                    $query->bind_param("s", $member_id);
                    $query->execute();
                    $result = $query->get_result();
                    $is_have = $result->num_rows;
                    if ($is_have == 1) {
                        $data = $result->fetch_array();
                        $amount = $data["amount"];
                        $msg_air_time = " <b><font size=2 face=tahoma color=white>Available Amount : $amount Day(s)</font></b>";
                        

                        $msg = "SELECT * FROM tbl_x_member_spacial WHERE member_id=? && start <= ? && stop >= ? ";
                        $stmt = $conn->prepare($msg);
                        $stmt->bind_param("sss", $member_id, $now, $now);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $is_sp = $result->num_rows;
                        if ($is_sp == 1) {
                            $data = $result->fetch_array();
                            $start = $data["start"];
                            $stop = $data["stop"];
                            $max_amount = $data["amount"];
                            $stmt->close();

                            $strSQL = "SELECT sub_id FROM tbl_x_member_sub WHERE master_id=?";
                            $sub_stmt = $conn->prepare($strSQL);
                            $sub_stmt->bind_param("s", $member_id);
                            $sub_stmt->execute();
                            $result = $sub_stmt->get_result();
                            $all_sub = $result->num_rows;
                            $sub_stmt->close();
                            $msg_air_time = "<b><font color=green face=tahoma size=2> Available From : $start <br> Available Until : $stop <br>
                                Sub Account Amount : $all_sub / $max_amount </font></b>";
                        }
                       

                        $msg = "SELECT * FROM tbl_x_member_spacial WHERE member_id=? && ( start > ? || stop < ?) ";
                        $sub_query = $conn->prepare($msg);
                        $sub_query->bind_param("sss", $member_id, $now, $now);
                        $sub_query->execute();
                        $result = $sub_query->get_result();
                        $is_sp = $result->num_rows;
                        if ($is_sp == 1) {
                            $data = $result->fetch_array();
                            $start = $data["start"];
                            $stop = $data["stop"];
                            $max_amount = $data["amount"];
                            $sub_query->close();

                            $msg_query = "SELECT sub_id FROM tbl_x_member_sub WHERE master_id=? ";
                            $stmt_query = $conn->prepare($msg_query);
                            $stmt_query->bind_param("s", $member_id);
                            $stmt_query->execute();
                            $result = $stmt_query->get_result();
                            $all_sub = $result->num_rows;
                            $stmt_query->close();
                            $msg_air_time = "<b><font color=white face=tahoma size=2> Available From : $start <br> Available Until : $stop <br>
                                Sub Account Amount : $all_sub / $max_amount </font></b>";
                        }
                    }
                    $text = "
							<table align=center width=90% cellpadding=0 cellspacing=0 border=0>
								<tr height=25>
									<td width=40% align=left> $msg_air_time </td>
								</tr>
							</table>
						";
                }

            }
        }
        //-------------------------------------------------------//
        mysqli_close($conn);
        return $text;
    }

}
?>