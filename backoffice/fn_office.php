<?php
ob_start();
date_default_timezone_set('Asia/Bangkok');
office_main();

function office_main()
{
    ?>
<nav class='navbar'>
    <div class="container-nav">
        <div class="navbar-header">
            <a class="navbar-brand" href="../index.php" style="color:#FFFFFF !important;">
                <img src="../images/index/logo-eol.png" style="height:40px;margin-top:12px;" />
            </a>
            <?php
                if ($_SESSION["admin_id"] != "") {
                    ?>
            <div class="pull-right">
                <a href="../backoffice/mainoffice.php?section=office&&status=logout"
                    style="height:40px;margin-top:12px;">
                    <img src="../2010/temp_images/temp/button/bt_logout.png" style="height:50px; margin-right:35px;"
                        title="Logout" />
                </a>
            </div>
            <?php
                }
                ?>
        </div>
    </div>
</nav>
<div>
    <?php display_body(); ?>
</div>

<footer>
    <hr class="f-top">Copyright © 2022 By English Online Co.,Ltd. All rights reserved.
    <hr class="f-bottom">
</footer>
<?php
}

function display_body()
{
    if ($_SESSION["admin_id"] != '') {
        echo "<div class='main'>";
        admin_profile();
        if ($_GET['status'] === "logout") {
            logout();
        }
        if (!$_GET['status']) {
            display_admin_menu();
        }
        if ($_GET['type']) {
            check_permission($_GET['type']);
            $type = explode("-", $_GET['type']);
            $main_type = $type[0] + 0;
            $sub_type = $type[1] + 0;
            if ($main_type == 0) {
                if ($sub_type == 1) {
                    if ($_GET['status'] === "list") {
                        display_user_list();
                    }
                    if ($_GET['status'] === "edit_active") {
                        edit_active();
                    }
                    if ($_GET['status'] === "edit_form") {
                        edit_user_form();
                    }
                    if ($_GET['status'] === "edit_user") {
                        edit_user();
                    }
                    if ($_GET['status'] === "delete_user") {
                        delete_user();
                    }
                    if ($_GET['status'] === "add_form") {
                        add_user_form();
                    }
                    if ($_GET['status'] === "add_user") {
                        add_user_form();
                    }
                }
            } else {
                if ($_GET['status'] === "list" && $_GET['type'] == "18-01") {
                    back_to_main_page();
                    include('fn_manage_eolcontest.php');
                }
                if ($_GET['status'] === "list" && $_GET['type'] == "02-04") {
                    feedback_list();
                }
                if ($_GET['status'] === "list" && $_GET['type'] != "02-04" && $_GET['type'] != "18-01") {
                    fn_display_list();
                }
                if ($_GET['status'] === "add_topic_form") {
                    add_topic_form();
                }
                if ($_GET['status'] === "edit_topic_form") {
                    edit_topic_form();
                }
                if ($_GET['status'] === "delete_topic") {
                    delete_topic();
                }
                if ($_GET['status'] === "edit_active") {
                    edit_active();
                }
                if ($_GET['status'] === "view_detail") {
                    view_detail();
                }
            }
        }
        echo "</div>";
    }
    if ($_SESSION["admin_id"] == '') {
        if ($_GET['status'] === "login_form") {
            login_form($_GET['error']);
        }
        if ($_GET['status'] === "login") {
            if ($_POST['username'] && $_POST['password']) {
                login($_POST['username'], $_POST['password']);
            } else {
                echo "<script type=\"text/javascript\">
                            window.location=\"?section=office&&status=login_form&&error=1\";
                      </script>";
                exit();
            }
        }
        if (!$_GET['status']) {
            echo "<script type=\"text/javascript\">
                        window.location=\"?section=office&&status=login_form\";
                  </script>";
            exit();
        }
        if ($_GET['type'] && $_GET['status']) {
            echo "<script type=\"text/javascript\">
                        window.location=\"?section=office&&status=login_form&&error=3\";
                  </script>";
            exit();
        }
    }
}

function login_form($error)
{

    if ($_SESSION["admin_id"] == '') {
        $msg = '';
        if ($error == '1') {
            $msg = "<font size=2 face=tahoma color=red><b>Username or Password Incorrect</b></font>";
        }
        if ($error == '2') {
            $msg = "<font size=2 face=tahoma color=red><b>Username & Password ถูกระงับชั่วคราว</b></font>";
        }
        if ($error == '3') {
            $msg = "<font size=2 face=tahoma color=red><b>Session Expired!!!, Please Login again</b></font>";
        }
        ?>
<div class="row form-login">
    <div class="col-sm-6 col-sm-offset-3 form-box">
        <div class="form-top">
            <div class="form-top-left">
                <h3>Administrator Login Form</h3>
                <p>Enter your username and password to log on:</p>
                <?if($error){?>
                <p>
                    <?php echo $msg; ?>
                </p>
                <?}?>
            </div>
            <div class="form-top-right" style="margin-top: 60px;">
                <i class="fa fa-key"></i>
            </div>
        </div>
        <div class="form-bottom">
            <form role="form" action="?section=office&&status=login" method="post" class="login-form">
                <div class="form-group">
                    <label class="sr-only" for="username">Username</label>
                    <input type="text" name="username" placeholder="Username..." class="form-username form-control"
                        id="form-username" required="required">
                </div>
                <div class="form-group">
                    <label class="sr-only" for="password">Password</label>
                    <input type="password" name="password" placeholder="Password..." class="form-password form-control"
                        id="form-password" required="required">
                </div>
                <button type="submit" class="btn">LOGIN</button>
            </form>
        </div>
    </div>
</div>
<?php
    }
}

function login($user, $pass)
{
    include('../config/connection.php');
    $username = $conn->real_escape_string(trim($user));
    $password = $conn->real_escape_string(trim($pass));
    $strSQL = "SELECT * FROM tbl_web_admin WHERE user=? && pass=?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_have = $result->num_rows;

    if ($is_have == 1) {
        $data = $result->fetch_array();
        $stmt->close();

        if ($data['is_active'] == 0) {
            echo "<script type=\"text/javascript\">
					window.location=\"?section=office&&status=login_form&&error=2\";
				 </script>";
            exit();
        } else {
            $_SESSION["admin_id"] = trim($data['admin_id']);
            $type_id = "00-02";
            $SQL = "SELECT * FROM tbl_permission WHERE admin_id = ? && type_id = ?";
            $query = $conn->prepare($SQL);
            $query->bind_param("ss", $data['admin_id'], $type_id);
            $query->execute();
            $result = $query->get_result();
            $rows = $result->num_rows;
            if ($rows == 1) {
                $_SESSION["level"] = "admin";
            } else {
                $_SESSION["level"] = "user";
            }

            echo "<script type=\"text/javascript\">
            		  window.location=\"?section=office\";
            	  </script>";
            exit;
        }
    } else {
        echo "<script type=\"text/javascript\">
                window.location=\"?section=office&&status=login_form&&error=1\";
             </script>";
        exit;
    }
}

function display_admin_menu()
{

    include('../config/connection.php');
    $topic[0] = "Manage User";
    $topic[1] = "Manage Main Menu";
    $topic[2] = "Manage Activity and News";
    $topic[3] = "Manage Interesting From EOL";
    $topic[4] = "Manage News";
    $topic[5] = "Manage Entertainment";
    $topic[6] = "Manage English Channel";
    $topic[7] = "Manage English E-Testing";
    $topic[10] = "Manage E-Learning";
    $topic[11] = "Manage E-Learning Reading Comprehension";
    $topic[12] = "Manage E-Learning Listening Comprehension";
    $topic[13] = "Manage E-Learning Semi-Speaking ";
    $topic[14] = "Manage E-Learning Semi-Writing";
    $topic[15] = "Manage E-Learning Grammatical Structure ";
    $topic[16] = "Manage E-Learning Integrated Skill: Cloze Test";
    $topic[17] = "Manage E-Learning Vocabulary Items ";
    $topic[18] = "Manage EOL Contest Exam";
    $font = "<font size=2 face=tahoma><b>";
    
    for ($p = 0; $p <= 18; $p++) {
        $event = "0$p";
        if ($p >= 10) {
            $event = $p;
        }
        $strSQL = "SELECT * FROM tbl_permission WHERE admin_id = ? && type_id LIKE '$event-%' ";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $_SESSION['admin_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $check_num = $result->num_rows;
        $stmt->close();

        if ($check_num >= 1) {

            if ($check_num == 1) {
                $size = "95%";
            } else {
                $size = "40%";
            }

            $SQL = "SELECT * FROM tbl_web_type WHERE type_id LIKE '%$event-%'";
            $query = $conn->prepare($SQL);
            $query->execute();
            $result = $query->get_result();
            $num = $result->num_rows;
            $query->close();
            echo "<table class='tb-list-menu' align=center width=100% cellpadding=0 cellspacing=0 border=0>
                        <tr height=50>
                            <td width='5%'></td><td colspan=4><font size=2 face=tahoma color=yellow><b>&nbsp; $topic[$p]<b>
                            </td>
                        </tr>
                        <tr valign=middle>";
                        
            if ($num >= 1) {
                $amount = 0;
                for ($i = 1; $i <= $num; $i++) {
                    if ($i <= 9) {
                        $int = "0$i";
                    } else {
                        $int = $i;
                    }

                    $msg = "SELECT * FROM tbl_permission AS a, tbl_web_type AS b WHERE a.admin_id = ? && b.type_id = '$event-$int' && a.type_id LIKE '%$event-$int%'";
                    $sub_stmt = $conn->prepare($msg);
                    $sub_stmt->bind_param("s", $_SESSION['admin_id']);
                    $sub_stmt->execute();
                    $result = $sub_stmt->get_result();
                    $is_have = $result->num_rows;
                    if ($is_have >= 1) {
                        $amount = $amount + 1;
                        $data_detail = $result->fetch_array();

                        if ($data_detail['type_id'] == "00-02") {
                            echo "<td width='5%'>&nbsp;</td>
                                  <td width='40%'>&nbsp;</td>";
                        }
                        if ($data_detail['type_id'] != "00-02") {
                            echo "<td width='5%'></td>
                                  <td width=5%>
                                       <a href=?section=office&&type=$data_detail[type_id]&&status=list><img src=../2010/temp_images/temp/icon/$data_detail[type_id].png width=75 border=0></a>
                                  </td>
							      <td width=$size>&nbsp;
                                       <a href=?section=office&&type=$data_detail[type_id]&&status=list>$font $data_detail[type_name]</a>
                                  </td>";
                        }
                        if ($amount % 2 == 0) {
                            echo "</tr><tr valign=middle height=10><td></td></tr><tr>";
                        }
                    }
                    $sub_stmt->close();
                }
            }
            echo "</tr><tr><td colspan=4>&nbsp;</td></tr>";
            echo "</table>";
        }
    }
}

function admin_profile()
{
    include('../config/connection.php');
    $strSQL = "SELECT * FROM tbl_web_admin WHERE admin_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $_SESSION['admin_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_have = $result->num_rows;
    if ($is_have == 1) {
        $data = $result->fetch_array();
        echo "
			<br><br>
			<table align=left width=85% cellpadding=0 cellspacing=0 border=0 bgcolor=#6E6E6E style='margin-left:48px; margin-top:20px;'>
				<tr height=30 >
					<td align=left width=85% >
						&nbsp;<font size=2 face=tahoma color=ffffff><b>Welcome to Web Admin System : 
						<font size=2 face=tahoma color=orange><b>$data[prefix] $data[fname] $data[lname] [$data[nickname]]
					</td>
				</tr>
		    </table><br>";
    }
}

function logout()
{
    session_destroy();
    echo "<script type=\"text/javascript\">
            window.location=\"?section=office&&status=login_form\";
          </script>";
    exit;
}

function check_permission($type)
{
    include('../config/connection.php');
    $type_id = trim($type);
    $strSQL = "SELECT * FROM tbl_permission WHERE admin_id = ? && type_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ss", $_SESSION['admin_id'], $type_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_have = $result->num_rows;
    if ($is_have == 0) {
        echo "<script type=\"text/javascript\">
                    window.location=\"?section=office\";
              </script>";
        exit;
    }
}

function display_user_list()
{

    include('../config/connection.php');
    $font = "<font size=2 face=tahoma color=black><b>";
    //------------ button back to main page ---------------//
    back_to_main_page();
    echo "  <table class=head-list align=center  width=90%  bgcolor=C7C7C7>
                <tr height=25>
                    <td width=10% align=center rowspan=2 >$font Admin ID</td>
                    <td width=60% align=center rowspan=2 >$font Admin Name</td>
                    <td width=30% align=center colspan=3 >$font Management</td>
                </tr>
                <tr height=25>
                    <td width=10% align=center ><font size=2 face=tahoma color=green><b> Active </td>
                    <td width=10% align=center ><font size=2 face=tahoma color=48A7F0><b> Edit</td>
                    <td width=10% align=center ><font size=2 face=tahoma color=red><b> Delete</td>
                </tr>
            </table>";

    $strSQL = "SELECT * FROM tbl_web_admin";
    $stmt = $conn->prepare($strSQL);
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->num_rows;

    if ($num >= 1) {
        for ($i = 1; $i <= $num; $i++) {
            $data = $result->fetch_array();
            if ($i % 2 == 0) {
                $color = "bgcolor=#E3E3E3";
            } else {
                $color = "bgcolor=#DEDEDE";
            }
            if ($data['is_active'] == 1 && $data['admin_id'] == 1) {
                $active = "<font size=2 color=green><b>-";
            } else if ($data['is_active'] == 1) {
                $active = "<a href=?section=office&&type=$_GET[type]&&status=edit_active&&admin_id=$data[admin_id]><font size=2 color=green><b>Active</a>";
            } else {
                $active = "<a href=?section=office&&type=$_GET[type]&&status=edit_active&&admin_id=$data[admin_id]><font size=2 color=orange><b>Not Active</a>";
            }

            echo "
				<table class=listuser align=center cellpadding=0 cellspacing=0 border=0 width=90%  $color>
					<tr height=25>
						<td width=10% align=center>$font $data[admin_id]</td>
						<td width=60% align=center>
							<table align=center cellpadding=0 cellspacing=0 border=0 width=100% >
								<tr>
									<td width=40% align=left >$font &nbsp; $data[prefix]&nbsp;$data[fname]</td>
									<td width=35% align=left>$font &nbsp; $data[lname]</td>
									<td width=25% align=left>$font $data[nickname] &nbsp;</td>
								</tr>
							</table>
						</td>
						<td width=10% align=center>$font $active</td>
						<td width=10% align=center>";
            if ($data['admin_id'] == 1) {
                echo "<font size=2 face=tahoma color=48A7F0><b>-";
            } else {
                echo "<a href=?section=office&&type=$_GET[type]&&status=edit_form&&admin_id=$data[admin_id]><font size=2 face=tahoma color=48A7F0><b>Edit</a>";
            }
            echo " </td>
						<td width=10% align=center>";
            if ($data['admin_id'] != 1 && $data['admin_id'] != $_SESSION["admin_id"]) {
                echo "<a style='cursor:pointer;'  onclick=\"javascript:
                            if(confirm('Are you sure ? want delete this member ?'))
                            {	window.location='?section=office&&type=$_GET[type]&&status=delete_user&&admin_id=$data[admin_id]';	}
                        \" ><font size=2 face=tahoma color=red><b>Delete</a>";
            } else {
                echo "<font size=2 face=tahoma color=red><b> - </b></font>";
            }
            echo "
						</td>
					<tr>
				</table>";
        }
    }
    echo "<table class='tb-add-new-user' align=center cellpadding=0 cellspacing=0 border=1 width=90%>
            <tr height=30>
                <td colspan=5 align=center>
                    <a href=?section=office&&status=add_form&&type=$_GET[type]><font size=4 face=tahoma><b>&nbsp; - Add New User - </a>
                </td>
            </tr>
         </table>";
}

function edit_active()
{
    include('../config/connection.php');
    $array = explode("-", $_GET['type']);
    $main = $array[0] + 0;
    $sub = $array[1] + 0;
    $admin_id = trim($_GET['admin_id']);

    if ($main == 0) {
        if ($_GET['admin_id'] != 1) {
            $strSQL = "SELECT * FROM tbl_web_admin WHERE admin_id = ?";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("s", $admin_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $num = $result->num_rows;
            if ($num == 1) {
                $data = $result->fetch_array();
                if ($data['is_active'] == 0) {
                    $active = 1;
                } else {
                    $active = 0;
                }
                $SQL = "UPDATE tbl_web_admin SET is_active = ? WHERE admin_id = ?";
                $query = $conn->prepare($SQL);
                $query->bind_param("is", $active, $admin_id);
                $query->execute();
                $query->close();
            }
        }
        echo "<script type=\"text/javascript\">
                    window.location=\"?section=office&&status=list&&type=$_GET[type]\";
              </script>";
        exit;
    } else {
        $topic_id = trim($_GET['topic_id']);
        $strSQL = "SELECT * FROM tbl_web_topic WHERE topic_id = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $topic_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $num = $result->num_rows;
        if ($num == 1) {
            $data = $result->fetch_array();
            if ($data['topic_active'] == 0) {
                $active = 1;
            } else {
                $active = 0;
            }
            if ($main == 1 && $sub == 2) {
                if ($data['topic_active'] == 1) {
                    $active = 2;
                }
                if ($data['topic_active'] == 2) {
                    $active = 0;
                }
            }
            $SQL = "UPDATE tbl_web_topic SET topic_active = ? WHERE topic_id = ?";
            $query = $conn->prepare($SQL);
            $query->bind_param("is", $active, $topic_id);
            $query->execute();
            $query->close();
        }
        echo "<script type=\"text/javascript\">
                    window.location=\"?section=office&&status=list&&type=$_GET[type]&&page=$_GET[page]\";
              </script>";
        exit;
    }
}

function edit_user_form()
{
    include('../config/connection.php');
    $admin_id = trim($_GET['admin_id']);
    back_to_list($_GET['type']);
    $disable = NULL;
    $check = array();
    $array = array();
    $allow = array();
    $topic = array();
    $topic[0] = "<font size=2 face=tahoma color=ffff77><b> Manage User </b></font>";
    $topic[1] = "<font size=2 face=tahoma color=ffff77><b> Manage Main Menu </b></font>";
    $topic[2] = "<font size=2 face=tahoma color=ffff77><b> Manage Activity and News </b></font>";
    $topic[3] = "<font size=2 face=tahoma color=ffff77><b> Manage Interesting From EOL </b></font>";
    $topic[4] = "<font size=2 face=tahoma color=ffff77><b> Manage News </b></font>";
    $topic[5] = "<font size=2 face=tahoma color=ffff77><b> Manage Entertainment </b></font>";
    $topic[6] = "<font size=2 face=tahoma color=ffff77><b> Manage Channel </b></font>";
    $topic[7] = "<font size=2 face=tahoma color=ffff77><b> Manage E-Testing </b></font>";
    $topic[10] = "<font size=2 face=tahoma color=ffff77><b> Manage E-Learning  </b></font>";
    $topic[11] = "<font size=2 face=tahoma color=ffff77><b> Manage E-Learning Reading Comprehension </b></font>";
    $topic[12] = "<font size=2 face=tahoma color=ffff77><b> Manage E-Learning Listening Comprehension </b></font>";
    $topic[13] = "<font size=2 face=tahoma color=ffff77><b> Manage E-Learning Semi-Speaking </b></font>";
    $topic[14] = "<font size=2 face=tahoma color=ffff77><b> Manage E-Learning Semi-Writing </b></font>";
    $topic[15] = "<font size=2 face=tahoma color=ffff77><b> Manage E-Learning Grammatical Structure </b></font>";
    $topic[16] = "<font size=2 face=tahoma color=ffff77><b> Manage E-Learning Integrated Skill: Cloze Test </b></font>";
    $topic[17] = "<font size=2 face=tahoma color=ffff77><b> Manage E-Learning Vocabulary Items  </b></font>";
    $font = "<font size=2 face=tahoma color=cccccc><b>";

    $strSQL = "SELECT * FROM tbl_web_admin WHERE admin_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->num_rows;
    if ($num == 1) {
        $data = $result->fetch_array();

        echo "<br>
        <form name='edit_form' class='edit_form' action=?section=office&&type=$_GET[type]&&status=edit_user&&admin_id=$_GET[admin_id] method=post style='width:90%;'>
                <table align=center width=100% cellpadding=0 cellspacing=0 border=1 bordercolor=white >
                    <tr height=50>
                        <td align=center colspan=3><font size=3 face=tahoma color=ffff77 ><b>Admin Detail</td>
                    </tr>
                    <tr>
                        <td>
                        <table align=center width=90% cellpadding=0 cellspacing=0 border=0 >
                            <tr height=25>
                                <td width=20% align=right>$font <br>Admin ID</td>
                                <td width=5% align=center>$font <br>:</td>
                                <td width=80% align=left>$font <br>$data[admin_id]</td>
                            </tr>
                            <tr height=25>
                                <td align=right >$font Prefix</td>
                                <td align=center >$font : </td>
                                <td align=left ><input type=text size=10 name=prefix value='$data[prefix]'></td>
                            </tr>
                            <tr height=25>
                                <td align=right >$font Firstname</td>
                                <td align=center >$font : </td>
                                <td align=left ><input type=text size=20 name=fname value='$data[fname]'></td>
                            </tr>
                            <tr height=25>
                                <td align=right>$font Lastname</td>
                                <td align=center>$font : </td>
                                <td align=left><input type=text size=20 name=lname value='$data[lname]'></td>
                            </tr>
                            <tr height=25>
                                <td align=right>$font Email</td>
                                <td align=center>$font : </td>
                                <td align=left><input type=text size=30 name=email value='$data[email]'></td>
                            </tr>
                            <tr height=25>
                                <td width=20% align=right>$font Nickname</td>
                                <td width=5% align=center>$font :</td>
                                <td width=80% align=left><input type=text size=20 name=nickname value='$data[nickname]'></td>
                            </tr>
                            <tr height=25>
                                <td width=20% align=right>$font Username</td>
                                <td width=5% align=center>$font :</td>
                                <td width=80% align=left>$font $data[user]</td>
                            </tr>
                            <tr height=25>
                                <td width=20% align=right>$font Password</td>
                                <td width=5% align=center>$font :</td>
                                <td width=80% align=left><input type=password size=20 name=pass value='$data[pass]'></td>
                            </tr>
                            <tr height=15></tr>
                            <tr height=25>
                                <td width=80% align=center colspan=3><br>
                                    <font size=5 color=black> >> List Permission << </font>
                                </td>
                            </tr>
                            <tr>
                                <td width=100% align=left colspan=3>";

        $SQL = "SELECT * FROM tbl_web_type ORDER BY type_id";
        $query = $conn->prepare($SQL);
        $query->execute();
        $result_type = $query->get_result();
        $sub_num = $result_type->num_rows;

        $msg = "SELECT * FROM tbl_permission WHERE admin_id = ?";
        $sub_stmt = $conn->prepare($msg);
        $sub_stmt->bind_param("s", $admin_id);
        $sub_stmt->execute();
        $result_per = $sub_stmt->get_result();
        $per_num = $result_per->num_rows;

        if ($per_num >= 1) {
            for ($k = 1; $k <= $per_num; $k++) {
                $per_data = $result_per->fetch_array();
                $allow[$k] = $per_data['type_id'];
            }
        }
        $sub_stmt->close();

        if ($sub_num >= 1) {
            echo "<table class='list-permission' align=center cellpadding=0 cellspacing=0 border=0 width=100%>";
            for ($i = 1; $i <= $sub_num; $i++) {
                $permission = $result_type->fetch_array();
                $array = explode("-", $permission['type_id']);
                $name = $permission['type_id'];
                $prefix = $array[0] + 0;
                $suffix = $array[1] + 0;

                if ($prefix == 0) {
                    $color = "red";
                }
                if ($prefix == 1) {
                    $color = "blue";
                }
                if ($prefix == 2) {
                    $color = "green";
                }
                if ($prefix == 3) {
                    $color = "orange";
                }
                if ($prefix == 4) {
                    $color = "brow";
                }
                if ($prefix == 5) {
                    $color = "gray";
                }
                if ($suffix == 1) {
                    echo "<tr>
                              <td colspan=3>
                                 <br>
                                 $topic[$prefix]
                              </td>
                          </tr>";
                }
                if ($per_num >= 1) {
                    for ($p = 1; $p <= $per_num; $p++) {
                        if ($permission['type_id'] == $allow[$p]) {
                            $check[$i] = "checked";
                        }
                    }
                }
                if ($_GET['admin_id'] == 1) {
                    $disable = 'disabled=disabled';
                }
                echo "<td width=50%>
                          <input type=checkbox name='$name' id='chk$name' $check[$i] value='1' $disable> $font $permission[type_name]
                      </td>";

                if ($suffix % 2 == 0) {
                    echo "<tr></tr>";
                }
            }
            $query->close();
            echo "</table>";
        }

        echo "
									<br><br><div align=center><font size=2 color=77ff77 face=tahoma><b>After Set New Permission Some Effect Is Activate After Next Login</div><br><br>
									<div align=center><input class='edit-personal' type=submit value='Edit Personal Data'></div>	
								</td>
							</tr>
							<tr>
								<td align=center colspan=3>&nbsp;</td>
							</tr>
						</table>
					</td>
                </tr>
            </table>
		</form>";
    }
    $stmt->close();
}

function edit_user()
{
    include('../config/connection.php');
    $admin_id = trim($_GET['admin_id']);
    if ($_POST['prefix'] && $_POST['fname'] && $_POST['lname'] && $_POST['nickname'] && $_POST['pass']) {
        $prefix = trim($_POST['prefix']);
        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        $nickname = trim($_POST['nickname']);
        $pass = trim($_POST['pass']);
        $email = trim($_POST['email']);

        $strSQL = "UPDATE tbl_web_admin SET prefix = ?, fname = ?, lname = ?, nickname = ?, pass = ?, email = ? WHERE admin_id = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("sssssss", $prefix, $fname, $lname, $nickname, $pass, $email, $admin_id);
        $stmt->execute();
        $stmt->close();
    }
    $SQL = "SELECT * FROM tbl_web_type ORDER BY type_id";
    $query = $conn->prepare($SQL);
    $query->execute();
    $result = $query->get_result();
    $num = $result->num_rows;
    if ($num >= 1) {
        $msg = "DELETE FROM tbl_permission WHERE admin_id = ?";
        $sub_stmt = $conn->prepare($msg);
        $sub_stmt->bind_param("s", $admin_id);
        $sub_stmt->execute();
        $sub_stmt->close();

        for ($i = 1; $i <= $num; $i++) {
            $data = $result->fetch_array();
            $type_id = $data['type_id'];
            if ($_POST[$type_id] == 1) {
                $strSQL = "INSERT INTO tbl_permission (admin_id,type_id) VALUES(?,?)";
                $stmt = $conn->prepare($strSQL);
                $stmt->bind_param("ss", $admin_id, $type_id);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
    $query->close();
    echo "<script type=\"text/javascript\">
                window.location=\"?section=office&&type=$_GET[type]&&status=edit_form&&admin_id=$admin_id\";
          </script>";
    exit;
}

function delete_user()
{
    include('../config/connection.php');
    $admin_id = trim($_GET['admin_id']);
    if ($admin_id != 1) {
        $strSQL = "DELETE FROM tbl_permission WHERE admin_id = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $admin_id);
        $stmt->execute();
        $stmt->close();
        $SQL = "DELETE FROM tbl_web_admin WHERE admin_id = ?";
        $query = $conn->prepare($SQL);
        $query->bind_param("s", $admin_id);
        $query->execute();
        $query->close();
        echo "<script type=\"text/javascript\">
                    window.location=\"?section=office&&status=list&&type=$_GET[type]\";
              </script>";
        exit;
    }
}
function add_user_form()
{
    include('../config/connection.php');
    if ($_GET['status'] === "add_user") {
        if ($_POST['prefix'] && $_POST['fname'] && $_POST['lname'] && $_POST['nickname'] && $_POST['user'] && $_POST['pass'] && $_POST['email']) {

            $user = trim($_POST['user']);
            $strSQL = "SELECT * FROM tbl_web_admin WHERE user = ?";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $result = $stmt->get_result();
            $is_have = $result->num_rows;
            $stmt->close();
            if ($is_have == 1) {
                $error['user'] = "This Username is Already Register";
            }
            if (!$error) {
                $strSQL = "SELECT * FROM tbl_web_admin ORDER BY admin_id DESC limit 1";
                $stmt = $conn->prepare($strSQL);
                $stmt->execute();
                $result = $stmt->get_result();
                $num = $result->num_rows;
                if ($num == 1) {
                    $data = $result->fetch_array();
                    $last_id = $data['admin_id'] + 1;
                    $user = trim($_POST['user']);
                    $pass = trim($_POST['pass']);
                    $prefix = trim($_POST['prefix']);
                    $fname = trim($_POST['fname']);
                    $lname = trim($_POST['lname']);
                    $email = trim($_POST['email']);
                    $active = 1;
                    $nickname = trim($_POST['nickname']);

                    //--------- add user -------------//
                    $SQL = "INSERT INTO tbl_web_admin (admin_id,user,pass,prefix,fname,lname,email,is_active,nickname) VALUES(?,?,?,?,?,?,?,?,?)";
                    $query = $conn->prepare($SQL);
                    $query->bind_param("sssssssis", $last_id, $user, $pass, $prefix, $fname, $lname, $email, $active, $nickname);
                    $query->execute();
                    $query->close();

                    //--------- add permission -------------//
                    $SQL = "SELECT * FROM tbl_web_type ORDER BY type_id";
                    $query = $conn->prepare($SQL);
                    $query->execute();
                    $result = $query->get_result();
                    $is_have = $result->num_rows;

                    if ($is_have >= 1) {
                        for ($k = 1; $k <= $is_have; $k++) {
                            $sub_data = $result->fetch_array();
                            $type_id = trim($sub_data['type_id']);
                            if ($_POST[$type_id] == 1) {
                                $msg = "INSERT INTO tbl_permission (admin_id,type_id) VALUES(?,?)";
                                $sub_stmt = $conn->prepare($msg);
                                $sub_stmt->bind_param("ss", $last_id, $type_id);
                                $sub_stmt->execute();
                                $sub_stmt->close();
                            }
                        }
                    }
                    $query->close();
                }
                echo "<script type=\"text/javascript\">
                           window.location=\"?section=office&&status=list&&type=$_GET[type]\";
                      </script>";
                exit;
            }
        } else {
            $error['len'] = "Please Insert Data completely";
        }
    }

    back_to_list($_GET['type']);
    $topic[0] = "<font size=2 face=tahoma color=yellow><b> Manage User </b></font>";
    $topic[1] = "<font size=2 face=tahoma color=yellow><b> Manage Main Menu </b></font>";
    $topic[2] = "<font size=2 face=tahoma color=yellow><b> Manage Activity and News </b></font>";
    $topic[3] = "<font size=2 face=tahoma color=yellow><b> Manage Interesting From EOL </b></font>";
    $topic[4] = "<font size=2 face=tahoma color=yellow><b> Manage News </b></font>";
    $topic[5] = "<font size=2 face=tahoma color=yellow><b> Manage Entertainment </b></font>";
    $topic[6] = "<font size=2 face=tahoma color=yellow><b> Manage English Channel </b></font>";
    $topic[7] = "<font size=2 face=tahoma color=yellow><b> Manage E-Testing </b></font>";
    $topic[10] = "<font size=2 face=tahoma color=yellow><b> Manage E-Learning  </b></font>";
    $topic[11] = "<font size=2 face=tahoma color=yellow><b> Manage E-Learning Reading Comprehension </b></font>";
    $topic[12] = "<font size=2 face=tahoma color=yellow><b> Manage E-Learning Listening Comprehension </b></font>";
    $topic[13] = "<font size=2 face=tahoma color=yellow><b> Manage E-Learning Semi-Speaking </b></font>";
    $topic[14] = "<font size=2 face=tahoma color=yellow><b> Manage E-Learning Semi-Writing </b></font>";
    $topic[15] = "<font size=2 face=tahoma color=yellow><b> Manage E-Learning Grammatical Structure </b></font>";
    $topic[16] = "<font size=2 face=tahoma color=yellow><b> Manage E-Learning Integrated Skill: Cloze Test </b></font>";
    $topic[17] = "<font size=2 face=tahoma color=yellow><b> Manage E-Learning Vocabulary Items  </b></font>";
    $font = "<font size=2 face=tahoma color=white><b>";

    echo "<br>
        <form name='add_form' class='add_form' action=?section=office&&type=$_GET[type]&&status=add_user method=post style='width:90%;'>
                <table align=center width=100% cellpadding=0 cellspacing=0 border=1 bordercolor=white >
                    <tr height=60>
                        <td align=center colspan=3><font size=3 face=tahoma color=ffff77 ><b>Admin Information</b></font><br>
                        <font size=2 face=tahoma color=red><b>*** Please fill out the information correctly and completely. ***</b></font></td>
                    </tr>";
                    
    if ($error) {
        echo "  <tr height=50>
                    <td align=center colspan=3><font size=2 face=tahoma color=red ><b>";
        if ($error['user']) {
            echo "&nbsp;$error[user]<br>";
        }
        if ($error['len']) {
            echo "&nbsp;$error[len]<br>";
        }
        echo "      </b></font></td>
                </tr>";
    }
    echo "<tr>
                        <td>
                        <table align=center width=90% cellpadding=0 cellspacing=0 border=0 >
                            <tr height=25>
                                <td align=right >$font Prefix</td>
                                <td align=center >$font : </td>
                                <td align=left ><input type=text size=10 name=prefix value='$_POST[prefix]' required placeholder='Prefix'></td>
                            </tr>
                            <tr height=25>
                                <td align=right >$font Firstname</td>
                                <td align=center >$font : </td>
                                <td align=left ><input type=text size=20 name=fname value='$_POST[fname]' required placeholder='Firstname'></td>
                            </tr>
                            <tr height=25>
                                <td align=right>$font Lastname</td>
                                <td align=center>$font : </td>
                                <td align=left><input type=text size=20 name=lname value='$_POST[lname]' required placeholder='Lastname'></td>
                            </tr>
                            <tr height=25>
                                <td width=20% align=right>$font Nickname</td>
                                <td width=5% align=center>$font :</td>
                                <td width=80% align=left><input type=text size=20 name=nickname value='$_POST[nickname]' required placeholder='Nickname'></td>
                            </tr>
                            <tr height=25>
                                <td align=right>$font Email</td>
                                <td align=center>$font : </td>
                                <td align=left><input type=text size=30 name=email value='$_POST[email]' required placeholder='Email'></td>
                            </tr>
                            <tr height=25>
                                <td width=20% align=right>$font Username</td>
                                <td width=5% align=center>$font :</td>
                                <td width=80% align=left><input type=text size=20 name=user value='$_POST[user]' required placeholder='Username'></td>
                            </tr>
                            <tr height=25>
                                <td width=20% align=right>$font Password</td>
                                <td width=5% align=center>$font :</td>
                                <td width=80% align=left><input type=password size=20 name=pass value='' required placeholder='Password'></td>
                            </tr>
                            <tr height=15></tr>
                            <tr height=25>
                                <td width=80% align=center colspan=3><br>
                                    <font size=5 color=black> >> List Permission << </font>
                                </td>
                            </tr>
                            <tr>
                                <td width=100% align=left colspan=3>";

    $SQL = "SELECT * FROM tbl_web_type ORDER BY type_id";
    $query = $conn->prepare($SQL);
    $query->execute();
    $result_type = $query->get_result();
    $sub_num = $result_type->num_rows;

    if ($sub_num >= 1) {
        echo "<table class='list-permission' align=center cellpadding=0 cellspacing=0 border=0 width=100%>";
        for ($i = 1; $i <= $sub_num; $i++) {
            $permission = $result_type->fetch_array();
            $array = explode("-", $permission['type_id']);
            $name = $permission['type_id'];
            $prefix = $array[0] + 0;
            $suffix = $array[1] + 0;

            if ($prefix == 0) {
                $color = "red";
            }
            if ($prefix == 1) {
                $color = "blue";
            }
            if ($prefix == 2) {
                $color = "green";
            }
            if ($prefix == 3) {
                $color = "orange";
            }
            if ($prefix == 4) {
                $color = "brow";
            }
            if ($prefix == 5) {
                $color = "gray";
            }
            if ($suffix == 1) {
                echo "  <tr>
                            <td colspan=3>
                                <br>
                                $topic[$prefix]
                            </td>
                        </tr>";
            }

            for ($p = 1; $p <= $sub_num; $p++) {
                if ($_POST[$name] == 1) {
                    $check[$i] = "checked";
                }
            }

            echo "  <td width=50%>
                        <input type=checkbox name='$name' id='chk$name' $check[$i] value='1'> $font $permission[type_name]
                    </td>";

            if ($suffix % 2 == 0) {
                echo "<tr></tr>";
            }
        }
        echo "</table>";
    }
    $query->close();
    echo "
									<br><br>
									<div align=center><input class='edit-personal' type=submit value='Add New User'></div>	
								</td>
							</tr>
							<tr>
								<td align=center colspan=3>&nbsp;</td>
							</tr>
						</table>
					</td>
                </tr>
            </table>
		</form>";
}

function feedback_list()
{
    back_to_main_page();
    if ($_GET['sub'] === "add_feedback") {
        add_feedback();
    }
    if ($_GET['sub'] === "feedback_hidden") {
        feedback_hidden();
    }
    if ($_GET['sub'] === "feedback_del") {
        feedback_del();
    }
    if (!$_GET['sub']) {
        echo "
			<table class='tb-feedback' align=center cellpadding=0 cellspacing=0 border=0 width=90%>
				<tr height=50 valign=top>
					<td width=100%>";
        feedback_menu();
        echo "
					</td>
				</tr>
				<tr>
					<td>";
        feedback();
        echo "
					</td>
				</tr>
				<tr height=25><td width=100%></td></tr>
			</table>";
    }
}

function feedback_menu()
{
    echo "
		<table class='menu-feedback' align=right cellpadding=0 cellspacing=0 border=0 >
			<tr height=25>
				<td><a href=?section=office&&status=list&&type=$_GET[type]&&menu=1>Organization List</a></td>
				<td>&nbsp;</td>
                <td><a href=?section=office&&status=list&&type=$_GET[type]&&menu=2>Feedback List</a></td>
				<td>&nbsp;</td>
			</tr>
		</table>";
}

function feedback()
{
    include('../config/connection.php');
    $font = "<font size=2 face=tahoma color=white><b>";
    $font_green = "<font size=2 face=tahoma color=77ff77><b>";
    $font_yellow = "<font size=2 face=tahoma color=yellow><b>";
    $font_red = "<font size=2 face=tahoma color=red><b>";
    $font_orange = "<font size=2 face=tahoma color=orange><b>";
    $font_white = "<font size=2 face=tahoma color=white><b>";

    if ($_GET['menu']) {
        $menu = trim($_GET['menu']);
    } else {
        $menu = 1;
    }
    if ($_GET['page']) {
        $page = trim($_GET['page']);
    }
    if (!$_GET['page']) {
        $page = 1;
    }
    $per_page = 10;
    $start = ($page - 1) * $per_page;
    if ($menu == 1) {
        $SQL = "SELECT count(school_id) FROM tbl_web_school";
        $header_a = "School ID";
        $header_b = "School Name";
        $header_c = "Management";
        $strSQL = "SELECT * FROM tbl_web_school ORDER BY school_id DESC limit $start,$per_page";
    } else {
        $SQL = "SELECT count(feedback_id) FROM tbl_web_feedback";
        $header_a = "Feedback ID";
        $header_b = "Feedback Detail";
        $header_c = "Management";
        $strSQL = "SELECT * FROM tbl_web_feedback ORDER BY feedback_id DESC limit $start,$per_page";
    }
    $query = $conn->prepare($SQL);
    $query->execute();
    $result_count = $query->get_result();
    $rows = $result_count->fetch_array();
    $all_num = $rows[0];
    // echo 'all num' . $all_num;
    $all_page = $all_num / $per_page;
    $arr = explode(".", $all_page);
    if ($arr[1] >= "1") {
        $total = $arr[0] + 1;
    }
    // --------------------------------------- //
    $stmt = $conn->prepare($strSQL);
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->num_rows;
    echo "
	    <table class='list-feedback' align=center width=90% cellpadding=0 cellspacing=0 border=1 bordercolor=white>
			<tr height=50>
				<td align=center width=15%><font size=2  color=white face=tahoma><b>$header_a</td>
				<td align=center width=60%><font size=2  color=white face=tahoma><b>$header_b</td>
				<td align=center width=25%><font size=2  color=white face=tahoma><b>$header_c</td>
			</tr>";

    if ($num >= 1) {
        echo "<tr height=100%>
				<td colspan=3>";

        for ($i = 1; $i <= $num; $i++) {
            $data = $result->fetch_array();
            if ($data['is_active'] == 0) {
                $msg = "$font_orange Hidden";
            } else {
                $msg = "$font_green Show";
            }
            if ($menu == 1) {
                $id = $data['school_id'];
                $name = $data['school_name'];
                $row = 1;
                $button = "Add Organization";
                $name_text = "school_name";
                $msg_name = "School Name";
                $del_name = 'Organization';
            } else {
                $id = $data['feedback_id'];
                $name = $data['feedback_detail'];
                $row = 2;
                $button = "Add Feedback";
                $name_text = "feedback_detail";
                $msg_name = "Feedback Detail";
                $del_name = 'Feedback';
            }
            echo "
					<table class='sub-list-feedback' align=center width=100% cellpadding=0 cellspacing=0 border=1>
						<tr height=25>
							<td width=14.7% align=center>$font_white $id</td>
							<td width=60% align=left class='topic-name'><font size=2 face=tahoma><b>&nbsp;$name</b></font></td>
							<td width=12.4% align=center><a href=?section=office&&status=list&&menu=$menu&&sub=feedback_hidden&&type=$_GET[type]&&id=$id&&page=$page>$msg</a></td>
							<td width=12.4% align=center>
                                <a style='cursor:pointer;' onclick=\"javascript: if(confirm('Are you sure ? want delete this $del_name ?')){   window.location='?section=office&&status=list&&menu=$menu&&sub=feedback_del&&type=$_GET[type]&&id=$id&&page=$page';} \">$font_red Delete</a>
                            </td>
						</tr>
					</table>";
        }
        echo "  </td>
              </tr>";
        echo "<tr height=100%>
                    <br>
					<table class='page-num' align=center cellpadding=0 cellspacing=0 border=0 width=75%>
						<tr height=25>
							<td align=left><font size=2 face=tahoma color=white><b>&nbsp;Page : &nbsp;";
        for ($j = 1; $j <= $total; $j++) {
            if ($j == $page) {
                echo "&nbsp<a href=?section=office&&status=list&&type=$_GET[type]&&menu=$menu&&page=$j>$font_red $j</a>&nbsp";
            }
            if ($j != $page) {
                echo "&nbsp<a href=?section=office&&status=list&&type=$_GET[type]&&menu=$menu&&page=$j>$font_yellow $j</a>&nbsp;";
            }
            if ($j % 20 == 0) {
                echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            }
        }
        echo "
							</td>
						</tr>
					</table>
              </tr><br>";
    } else {
        echo "<tr height=100%>
                    <td colspan=3 align=center>$font_red - Not Data - </td>
              </tr>";
    }

    echo "</table>
          <br>
		  <table class='tb-add' align=center cellpadding=0 cellspacing=0 border=0 width=90%>
				<form action=?section=office&&status=list&&type=$_GET[type]&&menu=$menu&&sub=add_feedback method=post>
					<tr>
						<td width=19% align=right>$font $msg_name</td>
						<td align=center>$font &nbsp;:&nbsp;</td>
						<td width=62% align=center><textarea name=$name_text cols=50 rows=$row single=single required></textarea></td>
						<td width=16% align=left><input class='btn-add' type=submit value='$button'></td>
					</tr>
				</form>
		  </table>
          <br>";
}

function add_feedback()
{
    include('../config/connection.php');
    $text = '';
    if ($_GET['menu'] == 1) {
        $strSQL = "SELECT * FROM tbl_web_school ORDER BY school_id DESC limit 1";
        $stmt = $conn->prepare($strSQL);
        $stmt->execute();
        $result = $stmt->get_result();
        $num = $result->num_rows;
        if ($num == 1) {
            $data = $result->fetch_array();
            $last_id = $data['school_id'] + 1;
        } else {
            $last_id = 1;
        }
        $stmt->close();
        $SQL = "INSERT INTO tbl_web_school (school_id,school_name) VALUES(?,?)";
        $query = $conn->prepare($SQL);
        $query->bind_param("ss", $last_id, $_POST['school_name']);
        $query->execute();
        $text = 'Add Organization Complete';

    } else {
        $strSQL = "SELECT * FROM tbl_web_feedback ORDER BY feedback_id DESC limit 1";
        $stmt = $conn->prepare($strSQL);
        $stmt->execute();
        $result = $stmt->get_result();
        $num = $result->num_rows;
        if ($num == 1) {
            $data = $result->fetch_array();
            $last_id = $data['feedback_id'] + 1;
        } else {
            $last_id = 1;
        }
        $stmt->close();
        $SQL = "INSERT INTO tbl_web_feedback (feedback_id,feedback_detail) VALUES(?,?)";
        $query = $conn->prepare($SQL);
        $query->bind_param("ss", $last_id, $_POST['feedback_detail']);
        $query->execute();
        $text = 'Add Feedback Complete';
    }
    if ($text == '') {
        $text = 'Sorry!!! An error occurred. <br> Please try again';
    }
    echo "<script type=\"text/javascript\">
                alert('$text');
                window.location=\"?section=office&&status=list&&type=$_GET[type]&&menu=$_GET[menu]\";
          </script>";
    exit;
}

function feedback_hidden()
{
    include('../config/connection.php');
    if ($_GET['menu'] == 1 && $_GET['id'] >= 1) {
        $strSQL = "SELECT * FROM tbl_web_school WHERE school_id = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $_GET['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $num = $result->num_rows;
        if ($num == 1) {
            $data = $result->fetch_array();
            $active = $data['is_active'];
            if ($active == 0) {
                $is_active = 1;
            } else {
                $is_active = 0;
            }
            $SQL = "UPDATE tbl_web_school SET is_active = ? WHERE school_id = ?";
            $query = $conn->prepare($SQL);
            $query->bind_param("is", $is_active, $_GET['id']);
            $query->execute();
            $query->close();
        }
        $stmt->close();
    } else if ($_GET['menu'] == 2 && $_GET['id'] >= 1) {
        $strSQL = "SELECT * FROM tbl_web_feedback WHERE feedback_id = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $_GET['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $num = $result->num_rows;
        if ($num == 1) {
            $data = $result->fetch_array();
            $active = $data['is_active'];
            if ($active == 0) {
                $is_active = 1;
            } else {
                $is_active = 0;
            }
            $SQL = "UPDATE tbl_web_feedback SET is_active = ? WHERE feedback_id = ?";
            $query = $conn->prepare($SQL);
            $query->bind_param("is", $is_active, $_GET['id']);
            $query->execute();
            $query->close();
        }
        $stmt->close();
    }
    echo "<script type=\"text/javascript\">
                window.location=\"?section=office&&status=list&&type=$_GET[type]&&menu=$_GET[menu]&&page=$_GET[page]\";
          </script>";
    exit;
}


function feedback_del()
{
    include('../config/connection.php');
    if ($_GET['menu'] == 1 && $_GET['id'] >= 1) {
        $strSQL = "DELETE FROM tbl_web_school WHERE school_id = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $_GET['id']);
        $stmt->execute();
        $stmt->close();
    } else if ($_GET['menu'] == 2 && $_GET['id'] >= 1) {
        $strSQL = "DELETE FROM tbl_web_feedback WHERE feedback_id = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $_GET['id']);
        $stmt->execute();
        $stmt->close();
    }

    echo "<script type=\"text/javascript\">
                window.location=\"?section=office&&status=list&&type=$_GET[type]&&menu=$_GET[menu]\";
          </script>";
    exit;
}

function fn_display_list()
{
    include('../config/connection.php');
    $type_id = trim($_GET['type']);
    $per_page = 10;
    check_permission($type_id);
    $topic_name = get_topic_name($type_id);
    $strSQL = "SELECT * FROM tbl_web_topic WHERE type_id = ? ORDER BY topic_id DESC";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $type_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->num_rows;
    $stmt->close();
    if (!$_GET['page']) {
        $page = 1;
    } else {
        $page = trim($_GET['page']);
    }
    $start = ($page - 1) * $per_page;
    $all_page = $num / $per_page;
    if ($num % $per_page != 0) {
        $all_page = $all_page + 1;
    }
    //--------------------------- cut dot ---------------------------//
    $arr_page = explode(".", $all_page);
    $all_page = $arr_page[0];

    $SQL = "SELECT * FROM tbl_web_topic WHERE type_id = ? ORDER BY topic_id DESC limit $start,$per_page";
    $query = $conn->prepare($SQL);
    $query->bind_param("s", $type_id);
    $query->execute();
    $result = $query->get_result();
    $num = $result->num_rows;
    //------------ button back to main page ---------------//
    back_to_main_page();

    if ($_SESSION['level'] == "admin") {
        $colspan = "5";
        $width_a = "50%";
        $width_b = "40%";
        $function = "
                    <td align=center width=13.3% style='border-radius:5px;'><font size=2 face=tahoma color=white><b>Display</td>
                    <td align=center width=13.3% style='border-radius:5px;'><font size=2 face=tahoma color=white><b>Edit</td>
                    <td align=center width=13.3% style='border-radius:5px;'><font size=2 face=tahoma color=white><b>Delete</td>";
    } else {
        $colspan = "4";
        $width_a = "60%";
        $width_b = "30%";
        $function = "
                    <td align=center width=13.3% style='border-radius:5px;'><font size=2 face=tahoma color=white><b>Display</td>
                    <td align=center width=13.3% style='border-radius:5px;'><font size=2 face=tahoma color=white><b>Edit</td>";
    }

    echo "  <table class='list-topic' width=90% align=center cellpadding=0 cellspacing=0 border=1 bordercolor=white >
                <tr height=40>
                    <td align=center style='border-radius:5px;'><font size=3 face=tahoma color=yellow><b>$topic_name</td>
                </tr>
            </table>
            <table class='list-page' width=90% align=center cellpadding=0 cellspacing=0 border=0  >
                <tr height=40>
                    <td align=left><font size=2 face=tahoma color=white><b><br>&nbsp;&nbsp;Page : &nbsp;";
    for ($i = 1; $i <= $all_page; $i++) {
        if ($page == $i) {
            echo "&nbsp;&nbsp;<a href=?section=office&&type=$type_id&&status=list&&page=$i><font size=2 color=red face=tahoma>$i</font></a>&nbsp;&nbsp;";
        } else {
            echo "&nbsp;&nbsp;<a href=?section=office&&type=$type_id&&status=list&&page=$i><font size=2 color=white face=tahoma>$i</font></a>&nbsp;&nbsp;";
        }
        if ($i % 20 == 0) {
            echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        }
    }
    echo "
						<br>&nbsp;</td>
					</tr>
				</table>
				<table class='list-topic row-topic' width=90% align=center cellpadding=0 cellspacing=0 border=1 bordercolor=white >
					<tr height=25>
						<td width=10% align=center rowspan=2 style='border-radius:5px;'><font size=2 face=tahoma color=yellow><b> Topic ID </td>
						<td width=$width_a align=center rowspan=2 style='border-radius:5px;'><font size=2 face=tahoma color=yellow><b> Topic Name </td>
						<td width=$width_b align=center colspan=$colspan style='border-radius:5px;'><font size=2 face=tahoma color=yellow><b> Management </td>
					</tr>
					<tr height=25>
                        $function 
					</tr height=25>";

    if ($num >= 1) {
        for ($i = 1; $i <= $num; $i++) {
            $data = $result->fetch_array();
            if ($data['topic_active'] == 0) {
                $color = "yellow";
                $msg = "Hidden";
            }
            if ($data['topic_active'] == 1) {
                $color = "77FF77";
                $msg = "Show";
            }
            if ($data['topic_active'] == 2) {
                $color = "aaffff";
                $msg = "Sticky";
            }
            if ($data['topic_comment'] == 0) {
                $color_b = "yellow";
                $msg_b = "No";
            }
            if ($data['topic_comment'] == 1) {
                $color_b = "77FF77";
                $msg_b = "Yes";
            }
            if ($data['topic_by'] == 1) {
                $admin_id = trim($data['admin_id']);
                $strSQL = "SELECT * FROM tbl_web_admin WHERE admin_id = ?";
                $stmt = $conn->prepare($strSQL);
                $stmt->bind_param("s", $admin_id);
                $stmt->execute();
                $result_admin = $stmt->get_result();
                $admin_num = $result_admin->num_rows;
                if ($admin_num == 1) {
                    $admin_data = $result_admin->fetch_array();
                    $admin_name = $admin_data['nickname'];
                } else {
                    $admin_name = "-";
                }
                $stmt->close();
            }
            echo "  <tr height=25>
						<td width=10% align=center><b><font size=2 color=white face=tahoma>$data[topic_id]</a>
                        </td>	
                        <td width='50%' align=left>
							<a class='topic-name' href=?section=office&&status=view_detail&&type=$_GET[type]&&topic_id=$data[topic_id]>
									<b><font size=2 face=tahoma>&nbsp;[$admin_name] &nbsp; $data[topic_name] 
							</a>
						</td>
						<td width=10% align=center>
							<a href=?section=office&&status=edit_active&&type=$_GET[type]&&page=$page&&topic_id=$data[topic_id]><b><font size=2 color=$color face=tahoma>$msg</a>
						</td>
						<td width=10% align=center>
							<a href=?section=office&&status=edit_topic_form&&type=$_GET[type]&&page=$page&&topic_id=$data[topic_id]><b><font size=2 color=aaaaff face=tahoma>Edit</a>
						</td>";

            if ($_SESSION['level'] === "admin") {
                echo "
						<td width=10% align=center>
                            <a style='cursor:pointer;'  onclick=\"javascript:
                            if(confirm('Are you sure ? want delete this topic ?'))
                            {	window.location='?section=office&&type=$_GET[type]&&status=delete_topic&&topic_id=$data[topic_id]';	}
                        \" ><font size=2 face=tahoma color=red><b>Delete</a>
						</td>";
            }
            echo "</tr>";
        }
    } else {
        echo "<tr height=25><td colspan='5' align=center ><font size=2 color=white face=tahoma><b> - Didn't Find Data List - </td></tr>";
    }
    echo "
			    </table>
                <br>
				<table class='add-new-topic' width=90% align=center cellpadding=0 cellspacing=0 border=1 bordercolor=white >
					<tr height=25>
						<td width=100% align=center style='border-radius:5px;'>
                            <a href=?section=office&&status=add_topic_form&&type=$_GET[type]><font size=4 face=tahoma><b> Add New Topic </b></font></a> 
                        </td>
					</tr>
				</table>";
}

function get_topic_name($type_id)
{
    include('../config/connection.php');
    $strSQL = "SELECT * FROM tbl_web_type WHERE type_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $type_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_have = $result->num_rows;
    if ($is_have == 1) {
        $data = $result->fetch_array();
        $name = $data['type_name'];
    } else {
        $name = " - Didn't Find Data List - ";
    }
    $stmt->close();
    return $name;
}

function image_resize($temp, $path, $img_name, $width, $height)
{
    list($wid, $ht) = getimagesize($temp);
    $r = $wid / $ht;

    if ($width / $height > $r) {
        $new_width = round($height * $r);
        $new_height = $height;
    } else {
        $new_height = round($width / $r);
        $new_width = $width;
    }

    $new_image = @imagecreatetruecolor($new_width, $new_height);

    $source = @imagecreatefromjpeg($temp);
    if (!$source) {
        $source = imagecreatefromstring(file_get_contents($temp));
    }

    imagecopyresampled($new_image, $source, 0, 0, 0, 0, $new_width, $new_height, $wid, $ht);

    imagejpeg($new_image, $path . '' . $img_name, 100);

    if (file_exists($temp)) {
        unlink($temp);
    }

}

function add_topic_form()
{
    include('../config/connection.php');
    back_to_list($_GET['type']);
    $error = NULL;
    $topic_name = $_POST['topic_name'] ? $_POST['topic_name'] : '';
    $topic_headline = $_POST['topic_headline'] ? $_POST['topic_headline'] : '';
    $topic_detail = $_POST['topic_detail'] ? $_POST['topic_detail'] : '';
    if ($_GET['sub'] === "add_topic") {
        if (!$_POST['topic_name']) {
            $error['topic_name'] = "Please Insert Topic Name <br>";
        }
        if (!$_POST['topic_detail']) {
            $error['topic_detail'] = "Please Insert Topic Detail <br>";
        }
        if ($_GET['type'] != "01-02") {
            if (!$_POST['topic_headline']) {
                $error['topic_headline'] = "Please Insert Topic Headline <br>";
            }
            if ($_FILES['image']['type'] != "image/jpeg" && $_FILES['image']['type'] != "image/pjpeg" && $_FILES['image']['type'] != "image/jpg") {
                $error['image'] = "Please Selected Image as .jpg File <br>";
            }
        }
        if (!$error) {

            $strSQL = "SELECT * FROM tbl_web_topic ORDER BY topic_id DESC limit 1";
            $stmt = $conn->prepare($strSQL);
            $stmt->execute();
            $result = $stmt->get_result();
            $num = $result->num_rows;
            if ($num == 1) {
                $data = $result->fetch_array();
                $last_id = $data['topic_id'] + 1;
            } else {
                $last_id = 1;
            }
            if ($_GET['type'] != "01-02") {
                $topic_headline = $_POST['topic_headline'];
                $img_name = $last_id . ".jpg";
                $temp = $_FILES['image']['tmp_name'];
                $path = "../2010/user_images/";

                //------------ upload and resize image -------------//
                image_resize($temp, $path, $img_name, 95, 90);

            } else {
                $topic_headline = "";
                $img_name = "";
            }
            $date = date("Y-m-d");
            $topic_detail = $_POST['topic_detail'];
            $type_id = trim($_GET['type']);
            $topic_name = $_POST['topic_name'];

            $topic_view = 0;
            $topic_active = 0;
            $topic_comment = 0;
            $topic_by = 1;
            $SQL = "INSERT INTO tbl_web_topic (topic_id,topic_name,topic_headline,topic_detail,topic_image,type_id,topic_view,topic_active,topic_comment,topic_create,topic_update,admin_id,topic_by) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $query = $conn->prepare($SQL);
            $query->bind_param("ssssssiiissss", $last_id, $topic_name, $topic_headline, $topic_detail, $img_name, $type_id, $topic_view, $topic_active, $topic_comment, $date, $date, $_SESSION['admin_id'], $topic_by);

            if ($query->execute()) {
                echo "<script type=\"text/javascript\">
                         alert('Add Topic Complete');
                         window.location=\"?section=office&&status=list&&type=$_GET[type]\";
                     </script>";
                exit;
            } else {
                echo "<script type=\"text/javascript\">
                         alert('Sorry!!! An error occurred.');
                         window.location=\"?section=office&&status=add_topic_form&&type=$_GET[type]\";
                     </script>";
                exit;
            }
        }
    }

    echo "
				<form enctype='multipart/form-data' action=?section=office&&status=$_GET[status]&&sub=add_topic&&type=$_GET[type] method=post>
					<table class='add-topic-form' align=center width=95% cellpadding=0 cellspacing=0 border=1 bordercolor=white bgcolor=white >
						<tr height=40>
							<td width=85% align=center>
                                <font size=4 face=tahoma color=orange><b>Add Topic Form</b></font>
                            </td>
						</tr>
						<tr>
							<td><br>
					        <table class='topic-detail' align=center width=95% cellpadding=0 cellspacing=0 border=0 bordercolor=white >";
    if ($error) {
        echo "<tr height=25 valign=top>
							        
							        <td width=80% align=center colspan='3'>
                                        <font size=2 face=tahoma color=red><b>
                                        $error[topic_name] $error[topic_headline] $error[image] $error[topic_detail]
                                        </b></font>
							        </td>
						        </tr>";

    }

    echo "<tr height=25 valign=top>
							        <td width=17.5% align=right>
                                        <font size=2 face=tahoma color=black><b>Topic Name</b></font>
                                    </td>
							        <td width=2.5% align=center>
                                        <font size=2 face=tahoma color=black><b>:</b></font>
                                    </td>
							        <td width=80% align=left>
                                        <font size=2 face=tahoma color=black><b>
								            <input type=text name=topic_name size=90 value='$topic_name' style='padding:4px; margin:1px;' required>
                                        </b></font>
							        </td>
						        </tr>";
    if ($_GET['type'] != "01-02") {
        echo "
						<tr height=25 valign=top>
							<td width=17.5% align=right><font size=2 face=tahoma color=black><b>Topic Headline</td>
							<td width=2.5% align=center>
                                <font size=2 face=tahoma color=black><b>:</b></font></td>
							<td width=80% align=left>
                                <font size=2 face=tahoma color=black><b>
								    <textarea name=topic_headline  cols=88 rows=1 style='padding:4px; margin:1px;' required>$topic_headline</textarea>
                                </b></font>
							</td>
						</tr>
						<tr height=25 valign=top>
							<td width=17.5% align=right>
                                <font size=2 face=tahoma color=black><b><br>Display Topic Image</b></font>
                            </td>
							<td width=2.5% align=center>
                                <font size=2 face=tahoma color=black><b><br>:</b></font>
                            </td>
							<td width=80% align=left>
                                <font size=2 face=tahoma color=black><b><br>
								    <input type=file name=image size=40 required><br>
								    <font size=2 face=tahoma color=orange><i>Image type .jpg only</i></font><br>
                                </b></font>
							</td>
						</tr>";
    }
    echo "
						<tr>
							<td width=17.5% align=right><font size=2 face=tahoma color=black><b>Topic Detail</td>
							<td width=2.5% align=center><font size=2 face=tahoma color=black><b>:</td>
							<td width=80% align=left><font size=2 face=tahoma color=white><b></td>
					   </tr>
                       <tr>
                            <td width=17.5% align=left></td>
                            <td width=2.5% align=left></td>
                            <td width=80% align=left>
                                <font color='red' size=2>
                                    <i><u>หมายเหตุ</u><i>
                                </font>
                                <br>
                                <font color='blue' align='left' size='2'>
                                    1. บทเรียนหรือเนื้อหาที่จะใส่ต้องอยู่ในรูปแบบของไฟล์ .word 
                                    <br>
                                    2.รูปภาพหรือไฟล์เสียงที่จะใส่ควรเป็นชื่อภาษาอังกฤษ
                                </font> 
                            </td>
                       </tr>
					   <tr bgcolor=white>
					       <td colspan=3 width=90%> 
                                <textarea id='topic_detail' name='topic_detail' class='form-control topic_detail' placeholder='' rows='20'>
                                    $topic_detail</textarea>
                           </td>
						</tr>
						<tr height=25>
							<td colspan=3> </td>
						</tr>
						<tr height=5>
							<td colspan=3> </td>
						</tr>
						<tr height=25>
							<td width=80% align=center colspan='3'><font size=2 face=tahoma color=white><b>
								<input title='Add Topic' type=image src=../2010/temp_images/temp/button/bt_add_topic.png alt=submit style='height:70px;'>
							</td>
						</tr>
					</table>
                    <br>
				</td>
            </tr>
        </table>
	</form>";
    script_ckeditor();

}

function edit_topic_form()
{
    include('../config/connection.php');
    back_to_list($_GET['type']);
    $error = [];
    $topic_id = trim($_GET['topic_id']);
    $strSQL = "SELECT * FROM tbl_web_topic WHERE topic_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $topic_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_have = $result->num_rows;
    if ($is_have == 1) {
        $data = $result->fetch_array();

        if ($_GET['sub'] === "edit_topic") {
            if ($_FILES['image']['type'] === "image/jpeg" || $_FILES['image']['type'] === "image/jpg") {
                $path = "../2010/user_images/";
                $img_name = $data['topic_id'] . ".jpg";
                image_resize($_FILES['image']['tmp_name'], $path, $img_name, 95, 90);
            }

            if (!$_POST['topic_name'] || !$_POST['topic_detail']) {
                $error['error'] = "Sorry, Something went wrong";
            }

            if (!$error) {
                $topic_detail = $_POST['topic_detail'];
                $topic_name = $_POST['topic_name'];
                $topic_headline = $_POST['topic_headline'] ? $_POST['topic_headline'] : '-';
                $date = date("Y-m-d");
                $SQL = "UPDATE tbl_web_topic SET topic_name = ?, topic_headline = ?, topic_detail = ?, topic_update = ? WHERE topic_id = ?";
                $query = $conn->prepare($SQL);
                $query->bind_param("sssss", $topic_name, $topic_headline, $topic_detail, $date, $topic_id);

                if ($query->execute()) {
                    echo "<script type=\"text/javascript\">
                                alert('Edit Topic Complete');
                                window.location=\"?section=office&&status=list&&type=$_GET[type]\";
                          </script>";
                    exit;
                } else {
                    echo "<script type=\"text/javascript\">
                                alert('Sorry, An error occurred. Please try again.');
                                window.location=\"?section=office&&status=$_GET[status]&&type=$_GET[type]&&topic_id=$data[topic_id]\";
                         </script>";
                    exit;
                }
            } else {
                echo "<script type=\"text/javascript\">
                            alert('Sorry, Something went wrong. Please try again.');
                            window.location=\"?section=office&&status=$_GET[status]&&type=$_GET[type]&&topic_id=$data[topic_id]\";
                      </script>";
                exit;
            }

        }
        if (!$_GET['sub']) {
            echo "
				<form enctype='multipart/form-data' action=?section=office&&status=$_GET[status]&&sub=edit_topic&&type=$_GET[type]&&topic_id=$data[topic_id] method=post>
					<table class='add-topic-form' align=center width=95% cellpadding=0 cellspacing=0 border=1 bordercolor=white bgcolor=white >
						<tr height=40>
							<td width=85% align=center>
                                <font size=4 face=tahoma color=orange><b>Edit Topic Form</b></font>
                            </td>
						</tr>
						<tr>
							<td><br>
					            <table class='topic-detail' align=center width=95% cellpadding=0 cellspacing=0 border=0 bordercolor=white >";

            echo "      <tr height=25 valign=top>
                                    <td width=17.5% align=right>
                                        <font size=2 face=tahoma color=black><b>Topic Name</b></font>
                                    </td>
                                    <td width=2.5% align=center>
                                        <font size=2 face=tahoma color=black><b>:</b></font>
                                    </td>
                                    <td width=80% align=left>
                                        <font size=2 face=tahoma color=black><b>
                                            <input type=text name=topic_name size=90 value='$data[topic_name]' style='padding:4px; margin:1px;' required></b>
                                        </font>
                                    </td>
                                </tr>";

            if ($_GET['type'] != "01-02") {
                echo "
                                <tr height=25 valign=top>
                                    <td width=17.5% align=right>
                                        <font size=2 face=tahoma color=black><b>Topic Headline</font>
                                    </td>
                                    <td width=2.5% align=center>
                                        <font size=2 face=tahoma color=black><b>:</b></font>
                                    </td>
                                    <td width=80% align=left>
                                        <font size=2 face=tahoma color=black><b>
                                            <textarea name=topic_headline  cols=88 rows=1 style='padding:4px; margin:1px;' required>$data[topic_headline]</textarea></b>
                                        </font>
                                    </td>
                                </tr>
                                <tr height=25 valign=top>
                                    <td width=17.5% align=right>
                                        <font size=2 face=tahoma color=black><b><br>Display Topic Image</b></font>
                                    </td>
                                    <td width=2.5% align=center>
                                        <font size=2 face=tahoma color=black><b><br>:</b></font>
                                    </td>
                                    <td width=80% align=left>
                                        <font size=2 face=tahoma color=black><b><br>
                                            <img src='../2010/user_images/$topic_id.jpg' border=0 width=75 height=50><br>
                                            <input type=file name=image size=40><br>
                                            <font size=2 face=tahoma color=orange><i>Image type .jpg only.</i></font><br></br>
                                        </font>
                                    </td>
                                </tr>";
            }

            echo "
                                <tr>
                                    <td width=17.5% align=right>
                                        <font size=2 face=tahoma color=black><b>Topic Detail</td>
                                        <td width=2.5% align=center><font size=2 face=tahoma color=black><b>:</td>
                                        <td width=80% align=left><font size=2 face=tahoma color=white><b>
                                    </td>
                                </tr>
                                <tr>
                                    <td width=17.5% align=left></td>
                                    <td width=2.5% align=left></td>
                                    <td width=80% align=left>
                                        <font color='red' size=2>
                                            <i><u>หมายเหตุ</u><i>
                                        </font>
                                        <br>
                                        <font color='blue' align='left' size='2'>
                                        1. บทเรียนหรือเนื้อหาที่จะใส่ต้องอยู่ในรูปแบบของไฟล์ .word 
                                        <br>
                                        2.รูปภาพหรือไฟล์เสียงที่จะใส่ควรเป็นชื่อภาษาอังกฤษ
                                        </font> 
                                    </td>
                                </tr>   
                                <tr bgcolor=white>
                                    <td colspan=3 width=90%> 
                                        <textarea id='topic_detail' name='topic_detail' class='form-control' placeholder='' rows='20'>
                                        $data[topic_detail]</textarea>
                                    </td>
                                </tr>
                                <tr height=25>
                                    <td colspan=3> </td>
                                </tr>
                                <tr height=5>
                                    <td colspan=3> </td>
                                </tr>
                                <tr height=25>
                                    <td width=80% align=center colspan='3'><font size=2 face=tahoma color=white><b>
                                        <input title='Edit Topic' type=image src=../2010/temp_images/temp/button/bt_edit_topic.png alt=submit style='height:70px;'>
                                    </td>
                                </tr>
                            </table>
                            <br>
			            </td>
                    </tr>
                </table>
	        </form>";
        }
        script_ckeditor();
    } else {
        header("Location:?section=office&&status=list&&type=$_GET[type]");
    }
    $stmt->close();
}

function delete_topic()
{
    include('../config/connection.php');
    $type_id = trim($_GET['type']);
    check_permission($type_id);
    $strSQL = "SELECT * FROM tbl_web_topic WHERE topic_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $_GET['topic_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_have = $result->num_rows;
    $data = $result->fetch_array();
    if ($_SESSION['level'] === 'user' && $_SESSION['level'] && ($_SESSION['admin_id'] != $data['admin_id'])) {
        header("Location:?section=office&&status=list&&type=$_GET[type]");
    } else {
        $image_dir = "../2010/user_images/" . $_GET['topic_id'] . ".jpg";
        if ($type_id != "01-02") {
            unlink($image_dir);
        }
        $SQL = "DELETE FROM tbl_web_topic WHERE topic_id = ?";
        $query = $conn->prepare($SQL);
        $query->bind_param("s", $_GET['topic_id']);
        $query->execute();
        $query->close();

        echo "<script type=\"text/javascript\">
                    window.location=\"?section=office&&status=list&&type=$_GET[type]\";
              </script>";
        exit;
    }

}

function view_detail()
{
    include('../config/connection.php');
    back_to_list($_GET['type']);
    $strSQL = "SELECT * FROM tbl_web_topic WHERE topic_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $_GET['topic_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_have = $result->num_rows;
    if ($is_have == 1) {
        $data = $result->fetch_array();

        echo "
			<table class='view_detail' width=90% align=center cellpadding=0 cellspacing=0 border=1 bordercplor=white>
				<tr height=30>
					<td  align=center width=15%>&nbsp;<font size=2 face=tahoma color=orange><b>Topic ID : $data[topic_id]</td>
					<td  align=left width=45%>&nbsp;<font size=2 face=tahoma color=orange><b>Topic Name : $data[topic_name]</td>
					<td  align=center width=15%>&nbsp;<font size=2 face=tahoma color=orange><b>Date : $data[topic_create]</td>
				</tr>";

        if ($_GET['type'] != "01-02") {

        echo "
                <tr height=30>
                    <td  align=center width=15%>&nbsp;<font size=2 face=tahoma color=orange><b>Headline : </td>
                    <td  align=left width=45% colspan=2>&nbsp;<font size=2 face=tahoma color=orange><b>$data[topic_headline]</td>
                </tr>";
        }
        echo "
				<tr height=30>
					<td  align=center width=75% colspan=3>&nbsp;<font size=2 face=tahoma color=orange><b>Detail </td>
				<tr height=30 >	
					<td  align=left width=75% colspan=3 style='padding:22px;'>&nbsp;<font size=2 face=tahoma color=white><b>$data[topic_detail]</td>
				</tr>
			</table>";
    } else {
        echo "
			<table align=center cellpadding=0 cellspacing=0 border=1 width=90%>
				<tr height=25 >
					<td align=center><font size=2 color=white face=tahoma><b> - Didn't Find Data List - </td>
				</tr>
			</table>";
    }
}


function back_to_main_page()
{
    echo "  <a href='../backoffice/mainoffice.php?section=office' style='height:40px;'>
                <img src='../2010/temp_images/temp/button/bt_to_main.png' style='height:50px;margin-top:-10px;margin-bottom:10px;' title='Back to Main'/>
            </a>";
}

function back_to_list($type)
{
    echo "  <a href='../backoffice/mainoffice.php?section=office&&status=list&&type=$type' style='height:40px;'>
                <img src='../2010/temp_images/temp/button/bt_to_list.png' style='height:50px; margin-top:-10px; margin-bottom:10px;' title='Back to List'/>
            </a>";
}


function script_ckeditor()
{
    ?>
<script>
CKEDITOR.replace('topic_detail', {

    // extraPlugins: 'embed,autoembed,autolink,undo,embedsemantic,balloontoolbar,balloonpanel,image2,mathjax,ckeditor_wiris,html5video,mathjax',

    extraPlugins: 'html5audio,lineheight,filebrowser,filetools,widget,clipboard,widgetselection,lineutils,undo,videoembed,ckeditorfa,codeTag,emojione,letterspacing,texttransform,templates,ajax,xml,floating-tools,simplebutton',


    line_height: '1px;1.1px;1.2px;1.3px;1.4px;1.5px;1.8px;2px;',
    allowedContent: true,
    // extraAllowedContent: 'span(*)[*]{*};p(*)[*]{*};div(*)[*]{*};li(*)[*]{*};ul(*)[*]{*}',

    contentsCss: '../bootstrap/fontawesome/css/all.min.css',

    height: 550,

    filebrowserUploadUrl: 'upload.php',

    filebrowserUploadMethod: 'form',

    // language: 'en',
    // filebrowserWindowWidth: '1000',
    // filebrowserWindowHeight: '700'

});
// icons font awesome
CKEDITOR.dtd.$removeEmpty.span = false;
</script>

<?php
}
?>