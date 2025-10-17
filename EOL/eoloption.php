<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');
main_layout();

function sub_coporate($member_id) {
    include('../config/connection.php');
    $id = $conn->real_escape_string($member_id);  
    
    $strSQL = "SELECT * FROM tbl_x_member_sub WHERE sub_id=?"; //=> ดึง sub_id from table tbl_x_member_sub 
    $stmt = $conn->prepare($strSQL);
	$stmt->bind_param("s", $id);
	$stmt->execute();
	$result = $stmt->get_result();
    $datasub = $result->fetch_array();
    $stmt->close();

    if ($datasub[0] != "") {
        // ถ้ามีข้อมูล
        $_SESSION["coporate"] = true;
    } else {
        // ถ้าไม่มีข้อมูล
        $_SESSION["coporate"] = false;
    }

    $now = date("Y-m-d H:i:s");
    
    $usable = check_time_member($id,$now,$now);

    if ($usable == 1) {
        $_SESSION["usable"] = true;
    } else {
        $_SESSION["usable"] = false;
    }
    mysqli_close($conn);
    
}
function main_layout() {
    echo "<table align=center width=100% cellpadding=0 cellspacing=0 border=0 style='margin-left:7px;'>
		    <tr><td>";
            
    if ($_SESSION["x_member_id"]) {
        echo sub_coporate($_SESSION["x_member_id"]);
        main_page();
    }
   
    echo "
		    </td></tr>
		  </table>";
}

function main_page() {
    include('../config/connection.php');
 
    $check_master = check_master();
    system_menu($check_master);
    $is_admin_teoc = check_admin_teoc();
    
    //-----------------------------------------------------------------------------//
    if ($_SESSION["x_member_id"] && !$_GET["status"]) {
        if ($check_master === "master") {
            if ($_GET["action"] !== "report") {
                corporate_main();
            }
            if ($_GET["action"] === "report") {
                    corporate_focus_profile();
                    if ($_GET["action"] === "report" && $_GET["report_section"] === "academic") {
                        if (!$_GET["result_id"]) {
                            report_a_layout();
                            report_a_result_list();
                        }
                        if ($_GET["result_id"]) {
                            report_a_result_detail();
                        }
                    }
                   
                    if ($_GET["action"] === "report" && $_GET["report_section"] === "standard") {
                        if (!$_GET["result_id"]) {
                            report_stest_list();
                        }
                        if ($_GET["result_id"]) {
                            report_s_result_detail();
                        }
                    }

                    if ($_GET["action"] === "report" && $_GET["report_section"] === "contest") {
                        if (!$_GET["result_id"]) {
                            report_list_contest();
                        }
                        if ($_GET["result_id"]) {
                            report_contest_result_detail();
                        }
                    }

                    if (!$_GET["report_section"]) {
                        report_select_section();
                    }
            }
        }
        if ($check_master === "personal") {
            if (trim($_SESSION["x_member_id"])) {
               $member_id = $_SESSION["x_member_id"];
            }
            $now = date("Y-m-d H:i:s");
            $usable = check_time_member($member_id,$now,$now);
            if ($usable == 0) {
                //-------------- Free Test -------------//
                if (!$_GET["action"]) {
                    expired_test();
                }
                if ($_GET["action"] === "report" && !$_GET["report_section"]) {
                    report_select_section();
                }
                if ($_GET["action"] === "report" && $_GET["report_section"] === "academic") {
                    if (!$_GET["result_id"]) {
                        user_focus_profile();
                        report_a_layout();
                        report_a_result_list();
                    }
                    if ($_GET["result_id"]) {
                        report_a_result_detail();
                    }
                }
                
                if ($_GET["action"] === "report" && $_GET["report_section"] === "standard") {
                    if (!$_GET["result_id"]) {
                        user_focus_profile();
                        report_stest_list();
                    }
                    if ($_GET["result_id"]) {
                        report_s_result_detail();
                    }
                }
                if ($_GET["action"] === "report" && $_GET["report_section"] === "contest"){
                    if (!$_GET["result_id"]) {
                        user_focus_profile();
                        report_list_contest();
                    }
                    if ($_GET["result_id"]) {
                        report_contest_result_detail();
                    }
                }
                
            }
            if ($usable == 1) {
                //-------------- Cost Test ---------------//
                if (!$_GET["action"]) {
                    include('cost_test.php');
                }
                if ($_GET["action"] === "academic") {
                    include('evaluaton_test.php');
                }
                if ($_GET["action"] === "eolcontest") {
                    include('e_testmain.php');
                }
                if ($_GET["action"] === "report" && !$_GET["report_section"]) {
                    report_select_section();
                }
                if ($_GET["action"] === "report" && $_GET["report_section"] === "academic") {
                    if (!$_GET["result_id"]) {
                        user_focus_profile();
                        report_a_layout();
                        report_a_result_list();
                    }
                    if ($_GET["result_id"]) {
                        report_a_result_detail();
                    }
                }
                if ($_GET["action"] === "report" && $_GET["report_section"] === "standard") {
                    if (!$_GET["result_id"]) {
                        user_focus_profile();
                        report_stest_list();
                    }
                    if ($_GET["result_id"]) {
                        report_s_result_detail();
                    }
                }
                if ($_GET["action"] === "report" && $_GET["report_section"] === "contest") {
                    if (!$_GET["result_id"]) {
                        user_focus_profile();
                        report_list_contest();
                    }
                    if ($_GET["result_id"]) {
                        report_contest_result_detail();
                    }
                }
            }
        }
        // ---------- master account expired or amount of day = 0 ----------- //
        if ($check_master === "expired") {
            if (!$_GET["action"]) {
                expired_test();
            }
            if ($_GET["action"] === "report" && !$_GET["report_section"]) {
                report_select_section();
            }
            if ($_GET["action"] === "report" && $_GET["report_section"] === "academic") {
                if (!$_GET["result_id"]) {
                    user_focus_profile();
                    report_a_layout();
                    report_a_result_list();
                }
                if ($_GET["result_id"]) {
                    report_a_result_detail();
                }
            }
            
            if ($_GET["action"] === "report" && $_GET["report_section"] === "standard") {
                if (!$_GET["result_id"]) {
                    user_focus_profile();
                    report_stest_list();
                }
                if ($_GET["result_id"]) {
                    report_s_result_detail();
                }
            }
            if ($_GET["action"] === "report" && $_GET["report_section"] === "contest"){
                if (!$_GET["result_id"]) {
                    user_focus_profile();
                    report_list_contest();
                }
                if ($_GET["result_id"]) {
                    report_contest_result_detail();
                }
            }
        }
        // กรณีที่ต้องการให้ครูหรืออาจารย์ดูผลการแข่งขันได้อย่างเดียว
        if($check_master === "master" && $is_admin_teoc == '2'){
            header("Location: eoltest_monitor.php");
        }
    }
    //-----------------------------------------------------------------------------//
    if ($_SESSION['x_member_id'] && $_SESSION['x_member_admin'] && $_GET["status"] === "manage_admin" && $check_master === "master") {
        include('manage_user_corporate.php');
    }
    if ($_SESSION['x_member_id'] && $_GET["status"] === "statistics" && $check_master === "master") {
        include('statistics.php');
    }
    if ($_SESSION["x_member_id"] && $_GET["status"] === "e-test" && $check_master === "master") {
        include('e_test.php');
    }
    if ($_SESSION["x_member_id"] && $_GET["status"] === "edit_profile") {
        include('edit_profile.php');
    }
    //-----------------------------------------------------------------------------//
    if ($_SESSION["x_member_id"] && $_GET["status"] === "refill") {
        refill_main($check_master);
    }
    
}

function check_master() {
    include('../config/connection.php');
    if ($_SESSION["x_member_id"]) {
        $member_id = $conn->real_escape_string($_SESSION["x_member_id"]);
    }
    $type = "";
    $strSQL = "SELECT * FROM tbl_x_member_amount WHERE member_id=?"; 
    $stmt = $conn->prepare($strSQL);
	$stmt->bind_param("s", $member_id);
	$stmt->execute();
	$result = $stmt->get_result();
    $is_ok = $result->num_rows;
    $stmt->close();
    
    if ($is_ok == 1) {
        $type = "master";
    }
    if ($is_ok == 0) {

        $strSQL = "SELECT * FROM tbl_x_member WHERE member_id=?"; //=> ดึง sub_id from table tbl_x_member_sub 
        $query = $conn->prepare($strSQL);
        $query->bind_param("s", $member_id);
        $query->execute();
        $result = $query->get_result();
        $is_member = $result->num_rows;
        $query->close();

        if ($is_member == 1) {
            $type = "personal";
            $refill = 0;
            $number = 1;
            //-------------------------------------------------------------//
            
            $msg = "SELECT a.sub_id,a.master_id,b.amount FROM tbl_x_member_sub AS a,tbl_x_member_amount AS b WHERE a.sub_id=? && a.master_id=b.member_id && b.amount >= ? && a.status= ?";
            $query = $conn->prepare($msg);
            $query->bind_param("sii", $member_id,$number,$number);
            $query->execute();
            $result = $query->get_result();
            $is_sub = $result->num_rows;

            if ($is_sub == 1) {
                $data = $result->fetch_array();
                $master_id = $data["master_id"];
                $sub_id = $data["sub_id"];
                $amount = $data["amount"];
                $query->close();
                //------------- table tbl_x_member_time -------------------//
                if($amount == 0){
                    $type = "expired";
                    $refill = 1;
                }else {
                    $now = date("Y-m-d H:i:s");
                    $is_available = check_time_member($member_id,$now,$now);

                    if ($is_available == 0) { // ถ้าไม่มีข้อมูล //
                        $k = 1;
                    
                        //-------------- table tbl_x_member_spacial -------------//
                        
                        $msg = "SELECT * FROM tbl_x_member_spacial  WHERE member_id=? && start <= ? &&  stop >= ?";
                        $stmt = $conn->prepare($msg);
                        $stmt->bind_param("sss", $master_id,$now,$now);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $is_sp = $result->num_rows;
                        $stmt->close();

                        if ($is_sp == 1) { // ถ้ามีข้อมูล //
                            $k = 0;
                        }
                        
                        //------------ table tbl_x_member_amount ----------------//
                        
                        $remaining_time = $amount - $k;
                        $strSQL = "UPDATE tbl_x_member_amount SET amount=? WHERE member_id =?";
                        $sub_query = $conn->prepare($strSQL);
                        $sub_query->bind_param("ss", $remaining_time, $master_id);
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
            }

            if ($refill == 0) {

                $strSQL = "SELECT * FROM tbl_x_member_total WHERE member_id=? && amount >= '1' ";
                $sub_stmt = $conn->prepare($strSQL);
                $sub_stmt->bind_param("s", $member_id);
                $sub_stmt->execute();
                $result = $sub_stmt->get_result();       
                $is_have = $result->num_rows;
                $sub_stmt->close();
                
                if ($is_have == 1) {
                    
                    $now = date("Y-m-d H:i:s");
                    $is_available = check_time_member($member_id,$now,$now);

                    if ($is_available == 0) {
                        
                        $strSQL = " UPDATE tbl_x_member_total SET amount=(amount-1) WHERE member_id=? ";
                        $stmt = $conn->prepare($strSQL);
                        $stmt->bind_param("s", $member_id);
                        $stmt->execute();
                        $stmt->close();
                        //----------------------//
                        $start = date("Y-m-d H:i:s");
                        $stop = date("Y-m-d H:i:s", time() + (60 * 60 * 24 * 1));
                        //----------------------//
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


function system_menu($check_master) {
    
    $_page = ($_GET['action'] === "eolcontest") ? "e-test" : $_GET['status'];
    $_lineColor['manage_admin'] = "#2a3f54";
    $_lineColor['edit_profile'] = "#3BB9FF";
    $_lineColor['refill'] = "#d5e17f";
    $_lineColor['statistics'] = "#aeafb0";
    $_lineColor['e-test'] = "#ec5c27";
    $_lineColor['eol_system'] = "#f7941d";
    ?>

<!----------------------- แทบเมนู ------------------------->

<div class="tabbed"
    style="border-bottom: 4px solid <?= ($_page <> "") ? $_lineColor[$_page] : $_lineColor['eol_system']; ?> !important;">
    <ul>
        <?php if($_SESSION['x_member_admin']){ ?>
        <a href="?section=<?= $_GET['section']; ?>&&status=manage_admin">
            <li class="<?= ($_GET['status'] === 'manage_admin') ? 'active' : "" ; ?>" id="tab_admin">Admin</li>
        </a>
        <?php } ?>

        <a href="?section=<?= $_GET['section']; ?>&&status=edit_profile">
            <li class="<?= ($_GET['status'] === 'edit_profile') ? 'active' : "" ; ?>" id="tab_profile">Profile</li>
        </a>
        <?php
            if ($check_master !== "master") {
        ?>
        <a href="?section=<?= $_GET['section']; ?>&&status=refill">
            <li class="<?= ($_GET['status'] === 'refill') ? 'active' : "" ; ?>" id="tab_refill">Refill</li>
        </a>
        <?php
            }
        ?>
        <?php
            if ($check_master === "master") {
        ?>

        <a href="?section=<?= $_GET['section']; ?>&&status=statistics&&action=view_group">
            <li class="<?= ($_GET['status'] === 'statistics') ? 'active' : "" ; ?>" id="tab_statistics">Statistics</li>
        </a>
        <a href="?section=<?= $_GET['section']; ?>&&status=e-test">
            <li class="<?= ($_GET['status'] === 'e-test') ? 'active' : "" ; ?>" id="tab_corporate">Add Test & Lesson
            </li>
        </a>

        <?php
            } elseif ($_SESSION["coporate"] == true && $_SESSION["usable"] == true && $check_master != "expired") {
        ?>
        <a href="../corporate/ecop.php">
            <li class="<?= (($_GET['status'] === 'eolcontest') || ($_GET['action']===" eolcontest" )) ? "active" : "" ;
                ?>" id="tab_corporate">Multi - Learning</li>
        </a>
        <?php
            }
        ?>
        <a href="?section=<?= $_GET['section']; ?>&&">
            <li class="<?= ((trim($_GET['status']) == "") && ($_GET['action'] <> " eolcontest")) ? "active" : "" ; ?>"
                id="tab_eolsystem">SYSTEM Page</li>
        </a>

    </ul>
</div>
<?php

}

function check_admin_teoc(){
    include('../config/connection.php');
    $status = 2;
    $strSQL = "SELECT is_admin FROM tbl_x_member WHERE member_id=? && is_admin = ? ";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("si", $_SESSION["x_member_id"],$status);
    $stmt->execute();
    $result = $stmt->get_result();      
    $data = $result->fetch_array();
    $is_have = $data['is_admin'];
    $stmt->close();
    return $is_have;
}

function corporate_main() {

    include('../config/connection.php');
    if (!$_SESSION["group_id"]) {
        $_SESSION["group_id"] = 0;
    }
    
    // ====== fn for form view sub member in group ========= //
    if ($_GET["action"] === "view_group" && $_POST["group_id"] >= 0 && $_POST["group_id"] - $_POST["group_id"] == 0) {
        $_SESSION["group_id"] = $conn->real_escape_string($_POST["group_id"]);
        if (!$_GET["page"]) {
            $_GET["page"] = '1';
        }
        
        header("Location: ?section=$_GET[section]&&page=$_GET[page]");
    }
    if ($_GET["action"] === "set_status" && $_GET["member_id"] >= 1) {
      
        $sub_id = $conn->real_escape_string($_GET['member_id']);
        $strSQL = "SELECT * FROM tbl_x_member_sub WHERE master_id = ? && sub_id = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("ss", $_SESSION['x_member_id'], $sub_id);
        $stmt->execute();
        $result = $stmt->get_result();       
        $is_sub = $result->num_rows;
        
        if ($is_sub == 1) {
            $data = $result->fetch_array();
            $status = $data["status"];
            if ($status == 0) {
                $set = 1;
            } 
            if ($status == 1) {
                $set = 0;
            }
            $msg = "UPDATE tbl_x_member_sub SET status = ? WHERE master_id = ? && sub_id = ?";
            $query = $conn->prepare($msg);
            $query->bind_param("iss", $set, $_SESSION['x_member_id'], $sub_id);
            $query->execute();
            $query->close();
        }
        $stmt->close();
        header("Location: ?section=$_GET[section]&&page=$_GET[page]");
    }
    //-----------------------------------------------------------------------------------------------//
    if ($_GET["action"] === "left_group" && $_GET["member_id"] >= 1) {

        $sub_id = $conn->real_escape_string($_GET['member_id']);
        $is_sub = get_sub_member($sub_id);
        
        if ($is_sub == 1) {
            $type_id = 0;
            $msg = "UPDATE tbl_x_member_sub SET type_id = ? WHERE master_id = ? && sub_id = ?";
            $query = $conn->prepare($msg);
            $query->bind_param("iss", $type_id, $_SESSION['x_member_id'], $sub_id);
            $query->execute();
            $query->close();
        }
        header("Location: ?section=$_GET[section]&&page=$_GET[page]");
    }
    //-----------------------------------------------------------------------------------------------//
    if ($_GET["action"] === "delete_sub" && $_GET["member_id"] >= 1) {
        
        $sub_id = $conn->real_escape_string($_GET['member_id']);
        $is_sub = get_sub_member($sub_id);

        if ($is_sub == 1) {
            $smg = "DELETE FROM tbl_x_member_sub WHERE master_id = ? && sub_id = ?";
            $query = $conn->prepare($smg);
            $query->bind_param("ss", $_SESSION['x_member_id'], $sub_id);
            $query->execute();
            $query->close();
        }
        header("Location: ?section=$_GET[section]&&page=$_GET[page]");
    }
    //-----------------------------------------------------------------------------------------------//
    if ($_GET["action"] === "all_limit" && $_POST["member_id"]) {
        
        $member_id = $_POST["member_id"];
        if ($member_id) {
            sort($member_id);
            $count = count($member_id);
        }
        if ($count >= 1) {
            $status = 0;
            for ($i = 0; $i < $count; $i++) {
                $id = $conn->real_escape_string($member_id[$i]);
                $strSQL = "UPDATE tbl_x_member_sub SET status = ? WHERE master_id = ? && sub_id = ?";
                $stmt = $conn->prepare($strSQL);
                $stmt->bind_param("iss", $status, $_SESSION['x_member_id'], $id);
                $stmt->execute();
                $stmt->close();
            }
        }
        header("Location: ?section=$_GET[section]&&page=$_GET[page]");
    }
    //-----------------------------------------------------------------------------------------------//
    if ($_GET["action"] === "all_unlimit" && $_POST["member_id"]) {
        
        $member_id = $_POST["member_id"];
        if ($member_id) {
            sort($member_id);
            $count = count($member_id);
        }
        if ($count >= 1) {
            $status = 1;
            for ($i = 0; $i < $count; $i++) {
                $id = $conn->real_escape_string($member_id[$i]);
                $strSQL = "UPDATE tbl_x_member_sub SET status = ? WHERE master_id = ? && sub_id = ?";
                $stmt = $conn->prepare($strSQL);
                $stmt->bind_param("iss", $status, $_SESSION['x_member_id'], $id);
                $stmt->execute();
                $stmt->close();
            }
        }
        header("Location: ?section=$_GET[section]&&page=$_GET[page]");
    }

    if ($_GET["action"] === "all_delete" && $_POST["member_id"]) {
        $member_id = $_POST["member_id"];
        if ($member_id) {
            sort($member_id);
            $count = count($member_id);
        }
        if ($count >= 1) {
            for ($i = 0; $i < $count; $i++) {
                $strSQL = "DELETE FROM tbl_x_member_sub WHERE master_id = ? && sub_id = ?";
                $query = $conn->prepare($strSQL);
                $query->bind_param("ss", $_SESSION['x_member_id'], $member_id[$i]);
                $query->execute();
                $query->close();
            }
        }
        header("Location: ?section=$_GET[section]&&page=$_GET[page]");
    }
    if ($_GET["action"] === "all_move" && $_POST["member_id"]) {

        $member_id = $_POST["member_id"];
        if ($member_id) {
            sort($member_id);
            $count = count($member_id);
        }

        if ($count >= 1 && $_POST["type_id"] == 0) {
            $type_id = 0;
            for ($i = 0; $i < $count; $i++) {
                $strSQL = "UPDATE tbl_x_member_sub SET type_id = ? WHERE master_id = ? && sub_id = ?";
                $stmt = $conn->prepare($strSQL);
                $stmt->bind_param("iss", $type_id, $_SESSION['x_member_id'], $member_id[$i]);
                $stmt->execute();
                $stmt->close();
            }
        } else if ($count >= 1) {
            $type_id = $conn->real_escape_string($_POST['type_id']);
            $strSQL = "SELECT * FROM tbl_x_member_type  WHERE member_id = ? && type_id = ?";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("ss", $_SESSION['x_member_id'], $type_id);
            $stmt->execute();
            $result = $stmt->get_result();       
            $is_group = $result->num_rows;
            $stmt->close();

            if ($is_group == 1) {
                for ($i = 0; $i < $count; $i++) {
                    $strSQL = "UPDATE tbl_x_member_sub SET type_id = ? WHERE master_id = ? && sub_id = ?";
                    $query = $conn->prepare($strSQL);
                    $query->bind_param("sss", $type_id, $_SESSION['x_member_id'], $member_id[$i]);
                    $query->execute();
                    $query->close();
                }
            }
        }
        header("Location: ?section=$_GET[section]&&page=$_GET[page]");
    }
    // ==================== add group ======================= //
    if ($_GET["action"] === "add_group" && trim($_POST["group_name"])) {
        $group_name = $conn->real_escape_string(trim($_POST["group_name"]));
        $strSQL = "INSERT INTO tbl_x_member_type (member_id, name) VALUES (?,?)";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("ss", $_SESSION['x_member_id'],$group_name);
        $stmt->execute();
        $stmt->close();
        
        header("Location: ?section=$_GET[section]&&");
    }
    //  ------------ rename group ---------------------------//
    if ($_GET["action"] === "re_group" && trim($_POST["rename"])) {
        $group_name = $conn->real_escape_string(trim($_POST['rename']));
        $id_rename = $conn->real_escape_string(trim($_POST['idrename']));
        $strSQL = "UPDATE tbl_x_member_type SET name = ? WHERE member_id = ? && type_id = ?";
        $query = $conn->prepare($strSQL);
        $query->bind_param("sss", $group_name, $_SESSION['x_member_id'], $id_rename);
        $query->execute();
        $query->close();

        header("Location: ?section=$_GET[section]&&");
    }
    //  ------------ delete group ---------------------------//

    if ($_GET["action"] === "delete_group") {
        if ($_POST["group_id"] >= 1) {
            $group_id = $conn->real_escape_string(trim($_POST["group_id"]));
            $type_id = 0;
            
            $strSQL = "UPDATE tbl_x_member_sub SET type_id = ? WHERE master_id = ? && type_id = ?";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("iss", $type_id, $_SESSION['x_member_id'], $group_id);
            $stmt->execute();
            $stmt->close();
            
            $smg = "DELETE FROM tbl_x_member_type WHERE member_id = ? && type_id = ?";
            $query = $conn->prepare($smg);
            $query->bind_param("ss", $_SESSION['x_member_id'], $group_id);
            $query->execute();
            $query->close();
        }
        header("Location: ?section=$_GET[section]&&");
    }
   
   
    if ($_SESSION["group_id"] >= 0) {
        $g_id = $conn->real_escape_string(trim($_SESSION["group_id"]));
        $ex_event = " && tbl_x_member_sub.type_id='$g_id' ";
    }
   
    $strSQL = "SELECT * FROM tbl_x_member_sub , tbl_x_member WHERE tbl_x_member_sub.master_id = ? && tbl_x_member_sub.sub_id=tbl_x_member.member_id $ex_event ORDER BY tbl_x_member.user";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $_SESSION['x_member_id']);
    $stmt->execute();
    $result = $stmt->get_result();       
    $num = $result->num_rows;
    $stmt->close();

    $all_list = $num;
    if ($num >= 1) {
        //---------------------------- Set Page --------------------------------//
        $all = $num;
        // -------------- แบบใหม่ ------------------- //
        $per_page = 20;
        if ($per_page != $all) {
            $all_page = $num / $per_page;
            $arr = explode(".", $all_page);
            if ($arr[1] >= 1) {
                $all_page = $arr[0] + 1;
            } else {
                $all_page = $arr[0];
            }
        }else{
            $all_page = 1;
        }
    }
    	
    //----------- FORM VIEW MANAGE SUB ACCOUNT ------------- //

    echo "
		<table align=center width=95% cellpadding=5 cellspacing=0 border=0>
			<tr height=30>
				<td align=center width=7%><font size=2 face=tahoma><b>Group : </b></font></td>
				<form id='view_form' method=post action='?section=$_GET[section]&&action=view_group' >
				<td align=left width=65%>
					<select name='group_id' id='group_id' style='height: 28px;'>";
    //------------------------------------------------------------------//
    $type_id = 0;
    $each_group = get_group_sub_member($type_id);
    
    $type_name = "None Group&nbsp;[ " . $each_group . " ]";
    echo "<option value='0'>$type_name</option>";
    
    $msg = "SELECT * FROM tbl_x_member_type WHERE member_id = ? ORDER BY name";
    $query = $conn->prepare($msg);
    $query->bind_param("s", $_SESSION['x_member_id']);
    $query->execute();
    $result = $query->get_result();
    $rows = $result->num_rows; 

    $j = 1;
    while($row = $result->fetch_assoc()) {
        $temp_id[$j] = $row['type_id'];
        $temp_name[$j] = $row['name'];
        $j++;  
    }

    if ($rows >= 1) {
        for ($i = 1; $i <= $rows; $i++) {
            $type_name = $conn->real_escape_string(trim($temp_name[$i]));
            $type_id = $conn->real_escape_string(trim($temp_id[$i]));
           
            $each_group = get_group_sub_member($type_id);
            $type_name = $type_name . "&nbsp;[ " . $each_group . " ]";
            if ($type_id == $_SESSION["group_id"]) {
                $select = "selected";
            } else {
                $select = "";
            }
            echo "<option value='$type_id' $select>$type_name </option>";
        }
    }
    $query->close();
    echo "		</select>
				<input type='submit' value='View' class='btn-view'>
				<input type='button' value='Edit' class='modalInput btn-edit' rel='#prompt1' onclick='rename()'>
				<input type='button' value='Delete This Group' class='btn-delete-group' 
						onclick=\"javascript:
								if(confirm('Do you want to delete this group ?'))
								{	
									if(confirm('Are you sure ? If you delete this group the member in this group will be None Group.'))
									{	
											document.getElementById('view_form').action='?section=$_GET[section]&&action=delete_group';
											document.getElementById('view_form').submit();
									}
								}
								\">
			</td>
			</form>
			<form id='add_form' method=post action='?section=$_GET[section]&&action=add_group' >
			    <td align=right width=20%><input type='text' name='group_name' size=20 placeholder='&nbsp;Name Group' class='enter-name-group' required></td>
			    <td align=left width=15%>
				    <input type='submit' value='Create New Group' class='btn-create-group' 
						onclick=\"javascript:
								if(confirm('Do you want to create new group ?'))
								{	document.getElementById('add_form').submit();	}
								\">
			    </td>
			</form>
		</tr>
	</table>
	<br>";
    if ($num >= 1) {
        $amount = 20;
        if ($_GET["page"] && ($_GET["page"] - $_GET["page"] == 0 && $_GET["page"] >= 1)) {
            $page = $_GET["page"];
        } else {
            $page = 1;
        }
        $start = ($page - 1) * $amount;
        $limit = " limit $start,$amount";
       
        $strSQL = "SELECT * FROM tbl_x_member_sub, tbl_x_member  WHERE tbl_x_member_sub.master_id = ? && tbl_x_member_sub.sub_id = tbl_x_member.member_id $ex_event ORDER BY tbl_x_member.member_id $limit";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $_SESSION['x_member_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $num = $result->num_rows; 
        $j = 1;
        while($data = $result->fetch_assoc()) {
            $temp_member_id[$j] = $data['member_id'];
            $temp_user[$j] = $data['user'];
            $temp_pass[$j] = $data['pass'];
            $temp_fname[$j] = $data['fname'];
            $temp_lname[$j] = $data['lname'];
            $temp_status[$j] = $data['status'];
            $j++;
        }
        $stmt->close();
        
        //---------------------------- Set Page --------------------------------//
        echo "	<table align=center width=90% cellpadding=0 cellspacing=2 border=0  class='noborder table-sub-member table' >
                    <form id='member_list' name='member_list' method=post >
                        <tr height=55>
                            <td width=4% bgcolor='#FAAC58' align=center >
                                <div onclick=\"javascript:select_all();\" style='cursor:pointer;'><font size=2 face=tahoma color=white title='Select All'><b>All</b></font></div>
                                <input type=hidden id='all_status' value='select'>
                            </td>
                            <td width=24% bgcolor='#676868' align=center><font size=2 face=tahoma color=white><b>First name - Last name</b></font></td>
                            <td width=13% bgcolor='#676868' align=center><font size=2 face=tahoma color=white><b>Username</b></font></td>
                            <td width=13% bgcolor='#676868' align=center><font size=2 face=tahoma color=white><b>Password</b></font></td>
                            <td width=16% bgcolor='#676868' align=center><font size=2 face=tahoma color=white><b>Oprerating time</b></font></td>
                            <td width=30% bgcolor='#676868' align=center color=white><font size=2 face=tahoma color=white><b>Management</b></font></td>
                        </tr>";
                       
        for ($i = 1; $i <= $num; $i++) {
            $htxt = NULL;
            $hour = NULL;
            $splittime1 = NULL;
            $splittime2 = NULL;
            $stop_msg = "";
            if (trim($temp_fname[$i]) && trim($temp_lname[$i])) {
                $is_mem = "true";
                $fname = trim($temp_fname[$i]);
                $lname = trim($temp_lname[$i]);
            } else {
                $is_mem = "false";
                $msg_name = "<div align=center><font color=red face=tahoma size=2> - </font></div>";
            }
            $member_id = $temp_member_id[$i];
            $user = $temp_user[$i];
            $pass = $temp_pass[$i];
            $status = $temp_status[$i];
            $day = date("Y-m-d");
            $enddate = date("Y-m-d H:i:s", strtotime($day));

            $smg = "SELECT * FROM tbl_x_log_member WHERE member_id = ? && logdate >= ? ORDER BY logdate DESC";
            $query = $conn->prepare($smg);
            $query->bind_param("ss", $member_id,$enddate);
            $query->execute();
            $result = $query->get_result();
            $is_have = $result->num_rows; 
            
            if ($is_have >= 1) {
                $timediff = array();
                $t = 0;
                while ($sub_data = $result->fetch_array()) {
                    $splittime1 = explode(" ", $sub_data["logdate"]);
                    $splittime2 = explode(" ", $sub_data["outdate"]);
                    $timediff[$t] = diff2time($splittime1[1], $splittime2[1]);
                    $lastime = $sub_data["logdate"];
                    $t++;
                }
                $hour = floor(array_sum($timediff) / 60);
                if ($hour > 0) {
                    $htxt = $hour . " ชั่วโมง ";
                }
                $stop_msg = "<font color=green title='$lastime'> $htxt " . floor(array_sum($timediff) % 60) . ' นาที </font>';
                
            } else {
                            
                $strSQL = "SELECT * FROM tbl_x_log_member WHERE member_id = ? ORDER BY logdate DESC LIMIT 0,1";
                $sub_query = $conn->prepare($strSQL);
                $sub_query->bind_param("s", $member_id);
                $sub_query->execute();
                $result = $sub_query->get_result();
                $is_have = $result->num_rows; 

                if ($is_have == 1) {
                    $sub_data = $result->fetch_array();
                    $lastime = $sub_data["logdate"];
                    $stop_msg = "<font color=red title='เข้าใช้ครั่งล่าสุดเมื่อ " . $lastime . "'> " . $lastime . "</font>";
                } else {
                    $stop_msg = "<font color='red'> - </font>";
                }
                $sub_query->close();
            }
            $query->close();
           
            $list_num = $i + (($page - 1) * $amount);
            if ($is_mem == "true") {
                $msg_name = "<table align=center width=100% cellpadding=0 cellspacing=0 border=0 >
                                    <tr class='line_name'>
                                        <td align=left width=50%>
                                            &nbsp;" . $fname . "&nbsp;
                                        </td>
                                        <td align=left width=50%>
                                            &nbsp;" . $lname . "&nbsp;
                                        </td>
                                    </tr>
                             </table>";
            }
            if ($i % 2 == 0) {
                $color = "#f0f0f0";
            } else {
                $color = "#f7f7f7";
            }
            if ($status == 1) {
                $img_status = "unlimit.png";
                $img_title = "Allow this Sub Account get Available Date from Master Account  - Click to Change as Limited";
            }
            if ($status == 0) {
                $img_status = "limit.png";
                $img_title = "Not allow this Sub Account get Available Date from Master Account  - Click to Change as Unlimited";
            }
           
            // ============ menu management => system page for admin ============= //
            
            echo "
                 <tr height=28 class='line_hover'>
                     <td bgcolor='#FAAC58' align=center>
                         <input type='checkbox' id='member_id[$i]' name='member_id[$i]' value='$member_id' title='[$list_num]' >
                     </td>
                     <td bgcolor='$color' align=left> <font face=tahoma size=2>$msg_name</font></td>
                     <td bgcolor='$color' align=center><font size=2 face=tahoma id='userdata_$member_id'><b>$user</b></font></td>
                     <td bgcolor='$color' align=center><font size=2 face=tahoma ><b>$pass</b></font></td>
                     <td bgcolor='$color' align=center><font size=2 face=tahoma >$stop_msg</font></td>
                     <td bgcolor='white' align=center>
                         <img src='../images/icon/$img_status' border=0 style='width:7%;cursor:pointer;margin-right:15px;' 
                             title='$img_title'
                             onclick=\"javascript:
                                         if(confirm('Do you want to change the member status ?'))
                                         {	window.location='?section=$_GET[section]&&action=set_status&&member_id=$member_id&&page=$_GET[page]';	}
                                     \"
                         >
                         <a target=_blank href='?section=$_GET[section]&&action=report&&member_id=$member_id' title='View Personal Report'><img src='../images/icon/report.png' border=0  style='width:8%; margin-right:15px;'></a>
                         <img src='../images/icon/move.png' border=0 style='width:7%;cursor:pointer;margin-right:15px;'
                              title='Move current group'
                             onclick=\"javascript:
                                         if(confirm('Do you want to bring this member out of this group to none group ?'))
                                         {	window.location='?section=$_GET[section]&&action=left_group&&member_id=$member_id&&page=$_GET[page]';	}
                                     \"
                         >
                         <button class='modalInput' rel='#prompt2' type='botton' style='width:20px;background:none; border:none;margin-right:20px;' id='$member_id' onclick='edit_subAcc(this)'><img src='../images/icon/edit.png' border=0 style='width:20px;cursor:pointer;margin-right:15px;'
                             title='Edit Username and Password'
                         ></button>
                         <img src='../images/icon/bin.png' border=0 style='width:7%;cursor:pointer;'
                             title='Delete this Sub Account from this Corporate Card'
                             onclick=\"javascript:
                                         if(confirm('Do you want to delete this member from your member ?'))
                                         {	window.location='?section=$_GET[section]&&action=delete_sub&&member_id=$member_id&&page=$_GET[page]';	}
                                     \"
                         >
                     </td>
                 </tr>";
            //------------ Checked All - Uncheck All ---------------//
            $msg_check_all_a = $msg_check_all_a . "document.getElementById('member_id[$i]').checked='checked';";
            $msg_check_all_b = $msg_check_all_b . "document.getElementById('member_id[$i]').checked='';";
        }
        echo "
            <script language=\"javascript\">
                function select_all() {
                    if (document.getElementById('all_status').value == 'select') {
                        $msg_check_all_a
                        document.getElementById('all_status').value = 'remove';
                    }
                    else {
                        $msg_check_all_b
                        document.getElementById('all_status').value = 'select';
                    }
                }
            </script>";
            
        //----------------------------------------------//
        echo "	    <input type=hidden id='type_id' name='type_id' size=5 value='0'>  
                </form>
            </table>";
        echo "
			<table align=center width=90% cellpadding=5 cellspacing=0 border=0 >
				<form method=post action='?section=$_GET[section]&&action=set_per_page'>	
					<tr valign=top>
						<td width=10% align=right><font size=2 face=tahoma color=red><b>Page :</b></font></td>
						<td width=100% align=left>";
                        
    for ($p = 1; $p <= $all_page; $p++) {
        if ($p >= 1 && $p < 10) {
            $page_num = "[00$p]";
        }
        if ($p > 9 && $p < 100) {
            $page_num = "[0$p]";
        }
        if ($p > 100) {
            $page_num = "[$p]";
        }

        if ($_GET["page"] == $p) {
            $p_color = "#DF013A";
        } else {
            $p_color = "black";
        }
            
        if ((!$_GET["page"] || $_GET["page"] - $_GET["page"] != 0 || $_GET["page"] <= 0) && $p == 1) {
            $p_color = "red";
        }
        echo " &nbsp;<a href='?section=$_GET[section]&&page=$p'><font size=2 face=tahoma color='$p_color'>$page_num</font></a> ";
        if ($p % 20 == 0) {
            echo "<br>";
        }
    }
    echo "
						</td>
					</tr>
				</form>
			</table><br>";
    }else{
        echo "
            <table align=center width=90% height=25 cellpadding=0 cellspacing=0 border=0 bgcolor='#FFFFFF' style='border-radius:5px'>
                <tr>
                    <td align=center><br><font size=2 face=tahoma color=red><b>&nbsp;- No Data -</b></font><br>&nbsp;</td>
                </tr>
            </table>";
    }
   
    //------ Footer Manage by Selected Items: -> Limit, Unlimit, Delete -------//	
   
    if ($num >= 1) {
        echo "<br>
			<table align=center width=90% cellpadding=0 cellspacing=0 border=0 class='table-select-item' bgcolor='#FFFFFF'>
				<tr height=70>
					<td width=18% align=right>
						<font size=2 face=tahoma color='#676868'><b>Selected Items&nbsp;&nbsp;:&nbsp;&nbsp;</b></font>
					</td>
					<td width=7% align=left>
					    <center>
						<img src='../images/icon/limit.png' class='limit' border=0 style='width:30%;cursor:pointer;'
							title='Change them as Limited - Not allow these Sub Account get Available Date from Master Account'
							onclick=\"javascript:
										if(confirm('Do you want to change the status of the following members to be Limited ?'))
										{	
											document.getElementById('member_list').action='?section=$_GET[section]&&action=all_limit&&page=$_GET[page]';
											document.getElementById('member_list').submit();
										}
									\"
						><br>
                        <font style='color:#FFB700;'>Limit</font>
                        </center>
					</td>
					<td width=7% align=left>
					    <center>
						    <img src='../images/icon/unlimit.png' class='unlimit' border=0  style='width:30%; cursor:pointer;'
							    title='Change them as Unlimited - Allow these Sub Account get Available Date from Master Account'
							    onclick=\"javascript:
										if(confirm('Do you want to change the status of the following members to be Unlimited ?'))
										{	
											document.getElementById('member_list').action='?section=$_GET[section]&&action=all_unlimit&&page=$_GET[page]';
											document.getElementById('member_list').submit();
										}
									\"
						    >
						    <br>
                            <font style='color:#00C12B;'>Unlimit</font>
                        </center>
					</td>
					<td width=7% align=left>
					    <center>
						    <img src='../images/icon/bin.png' class='bin' border=0  style='width: 30%; cursor:pointer;'
							    title='Delete them from this Corporate Card'
							    onclick=\"javascript:
										if(confirm('Do you want to bring the following members out of this Corporate Card ?'))
										{	
											document.getElementById('member_list').action='?section=$_GET[section]&&action=all_delete&&page=$_GET[page]';
											document.getElementById('member_list').submit();
										}
									\"
						    >
						    <br>
                            <font style='color:red;'>Delete</font>
                        </center>
					</td>
					<td width=10% align=center>
					    <img src='../images/icon/move-to.png' border=0 style='width:22px; margin-right:15px;'>
					    <br>
						<font size=2 face=tahoma color='#676868'><b>Move To&nbsp;&nbsp;:&nbsp;&nbsp;</b></font>
					</td>
					<td width=30% align=left>
						<select id='ref_id' style='height: 28px;'>";
        //------------------------------------------------------------------------//
        
        $type_id = 0;
        $each_group = get_group_sub_member($type_id);

        $type_name = "None Group&nbsp;[ " . $each_group . " ]";
    
        echo "<option value='0'>$type_name </option>";

        $strSQL = "SELECT * FROM tbl_x_member_type WHERE member_id = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $_SESSION['x_member_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->num_rows; 
        $j = 1;
        while($data = $result->fetch_assoc()) {
            $temp_id[$j] = $data['type_id'];
            $temp_name[$j] = $data['name'];
            $j++; 
        }
        
        if ($rows >= 1) {
            for ($i = 1; $i <= $rows; $i++) {
                $type_name = $temp_name[$i];
                $type_id = $conn->real_escape_string(trim($temp_id[$i]));
                $each_group = get_group_sub_member($type_id);

                $type_name = $type_name . "&nbsp;[ " . $each_group . " ]";
               
                echo "<option value='$type_id' >$type_name </option>";
            }
        }
        $stmt->close();
        echo "
					</select>
					<input type='button' value='&nbsp;Set&nbsp;' class='btn-set' onclick=\"javascript:
						if(confirm('Do you want to bring the following members into the selected group ?'))
						{	
							document.getElementById('type_id').value=document.getElementById('ref_id').value;	
							document.getElementById('member_list').action='?section=$_GET[section]&&action=all_move&&page=$_GET[page]';
							document.getElementById('member_list').submit();
						}
					\">
				</td>
			</tr>
		</table>";
    }
    //---------------------------------------------------------------------------//
    //---------------------- Footer & Add Member From ---------------------------//
    //---------------------------------------------------------------------------//
    $sp_allow = 1;
    $strSQL = "SELECT * FROM tbl_x_member_spacial WHERE member_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s",$_SESSION['x_member_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_sp = $result->num_rows; 

    if ($is_sp == 1) {
        $sp_data = $result->fetch_array();
        $max_amount = $sp_data["amount"];

        $msg = "SELECT sub_id FROM tbl_x_member_sub WHERE master_id = ?";
        $query = $conn->prepare($msg);
        $query->bind_param("s",$_SESSION['x_member_id']);
        $query->execute();
        $result = $query->get_result();
        $all_sub = $result->num_rows; 
        $query->close();
        if ($all_sub >= $max_amount) {
            $sp_allow = 0;
        }
    }
    $stmt->close();
    if ($sp_allow == 1) {
        echo "<br>
			<table align=center width=60% cellpadding=0 cellspacing=0 border=0 class='add-member'>
				<tr valign=top>
					<td width=100%>	<!-- 60 % -->
 			";
        if ($_GET["action"] == "add_member") {
            if (strlen(trim($_POST["add_user"])) >= 8 && strlen(trim($_POST["add_pass"])) >= 8 && strlen(trim($_POST["add_re"])) >= 8 &&
                    strlen(trim($_POST["add_user"])) <= 20 && strlen(trim($_POST["add_pass"])) <= 20 && strlen(trim($_POST["add_re"])) <= 20) {
                if (trim($_POST["add_pass"]) == trim($_POST["add_re"])) {
                    
                    $user = $conn->real_escape_string(trim($_POST["add_user"]));
                    $pass = $conn->real_escape_string(trim($_POST["add_pass"]));
                    
                    $strSQL = "SELECT * FROM tbl_x_member WHERE user = ?";
                    $sub_query = $conn->prepare($strSQL);
                    $sub_query->bind_param("s",$user);
                    $sub_query->execute();
                    $result = $sub_query->get_result();
                    $is_same = $result->num_rows; 
                    $sub_query->close();

                    if ($is_same >= 1) {
                        $error = "<font size=2 face=tahoma color=red>This Username is already created.</font>";
                    }
                    if ($is_same == 0) {
                       
                        $msg = "SELECT * FROM tbl_x_member ORDER BY member_id DESC LIMIT 0,1";
                        $query = $conn->prepare($msg);
                        $query->execute();
                        $result = $query->get_result();
                        $is_have = $result->num_rows; 

                        if ($is_have == 1) {
                            $sub_data = $result->fetch_array();
                            $last_id = $sub_data["member_id"] + 1;
                        }
                        if ($is_have == 0) {
                            $last_id = 1;
                        }
                        $query->close();
                        $now = date("Y-m-d H:i:s");
                        $status = 0;

                        $strSQL = "INSERT INTO tbl_x_member_sub (master_id, sub_id, status, type_id) VALUES(?,?,?,?)";
                        $stmt = $conn->prepare($strSQL);
                        $stmt->bind_param("ssis",$_SESSION['x_member_id'],$last_id,$status,$_POST['user_newgroup']);
                        $stmt->execute();
                        $stmt->close();

                        $_SESSION["group_id_addAcc"] = $_POST["user_newgroup"];

                        $fname = '';
                        $lname = '';
                        $nickname = '';
                        $gender = '0';
                        $education_level = '0';
                        $education = '';
                        $birthday = '0000-00-00';
                        $address = '';
                        $email = '';
                        $tel = '';
                        $is_admin = '0';
                        
                        $msg = "INSERT INTO tbl_x_member (member_id, user, pass, fname, lname, nickname, gender, education_level, education, birthday, address, email, tel, create_date, is_admin) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                        $stmt = $conn->prepare($msg);
                        $stmt->bind_param("sssssssssssssss",$last_id,$user,$pass,$fname,$lname,$nickname,$gender,$education_level,$education,$birthday,$address,$email,$tel,$now,$is_admin);
                        $stmt->execute();
                        $stmt->close();  

                        header("Location:?section=$_GET[section]&&page=$_GET[page]");
                        exit;
                    }
                } else {
                    $error = "<font size=2 face=tahoma color=red>Re-Password is not same as your password</font>";
                }
            } else {
                $error = "<font size=2 face=tahoma color=red>Please Insert Username , Password and Re-Password <br> as 8-20 characters long</font>";
            }
        }
       	
        echo "
				<table align=center width=100% cellpadding=0 cellspacing=0 border=0 class='table-add-member'>
					<form method=post action=?section=$_GET[section]&&action=add_member&&page=$_GET[page]>
						<tr height=55>
							<td align=center colspan=3><font face=tahoma size=3 color=white><b> :: Add New Member :: </b></font></td>
						</tr>";
        if ($_GET["action"] == "add_member" && $error) {
            echo "
						<tr height=10 bgcolor='#ffeadc'><td colspan=3></td></tr>
						<tr height=25 bgcolor='#ffeadc'>
                            <td align=center colspan=3>
                                <font face=tahoma size=2 color=red>
								    $error
                                </font>
                            </td>
						</tr>
						<tr height=10 bgcolor='#ffeadc'><td colspan=3></td></tr>";
        } else {
            echo "<tr height=10 bgcolor='#ffeadc'><td colspan=3></td></tr>";
        }
        echo "
			<tr height=25 bgcolor='#ffeadc'>
				<td width=27% align=right ><font face=tahoma size=2 color=black><b> Add to Group </b></font></td>
				<td width=5% align=center><font face=tahoma size=2 color=black><b>&nbsp;:&nbsp;</b></font></td>
				<td width=68% align=left>
				    <select id='user_newgroup'  name='user_newgroup' style='height: 25px;'>";
        //----------------------------------------------------------------//
       
        $type_id = 0;
        $each_group = get_group_sub_member($type_id);

        $type_name = "None Group&nbsp;[ " . $each_group . " ]";

        //-----------------------------------------------------------------//
        echo "<option value='0'>$type_name </option>";
       
        $msg = "SELECT * FROM tbl_x_member_type WHERE member_id = ?";
        $stmt = $conn->prepare($msg);
        $stmt->bind_param("s",$_SESSION['x_member_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->num_rows; 
        $j = 1;
        while($row = $result->fetch_assoc()) {
            $temp_id[$j] = $row['type_id'];
            $temp_name[$j] = $row['name'];
            $j++;
        }
        $stmt->close();
        if ($rows >= 1) {
            for ($i = 1; $i <= $rows; $i++) {
                $type_id = $conn->real_escape_string(trim($temp_id[$i]));
                $type_name = $temp_name[$i];
                if ($type_id == $_SESSION["group_id_addAcc"]) {
                    $selectgroup = "selected";
                } else {
                    $selectgroup = "";
                }
                $each_group = get_group_sub_member($type_id);
                
                $type_name = $type_name . "&nbsp;[ " . $each_group . " ]";

                //---------------------------------------------------------------//
                echo "<option value='$type_id' $selectgroup >$type_name </option>";
            }
        }
        echo "
				         </select>
						</td>
					</tr>
                    <tr height=5 bgcolor='#ffeadc'><td colspan=3></td></tr>
					<tr height=25 bgcolor='#ffeadc'>
						<td width=27% align=right ><font face=tahoma size=2 color=black><b> Username </b></font></td>
						<td width=5% align=center><font face=tahoma size=2 color=black><b>&nbsp;:&nbsp;</b></font></td>
						<td width=68% align=left><input type='text' size=15 name='add_user' placeholder='&nbsp;Username' value='$_POST[add_user]' required>
							<font face=tahoma size=2 color=brown>* 8-20 Characters long</font>
						</td>
					</tr>
					<tr height=5 bgcolor='#ffeadc'><td colspan=3></td></tr>
					<tr height=25 bgcolor='#ffeadc'>
						<td align=right><font face=tahoma size=2 color=black><b> Password </b></font></td>
						<td align=center><font face=tahoma size=2 color=black><b>&nbsp;:&nbsp;</b></font></td>
						<td align=left><input type='password' size=15 name='add_pass' placeholder='&nbsp;Password' required>
							<font face=tahoma size=2 color=brown>* 8-20 Characters long</font>
						</td>
					</tr>
					<tr height=5 bgcolor='#ffeadc'><td colspan=3></td></tr>
					<tr height=25 bgcolor='#ffeadc'>
						<td align=right><font face=tahoma size=2 color=black><b> Re - Password </b></font></td>
						<td align=center><font face=tahoma size=2 color=black><b>&nbsp;:&nbsp;</b></font></td>
						<td align=left><input type='password' size=15 name='add_re' placeholder='&nbsp;Re - Password' required>
							<font face=tahoma size=2 color=brown>* Same as Password</font>
						</td>
					</tr>
					<tr height=10 bgcolor='#ffeadc'><td colspan=3></td></tr>
					<tr height=25 bgcolor='#ffeadc'>
                        <td align=left colspan=3>
                            <font face=tahoma size=2 color=blue>
                                &nbsp; * Please use \"a-z\" , \"A-Z\" , \"0-9\" , \"-\" , \"_\" , \"@\" or \".\"  <br> 
                                &nbsp;&nbsp;&nbsp;&nbsp; to create Username and Password <br>
                                &nbsp; * You can create Username as abcde_01 - abcde_10 ,<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;  abcde01 - abcde10  or abcde-01 - abcde-10<br> 
                                &nbsp; * You can't duplicate usernames <br>
                            </font>
                        </td>
					</tr>
					<tr height=10 bgcolor='#ffeadc'><td colspan=3></td></tr>
					<tr height=25 bgcolor='#ffeadc'>
						<td align=right><font face=tahoma size=2 color=black><b>&nbsp;</b></font></td>
						<td align=center width=60><font face=tahoma size=2 color=black><b>&nbsp;</b></font></td>
						<td align=left>
							<input type=submit size=20 value='&nbsp; Add  &nbsp;' style='margin-left:60px;' class='btn-add-member'>&nbsp;
						</td>
					</tr>
                    
					<tr height=22 bgcolor='#ffeadc'>
						<td align=center colspan=3><font face=tahoma size=2 color=black><b>&nbsp;</b></font></td>
					</tr>
                    <tr height=20>
                        <td colspan=3></td>
                    </tr>
				</form>
				</table>	
			</td>
		</tr>
	    </table><br>&nbsp;";
    } else {
        echo "<br>&nbsp;";
    }
    mysqli_close($conn);
}

function diff2time($time_a, $time_b) {
    $now_time1 = strtotime(date("Y-m-d " . $time_a));
    $now_time2 = strtotime(date("Y-m-d " . $time_b));
    $time_diff = abs($now_time2 - $now_time1);
    // $time_diff_h=floor($time_diff/3600); // จำนวนชั่วโมงที่ต่างกัน  
    // $time_diff_m=floor(($time_diff%3600)/60); // จำวนวนนาทีที่ต่างกัน  
    $time_diff_m = floor($time_diff / 60);
    // $time_diff_s=($time_diff%3600)%60; // จำนวนวินาทีที่ต่างกัน  
    return $time_diff_m;
}

function corporate_focus_profile() {
    include('../config/connection.php');
    //--------------------------------------------------//
    $sub_id = $conn->real_escape_string(trim($_GET["member_id"]));
    $strSQL = "SELECT * FROM tbl_x_member_sub WHERE master_id = ? && sub_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ss",$_SESSION['x_member_id'], $sub_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_sub_account = $result->num_rows; 
    if ($is_sub_account == 1) {
        $data = $result->fetch_array();
        $id = $conn->real_escape_string(trim($data["sub_id"]));
        
        $smg = "SELECT * FROM tbl_x_member WHERE member_id = ?";
        $query = $conn->prepare($smg);
        $query->bind_param("s",$id);
        $query->execute();
        $result = $query->get_result();
        $is_member = $result->num_rows; 
        $msg = "";
        if ($is_member == 1) {
            $sub_data = $result->fetch_array();
            $fname = $sub_data["fname"];
            $lname = $sub_data["lname"];
        }
        $query->close();
    } else {
        header("Location:?section=$_GET[section]");
    }
   
    echo "
		<table align=center width=90% cellpadding=0 cellspacing=0 border=0 bgcolor='#f0f0f0' style='border-radius:5px'>
			<tr height=30>
				<td align=right width=15%><font size=2 face=tahoma color=brown><b>Focus On &nbsp; : &nbsp; </b></font></td>
				<td align=left width=85%><font size=2 face=tahoma color=brown><b>$fname &nbsp; $lname</b></font></td>
			</tr>
		</table><br>
		";
    
    $stmt->close();
    mysqli_close($conn); 
}
function user_focus_profile(){
    include('../config/connection.php');
    
    $smg = "SELECT * FROM tbl_x_member WHERE member_id = ?";
    $query = $conn->prepare($smg);
    $query->bind_param("s",$_SESSION['x_member_id']);
    $query->execute();
    $result = $query->get_result();
    $is_member = $result->num_rows; 
    if ($is_member == 1) {
        $sub_data = $result->fetch_array();
        $fname = $sub_data["fname"];
        $lname = $sub_data["lname"];
    }else{
        header("Location:?section=$_GET[section]");
    }
    $query->close();
    mysqli_close($conn);
    
    echo "
		<table align=center width=90% cellpadding=0 cellspacing=0 border=0 bgcolor='#f0f0f0' style='border-radius:5px'>
			<tr height=30>
				<td align=right width=15%><font size=2 face=tahoma color=brown><b>Focus On &nbsp; : &nbsp; </b></font></td>
				<td align=left width=85%><font size=2 face=tahoma color=brown><b>$fname &nbsp; $lname</b></font></td>
			</tr>
		</table><br>
		";    
}

function report_a_layout() {
    include('../config/connection.php');
    $allow = check_sub_account($_SESSION["x_member_id"], $_GET["member_id"]);
    
    if ($allow == "true") {
        $member_id = $conn->real_escape_string(trim($_GET["member_id"]));
        $link_ref_member = "&&member_id=$member_id";
    }
    //-----------------------------------------------------------------------------//
    //------------------------------- report academic ----------------------------//
    if ($_GET["report_section"] == "academic") {
        $color_a = "#FEBC13";
        $color_b = "#FCEFD9";

        // ========= แสดงหน้า report of test evaluation ============ //

        echo "
			<img src='../images/image2/eol system/Report/report-test-evo.png' usemap='#Map' border='0' width='970px' style='border-radius:10px'>
            <map name='Map' id='Map'>
                <area shape='rect' coords='670,292,955,369' href='?section=$_GET[section]&&action=$_GET[action]$link_ref_member' target='_self' />
            </map>
			
			<table width='80%' align='center' cellpadding='0' cellspacing='1' border='0' style='position:absolute;top:505px;left:50%;margin-left:-400px;' >
				<tr height='30'>
					<td bgcolor='$color_a' width='15%' align='right'><font size='2' face='tahoma' color='white'><b>Multiple Skills&nbsp;</b></font></td>
					<td bgcolor='$color_b' width='85%'>&nbsp;
						<a href='?section=$_GET[section]&&action=$_GET[action]&&report_section=$_GET[report_section]$link_ref_member&&skill_id=10'>
						<font size='2' face='tahoma' color='black'><b><img src='../images/icon/arrow.gif'> Multiple Skills </b></font></a>  
					</td>	
				</tr>
				<tr height='30'>
					<td bgcolor='$color_a' width='15%' align='right'><font size='2' face='tahoma' color='white'><b>Single Skill&nbsp;</b></font></td>
					<td bgcolor='$color_b' width='85%'>
						<table align='center' width='100%' cellpadding='0' cellspacing='0' border='0'>
							<tr height='25'>
								<td width='33%'>&nbsp;
									<a href='?section=$_GET[section]&&action=$_GET[action]&&report_section=$_GET[report_section]$link_ref_member&&skill_id=1'>
									<font size='2' face='tahoma' color='black'><b><img src='../images/icon/arrow.gif'> Reading Comprehension </b></font></a>  
								</td>
								<td width='33%'>&nbsp;
									<a href='?section=$_GET[section]&&action=$_GET[action]&&report_section=$_GET[report_section]$link_ref_member&&skill_id=3'>
									<font size='2' face='tahoma' color='black'><b><img src='../images/icon/arrow.gif'> Semi-Speaking </b></font></a>  
								</td>
								<td width='33%'>&nbsp;
									<a href='?section=$_GET[section]&&action=$_GET[action]&&report_section=$_GET[report_section]$link_ref_member&&skill_id=5'>
									<font size='2' face='tahoma' color='black'><b><img src='../images/icon/arrow.gif'> Grammar </b></font></a>  
								</td>
							</tr>
							<tr height='25'>
								<td width='33%'>&nbsp;
									<a href='?section=$_GET[section]&&action=$_GET[action]&&report_section=$_GET[report_section]$link_ref_member&&skill_id=2'>
									<font size='2' face='tahoma' color='black'><b><img src='../images/icon/arrow.gif'> Listening Comprehension </b></font></a>  
								</td>
								<td width='33%'>&nbsp;
									<a href='?section=$_GET[section]&&action=$_GET[action]&&report_section=$_GET[report_section]$link_ref_member&&skill_id=4'>
									<font size='2' face='tahoma' color='black'><b><img src='../images/icon/arrow.gif'> Semi-Writing </b></font></a>  
								</td>
								<td width='33%'>&nbsp;
									<a href='?section=$_GET[section]&&action=$_GET[action]&&report_section=$_GET[report_section]$link_ref_member&&skill_id=7'>
									<font size='2' face='tahoma' color='black'><b><img src='../images/icon/arrow.gif'> Vocabulary </b></font></a>  
								</td>
							</tr>
						</table>	
					</td>	
				</tr>
			</table>";
    }
    //-------------------------------------------------------//
    mysqli_close($conn);
}

function check_sub_account($master, $sub) {
    include('../config/connection.php');
    //--------------------------------------------------//
    
    $master_id = $conn->real_escape_string(trim($master));
    $sub_id = $conn->real_escape_string(trim($sub));
    $strSQL = "SELECT * FROM tbl_x_member_sub WHERE master_id = ? && sub_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ss",$master_id, $sub_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_sub_account = $result->num_rows;
    $stmt->close();
    if ($is_sub_account == 1) {
        $allow = "true";
    } else {
        $allow = "false";
    }
    mysqli_close($conn);
    return $allow;
}

function report_a_result_list() {
    include('../config/connection.php');
    if ($_GET["skill_id"] >= 1 && $_GET["skill_id"] - $_GET["skill_id"] == 0) {
        $skill_id = $conn->real_escape_string(trim($_GET["skill_id"]));
    } else {
        $skill_id = 10;
    }
    //---------------------------------------------------------//
    if (!$_POST["start"]) {
        $start = date("Y-m-d", time() - ( 60 * 60 * 24 * 30 ));
    } else {
        $start = $conn->real_escape_string(trim($_POST["start"]));
    }
    if (!$_POST["stop"]) {
        $stop = date("Y-m-d", time() + ( 60 * 60 * 24 * 1 ));
    } else {
        $stop = $conn->real_escape_string(trim($_POST["stop"]));
    }
    //---------------------------------------------------------//
    $allow = check_sub_account($_SESSION["x_member_id"], $_GET["member_id"]);
    
    if ($allow == "true") {
        $member_id = $conn->real_escape_string(trim($_GET["member_id"]));
        $link_ref_member = "&&member_id=$member_id";
    }
    
    //--------------------------------------------------------//
    $skill_name[1] = "Reading Comprehension";
    $skill_name[2] = "Listening Comprehension";
    $skill_name[3] = "Semi-Speaking";
    $skill_name[4] = "Semi-Writing";
    $skill_name[5] = "Grammar";
    $skill_name[6] = "Intergrated Skill : Cloze Test";
    $skill_name[7] = "Vocabulary ";
    $skill_name[10] = "Multiple Skills";
    $skill_name[11] = 'EOL Contest';
   
    echo "
		<link rel=\"stylesheet\" type=\"text/css\" href=\"../calendar/epoch_styles.css\" />
		<script type=\"text/javascript\" src=\"../calendar/epoch_classes.js\"></script>
		<script type=\"text/javascript\">
		 /*You can also place this code in a separate file and link to it like epoch_classes.js*/
		 	var a,b;      
		    window.onload = function () {
		 	    a  = new Epoch('epoch_popup','popup',document.getElementById('popup_container_a'));
		 	    b  = new Epoch('epoch_popup','popup',document.getElementById('popup_container_b'));
		    };
		</script>";
    
    if ($_GET["report_section"] == "academic") {

        echo "  <br>
			    <table align='center' width='80%' bgcolor='#FEBC13' cellpadding='0' cellspacing='0' style='position:absolute;top:600px;left:50%;margin-left:-400px;border-radius:10px;' >
                    <form method='post'  id='placeholder' 
                        action='?section=$_GET[section]&&action=$_GET[action]$link_ref_member&&report_section=$_GET[report_section]&&skill_id=$skill_id'>	
                        <tr height='40'>
                            <td align='center'><font size='3' face='tahoma' color='green'><b> Report :  " . $skill_name[$skill_id] . "</b></font></td>
                        </tr>
  </table>
				<br>
				<table align='center' width='60%' bgcolor='#ffffff' cellpadding='0' cellspacing='0' border='0' style='position:absolute;top:650px;left:60%;margin-left:-400px;border-radius:10px;'>
                        <tr height='50' valign='middle' >
                            <td align='right' width='13%' ><font size='2' face=tahoma color='black'><b>From &nbsp; : &nbsp;</b></font></td>
                            <td align='left' width='27%'>&nbsp;<input id='popup_container_a' type='text' name='start' value='$start' size=16 style='height:22px;border-radius:8px;border:1px solid #bbb2ae'></td>
                            <td align='right' width='13%' ><font size='2' face=tahoma color='black'><b>Until &nbsp; : &nbsp;</b></font></td>
                            <td align='left' width='27%'>&nbsp;<input id='popup_container_b' type='text' name='stop' value='$stop' size=16 style='height:22px;border-radius:8px;border:1px solid #bbb2ae'></td>
                            <td align='left' width='15%' ><input type='submit' value='&nbsp; View &nbsp;' class='btn-view' ></td>
                        </tr>
                        <tr height='25'>
                            <td align='center' colspan='5'><font size='2' face='tahoma' color='red'><b>Format Date : Ex. 2010-12-31 </b></font></td>
                        </tr>
				    </form>
				</table>
			    <br>";
    }

    // ----------------------------------------------------- //
    if ($_POST["start"] && $_POST["stop"]) {
        $time_msg = " && create_date >= '$start' && create_date <= '$stop' ";
    } else {
        $time_msg = " && create_date >= '$start' && create_date <= '$stop' ";
    }
    // ============== Loop For 5 Levels =================== //
    for ($level_id = 1; $level_id <= 5; $level_id++) {  
        if ($allow == "true") {
            $focus_member_id = $conn->real_escape_string(trim($_GET["member_id"]));
        }
        if ($allow == "false") {
            $focus_member_id = $_SESSION["x_member_id"];
        }
       
        $strSQL = "SELECT * FROM tbl_w_result WHERE member_id = ? && skill_id = ? && level_id = ? $time_msg ORDER BY create_date DESC";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("sss",$focus_member_id, $skill_id, $level_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $result_num[$level_id] = $result->num_rows;

        $j=1;
        while($row = $result->fetch_assoc()) {
            $temp_result[$j] = $row['result_id'];
            $temp_date[$j] = $row['create_date'];
            $j++;
        }
        $stmt->close();
        
        if ($result_num[$level_id] >= 1) {
            $max[$level_id] = 0;
            $min[$level_id] = 100;
            $sum[$level_id] = 0;
            for ($p = 1; $p <= $result_num[$level_id]; $p++) {
                $result_id = $temp_result[$p];
                //-------------------------------------//
                $arr_date_time = explode(" ", $temp_date[$p]);
                $arr_date = explode("-", $arr_date_time[0]);
                $create_date[$level_id][$p] = $arr_date[2] . "/" . $arr_date[1] . "/" . $arr_date[0] . "&nbsp;&nbsp;" . $arr_date_time[1];
                $arr_result_id[$level_id][$p] = $result_id;
                //-------------------------------------//

                $msg = "SELECT * FROM tbl_w_result_detail WHERE result_id = ?";
                $query = $conn->prepare($msg);
                $query->bind_param("s",$result_id);
                $query->execute();
                $result = $query->get_result();
                $ans_num = $result->num_rows;

                $total_amount[$level_id][$p] = $ans_num;

                $j=1;
                while($data = $result->fetch_assoc()) {
                    $temp_quiz[$j] = $data['quiz_id'];
                    $temp_ans[$j] = $data['ans_id'];
                    $j++;
                }
                $query->close();
                
                if ($ans_num >= 1) {
                    for ($k = 1; $k <= $ans_num; $k++) {
                        $quiz_id = $temp_quiz[$k];
                        $ans_id = $temp_ans[$k];
                        $correct = 1;
                        $sql = "SELECT * FROM tbl_answers WHERE QUESTIONS_ID = ? && ANSWERS_ID = ? && ANSWERS_CORRECT = ?";
                        $sub_stmt = $conn->prepare($sql);
                        $sub_stmt->bind_param("ssi",$quiz_id, $ans_id, $correct);
                        $sub_stmt->execute();
                        $result = $sub_stmt->get_result();
                        $is_true = $result->num_rows;
                        if ($is_true == 1) {
                            $result_point[$level_id][$p] = $result_point[$level_id][$p] + 1;
                        }
                    }
                    // $sub_stmt->close();
                } else {
                    $result_point[$level_id][$p] = 0;
                }
                //------------------------------------------------------//
                $percent[$level_id][$p] = 100 * ( $result_point[$level_id][$p] / $total_amount[$level_id][$p] ) + 0;
                $arr_percent = explode(".", $percent[$level_id][$p]);
                if ($arr_percent[1] >= 1) {
                    $percent[$level_id][$p] = $arr_percent[0] . "." . $arr_percent[1][0] . $arr_percent[1][1];
                } else {
                    $percent[$level_id][$p] = $arr_percent[0];
                }
                //------------------------------------------------------//
                if ($max[$level_id] <= $percent[$level_id][$p]) {
                    $max[$level_id] = $percent[$level_id][$p];
                }
                if ($min[$level_id] >= $percent[$level_id][$p]) {
                    $min[$level_id] = $percent[$level_id][$p];
                }
                $sum[$level_id] = $sum[$level_id] + $percent[$level_id][$p];
            }
            $average[$level_id] = $sum[$level_id] / $result_num[$level_id];
            $arr_average = explode(".", $average[$level_id]);
            if ($arr_average[1] >= 1) {
                $average[$level_id] = $arr_average[0] . "." . $arr_average[1][0] . $arr_average[1][1];
            } else {
                $average[$level_id] = $arr_average[0];
            }
           
        }
        $color[1] = "blue";
        $color[2] = "#3a879c";
        $color[3] = "green";
        $color[4] = "#ff9c31";
        $color[5] = "red";
        $level_name[1] = "Beginner";
        $level_name[2] = "lower Intermediate";
        $level_name[3] = "Intermediate";
        $level_name[4] = "Upper Intermediate";
        $level_name[5] = "Advanced";
        $x_bar[1] = "bar_07.png";
        $x_bar[2] = "bar_06.png";
        $x_bar[3] = "bar_01.png";
        $x_bar[4] = "bar_03.png";
        $x_bar[5] = "bar_02.png";
        
        if ($result_num[$level_id] >= 1) {
            echo "<br>
				  <table align='center' width='90%' cellpadding='0' cellspacing='0' border='0' background='#ffff'>
                    <tr height='50'>
                        <td align='left' colspan='4'><font size='3' face='tahoma' color='$color[$level_id]'><b>&nbsp; $level_name[$level_id]</b></font></td>
                    </tr>";
            for ($p = 1; $p <= $result_num[$level_id]; $p++) {
                $width = 510 * ($percent[$level_id][$p] / 100 );
                echo "
                    <tr height='30'>
                        <td align='left' width='20%' bgcolor='#f0f0f0'>
                            <a target='_blank' 
                                href='../EOL/eoltest.php?section=$_GET[section]&&action=$_GET[action]$link_ref_member&&report_section=$_GET[report_section]&&result_id=" . $arr_result_id[$level_id][$p] . "'>
                                <font size='2' face='tahoma' color='brown'><b>&nbsp; " . $create_date[$level_id][$p] . "</b></font>
                            </a>
                        </td>
                        <td width='10%' align='right' bgcolor='#d7d7d7'>
                            <font size='2' face='tahoma' color='black'><b>" . ($result_point[$level_id][$p] + 0) . " / " . ($total_amount[$level_id][$p] + 0) . "&nbsp;&nbsp;</b></font>
                        </td>
                        <td width='60%' align='left' bgcolor='#f0f0f0'>&nbsp;<img id='$p' src='../2010/temp_images/icon_bar/" . $x_bar[$level_id] . "' width='$width' height='25' style='border-radius:5px;margin-top:2.5px;'></td>
                        <td width='10%' align='right' bgcolor='#d7d7d7'><font size='2' face='tahoma' color='blue'><b>" . ($percent[$level_id][$p] + 0) . " % &nbsp; </b></font></td>
                    </tr>
					<tr height='1'><td colspan='4'></td></tr>";
            }
           
            // ============ หน้าแสดงผลการสอบของ test & evaluation ============ //
            
            echo "	
					<tr height='10'><td colspan='4'></td></tr>
					<tr height='30'>
						<td >&nbsp;</td>
						<td colspan='3'>
							<table align='center' width='100%' cellpadding='5' cellspacing='0' border='0' bgcolor='#f0f0f0' style='border-radius:10px'>
								<tr height='25'>
									<td align='right' width='15%'><font size='2' face='tahoma' color='blue'><b>Min&nbsp;:&nbsp;</b></font></td>
									<td align='left'  width='20%'><font size='2' face='tahoma' color='blue'><b>$min[$level_id] %</b></font></td>
									<td align='right' width='15%'><font size='2' face='tahoma' color='red'><b>Max&nbsp;:&nbsp;</b></font></td>
									<td align='left'  width='20%'><font size='2' face='tahoma' color='red'><b>$max[$level_id] %</b></font></td>
									<td align='right' width='15%'><font size='2' face='tahoma' color='green'><b>Average&nbsp;:&nbsp;</b></font></td>
									<td align='left'  width='15%'><font size='2' face='tahoma' color='green'><b>$average[$level_id] %</b></font></td>
								</tr>
							</table>
						</td>
					</tr>
				</table><br>";
        }
    }
    mysqli_close($conn);
}

function report_a_result_detail() {
    include('../config/connection.php');
    include('../config/format_time.php');
    //-----------------------------------------------------------------------------//
    $allow = check_sub_account($_SESSION["x_member_id"], $_GET["member_id"]);
  
    //-----------------------------------------------------------------------------//
    if ($allow == "true") {
        $member_id = $conn->real_escape_string(trim($_GET["member_id"]));
        $link_ref_member = "&&member_id=$member_id";
        $focus_member_id = $conn->real_escape_string(trim($_GET["member_id"]));
    }
    if ($allow == "false") {
        $focus_member_id = $_SESSION["x_member_id"];
    }
    $result_id = $conn->real_escape_string(trim($_GET["result_id"]));
    //-----------------------------------------------------------------------------//
   
    $strSQL = "SELECT * FROM tbl_w_result WHERE member_id = ? && result_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ss",$focus_member_id, $result_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->num_rows;
    if ($num == 1) {
        $result_data = $result->fetch_array();
        $result_id = $result_data["result_id"];
        $member_id = $result_data["member_id"];
        $level_id = $result_data["level_id"];
        $skill_id = $result_data["skill_id"];
        $create_date = $result_data["create_date"];
        $etest_id = $result_data["etest_id"];
    
        $arr_date_time = explode(" ", $create_date); 
        $msg_date = get_thai_day($arr_date_time[0]) . " &nbsp; " . get_thai_month($arr_date_time[0]) . " &nbsp; " . get_thai_year($arr_date_time[0]) . " &nbsp;&nbsp; เวลา " . $arr_date_time[1] . " น. ";
        //-------------------------------------//
       
        $msg = "SELECT * FROM tbl_x_member WHERE member_id = ?";
        $query = $conn->prepare($msg);
        $query->bind_param("s",$focus_member_id);
        $query->execute();
        $result = $query->get_result();
        $data = $result->fetch_array();
        $fname = $data["fname"];
        $lname = $data["lname"];
        $gender = $data["gender"];
        $query->close();
        
        $skill_name[1] = "Reading Comprehension";
        $skill_name[2] = "Listenin Comprehension";
        $skill_name[3] = "Semi-Speaking";
        $skill_name[4] = "Semi-Writing";
        $skill_name[5] = "Grammar";
        $skill_name[6] = "Integreted Skill : Cloze Test";
        $skill_name[7] = "Vocabulary";
        $skill_name[10] = "Multiple Skills";
        $level_name[1] = "Beginner";
        $level_name[2] = "Lower Intermediate";
        $level_name[3] = "Intermediate";
        $level_name[4] = "Upper Intermediate";
        $level_name[5] = "Advanced";
        $section_msg = "&nbsp; $skill_name[$skill_id] &nbsp; &raquo; &nbsp; $level_name[$level_id]";
       
        if ($etest_id >= 1) {
            
            $str = "SELECT * FROM tbl_etest WHERE ETEST_ID = ?";
            $sub_stmt = $conn->prepare($str);
            $sub_stmt->bind_param("s",$etest_id);
            $sub_stmt->execute();
            $result = $sub_stmt->get_result();
            $is_etest = $result->num_rows;
            if ($is_etest == 1) {
                $e_data = $result->fetch_array();
                $etest_name = $e_data["ETEST_NAME"];
                $is_est = $e_data["IS_EST"];
                $section_msg = "&nbsp; Extra Test &nbsp; &raquo; &nbsp; $etest_name";
            }
            $sub_stmt->close();
        }
        if ($is_est != 1) {
            //---------------- Get All point --------------------//
            
            $sql = "SELECT * FROM tbl_w_result_detail WHERE result_id = ? GROUP BY quiz_id";
            $sub_query = $conn->prepare($sql);
            $sub_query->bind_param("s",$result_id);
            $sub_query->execute();
            $result = $sub_query->get_result();
            $total_amount = $result->num_rows;
            $j=1;
            while($row = $result->fetch_assoc()) {
                $temp_quiz[$j] = $row['quiz_id'];
                $j++;
            }
            $sub_query->close();
            //---------------- Get Pass point -------------------//
            if ($total_amount >= 1) {
                $amount = 0;
                for ($i = 1; $i <= $total_amount; $i++) {
                    $quiz_id = $temp_quiz[$i];
                    $correct = 1;

                    $str = "SELECT ANSWERS_ID FROM tbl_answers WHERE QUESTIONS_ID = ? &&  ANSWERS_CORRECT = ?";
                    $str_stmt = $conn->prepare($str);
                    $str_stmt->bind_param("si",$quiz_id,$correct);
                    $str_stmt->execute();
                    $result = $str_stmt->get_result();
                    $is_true = $result->num_rows;

                    if ($is_true == 1) {
                        $check = $result->fetch_array();
                        $ans_id = $check["ANSWERS_ID"];
                        $result_id = $conn->real_escape_string(trim($_GET["result_id"]));
                        
                        $table = "SELECT ans_id FROM tbl_w_result_detail WHERE result_id = ? && quiz_id = ? && ans_id = ?";
                        $str_query = $conn->prepare($table);
                        $str_query->bind_param("sss",$result_id,$quiz_id,$ans_id);
                        $str_query->execute();
                        $result = $str_query->get_result();
                        $is_correct = $result->num_rows;
                        
                        if ($is_correct == 1) {
                            $amount = $amount + 1;
                        }
                        $str_query->close();
                    }
                    $str_stmt->close();
                }
                $amount = $amount + 0;
                $percent = 0 + ($amount / $total_amount * 100);
                $arr = explode(".", $percent);
                if (strlen($arr[1]) > "2") {
                    $percent = $arr[0] . "." . $arr[1][0] . $arr[1][1];
                }
            }
            $msg_image = "../2010/member_images/" . $member_id . ".jpg";
            $data_image = @getimagesize($msg_image);
            if ($data_image[0] >= 1 && $data_image[0] - $data_image[0] == 0) {
                $image_name = $member_id . ".jpg";
                if ($data_image[1] >= 100) {
                    $height = 100;
                } else {
                    $height = $data_image[1];
                }
            } else {
                $image_name = "icon_user_0" . $gender . ".jpg";
                $height = 100;
            }
            
            //=========== หน้าแสดงรายละเอียดผลการสอบของแต่ละบุคคล ===============//
            
            echo "
				<table align=center width=90% cellpadding=5 cellspacing=0 border=0 bgcolor='#fff' style='border-radius:10px'>
					<tr height=25>
						<td width=11% rowspan=4 bgcolor='#e7e7e7' align=center><img src='../2010/member_images/$image_name' height='$height'></td>
	  					<td width=22% align=right><font size=2 face=tahoma color=black><b>ผู้ทำแบบทดสอบ &nbsp; : &nbsp; </b></font></td>
	  					<td width=50% align=left><font size=2 face=tahoma color=black><b>&nbsp; $fname &nbsp; &nbsp; $lname </b></font></td>
      					<td width=17% rowspan=4>
						</td>
  					</tr>
					<tr  height=25>
						<td align=right><font size=2 face=tahoma color=black><b>วันที่ทำการทดสอบ &nbsp; : &nbsp; </b></font></td>
						<td align=left ><font size=2 face=tahoma color=black><b>&nbsp; $msg_date </b></font></td>
    				</tr>
					<tr  height=25>
						<td align=right><font size=2 face=tahoma color=black><b>ประเภทการทดสอบ &nbsp; : &nbsp; </b></font></td>
						<td align=left ><font size=2 face=tahoma color=black><b> $section_msg </b></font></td>
    				</tr>
					<tr  height=25>
						<td align=right><font size=2 face=tahoma color=black><b>คะแนนที่ได้ &nbsp; : &nbsp; </b></font></td>
						<td align=left ><font size=2 face=tahoma color=black><b>&nbsp; $amount / $total_amount &nbsp; คะแนน &nbsp;&nbsp;&nbsp; คิดเป็น &nbsp; $percent %</b></font></td>
    				</tr>
				</table><br>
				<table align=center width=90% cellpadding=2 cellspacing=0 border=0 >
                    <tr  height=30>
						<td width=15% align=center >
							<a href='?section=$_GET[section]&&action=$_GET[action]&&report_section=$_GET[report_section]$link_ref_member&&result_id=$_GET[result_id]&&type=1'>
								<img src='../images/icon/summary-01.png' border=0>
							</a> 
                        </td>
						<td width=15% align=center >
							<a href='?section=$_GET[section]&&action=$_GET[action]&&report_section=$_GET[report_section]$link_ref_member&&result_id=$_GET[result_id]&&type=2'>
								<img src='../images/icon/check your answer-01.png' border=0>
							</a> 
                        </td>
						<td width=15% align=center >
							<a href='?section=$_GET[section]&&action=$_GET[action]&&report_section=$_GET[report_section]$link_ref_member&&result_id=$_GET[result_id]&&type=3'>
								<img src='../images/icon/ranking-01.png' border=0>
							</a> 
						</td>
						<td width=70% align=left colspan=2 >&nbsp;</td>
					</tr>
				</table><br>";
            if ($_GET["type"] == 1 || !$_GET["type"]) {
                display_chart_bar();
                display_weak_point();
            }
            if ($_GET["type"] == 2) {
                display_a_test_detail();
            }
            if ($_GET["type"] == 3) {
                display_a_view_group();
            }
            if ($_GET["type"] == 4) {
                if ($_GET["sub_action"] == "comment") {
                    display_comment();
                }
            }
        }
    } else {
        header("Location:?section=$_GET[section]");
    }
    $stmt->close();
    mysqli_close($conn);

}
function report_select_section() {
    include('../config/connection.php');
    //-----------------------------------------------------------------------------//
    $allow = check_sub_account($_SESSION["x_member_id"], $_GET["member_id"]);
    if ($allow == "true") {
        $member_id = $conn->real_escape_string(trim($_GET["member_id"]));
        $link_ref_member = "&&member_id=$member_id";
    }
    $check_master = check_master();
    $is_sub = check_sub_member();
    
    if($check_master === "master"){
        $padding_top = "padding-top: 40px;";
        $style1 = "position:absolute;top:512px;left:50%;margin-left:-390px;border-radius:20px;width:28%;";
        $style2 = "position:absolute;top:512px;left:50%;margin-left:-120px;border-radius:20px;width:28%;";
        $style3 = "position:absolute;top:512px;left:50%;margin-left:150px;border-radius:20px;width:28%;";
    }else{
        $style1 = "position:absolute;top:475px;left:50%;margin-left:-390px;border-radius:20px;width:28%;";
        $style2 = "position:absolute;top:475px;left:50%;margin-left:-120px;border-radius:20px;width:28%;";
        $style3 = "position:absolute;top:475px;left:50%;margin-left:150px;border-radius:20px;width:28%;";
    }
    if($is_sub == 1 || $allow == "true"){
        echo "
            <div class='sub-member' style='$padding_top'>
                <p>ตรวจเช็คดูผลการฝึกฝนและเรียนรู้ในห้องทดสอบทั้ง 3 ฟังก์ชั่น</p>
            </div>
            <table align=center width=90% cellpadding=0 cellspacing=0 border=0>
                <tr>
                    <a href='?section=$_GET[section]&&action=$_GET[action]&&report_section=academic$link_ref_member'>
                        <img src='../images/image2/eol system/Report/Button/Test Evaluation Report.png'  style='$style1'>
                    </a>
                    <a href='?section=$_GET[section]&&action=$_GET[action]&&report_section=standard$link_ref_member'>
                        <img src='../images/image2/eol system/Report/Button/EST Report.png'  style='$style2'>
                    </a>
                    <a href='?section=$_GET[section]&&action=$_GET[action]&&report_section=contest$link_ref_member'>
                        <img src='../images/image2/eol system/Report/Button/Contest Report.png'  style='$style3'>
                    </a>
                    <img src='../images/image2/eol system/Report/bg-report.png' width='970px' style='border-radius:10px'>
                </tr>
            </table><br>&nbsp;";
    }
    else{
        echo "
        <div class='personal'>
            <p>ตรวจเช็คดูผลการฝึกฝนและเรียนรู้ในห้องทดสอบทั้ง 2 ฟังก์ชั่น</p>
        </div>
        <table align=center width=90% cellpadding=0 cellspacing=0 border=0 class='sec-report'>
            <tr>
                <a href='?section=$_GET[section]&&action=$_GET[action]&&report_section=academic$link_ref_member'>
                    <img src='../images/image2/eol system/Report/Button/Test Evaluation Report.png'  style='position:absolute;top:475px;left:50%;margin-left:-257px;border-radius:20px;width:28%;'>
                </a>
                <a href='?section=$_GET[section]&&action=$_GET[action]&&report_section=standard$link_ref_member'>
                    <img src='../images/image2/eol system/Report/Button/EST Report.png'  style='position:absolute;top:475px;left:50%;margin-left:40px;border-radius:20px;width:28%;'>
                </a>
                <img src='../images/image2/eol system/Report/bg-report.png' width='970px' style='border-radius:10px'>
            </tr>
        </table>
        <br>&nbsp;";
    }
    mysqli_close($conn);
}

function display_chart_bar() {
    include('../config/connection.php');
    //---------------------------------------------------//
    $font_a = "<font size=2 face=tahoma>";
    $result_id = $conn->real_escape_string(trim($_GET["result_id"]));
    $strSQL = "SELECT * FROM tbl_w_result_detail WHERE result_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s",$result_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->num_rows;
    $j=1;
    while($row = $result->fetch_assoc()) {
        $temp_quiz[$j] = trim($row['quiz_id']);
        $j++;  
    }
    $stmt->close();
    $amount = 0;
    $percent = 0;
    if ($num >= 1) {
        for ($i = 1; $i <= $num; $i++) {
            $question_id = $temp_quiz[$i];
            $sql = "SELECT QUESTIONS_ID,SKILL_ID FROM tbl_questions WHERE QUESTIONS_ID = ?";
            $query = $conn->prepare($sql);
            $query->bind_param("s",$question_id);
            $query->execute();
            $result = $query->get_result();
            $is_question = $result->num_rows;

            if ($is_question == 1) {
                $sub_data = $result->fetch_array();
                $skill_id = $sub_data["SKILL_ID"];
                $question_id = $sub_data["QUESTIONS_ID"];
                $ans_correct = 1;

                $str = "SELECT ANSWERS_ID FROM tbl_answers WHERE QUESTIONS_ID = ? && ANSWERS_CORRECT = ?";
                $sub_stmt = $conn->prepare($str);
                $sub_stmt->bind_param("si",$question_id,$ans_correct);
                $sub_stmt->execute();
                $result = $sub_stmt->get_result();
                $is_true = $result->num_rows;
                if ($is_true == 1) {
                    $check = $result->fetch_array();
                    $ans_id = trim($check["ANSWERS_ID"]);
                   
                    $msg = "SELECT ans_id FROM tbl_w_result_detail WHERE result_id = ? && quiz_id = ? && ans_id = ?";
                    $sub_query = $conn->prepare($msg);
                    $sub_query->bind_param("sss",$result_id,$question_id,$ans_id);
                    $sub_query->execute();
                    $result = $sub_query->get_result();
                    $is_correct = $result->num_rows;
                    $sub_query->close();
                    
                    for ($k = 1; $k <= 7; $k++) {
                        if ($skill_id == $k) {
                            $skill[$k] = $skill[$k] + 1;
                        }
                        if ($is_correct == 1) {
                            if ($skill_id == $k) {
                                $pass[$k] = $pass[$k] + 1;
                                $amount = $amount + 1;
                            }
                        }
                    }
                }
                $sub_stmt->close();
            }
            $query->close();
        }
    }
   
    echo "<br>";
    $topic[1] = "Reading Comprehension";
    $topic[2] = "Listening Comprehension";
    $topic[3] = "Semi-Speaking ";
    $topic[4] = "Semi-Writing";
    $topic[5] = "Grammar";
    $topic[6] = "Integrated Skill: Cloze Test ";
    $topic[7] = "Vocabulary";
    for ($i = 1; $i <= 7; $i++) {
        if (!$skill[$i]) {
            $skill[$i] = 0;
        }
        if (!$pass[$i]) {
            $pass[$i] = 0;
        }
        if ($skill[$i] != 0) {
            $percent = (0 + ($pass[$i] / $skill[$i])) * 100;
            $arr = explode(".", $percent);
            if (strlen($arr[1]) > "2") {
                $percent = $arr[0] . "." . $arr[1][0] . $arr[1][1];
            }
            
            // =========== ตารางแสดงกราฟคะแนนแต่ละลำดับ ================ //
           
            echo "	
				<table align=center width=90% cellpadding=0 cellspacing=1 border=0 bgcolor='#FFFFFF' style='border-radius:5px'>
					<tr height=40 valign=middle>
						<td width=20% align=right width=10%>$font_a  <b> $topic[$i]</td>
						<td width=1% align=center>$font_a &nbsp;:&nbsp;</td>
						<td width=15% align=right bgcolor=eeeeee>$font_a &nbsp; $percent% [$pass[$i]/$skill[$i]]&nbsp;</td>
						<td width=64% align=left bgcolor=eeeeee>
							<img src=../2010/temp_images/icon_bar/bar_0$i.png height=25 width='$percent%' style='border-radius:5px;'>
						</td>
					</tr>
				</table>";
        }
    }
    $amount = $amount + 0;
    $percent = 0 + ($amount / $num * 100);
    $arr = explode(".", $percent);
    if (strlen($arr[1]) > "2") {
        $percent = $arr[0] . "." . $arr[1][0] . $arr[1][1];
    }
    
    
    // ================ ตารางแสดงกราฟของ Average ===================== //
    if($_SESSION['exam_type'] == 2){
        $amount = $_SESSION['amount'];
        $percent = $_SESSION['percent'];
        echo "	
		<table align=center width=90% cellpadding=0 cellspacing=1 border=0 bgcolor='#FFFFFF' style='border-radius:5px'>
			<tr height=40 valign=middle >
				<td width=20% align=right width=10%>$font_a <b> Average</td>
				<td width=1% align=center>$font_a  &nbsp;:&nbsp;</td>
				<td width=15% align=right bgcolor=eeeeee>$font_a <b> &nbsp; $percent% [$amount/$num]&nbsp;</td>
				<td width=64% align=left bgcolor=eeeeee>
					<img src=../2010/temp_images/icon_bar/bar_08.png height=25 width='$percent%' style='border-radius:5px'>
				</td>
			</tr>
		</table>";
    }else{
        echo "	
		<table align=center width=90% cellpadding=0 cellspacing=1 border=0 bgcolor='#FFFFFF' style='border-radius:5px'>
			<tr height=40 valign=middle >
				<td width=20% align=right width=10%>$font_a <b> Average</td>
				<td width=1% align=center>$font_a  &nbsp;:&nbsp;</td>
				<td width=15% align=right bgcolor=eeeeee>$font_a <b> &nbsp; $percent% [$amount/$num]&nbsp;</td>
				<td width=64% align=left bgcolor=eeeeee>
					<img src=../2010/temp_images/icon_bar/bar_08.png height=25 width='$percent%' style='border-radius:5px'>
				</td>
			</tr>
		</table>";
    }
    mysqli_close($conn);		
}

function display_weak_point() {
    include('../config/connection.php');
    echo "<br>";
    $result_id = $conn->real_escape_string(trim($_GET["result_id"]));

    $strSQL = "SELECT * FROM tbl_w_result_detail WHERE result_id = ? ORDER BY quiz_id";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s",$result_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->num_rows;
    $j=1;
    while($row = $result->fetch_assoc()) {
        $temp_quiz[$j] = $row['quiz_id'];
        $temp_ans[$j] = $row['ans_id'];
        $j++;
    }
    $stmt->close();
    $amount = 0;
        // ========== ตอบคำถาม/ตอบ ========= //
        for ($i = 1; $i <= $num; $i++) {
            $answer_id = trim($temp_ans[$i]);
            $quiz_id = trim($temp_quiz[$i]);
            if ($answer_id >= 1) {  //----- Answer ----//

                $ans_correct = 0;
                $msg = "SELECT * FROM tbl_answers WHERE ANSWERS_ID = ? && ANSWERS_CORRECT = ?";
                $query = $conn->prepare($msg);
                $query->bind_param("si",$answer_id,$ans_correct);
                $query->execute();
                $result = $query->get_result();
                $is_true = $result->num_rows;
                $query->close();
                
                if ($is_true == 1) {
                    $amount = $amount + 1;

                    $sql = "SELECT QUESTIONS_ID,SKILL_ID,SSKILL_ID,DETAIL_ID FROM tbl_questions WHERE QUESTIONS_ID = ?";
                    $sub_stmt = $conn->prepare($sql);
                    $sub_stmt->bind_param("s",$quiz_id);
                    $sub_stmt->execute();
                    $result = $sub_stmt->get_result();
                    $is_have = $result->num_rows;
                    
                    if ($is_have == 1) {
                        $ref_question = $result->fetch_array();
                        $check = 0;
                        for ($k = 1; $k <= $i; $k++) {
                            if ($ref_question["DETAIL_ID"] == $question_id[$k]["detail_id"] && $question_id[$k]["skill_id"] == $ref_question["SKILL_ID"]) {
                                $check = 1;
                                $k = $i + 1;
                            }
                        }
                        if ($check == 0) {
                            $question_id[$i]["quiz_id"] = $ref_question["QUESTIONS_ID"];
                            $question_id[$i]["skill_id"] = $ref_question["SKILL_ID"];
                            $question_id[$i]["sskill_id"] = $ref_question["SSKILL_ID"];
                            $question_id[$i]["detail_id"] = $ref_question["DETAIL_ID"];
                            $skill_id = $question_id[$i]["skill_id"];
                            $skill[$skill_id] = $skill[$skill_id] + 1;
                        }
                    }
                    $sub_stmt->close();
                }
            }
            if ($answer_id == 0) { //----- Un Answer ----// 
                // ========= ไม่ได้ตอบคำถาม/ไม่ได้ตอบ ==============//
                $amount = $amount + 1;

                $str = "SELECT QUESTIONS_ID,SKILL_ID,SSKILL_ID,DETAIL_ID FROM tbl_questions WHERE QUESTIONS_ID = ?";
                $sub_query = $conn->prepare($str);
                $sub_query->bind_param("s",$quiz_id);
                $sub_query->execute();
                $result = $sub_query->get_result();
                $is_have = $result->num_rows;
               
                if ($is_have == 1) {
                    $ref_question = $result->fetch_array();
                    $check = 0;
                    for ($k = 1; $k <= $i; $k++) {
                        if ($ref_question["DETAIL_ID"] == $question_id[$k]["detail_id"] && $question_id[$k]["skill_id"] == $ref_question["SKILL_ID"]) {
                            $check = 1;
                            $k = $i + 1;
                        }
                    }
                    if ($check == 0) {
                        $question_id[$i]["quiz_id"] = $ref_question["QUESTIONS_ID"];
                        $question_id[$i]["skill_id"] = $ref_question["SKILL_ID"];
                        $question_id[$i]["sskill_id"] = $ref_question["SSKILL_ID"];
                        $question_id[$i]["detail_id"] = $ref_question["DETAIL_ID"];
                        $skill_id = $question_id[$i]["skill_id"];
                        $skill[$skill_id] = $skill[$skill_id] + 1;
                    }
                }
                $sub_query->close();
            }
        }
        if (count($question_id) >= "1") {
            sort($question_id);
        }
        $count = count($question_id);
        
        $topic[1] = " <font size=2 face=tahoma color= >&nbsp;<b>Reading Comprehension</b></font> ";
        $topic[2] = " <font size=2 face=tahoma color= >&nbsp;<b>Listening Comprehension</b></font> ";
        $topic[3] = " <font size=2 face=tahoma color= >&nbsp;<b>Semi-Speaking</b></font> ";
        $topic[4] = " <font size=2 face=tahoma color= >&nbsp;<b>Semi-Writing</b></font> ";
        $topic[5] = " <font size=2 face=tahoma color= >&nbsp;<b>Grammar</b></font> ";
        $topic[6] = " <font size=2 face=tahoma color= >&nbsp;<b>Integrated Skill: Cloze Test</b></font> ";
        $topic[7] = " <font size=2 face=tahoma color= >&nbsp;<b>Vocabulary </b></font> ";
        
        // Display Form in part The Following Skills are recommended for your future practice //
        // 
        
        echo "
			<table align=center name='tb_topic_test' width=90% height=25 cellpadding=0 cellspacing=0 border=0 bgcolor='#FFFFFF' style='border-radius:5px'>
				<tr>
					<td><br><font size=2 face=tahoma color=gray><b>&nbsp;The Following Skills are recommended for your future practice</b></font><br>&nbsp;</td>
				</tr>
			</table>
			";
        
        $all_sskill = "SELECT * FROM tbl_item_sskill GROUP BY SSKILL_ID";
        $query_sskill = $conn->prepare($all_sskill);
        $query_sskill->execute();
        $result = $query_sskill->get_result();
        $sskill_num = $result->num_rows;
        $query_sskill->close();

        for ($k = 1; $k <= 7; $k++) {
            if ($skill[$k] != "") {
                // ============== Display Topic ===================== //
                echo "
					<table align=center width=90% height=25 cellpadding=0 cellspacing=0 border=0 bgcolor='#FFFFFF'>
						<tr>
							<td>$topic[$k]</td>
						</tr>
					</table>";
                    
                for ($p = 1; $p <= $sskill_num; $p++) {
                    for ($i = 0; $i < $count; $i++) {
                        if ($question_id[$i]["skill_id"] == $k && $question_id[$i]["sskill_id"] == $p) {
                            $allow = $allow + 1;
                            $sskill_id = $question_id[$i]["sskill_id"];
                            $reason_id = $question_id[$i]["detail_id"];
                            
                            $str_sskill = "SELECT * FROM tbl_item_sskill WHERE SSKILL_ID = ? GROUP BY SSKILL_ID";
                            $stmt_sskill = $conn->prepare($str_sskill);
                            $stmt_sskill->bind_param("s",$sskill_id);
                            $stmt_sskill->execute();
                            $result = $stmt_sskill->get_result();
                            $sskill_num = $result->num_rows;
                            $data_sskill = $result->fetch_array();
                            
                            $sskill_name = $data_sskill["SSKILL_NAME"];
                            $stmt_sskill->close();
                            $last[$allow] = $sskill_id;
                            
                            // จาก tb_reason เปลี่ยนเป็น tb_detail
                            $str_detail = "SELECT * FROM tbl_item_detail WHERE DETAIL_ID = ? GROUP BY DETAIL_ID";
                            $stmt_detail = $conn->prepare($str_detail);
                            $stmt_detail->bind_param("s",$reason_id);
                            $stmt_detail->execute();
                            $result = $stmt_detail->get_result();
                            $data_detail = $result->fetch_array();
                            $reason_name = $data_detail["DETAIL_NAME"];
                            $stmt_detail->close();
                            if ($last[$allow - 1] == $sskill_id) {
                                $sskill_name = "";
                            }
                            // ==================== แสดง Topic ฝั่งขวาที่ตัวอักษรเป็นสีแสดง ================== //
                            echo "
								<table align=center width=90% cellpadding=0 cellspacing=0 border=0 bgcolor=#FFFFFF style='border-bottom-right-radius:5px;border-bottom-left-radius:5px'>
									<tr valign=top>
										<td align=left width=30%>&nbsp;<font size=2 color=gray face=tahoma><b>$sskill_name</b></font></td>
										<td align=center><font size=2 color=gray face=tahoma><b>&nbsp;:&nbsp;&nbsp;</b></font></td>
										<td align=left width=70%>
											<a href=elearning_switch.php?reason_id=$reason_id&&skill_id=" . $question_id[$i]["skill_id"] . " target=_blank>	
												<font size=2 color=red face=tahoma><b>$reason_name</b></font>
											</a>
										</td>
									</tr>
								</table>";
                        }
                    }
                }
                echo "<br>";
            }
        }
        mysqli_close($conn);
}

function display_a_test_detail() {
    include('../config/connection.php');
    $result_id = $conn->real_escape_string(trim($_GET["result_id"]));
    //-----------------------------------------------------------//
    $strSQL = "SELECT member_id,etest_id FROM tbl_w_result WHERE result_id = ? ";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s",$result_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $sub_num = $result->num_rows;
    
    if ($sub_num == 1) {
        $sub_data = $result->fetch_array();
        $member_id = trim($sub_data['member_id']);
        $etest_id = trim($sub_data['etest_id']);
    }
    $stmt->close();
    if ($etest_id != 0) {// check is eolcontest ****
        $exam_type = 2;
        $sql = "SELECT * FROM tbl_eventest WHERE exam_id = ? && exam_type = ?";
        $query = $conn->prepare($sql);
        $query->bind_param("si",$etest_id,$exam_type);
        $query->execute();
        $result = $query->get_result();
        $dataexam = $result->num_rows;
        $query->close();
    }
    if ($dataexam >= 1) { // exam contest
        detail_eolcontest_exam_custom();
    } else {
        //-----------------------------------------------------------//
        
        $msg = "SELECT * FROM tbl_w_result_detail WHERE result_id = ? ORDER BY ans_id ASC";
        $sub_stmt = $conn->prepare($msg);
        $sub_stmt->bind_param("s",$result_id);
        $sub_stmt->execute();
        $result = $sub_stmt->get_result();
        $num = $result->num_rows;
        $j=1;
        while($row = $result->fetch_assoc()) {
            $temp_quiz[$j] = $row['quiz_id'];
            $temp_ans[$j] = $row['ans_id'];
            $j++;
        }
        $sub_stmt->close();
        if ($num >= 1) {
            for ($i = 1; $i <= $num; $i++) {
                $quiz_id[$i] = trim($temp_quiz[$i]);
                $ans_id[$i] = trim($temp_ans[$i]);
                
                $str = "SELECT * FROM tbl_questions WHERE QUESTIONS_ID = ?";
                $sub_str = $conn->prepare($str);
                $sub_str->bind_param("s",$quiz_id[$i]);
                $sub_str->execute();
                $result = $sub_str->get_result();
                $q_num = $result->num_rows;
                if ($q_num == 1) {
                    $q_data = $result->fetch_array();
                    $quiz_text[$i] = $q_data["QUESTIONS_TEXT"];
                    $reason_id[$i] = $q_data["DETAIL_ID"];
                    $skill_id[$i] = $q_data["SKILL_ID"];
                    
                    $r_table = "SELECT * FROM tbl_item_detail WHERE DETAIL_ID = ? GROUP BY DETAIL_ID";
                    $str_reason = $conn->prepare($r_table);
                    $str_reason->bind_param("s",$reason_id[$i]);
                    $str_reason->execute();
                    $result = $str_reason->get_result();
                    $r_num = $result->num_rows;
                    if ($r_num == 1) {
                        $r_data = $result->fetch_array();
                        $reason_text[$i] = $r_data["DETAIL_NAME"];
                    }
                    $str_reason->close();
                }
                $sub_str->close();
                
                $quiz_map = "SELECT * FROM tbl_questions_mapping WHERE QUESTIONS_ID = ?";
                $str_quiz_map = $conn->prepare($quiz_map);
                $str_quiz_map->bind_param("s",$quiz_id[$i]);
                $str_quiz_map->execute();
                $result = $str_quiz_map->get_result();
                $quiz_num = $result->num_rows;
                if ($quiz_num == 1) {
                    $quiz_data = $result->fetch_array();
                    $relate_id[$i] = $quiz_data["GQUESTION_ID"];
                    
                    // change name from tb_relate_data to tb_questions_relate
                    
                    $tb_relate = "SELECT * FROM tbl_gquestion WHERE GQUESTION_ID = ? ";
                    $str_relate = $conn->prepare($tb_relate);
                    $str_relate->bind_param("s",$relate_id[$i]);
                    $str_relate->execute();
                    $result = $str_relate->get_result();
                    $relate_num = $result->num_rows;
                    if ($relate_num == 1) {
                        $retale_data = $result->fetch_array();
                        $relate_type[$i] = $retale_data["GQUESTION_TYPE_ID"];
                        $relate_text[$i] = $retale_data["GQUESTION_TEXT"];
                        if ($relate_type[$i] == 1) {
                            $relate_text[$i] = "<font size=2 face=Verdana>" . $relate_text[$i] . "</font>";
                        }
                        if ($relate_type[$i] == 2) {
                            $relate_text[$i] = str_replace("/home/engtest/domains/engtest.net/public_html/", "", $relate_text[$i]);
                            $relate_text[$i] = "<img src='$relate_text[$i]' width=300 border=5 style=\"border-color: eeeeee\">";
                        }
                        if ($relate_type[$i] == 3) {
                            if (is_mobile()) {
                                $relate_text[$i] = str_replace("https://www.engtest.net/files/sound/", "", $relate_text[$i]);
                                $relate_text[$i] = str_replace(".flv", ".mp3", $relate_text[$i]);
                                $relate_text[$i] = "<div align=center>
														<br>
														    <audio controls='controls' preload='none'> 
                                                                <source src='https://www.engtest.net/files/sound/" . $relate_text[$i] . "'>  
                                                            </audio>
														<br>
													</div>";
                            } else {
                                $relate_text[$i] = str_replace("https://www.engtest.net/files/sound/", "", $relate_text[$i]);
                                $relate_text[$i] = str_replace(".flv", ".mp3", $relate_text[$i]);
                                $relate_text[$i] = '<audio controls="controls" preload="none"> 
										                <source src="https://www.engtest.net/files/sound/' . $relate_text[$i] . '">  
										            </audio>';
                            }
                        }
                       
                    }
                    $str_relate->close();
                }
                $str_quiz_map->close();
                
                $tb_ans = "SELECT * FROM tbl_answers WHERE QUESTIONS_ID = ? ORDER BY ANSWERS_ID ASC";
                $str_ans = $conn->prepare($tb_ans);
                $str_ans->bind_param("s",$quiz_id[$i]);
                $str_ans->execute();
                $result = $str_ans->get_result();
                $ans_num = $result->num_rows;
                
                if ($ans_num >= 1) {
                    $ans_msg_b[$i] = "";
                    $correct[$i] = "0";
                    for ($k = 1; $k <= $ans_num; $k++) {
                        $ans_data = $result->fetch_array();
                        $ans["text"][$i][$k] = $k . ".&nbsp;&nbsp;" . $ans_data["ANSWERS_TEXT"];
                        $ans["id"][$i][$k] = $ans_data["ANSWERS_ID"];
                        $ans["correct"][$i][$k] = $ans_data["ANSWERS_CORRECT"];
                        if ($ans_id[$i] == $ans["id"][$i][$k]) {
                            $ans["text"][$i][$k] = "<font color=orange><b>" . $ans["text"][$i][$k] . "</b></font>";
                            $ans_msg_a[$i] = "Your answer is $k. ";
                        }
                        // ============= แสดงข้อความข้างล่างหลังจากที่ตอบถูก ===============//
                        if ($ans_id[$i] == $ans["id"][$i][$k] && $ans["correct"][$i][$k] == "1") {
                            $ans_msg_b[$i] = "<font color=green size=2>It's a correct answer.</font>";
                            $correct[$i] = "1";
                        }
                    }
                    // ============= แสดงข้อความข้างล่างหลังจากที่ตอบผิด ===============//
                    if (!$ans_msg_b[$i]) {
                        $ans_msg_b[$i] = "<font color=red size=2>It's an incorrect answer.</font>";
                    }
                    // ============= แสดงข้อความข้างล่างหลังจากที่ไม่ได้ตอบคำถาม ===============//
                    if (!$ans_msg_a[$i]) {
                        $ans_msg_a[$i] = "<font color=blue size=2>It's unanswered</font>";
                    }
                }
                $str_ans->close();
            }
            //---------------------------- Display -------------------------------//
            //================== แสดงในส่วนของ Check Your answers =================//
            //--------------------------------------------------------------------//
            for ($i = 1; $i <= $num; $i++) {
                echo "
					<table width=90% align=center border=0 cellpadding=0 cellspacing=0 bgcolor=#DBDBDB style='border-radius: 10px;'>
						<tr height=10><td rowspan=6>&nbsp;&nbsp;</td><td colspan=2></td><td rowspan=5>&nbsp;&nbsp;</td></tr>";

                if ($relate_id[$i]) {
                    if ($relate_type[$i] == "1") {
                        $align = "align=left";
                    } else {
                        $align = "align=center";
                    }
                    echo "			
						<tr>
							<td width=100% colspan=2 $align>$relate_text[$i]<br>&nbsp;</td>
						</tr>";
                }
                echo "
					<tr valign=top height=25>
						<td width=5% rowspan=3 align=center><font size=2 face=Verdana><b>$i.</b></font></td>
						<td width=95%><font size=2 face=Verdana>$quiz_text[$i]</font></td>
					</tr>
					<tr>
						<td>
							<table align=center width=100% cellpadding=0 cellspacing=0 border=0>
								<tr>
									<td width=75%>
										<font size=2 face=Verdana>";

                for ($k = 1; $k <= 4; $k++) {
                    echo $ans["text"][$i][$k] . "<br>";
                }
                
                echo "<br><b><font color=blue size=2>" . $ans_msg_a[$i] . "</font>&nbsp;" . $ans_msg_b[$i] . "</b>";
                echo "
										</font>
									</td>
									<td width=25% align=center>";
                                    
                // ========================== กรณีตอบถูกให้แสดงรูปต่อไปนี้ อยู่ฝั่งขวา ========================= //
                if ($correct[$i] == "1") {
                    echo "<img src=../2010/temp_images/icon_correct.jpg border=0 style='border-radius:10px;margin-left:35px;'>";
                }
                // ========================== กรณีตอบผิดให้แสดงรูปต่อไปนี้ ยู่ฝั่งขวา ========================= //
                if ($correct[$i] == "0") {
                    echo "<img src=../2010/temp_images/icon_incorrect.jpg border=0 style='border-radius:10px;margin-left:35px;'>";
                }
                    echo "		
									</td>
								</tr>
							</table>
						</td>
					</tr>";
                
                echo "			
					<tr>
						<td align=left>
                            <table align=center width=100% cellspacing=0 cellpadding=0 border=0>
                                <tr>
                                    <td align=left width=80%><font face=Verdana color=brown size=2 ><b>Tip : $reason_text[$i]</font></b></td>
									<td align=center width=20%>
                                        <a target=_blank href='elearning_switch.php?reason_id=$reason_id[$i]&&skill_id=$skill_id[$i]'>
										<b><font face=verdana color=green size=2>&raquo; Go to Lessons &laquo;</font></b></a>
                                    </td>
								</tr>";
                                
                
                $tb_des = "SELECT * FROM tbl_description WHERE QUESTIONS_ID = ?";
                $str_des = $conn->prepare($tb_des);
                $str_des->bind_param("s",$quiz_id[$i]);
                $str_des->execute();
                $result = $str_des->get_result();
                $is_des = $result->num_rows;
                if ($is_des == 1) {
                    $des_data = $result->fetch_array();
                    echo "
						    <tr height=10><td colspan=2></td></tr>
						    <tr >
						    	<td align=left width=80% ><font face=Verdana color='#e400e0' size=2 ><b>Description : </font></b></td>
						    	<td align=right width=20%>&nbsp;</td>
						    </tr>
						    <tr > 
						    	<td colspan=2 width=100% >
						    		<font size=2 face=tahoma color='#e400e0'>$des_data[TEXT]</font>
						    	</td>
						    </tr>";
                }
                $str_des->close();
                    echo "
							<tr height=25><td colspan=2 align=center></td></tr>		
							<tr height=25>
								<td colspan=2 align=right>
									<table id='box_a_$quiz_id[$i]' cellpadding=0 cellspacing=0 border=0 style=\"cursor:pointer\" 
											onclick=\"javascript:
														document.getElementById('box_a_$quiz_id[$i]').style.display='none';
														document.getElementById('box_b_$quiz_id[$i]').style.display='';
													\">
										<tr valign=middle>
											<td align=right>
												<font size=2 face=tahoma color=black align=right><b>&laquo; Ask Our academics &raquo;</b></font>
												&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
										</tr>
									</table>
									<table id='box_b_$quiz_id[$i]' width=50% cellpadding=0 cellspacing=0 border=0 style=\"display:none;\" >
										<tr>
											<td align=right colspan=3 >
												<table cellpadding=0 cellspacing=0 border=0 style=\"cursor:pointer\" 
														onclick=\"javascript:
																	document.getElementById('box_a_$quiz_id[$i]').style.display='';
																	document.getElementById('box_b_$quiz_id[$i]').style.display='none';
																\">
													<tr valign=middle>
														<td align=right>
															<font size=2 face=tahoma color=gray><b>&raquo; Ask our academics &laquo;</b></font>
															&nbsp;&nbsp;&nbsp;&nbsp;
														</td>
													</tr>
												</table>
											</td>
                                        </tr>
                                        <form action='?section=$_GET[section]&&action=$_GET[action]&&report_section=$_GET[report_section]&&member_id=$member_id&&result_id=$_GET[result_id]&&type=4&&sub_action=comment' method=post target=_blank>
                                            <input type=hidden name='member_id' value='$member_id'>
                                            <input type=hidden name='quiz_id' value='$quiz_id[$i]'>
                                            <tr height=10><td colspan=3></td></tr>
                                            <tr height=10 bgcolor='#d0d0d0'><td colspan=3></td></tr>
                                            <tr bgcolor='#d0d0d0'>
                                                <td width=20% align=right><font size=2 face=tahoma><b>Message</b></font></td>
                                                <td width=5%><font size=2 face=tahoma><b>&nbsp;:&nbsp;</b></font></td>
                                                <td width=75%><textarea name='text' style=\"width:270px; height:50px;\" required></textarea></td>
                                            </tr>
                                            <tr bgcolor='#d0d0d0' height=25>
                                                <td >&nbsp;</td>
                                                <td >&nbsp;</td>
                                                <td align=left>
                                                    <font size=2 face=tahoma color='brown'>Your message will be sent to our academicians.</font>
                                                </td>
                                            </tr>
                                            <tr height=35 bgcolor='#d0d0d0'>
                                                <td >&nbsp;</td>
                                                <td >&nbsp;</td>
                                                <td ><input type=submit value=' Send Message ' class='send-message'></td>
                                            </tr>
                                        </form>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
                <tr height=10>
                    <td></td>
                </tr>
			</table><br>";
            }
        }
    }
    mysqli_close($conn);
}

function detail_eolcontest_exam_custom(){
    include('../config/connection.php');
    $result_id = $conn->real_escape_string(trim($_GET['result_id']));
    $SQL = "SELECT *  FROM  tbl_w_result_detail 
			INNER JOIN tbl_eventest_question_custom  ON tbl_eventest_question_custom.question_id = tbl_w_result_detail.quiz_id 
			WHERE  tbl_w_result_detail.result_id = ?";
   
    $stmt = $conn->prepare($SQL);
    $stmt->bind_param("s",$result_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $i = 1;
    while ($result_row = $result->fetch_assoc()) {
        echo "
        <table width=90% align=center border=0 cellpadding=0 cellspacing=0 bgcolor=#DBDBDB style='border-radius:10px;padding:10px;'>
            <tr valign=top height=25>
                <td width=2% align=center><font size=2 face=Verdana><b>$i.</b></font></td>
                <td width=98%><font size=2 face=Verdana>$result_row[question_text]</font></td>
            </tr>";
            
        $strSQL = 'SELECT * FROM tbl_eventest_answer WHERE question_id = ?';
        $query = $conn->prepare($strSQL);
        $query->bind_param("s",$result_row['quiz_id']);
        $query->execute();
        $result_ans = $query->get_result();
        $img = '<img src=../2010/temp_images/icon_incorrect.jpg border=0 style="border-radius:10px;margin-left:35px;">  ';
        $msg_ans = "<font color=red size=2>It's an incorrect answer.</font>";
        while ($sub_row = $result_ans->fetch_assoc()) {
            if ($result_row['ans_id'] == $sub_row['answer_id'] && $sub_row['answer']) {
                $img = '<img src=../2010/temp_images/icon_correct.jpg border=0 style="border-radius:10px;margin-left:35px;" > ';
                $select = 'checked';
                $msg_ans = "<font color=green size=2>It's a correct answer.</font>";
            } elseif ($result_row['ans_id'] == $sub_row['answer_id']) {
                $select = 'checked';
            } else {
                $select = '';
            }
            echo '<tr>
                    <td width=2%></td>
                    <td width=98%>
                        <table align=center width=100% cellpadding=0 cellspacing=0 border=0>
                            <tr>
                                <td width=75%>';
            echo '<input type="radio" name="select', $result_row['ans_id'], '[]" ', $select, '>', $sub_row['answer_text'];
            echo "		
							    </td>   
							</tr>
						</table>
                    </td>
                </tr>";
        }
        echo '<tr height=15></tr>';
        echo '<tr><td width=2%></td><td width=98%>',$msg_ans,'</td></tr>';
        echo '<tr height=10></tr>';
        echo '<tr><td>',$img, '</td>
        </tr></table>';
        echo '<br>';
        $i++;
    }
    $query->close();
    $stmt->close();
    mysqli_close($conn);
}

function display_a_view_group() {
    include('../config/connection.php');
    //-----------------------------------------------------------------------------//
    $allow = check_sub_account($_SESSION["x_member_id"], $_GET["member_id"]);
    if ($allow == "true") {
        $member_id = $conn->real_escape_string(trim($_GET["member_id"]));
        $link_ref_member = "&&member_id=$member_id";
        $focus_member_id = $conn->real_escape_string(trim($_GET["member_id"]));
    }else{
        $focus_member_id = $conn->real_escape_string($_SESSION["x_member_id"]);
    }
    //-----------------------------------------------------------------------------//
    
    $result_id = $conn->real_escape_string($_GET["result_id"]);
    if (!$_POST["start"] || !$_POST["stop"]) {
        $start = date("Y-m-d", time() - ( 60 * 60 * 24 * 30 ));
        $stop = date("Y-m-d", time() + ( 60 * 60 * 24 * 1 ));
    }
    /*  if select form and until date    */
    if ($_POST["start"] && $_POST["stop"]) {
        $start = $_POST["start"];
        $stop = $_POST["stop"];
    }
    
    //-----------------------------------------------------//
    
    $tb_sub = "SELECT * FROM tbl_x_member_sub WHERE sub_id = ?";
    $str_sub = $conn->prepare($tb_sub);
    $str_sub->bind_param("s",$focus_member_id);
    $str_sub->execute();
    $result = $str_sub->get_result();
    $is_co = $result->num_rows;

    //is Corporate 
    if ($_POST["group"] == 1) {
        if ($is_co == 1) {
            $co_data = $result->fetch_array();
            $co_master_id = $co_data["master_id"];

            $tb_x_sub = "SELECT * FROM tbl_x_member_sub WHERE master_id = ?";
            $str_x_sub = $conn->prepare($tb_x_sub);
            $str_x_sub->bind_param("s",$co_master_id);
            $str_x_sub->execute();
            $result = $str_x_sub->get_result();
            $all_member_num = $result->num_rows;
            
            $j=1;
            while($row = $result->fetch_assoc()) {
                $temp_sub[$j] = $row['sub_id'];
                $j++;
            }

            $co_event = "";
            if ($all_member_num >= 1) {
                for ($i = 1; $i <= $all_member_num; $i++) {
                    $co_member_list = $temp_sub[$i];
                    if ($i != $all_member_num) {
                        $co_event = $co_event . " member_id='$co_member_list' || ";
                    }
                    if ($i == $all_member_num) {
                        $co_event = $co_event . " member_id='$co_member_list' ";
                    }
                }
                $co_event = " ( " . $co_event . " ) && ";
            }
        }
    }
    $str_sub->close();
    //-----------------------------------------------------//
    
    $tb_result = "SELECT * FROM tbl_w_result WHERE $co_event result_id = ?";
    $str_result = $conn->prepare($tb_result);
    $str_result->bind_param("s",$result_id);
    $str_result->execute();
    $result = $str_result->get_result();
    $num = $result->num_rows;
    if ($num == 1) {
        $data = $result->fetch_array();
        $mem_id = $data["member_id"];
        $etest_id = $data["etest_id"];
        $skill_id = $data["skill_id"];
        $level_id = $data["level_id"];
        
        $font = "<font size=2 face=tahoma color=black><b>";
        echo "
				<link rel=\"stylesheet\" type=\"text/css\" href=\"../calendar/epoch_styles.css\" />
				<script type=\"text/javascript\" src=\"../calendar/epoch_classes.js\"></script>
				<script type=\"text/javascript\">
				/*You can also place this code in a separate file and link to it like epoch_classes.js*/
					var bas_cal,dp_cal,ms_cal,a,b;      
				window.onload = function () {
					a  = new Epoch('epoch_popup','popup',document.getElementById('popup_container_a'));
					b  = new Epoch('epoch_popup','popup',document.getElementById('popup_container_b'));
					//ms_cal  = new Epoch('epoch_multi','flat',document.getElementById('multi_container'),true);
				};
				</script>
				<!-- ----------------------------------------------------- -->			
				<table width=90% align=center cellpadding=0 cellspacing=0 border=0 bgcolor=dddddd style='border-radius:10px'>
					<form method='post' id='placeholder' action='?section=$_GET[section]&&action=$_GET[action]&&report_section=$_GET[report_section]$link_ref_member&&result_id=$_GET[result_id]&&type=$_GET[type]'>
					<tr><td height=10></td></tr>
					<tr>
						<td width=30% align=center>$font From : <input id='popup_container_a' type=text name=start value='$start' size=15 style='height:22px;border-radius:8px;border:1px solid #bbb2ae'></td>
						<td width=30% align=center>$font Until : <input id='popup_container_b' type=text name=stop value='$stop' size=15 style='height:22px;border-radius:8px;border:1px solid #bbb2ae'></td>";

        if ($is_co == 1) {
            if ($_POST["group"] == "1") {
                $check = "checked";
            }
            echo "<td width=20% align=center>$font <input type=checkbox name=group value='1' $check> Corporate Member </td>";
        }
            echo "
						<td width=20% align=center>
							<input type=submit value='&nbsp;Search&nbsp;' class='btn-contest-search'><br>
							<font size=2 face=tahoma color=red>Ex. 2010-12-31</font>
						</td>
					</tr>
					<tr><td height=10></td></tr>
				</form>
			</table>";
       
        $tb_w_result = "SELECT * FROM tbl_w_result WHERE $co_event etest_id = ? && level_id = ? && skill_id = ? && create_date >= ? && create_date <= ? ORDER BY result_id ASC ";
        $str_x_result = $conn->prepare($tb_w_result);
        $str_x_result->bind_param("sssss",$etest_id,$level_id,$skill_id,$start,$stop);
        $str_x_result->execute();
        $result = $str_x_result->get_result();
        $result_num = $result->num_rows;

        $j=1;
        while($row = $result->fetch_assoc()) {
            $temp_member[$j] = $row['member_id'];
            $temp_result[$j] = $row['result_id'];
            $temp_percent[$j] = $row['percent'];
            $j++;
        }
        $str_x_result->close();
        
        if ($result_num >= 1) {
            $sum_percent = 0;
            $min = 100;
            $max = 0;

            // ============ ตารางแสดง Ranking ของแต่ละบุคคล ============ //
            // ================ Total Result Amount ================== //
            
            echo "
                <br>
				<table align=center width=40% cellpadding=0 cellspacing=0 border=0 style='border-radius:10px; background:#f0f0f0;'>
					<tr height=50>
						<td align=center><font size=3 face=tahoma ><b>Total Result Amount : $result_num </b></font></td>
					</tr>
				</table>";
                
            for ($i = 1; $i <= $result_num; $i++) {
                $amount = 0;
                $member_id_list = $temp_member[$i];
                $all_result_id = $temp_result[$i];
                $percent = $temp_percent[$i];
        
                //-------------------------------------------------------------//
                //-------------------------------------------------------------//
                if ($percent == 0) {
                    $rank[0] = $rank[0] + 1;
                }
                if ($percent >= 1 && $percent <= 10) {
                    $rank[1] = $rank[1] + 1;
                }
                if ($percent > 10 && $percent <= 20) {
                    $rank[2] = $rank[2] + 1;
                }
                if ($percent > 20 && $percent <= 30) {
                    $rank[3] = $rank[3] + 1;
                }
                if ($percent > 30 && $percent <= 40) {
                    $rank[4] = $rank[4] + 1;
                }
                if ($percent > 40 && $percent <= 50) {
                    $rank[5] = $rank[5] + 1;
                }
                if ($percent > 50 && $percent <= 60) {
                    $rank[6] = $rank[6] + 1;
                }
                if ($percent > 60 && $percent <= 70) {
                    $rank[7] = $rank[7] + 1;
                }
                if ($percent > 70 && $percent <= 80) {
                    $rank[8] = $rank[8] + 1;
                }
                if ($percent > 80 && $percent <= 90) {
                    $rank[9] = $rank[9] + 1;
                }
                if ($percent > 90 && $percent <= 100) {
                    $rank[10] = $rank[10] + 1;
                }
                //-----------------------------------------//
                if ($min >= $percent) {
                    $min = $percent;
                }
                if ($max <= $percent) {
                    $max = $percent;
                }
                $sum_percent = $sum_percent + $percent;
                
                //--------------------- Order for sort --------------------//
                
                if ($data_list['most'][$member_id_list] <= $percent) {
                    $data_list['most'][$member_id_list] = $percent;
                }
                if ($data_list['most'][$member_id_list]) {
                    $data_list['amount'][$member_id_list] = $data_list['amount'][$member_id_list] + 1;
                }
            }
            //------------ Sort By Percent : Max -> Min  ------------------//
            
            arsort($data_list['most']);
            
            $loop = 1;
            foreach ($data_list['most'] as $member_ref_id => $each_max_percent) {
                $order_data_list['percent'][$loop] = $each_max_percent;
                $order_data_list['member_id'][$loop] = $member_ref_id;
                $order_data_list['amount'][$loop] = $data_list['amount'][$member_ref_id];
                $loop++;
            }
            //----------------------------------------------------------------//
            for ($r = 0; $r <= 10; $r++) {
                $rank_percent[$r] = 100 * ( $rank[$r] / $result_num );
                $arr = explode(".", $rank_percent[$r]);
                if (strlen($arr[1]) > "2") {
                    $rank_percent[$r] = $arr[0] . "." . $arr[1][0] . $arr[1][1];
                }
                $total_percent = $total_percent + $rank_percent[$r];
            }
           
            $total_percent = $sum_percent / $result_num;
            $arr = explode(".", $total_percent);
            if (strlen($arr[1]) > "2") {
                $total_percent = $arr[0] . "." . $arr[1][0] . $arr[1][1];
            }
            
            $period[0] = "00 %";
            $period[1] = "00 - 10 %&nbsp;";
            $period[2] = "10 - 20 %&nbsp;";
            $period[3] = "20 - 30 %&nbsp;";
            $period[4] = "30 - 40 %&nbsp;";
            $period[5] = "40 - 50 %&nbsp;";
            $period[6] = "50 - 60 %&nbsp;";
            $period[7] = "60 - 70 %&nbsp;";
            $period[8] = "70 - 80 %&nbsp;";
            $period[9] = "80 - 90 %&nbsp;";
            $period[10] = "90 - 100 %";
            $rand_num = rand(1, 8);
            
            // ============= ตารางแสดง Ranking ของแต่ละบุคคล ============== //
            // ==== ตารางแสดง Period (%), Amount (Times), Ratio (%)  ==== //
            echo "
					<table align=center width=80% cellpadding=0 cellspacing=1 border=0>
						<tr height=25><td colspan=4></td></tr>
						<tr height=25>
							<td align=center width=15%>
								<font size=2 face=tahoma color=Black><b>Period (%)</b></font>
							</td>
							<td align=center width=15%>
								<font size=2 face=tahoma color=Black><b>Amount (Times)</b></font>
							</td>
							<td align=center width=55%>
								<font size=2 face=tahoma color=Black><b>&nbsp;</b></font>
							</td>
							<td align=center width=15%>
								<font size=2 face=tahoma color=Black><b>Ratio (%)</b></font>
							</td>
						</tr>
						<tr height=5><td colspan=4></td></tr>";
                        
            for ($i = 0; $i <= 10; $i++) {
                echo "
						<tr height=30>
							<td align=center width=15% bgcolor='#d7d7d7'>
								<font size=2 face=tahoma color=Black><b>$period[$i]</b></font>
							</td>
							<td align=center width=20% bgcolor='#f0f0f0'>
								<font size=2 face=tahoma color=Black><b>" . ($rank[$i] + 0) . "</b></font>
							</td>
							<td align=left width=50% bgcolor='#f7f7f7'>
								<img src='../2010/temp_images/icon_bar/bar_0" . $rand_num . ".png' height='25' width='" . $rank_percent[$i] . "%' style='margin-top:4px; border-radius:4px;'>
							</td>
							<td align=center width=15% bgcolor='#f0f0f0'>
								<font size=2 face=tahoma color=Black><b>$rank_percent[$i] %</b></font>
							</td>
						</tr>";
            }
            
            // ============ ตารางแสดง Ranking ของแต่ละบุคคล ============= //
            // ================== Min, Max, Average =================== //
            
            echo "
						<tr height=25><td colspan=4></td></tr>
						<tr height=25>
							<td align=center colspan=2>&nbsp;</td>
							<td align=center colspan=2 bgcolor='#f0f0f0' style='border-radius:10px'>
                                <font size=2 face=tahoma >
                                    <b>
								        <font color=blue> Min  : $min %  </font>
								        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								        <font color=red> Max  : $max %  </font>
								        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								        <font color=green> Average :  $total_percent % </font>
								    </b>
                                </font>
							</td>
						</tr>
						<tr height=25><td colspan=4></td></tr>
					</table>";
            
            // =========== ตารางแสดง Ranking ของแต่ละบุคคล ============ //
            // ============= แสดงในส่วนของอันดับ Ranking =============== //
           
            echo "
					<table align=center width=80% cellpadding=0 cellspacing=1 border=0>
						<tr height=40 bgcolor='#d0d0d0'>
							<td align=center width=10%><font size=2 face=tahoma color=black><b>No.</b></font></td>
							<td align=left width=25%>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=2 face=tahoma color=black><b>First Name</b></font></td>
							<td align=left width=25%>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=2 face=tahoma color=black><b>Last Name</b></font></td>
							<td align=center width=20%><font size=2 face=tahoma color=black><b>Highest Percent</b></font></td>
                            <td align=center width=20%><font size=2 face=tahoma color=black><b>Result Amount</b></font></td>
                        </tr>";
                        
            $count = count($order_data_list['percent']);
            $loop = 0;
            for ($i = 1; $i <= $count; $i++) {
                $loop++;
                if ($order_data_list['percent'][$i] == $order_data_list['percent'][$i - 1]) {
                    $loop--;
                    $order = $loop;
                } else {
                    $loop = $i;
                    $order = $loop;
                }

                $mem_id = $order_data_list['member_id'][$i];
                $tb_member = "SELECT * FROM tbl_x_member WHERE member_id = ?";
                $str_member = $conn->prepare($tb_member);
                $str_member->bind_param("s",$mem_id);
                $str_member->execute();
                $result = $str_member->get_result();
                $is_member = $result->num_rows;
                if ($is_member == 1) {
                    $member_data = $result->fetch_array();
                    $fname = $member_data['fname'];
                    $lname = $member_data['lname'];
                }
                if ($i % 2 == 1) {
                    $color = "#f7f7f7";
                } else {
                    $color = "#f0f0f0";
                }
                if ($order_data_list['member_id'][$i] == $focus_member_id) {
                    $color = "#ffd0ff";
                }
                echo "
					<tr height=25 bgcolor='$color'>
						<td align=center ><font size=2 face=tahoma color=black><b>$order</b></font></td>
						<td align=left >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=2 face=tahoma color=black><b>" . $fname . "</b></font></td>
						<td align=left >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=2 face=tahoma color=black><b>" . $lname . "</b></font></td>
						<td align=right ><font size=2 face=tahoma color=black><b>" . $order_data_list['percent'][$i] . " % </b></font>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td align=center ><font size=2 face=tahoma color=black><b>" . $order_data_list['amount'][$i] . "</b></font></td>
					</tr>";
            }
            echo "</table><br><br>&nbsp;";
        } else {
            
            // ============ ตารางแสดง Ranking ของแต่ละบุคคล ============= //
            // =================== ในกรณีที่หาไม่เจอ ====================== //
            echo "
				<table align=center width=50% cellpadding=0 cellspacing=0 border=0>
					<tr height=100>
						<td align=center><font size=2 face=tahoma color=red> - No Data List - </font></td>
					</tr>
				</table>";
        }
    }
    $str_result->close();
    mysqli_close($conn);
}

function report_stest_list() {
    include('../config/connection.php');
    include('../config/format_time.php');
    $allow = check_sub_account($_SESSION["x_member_id"], $_GET["member_id"]);
    //-----------------------------------------------------------------------//
    if ($allow == "true") {
        $member_id = $conn->real_escape_string(trim($_GET['member_id']));
        $link_ref_member = "&&member_id=$member_id";
        $focus_member_id = $member_id;
    }
    if ($allow == "false") {
        $focus_member_id = $_SESSION["x_member_id"];
    }
    if (!$_POST["start"]) {
        $start = date("Y-m-d", time() - ( 60 * 60 * 24 * 30 ));
    } else {
        $start = $_POST["start"];
    }
    if (!$_POST["stop"]) {
        $stop = date("Y-m-d", time() + ( 60 * 60 * 24 * 1 ));
    } else {
        $stop = $_POST["stop"];
    }
   
    //--------------------------------------------------------------------------//
   
    $is_est = 1;
    $tb_etest = "SELECT * FROM tbl_etest WHERE IS_EST = ? ORDER BY ETEST_ID";
    $str_etest = $conn->prepare($tb_etest);
    $str_etest->bind_param("i",$is_est);
    $str_etest->execute();
    $result = $str_etest->get_result();
    $rows = $result->num_rows;
   
    if ($rows >= 1) {
        $i = 1;
        while($data = $result->fetch_assoc()) {
            $etest_id = $data['ETEST_ID'];
            if ($i != $rows) {
                $event_msg = $event_msg . " ETEST_ID='$etest_id' || ";
            } else {
                $event_msg = $event_msg . " ETEST_ID='$etest_id' ";
            }
            $i++;
        }
        
        $event_msg = " && ( " . $event_msg . " ) ";

        $tb_rsult = "SELECT result_id,percent,create_date FROM tbl_w_result_est WHERE create_date >= ? && create_date <= ? && member_id = ? $event_msg ORDER BY create_date DESC";
        $str_result = $conn->prepare($tb_rsult);
        $str_result->bind_param("ssi",$start,$stop,$focus_member_id);
        $str_result->execute();
        $result = $str_result->get_result();
        $num = $result->num_rows;

        echo "          
            <link rel=\"stylesheet\" type=\"text/css\" href=\"../calendar/epoch_styles.css\" />
            <script type=\"text/javascript\" src=\"../calendar/epoch_classes.js\"></script>
            <script type=\"text/javascript\">
                /*You can also place this code in a separate file and link to it like epoch_classes.js*/
                    var a,b;      
                window.onload = function () {
                    a  = new Epoch('epoch_popup','popup',document.getElementById('popup_eolstandard_a'));
                    b  = new Epoch('epoch_popup','popup',document.getElementById('popup_eolstandard_b'));
                };
            </script>  
            <map name='Back' id='Back'>
                <area shape='rect' coords='720,286,978,377' href='?section=$_GET[section]&&action=$_GET[action]$link_ref_member' />
            </map>
            <img src='../images/image2/eol system/Report/report-standard-test.png' width='99%' usemap='#Back' style='border-radius:10px;'>
            <br>
            <table align=center width=60% bgcolor='#827f7beb' cellpadding=0 cellspacing=0 border=0 style='position:absolute;top:600px;left:62%;margin-left:-400px;border-radius: 10px;'>
                <form method=post  id='placeholder' 
                action='?section=$_GET[section]&&action=$_GET[action]$link_ref_member&&report_section=$_GET[report_section]'>   
                    <tr height=50 valign=middle>
                        <td align=right width=13%><font size=2 face=tahoma color=black><b>From &nbsp; : &nbsp;</b></font></td>
                        <td align=left width=27%>&nbsp;<input id='popup_eolstandard_a' type=text name=start value='$start' size=16 style='height:22px;border-radius:8px;border:1px solid #bbb2ae;'></td>
                        <td align=right width=13%><font size=2 face=tahoma color=black><b>Until &nbsp; : &nbsp;</b></font></td>
                        <td align=left width=27%>&nbsp;<input id='popup_eolstandard_b' type=text name=stop value='$stop' size=16 style='height:22px;border-radius:8px;border:1px solid #bbb2ae;'></td>
                        <td align=left width=15% ><input type='submit' name='veiw' value='&nbsp; View &nbsp;' class='btn-view'></td>
                    </tr>
                    <tr height=25 >
                        <td align=center colspan=5><font size=2 face=tahoma color=red>Format Date : Ex. 2010-12-31 </font></td>
                    </tr>
                </form>
            </table>
            <br><br><br>";
        if ($num >= 1) {

            echo "
				<table width=80% align=center cellpadding=5 cellspacing=0 border=0 style='background: #f0f0f0;border-radius: 10px;'>
					<tr height=25>
						<td align=left colspan=6>
									
						</td>
					</tr>";
            while($result_data = $result->fetch_assoc()) {
                $result_id = $result_data['result_id'];
                $percent = $result_data['percent'];
                $date = $result_data['create_date'];
                $arr_date = explode(" ", $date);
                $date_msg = get_thai_day($arr_date[0]) . "&nbsp;" . get_thai_month($arr_date[0]) . "&nbsp;" . get_thai_year($arr_date[0]);
                echo "
					<tr height=25>
						<td width=7% align=right><font size=2 face=tahoma color='black'>&bull;&nbsp;</font></td>
						<td width=15% align=left><font size=2 face=tahoma color='black'><b>ทำการทดสอบเมื่อ</b></font></td>
						<td width=44% align=left><font size=2 face=tahoma color='black'><b>วันที่ $date_msg เวลา $arr_date[1] น.</b></font></td>
						<td width=20% align=left><font size=2 face=tahoma color='black'><b>คิดเป็น&nbsp;&nbsp;" . $percent . "&nbsp;&nbsp;%</b></font></td>
						<td width=14% align=center>
							<a target=_blank href='?section=$_GET[section]&&action=report&&report_section=standard$link_ref_member&&result_id=$result_id'>
							<font size=2 face=tahoma color='blue'><b>[ดูรายละเอียด]&nbsp;&nbsp;</b></font></a>
						</td>
					</tr>";
            }
            echo "<tr height=25 bgcolor='#f0f0f0'><td align=left colspan=6></td></tr></table><br><br>&nbsp;";
        } else {
            echo "
				<table width=80% align=center cellpadding=5 cellspacing=0 border=0 style='background:#f0f0f0; border-radius:10px;'>
					<tr height=50>
						<td align=center><font size=2 face=tahoma color='red'> - Didn't find any EOL Standard Test result - </font></td>
					</tr>
				</table><br><br>&nbsp;";
        }
        $str_result->close();
    }
    $str_etest->close();
    mysqli_close($conn);
}

function report_s_result_detail() {
    include('../config/connection.php');
    include('../config/format_time.php');
    //-----------------------------------------------------------------------------//
    $allow = check_sub_account($_SESSION["x_member_id"], $_GET["member_id"]);
    $member_id = $conn->real_escape_string(trim($_GET['member_id']));
    $result_id = $conn->real_escape_string(trim($_GET['result_id']));
    //-----------------------------------------------------------------------------//
    if ($allow == "true") {
        $link_ref_member = "&&member_id=$member_id";
        $focus_member_id = $member_id;
    }else{
        $focus_member_id = $_SESSION["x_member_id"];
    }
    
    $tb_result = "SELECT * FROM tbl_w_result_est WHERE member_id = ? && result_id = ?";
    $str_result = $conn->prepare($tb_result);
    $str_result->bind_param("ss",$focus_member_id,$result_id);
    $str_result->execute();
    $result = $str_result->get_result();
    $num = $result->num_rows;
    if ($num == 1) {
        $result_data = $result->fetch_array();
        $result_id = $result_data['result_id'];
        $member_id = $result_data['member_id'];
        $level_id = $result_data['level_id'];
        $skill_id = $result_data['skill_id'];
        $create_date = $result_data['create_date'];
        $etest_id = $result_data['etest_id'];
        
        $arr_date_time = explode(" ", $create_date);
        $msg_date = get_thai_day($arr_date_time[0]) . " &nbsp; " . get_thai_month($arr_date_time[0]) . " &nbsp; " . get_thai_year($arr_date_time[0]) . " &nbsp; 
						&nbsp; เวลา " . $arr_date_time[1] . " น. ";
        //-------------------------------------//
        
        $tb_member = "SELECT * FROM tbl_x_member WHERE member_id = ?";
        $str_member = $conn->prepare($tb_member);
        $str_member->bind_param("s",$focus_member_id);
        $str_member->execute();
        $result = $str_member->get_result();
        $data = $result->fetch_array();
        $fname = $data['fname'];
        $lname = $data['lname'];
        $gender = $data['gender'];
        
        if ($etest_id >= 1) {
            
            $tb_etest = "SELECT * FROM tbl_etest WHERE ETEST_ID = ?";
            $str_etest = $conn->prepare($tb_etest);
            $str_etest->bind_param("s",$etest_id);
            $str_etest->execute();
            $result = $str_etest->get_result();
            $is_etest = $result->num_rows;
            if ($is_etest == 1) {
                $e_data = $result->fetch_array();
                $etest_name = $e_data['ETEST_NAME'];
                $etest_standard = $e_data['IS_EST'];
            }
            $str_etest->close();
        }
        if ($etest_standard == 1) {
            //----------------- Get All point --------------------//
            
            $tb_result_detail = "SELECT * FROM tbl_w_result_est_detail WHERE result_id = ? group by quiz_id";
            $str_re_detail = $conn->prepare($tb_result_detail);
            $str_re_detail->bind_param("s",$result_id);
            $str_re_detail->execute();
            $result = $str_re_detail->get_result();
            $total_amount = $result->num_rows;
            
            $j=1;
            while($sub_data = $result->fetch_assoc()) {
                $temp_quiz[$j] = $sub_data['quiz_id'];
                $temp_ans[$j] = $sub_data['ans_id'];
                $j++; 
            }
            $str_re_detail->close();
            //----------------- Get Pass point -----------------------//
            if ($total_amount >= 1) {
                $amount = NULL;
                for ($i = 1; $i <= $total_amount; $i++) {
                    $quiz_id = $temp_quiz[$i];
                    $result_ans = $temp_ans[$i];
                    
                    $tb_question = "SELECT SKILL_ID FROM tbl_questions WHERE QUESTIONS_ID = ?";
                    $str_quiz = $conn->prepare($tb_question);
                    $str_quiz->bind_param("s",$quiz_id);
                    $str_quiz->execute();
                    $result = $str_quiz->get_result();
                    $is_have = $result->num_rows;
                    if ($is_have == 1) {
                        $skill_data = $result->fetch_array();
                        $skill_id = $skill_data['SKILL_ID'];
                    }
                    $str_quiz->close();
                    
                    $ans_correct = 1;
                    $tb_ans = "SELECT ANSWERS_ID FROM tbl_answers WHERE QUESTIONS_ID = ? && ANSWERS_CORRECT = ?";
                    $str_ans = $conn->prepare($tb_ans);
                    $str_ans->bind_param("si",$quiz_id,$ans_correct);
                    $str_ans->execute();
                    $result = $str_ans->get_result();
                    $is_true = $result->num_rows;
                    if ($is_true == 1) {
                        $check = $result->fetch_array();
                        if ($result_ans == $check['ANSWERS_ID']) {
                            $amount[$skill_id] = $amount[$skill_id] + 1;
                        }
                        if ($result_ans != $check['ANSWERS_ID'] && $result_ans != 0) {
                            $wrong[$skill_id] = $wrong[$skill_id] + 1;
                        }
                        if ($result_ans == 0) {
                            $unans[$skill_id] = $unans[$skill_id] + 1;
                        }
                    }
                    $str_ans->close();
                }
                $all_pass = ($amount[1] + $amount[2] + $amount[4] + $amount[5]);
                $all_wrong = ($wrong[1] + $wrong[2] + $wrong[4] + $wrong[5]);
                $all_unans = ($unans[1] + $unans[2] + $unans[4] + $unans[5]);
                $percent = (($all_pass + 0) - ($all_wrong * 0.25)) * ( 100 / $total_amount);

            }
            $msg_image = "../2010/member_images/" . $member_id . ".jpg";
            $data_image = @getimagesize($msg_image);
            if ($data_image[0] >= 1 && $data_image[0] - $data_image[0] == 0) {
                $image_name = $member_id . ".jpg";
                if ($data_image[1] >= 100) {
                    $height = 100;
                } else {
                    $height = $data_image[1];
                }
            } else {
                if ($gender == 0) {
                    $gender = 1;
                }
                $image_name = "icon_user_0" . $gender . ".jpg";
                $height = 100;
            }
            
            //=========== แสดงหน้ารายละเอียดของผู้ทำแบบทดสอบ standard test ===========//
           
            echo "
				<table align=center width=89% cellpadding=5 cellspacing=0 border=0 bgcolor='#f7f7f7'>
					<tr height=25>
						<center><img src='../images/image2/eol system/Report/EST_head_report.png' width=90%></img><br><br></center>
						<td width=10% rowspan=4 bgcolor='#e7e7e7' align=center>
							<img src='../2010/member_images/$image_name' height='$height'>
						</td>
						<td width=20% align=right><font size=2 face=tahoma color=black><b>ผู้ทำแบบทดสอบ &nbsp; : &nbsp; </b></font></td>
						<td width=70% align=left colspan=3><font size=2 face=tahoma color=black><b>&nbsp; $fname &nbsp; &nbsp; $lname </b></font></td>
					</tr>
					<tr  height=25>
						<td align=right><font size=2 face=tahoma color=black><b>วันที่ทำการทดสอบ &nbsp; : &nbsp; </b></font></td>
						<td align=left ><font size=2 face=tahoma color=black><b>&nbsp; $msg_date </b></font></td>
					</tr>
					<tr  height=25>
						<td align=right><font size=2 face=tahoma color=black><b>
							ประเภทการทดสอบ &nbsp; : &nbsp;</b></font></td>
						<td align=left >
							<font size=2 face=tahoma color=black><b>
								&nbsp; EOL Standard Test
							</b></font>
						</td>
					</tr>
					<tr  height=25>
						<td align=right><font size=2 face=tahoma color=black><b>คะแนนที่ได้ &nbsp; : &nbsp; </b></font></td>
						<td align=left >
							<font size=2 face=tahoma color=black><b>
								&nbsp; ตอบถูก $all_pass ข้อ &nbsp; &nbsp; ตอบผิด $all_wrong ข้อ &nbsp; &nbsp; ไม่ได้ตอบ $all_unans ข้อ &nbsp; &nbsp; คิดเป็น $percent %
							</b></font>
						</td>
					</tr>
				</table><br>";
        
            //------------------------------------------------------//
            $text_msg[0] = "<font color=red>ไม่สามารถประเมินได้ ( Incalculable )</font>";
            $text_msg[1] = "<font color=brown>พอใช้ ( Low )</font>";
            $text_msg[2] = "<font color=green>ปานกลาง ( Intermediate )</font>";
            $text_msg[3] = "<font color=blue>สูง ( High )</font>";
            $each_percent[1] = (($amount[1] + 0) - ($wrong[1] * 0.25)) + 0;
            $each_percent[2] = (($amount[2] + 0) - ($wrong[2] * 0.25)) + 0;
            $each_percent[3] = (($amount[4] + $amount[5] + 0) - ( ($wrong[4] + $wrong[5] ) * 0.25)) + 0;
            //------------------------------------------------------//
			if($each_percent[1]<=0)							    {	$skill_msg[1] = $text_msg[0]; 	}
			if($each_percent[1]>0&&$each_percent[1]<=14.75)	    {	$skill_msg[1] = $text_msg[1]; 	}
			if($each_percent[1]>14.75&&$each_percent[1]<=29.75)	{	$skill_msg[1] = $text_msg[2]; 	}
			if($each_percent[1]>29.75)							{	$skill_msg[1] = $text_msg[3]; 	}
			//------------------------------------------------------//
			if($each_percent[2]<=0)							    {	$skill_msg[2] = $text_msg[0]; 	}
			if($each_percent[2]>0&&$each_percent[2]<=10.75)	    {	$skill_msg[2] = $text_msg[1]; 	}
			if($each_percent[2]>10.75&&$each_percent[2]<=20.75)	{	$skill_msg[2] = $text_msg[2]; 	}
			if($each_percent[2]>20.75)							{	$skill_msg[2] = $text_msg[3]; 	}
			//------------------------------------------------------//
			if($each_percent[3]<=0)							    {	$skill_msg[3] = $text_msg[0]; 	}
			if($each_percent[3]>0&&$each_percent[3]<=10.75)	    {	$skill_msg[3] = $text_msg[1]; 	}
			if($each_percent[3]>10.75&&$each_percent[3]<=20.75)	{	$skill_msg[3] = $text_msg[2]; 	}
			if($each_percent[3]>20.75)							{	$skill_msg[3] = $text_msg[3]; 	}
			
            //-----------------------------------------------------------------//
            //============ ตารางแสดง ทักษะ คะแนน ระดับความสามารถ  ===============//
            //-----------------------------------------------------------------//

            echo "
				<table align=center width=90% cellpadding=5 cellspacing=2 border=0>
					<tr height=25 >
						<td align=center width=20% bgcolor='#aaaaaa'><font size=2 face=tahoma color='#ffffff'><b>ทักษะ ( Skill )</b></font></td>
						<td align=center width=45% bgcolor='#aaaaaa' colspan=3><font size=2 face=tahoma color='#ffffff'><b>คะแนน ( Score )</b></font></td>
						<td align=center width=35% bgcolor='#aaaaaa'><font size=2 face=tahoma color='#ffffff'><b>ระดับความสามารถ ( Level )</b></font></td>
					</tr>
					<tr height=25 >
						<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma><b>การฟัง ( Listening )</b></font></td>
						<td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบถูก " . ($amount[2] + 0) . " ข้อ </font></td>
						<td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบผิด " . ($wrong[2] + 0) . " ข้อ </font></td>
						<td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ไม่ได้ตอบ " . ($unans[2] + 0) . " ข้อ </font></td>
						<td align=center width=40% bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$skill_msg[2]</font></td>
					</tr>
					<tr height=25>
						<td align=center bgcolor='#e0e0e0' colspan=3><font size=2 face=tahoma >
							<b>คิดเป็น " . (round($each_percent[2], 2) + 0) . " / " . ($amount[2] + $wrong[2] + $unans[2] + 0) . " คะแนน </b>
						</font></td>
					</tr>
					<tr height=25 >
						<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma><b>การอ่าน ( Reading )</b></font></td>
						<td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบถูก " . ($amount[1] + 0) . " ข้อ </font></td>
						<td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบผิด " . ($wrong[1] + 0) . " ข้อ </font></td>
						<td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ไม่ได้ตอบ " . ($unans[1] + 0) . " ข้อ </font></td>
						<td align=center width=40% bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma > $skill_msg[1]</font></td>
					</tr>
					<tr height=25>
						<td align=center bgcolor='#e0e0e0' colspan=3><font size=2 face=tahoma >
							<b>คิดเป็น " . (round($each_percent[1], 2) + 0) . " / " . ($amount[1] + $wrong[1] + $unans[1] + 0) . " คะแนน </b>
						</font></td>
					</tr>
					<tr height=25 >
						<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma><b>การเขียน ( Writing )</b></font></td>
						<td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบถูก " . (($amount[4] + $amount[5]) + 0) . " ข้อ </font></td>
						<td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบผิด " . (($wrong[4] + $wrong[5]) + 0) . " ข้อ </font></td>
						<td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ไม่ได้ตอบ " . (($unans[4] + $unans[5]) + 0) . " ข้อ </font></td>
						<td align=center width=40% bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$skill_msg[3]</font></td>
					</tr>
					<tr height=25>
						<td align=center bgcolor='#e0e0e0' colspan=3><font size=2 face=tahoma >
							<b>คิดเป็น " . (round($each_percent[3], 2) + 0) . " /  
							" . ($amount[4] + $wrong[4] + $unans[4] + $amount[5] + $wrong[5] + $unans[5]) . " คะแนน </b>
						</font></td>
					</tr>
				</table><br>";
            //--------------------------------------------------------------//
            $color_a = "bgcolor='#f0f0f0'";		    $color_b = "bgcolor='#ffe0e0'";
			$color_bottom = "bgcolor='#C4FAFC'";    $color_top_score ="bgcolor='#E2F9F9'";
			if($percent<=0)					        {	$color[0] = $color_b;	$color_m[0] = $color_b;	}else{	$color[0] = $color_a;	$color_m[0] = $color_a;}
			if($percent>=0.25&&$percent<=7.75)	    {	$color[1] = $color_b;	$color_m[1] = $color_b; $color_g[1] = $color_b;	}else{	$color[1] = $color_a;	$color_m[1] = $color_a;	$color_g[1] = $color_a;}
			if($percent>7.75&&$percent<=15.75)	    {	$color[2] = $color_b;	$color_m[1] = $color_b;	$color_g[1] = $color_b; }else{	$color[2] = $color_a;	}
			if($percent>15.75&&$percent<=25.75)	    {	$color[3] = $color_b;	$color_m[2] = $color_b;	$color_g[2] = $color_b; }else{	$color[3] = $color_a;	$color_m[2] = $color_a;	$color_g[2] = $color_a;}
			if($percent>25.75&&$percent<=35.75)	    {	$color[4] = $color_b;	$color_m[2] = $color_b;	$color_g[2] = $color_b; }else{	$color[4] = $color_a;	}
			if($percent>35.75&&$percent<=45.75)	    {	$color[5] = $color_b;	$color_m[3] = $color_b;	$color_g[3] = $color_b; }else{	$color[5] = $color_a;	$color_m[3] = $color_a;	$color_g[3] = $color_a;}
			if($percent>45.75&&$percent<=60.75)	    {	$color[6] = $color_b;	$color_m[3] = $color_b;	$color_g[3] = $color_b; }else{	$color[6] = $color_a;	}
			if($percent>60.75&&$percent<=70.75)	    {	$color[7] = $color_b;	$color_m[4] = $color_b;	$color_g[4] = $color_b; }else{	$color[7] = $color_a;	$color_m[4] = $color_a;	$color_g[4] = $color_a;}
			if($percent>70.75&&$percent<=80.75)	    {	$color[8] = $color_b;	$color_m[4] = $color_b;	$color_g[4] = $color_b; }else{	$color[8] = $color_a;	}
			if($percent>80.75&&$percent<=90.75)	    {	$color[9] = $color_b;	$color_m[5] = $color_b; $color_g[5] = $color_b; }else{	$color[9] = $color_a;	$color_m[5] = $color_a;	$color_g[5] = $color_a;}
			if($percent>90.75&&$percent<=99.75)	    {	$color[10] = $color_b;	$color_m[6] = $color_b; $color_g[5] = $color_b; }else{	$color[10] = $color_a;	$color_m[6] = $color_a;}
			if($percent>99.75&&$percent<=100)	    {	$color[11] = $color_b;	$color_m[7] = $color_b; }else{	$color[11] = $color_bottom;	$color_m[7] = $color_bottom;	}
					
			//------------------------ CEFR ---------------------//
			if($percent<=0)					        {	$color_c[0] = $color_b;	}else{ $color_c[0] = $color_a; }
			if($percent>=0.25&&$percent<=15.75)	    {	$color_c[1] = $color_b;	}else{ $color_c[1] = $color_a; }
			if($percent>15.75&&$percent<=35.75)	    {	$color_c[2] = $color_b;	}else{ $color_c[2] = $color_a; }
			if($percent>35.75&&$percent<=60.75)	    {	$color_c[3] = $color_b;	}else{ $color_c[3] = $color_a; }
			if($percent>60.75&&$percent<=80.75)	    {	$color_c[4] = $color_b;	}else{ $color_c[4] = $color_a; }
			if($percent>80.75&&$percent<=99.75)	    {	$color_c[5] = $color_b;	}else{ $color_c[5] = $color_a; }
			if($percent>99.75&&$percent<=100)	    {	$color_c[6] = $color_b;	}else{ $color_c[6] = $color_bottom; }
           
            // ==== ตารางแสดงรายละเอียด EOL Standard Test, TOEIC, TOEFL ITP, TOEFL IBT, IELTS, CU-TEP, CEFR ==== //
            
            echo "
                <table align=center width=90% cellpadding=5 cellspacing=2 border=0>
                    <tr height=25>
                        <td align=center bgcolor='#aaaaaa'>
                            <font size=2 face=tahoma color='#ffffff'><b>EOL Standard Test</b></font>
                        </td>
                        <td align=center bgcolor='#aaaaaa'>
                            <font size=2 face=tahoma color='#ffffff'><b>TOEIC</b></font>
                        </td>
                        <td align=center bgcolor='#aaaaaa'>
                            <font size=2 face=tahoma color='#ffffff'><b>CU-TEP</b></font>
                        </td>
                        <td align=center bgcolor='#aaaaaa'>
                            <font size=2 face=tahoma color='#ffffff'><b>TOEFL ITP</b></font>
                        </td>
                        <td align=center bgcolor='#aaaaaa'>
                            <font size=2 face=tahoma color='#ffffff'><b>TOEFL IBT</b></font>
                        </td>
                        <td align=center bgcolor='#aaaaaa'>
                            <font size=2 face=tahoma color='#ffffff'><b>IELTS</b></font>
                        </td>
                        
                        <td align=center bgcolor='#aaaaaa'>
                            <font size=2 face=tahoma color='#ffffff'><b>CEFR</b></font>
                        </td>
                    </tr>
                    <tr height=25>
                        <td align=center rowspan=2 $color_g[1]>
                            <font size=3 face=tahoma><b>1 - 15</b></font>
                        </td>
                        <td align=center rowspan=2 $color_m[1]>
                            <font size=2 face=tahoma>0 - 250</font>
                        </td>
                        <td align=center $color[1]>
                            <font size=2 face=tahoma> - </font>
                        </td>
                        <td align=center $color[1]>
                            <font size=2 face=tahoma> - </font>
                        </td>
                        <td align=center $color[1]>
                            <font size=2 face=tahoma> - </font>
                        </td>
                        <td align=center $color[1]>
                            <font size=2 face=tahoma>0 - 1</font>
                        </td>
                    
                        <td align=center $color_c[1] rowspan=2><font size=2 face=tahoma >A1</font></td>
                    </tr>
                    <tr height=25>
                        <td align=center  $color[2]>
                            <font size=2 face=tahoma> - </font>
                        </td>
                        <td align=center $color[2]>
                            <font size=2 face=tahoma> - </font>
                        </td>
                        <td align=center $color[2]>
                            <font size=2 face=tahoma> - </font>
                        </td>
                        <td align=center $color[2]>
                            <font size=2 face=tahoma>1 - 1.5</font>
                        </td>
                        
                    </tr>
                    <tr height=25>
                        <td align=center rowspan=2 $color_g[2]>
                            <font size=3 face=tahoma><b>16 - 35</b></font>
                        </td>
                        <td align=center rowspan=2 $color_m[2]>
                            <font size=2 face=tahoma>255 - 400</font>
                        </td>
                        <td align=center $color[3]>
                            <font size=2 face=tahoma> - </font>
                        </td>
                        <td align=center $color[3]>
                            <font size=2 face=tahoma>347 - 393</font>
                        </td>
                        <td align=center $color[3]>
                            <font size=2 face=tahoma> - </font>
                        </td>
                        <td align=center $color[3]>
                            <font size=2 face=tahoma>2 - 2.5</font>
                        </td>
                        <td align=center $color_c[2] rowspan=2><font size=2 face=tahoma >A2</font></td>
                    </tr>
                    <tr height=25>
                        <td align=center $color[4]>
                            <font size=2 face=tahoma> - </font>
                        </td>
                        
                        <td align=center $color[4]>
                            <font size=2 face=tahoma>397 - 433</font>
                        </td>
                        <td align=center $color[4]>
                            <font size=2 face=tahoma> - </font>
                        </td>
                        <td align=center $color[4]>
                            <font size=2 face=tahoma>3 - 3.5</font>
                        </td>
                        
                    </tr>
                    <tr height=25>
                        <td align=center rowspan=2 $color_g[3]>
                            <font size=3 face=tahoma><b>36 - 60</b></font>
                        </td>
                        <td align=center rowspan=2 $color_m[3]>
                            <font size=2 face=tahoma >405 - 600</font>
                        </td>
                        <td align=center  $color[5]>
                            <font size=2 face=tahoma> - </font>
                        </td>
                        <td align=center $color[5]>
                            <font size=2 face=tahoma>437 - 473</font>
                        </td>
                        <td align=center $color[5]>
                            <font size=2 face=tahoma>41 - 52</font>
                        </td>
                        <td align=center $color[5]>
                            <font size=2 face=tahoma>4</font>
                        </td>
                    
                        <td align=center $color_c[3] rowspan=2><font size=2 face=tahoma >B1</font>
                        </td>
                    </tr>
                    <tr height=25>
                        <td align=center $color[6]>
                            <font size=2 face=tahoma> 60 </font>
                        </td>
                        <td align=center $color[6]>
                            <font size=2 face=tahoma>477 - 510</font>
                        </td>
                        <td align=center $color[6]>
                            <font size=2 face=tahoma>53 - 64</font>
                        </td>
                        <td align=center $color[6]>
                            <font size=2 face=tahoma>4.5 - 5</font>
                        </td>
                    </tr>
                    <tr height=25>
                        <td align=center rowspan=2 $color_g[4]>
                            <font size=3 face=tahoma><b>61 - 80</b></font>
                        </td>
                        <td align=center rowspan=2 $color_m[4]>
                            <font size=2 face=tahoma >605 - 780</font>
                        </td>
                        <td align=center $color[7]>
                            <font size=2 face=tahoma> 75 </font>
                        </td>
                        <td align=center $color[7]>
                            <font size=2 face=tahoma>513 - 547</font>
                        </td>
                        <td align=center $color[7]>
                            <font size=2 face=tahoma>65 - 78</font>
                        </td>
                        <td align=center $color[7]>
                            <font size=2 face=tahoma>5.5 - 6</font>
                        </td>
                        
                        <td align=center $color_c[4] rowspan=2><font size=2 face=tahoma >B2</font></td>
                    </tr>
                    <tr height=25>

                        <td align=center   $color[8]> 
                            <font size=2 face=tahoma> 90 </font>
                        </td>
                        <td align=center $color[8]>
                            <font size=2 face=tahoma>550 - 587</font>
                        </td>
                        <td align=center  $color[8]>
                            <font size=2 face=tahoma>79 - 95</font>
                        </td>
                        <td align=center $color[8]>
                            <font size=2 face=tahoma> 6.5 - 7 </font>
                        </td>
                    
                    </tr>
                    <tr height=25>
                        <td align=center rowspan=2 $color_g[5]>
                            <font size=3 face=tahoma><b>81 - 99</b></font>
                        </td>
                        <td align=center $color_m[5]>
                            <font size=2 face=tahoma >785 - 900</font>
                        </td>
                        <td align=center $color[9]>
                            <font size=2 face=tahoma> 100 </font>
                        </td>
                        <td align=center $color[9]>
                            <font size=2 face=tahoma>590 - 637</font>
                        </td>
                        <td align=center $color[9]>
                            <font size=2 face=tahoma>96 - 110</font>
                        </td>
                        <td align=center $color[9]>
                            <font size=2 face=tahoma>7.5 - 8</font>
                        </td>
                        <td align=center $color_c[5] rowspan=2><font size=2 face=tahoma >C1</font></td>
                    </tr>
                    <tr height=25>
                        <td align=center $color_m[6]>
                            <font size=2 face=tahoma>905 - 989</font>
                        </td>
                        <td align=center $color[10]>
                            <font size=2 face=tahoma>119</font>
                        </td>
                        <td align=center $color[10]>
                            <font size=2 face=tahoma>640 - 676</font>
                        </td>
                        <td align=center $color[10]>
                            <font size=2 face=tahoma>111 - 119</font>
                        </td>
                        <td align=center $color[10]>
                            <font size=2 face=tahoma>8.5</font>
                        </td>
                    </tr>
                    <tr>
                        <td align=center colspan=7 $color_top_score>
                            <font size=3 face=tahoma><b> TOP SCORE </b></font>
                        </td>
                    </tr>
                    <tr>
                        <td align=center $color[11]>
                            <font size=3 face=tahoma><b>100</b></font>
                        </td>
                        <td align=center $color_m[7]>
                            <font size=2 face=tahoma>990</font>
                        </td>
                        <td align=center $color[11]>
                            <font size=2 face=tahoma>120</font>
                        </td>
                        <td align=center $color[11]>
                            <font size=2 face=tahoma>677</font>
                        </td>
                        <td align=center $color[11]>
                            <font size=2 face=tahoma>120</font>
                        </td>
                        <td align=center $color[11]>
                            <font size=2 face=tahoma>9</font>
                        </td>
                        <td align=center $color_c[6]><font size=2 face=tahoma >C2</font></td>
                    </tr>
                </table><br><br>&nbsp;";
        }
    }else header("Location:?section=$_GET[section]");
    
    //---------------------------------//
    mysqli_close($conn);
}

function report_list_contest() {
    include('../config/connection.php');

    ///////// RECAL //////////
    $sql_recal = "SELECT * FROM (
        -- ดึงตาราง tb_x_member, tb_w_result, tb_w_result_detail, tb_answers, tb_x_member
        SELECT Z.CREATE_DATE, Z.RESULT_ID,C.MEMBER_ID, C.USER, C.PASS, (
        SUM( B.ANSWERS_CORRECT ) / COUNT( A.RESULT_DETAIL_ID )
        ) *100 AS CORRECT_PERCENTAGE, Z.PERCENT AS WRONG_PERCENTAGE, Z.ETEST_ID
        FROM tbl_x_member_sub AS Y 
        -- where memner_id = sub_id
        LEFT JOIN tbl_w_result AS Z ON (Z.member_id = Y.sub_id)  
        -- where result_id = result_id
        LEFT JOIN tbl_w_result_detail AS A ON ( A.RESULT_ID = Z.RESULT_ID )
        -- where question = quiz_id
        LEFT JOIN tbl_answers AS B ON ( B.QUESTIONS_ID = A.QUIZ_ID
        AND B.ANSWERS_CORRECT = '1'
        AND B.ANSWERS_ID = A.ANS_ID )
        LEFT JOIN tbl_x_member AS C ON ( C.MEMBER_ID = Z.MEMBER_ID )
        WHERE (Y.SUB_ID = '" . $_SESSION['x_member_id'] . "' OR Y.SUB_ID = '" . $_GET['member_id'] . "')
		AND Y.SUB_ID <> '' GROUP BY Z.RESULT_ID
        ) AS M

        WHERE M.CORRECT_PERCENTAGE <> M.WRONG_PERCENTAGE";

    $stmt_recal = $conn->prepare($sql_recal);
    $stmt_recal->execute();
    $result = $stmt_recal->get_result();
    $num_recal = $result->num_rows;

    for ($x = 1; $x <= $num_recal; $x++) {
        $row_recal = $result->fetch_array();

        $sql_recal_update = "UPDATE tbl_w_result SET 
                            percent = '" . $row_recal['CORRECT_PERCENTAGE'] . "'
                            WHERE result_id = '" . $row_recal['RESULT_ID'] . "' AND member_id = '" . $row_recal['MEMBER_ID'] . "' AND etest_id = '" . $row_recal['ETEST_ID'] . "';";
        $query_recal = $conn->prepare($sql_recal_update);
        $query_recal->execute();
    }
    $stmt_recal->close();
    // ------------------------------------------------------ //
    
    if (!$_POST["start"]) {
        $start = date("Y-m-d", time() - ( 60 * 60 * 24 * 30 ));
    } else {
        $start = $_POST["start"];
    }
    if (!$_POST["stop"]) {
        $stop = date("Y-m-d", time() + ( 60 * 60 * 24 * 1 ));
    } else {
        $stop = $_POST["stop"];
    }
    if($start == $stop){
        $format = 'Y-m-d H:i:s';
        $strstart = trim($_POST["start"]) . ' ' . '00:00:00';
        $strend = trim($_POST["stop"]) . ' ' . '23:59:59';
        $dateS = DateTime::createFromFormat($format, $strstart);
        $dateE = DateTime::createFromFormat($format, $strend);
        $start = $dateS->format('Y-m-d H:i:s');
        $stop = $dateE->format('Y-m-d H:i:s');
    }
    $allow = check_sub_account($_SESSION["x_member_id"], $_GET["member_id"]);
    
    if ($allow == "true") {
        $member_id = $conn->real_escape_string(trim($_GET['member_id']));
        $link_ref_member = "&&member_id=$member_id";
    }else{
        $member_id = $conn->real_escape_string($_SESSION['x_member_id']);
    }
    // ------------------------------------------------------ //
    $etest_id = 0;
    if ($member_id == "") {
        $contest = "SELECT * FROM tbl_w_result  WHERE  member_id = ? && etest_id > ? && create_date >= ? && create_date <= ?";
        $str_contest = $conn->prepare($contest);
        $str_contest->bind_param("siss",$_SESSION['x_member_id'],$etest_id,$start,$stop);
        $str_contest->execute();
        $result = $str_contest->get_result();
        $is_have = $result->num_rows;
    } else {
        $contest = "SELECT * FROM tbl_w_result  WHERE  member_id = ? && etest_id > ? && create_date >= ? && create_date <= ?";
        $str_contest = $conn->prepare($contest);
        $str_contest->bind_param("siss",$member_id,$etest_id,$start,$stop);
        $str_contest->execute();
        $result = $str_contest->get_result();
        $is_have = $result->num_rows;
    }
 
    echo "
		<link rel=\"stylesheet\" type=\"text/css\" href=\"../calendar/epoch_styles.css\" />
		<script type=\"text/javascript\" src=\"../calendar/epoch_classes.js\"></script>
		<script type=\"text/javascript\">
            /*You can also place this code in a separate file and link to it like epoch_classes.js*/
                var a,b;      
            window.onload = function () {
                a  = new Epoch('epoch_popup','popup',document.getElementById('popup_container_a'));
                b  = new Epoch('epoch_popup','popup',document.getElementById('popup_container_b'));
            };
		</script>";
    

        echo "
			<img src='../images/image2/eol system/Report/report-contest.png' width=99% usemap='#Map1' style='border-radius:15px;'>
			<map name='Map1' id='Map1'>
              <area shape='rect' coords='720,292,979,379' href='eoltest.php?section=$_GET[section]&&action=$_GET[action]$link_ref_member' target='_self' />
            </map>
            <table align=center width=60% bgcolor='#f0f0f0' cellpadding=0 cellspacing=0 border=0 style='position:absolute;top:600px;left:60%;margin-left:-400px;border-radius:15px;'>
                <form method=post  id='placeholder' 
                action='?section=$_GET[section]&&action=$_GET[action]$link_ref_member&&report_section=$_GET[report_section]'>   
                    <tr height=50 valign=middle>
                        <td align=right width=13%><font size=2 face=tahoma color=black><b>From &nbsp; : &nbsp;</b></font></td>
                        <td align=left width=27%>&nbsp;<input id='popup_container_a' type=text name=start value='$start' size=16 style='height:22px;border-radius:8px;border:1px solid #bbb2ae'></td>
                        <td align=right width=13%><font size=2 face=tahoma color=black><b>Until &nbsp; : &nbsp;</b></font></td>
                        <td align=left width=27%>&nbsp;<input id='popup_container_b' type=text name=stop value='$stop' size=16 style='height:22px;border-radius:8px;border:1px solid #bbb2ae'></td>
                        <td align=left width=15%><input type='submit' name='veiw' value='&nbsp; View &nbsp;' class='btn-view'></td>
                    </tr>
                    <tr height=25 >
                        <td align=center colspan=5><font size=2 face=tahoma color=red><b>Format Date : Ex. 2010-12-31 </b></font></td>
                    </tr>
                </form>
            </table>
            <br><br>";
        if ($is_have) {
            echo "<br><br><table align=center width=100% cellpadding=0 cellspacing=0 border=0 class='tb-list-score-contest'>
            <tr bgcolor='#f0f0f0'></tr>";
            while ($row = $result->fetch_assoc()) {
                $exam_name = get_exam_name($row['etest_id']);
                echo '<tr  style="height:50px;">
                        <td align="center"></td>
                        <td style="min-width:100px;text-align:center;">
                            <a href="?section=business&&action=report&&member_id=' . $member_id . '&&report_section=contest&&result_id=', $row['result_id'], '" target="_bank" style="font-size:14px;" title="',$exam_name,'">', $row['create_date'], '</a> 
                        </td>
                        <td style="min-width:100px;text-align:center;font-size:14px;">คะแนนที่ได้ : <br><b>', $row['percent'], '%</b></td>
                        <td style="width:70%;"><img  src="../2010/temp_images/icon_bar/bar_01.png" style="border-radius:5px; width:', $row['percent'], '%" height="25" title="',$exam_name,'"></td>
                      </tr>';
            }
            echo '</table>';
        } else {
            echo "<br><br>
			<table width=80% align=center cellpadding=5 cellspacing=0 border=0 style='background:#f0f0f0; border-radius:10px;'>
				
				<tr height='50'>
					<td align=center><font size=2 face=tahoma color='red'> - Didn't find any result - </font></td>
				</tr>
                
			</table><br><br>&nbsp;";
        }
        
        if ($_POST['view'] && $_POST['start'] && $_POST['stop']) {
            report_list_contest();
        } 
        $str_contest->close();
        mysqli_close($conn);
}

function report_contest_result_detail() {
    include('../config/connection.php');
    include('../config/format_time.php');
    //-----------------------------------------------------------------------------//
    $allow = check_sub_account($_SESSION["x_member_id"], $_GET["member_id"]);
    $member_id = $conn->real_escape_string(trim($_GET['member_id']));
    $result_id = $conn->real_escape_string(trim($_GET['result_id']));
    if ($allow == "true") {
        $link_ref_member = "&&member_id=$member_id";
        $focus_member_id = $member_id;
    }else {
        $focus_member_id = $_SESSION["x_member_id"];
    }
    //-----------------------------------------------------------------------------//

    $tb_result = "SELECT * FROM tbl_w_result WHERE member_id = ? && result_id = ?";
    $str_result = $conn->prepare($tb_result);
    $str_result->bind_param("ss",$focus_member_id,$result_id);
    $str_result->execute();
    $result = $str_result->get_result();
    $num = $result->num_rows;
    $result_data = $result->fetch_array();
    $etest_id = trim($result_data['etest_id']);
    if ($num == 1) {
        if ($etest_id != 0) {
            $tb_etest = "SELECT * FROM tbl_eventest WHERE exam_id = ?";
            $str_etest = $conn->prepare($tb_etest);
            $str_etest->bind_param("s",$etest_id);
            $str_etest->execute();
            $result = $str_etest->get_result();
            $result_exam = $result->fetch_array();  
            $test_type = $result_exam['test_type'];
            $exam_name = $result_exam['exam_name'];
            $exam_type = $result_exam['exam_type'];
            $_SESSION['exam_type'] = $exam_type;
            $str_etest->close();
 
            if ($test_type == 2)
                $section_msg = 'EOL Contest &nbsp; &raquo; &nbsp;' . $exam_name . ' &nbsp; &raquo; &nbsp; การแข่งขัน ';
            else
                $section_msg = 'EOL Contest &nbsp; &raquo; &nbsp;' . $exam_name . '&nbsp; &raquo; &nbsp; เก็บคะแนน';
        }
        //------------------------------------------------------------------------//
        $result_id = $result_data['result_id'];
        $member_id = $result_data['member_id'];
        $level_id = $result_data['level_id'];
        $skill_id = $result_data['skill_id'];
        $create_date = $result_data['create_date'];
        //-------------------------------------------------------------------------//
        $arr_date_time = explode(" ", $create_date);
        $msg_date = get_thai_day($arr_date_time[0]) . " &nbsp; " . get_thai_month($arr_date_time[0]) . " &nbsp; " . get_thai_year($arr_date_time[0]) . " &nbsp; 
						&nbsp; เวลา " . $arr_date_time[1] . " น. ";
        //-------------------------------------//
       
        $tb_member = "SELECT * FROM tbl_x_member WHERE member_id = ?";
        $str_member = $conn->prepare($tb_member);
        $str_member->bind_param("s",$member_id);
        $str_member->execute();
        $result = $str_member->get_result();
        $is_have = $result->num_rows;
        $data = $result->fetch_array(); 
        $fname = $data['fname'];
        $lname = $data['lname'];
        $gender = $data['gender'];
        $str_member->close();
        
        $is_est = 1;
        if ($is_est == 1) {
            //---------------- Get All point ---------------------//
            
            $tb_result_detail = "SELECT * FROM tbl_w_result_detail WHERE result_id = ?";
            $str_re_detail = $conn->prepare($tb_result_detail);
            $str_re_detail->bind_param("s",$result_id);
            $str_re_detail->execute();
            $result = $str_re_detail->get_result();
            $total_amount = $result->num_rows;
            
            $j = 1;
            while($data = $result->fetch_assoc()) {
                $temp_quiz[$j] = $data['quiz_id'];
                $temp_ans[$j] = $data['ans_id'];
                $j++;  
            }
            $str_re_detail->close();
            
            //---------------- Get Pass point ------------------//
            $amount = 0;
            $percent = 0;
            if ($total_amount >= 1) {
                if ($exam_type == 1) { // check exam type
                    unset($_SESSION['exam_type']);
                    unset($_SESSION['amount']);
                    unset( $_SESSION['percent']);
                    for ($i = 1; $i <= $total_amount; $i++) {
                       
                        $quiz_id = $temp_quiz[$i];
                        $ans_correct = 1;
                        $tb_ans = "SELECT ANSWERS_ID FROM tbl_answers WHERE QUESTIONS_ID = ? && ANSWERS_CORRECT = ?";
                        $str_ans = $conn->prepare($tb_ans);
                        $str_ans->bind_param("si",$quiz_id,$ans_correct);
                        $str_ans->execute();
                        $result = $str_ans->get_result();
                        $is_true = $result->num_rows;
                        if ($is_true == 1) {
                            $check = $result->fetch_array();
                            $ans_id = $check['ANSWERS_ID'];
                            
                            $tb_w_result_detail = "SELECT ans_id FROM tbl_w_result_detail WHERE result_id = ? && quiz_id = ? && ans_id = ?";
                            $str_w_result = $conn->prepare($tb_w_result_detail);
                            $str_w_result->bind_param("sss",$result_id,$quiz_id,$ans_id);
                            $str_w_result->execute();
                            $result = $str_w_result->get_result();
                            $is_correct = $result->num_rows;
                            if ($is_correct == 1) {
                                $amount += 1;
                            }
                            $str_w_result->close();
                        }
                        $str_ans->close();
                    }
                    $amount = $amount + 0;
                    $percent = 0 + ($amount / $total_amount * 100);
                    $arr = explode(".", $percent);
                    if (strlen($arr[1]) > "2") {
                        $percent = $arr[0] . "." . $arr[1][0] . $arr[1][1];
                    }
                } else {
                   
                    for ($i = 1; $i <= $total_amount; $i++) { 
                        $quiz_id = $temp_quiz[$i];
                        $ans_id = $temp_ans[$i];
                        $answer = 1;
                        $tb_event_ans = "SELECT * FROM tbl_eventest_answer WHERE answer_id = ? && question_id = ? && answer = ?";
                        $str_event_ans = $conn->prepare($tb_event_ans);
                        $str_event_ans->bind_param("sss",$ans_id,$quiz_id,$answer);
                        $str_event_ans->execute();
                        $result = $str_event_ans->get_result();
                        $is_correct = $result->num_rows;
                        if ($is_correct == 1) {
                            $amount = $amount + 1;
                        }
                        $str_event_ans->close();
                    }
                    $amount = $amount + 0;
                    $percent = 0 + ($amount / $total_amount * 100);
                    $arr = explode(".", $percent);
                    if (strlen($arr[1]) > "2") {
                        $percent = $arr[0] . "." . $arr[1][0] . $arr[1][1];
                    }
                    $_SESSION['amount'] = $amount;
                    $_SESSION['percent'] = $percent;
                }
            }
            $msg_image = "../2010/member_images/" . $member_id . ".jpg";
            $data_image = @getimagesize($msg_image);
            if ($data_image[0] >= 1 && $data_image[0] - $data_image[0] == 0) {
                $image_name = $member_id . ".jpg";
                if ($data_image[1] >= 100) {
                    $height = 100;
                } else {
                    $height = $data_image[1];
                }
            } else {
                if ($gender == 0) {
                    $gender = 1;
                }
                $image_name = "icon_user_0" . $gender . ".jpg";
                $height = 100;
            }

            echo "
				<table align=center width=90% cellpadding=5 cellspacing=0 border=0 bgcolor='#fff' style='border-radius:15px'>
					<tr height=25>
						<td width=11% rowspan=4 bgcolor='#e7e7e7' align=center><img src='../2010/member_images/$image_name' height='$height'></td>
	  					<td width=22% align=right><font size=2 face=tahoma color=black><b>ผู้ทำแบบทดสอบ &nbsp; : &nbsp; </b></font></td>
	  					<td width=50% align=left><font size=2 face=tahoma color=black><b>&nbsp; $fname &nbsp; &nbsp; $lname </b></font></td>
      					<td width=17% rowspan=4>
						</td>
  					</tr>
					<tr  height=25>
						<td align=right><font size=2 face=tahoma color=black><b>วันที่ทำการทดสอบ &nbsp; : &nbsp; </b></font></td>
						<td align=left ><font size=2 face=tahoma color=black><b>&nbsp; $msg_date </b></font></td>
    				</tr>
					<tr  height=25>
						<td align=right><font size=2 face=tahoma color=black><b>ประเภทการทดสอบ &nbsp; : &nbsp; </b></font></td>
						<td align=left width='80%'><font size=2 face=tahoma color=black><b>&nbsp; $section_msg</b></font></td>
    				</tr>
					<tr  height=25>
						<td align=right><font size=2 face=tahoma color=black><b>คะแนนที่ได้ &nbsp; : &nbsp; </b></font></td>
						<td align=left ><font size=2 face=tahoma color=black><b>&nbsp; $amount / $total_amount &nbsp; คะแนน &nbsp;&nbsp;&nbsp; คิดเป็น &nbsp; $percent %</b></font></td>
    				</tr>
				</table><br>
				<table align=center width=90% cellpadding=2 cellspacing=0 border=0 >
					<tr  height=30>
						<td width=15% align=center >
							<a href='?section=$_GET[section]&&action=$_GET[action]&&report_section=$_GET[report_section]$link_ref_member&&result_id=$_GET[result_id]&&type=1'>
								<img src='../images/icon/summary-01.png' border=0>
							</a> 
						</td>
						<td width=15% align=center >
							<a href='?section=$_GET[section]&&action=$_GET[action]&&report_section=$_GET[report_section]$link_ref_member&&result_id=$_GET[result_id]&&type=2'>
								<img src='../images/icon/check your answer-01.png' border=0>
							</a> 
						</td>
						<td width=15% align=center >
							<a href='?section=$_GET[section]&&action=$_GET[action]&&report_section=$_GET[report_section]$link_ref_member&&result_id=$_GET[result_id]&&type=3'>
								<img src='../images/icon/ranking-01.png' border=0>
							</a> 
						</td>
						<td width=70% align=left colspan=2 >&nbsp;</td>
					</tr>
				</table><br>";
                
            if ($_GET["type"] == 1 || !$_GET["type"]) {
                display_chart_bar();
                display_weak_point();
            }
            if ($_GET["type"] == 2) {
                display_a_test_detail();
            }
            if ($_GET["type"] == 3) {
                display_a_view_group();
            }
            if ($_GET["type"] == 4) {
                if ($_GET["sub_action"] == "comment") {
                    display_comment();
                }
            }
        }
    } else {
        header("Location:?section=$_GET[section]");
    }
    $str_result->close();
    mysqli_close($conn);
   
}
function get_exam_name($etest_id){
    include('../config/connection.php');
    $strSQL = "SELECT * FROM tbl_eventest WHERE exam_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s",$etest_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $result_exam = $result->fetch_array();  
    $exam_name = $result_exam['exam_name'];
    return $exam_name;
}

function display_comment() {
    include('../config/connection.php');
    
    $date = date("Y-m-d H:i:s");
    if (trim($_POST['quiz_id']) && trim($_POST['member_id']) && trim($_POST['text'])) {
        
        $mem_id = $conn->real_escape_string($_POST['member_id']);
        $quiz_id = $conn->real_escape_string($_POST['quiz_id']);
        $text = $conn->real_escape_string($_POST['text']);
        $status = 0;
        $strSQL = "SELECT * FROM tbl_quiz_comment WHERE mem_id = ? && quiz_id = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("ss",$mem_id,$quiz_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $is_have = $result->num_rows;
        
        if ($is_have == 0) {
           
            $msg = "INSERT INTO tbl_quiz_comment (quiz_id, mem_id, text, status, date) VALUES (?,?,?,?,?)";
            $query = $conn->prepare($msg);
            $query->bind_param("sssis",$quiz_id,$mem_id,$text,$status,$date);
            $query->execute();
            $query->close();
            
        }
        if ($is_have == 1) {

            $sql = "UPDATE tbl_quiz_comment SET text = ?, status = ?, date = ? WHERE quiz_id = ? && mem_id = ?";
            $sub_query = $conn->prepare($sql);
            $sub_query->bind_param("sisss",$text,$status,$date,$quiz_id,$mem_id);
            $sub_query->execute();

        }
        $stmt->close();
    }
    mysqli_close($conn);
    echo "<br><br><br><br>
				<div align=center>
                    <font color=brown size=2 face=tahoma><b>
					    Your message have been sent to our academicians. Thank you for your message.
				    </font><br><br>
				    <font size=2 face=tahoma color='green'>
					    The question(s) will be replied within seven  workdays via your registered email-address. 
				    </font><br><br>
				    <font size=2 face=tahoma color='red'>
					    Note : We are not responsible for the users with invalid or without email address. 
				    </font>
				</div>
			    <br><br><br><br></b>
			    <table align=center border=0 style=\"cursor:pointer\"
				    onclick=\"javascript:window.close();\">
				    <tr height=25>
                        <td align=center>
                            <font color=blue size=2 face=tahoma>
                                <b>
                                    [ Click here to close this page ]
                                </b>
                            </font>
				        </td>
                    </tr>
			    </table>
		  <br><br>&nbsp;";
}

function refill_main($check_master) {
    refill_form($check_master);
    refill_history($check_master);
}

function refill_form($check_master) {
    
    include('../config/connection.php');
    if ($_GET['action'] === "refill") {
        if ($_POST['code'] && $_POST['pin'] && $_POST['verifly']) {
            
            if ($_POST['verifly'] != $_SESSION['verifly']) {
                $refill_error = " Verify Code is incorrect ";
            } 
            else {
                
                $code = $conn->real_escape_string(trim($_POST['code']));
                $pin = $conn->real_escape_string(trim($_POST['pin']));
                $active = 0;
                $strSQL = "SELECT * FROM tbl_x_card WHERE code = ? && pin = ? && active = ?";
                $stmt = $conn->prepare($strSQL);
                $stmt->bind_param("ssi", $code, $pin, $active);
                $stmt->execute();
                $result = $stmt->get_result();
                $is_ok = $result->num_rows;
                if ($is_ok == 1) {
                    $data = $result->fetch_array();
                    $card_id = $data['card_id'];
                    $type_id = $data['type_id'];
                    
                    $SQL = "SELECT * FROM tbl_x_card_type WHERE type_id = ?";
                    $query = $conn->prepare($SQL);
                    $query->bind_param("s", $type_id);
                    $query->execute();
                    $result_type = $query->get_result();
                    $is_type = $result_type->num_rows;
                    if ($is_type == 1) {
                        $data_type = $result_type->fetch_array();
                        $day = $data_type['amount'];
                    }
                    $query->close();
                    //------------------------------------------------------------//
                    if ($check_master === "master") {
                        $now = date("Y-m-d H:i:s");
                        $sql = "SELECT * FROM tbl_x_member_time ORDER BY refill_id DESC limit 0,1";
                        $sub_stmt = $conn->prepare($sql);
                        $sub_stmt->execute();
                        $result = $sub_stmt->get_result();
                        $is_last = $result->num_rows;
                        if ($is_last == 1) {
                            $data_last = $result->fetch_array();
                            $last_id = $data_last['refill_id'] + 1;
                        }
                        if ($is_last == 0) {
                            $last_id = 1;
                        }
                        $sub_stmt->close();
                       
                        $SQL = "SELECT * FROM tbl_x_member_time WHERE member_id = ? && stop >= ?  ORDER BY stop DESC limit 0,1";
                        $sub_query = $conn->prepare($SQL);
                        $sub_query->bind_param("ss", $_SESSION['x_member_id'],$now);
                        $sub_query->execute();
                        $result = $sub_query->get_result();
                        $is_remaining = $result->num_rows;
                        if ($is_remaining == 1) {
                            $sub_data = $result->fetch_array();
                            $last_stop = $sub_data['stop'];
                            $strtime = strtotime("$last_stop");
                            $new_stop = date("Y-m-d H:i:s", $strtime + (60 * 60 * 24 * $day));
                           
                            $msg = "INSERT INTO tbl_x_member_time (refill_id, member_id, card_id, start, stop, create_date) VALUES (?,?,?,?,?,?)";
                            $query = $conn->prepare($msg);
                            $query->bind_param("ssssss",$last_id,$_SESSION['x_member_id'],$card_id,$last_stop,$new_stop,$now);
                            $query->execute();
                            $query->close();
                            
                            $active = 1;
                            $sql = "UPDATE tbl_x_card SET active = ? WHERE card_id = ?";
                            $sub_stmt = $conn->prepare($sql);
                            $sub_stmt->bind_param("is",$active,$card_id);
                            $sub_stmt->execute();
                            $sub_stmt->close();
                        }
                        if ($is_remaining == 0) {
                            $next = date("Y-m-d H:i:s", time() + (60 * 60 * 24 * $day));
                            
                            $msg = "INSERT INTO tbl_x_member_time (refill_id, member_id, card_id, start, stop, create_date) VALUES (?,?,?,?,?,?)";
                            $query = $conn->prepare($msg);
                            $query->bind_param("ssssss",$last_id,$_SESSION['x_member_id'],$card_id,$now,$next,$now);
                            $query->execute();
                            $query->close();

                            $active = 1;
                            $sql = "UPDATE tbl_x_card SET active = ? WHERE card_id = ?";
                            $sub_stmt = $conn->prepare($sql);
                            $sub_stmt->bind_param("is",$active,$card_id);
                            $sub_stmt->execute();
                            $sub_stmt->close();
                        }
                        $sub_query->close();
                        //----------- For Corporate Master ID ---------------//
                        
                        $co_table = "UPDATE tbl_x_member_amount SET amount=(amount+$day) WHERE member_id = ?";
                        $co_stmt = $conn->prepare($co_table);
                        $co_stmt->bind_param("s",$_SESSION['x_member_id']);
                        $co_stmt->execute();
                        $co_stmt->close();
                    }
                    if ($check_master === "personal") {
                        $now = date("Y-m-d H:i:s");
                        $SQL = "SELECT * FROM tbl_x_member_total WHERE member_id = ?";
                        $str = $conn->prepare($SQL);
                        $str->bind_param("s", $_SESSION['x_member_id']);
                        $str->execute();
                        $result = $str->get_result();
                        $is_have = $result->num_rows;
                        $str->close();
                        if ($is_have == 0) {
                            
                            $msg = "INSERT INTO tbl_x_member_total (member_id, amount) VALUES (?,?)";
                            $query = $conn->prepare($msg);
                            $query->bind_param("ss",$_SESSION['x_member_id'],$day);
                            $query->execute();
                            $query->close();

                            // สำหรับ personal เมื่อทำการ refill แล้วให้ทำการ active user
                        }
                        if ($is_have == 1) {
                           
                            $msg = "UPDATE tbl_x_member_total SET amount = (amount+$day) WHERE member_id = ?";
                            $query = $conn->prepare($msg);
                            $query->bind_param("s",$_SESSION['x_member_id']);
                            $query->execute();
                            $query->close();
                        }

                        $msg = "INSERT INTO tbl_x_member_refill (member_id, card_id, create_date) VALUES (?,?,?)";
                        $query = $conn->prepare($msg);
                        $query->bind_param("sss",$_SESSION['x_member_id'],$card_id,$now);
                        $query->execute();
                        $query->close();

                        $active = 1;
                        $sql = "UPDATE tbl_x_card SET active = ? WHERE card_id = ?";
                        $sub_query = $conn->prepare($sql);
                        $sub_query->bind_param("is",$active,$card_id);
                        $sub_query->execute();
                        $sub_query->close();
                    }
                    echo "<script type=\"text/javascript\">
		                        window.location=\"?section=$_GET[section]&&status=$_GET[status]&&action=refill_complete\";
		                  </script>";
                    exit;
                } else {
                    $refill_error = " Code and PIN are Incorrect ";
                }
                //-----------------------------------------------------//
                $stmt->close();
            }
        } else {
            $refill_error = " Please Insert Code , PIN and Verify Code ";
        }
    }
    // ------------------ fn refill --------------------------- //
    echo "
		<table id='refill_form_header_a' align=center width=70% cellpadding=5 cellspacing=0 border=0 style='cursor:pointer;'
			onclick=\"javascript:
						document.getElementById('refill_form').style.display='';
						document.getElementById('refill_form_header_a').style.display='none';
						document.getElementById('refill_form_header_b').style.display='';
					\">
			<form method=post action=?section=$_GET[section]&&status=$_GET[status]&&action=refill>
			<tr height=25></tr>
		</table>
		<table id='refill_form_header_b' align=center width=70% cellpadding=5 cellspacing=0 border=0 style='display:none; cursor:pointer;'
			onclick=\"javascript:
						document.getElementById('refill_form').style.display='none';
						document.getElementById('refill_form_header_a').style.display='';
						document.getElementById('refill_form_header_b').style.display='none';
					\">
		</table>";
    if ($_GET['action'] === "refill_complete") {
        echo "<div align=center style='margin-top: 45px;'>
                <font size=2 face=tahoma color=green>
                    <b><br>
						Your Refill is Complete . Please Check Refill Information in Refill History
                    <br>&nbsp;</b>
                </font>
              </div>";
    }
    
    echo " 
            <div class='welcome'>
                <p>Welcome To EOL System Program</p>
            </div>
            <br><br>
            <center><h1>Refill Form</h1></center>
			<table id='refill_form' align=center width=45% cellpadding=0 cellspacing=0 border=0 >
                
				<tr height=5 valign=middle >
					<td align=left colspan=2>
                        <a href='../info/refill_card.php' target='_blank'>วิธีการ refill</a> 
                        <hr>
					</td>
                    <td align=right>
                        <a href='../shop/product_personal.php' target='_blank'>สั่งซื้อ Refill Card</a> 
                        <hr>
					</td>
				</tr>
				<tr height=15 ><td colspan=3></td></tr>
				<tr >
					<td align=center width=35%><font size=3 face=tahoma color=black><b>Code</b></font></td>
					<td align=center width=5%><font size=2 face=tahoma color=black><b>&nbsp;:&nbsp;</b></font></td>
					<td align=left width=60%><input type=text size=22 name=code value='$_POST[code]' placeholder='Please Enter Your Code' style='border:1px solid #ccc; padding:10px 15px; border-radius:5px' required></td>
				</tr>
				<tr height=10 ><td colspan=3></td></tr>
				<tr >
					<td align=center ><font size=3 face=tahoma color=black><b>PIN</b></font></td>
					<td align=center ><font size=2 face=tahoma color=black><b>&nbsp;:&nbsp;</b></font></td>
					<td align=left ><input type=text size=22 name=pin value='$_POST[pin]' placeholder='Please Enter Your Pin' style='border:1px solid #ccc; padding:10px 15px; border-radius:5px' required></td>
				</tr>
				<tr height=15 ><td colspan=3></td></tr>
				<tr >
					<td align=center ><font size=2 face=tahoma color=black><b>Verify Code</b></font></td>
					<td align=center ><font size=2 face=tahoma color=black><b>&nbsp;:&nbsp;</b></font></td>
					<td align=left >
						<font size=2 face=tahoma color=black><b>";
                        
    $rand_a = rand(1, 5);
    $rand_b = rand(1, 5);
    $result = $rand_a + $rand_b;
    if (isset($_SESSION['verifly'])) {
        unset($_SESSION['verifly']);
        $_SESSION['verifly'] = $result;
    }else{
        $_SESSION['verifly'] = $result;
    }
    
    $ran_msg = "$rand_b + $rand_a = ";
    echo "$ran_msg <input type=text size=7 name=verifly maxlength=2 required placeholder='Result' style='padding:3px 0px 3px 10px;border:1px solid #ccc; border-radius:5px'> ";
    echo "
						</b></font>
					</td>
				</tr>
				<tr height=20 ><td colspan=3></td></tr>";
    if ($refill_error) {
        echo "
				<tr height=25 >
					<td align=center colspan=3><font size=2 face=tahoma color=red>$refill_error</font></td>
				</tr>
				<tr height=10 ><td colspan=3></td></tr>";
    }
    echo "
				<tr >
					<td align=center ></td>
					<td align=center ></td>
					<td align=left ><input type=submit value='&nbsp; Refill Account &nbsp;' class='refill_account'></td>
				</tr>
				<tr height=20 >
                    <td colspan=3></td>
                </tr>
                <tr height=0 valign=middle >
					<td align=center colspan=3>
                        <hr>
					</td>
				</tr>
			</table>
		</form>";
    if ($refill_error) {
        echo "<script language=\"javascript\">
            document.getElementById('refill_form').style.display = '';
            document.getElementById('refill_form_header_a').style.display = 'none';
            document.getElementById('refill_form_header_b').style.display = '';
        </script>";
    }
    mysqli_close($conn);
}
// -------------------------- REFILL HISTORY ---------------- //
function refill_history($check_master) {
    
    include('../config/connection.php');
    echo "
		<link rel=\"stylesheet\" type=\"text/css\" href=\"../bootstrap/css/refill-hide.css\" />
		<table id='refill_history_header_a' align=center width=45% cellpadding=5 cellspacing=0 border=0>
		    <!-- Refill History -->
			<tr height=10>
                <td><input type='submit' name='refill' value='Refill History' class='refill_history'
                    onclick=\"javascript:
                                document.getElementById('refill_history').style.display='';
                            \">
                </td>
            </tr>
		</table>
			
		<table id='refill_history' align=center width=70% cellpadding=0 cellspacing=0 border=1 style='display:none;border-radius:2px;' bgcolor='#ccc'>";
    //---------------------------------------------------------//		
    if ($check_master === "personal") {
        // -------------- แสดงตาราง refill history -------------- //
        echo "	
			<tr height=25>
				<td align=center><font size=2 face=tahoma color='black'><b>Refill Date</b></font></td>
				<td align=center colspan=3><font size=2 face=tahoma color='black'><b>EOL Refill Card List</b></font></td>
			</tr>";
        //---------------------------------------------------------//
       
        $strSQL = "SELECT * FROM tbl_x_member_refill WHERE member_id = ? ORDER BY create_date DESC";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $_SESSION['x_member_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $num = $result->num_rows;
        $j = 1;
        while ($data_result = $result->fetch_assoc()) {
            $t_card_id[$j] = $data_result['card_id'];
            $t_create_date[$j] = $data_result['create_date'];
            $j++;
        }
        $stmt->close();
        for ($i = 1; $i <= $num; $i++) {
            $card_id = $t_card_id[$i];
            $create_date = $t_create_date[$i];
            
            $SQL = "SELECT * FROM tbl_x_card WHERE card_id = ?";
            $query = $conn->prepare($SQL);
            $query->bind_param("s", $card_id);
            $query->execute();
            $result = $query->get_result();
            $is_have = $result->num_rows;

            if ($is_have == 1) {
                $sub_data = $result->fetch_array();
                $type_id = $sub_data['type_id'];
            }
            $query->close();
            
            $sql = "SELECT * FROM tbl_x_card_type WHERE type_id = ?";
            $sub_stmt = $conn->prepare($sql);
            $sub_stmt->bind_param("s", $type_id);
            $sub_stmt->execute();
            $result = $sub_stmt->get_result();
            $is_type = $result->num_rows;
            if ($is_type == 1) {
                $sub_data = $result->fetch_array();
            }
            
            if ($card_id) {
                $type_msg = "$sub_data[type_name] [ $sub_data[cost] Baht ]";
            } else {
                $type_msg = "Corporate Refill by Master Account";
            }
            if ($card_id == -1) {
                $type_msg = "Refill 1 day from Personal Available Day";
            }
            $sub_stmt->close();
            //--------------------------------------------------------------------//
            echo "  <tr height=25 bgcolor='white'>
						<td align=center><font size=2 face=tahoma color=brown>$create_date</font></td>
						<td align=left colspan=3><font size=2 face=tahoma color=blue>&nbsp; $type_msg</font></td>
					</tr>";
        }
        if ($num == 0) {
            // --------- กรณีไม่มี history แสดงข้อความข้างล่างนี้ ------------ //
            echo "	<tr height=50 bgcolor='white'>
						<td align=center colspan=4><font size=3 face=tahoma color=red>Didn't find any Refill History</font></td>
					</tr>";
        }
    }
    //--------------------------------------------------------//	
    echo "
				<tr height=5>
					<td align=center width=20% rowspan=2><font size=2 face=tahoma color=black><b>Refill Date</b></font></td>
					<td align=center width=40% rowspan=2><font size=2 face=tahoma color=black><b>Refill List</b></font></td>";
    if ($check_master === "personal") {
            echo "  <td align=center width=40% colspan=2><font size=2 face=tahoma color=black><b>Available Time</b></font></td>";
    }
    echo "
				</tr>
				<tr height=25>";
    if ($check_master === "personal") {
        echo "
					<td align=center width=20% ><font size=2 face=tahoma color=green><b>From</b></font></td>
					<td align=center width=20% ><font size=2 face=tahoma color=red><b>Until</b></font></td>";
    }
    echo "      </tr>";
    
    //---------------------------------------------------------//
    
    $strSQL = "SELECT * FROM tbl_x_member_time WHERE member_id = ? ORDER BY create_date DESC";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $_SESSION['x_member_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->num_rows;

    $j = 1;
    while ($data_result = $result->fetch_assoc()) {
        $t_card_id[$j] = $data_result['card_id'];
        $t_start[$j] = $data_result['start'];
        $t_stop[$j] = $data_result['stop'];
        $t_create_date[$j] = $data_result['create_date'];
        $j++;
    }
    
    $stmt->close();
    for ($i = 1; $i <= $num; $i++) {
        $card_id = $t_card_id[$i];
        $start = $t_start[$i];
        $stop = $t_stop[$i];
        $create_date = $t_create_date[$i];
        //--------------------------------------------------------------------//

        $SQL = "SELECT * FROM tbl_x_card WHERE card_id = ?";
        $query = $conn->prepare($SQL);
        $query->bind_param("s", $card_id);
        $query->execute();
        $result = $query->get_result();
        $is_have = $result->num_rows;

        if ($is_have == 1) {
            $sub_data = $result->fetch_array();
            $type_id = $sub_data['type_id'];
        }
        $query->close();
        //--------------------------------------------------------------------//
       
        $sql = "SELECT * FROM tbl_x_card_type WHERE type_id = ?";
        $sub_stmt = $conn->prepare($sql);
        $sub_stmt->bind_param("s", $type_id);
        $sub_stmt->execute();
        $result = $sub_stmt->get_result();
        $is_type = $result->num_rows;
        if ($is_type == 1) {
            $sub_data = $result->fetch_array();
        }
        //--------------------------------------------------------------------//
        if ($card_id) {
            $type_msg = "$sub_data[type_name] [ $sub_data[cost] Baht ]";
        } else {
            $type_msg = "Corporate Refill by Master Account";
        }
        if ($card_id == -1) {
            $type_msg = "Refill 1 day from Personal Available Day";
        }
        $sub_stmt->close();
        //--------------------------------------------------------------------//
        echo "
						<tr height=15 bgcolor='white'>
							<td align=center><font size=2 face=tahoma color=brown>$create_date</font></td>
							<td align=left><font size=2 face=tahoma color=blue>&nbsp; $type_msg</font></td>";
        if ($check_master === "personal") {
            echo "
							<td align=center><font size=2 face=tahoma color=green>$start</font></td>
							<td align=center><font size=2 face=tahoma color=red>$stop</font></td>
						</tr>";
        }
    }
    if ($num == 0) {
        echo "	
						<tr height=35 bgcolor='white'>
							<td align=center colspan=4><font size=3 face=tahoma color=red>Didn't find any Refill History</font></td>
						</tr>";
    }
    //---------------------------------------------------------//
    
    echo "
            <tr height=15 align='center'>
                <td>
                    <a href='#' class='button button-gray' 
                    onclick=\"javascript:
                                    document.getElementById('refill_history').style.display='none';
                            \">Hide</a>
                </td>
            </tr>
		</table>
        <br>&nbsp;";
    if ($_GET['action'] === "refill_complete") {
        echo "<script language=\"javascript\">
            document.getElementById('refill_history').style.display = '';
            document.getElementById('refill_history_header_a').style.display = 'none';
            <!-- document.getElementById('refill_history_header_b').style.display = ''; -->
        </script>";
    }
    mysqli_close($conn);
}
function expired_test(){
    include('../config/connection.php');
    $number = 1;
    $strSQL = "SELECT * FROM tbl_x_member_refill WHERE member_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $_SESSION['x_member_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_have = $result->num_rows;
    $stmt->close();
    $is_sub = check_sub_member();
    if($is_have == 0 && $_SESSION['sub_member'] != true &&  $_SESSION['personal'] == true && $is_sub == 0){
        header("Location:?section=$_GET[section]&&status=refill");
    }
    // else{
    //     echo " <div style='position:absolute;margin-top:110px;margin-left:330px;z-index:100;'>
    //                 <a href='?section=business&&action=report'>
    //                     <img class='img_hover' src='https://www.engtest.net/image2/eol system/report-new.png' border=0 />
    //                 </a>
    //            </div>";
    // }
    echo "
    <div style='position:absolute;margin-top:110px;margin-left:330px;z-index:100;'>
        <a href='?section=business&&action=report'>
            <img class='img_hover' src='../images/image2/eol system/report-new.png' border=0>
        </a>
    </div>

    <div  style='position:absolute;top:650px;margin-left:50px;z-index:100px;'>
        <a href='../shop/product_personal.php' target=_blank border=0><img  class='img_hover' src='../images/image2/eol system/purchase-card.png' border=0>
        </a>
    </div>
    <img src='../images/image2/eol system/bg-free-09.jpg' style='border-radius:10px;'>";
}

function get_sub_member($sub_id){
    include('../config/connection.php');
    $strSQL = "SELECT * FROM tbl_x_member_sub WHERE master_id = ? && sub_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ss", $_SESSION['x_member_id'], $sub_id);
    $stmt->execute();
    $result = $stmt->get_result();       
    $is_sub = $result->num_rows;
    $stmt->close();
    return $is_sub;
}

function get_group_sub_member($type_id){
    include('../config/connection.php');
    $strSQL = "SELECT * FROM tbl_x_member_sub WHERE master_id = ? && type_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("si", $_SESSION['x_member_id'],$type_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $each_group = $result->num_rows; 
    $stmt->close();
    return $each_group;
}

function check_sub_member(){
    include('../config/connection.php');
    $SQL = "SELECT a.sub_id,a.master_id,b.amount FROM tbl_x_member_sub AS a,tbl_x_member_amount AS b WHERE a.sub_id=? && a.master_id=b.member_id";
    $query = $conn->prepare($SQL);
    $query->bind_param("s", $_SESSION['x_member_id']);
    $query->execute();
    $result = $query->get_result();
    $is_sub = $result->num_rows;
    $query->close();
    return $is_sub;
}

function check_time_member($id,$start,$stop){
    include('../config/connection.php');
    $SQL = "SELECT * FROM tbl_x_member_time WHERE member_id=? AND start <= ? AND stop >= ?";
    $query = $conn->prepare($SQL);
    $query->bind_param("sss", $id,$start,$stop);
    $query->execute();
    $result = $query->get_result();       
    $usable = $result->num_rows;
    $query->close();
    return $usable;
}

function process_date($timestamp) {
    $thMonth = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    $date = date("j", $timestamp);
    $month = $thMonth[date("m", $timestamp) - 1];
    $y = date("Y", $timestamp) + 543;
    $t1 = "$date $month $y";
    $t2 = "$date $month";
    if ($timestamp > strtotime(date("Y-01-01 00:00:00"))) {
        $text = $t2 . " เวลา " . date("G:i ", $timestamp) . " น.";
    } else {
        $text = $t1 . " เวลา " . date("G:i ", $timestamp) . " น.";
    }
    return $text;
}

function is_mobile()
{

    // Get the user agent

    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    // Create an array of known mobile user agents
    // This list is from the 21 October 2010 WURFL File.
    // Most mobile devices send a pretty standard string that can be covered by
    // one of these. I believe I have found all the agents (as of the date above)
    // that do not and have included them below. If you use this function, you
    // should periodically check your list against the WURFL file, available at:
    // https://wurfl.sourceforge.net/


    $mobile_agents = Array(

        "240x320",
        "acer",
        "acoon",
        "acs-",
        "abacho",
        "ahong",
        "airness",
        "alcatel",
        "amoi",
        "android",
        "anywhereyougo.com",
        "applewebkit/525",
        "applewebkit/532",
        "asus",
        "audio",
        "au-mic",
        "avantogo",
        "becker",
        "benq",
        "bilbo",
        "bird",
        "blackberry",
        "blazer",
        "bleu",
        "cdm-",
        "compal",
        "coolpad",
        "danger",
        "dbtel",
        "dopod",
        "elaine",
        "eric",
        "etouch",
        "fly " ,
        "fly_",
        "fly-",
        "go.web",
        "goodaccess",
        "google",
        "gradiente",
        "grundig",
        "haier",
        "hedy",
        "hitachi",
        "htc",
        "honor",
        "huawei",
        "hutchison",
        "inno",
        "infinix",
        "ipad",
        "ipaq",
        "ipod",
        "iphone",
        "itel",
        "jbrowser",
        "kddi",
        "kgt",
        "kwc",
        "lenovo",
        "lg ",
        "lg2",
        "lg3",
        "lg4",
        "lg5",
        "lg7",
        "lg8",
        "lg9",
        "lg-",
        "lge-",
        "lge9",
        "longcos",
        "maemo",
        "mercator",
        "meridian",
        "micromax",
        "midp",
        "mini",
        "mitsu",
        "mmm",
        "mmp",
        "mobi",
        "mot-",
        "moto",
        "motorola",
        "nec-",
        "netfront",
        "newgen",
        "nexian",
        "nf-browser",
        "nintendo",
        "nitro",
        "nokia",
        "nook",
        "novarra",
        "obigo",
        "oppo",
        "oneplus",
        "palm",
        "panasonic",
        "pantech",
        "philips",
        "phone",
        "pg-",
        "playstation",
        "poco",
        "pocket",
        "pt-",
        "qc-",
        "qtek",
        "rover",
        "redmi",
        "realme",
        "sagem",
        "sama",
        "samu",
        "sanyo",
        "samsung",
        "sch-",
        "scooter",
        "sec-",
        "sendo",
        "sgh-",
        "sharp",
        "siemens",
        "sie-",
        "softbank",
        "sony",
        "spice",
        "sprint",
        "spv",
        "symbian",
        "tablet",
        "talkabout",
        "tcl-",
        "teleca",
        "telit",
        "tianyu",
        "tim-",
        "toshiba",
        "tsm",
        "up.browser",
        "utec",
        "utstar",
        "verykool",
        "virgin",
        "vivo",
        "vk-",
        "voda",
        "voxtel",
        "vx",
        "wap",
        "wellco",
        "wig browser",
        "wii",
        "windows ce",
        "wireless",
        "xda",
        "xde",
        "xiaomi",
        "zte"
    );

    // Pre-set $is_mobile to false.

    $is_mobile = false;

    // Cycle through the list in $mobile_agents to see if any of them
    // appear in $user_agent.

    foreach ($mobile_agents as $device) {

    // Check each element in $mobile_agents to see if it appears in
    // $user_agent. If it does, set $is_mobile to true.

        if (stristr($user_agent, $device)) {
            $is_mobile = true;
            // break out of the foreach, we don't need to test
            // any more once we get a true value.
            break;
        }
    }

    return $is_mobile;
}


?>