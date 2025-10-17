<?php
ob_start();
date_default_timezone_set('Asia/Bangkok');
admin_main();

function admin_main()
{
	?>
<nav class='navbar'>
    <div class="container-nav">
        <div class="navbar-header">
            <a class="navbar-brand" href="../index.php" style="color:#FFFFFF !important;">
                <img src="../images/index/logo-eol.png" style="height:40px;margin-top:12px;" />
            </a>
            <?php
				if ($_SESSION["admin"] != "") {
					?>
            <div class="pull-right">
                <a href="../backoffice/mainoffice.php?section=admin&&status=logout"
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

<footer class="f-thai">
    <hr class="f-top">Copyright © 2022 By English Online Co.,Ltd. All rights reserved.
    <hr class="f-bottom">
</footer>
<?php
}

function display_body()
{
	if ($_SESSION["admin"] != '') {
		echo "<div class='main-academic'>";
		admin_main_menu();
		if ($_GET['status'] === "logout") {
			logout();
		}
		echo "</div>";
	}
	if ($_SESSION["admin"] == '') {
		if ($_GET['status'] === "login_form") {
			login_form($_GET['error']);
		}
		if ($_GET['status'] === "login") {
			if ($_POST['username'] && $_POST['password']) {
				login($_POST['username'], $_POST['password']);
			} else {
				echo "<script type=\"text/javascript\">
                            window.location=\"?section=admin&&status=login_form&&error=1\";
                      </script>";
				exit();
			}
		}
		if (!$_GET['status']) {
			echo "<script type=\"text/javascript\">
                        window.location=\"?section=admin&&status=login_form\";
                  </script>";
			exit();
		}
		if ($_GET['type'] && $_GET['status']) {
			echo "<script type=\"text/javascript\">
                        window.location=\"?section=admin&&status=login_form&&error=3\";
                  </script>";
			exit();
		}
		if ($_GET['section'] && $_GET['status'] !== 'login_form') {
			echo "<script type=\"text/javascript\">
                        window.location=\"?section=admin&&status=login_form&&error=3\";
                  </script>";
			exit();
		}

	}
}

function login_form($error)
{

	if ($_SESSION["admin"] == '') {
		$msg = '';
		if ($error == '1') {
			$msg = "<font size=2 color=red><b>Username or Password Incorrect</b></font>";
		}
		if ($error == '2') {
			$msg = "<font size=2 color=red><b>Username & Password ถูกระงับชั่วคราว</b></font>";
		}
		if ($error == '3') {
			$msg = "<font size=2 color=red><b>Session Expired!!!, Please Login again</b></font>";
		}
		?>
<div class="row form-login">
    <div class="col-sm-6 col-sm-offset-3 form-box">
        <div class="form-top">
            <div class="form-top-left f-thai">
                <h3>Academician Login Form</h3>
                <p>Enter your username and password to log on:</p>
                <? if ($error) { ?>
                <p>
                    <?php echo $msg; ?>
                </p>
                <? } ?>
            </div>
            <div class="form-top-right" style="margin-top: 60px;">
                <i class="fa fa-key"></i>
            </div>
        </div>
        <div class="form-bottom">
            <form role="form" action="?section=admin&&status=login" method="post" class="login-form f-thai">
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
	$strSQL = "SELECT * FROM tbl_admin WHERE ADMIN_USERNAME=? && ADMIN_PASSWORD=?";
	$stmt = $conn->prepare($strSQL);
	$stmt->bind_param("ss", $username, $password);
	$stmt->execute();
	$result = $stmt->get_result();
	$is_have = $result->num_rows;

	if ($is_have == 1) {
		$data = $result->fetch_array();
		$stmt->close();

		if ($data['IS_ACTIVE'] == 0) {
			echo "<script type=\"text/javascript\">
					window.location=\"?section=admin&&status=login_form&&error=2\";
				 </script>";
			exit();
		} else {
			$_SESSION["admin"] = trim($data['ADMIN_ID']);
			echo "<script type=\"text/javascript\">
            		  window.location=\"?section=admin\";
            	  </script>";
			exit;
		}
	} else {
		echo "<script type=\"text/javascript\">
                window.location=\"?section=admin&&status=login_form&&error=1\";
             </script>";
		exit;
	}
}

function logout()
{
	session_destroy();
	echo "<script type=\"text/javascript\">
            window.location=\"?section=admin&&status=login_form\";
          </script>";
	exit;
}

function admin_main_menu()
{
	$status = $_GET['status'];
	echo "
		<br><br>
		<div align=center class=f-thai>
			<br><br>
			<a href=?section=$_GET[section]&&status=1>[Check Question Amount]</a>&nbsp;&nbsp;
			<a href=?section=$_GET[section]&&status=2>[Check Reason Index and Details]</a>&nbsp;&nbsp;
			<a href=?section=$_GET[section]&&status=3>[Check Questions List]</a>&nbsp;&nbsp;
		
		<br><br>
			<a href=?section=$_GET[section]&&status=9>[Extra Test System] </a>&nbsp;&nbsp;
			<a href=?section=$_GET[section]&&status=10>[Analyze Quiz] </a>&nbsp;&nbsp;
			<a href=?section=$_GET[section]&&status=11>[Quiz Comment] </a>&nbsp;&nbsp;
            <a href=?section=$_GET[section]&&status=12>[Lessons & Related] </a>&nbsp;&nbsp;
        <br><br>
			<a href=?section=$_GET[section]&&status=16>[Monthly Report] </a>&nbsp;&nbsp;
            <a href=?section=$_GET[section]&&status=17>[Export Report GEPOT Excel] </a>&nbsp;&nbsp;
			<a href=?section=$_GET[section]&&status=18>[Export Report GEPOT PDF] </a>&nbsp;&nbsp;
		<br><br><br>
		<hr>
		</div>";

	if ($status == 1) {
		check_question_amount();
	}
	if ($status == 2) {
		check_reason_index_and_detail();
	}
	if ($status == 3) {
		check_questions_list();
	}
	if ($status == 9) {
		extra_test_system();
	}
	if ($status == 10) {
		if (!$_GET['action']) {
			analyze_quiz_list();
		}
	}
	if ($status == 11) {
		comment_quiz();
	}
	if ($status == 12) {
		lesson_and_relate();
	}
	if($status == 16){	
		monthly_reports();	
	}
	if($status == 17){
		export_report_gepot_to_excel();
	}
	if($status == 18){
		export_report_gepot_to_pdf();
	}
}

function check_question_amount()
{
	include('../config/connection.php');
	$active = 1;
	echo "	<br>
			<table align=center width=100% cellpadding=0 cellspacing=0 border=0 class=f-thai>
				<tr height=50>
					<td align=center colspan=7><font size=4><b>Academic Room</b></font></td>
				</tr>
				<tr height=45 bgcolor='#f7f7f7'>
					<td width=15% align=center><font size=3><b>Skill</b></font></td>
					<td width=14% align=center><font size=3><b>Beginner</b></font></td>
					<td width=14% align=center><font size=3><b>Lower Inter.</b></font></td>
					<td width=14% align=center><font size=3><b>Intermediate</b></font></td>
					<td width=14% align=center><font size=3><b>Upper Inter.</b></font></td>
					<td width=14% align=center><font size=3><b>Advanced</b></font></td>
					<td width=15% align=center><font size=3 color=red><b>Total</b></font></td>
				</tr>";

	$skill_name[1] = "Reading";
	$skill_name[2] = "Listening ";
	$skill_name[3] = "Speaking";
	$skill_name[4] = "Writing";
	$skill_name[5] = "Grammartical ";
	$skill_name[6] = "Intergrated";
	$skill_name[7] = "Vocabulary";
	for ($skill = 1; $skill <= 7; $skill++) {
		$sum_online = 0;
		$sum_offline = 0;
		$sum_all = 0;
		for ($num = 1; $num <= 5; $num++) {
			$strSQL = "SELECT count(QUESTIONS_ID) FROM tbl_questions WHERE TEST_ID = ? && SKILL_ID = ? && LEVEL_ID = ? && IS_ACTIVE = ?";
			$stmt = $conn->prepare($strSQL);
			$stmt->bind_param("ssss", $active, $skill, $num, $active);
			$stmt->execute();
			$result = $stmt->get_result();
			$data = $result->fetch_array();
			$stmt->close();
			$online[$num] = $data[0];
			
			$strSQL = "SELECT count(QUESTIONS_ID) FROM tbl_questions WHERE TEST_ID = ? && SKILL_ID = ? && LEVEL_ID = ? && IS_ACTIVE = 0";
			$stmt = $conn->prepare($strSQL);
			$stmt->bind_param("sss", $active, $skill, $num);
			$stmt->execute();
			$result = $stmt->get_result();
			$data = $result->fetch_array();
			$stmt->close();
			$offline[$num] = $data[0];
			//------------------------------------------------------//
			$total[$num] = $online[$num] + $offline[$num];
			//------------------------------------------------------//
			$sum_online = $sum_online + $online[$num];
			$sum_offline = $sum_offline + $offline[$num];
			$sum_all = $sum_all + $total[$num];
		}
		echo "
			<tr height=35>
				<td align=center><font size=2><b>$skill_name[$skill]</b></font></td>
				<td align=center><font size=2 color=green><b>$online[1]</b></font> + <font size=2 color=red><b>$offline[1]</b></font>
						 = <font size=2 color=blue><b>$total[1]</b></font></td>
				<td align=center><font size=2 color=green><b>$online[2]</b></font> + <font size=2 color=red><b>$offline[2]</b></font>
						 = <font size=2 color=blue><b>$total[2]</b></font></td>
				<td align=center><font size=2 color=green><b>$online[3]</b></font> + <font size=2 color=red><b>$offline[3]</b></font>
						 = <font size=2 color=blue><b>$total[3]</b></font></td>
				<td align=center><font size=2 color=green><b>$online[4]</b></font> + <font size=2 color=red><b>$offline[4]</b></font>
						 = <font size=2 color=blue><b>$total[4]</b></font></td>
				<td align=center><font size=2 color=green><b>$online[5]</b></font> + <font size=2 color=red><b>$offline[5]</b></font>
						 = <font size=2 color=blue><b>$total[5]</b></font></td>
				<td align=center><b><font size=2 color=green><b>$sum_online</b></font> + <font size=2 color=red><b>$sum_offline</b></font>
						 = <font size=2 color=blue><b>$sum_all</b></font></b></td>
			</tr>";

	}
	echo "</table>";
	echo "<br><br>";
	des_table();
}

function des_table()
{
	include('../config/connection.php');
	$skill_name[1] = "Reading";
	$skill_name[2] = "Listening";
	$skill_name[3] = "Speaking";
	$skill_name[4] = "Writing";
	$skill_name[5] = "Grammartical";
	$skill_name[6] = "Cloze test";
	$skill_name[7] = "Vocabulary";
	$table_a = "tbl_questions";
	$table_b = "tbl_description";
	echo "<div align=center class=f-thai>";
	echo "<p>Description in Questions</p>";
	for ($i = 1; $i <= 7; $i++) {
		$SQL = "SELECT $table_a.QUESTIONS_ID FROM $table_a,$table_b
		WHERE $table_a.SKILL_ID='$i' && $table_a.QUESTIONS_ID=$table_b.QUESTIONS_ID order by $table_a.QUESTIONS_ID";
		$stmt = $conn->prepare($SQL);
		$stmt->execute();
		$result = $stmt->get_result();
		$amount[$i] = $result->num_rows;
		if ($i == 7) {
			echo "<font size=2 color=black>$skill_name[$i] : " . ($amount[$i] + 0) . " </font>";
		} else {
			echo "<font size=2 color=black>$skill_name[$i] : " . ($amount[$i] + 0) . " &nbsp;||&nbsp;</font>";
		}
	}
	echo "</div>";
}

function check_reason_index_and_detail()
{
	echo "<div align=center class=f-thai><br><br>";
	echo "<a href=?section=$_GET[section]&&status=$_GET[status]&&skill_id=1>[Reading]</a>&nbsp;&nbsp;";
	echo "<a href=?section=$_GET[section]&&status=$_GET[status]&&skill_id=2>[Listening]</a>&nbsp;&nbsp;";
	echo "<a href=?section=$_GET[section]&&status=$_GET[status]&&skill_id=3>[Semi-Speaking]</a>&nbsp;&nbsp;";
	echo "<a href=?section=$_GET[section]&&status=$_GET[status]&&skill_id=4>[Semi-Writing]</a>&nbsp;&nbsp;";
	echo "<a href=?section=$_GET[section]&&status=$_GET[status]&&skill_id=5>[Grammartic]</a>&nbsp;&nbsp;";
	echo "<a href=?section=$_GET[section]&&status=$_GET[status]&&skill_id=6>[Cloze Test]</a>&nbsp;&nbsp;";
	echo "<a href=?section=$_GET[section]&&status=$_GET[status]&&skill_id=7>[Vocab]</a>&nbsp;&nbsp;";
	echo "</div>";
	if (!$_GET['skill_id']) {
		if ($_GET['detail_id']) {
			each_detail();
		}
		if($_GET['quiz_id']){
			show_item_quiz();
		}
		if (!$_GET['detail_id'] && !$_GET['quiz_id']) {
			weak();
		}
	}
	if ($_GET['skill_id']) {
		each_weak();
	}
	
}

function each_detail()
{
	include('../config/connection.php');
	$strSQL = "SELECT LEVEL_ID,TEST_ID,SKILL_ID,SSKILL_ID,DETAIL_ID,QUESTIONS_ID FROM tbl_questions WHERE DETAIL_ID=? order by SKILL_ID,SSKILL_ID";
	$stmt = $conn->prepare($strSQL);
	$stmt->bind_param("s", $_GET['detail_id']);
	$stmt->execute();
	$result = $stmt->get_result();
	$num = $result->num_rows;
	//--------------------------------------------------------------//
	$result_detail = get_detail(trim($_GET['detail_id']));
	$is_query = $result_detail->num_rows;
	if ($is_query == "1") {
		$sub_data = $result_detail->fetch_array();
		$detail_name = $sub_data['DETAIL_NAME'];
	}
	//--------------------------------------------------------------//
	echo "<div align=center class=f-thai><br><font size=3><b>Found Quiz By Detail ID : $detail_name [ $_GET[detail_id] ] :  $num Quizes</b></font></div><br>&nbsp;";
	echo "
			<table align=center width=100% cellpadding=0 cellspacing=0 border=0 bgcolor=eeeeee class=f-thai>
				<tr height=45>
					<td width=5% align=center><font size=2 color=black><b>No.</td>
					<td width=5% align=center><font size=2 color=black><b>Quiz ID</td>
					<td width=10% align=center><font size=2 color=black><b>Test</td>
					<td width=15% align=center><font size=2 color=black><b>Level</td>
					<td width=5% align=center><font size=2 color=black><b>Skill ID</td>
					<td width=15% align=center><font size=2 color=black><b>Skill Name</td>
					<td width=5% align=center><font size=2 color=black><b>SSkill ID</td>
					<td width=30% align=center><font size=2 color=black><b>SSkill Name</td>
				</tr>
			</table>";

	if ($num >= 1) {
		$test[1] = "<font color=blue>School</font>";
		$test[2] = "<font color=green>Collage</font>";
		$test[3] = "<font color=ff77ff>Professional</font>";
		$test[4] = "<font color=red>Everyone</font>";
		$level[1] = "<font color=blue>Beginner</font>";
		$level[2] = "<font color=green>Lower Intermediate</font>";
		$level[3] = "<font color=brown>Lower Intermediate</font>";
		$level[4] = "<font color=ff77ff>Upper Intermediate</font>";
		$level[5] = "<font color=red>Advance</font>";

		echo "<table align=center width=100% cellpadding=0 cellspacing=0 border=1 class=f-thai>";

		for ($i = 1; $i <= $num; $i++) {
			$data = $result->fetch_array();
			//--------------------------------------------------------------//
			$result_skill = get_skill(trim($data['SKILL_ID']));
			$is_query = $result_skill->num_rows;
			if ($is_query == "1") {
				$sub_data = $result_skill->fetch_array();
				$skill_name = $sub_data['SKILL_NAME'];
			}
			//--------------------------------------------------------------//
			$result_sskill = get_sub_skill(trim($data['SSKILL_ID']));
			$is_query = $result_sskill->num_rows;
			if ($is_query == "1") {
				$sub_data = $result_sskill->fetch_array();
				$sskill_name = $sub_data['SSKILL_NAME'];
			}
			//--------------------------------------------------------------//
			echo "
				<tr height=35>
					<td width=5% align=center><font size=2 color=black>$i</td>
					<td width=5% align=center><font size=2 color=black><a href='?section=$_GET[section]&&status=$_GET[status]&&quiz_id=$data[QUESTIONS_ID]' target='_blank'>$data[QUESTIONS_ID] </a></td>
					<td width=10% align=center><font size=2 color=black>" . $test[$data['TEST_ID']] . "</td>
					<td width=15% align=center><font size=2 color=black>" . $level[$data['LEVEL_ID']] . "</td>
					<td width=5% align=center><font size=2 color=black>$data[SKILL_ID]</td>
					<td width=15% align=center><font size=2 color=black>$skill_name</td>
					<td width=5% align=center><font size=2 color=black>$data[SSKILL_ID]</td>
					<td width=30% align=center><font size=2 color=black>$sskill_name</td>
				</tr>";
		}
		echo "</table>";
	}
}

function weak()
{
	include('../config/connection.php');
	$SQLsskill = "SELECT SSKILL_ID,SSKILL_NAME FROM tbl_item_sskill group by SSKILL_ID order by SSKILL_ID";
	$query_sskill = $conn->prepare($SQLsskill);
	$query_sskill->execute();
	$result_sskill = $query_sskill->get_result();
	$chk_num = $result_sskill->num_rows;
	if ($chk_num >= 1) {
		for ($i = 1; $i <= $chk_num; $i++) {
			$data = $result_sskill->fetch_array();
			$sskill_id[$i] = $data['SSKILL_ID'];
			$sskill_name[$i] = $data['SSKILL_NAME'];
		}
	}
	//================== get ref ====================//
	$SQL = "SELECT DETAIL_ID,DETAIL_NAME,DETAIL_CODE,SSKILL_ID FROM tbl_item_detail group by DETAIL_ID order by DETAIL_ID";
	$query = $conn->prepare($SQL);
	$query->execute();
	$result = $query->get_result();
	$num = $result->num_rows;
	
	$font = "<font color=black size=2>";
	echo "<br><br><br>
		<table align=center width=100% cellpadding=0 cellspacing=0 border=1 bordercolor=gray>
			<tr bgcolor=DDDDDD height=45 class=f-thai>
				<td align=center colspan=6><font color=black size=3> Reason Amounts : $num</font></td>
			</tr>
			<tr bgcolor=EEEEEE height=40 class=f-thai>
				<td align=center>$font &nbsp;No.&nbsp; </td>
				<td align=center>$font &nbsp;DETAIL_ID&nbsp; </td>
				<td align=center>$font &nbsp;SSKILL_ID&nbsp; </td>
				<td align=center>$font &nbsp;SSKILL_NAME&nbsp; </td>
				<td align=center>$font &nbsp;DETAIL_CODE&nbsp; </td>
				<td align=center>$font &nbsp;DETAIL_NAME&nbsp; </td>
			</tr>";

	for ($i = 1; $i <= $num; $i++) {
		$data = $result->fetch_array();
		echo "
			<tr height=35 valign=top class=f-thai>
				<td align=center>$font &nbsp;$i&nbsp; </td>
				<td align=center>$font &nbsp;$data[DETAIL_ID]&nbsp; </td>
				<td align=center>$font &nbsp;$data[SSKILL_ID]&nbsp; </td>
				<td align=left width=20%>
					$font &nbsp;";

		for ($k = 1; $k <= $chk_num; $k++) {
			if ($data['SSKILL_ID'] == $sskill_id[$k]) {
				echo $sskill_name[$k];
			}
		}
		echo "
				</td>
				<td align=center>$font &nbsp;$data[DETAIL_CODE]&nbsp; </td>
				<td align=left width=60%><a href='?section=$_GET[section]&&status=$_GET[status]&&detail_id=$data[DETAIL_ID]' target='_blank'>$font &nbsp; $data[DETAIL_NAME] </a></td>
			</tr>";
	}
	echo "</table>";
}

function each_weak()
{
	include('../config/connection.php');
	$active = 1;
	$skill_name = get_skill_name($_GET['skill_id']);
	$SQLsskill = "SELECT SSKILL_ID,SSKILL_NAME FROM tbl_item_sskill WHERE SKILL_ID = ? group by SSKILL_NAME order by SSKILL_ID";
	$query_sskill = $conn->prepare($SQLsskill);
	$query_sskill->bind_param("s", $_GET['skill_id']);
	$query_sskill->execute();
	$result_sskill = $query_sskill->get_result();
	$chk_num = $result_sskill->num_rows;
	if ($chk_num >= 1) {
		for ($i = 1; $i <= $chk_num; $i++) {
			$data = $result_sskill->fetch_array();
			$sskill_id[$i] = $data['SSKILL_ID'];
			$sskill_name[$i] = $data['SSKILL_NAME'];
		}
	}
	
	$SQL = "SELECT DETAIL_ID,DETAIL_NAME,DETAIL_CODE,SSKILL_ID FROM tbl_item_detail WHERE SKILL_ID = ? group by DETAIL_NAME order by DETAIL_ID";
	$query = $conn->prepare($SQL);
	$query->bind_param("s", $_GET['skill_id']);
	$query->execute();
	$result = $query->get_result();
	$num = $result->num_rows;
	$font = "<font color=black size=2>";
	echo "<br><center class=f-thai><h3><font color=red>$skill_name</font></h3></center>";
	echo "<br><br>
			<table align=center width=100% cellpadding=0 cellspacing=0 border=1 bordercolor=gray>
				<tr bgcolor=DDDDDD height=45 class=f-thai>
					<td align=center colspan=10><font color=black size=3> Reason Amounts : $num </font></td>
				</tr>
				<tr bgcolor=EEEEEE height=40 class=f-thai>
					<td align=center>$font &nbsp;No.&nbsp; </td>
					<td align=center>$font &nbsp;DETAIL_ID&nbsp; </td>
					<td align=center>$font &nbsp;SSKILL_ID&nbsp; </td>
					<td align=center>$font &nbsp;SSKILL_NAME&nbsp; </td>
					<td align=center>$font &nbsp;DETAIL_NAME&nbsp; </td>
					<td align=center>$font &nbsp;B&nbsp; </td>
					<td align=center>$font &nbsp;L&nbsp; </td>
					<td align=center>$font &nbsp;I&nbsp; </td>
					<td align=center>$font &nbsp;U&nbsp; </td>
					<td align=center>$font &nbsp;A&nbsp; </td>
				</tr>";

	for ($i = 1; $i <= $num; $i++) {
		$data = $result->fetch_array();
		echo "
				<tr height=35 valign=top class=f-thai>
					<td align=center width=3%>$font &nbsp;$i&nbsp; </td>
					<td align=center width=6%>$font &nbsp;$data[DETAIL_ID]&nbsp; </td>
					<td align=center width=6%>$font &nbsp;$data[SSKILL_ID]&nbsp; </td>
					<td align=left width=10%>
						$font &nbsp;";

		for ($k = 1; $k <= $chk_num; $k++) {
			if ($data['SSKILL_ID'] == $sskill_id[$k]) {
				echo $sskill_name[$k];
			}
		}
		//-----------------------------------------------------------------//
		for ($p = 1; $p <= 5; $p++) {
			$strSQL = "SELECT QUESTIONS_ID FROM tbl_questions WHERE TEST_ID = ? && LEVEL_ID = ? && SKILL_ID = ? && SSKILL_ID = ? && DETAIL_ID = ?";
			$stmt = $conn->prepare($strSQL);
			$stmt->bind_param("sssss", $active, $p, $_GET['skill_id'], $data['SSKILL_ID'], $data['DETAIL_ID']);
			$stmt->execute();
			$result_ques = $stmt->get_result();
			$amount_num = $result_ques->num_rows;
			$sub_amount[$p] = $amount_num;
		}
		//-----------------------------------------------------------------//
		echo "
				</td>
				<td align=left width=40%><a href='?section=$_GET[section]&&status=$_GET[status]&&detail_id=$data[DETAIL_ID]' target='_blank'>$font &nbsp; $data[DETAIL_NAME] </a></td>
				<td align=center width=7%>$font $sub_amount[1]</td>
				<td align=center width=7%>$font $sub_amount[2]</td>
				<td align=center width=7%>$font $sub_amount[3]</td>
				<td align=center width=7%>$font $sub_amount[4]</td>
				<td align=center width=7%>$font $sub_amount[5]</td>
			</tr>";
	}
	echo "</table>";
}

function show_item_quiz(){
	include('../config/connection.php');
	$quiz_id = trim($_GET['quiz_id']);
	$strSQL = "SELECT * FROM tbl_questions WHERE QUESTIONS_ID=?";
	$stmt = $conn->prepare($strSQL);
	$stmt->bind_param("s", $quiz_id);
	$stmt->execute();
	$result = $stmt->get_result();
	$num = $result->num_rows;
    if($num>=1)
    {
        for($i=1;$i<=$num;$i++)
        {
            $data = $result->fetch_array();
            $text = $data['QUESTIONS_TEXT'];
            $text = stripslashes($text);
            $text = str_replace("&#039;","'",$text);
            $text = str_replace("&lt;","<",$text);
            $text = str_replace("&gt;",">",$text);
            //---------------------------------------------------//
            $totem = "<font color=green> None Relate File or Passage </font>";
			$result_qmap = get_questions_mapping($quiz_id);
			$is_totem = $result_qmap->num_rows;
            if($is_totem==1)
            {
                $totem_data = $result_qmap->fetch_array();      
                $totem_type_id = $totem_data['GQUESTION_ID'];
                //-----------------------------------------//
				$result_relate = get_questions_relate(trim($totem_type_id));
				$a_have = $result_relate->num_rows;
                if($a_have==1)
                {
					$a_data = $result_relate->fetch_array();    
					$totem_type_id = $a_data['GQUESTION_TYPE_ID'];
                    $totem_id = $a_data['GQUESTION_ID'];
                    $totem_msg = $a_data['GQUESTION_TEXT'];
                    // ============================================================= //
                    // ------------------ Passage กรณีที่เป็นข้อความ -------------------- //
                    // ============================================================= //
                    if($totem_type_id==1)     
                    {
                        $totem_type_msg = "<font color=blue>Passage : ($totem_data[GQUESTION_ID])</font><br><br>";
                        $totem_msg = get_relate_passage($totem_msg);
                    }
                    // ============================================================= //
                    // ------------------ Picture กรณีที่เป็นรูปภาพ -------------------- //
                    // ============================================================= //
                    if($totem_type_id==2)     
                    {
                        $totem_type_msg = "<font color=orange>Picture : ($totem_data[GQUESTION_ID])</font><br><br>";    
						$totem_msg = get_relate_picture($totem_msg);
                    }
                    // ============================================================= //
                    // ------------------ Sound กรณีที่เป็นเสียง-------------------- //
                    // ============================================================= //
                    if($totem_type_id==3)     
                    {
                        $totem_type_msg = "<font color=red>Sound : ($totem_data[GQUESTION_ID])</font><br><br>";    
						$totem_msg = get_relate_sound($totem_msg);
                    }
                        
                }
                $totem = "".$totem_type_msg.$totem_msg;
            }
                
			echo "
				<br>
				<table align=center width=100% border=1 class='f-thai'>
					<tr align=middle>
						<td align=left>";
							//-----------------//	
							$data = get_question($quiz_id);
							//---------------- Get Path section --------------------//
							$result_sec = get_section(trim($data['TEST_ID']));
							$path_num = $result_sec->num_rows;
							if ($path_num == 1) {
								$path_data = $result_sec->fetch_array();
								$path_a = $path_data['TEST_NAME'];
							}
							//---------------- Get Path level --------------------//
							$result_level = get_level(trim($data['LEVEL_ID']));
							$path_num = $result_level->num_rows;
							if ($path_num == 1) {
								$path_data = $result_level->fetch_array();
								$path_b = $path_data['LEVEL_NAME'];
							}
							//---------------- Get Path skill --------------------//
							$result_skill = get_skill(trim($data['SKILL_ID']));
							$path_num = $result_skill->num_rows;
							if ($path_num == 1) {
								$path_data = $result_skill->fetch_array();
								$path_c = $path_data['SKILL_NAME'];
							}
							//---------------- Get Path sub skill --------------------//
							$result_sskill = get_sub_skill(trim($data['SSKILL_ID']));
							$path_num = $result_sskill->num_rows;
							if ($path_num == 1) {
								$path_data = $result_sskill->fetch_array();
								$path_d = $path_data['SSKILL_NAME'];
							}
							//---------------- Get Path reason --------------------//
							$result_detail = get_detail(trim($data['DETAIL_ID']));	
							$path_num = $result_detail->num_rows;
							if ($path_num == 1) {
								$path_data = $result_detail->fetch_array();
								$path_e = $path_data['DETAIL_NAME'];
							}
							echo "	
								<font size=2 face=tahoma color=brown>&nbsp;
									&nbsp; $path_a &nbsp;&nbsp;&raquo;&nbsp;&nbsp; $path_b &nbsp;&nbsp;&raquo;&nbsp;&nbsp; $path_c &nbsp;&nbsp;&raquo;&nbsp;&nbsp;
									$path_d &nbsp;&nbsp;&raquo;&nbsp;&nbsp; $path_e  
								</font>
								";
							//-----------------//
			echo "
						</td>
					</tr>
					<tr>
						<td align=left width=10%>
							$totem
						</td>
					</tr>
                    <tr valign=top>
                        <td width=10%>
						&nbsp;[$quiz_id] $text
                        </td>      
                    </tr>
                    <tr>
                        <td align=left width=90%> ";
                            
							$result_ans = get_answers(trim($quiz_id));
							$sub_num = $result_ans->num_rows;
                            if($sub_num)
                            {
                                for($k=1;$k<=$sub_num;$k++)
                                {
                                    $sub_data = $result_ans->fetch_array();
									$ans_text = stripslashes($sub_data['ANSWERS_TEXT']);
                                    if($sub_data['ANSWERS_CORRECT']=="1")
									{    
										$correct = "<font color=blue> True </font>";    
									}
                                    else{   
										$correct = "<font color=red> False </font>";    
									}
                                    echo "&nbsp;&nbsp; [$sub_data[ANSWERS_ID]] : $correct : ".$ans_text." <br>";
                                }
                            }
						// ========================================================================== //
						// ---------------- Description and None Description ------------------------ //
						// ========================================================================== //
                echo "
                        </td>
                    </tr>
                    <tr>
                        <td colspan=2>
                            <font size=2 ><b>&nbsp;Description : <br></b></font>";
							$result_des = get_description(trim($quiz_id));
							$is_des = $result_des->num_rows;
                            if($is_des=="1")
                            {
                                $des_data = $result_des->fetch_array();  
                                echo "<font size=2 color=blue> $des_data[TEXT] </font>"; 
                            }else{  
								echo "<div align=center><font size=2 color=red><b> - None Description - </b></font></div><br>";    
							}
                echo "
                         </td>
                    </tr>
                </table>";
		}
	}
}

function check_questions_list()
{
	echo "<br><br><br><div align=center class=f-thai><a href=?section=$_GET[section]&&status=$_GET[status]&&type=10>[Search List]</a>&nbsp;&nbsp;&nbsp;";
	echo "<a href=?section=$_GET[section]&&status=$_GET[status]&&type=6>[Add Questions]</a>&nbsp;&nbsp;&nbsp;";
	echo "<a href=?section=$_GET[section]&&status=$_GET[status]&&type=7>[Add Related Item]</a>&nbsp;&nbsp;&nbsp;";
	echo "<a href=?section=$_GET[section]&&status=$_GET[status]&&type=1>[Show Question List]</a>&nbsp;&nbsp;&nbsp;";
	echo "<a href=?section=$_GET[section]&&status=$_GET[status]&&type=2>[Hidden Question List]</a>&nbsp;&nbsp;&nbsp;";
	echo "<a href=?section=$_GET[section]&&status=$_GET[status]&&type=4>[Show Related List]</a>&nbsp;&nbsp;&nbsp;";
	echo "<a href=?section=$_GET[section]&&status=$_GET[status]&&type=5>[Hidden Related List]</a></div><br><br>";

	if ($_GET['search'] == 1) {
		set_select_event_session();
	}
	if ($_GET['edit'] === "question") {
		edit_question_form();
	}
	if ($_GET['edit'] === "edit") {
		edit_question();
	}
	if ($_GET['edit'] === "active") {
		set_active();
	}
	if ($_GET['edit_item'] === "active") {
		set_item_active();
	}
	if ($_GET['del'] === "quiz") {
		del_quiz();
	}
	if ($_GET['edit_relate'] === "form") {
		edit_relate_form();
	}
	if ($_GET['edit_relate'] === "edit") {
		edit_relate();
	}
	if ($_GET['edit_relate'] === "set_relate") {
		set_relate();
	}
	if ($_GET['type'] == 1 && !$_GET['edit']) {
		show_quiz();
	}
	if ($_GET['type'] == 2 && !$_GET['edit']) {
		hidden_quiz();
	}
	if ($_GET['type'] == 4 && !$_GET['edit_relate']) {
		show_relate_data_list();
	}
	if ($_GET['type'] == 5 && !$_GET['edit_relate']) {
		hidden_relate_data_list();
	}
	if ($_GET['type'] == 10 && !$_GET['edit_relate'] && !$_GET['edit']) {
		search_list();
	}
	if ($_GET['type'] == 7 && !$_GET['edit_relate']) {
		add_relate_form();
		echo "<br>";
		last_item_list();
	}
	if ($_GET['type'] == 6 && !$_GET['edit']) {
		add_quiz_form();
		echo "<br>";
		last_quiz_list();
	}
}


function set_select_event_session()
{
	$section_id = $_POST['section_id'] + 0;
	$level_id = $_POST['level_id'] + 0;
	$skill_id = $_POST['skill_id'] + 0;
	$sskill_id = $_POST['sskill_id'] + 0;
	$reason_id = $_POST['reason_id'] + 0;
	$_SESSION['section_id'] = $section_id;
	$_SESSION['level_id'] = $level_id;
	$_SESSION['skill_id'] = $skill_id;
	$_SESSION['sskill_id'] = $sskill_id;
	$_SESSION['reason_id'] = $reason_id;
	header("Location:?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]");
}

function edit_question_form()
{
	include('../config/connection.php');
	$data = get_question(trim($_GET['question']));
	//----------------------------------------//
	$totem = "<font color=green> None Relate File or Passage </font>";
	$result_qmap = get_questions_mapping(trim($_GET['question']));
	$is_totem = $result_qmap->num_rows;
	if ($is_totem == 1) {
		$totem_data = $result_qmap->fetch_array();
		$totem_type_id = $totem_data['GQUESTION_ID'];
		//-----------------------------------------//
		$result_relate = get_questions_relate(trim($totem_type_id));
		$a_have = $result_relate->num_rows;
		if ($a_have == 1) {
			$a_data = $result_relate->fetch_array();
			$totem_type_id = $a_data['GQUESTION_TYPE_ID'];
			$totem_msg = $a_data['GQUESTION_TEXT'];
			if ($totem_type_id == 1) {
				$totem_type_msg = "<font color=blue>Passage : </font><br><br>";
				$totem_msg = get_relate_passage($totem_msg);
			}
			if ($totem_type_id == 2) {
				$totem_type_msg = "<font color=orange>Picture : </font><br><br>";
				$totem_msg = get_relate_picture($totem_msg);
			}
			if ($totem_type_id == 3) {
				$totem_type_msg = "<font color=red>Sound : </font><br><br>";
				$totem_msg = get_relate_sound($totem_msg);
			}

		}
		$totem = "" . $totem_type_msg . $totem_msg;
	}
	//------------------------------------------------------//
	$result_des = get_description(trim($_GET['question']));
	$is_des = $result_des->num_rows;
	if ($is_des == 1) {
		$des_data = $result_des->fetch_array();
		$des_text = $des_data['TEXT'] ? $des_data['TEXT'] : '- None Description -';
	}
	//---------------------------------------------------------//
	echo "	<br><br><br><br>
			<table width=100% cellpadding=0 cellspacing=0 border=1 align=center class=f-thai>
				<tr>
					<td colspan=2 align=left>";

	move_question_form();

	echo "				
					</td>
				</tr>
				<form method=post action=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit=edit&&question=$_GET[question]>
				<tr valign=top>
					<td width=10% align=center rowspan=2><font size=2 > $data[QUESTIONS_ID]</td>
					<td width=90% align=left>$totem<br><br>";

	$value = stripslashes($data['QUESTIONS_TEXT']) ? stripslashes($data['QUESTIONS_TEXT']) : ' ';
	
	echo "
					<textarea id='topic_detail' name='question' class='form-control topic_detail' placeholder='' rows='15'>
					$value</textarea>

					</td>
				</tr>
				<tr>
					<td><font size=2>&nbsp; <b>Description : </b><br></font>";

	echo "<textarea id='description' name='des_text' class='form-control description' placeholder='' rows='15'>
	$des_text</textarea>
					<br><br>
					<option>";

	$result_ans = get_answers(trim($_GET['question']));
	$num = $result_ans->num_rows;
	if ($num >= 1) {
		for ($i = 1; $i <= $num; $i++) {
			$sub_data = $result_ans->fetch_array();
			$ans_text = $sub_data['ANSWERS_TEXT'];

			//$ans_text = stripslashes($sub_data[ANSWERS_TEXT]);
			if ($sub_data['ANSWERS_CORRECT'] == "1") {
				$check = "checked";
				$color = "red";
			}
			if ($sub_data['ANSWERS_CORRECT'] == "0") {
				$check = "";
				$color = "black";
			}
			echo "
				<font size=2 color=$color>
						$sub_data[ANSWERS_ID] : 
					<input type=radio name=correct value='$sub_data[ANSWERS_ID]' $check> - 
								"; ?>
<input type='text' name="<?= 'order_' . $i; ?>" value="<?php echo $ans_text; ?>" size="100"> <br>
<?php echo "
					<input type=hidden name='ref_$i' value='$sub_data[ANSWERS_ID]'>
				</font>";
		}

	}
	echo "			
					</option><br><br>
					<input type=submit value='&nbsp;&nbsp;&nbsp; Edit Question &nbsp;&nbsp;&nbsp;' class='btn-edit'>
				</td>
				</tr>
				<tr>
					<td colspan=2>&nbsp;</td>
				</tr>
			</form>
			</table><br><br><br>&nbsp;";
			script_ckeditor_detail();
			script_ckeditor_description();
}

function move_question_form()
{
	include('../config/connection.php');
	if ($_POST['set_section'] && $_POST['set_level'] && $_POST['set_skill']) {
		unset($_SESSION["set_sub_skill"]);
	}
	if ($_POST['set_sub_skill']) {
		unset($_SESSION["set_reason"]);
	}
	if ($_POST['set_section'] >= 1) {
		$_SESSION['set_section'] = $_POST['set_section'];
	}
	if ($_POST['set_level'] >= 1) {
		$_SESSION['set_level'] = $_POST['set_level'];
	}
	if ($_POST['set_skill'] >= 1) {
		$_SESSION['set_skill'] = $_POST['set_skill'];
	}
	if ($_POST['set_sub_skill'] >= 1) {
		$_SESSION['set_sub_skill'] = $_POST['set_sub_skill'];
	}
	if ($_POST['set_reason'] >= 1) {
		$_SESSION['set_reason'] = $_POST['set_reason'];
	}
	//------------------------------------------------------------------------//
	if ($_POST['active'] === "change") {
		$SQL = "UPDATE tbl_questions SET TEST_ID = ?, LEVEL_ID=?, SKILL_ID=?, SSKILL_ID=?, DETAIL_ID=?  WHERE QUESTIONS_ID = ?";
		$query = $conn->prepare($SQL);
		$query->bind_param("ssssss", $_SESSION['set_section'], $_SESSION['set_level'], $_SESSION['set_skill'], $_SESSION['set_sub_skill'], $_SESSION['set_reason'], $_GET['question']);
		$query->execute();
		$query->close();
	}
	//------------------------------------------------------------------------//
	echo "
		<table align=center width=100% cellspading=0 cellspacing=0 border=0 class=f-thai>
		<form action=?section=$_GET[section]&&status=$_GET[status]&&edit=$_GET[edit]&&question=$_GET[question] method=post>
			<tr bgcolor=eeeeee height=30>
				<td width=28% align=center><font size=2> Section : ";

	//---- Section List ----//
	echo "
					<select name=set_section> <option value=0 > - Select Section - </option>";

	$section_name[1] = "School";
	$section_name[2] = "Collage";
	$section_name[3] = "Professional";
	$section_name[4] = "Everyone";
	
	for ($i = 1; $i <= 4; $i++) {
		if ($_SESSION['set_section'] == $i) {
			echo "<option value=$i selected>$section_name[$i]</option>";
			$section_msg = "$section_name[$i]";
		} else {
			echo "<option value=$i >$section_name[$i]</option>";
		}
	}
	echo "
					</select>
				</td>
				<td width=28% align=center><font size=2> Level : ";
	//---- Section List ----//
	echo "
					<select name=set_level> <option value=0 > - Select Level - </option>";

	$level_name[1] = "Beginner";
	$level_name[2] = "Lower Intermediate";
	$level_name[3] = "Intermediate";
	$level_name[4] = "Upper Intermediate";
	$level_name[5] = "Advance";
	
	for ($i = 1; $i <= 5; $i++) {
		if ($_SESSION['set_level'] == $i) {
			echo "<option value=$i selected>$level_name[$i]</option>";
			$level_msg = "$level_name[$i]";
		} else {
			echo "<option value=$i >$level_name[$i]</option>";
		}
	}
	echo "
					</select>
				</td>
				<td width=34% align=center><font size=2> Skill : ";

	//---- Skill List ----//
	echo "
					<select name=set_skill> <option value=0 > - Select Skill - </option>";

	$skill_name[1] = "Reading Comprehension";
	$skill_name[2] = "Listening Comprehension";
	$skill_name[3] = "Semi-Speaking";
	$skill_name[4] = "Semi-Writing";
	$skill_name[5] = "Grammatical Structure";
	$skill_name[6] = "Integrated Skill : Cloze Test";
	$skill_name[7] = "Vocabulary Items";

	for ($i = 1; $i <= 7; $i++) {
		if ($_SESSION['set_skill'] == $i) {
			echo "<option value=$i selected>$skill_name[$i]</option>";
			$skill_msg = "$skill_name[$i]";
		} else {
			echo "<option value=$i >$skill_name[$i]</option>";
		}
	}
	echo "
					</select>
				</td>
				<td align=center width=10%>
					<input class='btn-set-path' type=submit value='&nbsp;&nbsp; Set First Path &nbsp;&nbsp;&nbsp;'>
				</td>
			</tr>
		</form>";

	//---- Sub Skill List ----//
	
	if ($_SESSION['set_section'] >= 1 && $_SESSION['set_level'] >= 1 && $_SESSION['set_skill'] >= 1) {
		echo "
			<tr bgcolor=dddddd height=30>
				<form action=?section=$_GET[section]&&status=$_GET[status]&&edit=$_GET[edit]&&question=$_GET[question] method=post>
				<td align=left colspan=3><font size=2 >&nbsp; Sub Skill : 
					<select name=set_sub_skill> 
						<option value=0 > - Select Sub Skill - </option>";

		$SQLsskill = "SELECT * FROM tbl_item_sskill WHERE SKILL_ID = ? && LEVEL_ID = ?  && TEST_ID = ? order by SSKILL_NAME ASC";
		$query_sskill = $conn->prepare($SQLsskill);
		$query_sskill->bind_param("sss", $_SESSION['set_skill'], $_SESSION['set_level'], $_SESSION['set_section']);
		$query_sskill->execute();
		$result_sskill = $query_sskill->get_result();
		$num = $result_sskill->num_rows;
		for ($i = 1; $i <= $num; $i++) {
			$data = $result_sskill->fetch_array();
			$sub_skill_name = $data['SSKILL_NAME'];
			$sub_skill_id = trim($data['SSKILL_ID']);

			if ($_SESSION['set_sub_skill'] == $sub_skill_id) {
				echo "<option value=$sub_skill_id selected>$sub_skill_name</option>";
				$sub_skill_msg = "$sub_skill_name";
			} else {
				echo "<option value=$sub_skill_id >$sub_skill_name</option>";
			}
		}
		echo "
					</select>
				</td>
				<td align=center>				
					<input class='btn-set-path' type=submit value='Set Second Path' >
				</td>
				</form>
			</tr>";
				
		if ($_SESSION['set_sub_skill'] >= 1) {
			$SQLdetail = "SELECT * FROM tbl_item_detail WHERE SSKILL_ID=? && SKILL_ID=? && LEVEL_ID=? && TEST_ID=? order by DETAIL_NAME ASC";
			$query_detail = $conn->prepare($SQLdetail);
			$query_detail->bind_param("ssss", $_SESSION['set_sub_skill'], $_SESSION['set_skill'], $_SESSION['set_level'], $_SESSION['set_section']);
			$query_detail->execute();
			$result_detail = $query_detail->get_result();
			$num = $result_detail->num_rows;
			echo "<tr bgcolor=cccccc height=30>
						<form action=?section=$_GET[section]&&status=$_GET[status]&&edit=$_GET[edit]&&question=$_GET[question] method=post>
							<td colspan=3><font size=2 >
								&nbsp; Reason : <select name=set_reason> 
								<option value=0 > - Select Reason - </option>";
									
			for ($i = 1; $i <= $num; $i++) {
				$data = $result_detail->fetch_array();
				$detail_name = $data['DETAIL_NAME'];
				$detail_id = trim($data['DETAIL_ID']);
				if ($_SESSION['set_reason'] == $detail_id) {
					echo "<option value=$detail_id selected>$detail_name</option>";
					$reason_msg = "$detail_name";
				} else {
					echo "<option value=$detail_id >$detail_name</option>";
				}
			}
			echo "
								</select>
							</td>
							<td align=center>				
								<input class='btn-set-path' type=submit value='&nbsp;&nbsp; Set Final Path &nbsp;&nbsp;' >
							</td>
						</form>
					</tr>";
		}
	}
	echo "
					<tr valign=middle>
					<form action=?section=$_GET[section]&&status=$_GET[status]&&edit=$_GET[edit]&&question=$_GET[question] method=post>
						<td colspan=3>";
						
	if ($_GET['edit'] === "question") {
		//------------------------------------------------------//
		$data = get_question(trim($_GET['question']));
		//---------------- Get Path section --------------------//
		$result_sec = get_section(trim($data['TEST_ID']));
		$path_num = $result_sec->num_rows;
		if ($path_num == 1) {
			$path_data = $result_sec->fetch_array();
			$path_a = $path_data['TEST_NAME'];
		}
		//---------------- Get Path level ----------------------//
		$result_level = get_level(trim($data['LEVEL_ID']));
		$path_num = $result_level->num_rows;
		if ($path_num == 1) {
			$path_data = $result_level->fetch_array();
			$path_b = $path_data['LEVEL_NAME'];
		}
		//---------------- Get Path skill --------------------//
		$result_skill = get_skill(trim($data['SKILL_ID']));
		$path_num = $result_skill->num_rows;
		if ($path_num == 1) {
			$path_data = $result_skill->fetch_array();
			$path_c = $path_data['SKILL_NAME'];
		}
		//---------------- Get Path sub skill --------------------//
		$result_sskill = get_sub_skill(trim($data['SSKILL_ID']));	
		$path_num = $result_sskill->num_rows;
		if ($path_num == 1) {
			$path_data = $result_sskill->fetch_array();
			$path_d = $path_data['SSKILL_NAME'];
		}
		//---------------- Get Path reason --------------------//
		$result_detail = get_detail(trim($data['DETAIL_ID']));
		$path_num = $result_detail->num_rows;
		if ($path_num == 1) {
			$path_data = $result_detail->fetch_array();
			$path_e = $path_data['DETAIL_NAME'];
		}
		echo "	
				<font size=2 color=green>&nbsp;
					Default Path : $path_a &nbsp;&nbsp;&raquo;&nbsp;&nbsp; $path_b &nbsp;&nbsp;&raquo;&nbsp;&nbsp; $path_c &nbsp;&nbsp;&raquo;&nbsp;&nbsp;
					$path_d &nbsp;&nbsp;&raquo;<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
					$path_e  
				</font>";
	}
	if ($_SESSION['set_section'] && $_SESSION['set_level'] && $_SESSION['set_skill'] && $_SESSION['set_sub_skill'] && $_SESSION['set_reason']) {
		echo "	<br>
					<font size=2 color=red>&nbsp;
						Change Path : $section_msg &nbsp;&nbsp;&raquo;&nbsp;&nbsp; $level_msg &nbsp;&nbsp;&raquo;&nbsp;&nbsp; $skill_msg &nbsp;&nbsp;&raquo;&nbsp;&nbsp;
						$sub_skill_msg &nbsp;&nbsp;&raquo;<br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
						$reason_msg  
					</font>
					</td>
					<td align=center>
						<input type=hidden value='change' name=active>
						<input type=submit value='&nbsp;Confirm Change&nbsp;' class='btn-set-path'>
						";
	}
	echo "
					</td>
				</form>
				</tr>	
			</table>";
}

function edit_question()
{
	include('../config/connection.php');
	echo "<br>";
	$question_id = trim($_GET['question']);
	$question_text = $_POST['question'];
	$detail = $question_text;
	echo "$detail<br>";
	//$detail = addslashes($question_text);
	//$detail = str_replace("&quot;","",$detail);
	$detail = str_replace("&#039;", "'", $detail);
	$detail = str_replace("&lt;", "<", $detail);
	$detail = str_replace("&gt;", ">", $detail);
	$correct = $_POST['correct'];
	$answer['text'][1] = $_POST['order_1'];
	$answer['text'][2] = $_POST['order_2'];
	$answer['text'][3] = $_POST['order_3'];
	$answer['text'][4] = $_POST['order_4'];
	//-----------------------------------------------------------//
	$answer['text'][1] = htmlspecialchars($answer['text'][1]);
	$answer['text'][2] = htmlspecialchars($answer['text'][2]);
	$answer['text'][3] = htmlspecialchars($answer['text'][3]);
	$answer['text'][4] = htmlspecialchars($answer['text'][4]);
	//-----------------------------------------------------------//
	$answer['text'][1] = str_replace("‘", "&#039;", $answer['text'][1]);
	$answer['text'][1] = str_replace("’", "&#039;", $answer['text'][1]);
	$answer['text'][1] = str_replace("“", "&quot;", $answer['text'][1]);
	$answer['text'][1] = str_replace("”", "&quot;", $answer['text'][1]);
	//-----------------------------------------------------------//
	$answer['text'][2] = str_replace("‘", "&#039;", $answer['text'][2]);
	$answer['text'][2] = str_replace("’", "&#039;", $answer['text'][2]);
	$answer['text'][2] = str_replace("“", "&quot;", $answer['text'][2]);
	$answer['text'][2] = str_replace("”", "&quot;", $answer['text'][2]);
	//-----------------------------------------------------------//
	$answer['text'][3] = str_replace("‘", "&#039;", $answer['text'][3]);
	$answer['text'][3] = str_replace("’", "&#039;", $answer['text'][3]);
	$answer['text'][3] = str_replace("“", "&quot;", $answer['text'][3]);
	$answer['text'][3] = str_replace("”", "&quot;", $answer['text'][3]);
	//-----------------------------------------------------------//
	$answer['text'][4] = str_replace("‘", "&#039;", $answer['text'][4]);
	$answer['text'][4] = str_replace("’", "&#039;", $answer['text'][4]);
	$answer['text'][4] = str_replace("“", "&quot;", $answer['text'][4]);
	$answer['text'][4] = str_replace("”", "&quot;", $answer['text'][4]);
	//-----------------------------------------------------------//
	$answer['ref'][1] = $_POST['ref_1'];
	$answer['ref'][2] = $_POST['ref_2'];
	$answer['ref'][3] = $_POST['ref_3'];
	$answer['ref'][4] = $_POST['ref_4'];
	
	for ($i = 1; $i <= 4; $i++) {
		if ($answer['ref'][$i] == $correct) {
			$ans_correct[$i] = "1";
		} else {
			$ans_correct[$i] = "0";
		}
	}
	
	update_data('tbl_questions', 'QUESTIONS_TEXT', $detail, 'QUESTIONS_ID' ,$question_id);
	//===================================================================//
	update_answers($answer['text'][1], $ans_correct[1], $answer['ref'][1]);
	//-------------------------------------------------------------------//
	update_answers($answer['text'][2], $ans_correct[2], $answer['ref'][2]);
	//-------------------------------------------------------------------//
	update_answers($answer['text'][3], $ans_correct[3], $answer['ref'][3]);
	//-------------------------------------------------------------------//
	update_answers($answer['text'][4], $ans_correct[4], $answer['ref'][4]);
	//-------------------------------------------------------------------//
	$des_long = strlen(trim($_POST['des_text']));
	if ($des_long >= "1") {
		$result_des = get_description($question_id);
		$is_des = $result_des->num_rows;
		if ($is_des == 1) {
			update_data('tbl_description', 'TEXT', $_POST['des_text'], 'QUESTIONS_ID' ,$question_id);
		} else {
			$strSQL = "INSERT INTO tbl_description (QUESTIONS_ID,TEXT) VALUES(?,?)";
			$stmt = $conn->prepare($strSQL);
			$stmt->bind_param("ss", $question_id, $_POST['des_text']);
			$stmt->execute();
			$stmt->close();
		}
	} else {
		delete_data('tbl_description', 'QUESTIONS_ID' , $question_id);
	}
	//-------------------------------------------------------------------//
	header("Location:?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit=question&&question=$_GET[question]");
}

function set_active()
{
	include('../config/connection.php');
	if ($_GET['question']) {
		update_data('tbl_questions', 'IS_ACTIVE', trim($_GET['active']), 'QUESTIONS_ID' ,trim($_GET['question']));
	}
	if ($_POST['question']) {
		update_data('tbl_questions', 'IS_ACTIVE', trim($_GET['active']), 'QUESTIONS_ID' ,trim($_POST['question']));
	}
	if ($_GET['edit_relate'] && $_GET['relate_id']) {
		header("Location:?section=$_GET[section]&&status=$_GET[status]&&edit_relate=$_GET[edit_relate]&&relate_id=$_GET[relate_id]");
	}
	if (!$_GET['edit_relate'] && !$_GET['relate_id']) {
		header("Location:?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&page=$_GET[page]");
	}
}

function set_item_active()
{
	include('../config/connection.php');
	if ($_GET['page']) {
		$page = $_GET['page'];
	} else {
		$page = 1;
	}
	if ($_GET['item_id']) {
		update_data('tbl_gquestion', 'IS_ACTIVE', trim($_GET['active']), 'GQUESTION_ID' ,trim($_GET['item_id']));
	}
	header("Location:?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&page=$page");
}

function del_quiz()
{
	include('../config/connection.php');
	if ($_GET['quiz_id'] >= 1) {
		delete_data('tbl_questions', 'QUESTIONS_ID' , trim($_GET['quiz_id']));
		delete_data('tbl_answers', 'QUESTIONS_ID' , trim($_GET['quiz_id']));
		delete_data('tbl_questions_mapping', 'QUESTIONS_ID' , trim($_GET['quiz_id']));
		delete_data('tbl_result_detail', 'QUESTIONS_ID' , trim($_GET['quiz_id']));
		delete_data('tbl_etest_mapping', 'QUESTIONS_ID' , trim($_GET['quiz_id']));
		delete_data('tbl_description', 'QUESTIONS_ID' , trim($_GET['quiz_id']));
	}
	header("Location:?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&page=$_GET[page]");
}

function edit_relate_form()
{
	include('../config/connection.php');
	$result = get_questions_relate(trim($_GET['relate_id']));
	$is_have = $result->num_rows;
	if ($is_have == 1) {
		$y_data = $result->fetch_array();
		if ($y_data['GQUESTION_TYPE_ID'] == 1) {
			//-----------------------------------------------------------------------------------//
			echo "
				<table align=center cellpadding=0 cellspacing=0 width=100% border=1 class=f-thai>
					<form action='?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit_relate=edit&&relate_id=$_GET[relate_id]' method=post >	
						<tr valign=top>
							<td align=center width=10% rowspan=2>$y_data[GQUESTION_ID]</td>
							<td align=center width=90%>";
			//----------------------------------------------//
			$value = stripslashes($y_data['GQUESTION_TEXT']);
			echo "
			
                                <textarea id='topic_detail' name='relate' class='form-control topic_detail' placeholder='' rows='20'>
                                 $value</textarea>
                           
							</td>
						</tr>
						<tr>
							<td><input type=submit value='Edit Passage' class='btn-edit'></td>
						</tr>
					</form>	
				</table>";
				script_ckeditor_detail();
			//-----------------------------------------------------------------------//	
		}
		if ($y_data['GQUESTION_TYPE_ID'] == 2) {
			$msg = "" . str_replace("/home/engtest/domains/engtest.net/public_html/", "/", $y_data['GQUESTION_TEXT']) . "<br>
				<img src=" . str_replace("/home/engtest/domains/engtest.net/public_html/", "/", $y_data['GQUESTION_TEXT']) . " border=0 style='width: 75%; height: auto;'>";
			echo "
						<table align=center width=100% cellspacing=0 cellpaddinging=0 border=1 class=f-thai>
							<tr>
								<td align=center>$msg</td>
							</tr>
							<form enctype='multipart/form-data' action='?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit_relate=edit&&relate_id=$_GET[relate_id]' method=post >	
							<tr>
								<td align=center><input type=file name='pic_file' size=50 required>&nbsp;&nbsp;&nbsp;<input type=submit value='Upload' class='btn-add'></td>
							</tr>
							</form>
						</table>";
		}
		if ($y_data['GQUESTION_TYPE_ID'] == 3) {
			$totem_type_msg = "<font color=red>Sound : ($y_data[GQUESTION_TEXT])</font><br><br>";
			$msg =	get_relate_sound($y_data['GQUESTION_TEXT']);

			echo "
						<table align=center width=100% cellspacing=0 cellpaddinging=0 border=1 class=f-thai>
							<tr>
								<td align=center>$msg</td>
							</tr>
							<form enctype='multipart/form-data' action='?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit_relate=edit&&relate_id=$_GET[relate_id]' method=post >	
							<tr>
								<td align=center>
								<font size=2><br>
										.mp3 File : <input type=file name='sound_file' size=50 required><br><br>
									<input type=submit value='Upload' class='btn-add'><br>&nbsp;
								</font>
								</td>
							</tr>
							</form>
						</table>	
						";
		}
		set_relate_form("by quiz", "-", "-");
		//------------------------- Relate Quiz list ----------------------------//
		$SQLqmap = "SELECT * FROM tbl_questions_mapping WHERE GQUESTION_ID = ? order by GQUESTION_ID ASC";
		$query_qmap = $conn->prepare($SQLqmap);
		$query_qmap->bind_param("s", $_GET['relate_id']);
		$query_qmap->execute();
		$result_qmap = $query_qmap->get_result();
		$x_num = $result_qmap->num_rows;
		if ($x_num >= 1) {
			for ($p = 1; $p <= $x_num; $p++) {
				$x_data = $result_qmap->fetch_array();
				$quiz_id = $x_data['QUESTIONS_ID'];
				$SQLques = "SELECT * FROM tbl_questions WHERE QUESTIONS_ID = ? order by QUESTIONS_ID ASC";
				$query_ques = $conn->prepare($SQLques);
				$query_ques->bind_param("s", $quiz_id);
				$query_ques->execute();
				$result_ques = $query_ques->get_result();
				$num = $result_ques->num_rows;
				if ($num >= 1) {
					for ($i = 1; $i <= $num; $i++) {
						$data = $result_ques->fetch_array();
						$text = $data['QUESTIONS_TEXT'];
						$text = stripslashes($text);
						$text = str_replace("&#039;", "'", $text);
						$text = str_replace("&lt;", "<", $text);
						$text = str_replace("&gt;", ">", $text);
						$id = $data['QUESTIONS_ID'];
						//---------------------------------------------------//
						echo " <br>
								<table align=center width=100% border=1 class=f-thai>	
									<tr valign=top>
										<td align=center rowspan=3 width=10%>
											$id
										<br><br><br>";

						if ($data['IS_ACTIVE'] == 0) {
							$msg_set = "<a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit=active&&active=1&&question=$id&&edit_relate=form&&relate_id=$_GET[relate_id]>
														<font size=2 color=green> Set Show </a>";
						}
						if ($data['IS_ACTIVE'] == 1) {
							$msg_set = "<a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit=active&&active=0&&question=$id&&edit_relate=form&&relate_id=$_GET[relate_id]>
														<font size=2 color=red> Set Hidden </a>";
						}
						echo "
															$msg_set					
										</td>
										<td align=left width=90%>
											<a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&relate_id=$_GET[relate_id]&&quiz_id=$id&&edit_relate=set_relate&&action=del>		
													<font size=3 color=brown> Set Question </font>=><font size=3 color=green> None Relate Item </font>
											</a>
										</td>
									</tr>
									<tr>	
										<td align=left width=100%><font size=2>$text</font>								
											<br><br><a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit=question&&question=$id target=_blank> >>  Edit Question << </a><br>&nbsp;
										</td>
									</tr>
									<tr>
										<td align=left width=90%><br>";

						$result_ans = get_answers(trim($id));
						$sub_num = $result_ans->num_rows;
						if ($sub_num) {
							for ($k = 1; $k <= $sub_num; $k++) {
								$sub_data = $result_ans->fetch_array();
								$ans_text = stripslashes($sub_data['ANSWERS_TEXT']);
								if ($sub_data['ANSWERS_CORRECT'] == "1") {
									$correct = "<font color=blue> True </font>";
								} else {
									$correct = "<font color=red> False </font>";
								}
								echo "&nbsp;&nbsp; $sub_data[ANSWERS_ID] : $correct : " . $ans_text . " <br>";
							}
						}
						echo "
										</td>
									</tr>
									<tr>
										<td colspan=2>
											<font size=2><b>&nbsp;Description : <br></b></font>";

						$result_des = get_description(trim($id));
						$is_des = $result_des->num_rows;
						if ($is_des == 1) {
							$des_data = $result_des->fetch_array();
							echo "<font  size=2 color=blue>$des_data[TEXT]</font>";
						} else {
							echo "<div align=center><font size=2 color=red><b> - None Description - </b></font></div><br>";
						}
						echo "
										</td>
									</tr>
								</table>";
					}
				}
			}
		}	
	}
}

function set_relate_form($type, $id, $relate)
{
	if ($type == "by quiz") {
		$font = "<font size=2 color=blue>";
		echo "<br>
			<table align=center width=350 cellpadding=0 cellspacing=0 border=0 class=f-thai>
			<form action=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&relate_id=$_GET[relate_id]&&edit_relate=set_relate&&action=add_by_quiz method=post>	
				<tr width=300>
					<td align=center>$font Quiz ID</td>
					<td align=center>$font &nbsp;:&nbsp;</td>
					<td align=center>
						<input type=text name=quiz_id size=5 required>
						<input type=hidden name=relate_id value='$_GET[relate_id]'>
					</td>
					<td align=center>$font &nbsp;:&nbsp;</td>
					<td align=left><input type=submit value='Set Relate' class='btn-set-relate'></td>
				</tr>
			</form>
			</table>
			";
	}
	if ($type == "by relate") {
		if ($_GET['page']) {
			$page = $_GET['page'];
		} else {
			$page = "1";
		}
		$font = "<font size=2 color=blue>";
		echo "<br>
			<table align=center width=550 cellpadding=0 cellspacing=0 border=0 class=f-thai>
			<form action=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&relate_id=$_GET[relate_id]&&edit_relate=set_relate&&action=add_by_relate&&page=$_GET[page] method=post>	
				<tr>
					<td align=center>$font Relate ID</td>
					<td align=center>$font &nbsp;:&nbsp;</td>
					<td align=center>
						<input type=text name=relate_id size=5 required>
						<input type=hidden name=quiz_id value='$id'>
					</td>
					<td align=center>$font &nbsp;:&nbsp;</td>
					<td align=left>
						<input type=submit value='Set Relate' class='btn-set-relate'>
							&nbsp;&nbsp;&laquo;&nbsp;&raquo;&nbsp;&nbsp;
						<a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&relate_id=$relate&&quiz_id=$id&&edit_relate=set_relate&&action=del&&page=$page>		
								<font size=2 color=green>Set to None Relate Item</font>
						</a>
					</td>
				</tr>
			</form>
			</table><br>";
	}
}

function edit_relate()
{
	include('../config/connection.php');
	$relate_id = $_GET['relate_id'];
	if ($_POST['relate']) {

		$relate_text = $_POST['relate'];
		$detail = $relate_text;
		//$detail = addslashes($question_text);
		//$detail = str_replace("&quot;","",$detail);
		$detail = str_replace("&#039;", "'", $detail);
		$detail = str_replace("&lt;", "<", $detail);
		$detail = str_replace("&gt;", ">", $detail);
		update_data('tbl_gquestion', 'GQUESTION_TEXT', $detail, 'GQUESTION_ID' ,trim($relate_id));
	}
	if ($_FILES['pic_file']) {
		$temp = $_FILES['pic_file']['tmp_name'];
		$des_dir = $_SERVER['DOCUMENT_ROOT'] . "/files/picture/";
		if ($_FILES['pic_file']['type'] == "image/jpeg" || $_FILES['pic_file']['type'] == "image/pjpeg") {
			$name = "" . date("Y-m-d-h-i-s") . "-" . $_FILES['pic_file']['name'];
			update_data('tbl_gquestion', 'GQUESTION_TEXT', $name, 'GQUESTION_ID' ,trim($relate_id));
			//------------------------------------------------------------//
			$des = $des_dir . $name;
			copy($temp, $des);
			unlink($temp);
		}
	}
	if ($_FILES['sound_file']) {
		$prefix = "" . date("Y-m-d-H-i-s") . "-";
		$temp_mp3 = $_FILES['sound_file']['tmp_name'];
		$des_dir_mp3 = $_SERVER['DOCUMENT_ROOT'] . "/files/sound/";
		if (
			($_FILES['sound_file']['type'] == "audio/mp3" || $_FILES['sound_file']['type'] == "audio/mpeg" || $_FILES['sound_file']['type'] == "application/octet-stream")
		) {
			$name = $prefix . $_FILES['sound_file']['name'];
			update_data('tbl_gquestion', 'GQUESTION_TEXT', $name, 'GQUESTION_ID' ,trim($relate_id));
			$des_mp3 = $des_dir_mp3 . $name;
			copy($temp_mp3, $des_mp3);
			unlink($temp_mp3);
		}
	}
	header("Location:?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit_relate=form&&relate_id=$relate_id");
}

function set_relate()
{
	include('../config/connection.php');
	if ($_GET['action'] === "add_by_quiz") {
		$relate_id = $_POST['relate_id'] + 0;
		$quiz_id = $_POST['quiz_id'] + 0;
		if ($relate_id >= 1 && $quiz_id >= 1) {
			$result = get_questions_mapping(trim($_POST['quiz_id']));
			$num = $result->num_rows;
			//-----------------------------------------------------//
			if ($num == 0) {
				$strSQL = "INSERT INTO tbl_questions_mapping (QUESTIONS_ID,GQUESTION_ID) VALUES(?,?)";
				$stmt = $conn->prepare($strSQL);
				$stmt->bind_param("ss", $_POST['quiz_id'], $_POST['relate_id']);
				$stmt->execute();
				$stmt->close();
			}
		}
		header("Location:?section=$_GET[section]&&status=3&&type=$_GET[type]&&edit_relate=form&&relate_id=$relate_id&&sub_type=$_GET[sub_type]");
	}
	if ($_GET['action'] === "add_by_relate") {
		var_dump($_POST);
		$relate_id = $_POST['relate_id'] + 0;
		$quiz_id = $_POST['quiz_id'] + 0;
		echo "$relate_id : $quiz_id";
		if ($relate_id >= 1 && $quiz_id >= 1) {
			$result_qmap = get_questions_mapping(trim($_POST['quiz_id']));	
			$num = $result_qmap->num_rows;
			//-----------------------------------------------------//
			if ($num == 0) {
				$strSQL = "INSERT INTO tbl_questions_mapping (QUESTIONS_ID,GQUESTION_ID) VALUES(?,?)";
				$stmt = $conn->prepare($strSQL);
				$stmt->bind_param("ss", $_POST['quiz_id'], $_POST['relate_id']);
				$stmt->execute();
				$stmt->close();
			}
			if ($num == 1) {
				$data = $result_qmap->fetch_array();
				$SQL = "UPDATE tbl_questions_mapping SET QUESTIONS_ID = ?, GQUESTION_ID = ? WHERE QUESTIONS_ID = ? && GQUESTION_ID = ? ";
				$query = $conn->prepare($SQL);
				$query->bind_param("ssss", $_POST['quiz_id'], $_POST['relate_id'], $data['QUESTIONS_ID'], $data['GQUESTION_ID']);
				$query->execute();
				$query->close();
			}
		}
		header("Location:?section=$_GET[section]&&status=3&&type=$_GET[type]&&page=$_GET[page]");
	}
	if ($_GET['action'] === "del") {
		$relate_id = $_GET['relate_id'] + 0;
		$quiz_id = $_GET['quiz_id'] + 0;
		if ($relate_id >= 1 && $quiz_id >= 1) {
			$SQL = "DELETE FROM tbl_questions_mapping WHERE QUESTIONS_ID = ? && GQUESTION_ID=?";
			$stmt = $conn->prepare($SQL);
			$stmt->bind_param("ss", $quiz_id, $relate_id);
			$stmt->execute();
			$stmt->close();
		}
		if ($_GET['page']) {
			header("Location:?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&page=$_GET[page]");
		}
		if (!$_GET['page']) {
			header("Location:?section=$_GET[section]&&status=3&&type=$_GET[type]&&edit_relate=form&&relate_id=$relate_id&&sub_type=$_GET[sub_type]");
		}
	}
}

function show_quiz()
{
	include('../config/connection.php');
	set_select_quiz_event();
	$font_page = "<font size=2>";
	//----------------------//
	$amount = 20;
	$msg_where = "IS_ACTIVE='1'";
	if ($_SESSION['section_id'] >= "1") {
		$msg_where = $msg_where . " && TEST_ID='" . $_SESSION['section_id'] . "' ";
	}
	if ($_SESSION['level_id'] >= "1") {
		$msg_where = $msg_where . " && LEVEL_ID='" . $_SESSION['level_id'] . "' ";
	}
	if ($_SESSION['skill_id'] >= "1") {
		$msg_where = $msg_where . " && SKILL_ID='" . $_SESSION['skill_id'] . "' ";
	}
	if($_SESSION['sskill_id']>="1"){ 
		$msg_where = $msg_where. " && SSKILL_ID='".$_SESSION['sskill_id']."'";
	}
	if($_SESSION['reason_id']>="1"){ 
		$msg_where = $msg_where." && DETAIL_ID='".$_SESSION['reason_id']."'";
	}
	$strSQL = "SELECT QUESTIONS_ID FROM tbl_questions WHERE $msg_where order by QUESTIONS_ID";
	$stmt = $conn->prepare($strSQL);
	$stmt->execute();
	$result = $stmt->get_result();
	$total = $result->num_rows;
	$stmt->close();
	$all_page = $total / $amount;
	$page_arr = explode(".", $all_page);
	if ($page_arr[1] > 0) {
		$all_page = $page_arr[0] + 1;
	} else {
		$all_page = $page_arr[0];
	}

	echo "<br><div align=center class=f-thai><font size=5 color=green><b>Show Question List [$total Items]</b></font></div><br>";
	// ==================================================================== //
	// -------------- แสดงจำนวนหน้าทั้งหมดของรายการข้อสอบ ---------------------- //

	echo "<table align=center width=100% border=0 cellpadding= cellspacing=0 class=f-thai>
			<tr valign=top>
				<td width=7% align=right>$font_page Page : </td>
				<td align=left width=93%>";

	for ($i = 1; $i <= $all_page; $i++) {
		if ($_GET['page'] == $i) {
			$page_color = "red";
		} else {
			$page_color = "blue";
		}
		echo "&nbsp;&nbsp;<a href=?section=$_GET[section]&&status=3&&type=$_GET[type]&&page=$i><font size=2 color=$page_color>$i</a>&nbsp;&nbsp;";
		if ($i % 20 == 0) {
			echo "<br>";
		}
	}
	echo "	</td>
			</tr>
		 </table>";
	
	//-----------------------------------------------------------------------//
	$page = $_GET['page'];
	if (!$_GET['page']) {
		$page = 1;
	}
	$start = ($page - 1) * $amount;
	$SQL = "SELECT * FROM tbl_questions WHERE $msg_where order by QUESTIONS_ID limit $start,$amount";
	$query = $conn->prepare($SQL);
	$query->execute();
	$result_ques = $query->get_result();
	$num = $result_ques->num_rows;
	if ($num >= 1) {
		$j = 1;
		while ($row = $result_ques->fetch_assoc()) {
			$temp_id[$j] = $row['QUESTIONS_ID'];
			$temp_data[$j] = $row['QUESTIONS_TEXT'];
			$j++;
		}
		for ($i = 1; $i <= $num; $i++) {
			$text = $temp_data[$i];
			$text = stripslashes($text);
			$text = str_replace("&#039;", "'", $text);
			$text = str_replace("&lt;", "<", $text);
			$text = str_replace("&gt;", ">", $text);
			$id = trim($temp_id[$i]);
			//---------------------------------------------------//
			$totem = "<font color=green> None Relate File or Passage </font>";
			$result_qmap = get_questions_mapping($id);
			$is_totem = $result_qmap->num_rows;
			// echo $is_totem . "questions_mapping <br>";
			if ($is_totem == 1) {
				$totem_data = $result_qmap->fetch_array();
				$totem_type_id = $totem_data['GQUESTION_ID'];
				//-----------------------------------------//
				$result_relate = get_questions_relate(trim($totem_type_id));
				$a_have = $result_relate->num_rows;
				// echo $a_have . "questions_relate <br>";
				if ($a_have == 1) {
					$a_data = $result_relate->fetch_array();
					$totem_type_id = $a_data['GQUESTION_TYPE_ID'];
					$totem_id = $a_data['GQUESTION_ID'];
					$totem_msg = $a_data['GQUESTION_TEXT'];
					// ============================================================= //
					// ------------------ Passage กรณีที่เป็นข้อความ -------------------- //
					// ============================================================= //
					if ($totem_type_id == 1) {
						$totem_type_msg = "<font color=blue>Passage : ($totem_data[GQUESTION_ID])</font><br><br>";
						$totem_msg = get_relate_passage($totem_msg);
					}
					// ============================================================= //
					// ------------------ Picture กรณีที่เป็นรูปภาพ -------------------- //
					// ============================================================= //
					if ($totem_type_id == 2) {
						$totem_type_msg = "<font color=orange>Picture : ($totem_data[GQUESTION_ID])</font><br><br>";
						$totem_msg = get_relate_picture($totem_msg);
					}
					// ============================================================= //
					// ------------------ Sound กรณีที่เป็นเสียง-------------------- //
					// ============================================================= //
					if ($totem_type_id == 3) {
						$totem_type_msg = "<font color=red>Sound : ($totem_data[GQUESTION_ID])</font><br><br>";
						$totem_msg = get_relate_sound($totem_msg);
					}

				}
				$totem = "" . $totem_type_msg . $totem_msg;
			}
			//******************************************************//
			echo " <br>
					<table align=center width=100% border=1 style='margin: 0 auto;' class='f-thai show-quiz'>
						<tr align=middle>
							<td colspan=2 align=left>";
			//-----------------//	
			$data = get_question($id);
			//---------------- Get Path section --------------------//
			$result_sec = get_section(trim($data['TEST_ID']));
			$path_num = $result_sec->num_rows;
			if ($path_num == 1) {
				$path_data = $result_sec->fetch_array();
				$path_a = $path_data['TEST_NAME'];
			}
			//---------------- Get Path level --------------------//
			$result_level = get_level(trim($data['LEVEL_ID']));	
			$path_num = $result_level->num_rows;
			if ($path_num == 1) {
				$path_data = $result_level->fetch_array();
				$path_b = $path_data['LEVEL_NAME'];
			}
			//---------------- Get Path skill --------------------//
			$result_skill = get_skill(trim($data['SKILL_ID']));
			$path_num = $result_skill->num_rows;
			if ($path_num == 1) {
				$path_data = $result_skill->fetch_array();
				$path_c = $path_data['SKILL_NAME'];
			}
			//---------------- Get Path sub skill --------------------//
			$result_sskill = get_sub_skill(trim($data['SSKILL_ID']));
			$path_num = $result_sskill->num_rows;
			if ($path_num == 1) {
				$path_data = $result_sskill->fetch_array();
				$path_d = $path_data['SSKILL_NAME'];
			}
			//---------------- Get Path reason --------------------//
			$result_detail = get_detail(trim($data['DETAIL_ID']));	
			$path_num = $result_detail->num_rows;
			if ($path_num == 1) {
				$path_data = $result_detail->fetch_array();
				$path_e = $path_data['DETAIL_NAME'];
			}
			echo "	
									<font size=2 color=brown>&nbsp;
										&nbsp; $path_a &nbsp;&nbsp;&raquo;&nbsp;&nbsp; $path_b &nbsp;&nbsp;&raquo;&nbsp;&nbsp; $path_c &nbsp;&nbsp;&raquo;&nbsp;&nbsp;
										$path_d &nbsp;&nbsp;&raquo;&nbsp;&nbsp; <br>&nbsp; &nbsp; $path_e  
									</font>
									";
			// ----------------------------------------------------------------------- //
			// ========================== ฟอร์มแสดงข้อสอบ ============================== //
			// ----------------------------------------------------------------------- //

			echo "
							</td>
						</tr>
						<tr valign=top>
							<td align=center rowspan=3 width=10%>
								$id
								<br><br><br>
								<a title='Show' href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&page=$page&&edit=active&&active=0&&question=$id> Set Hidden </a><br><br><b>[$i]</b>		
									<br><br>
									<input class='btn-delete' type=button value='Delete' 
										onclick=\"javascript:
											if(confirm('คุณต้องการลบข้อสอบข้อนี้ใช่หรือไม่ ?'))
											{
												window.location='?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&page=$_GET[page]&&del=quiz&&quiz_id=$id';
											}
										\">
			
							</td>
							<td align=left width=90%>
								$totem
							</td>
						</tr>
						<tr>	
							<td align=left width=100% bgcolor=dddddd><font size=2>$text	</font>							
								<br><br><a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit=question&&question=$id target=_blank><font color=red> >>  Edit Question << </font></a><br>&nbsp;
							</td>
						</tr>
						<tr>
							<td align=left width=90%><br>";
							
			$result_ans = get_answers(trim($id));	
			$sub_num = $result_ans->num_rows;
			if ($sub_num) {
				for ($k = 1; $k <= $sub_num; $k++) {
					$sub_data = $result_ans->fetch_array();
					$ans_text = stripslashes($sub_data['ANSWERS_TEXT']);
					if ($sub_data['ANSWERS_CORRECT'] == 1) {
						$correct = "<font color=blue> True </font>";
					} else {
						$correct = "<font color=red> False </font>";
					}
					echo "&nbsp;&nbsp; $sub_data[ANSWERS_ID] : $correct : " . $ans_text . " <br>";
				}
			}
			// ========================================================================== //
			// ---------------- Description and None Description ------------------------ //
			// ========================================================================== //
			echo "
							</td>
						</tr>
						<tr>
							<td colspan=2>
								<font size=2><b>&nbsp;Description : <br></b></font>";
								
			$result_des = get_description(trim($id));	
			$is_des = $result_des->num_rows;
			if ($is_des == 1) {
				$des_data = $result_des->fetch_array();
				echo "<font  size=2 color=blue>$des_data[TEXT]</font>";
			} else {
				echo "<div align=center><font size=2 color=red><b> - None Description - </b></font></div><br>";
			}
			echo "
							</td>
						</tr>
						<tr>
							<td colspan=2>";
			set_relate_form("by relate", $id, $totem_id);
			echo "
							</td>
						</tr>
					</table>";

					
		}
		if($total > 20){
			$next = $_GET['page'] + 1;
			if ($next > $all_page) {
				$next = $all_page;
			}
			$back = $next - 2;
			if ($next <= 1) {
				$back = 1;
			}
			if (!$_GET['page'] || $_GET['page'] == 0 || $_GET['page'] == 1) {
				$next = 2;
				$back = 1;
			}
			echo "	<br>
					<div align=center class='f-thai paginate'>
						<a href=?section=admin&&status=$_GET[status]&&type=1&&page=$back><font size=2 color=red>&raquo; Back &laquo;</font></a>
								&nbsp;&nbsp;&nbsp;&nbsp;<a href=#><font size=2 color=blue>Go to Top</font></a>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href=?section=admin&&status=$_GET[status]&&type=$_GET[type]&&page=$next><font size=2 color=red>&raquo; Next &laquo;</font></a>
					</div>";
		}else{
			echo "	<br>
					<div align=center class='f-thai paginate'>
						<a href=#><font size=2 color=blue>Go to Top</font></a>
					</div>";
		}
	}
	echo "</div>";
}

function set_select_quiz_event(){
	include('../config/connection.php');
	$font = "<font size=2>";
	if($_POST['set_section']&&$_POST['set_level']&&$_POST['set_skill'])
	{	unset($_SESSION["sskill_id"]);	}
	if($_POST['set_sub_skill'])
	{	unset($_SESSION["reason_id"]);	}
	if ($_POST['set_section']>="1") {
		$_SESSION['section_id'] = $_POST['set_section'];
	} else {
		$section_id = "0";
	}
	if ($_POST['set_level']>="1") {
		$_SESSION['level_id'] = $_POST['set_level'];
	} else {
		$level_id = "0";
	}
	if ($_POST['set_skill']>="1") {
		$_SESSION['skill_id'] = $_POST['set_skill'];
	} else {
		$skill_id = "0";
	}
	if ($_POST['set_sub_skill']>="1") {
		$_SESSION['sskill_id'] = $_POST['set_sub_skill'];
	} else {
		$sskill_id = "0";
	}
	if ($_POST['set_reason']>="1") {
		$_SESSION['reason_id'] = $_POST['set_reason'];
	} else {
		$reason_id = "0";
	}
	
	echo "
		<table align=center width=100% cellspading=0 cellspacing=0 border=1 class=f-thai>
			<form action=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type] method=post>
				<tr bgcolor=eeeeee height=30>
					<td width=28% align=center><font size=2> Section : ";
					//---- Section List ----//
					echo "<select name=set_section> <option value=0 > - Select Section - </option>";
					$section_name[1] = "School";	
					$section_name[2] = "College";	
					$section_name[3] = "Professional";	
					$section_name[4] = "Everyone";
					for($i=1;$i<=4;$i++)
					{
						if($_SESSION['section_id']==$i)
						{	
							echo "<option value=$i selected>$section_name[$i]</option>";	
							$section_msg = "$section_name[$i]";	
						}else{	echo "<option value=$i >$section_name[$i]</option>";	}
					}
					echo "
							</select>
						</td>
						<td width=28% align=center><font size=2> Level : ";
					//---- Section List ----//
					echo " <select name=set_level> <option value=0 > - Select Level - </option> ";
					
					$level_name[1] = "Beginner";				
					$level_name[2] = "Lower Intermediate";		
					$level_name[3] = "Intermediate";
					$level_name[4] = "Upper Intermediate";		
					$level_name[5] = "Advance";
					for($i=1;$i<=5;$i++)
					{
						if($_SESSION['level_id']==$i)
						{	
							echo "<option value=$i selected>$level_name[$i]</option>";	
							$level_msg = "$level_name[$i]";	
						}
						else{	echo "<option value=$i >$level_name[$i]</option>";	}
					}
					echo "
							</select>
						</td>
						<td width=34% align=center><font size=2> Skill : ";
					//---- Skill List ----//
					echo " <select name=set_skill> <option value=0 > - Select Skill - </option> ";
					$skill_name[1] = "Reading Comprehension";	
					$skill_name[2] = "Listening Comprehension";		
					$skill_name[3] = "Semi-Speaking";
					$skill_name[4] = "Semi-Writing";			
					$skill_name[5] = "Grammatical Structure";		
					$skill_name[6] = "Integrated Skill : Cloze Test";
					$skill_name[7] = "Vocabulary Items";
					for($i=1;$i<=7;$i++)
					{
						if($_SESSION['skill_id']==$i)
						{	
							echo "<option value=$i selected>$skill_name[$i]</option>";	
							$skill_msg = "$skill_name[$i]";	
						}else{	echo "<option value=$i >$skill_name[$i]</option>";	}
					}
					echo "
							</select>
						</td>
						<td align=center width=10%>
							<input class='btn-set-path' type=submit value='&nbsp;&nbsp; Set First Path &nbsp;&nbsp;&nbsp;'>
						</td>
					</tr>
				</form>";
				//---- Sub Skill List ----//
				if($_SESSION['section_id']>="1"&&$_SESSION['level_id']>="1"&&$_SESSION['skill_id']>="1")
				{
					echo "
					<tr  bgcolor=dddddd height=30>
						<form action=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type] method=post>
							<td align=left colspan=3><font size=2>&nbsp; Sub Skill : 
								<select name=set_sub_skill> <option value=0 > - Select Sub Skill - </option>";
								$strSQL = "SELECT * FROM tbl_item_sskill WHERE TEST_ID=? && LEVEL_ID=? && SKILL_ID=? order by SSKILL_NAME ASC";
								$stmt = $conn->prepare($strSQL);
								$stmt->bind_param("sss", $_SESSION['section_id'], $_SESSION['level_id'], $_SESSION['skill_id']);
								$stmt->execute();
								$result_skill = $stmt->get_result();
								$num = $result_skill->num_rows;
								for($i=1;$i<=$num;$i++)
								{
									$data = $result_skill->fetch_array();		$sub_skill_name = $data['SSKILL_NAME'];	$sub_skill_id = $data['SSKILL_ID'];
									if($_SESSION['sskill_id']==$sub_skill_id)
									{	
										echo "<option value=$sub_skill_id selected>$sub_skill_name</option>";	
										$sub_skill_msg = "$sub_skill_name";	
									}
									else{	
										echo "<option value=$sub_skill_id >$sub_skill_name</option>";	
									}
								}
						echo "
								</select>
							</td>
							<td align=center>				
								<input class='btn-set-path' type=submit value='Set Second Path' >
							</td>
						</form>
					</tr>";
				if($_SESSION['sskill_id']>="1")
				{
					$SQLdetail = "SELECT * FROM tbl_item_detail WHERE TEST_ID=? && LEVEL_ID=? && SKILL_ID=? && SSKILL_ID = ? order by DETAIL_NAME ASC";
					$query_detail = $conn->prepare($SQLdetail);
					$query_detail->bind_param("ssss", $_SESSION['section_id'], $_SESSION['level_id'], $_SESSION['skill_id'], $_SESSION['sskill_id']);
					$query_detail->execute();
					$result_detail = $query_detail->get_result();
					$num = $result_detail->num_rows;
					echo "<tr bgcolor=cccccc height=30>
							<form action=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type] method=post>
								<td colspan=3><font size=2 >
									&nbsp; Reason : 
									<select name=set_reason> 
										<option value=0 > - Select Reason - </option>";
										for($i=1;$i<=$num;$i++)
										{
											$data = $result_detail->fetch_array();		$detail_name = $data['DETAIL_NAME'];	$detail_id = $data['DETAIL_ID'];
											if($_SESSION['reason_id']==$detail_id)
											{	
												echo "<option value=$detail_id selected>$detail_name</option>";	$reason_msg = "$detail_name";	
											}else{	
												echo "<option value=$detail_id >$detail_name</option>";	
											}
										}
								echo "
									</select>
								</td>
								<td align=center>				
									<input class='btn-set-path' type=submit value='&nbsp;&nbsp; Search &nbsp;&nbsp;' >
								</td>
							</form>
						</tr>";
								}
							}
		echo "</table>";
}

function hidden_quiz()
{
	include('../config/connection.php');
	set_select_quiz_event();
	//----------------------//
	$font_page = "<font size=2>";
	$amount = 20;
	$msg_where = "IS_ACTIVE='0'";
	if ($_SESSION['section_id'] >= "1") {
		$msg_where = $msg_where . " && TEST_ID='" . $_SESSION['section_id'] . "' ";
	}
	if ($_SESSION['level_id'] >= "1") {
		$msg_where = $msg_where . " && LEVEL_ID='" . $_SESSION['level_id'] . "' ";
	}
	if ($_SESSION['skill_id'] >= "1") {
		$msg_where = $msg_where . " && SKILL_ID='" . $_SESSION['skill_id'] . "' ";
	}
	if($_SESSION['sskill_id']>="1"){ 
		$msg_where = $msg_where. " && SSKILL_ID='".$_SESSION['sskill_id']."'";
	}
	if($_SESSION['reason_id']>="1"){ 
		$msg_where = $msg_where." && DETAIL_ID='".$_SESSION['reason_id']."'";
	}
	$strSQL = "SELECT QUESTIONS_ID FROM tbl_questions WHERE $msg_where order by QUESTIONS_ID";
	$stmt = $conn->prepare($strSQL);
	$stmt->execute();
	$result = $stmt->get_result();	
	$total = $result->num_rows;
	$stmt->close();
	$all_page = $total / $amount;
	$page_arr = explode(".", $all_page);
	if ($page_arr[1] > 0) {
		$all_page = $page_arr[0] + 1;
	} else {
		$all_page = $page_arr[0];
	}
	echo "<br><div align=center class=f-thai><font size=5 color=brown><b>Hidden Question List [$total Items]</b></font></div><br>";
	echo "	<table align=center width=100% border=0 cellpadding=0 cellspacing=0 class=f-thai>
				<tr valign=top>
					<td width=7% align=right>$font_page Page : </td>
					<td align=left width=93%>";

	for ($i = 1; $i <= $all_page; $i++) {
		if ($_GET['page'] == $i) {
			$page_color = "red";
		} else {
			$page_color = "blue";
		}
		echo "&nbsp;&nbsp;<a href=?section=$_GET[section]&&status=3&&type=$_GET[type]&&page=$i><font size=2 color=$page_color>$i</a>&nbsp;&nbsp;";
		if ($i % 20 == 0) {
			echo "<br>";
		}
	}
	echo "	</td>
				</tr>
			</table>";
	
	//-----------------------------------------------------------------------//
	$page = $_GET['page'];
	if (!$_GET['page']) {
		$page = 1;
	}
	$start = ($page - 1) * $amount;
	$SQL = "SELECT * FROM tbl_questions WHERE $msg_where order by QUESTIONS_ID LIMIT $start,$amount";
	$query = $conn->prepare($SQL);
	$query->execute();
	$result_ques = $query->get_result();
	$num = $result_ques->num_rows;
	if ($num >= 1) {
		for ($i = 1; $i <= $num; $i++) {
			$data = $result_ques->fetch_array();
			$text = $data['QUESTIONS_TEXT'];
			$text = stripslashes($text);
			$text = str_replace("&#039;", "'", $text);
			$text = str_replace("&lt;", "<", $text);
			$text = str_replace("&gt;", ">", $text);
			$id = $data['QUESTIONS_ID'];
			//---------------------------------------------------//
			$totem = "<font color=green> None Relate File or Passage </font>";
			$result_ques = get_questions_mapping(trim($id));	
			$is_totem = $result_ques->num_rows;
			if ($is_totem == 1) {
				$totem_data = $result_ques->fetch_array();
				$totem_type_id = $totem_data['GQUESTION_ID'];
				//-----------------------------------------//
				$result_relate = get_questions_relate(trim($totem_type_id));
				$a_have = $result_relate->num_rows;
				if ($a_have == 1) {
					$a_data = $result_relate->fetch_array();
					$totem_type_id = $a_data['GQUESTION_TYPE_ID'];
					$totem_id = $a_data['GQUESTION_ID'];
					$totem_msg = $a_data['GQUESTION_TEXT'];
					if ($totem_type_id == 1) {
						$totem_type_msg = "<font color=blue>Passage : ($totem_data[GQUESTION_ID])</font><br><br>";
						$totem_msg = get_relate_passage($totem_msg);
					}
					if ($totem_type_id == 2) {
						$totem_type_msg = "<font color=orange>Picture : ($totem_data[GQUESTION_ID])</font><br><br>";
						$totem_msg = get_relate_picture($totem_msg);
					}
					if ($totem_type_id == 3) {
						$totem_type_msg = "<font color=red>Sound : ($totem_data[GQUESTION_ID])</font><br><br>";
						$totem_msg = get_relate_sound($totem_msg);
					}

				}
				$totem = "" . $totem_type_msg . $totem_msg;
			}
			//******************************************************//
			echo " <br>
				   <table align=center width=100% border=1 class='f-thai hidden-quiz' style='margin: 0 auto;'>
						<tr align=middle>
							<td colspan=2 align=left>";
			//-----------------//	
			$data = get_question($id);
			$result_sec = get_section(trim($data['TEST_ID']));
			$path_num = $result_sec->num_rows;
			if ($path_num == 1) {
				$path_data = $result_sec->fetch_array();
				$path_a = $path_data['TEST_NAME'];
			}
			//---------------- Get Path level --------------------//
			$result_level = get_level(trim($data['LEVEL_ID']));
			$path_num = $result_level->num_rows;
			if ($path_num == 1) {
				$path_data = $result_level->fetch_array();
				$path_b = $path_data['LEVEL_NAME'];
			}
			//---------------- Get Path skill --------------------//
			$result_skill = get_skill(trim($data['SKILL_ID']));
			$path_num = $result_skill->num_rows;
			if ($path_num == 1) {
				$path_data = $result_skill->fetch_array();
				$path_c = $path_data['SKILL_NAME'];
			}
			//---------------- Get Path sub skill --------------------//
			$result_sskill = get_sub_skill(trim($data['SSKILL_ID']));
			$path_num = $result_sskill->num_rows;
			if ($path_num == 1) {
				$path_data = $result_sskill->fetch_array();
				$path_d = $path_data['SSKILL_NAME'];
			}
			//---------------- Get Path reason --------------------//
			$result_detail = get_detail(trim($data['DETAIL_ID']));	
			$path_num = $result_detail->num_rows;
			if ($path_num == 1) {
				$path_data = $result_detail->fetch_array();
				$path_e = $path_data['DETAIL_NAME'];
			}
			echo "	
									<font size=2 color=brown>&nbsp;
										&nbsp; $path_a &nbsp;&nbsp;&raquo;&nbsp;&nbsp; $path_b &nbsp;&nbsp;&raquo;&nbsp;&nbsp; $path_c &nbsp;&nbsp;&raquo;&nbsp;&nbsp;
										$path_d &nbsp;&nbsp;&raquo;&nbsp;&nbsp; <br>&nbsp; &nbsp; $path_e  
									</font>";
			//-----------------//
			echo "
							</td>
						</tr>
						<tr valign=top>
							<td align=center rowspan=3 width=10%>
								$id
								<br><br><br>
								<a title='Hidden' href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit=active&&active=1&&question=$id> Set Show </a>	<br><br><b>[$i]</b>
									<br><br>
									<input class='btn-delete' type=button value='Delete' 
											onclick=\"javascript:
												if(confirm('คุณต้องการลบข้อสอบข้อนี้ใช่หรือไม่ ?'))
												{
													window.location='?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&page=$_GET[page]&&del=quiz&&quiz_id=$id';
												}
											\">
							</td>
							<td align=left width=90%>
								$totem
							</td>
						</tr>
						<tr>	
							<td align=left width=100% bgcolor=dddddd><font size=2>$text	</font>								
								<br><br><a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit=question&&question=$id target=_blank><font color=red> >>  Edit Question << </font></a><br>&nbsp;
							</td>
						</tr>
						<tr>
							<td align=left width=90%><br>";
							
			$result_ans = get_answers(trim($id));
			$sub_num = $result_ans->num_rows;
			if ($sub_num) {
				for ($k = 1; $k <= $sub_num; $k++) {
					$sub_data = $result_ans->fetch_array();
					$ans_text = stripslashes($sub_data['ANSWERS_TEXT']);
					if ($sub_data['ANSWERS_CORRECT'] == "1") {
						$correct = "<font color=blue> True </font>";
					} else {
						$correct = "<font color=red> False </font>";
					}
					echo "&nbsp;&nbsp; $sub_data[ANSWERS_ID] : $correct : " . $ans_text . " <br>";
				}
			}
			echo "
							</td>
						</tr>
						<tr>
							<td colspan=2>
								<font size=2><b>&nbsp;Description : <br></b></font>";
				
			$result_des = get_description(trim($id));
			$is_des = $result_des->num_rows;
			if ($is_des == "1") {
				$des_data = $result_des->fetch_array();
				echo "<font  size=2 color=blue>$des_data[TEXT]</font>";
			} else {
				echo "<div align=center><font size=2 color=red><b> - None Description - </b></font></div><br>";
			}
			echo "
							</td>
						</tr>
						<tr>
							<td colspan=2>";
			set_relate_form("by relate", $id, $totem_id);
			echo "
							</td>
						</tr>
					</table>";
		}
		if($total > 20){
			$next = $_GET['page'] + 1;
			if ($next > $all_page) {
				$next = $all_page;
			}
			$back = $next - 2;
			if ($next <= 1) {
				$back = 1;
			}
			if (!$_GET['page'] || $_GET['page'] == 0 || $_GET['page'] == 1) {
				$next = 2;
				$back = 1;
			}
			echo "	<br>
					<div align=center class='f-thai paginate'>
						<a href=?section=admin&&status=$_GET[status]&&type=1&&page=$back><font size=2 color=red>&raquo; Back &laquo;</font></a>
								&nbsp;&nbsp;&nbsp;&nbsp;<a href=#><font size=2 color=blue>Go to Top</font></a>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href=?section=admin&&status=$_GET[status]&&type=$_GET[type]&&page=$next><font size=2 color=red>&raquo; Next &laquo;</font></a>
					</div>";
		}else{
			echo "	<br>
					<div align=center class='f-thai paginate'>
						<a href=#><font size=2 color=blue>Go to Top</font></a>
					</div>";
		}
	}
	echo "</div>";
}

function show_relate_data_list()
{
	include('../config/connection.php');
	echo "
		<br><div align=center class=f-thai>
			<a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&sub_type=1>Passage</a>&nbsp;&nbsp;&nbsp;
			<a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&sub_type=2>Picture</a>&nbsp;&nbsp;&nbsp;
			<a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&sub_type=3>Sound</a>
		</div><br>";

	$font_page = "<font size=2>";
	$amount = 20;
	$active = 1;
	$sub_type = $_GET['sub_type'] + 0;
	if ($sub_type == 0) {
		$sub_type = 1;
	}
	$SQL = "SELECT GQUESTION_ID FROM tbl_gquestion WHERE IS_ACTIVE=? && GQUESTION_TYPE_ID=? order by GQUESTION_ID ASC";
	$query = $conn->prepare($SQL);
	$query->bind_param("is", $active, $sub_type);
	$query->execute();
	$result = $query->get_result();
	$total = $result->num_rows;
	$all_page = $total / $amount;
	$page_arr = explode(".", $all_page);
	if ($page_arr[1] > 0) {
		$all_page = $page_arr[0] + 1;
	} else {
		$all_page = $page_arr[0];
	}
	echo "<br><div align=center class=f-thai><font size=5 color=green><b>Show Relate Item List [$total Items]</b></font></div><br>";
	echo "<table align=center width=100% border=0 cellpadding=0 cellspacing=0 class=f-thai>
			<tr valign=top>
				<td width=7% align=right>$font_page Page : </td>
				<td align=left width=93%>";
	for ($i = 1; $i <= $all_page; $i++) {
		if ($_GET['page'] == $i) {
			$page_color = "red";
		} else {
			$page_color = "blue";
		}
		echo "&nbsp;&nbsp;<a href=?section=$_GET[section]&&status=3&&type=$_GET[type]&&sub_type=$sub_type&&page=$i><font size=2 color=$page_color>$i</a>&nbsp;&nbsp;";
		if ($i % 20 == 0) {
			echo "<br>";
		}
	}
	echo "		</td>
			</tr>
		</table>";
	
	//-----------------------------------------------------------------------//
	
	if ($_GET['page']) {
		$start = $amount * ($_GET['page'] - 1);
	} else {
		$start = 0;
	}
	$SQLrelate = "SELECT * FROM tbl_gquestion WHERE IS_ACTIVE=? && GQUESTION_TYPE_ID=? order by GQUESTION_ID ASC limit $start, $amount";
	$query_relate = $conn->prepare($SQLrelate);
	$query_relate->bind_param("is", $active, $sub_type);
	$query_relate->execute();
	$result_relate = $query_relate->get_result();
	$num = $result_relate->num_rows;
	for ($i = 1; $i <= $num; $i++) {
		$data = $result_relate->fetch_array();
		$font = "<font size=2>";
		$edit_msg = "";
		if ($data['GQUESTION_TYPE_ID'] == 1) {
			$type = "Passage";
			$msg = $data['GQUESTION_TEXT'];
			$edit_msg = "	<a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit_relate=form&&relate_id=$data[GQUESTION_ID]&&sub_type=$sub_type target=_blank>
									<font size=2 color=blue>[ Edit & Details]</a> 
						 		";
		}
		if ($data['GQUESTION_TYPE_ID'] == 2) {
			$type = "Picture";
			$edit_msg = "	<a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit_relate=form&&relate_id=$data[GQUESTION_ID]&&sub_type=$sub_type target=_blank>
									<font size=2 color=blue>[ Edit & Details]</a> 
						 		";
			$msg = "" . str_replace("/home/engtest/domains/engtest.net/public_html/", "/", $data['GQUESTION_TEXT']) . "<br>
							<img src=" . str_replace("/home/engtest/domains/engtest.net/public_html/", "/", $data['GQUESTION_TEXT']) . " border=0 style='width: 75%; height: auto;'>";
		}
		if ($data['GQUESTION_TYPE_ID'] == 3) {
			$type = "Sound";
			$edit_msg = "	<a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit_relate=form&&relate_id=$data[GQUESTION_ID]&&sub_type=$sub_type target=_blank>
									<font size=2 color=blue>[ Edit & Details]</a> 
						 		";
			$width = 300;
			$height = 60;
			$folder = "sound";
			$msg = str_replace("/home/engtest/domains/engtest.net/public_html/files/sound/", "", $data['GQUESTION_TEXT']);
			$msg = str_replace(".flv", ".mp3", $msg);
			$msg = "
							$msg<br>
							<div align=center >
								<audio  controls='controls' height=\"$height\" width=\"$width\" preload='auto'>
									<source src=\"https://www.engtest.net/files/$folder/$msg\" >
								</audio>
							</div>
								";
		}
		if ($data['IS_ACTIVE'] == 0) {
			$active_msg = "<a title='Hidden' href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&page=$_GET[page]&&sub_type=$_GET[sub_type]&&edit_item=active&&active=1&&item_id=$data[GQUESTION_ID]>
								 <font size=2 color=green>[Set Show Item]</font></a>";
		}
		if ($data['IS_ACTIVE'] == 1) {
			$active_msg = "<a title='Show' href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&page=$_GET[page]&&sub_type=$_GET[sub_type]&&edit_item=active&&active=0&&item_id=$data[GQUESTION_ID]>
								<font size=2 color=red>[Set Hidden Item]</font></a>";
		}

		echo "
			<table align=center width=100% cellpadding=0 cellspacing=0 border=1 class='f-thai show-relate' style='margin: 0 auto;'>
				<tr height=40>
					<td width=20% align=center >$font Data ID :$data[GQUESTION_ID]</td>
					<td width=20% align=center >$font Type : $type</td>
					<td width=60% align=left >&nbsp; $font Reference Name $data[GQUESTION_NAME_REF]</td>
				</tr>
				<tr>
					<td width=100% align=left colspan=3> <br><font size=2>$msg</font><br>&nbsp;</td>
				</tr>
				<tr height=50>
					<td width=100% align=center colspan=3>$active_msg Relate Question List $edit_msg</td>
				</tr>
				<tr height=20>
					<td width=100% align=left colspan=3><font size=2>&nbsp;&nbsp;";
		
		$result_qmap = get_questions_mapping_where_gquestion(trim($data['GQUESTION_ID']));
		$a_num = $result_qmap->num_rows;
		if ($a_num >= "1") {
			for ($k = 1; $k <= $a_num; $k++) {
				$a_data = $result_qmap->fetch_array();
				echo $a_data['QUESTIONS_ID'] . "&nbsp;&nbsp;";
				if ($k % 15 == 0) {
					echo "<br>";
				}

			}
		}
		if ($a_num == "0") {
			echo "<div align=center class=f-thai><font size=3 color=red><b>None Relate Question !!!</b></font><br></div>";
		}

		echo "
					</td>
				</tr>
			</table><br>";
	}
	if($total > 20){
		$next = $_GET['page'] + 1;
		if ($next > $all_page) {
			$next = $all_page;
		}
		$back = $next - 2;
		if ($next <= 1) {
			$back = 1;
		}
		if (!$_GET['page'] || $_GET['page'] == 0 || $_GET['page'] == 1) {
			$next = 2;
			$back = 1;
		}
		echo "  <div align=center class='f-thai paginate'>
					<a href=?section=admin&&status=$_GET[status]&&type=$_GET[type]&&sub_type=1&&page=$back><font size=2 color=red>&raquo; Back &laquo;</font></a>
							&nbsp;&nbsp;&nbsp;&nbsp;<a href=#><font size=2 color=blue>Go to Top</font></a>&nbsp;&nbsp;&nbsp;&nbsp;
					<a href=?section=admin&&status=$_GET[status]&&type=$_GET[type]&&sub_type=1&&page=$next><font size=2 color=red>&raquo; Next &laquo;</font></a>
				</div>";
	}else{
		echo "	<br>
				<div align=center class='f-thai paginate'>
					<a href=#><font size=2 color=blue>Go to Top</font></a>
				</div>";
	}
	echo "</div>";
}

function hidden_relate_data_list()
{
	include('../config/connection.php');
	$active = 0;
	echo "
		<br>
		<div align=center class=f-thai>
			<a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&sub_type=1>Passage</a>&nbsp;&nbsp;&nbsp;
			<a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&sub_type=2>Picture</a>&nbsp;&nbsp;&nbsp;
			<a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&sub_type=3>Sound</a>
		</div><br>";
	$font_page = "<font size=2>";
	$amount = 20;
	$sub_type = $_GET['sub_type'] + 0;
	if ($sub_type == 0) {
		$sub_type = 1;
	}
	$SQL = "SELECT GQUESTION_ID FROM tbl_gquestion WHERE IS_ACTIVE=? && GQUESTION_TYPE_ID=? order by GQUESTION_ID ASC";
	$query = $conn->prepare($SQL);
	$query->bind_param("ss", $active, $sub_type);
	$query->execute();
	$result = $query->get_result();
	$total = $result->num_rows;
	$all_page = $total / $amount;
	$page_arr = explode(".", $all_page);
	if ($page_arr[1] > 0) {
		$all_page = $page_arr[0] + 1;
	} else {
		$all_page = $page_arr[0];
	}
	echo "<br><div align=center class=f-thai><font size=5 color=brown><b>Hidden Relate Item List [$total Items]</b></font></div><br>";
	echo "<table align=center width=100% border=0 cellpadding=0 cellspacing=0 class=f-thai>
			<tr valign=top>
				<td width=7% align=right>$font_page Page :
				</td>
				<td align=left width=93%>";

	for ($i = 1; $i <= $all_page; $i++) {
		if ($_GET['page'] == $i) {
			$page_color = "red";
		} else {
			$page_color = "blue";
		}
		echo "&nbsp;&nbsp;<a href=?section=$_GET[section]&&status=3&&type=$_GET[type]&&sub_type=$sub_type&&page=$i><font size=2 color=$page_color>$i</a>&nbsp;&nbsp;";
		if ($i % 20 == 0) {
			echo "<br>";
		}
	}
	echo "</td>
			</tr>
		  </table>";
	
	//-----------------------------------------------------------------------//
	
	if ($_GET['page']) {
		$start = $amount * ($_GET['page'] - 1);
	} else {
		$start = 0;
	}
	$SQLrelate = "SELECT * FROM tbl_gquestion WHERE IS_ACTIVE=? && GQUESTION_TYPE_ID=? order by GQUESTION_ID ASC limit $start,$amount";
	$query_relate = $conn->prepare($SQLrelate);
	$query_relate->bind_param("ss", $active, $sub_type);
	$query_relate->execute();
	$result_relate = $query_relate->get_result();
	$num = $result_relate->num_rows;
	for ($i = 1; $i <= $num; $i++) {
		$data = $result_relate->fetch_array();
		$font = "<font size=2>";
		if ($data['GQUESTION_TYPE_ID'] == 1) {
			$type = "Passage";
			$msg = $data['GQUESTION_TEXT'];
			$edit_msg = "	<a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit_relate=form&&relate_id=$data[GQUESTION_ID]&&sub_type=$sub_type target=_blank>
									<font size=2 color=blue>[ Edit & Details]</a> 
						 		";
		}
		if ($data['GQUESTION_TYPE_ID'] == 2) {
			$type = "Picture";
			$msg = "" . str_replace("/home/engtest/domains/engtest.net/public_html/", "/", $data['GQUESTION_TEXT']) . "<br>
							<img src=" . str_replace("/home/engtest/domains/engtest.net/public_html/", "/", $data['GQUESTION_TEXT']) . " border=0 style='width: 75%; height: auto;'>";
			$edit_msg = "	<a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit_relate=form&&relate_id=$data[GQUESTION_ID]&&sub_type=$sub_type target=_blank>
									<font size=2 color=blue>[ Edit & Details]</a> 
						 		";
		}
		if ($data['GQUESTION_TYPE_ID'] == 3) {
			$type = "Sound";
			$edit_msg = "	<a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit_relate=form&&relate_id=$data[GQUESTION_ID]&&sub_type=$sub_type target=_blank>
									<font size=2 color=blue>[ Edit & Details]</a> 
					 		";
			$type = "Sound";
			$width = 300;
			$height = 60;
			$folder = "sound";
			$msg = str_replace("/home/engtest/domains/engtest.net/public_html/files/sound/", "", $data['GQUESTION_TEXT']);
			$msg = str_replace(".flv", ".mp3", $msg);
			$msg = "
						$msg<br>
						<div align=center >
							<audio  controls='controls' height=\"$height\" width=\"$width\" preload='auto'>
								<source src=\"https://www.engtest.net/files/$folder/$msg\" >
							</audio>
						</div>
								";
			
		}
		if ($data['IS_ACTIVE'] == "0") {
			$active_msg = "<a tile='Hidden' href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&page=$_GET[page]&&sub_type=$_GET[sub_type]&&edit_item=active&&active=1&&item_id=$data[GQUESTION_ID]>
							 <font size=2 color=green>[Set Show Item]</font></a>";
		}
		if ($data['IS_ACTIVE'] == "1") {
			$active_msg = "<a title='Show' href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&page=$_GET[page]&&sub_type=$_GET[sub_type]&&edit_item=active&&active=0&&item_id=$data[GQUESTION_ID]>
							<font size=2 color=red>[Set Hidden Item]</font></a>";
		}
		echo "
			<table align=center width=100% cellpadding=0 cellspacing=0 border=1 class='f-thai hidden-relate' style='margin: 0 auto;'>
				<tr height=40>
					<td width=20% align=center >$font Data ID :$data[GQUESTION_ID]</td>
					<td width=20% align=center >$font Type : $type</td>
					<td width=60% align=left >&nbsp; $font Reference Name $data[GQUESTION_NAME_REF]</td>
				</tr>
				<tr>
					<td width=100% align=left colspan=3 > <br><font size=2>$msg</font><br>&nbsp;</td>
				</tr>
				<tr height=50>
					<td width=100% align=center colspan=3>$active_msg Relate Question List $edit_msg</td>
				</tr>
				<tr height=20>
					<td width=100% align=left colspan=3><font size=2>&nbsp;&nbsp;";
	
		$result_qmap = get_questions_mapping_where_gquestion(trim($data['GQUESTION_ID']));
		$a_num = $result_qmap->num_rows;
		if ($a_num >= "1") {
			for ($k = 1; $k <= $a_num; $k++) {
				$a_data = $result_qmap->fetch_array();
				echo $a_data['QUESTIONS_ID'] . "&nbsp;&nbsp;";
				if ($k % 15 == 0) {
					echo "<br>";
				}

			}
		}
		if ($a_num == "0") {
			echo "<div align=center class=f-thai><font size=3 color=red><b>None Relate Question !!!</b></font><br></div>";
		}

		echo "
					</font></td>
				</tr>
			</table><br>";
	}
	if($total > 20){
		$next = $_GET['page'] + 1;
		if ($next > $all_page) {
			$next = $all_page;
		}
		$back = $next - 2;
		if ($next <= 1) {
			$back = 1;
		}
		if (!$_GET['page'] || $_GET['page'] == 0 || $_GET['page'] == 1) {
			$next = 2;
			$back = 1;
		}else{
			$back = 1;
		}
		
		echo "	<div align=center class='f-thai paginate'>
					<a href=?section=admin&&status=$_GET[status]&&type=$_GET[type]&&sub_type=1&&page=$back><font size=2 color=red>&raquo; Back &laquo;</font></a>
							&nbsp;&nbsp;&nbsp;&nbsp;<a href=#><font size=2 color=blue>Go to Top</font></a>&nbsp;&nbsp;&nbsp;&nbsp;
					<a href=?section=admin&&status=$_GET[status]&&type=$_GET[type]&&sub_type=1&&page=$next><font size=2 color=red>&raquo; Next &laquo;</font></a>
				</div>";
	}else{
		echo "	
				<div align=center class='f-thai paginate'>
					<a href=#><font size=2 color=blue>Go to Top</font></a>
				</div>";
	}
	echo "</div>";
}

function search_list()
{
	include('../config/connection.php');
	if ($_POST['action'] === "search") {
		unset($_SESSION["mode"]);
		unset($_SESSION["find_id"]);
		unset($_SESSION["find_key"]);
		if ($_POST['mode']) {
			$_SESSION['mode'] = $_POST['mode'];
		}
		if (trim($_POST['find_id'])) {
			$_SESSION['find_id'] = $_POST['find_id'];
		}
		if (trim($_POST['find_key'])) {
			$_SESSION['find_key'] = $_POST['find_key'];
		}
		//-----------------------------------------------------------------------------------------------------//
	}
	if ($_SESSION['mode'] == 1) {
		$select_a = "checked";
	}
	if ($_SESSION['mode'] == 2) {
		$select_b = "checked";
	}
	if ($_SESSION['mode'] == 3) {
		$select_c = "checked";
	}
	echo "	
		<table align=center width=100% cellpadding=0 cellspacing=0 border=0 bgcolor=dddddd class=f-thai>
			<form action=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type] method=post>
				<tr height=40>
					<td align=center width=30%><font size=2>
						<input type=radio name=mode value=1 $select_a> &raquo; Question
						<input type=radio name=mode value=2 $select_b> &raquo; Relation
						<input type=radio name=mode value=3 $select_c> &raquo; Answer
					</td>
					<td align=left width=55%><font size=2>
						&nbsp; By ID : &nbsp;<input type=text name=find_id size=5 value='$_SESSION[find_id]'> 
						&nbsp; By Keyword : &nbsp;<input type=text name=find_key size=35 value='$_SESSION[find_key]'>
					</td>
					<td align=center width=15%>
						<input type=hidden value='search' name=action>
						<input type=submit value='&nbsp;&nbsp; Search &nbsp;&nbsp;' class='btn-set-relate'>
					</td>
				</tr>
				<tr height=25>
					<td align=center colspan=3><font size=2 color=red>
						Tips Search : Relation &raquo; by Keyword , It's going to find only in Passage Section [Sounds & Pictures haven't any Keywords] 
					</font></td>
				</tr>
			</form>	
		</table><br>";

	if ($_SESSION['mode']) {
		if ($_SESSION['mode'] == 1) {
			search_in_quiz();
		}
		if ($_SESSION['mode'] == 2) {
			search_in_item();
		}
		if ($_SESSION['mode'] == 3) {
			search_in_answer();
		}
	}
	
}

function search_in_quiz()
{
	include('../config/connection.php');
	$total = 0;
	$amount = 20;
	if ($_SESSION['find_id']) {
		$where = "QUESTIONS_ID='$_SESSION[find_id]' order by QUESTIONS_ID ";
		$strSQL = "SELECT QUESTIONS_ID FROM tbl_questions WHERE $where ";
		$stmt = $conn->prepare($strSQL);
		$stmt->execute();
		$result = $stmt->get_result();
		$total = $result->num_rows;
	} else {
		if ($_SESSION['find_key']) {
			$where = "QUESTIONS_TEXT LIKE '%$_SESSION[find_key]%' order by QUESTIONS_ID ";
			$strSQL = "SELECT QUESTIONS_ID FROM tbl_questions WHERE $where";
			$stmt = $conn->prepare($strSQL);
			$stmt->execute();
			$result = $stmt->get_result();
			$total = $result->num_rows;
		}
	}
	if ($total == 0) {
		echo "<div align=center class=f-thai><font color=red size=3><br><br><b>Can't Found Your ID or Keyword</b></font></div>";
	}
	if ($total >= 1) {
		echo "<div align=center class=f-thai><font size=3 color=blue>Total Search Result : [$total]</font><br></div>";
		//----------------------------------------------------------------------------------------------------//
		$font_page = "<font size=2>";
		$all_page = $total / $amount;
		$page_arr = explode(".", $all_page);
		if ($page_arr[1] > 0) {
			$all_page = $page_arr[0] + 1;
		} else {
			$all_page = $page_arr[0];
		}
		echo "<table align=center width=100% border=0 cellpadding=0 cellspacing=0 class=f-thai>
				<tr valign=top>
					<td width=7% align=right>$font_page Page :
					</td>
					<td align=left width=93%>";
		for ($i = 1; $i <= $all_page; $i++) {
			if ($_GET['page'] == $i) {
				$page_color = "red";
			} else {
				$page_color = "blue";
			}
			echo "&nbsp;&nbsp;<a href=?section=$_GET[section]&&status=3&&type=$_GET[type]&&page=$i><font size=2 color=$page_color>$i</a>&nbsp;&nbsp;";
			if ($i % 20 == 0) {
				echo "<br>";
			}
		}
		echo "		</td>
				</tr>
			</table>";
		//-----------------------------------------------------------------------//
		$page = $_GET['page'];
		if (!$_GET['page']) {
			$page = 1;
		}
		$start = ($page - 1) * $amount;
		$SQL = "SELECT * FROM tbl_questions WHERE $where limit $start,$amount";
		$query = $conn->prepare($SQL);
		$query->execute();
		$result_ques = $query->get_result();
		$num = $result_ques->num_rows;
		if ($num >= 1) {
			for ($i = 1; $i <= $num; $i++) {
				$data = $result_ques->fetch_array();
				$text = $data['QUESTIONS_TEXT'];
				$text = stripslashes($text);
				$text = str_replace("&#039;", "'", $text);
				$text = str_replace("&lt;", "<", $text);
				$text = str_replace("&gt;", ">", $text);
				$id = $data['QUESTIONS_ID'];
				$is_active = $data['IS_ACTIVE'];
				//---------------------------------------------------//
				$totem = "<font color=green> None Relate File or Passage </font>";
				$result_qmap = get_questions_mapping(trim($id));
				$is_totem = $result_qmap->num_rows;
				if ($is_totem == 1) {
					$totem_data = $result_qmap->fetch_array();
					$totem_type_id = $totem_data['GQUESTION_ID'];
					//-----------------------------------------//
					$result_relate = get_questions_relate(trim($totem_type_id));	
					$a_have = $result_relate->num_rows;
					// echo $a_have."<br />";
					if ($a_have == 1) {
						$a_data = $result_relate->fetch_array();
						$totem_id = $a_data['GQUESTION_ID'];
						$totem_type_id = $a_data['GQUESTION_TYPE_ID'];
						$totem_msg = $a_data['GQUESTION_TEXT'];
						// echo $totem_type_id."<br />";
						if ($totem_type_id == 1) {
							$totem_type_msg = "<font color=blue>Passage : ($totem_data[GQUESTION_ID])</font><br><br>";
							$totem_msg = get_relate_passage($totem_msg);
						}
						if ($totem_type_id == 2) {
							$totem_type_msg = "<font color=orange>Picture : ($totem_data[GQUESTION_ID])</font><br><br>";
							$totem_msg = get_relate_picture($totem_msg);
						}
						if ($totem_type_id == 3) {
							$totem_type_msg = "<font color=red>Sound : ($totem_data[GQUESTION_ID])</font><br><br>";
							$totem_msg = get_relate_sound($totem_msg);
						}

					}
					$totem = "" . $totem_type_msg . $totem_msg;
				}
				//******************************************************//
				if ($is_active == 1) {
					$msg_link = "<a title='Show' href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit=active&&active=0&&question=$id>
								<font size=2 color=red> Set Hidden </font></a>
										";
				}
				if ($is_active == 0) {
					$msg_link = "<a title='Hidden' href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit=active&&active=1&&question=$id>
								<font size=2 color=green> Set Show </font></a>
										";
				}
				echo " <br>
						<table align=center width=100% border=1 class='f-thai search-list' style='margin: 0 auto';>
							<tr align=middle>
								<td colspan=2 align=left>";
				//-----------------//	
				$data = get_question($id);
				//---------------- Get Path section --------------------//
				$result_sec = get_section(trim($data['TEST_ID']));
				$path_num = $result_sec->num_rows;
				if ($path_num == 1) {
					$path_data = $result_sec->fetch_array();
					$path_a = $path_data['TEST_NAME'];
				}
				//---------------- Get Path level --------------------//
				$result_level = get_level(trim($data['LEVEL_ID']));	
				$path_num = $result_level->num_rows;
				if ($path_num == 1) {
					$path_data = $result_level->fetch_array();
					$path_b = $path_data['LEVEL_NAME'];
				}
				//---------------- Get Path skill --------------------//
				$result_skill = get_skill(trim($data['SKILL_ID']));
				$path_num = $result_skill->num_rows;
				if ($path_num == 1) {
					$path_data = $result_skill->fetch_array();
					$path_c = $path_data['SKILL_NAME'];
				}
				//---------------- Get Path sub skill --------------------//
				$result_sskill = get_sub_skill(trim($data['SSKILL_ID']));
				$path_num = $result_sskill->num_rows;
				if ($path_num == 1) {
					$path_data = $result_sskill->fetch_array();
					$path_d = $path_data['SSKILL_NAME'];
				}
				//---------------- Get Path reason --------------------//
				$result_detail = get_detail(trim($data['DETAIL_ID']));
				$path_num = $result_detail->num_rows;
				if ($path_num == 1) {
					$path_data = $result_detail->fetch_array();
					$path_e = $path_data['DETAIL_NAME'];
				}
				echo "	
										<font size=2 color=brown>&nbsp;
											&nbsp; $path_a &nbsp;&nbsp;&raquo;&nbsp;&nbsp; $path_b &nbsp;&nbsp;&raquo;&nbsp;&nbsp; $path_c &nbsp;&nbsp;&raquo;&nbsp;&nbsp;
												$path_d &nbsp;&nbsp;&raquo;&nbsp;&nbsp; <br>&nbsp; &nbsp; $path_e  
										</font>";
				//-----------------//
				echo "
								</td>
							</tr>
							<tr valign=top>
								<td align=center rowspan=3 width=10%>
									$id
										<br><br><br>
									$msg_link	
										<br><br><b>[$i]</b>	
									<br><br>
									<input class='btn-delete' type=button value='Delete' 
											onclick=\"javascript:
												if(confirm('คุณต้องการลบข้อสอบข้อนี้ใช่หรือไม่ ?'))
												{
													window.location='?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&page=$_GET[page]&&del=quiz&&quiz_id=$id';
												}
											\">
								</td>
								<td align=left width=90%>
									$totem
								</td>
							</tr>
							<tr>	
								<td align=left width=100% bgcolor=dddddd><font size=2>$text</font>							
									<br><br><a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit=question&&question=$id target=_blank>
									<font color=red> >>  Edit Question << </font></a><br>&nbsp;
								</td>
							</tr>
							<tr>
								<td align=left width=90%><br>";

				$result_ans = get_answers(trim($id));
				$sub_num = $result_ans->num_rows;
				if ($sub_num) {
					for ($k = 1; $k <= $sub_num; $k++) {
						$sub_data = $result_ans->fetch_array();
						$ans_text = stripslashes($sub_data['ANSWERS_TEXT']);
						if ($sub_data['ANSWERS_CORRECT'] == "1") {
							$correct = "<font color=blue> True </font>";
						} else {
							$correct = "<font color=red> False </font>";
						}
						echo "&nbsp;&nbsp; $sub_data[ANSWERS_ID] : $correct : " . $ans_text . " <br>";
					}
				}
				echo "
								</td>
							</tr>
							<tr>
								<td colspan=2>
									<font size=2><b>&nbsp;Description : <br></b></font>";

				$result_des = get_description(trim($id));
				$is_des = $result_des->num_rows;
				if ($is_des == "1") {
					$des_data = $result_des->fetch_array();
					echo "<font  size=2 color=blue>$des_data[TEXT]</font>";
				} else {
					echo "<div align=center><font size=2 color=red><b> - None Description - </b></font></div><br>";
				}
				echo "
								</td>
							</tr>
							<tr>
								<td colspan=2>";
				set_relate_form("by relate", $id, $totem_id);
				echo "
								</td>
							</tr>
						</table>";
			}
		}
		if($total > 20){
			$next = $_GET['page'] + 1;
			if ($next > $all_page) {
				$next = $all_page;
			}
			$back = $next - 2;
			if ($next <= 1) {
				$back = 1;
			}
			if (!$_GET['page'] || $_GET['page'] == 0 || $_GET['page'] == 1) {
				$next = 2;
				$back = 1;
			}
			echo "	<br>
					<div align=center class='f-thai paginate'>
						<a href=?section=admin&&status=$_GET[status]&&type=$_GET[type]&&page=$back><font size=2 color=red>&raquo; Back &laquo;</font></a>
								&nbsp;&nbsp;&nbsp;&nbsp;<a href=#><font size=2 color=blue>Go to Top</font></a>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href=?section=admin&&status=$_GET[status]&&type=$_GET[type]&&page=$next><font size=2 color=red>&raquo; Next &laquo;</font></a>
					</div>";
		}else{
			echo "	<br>
					<div align=center class='f-thai paginate'>
						<a href=#><font size=2 color=blue>Go to Top</font></a>
					</div>";
		}
	}
	echo "</div>";
}

function search_in_item()
{
	include('../config/connection.php');
	$total = 0;
	$amount = 20;
	if ($_SESSION['find_id']) {
		$where = "GQUESTION_ID='$_SESSION[find_id]' order by GQUESTION_ID ";
		$strSQL = "SELECT GQUESTION_ID FROM tbl_gquestion WHERE $where ";
		$stmt = $conn->prepare($strSQL);
		$stmt->execute();
		$result = $stmt->get_result();
		$total = $result->num_rows;
	} else {
		if ($_SESSION['find_key']) {
			$where = "GQUESTION_TEXT LIKE '%$_SESSION[find_key]%' && GQUESTION_TYPE_ID='1' order by GQUESTION_ID ";
			$strSQL = "SELECT GQUESTION_ID FROM tbl_gquestion WHERE $where";
			$stmt = $conn->prepare($strSQL);
			$stmt->execute();
			$result = $stmt->get_result();
			$total = $result->num_rows;
		}
	}
	if ($total == 0) {
		echo "<div align=center class=f-thai><font color=red size=3><br><br><b>Can't Found Your ID or Keyword</b></font></div>";
	}
	if ($total >= 1) {
		echo "<div align=center class=f-thai><font size=3 color=blue>Total Search Result : [$total]</font><br></div>";
		//-------------------------------------------------------------------------------------//
		$font_page = "<font size=2>";
		$all_page = $total / $amount;
		$page_arr = explode(".", $all_page);
		if ($page_arr[1] > 0) {
			$all_page = $page_arr[0] + 1;
		} else {
			$all_page = $page_arr[0];
		}
		echo "<table align=center width=100% border=0 cellpadding=0 cellspacing=0 class=f-thai>
				<tr valign=top>
					<td width=7% align=right>$font_page Page :
					</td>
					<td align=left width=93%>";
		for ($i = 1; $i <= $all_page; $i++) {
			if ($_GET['page'] == $i) {
				$page_color = "red";
			} else {
				$page_color = "blue";
			}
			echo "&nbsp;&nbsp;<a href=?section=$_GET[section]&&status=3&&type=$_GET[type]&&page=$i><font size=2 color=$page_color>$i</a>&nbsp;&nbsp;";
			if ($i % 20 == 0) {
				echo "<br>";
			}
		}
		echo "		</td>
						</tr>
					  </table>";
		echo "<br>";
		//-----------------------------------------------------------------------//
		$page = $_GET['page'];
		if (!$_GET['page']) {
			$page = 1;
		}
		$start = ($page - 1) * $amount;
		$SQL = "SELECT * FROM tbl_gquestion WHERE $where limit $start,$amount";
		$query = $conn->prepare($SQL);
		$query->execute();
		$result_relate = $query->get_result();
		$num = $result_relate->num_rows;
		for ($i = 1; $i <= $num; $i++) {
			$data = $result_relate->fetch_array();
			$font = "<font size=2>";
			$edit_msg = "";
			if ($data['GQUESTION_TYPE_ID'] == 1) {
				$type = "Passage";
				$msg = $data['GQUESTION_TEXT'];
				$edit_msg = "	<a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit_relate=form&&relate_id=$data[GQUESTION_ID] target=_blank>
								<font size=2 color=blue>[ Edit & Details]</font></a> 
							";
			}
			if ($data['GQUESTION_TYPE_ID'] == 2) {
				$type = "Picture";
				$msg = "" . str_replace("/home/engtest/domains/engtest.net/public_html/", "/", $data['GQUESTION_TEXT']) . "<br>
									<img src=" . str_replace("/home/engtest/domains/engtest.net/public_html/", "/", $data['GQUESTION_TEXT']) . " border=0 style='width: 75%; height: auto;'>";
				$edit_msg = "	<a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit_relate=form&&relate_id=$data[GQUESTION_ID] target=_blank>
								<font size=2 color=blue>[ Edit & Details]</a> 
							";
			}
			if ($data['GQUESTION_TYPE_ID'] == 3) {
				$edit_msg = "	<a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit_relate=form&&relate_id=$data[GQUESTION_ID] target=_blank>
								<font size=2 color=blue>[ Edit & Details]</a> 
								";
				$msg = get_relate_sound($data['GQUESTION_TEXT']);
			}
			if ($data['IS_ACTIVE'] == 0) {
				$status_msg = "<font size=2 color=red>[Hidden]</font>";
				$active_msg = "<a title='Hidden' href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&page=$_GET[page]&&sub_type=$_GET[sub_type]&&edit_item=active&&active=1&&item_id=$data[GQUESTION_ID]>
								<font size=2 color=green>[Set Show Item]</font></a>";
			}
			if ($data['IS_ACTIVE'] == 1) {
				$status_msg = "<font size=2 color=green>[Show]</font>";
				$active_msg = "<a title='Show' href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&page=$_GET[page]&&sub_type=$_GET[sub_type]&&edit_item=active&&active=0&&item_id=$data[GQUESTION_ID]>
										<font size=2 color=red>[Set Hidden Item]</font></a>";
			}
			echo "
				<table align=center width=100% cellpadding=0 cellspacing=0 border=1 style='margin:0 auto;' class='f-thai search-list'>
					<tr height=40>
						<td width=20% align=center >$font Data ID :$data[GQUESTION_ID]</td>
						<td width=20% align=center >$font Type : $type</td>
						<td width=60% align=left >&nbsp; $font Reference Name $data[GQUESTION_NAME_REF] $status_msg</td>
					</tr>
					<tr>
						<td width=100% align=left colspan=3> <br><font size=2>$msg</font><br>&nbsp;</td>
					</tr>
					<tr height=50>
						<td width=100% align=center colspan=3>$active_msg Relate Question List $edit_msg</td>
					</tr>
					<tr>
						<td width=100% align=left colspan=3><font size=2>";

			$SQLqmap = "SELECT GQUESTION_ID FROM tbl_questions_mapping WHERE GQUESTION_ID = ?";
			$query_qmap = $conn->prepare($SQLqmap);
			$query_qmap->bind_param("s", $data['GQUESTION_ID']);
			$query_qmap->execute();
			$result_qmap = $query_qmap->get_result();
			$a_num = $result_qmap->num_rows;
			if ($a_num >= 1) {
				for ($k = 1; $k <= $a_num; $k++) {
					$a_data = $result_qmap->fetch_array();
					echo $a_data['QUESTIONS_ID'] . "&nbsp;&nbsp;";
					if ($k % 15 == 0) {
						echo "<br>";
					}
				}
			}
			if ($a_num == 0) {
				echo "<div align=center class=f-thai><font size=3 color=red ><b>None Relate Question !!!</b></font><br></div>";
			}

			echo "
						</td>
					</tr>
				</table><br>";
		}
		if($total > 20){
			$next = $_GET['page'] + 1;
			if ($next > $all_page) {
				$next = $all_page;
			}
			$back = $next - 2;
			if ($next <= 1) {
				$back = 1;
			}
			if (!$_GET['page'] || $_GET['page'] == 0 || $_GET['page'] == 1) {
				$next = 2;
				$back = 1;
			}
			echo "	
					<div align=center class='f-thai paginate'>
						<a href=?section=admin&&status=$_GET[status]&&type=$_GET[type]&&page=$back><font size=2 color=red>&raquo; Back &laquo;</font></a>
								&nbsp;&nbsp;&nbsp;&nbsp;<a href=#><font size=2 color=blue>Go to Top</font></a>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href=?section=admin&&status=$_GET[status]&&type=$_GET[type]&&page=$next><font size=2 color=red>&raquo; Next &laquo;</font></a>
					</div>";
		}else{
			echo "	
					<div align=center class='f-thai paginate'>
						<a href=#><font size=2 color=blue>Go to Top</font></a>
					</div>";
		}
	}
	echo "</div>";
}

function search_in_answer()
{
	include('../config/connection.php');
	$total = 0;
	$amount = 20;
	if ($_SESSION['find_id']) {
		$where = "ANSWERS_ID='$_SESSION[find_id]' group by QUESTIONS_ID order by QUESTIONS_ID ";
		$strSQL = "SELECT QUESTIONS_ID FROM tbl_answers WHERE $where ";
		$stmt = $conn->prepare($strSQL);
		$stmt->execute();
		$result = $stmt->get_result();
		$total = $result->num_rows;
		if ($total == 1) {
			$data = $result->fetch_array();
			$quiz_id = $data['QUESTIONS_ID'];
			$where = "QUESTIONS_ID='$quiz_id' order by QUESTIONS_ID ";
		}
	} else {
		if ($_SESSION['find_key']) {
			$where = "ANSWERS_TEXT LIKE '%$_SESSION[find_key]%' group by QUESTIONS_ID order by QUESTIONS_ID ";
			$strSQL = "SELECT QUESTIONS_ID FROM tbl_answers WHERE $where ";
			$stmt = $conn->prepare($strSQL);
			$stmt->execute();
			$result = $stmt->get_result();
			$total = $result->num_rows;
			if ($total >= 1) {
				for ($i = 1; $i <= $total; $i++) {
					$data = $result->fetch_array();
					$quiz_id = $data['QUESTIONS_ID'];
					if ($i != $total) {
						$x_msg = $x_msg . " QUESTIONS_ID='$quiz_id' || ";
					} else {
						$x_msg = $x_msg . " QUESTIONS_ID='$quiz_id' ";
					}
				}
				if ($x_msg) {
					$where = "$x_msg order by QUESTIONS_ID ";
				}
			}
		}
	}
	if ($total == 0) {
		echo "<div align=center class=f-thai><font color=red size=3><br><br><b>Can't Found Your ID or Keyword</b></font></div>";
	}
	if ($total >= 1) {
		echo "<div align=center class=f-thai><font size=3 color=blue>Total Search Result : [$total]</font><br></div>";
		//----------------------------------------------------------------------------------------------------//
		$font_page = "<font size=2>";
		$all_page = $total / $amount;
		$page_arr = explode(".", $all_page);
		if ($page_arr[1] > 0) {
			$all_page = $page_arr[0] + 1;
		} else {
			$all_page = $page_arr[0];
		}
		echo "<table align=center width=100% border=0 cellpadding=0 cellspacing=0 class=f-thai>
				<tr valign=top>
					<td width=7% align=right>$font_page Page :
					</td>
					<td align=left width=93%>	
			";
		for ($i = 1; $i <= $all_page; $i++) {
			if ($_GET['page'] == $i) {
				$page_color = "red";
			} else {
				$page_color = "blue";
			}
			echo "&nbsp;&nbsp;<a href=?section=$_GET[section]&&status=3&&type=$_GET[type]&&page=$i><font size=2 color=$page_color>$i</a>&nbsp;&nbsp;";
			if ($i % 20 == 0) {
				echo "<br>";
			}
		}
		echo "		</td>
				</tr>
			  </table>";
		//-----------------------------------------------------------------------//
		$page = $_GET['page'];
		if (!$_GET['page']) {
			$page = 1;
		}
		$start = ($page - 1) * $amount;
		$SQL = "SELECT * FROM tbl_questions WHERE $where limit $start,$amount";
		$query = $conn->prepare($SQL);
		$query->execute();
		$result_ques = $query->get_result();
		$num = $result_ques->num_rows;
		// echo "$num <br>";
		if ($num >= 1) {
			for ($i = 1; $i <= $num; $i++) {
				$data = $result_ques->fetch_array();
				$text = $data['QUESTIONS_TEXT'];
				$text = stripslashes($text);
				$text = str_replace("&#039;", "'", $text);
				$text = str_replace("&lt;", "<", $text);
				$text = str_replace("&gt;", ">", $text);
				$id = $data['QUESTIONS_ID'];
				$is_active = $data['IS_ACTIVE'];
				//---------------------------------------------------//
				$totem = "<font color=green> None Relate File or Passage </font>";
				$result_qmap = get_questions_mapping(trim($id));
				$is_totem = $result_qmap->num_rows;
				if ($is_totem == 1) {
					$totem_data = $result_qmap->fetch_array();
					$totem_type_id = $totem_data['GQUESTION_ID'];
					$result_relate = get_questions_relate(trim($totem_type_id));
					$a_have = $result_relate->num_rows;
					if ($a_have == 1) {
						$a_data = $result_relate->fetch_array();
						$totem_id = $a_data['GQUESTION_ID'];
						$totem_type_id = $a_data['GQUESTION_TYPE_ID'];
						$totem_msg = $a_data['GQUESTION_TEXT'];
						if ($totem_type_id == 1) {
							$totem_type_msg = "<font color=blue>Passage : ($totem_data[GQUESTION_ID])</font><br><br>";
							$totem_msg = get_relate_passage($totem_msg);
						}
						if ($totem_type_id == 2) {
							$totem_type_msg = "<font color=orange>Picture : ($totem_data[GQUESTION_ID])</font><br><br>";
							$totem_msg = get_relate_picture($totem_msg);
						}
						if ($totem_type_id == 3) {
							$totem_type_msg = "<font color=red>Sound : ($totem_data[GQUESTION_ID])</font><br><br>";
							$totem_msg = get_relate_sound($totem_msg);
						}

					}
					$totem = "" . $totem_type_msg . $totem_msg;
				}
				//******************************************************//
				if ($is_active == 1) {
					$msg_link = "<a title='Show' href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit=active&&active=0&&question=$id>
								<font size=2 color=red> Set Hidden </font></a>
								";
				}
				if ($is_active == 0) {
					$msg_link = "<a title='Hidden' href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit=active&&active=1&&question=$id>
								<font size=2 color=green> Set Show </font></a>
								";
				}
				echo " <br>
						<table align=center width=100% border=1 class='f-thai search-list' style='margin: 0 auto;'>
							<tr align=middle>
								<td colspan=2 align=left>
					";
				//-----------------//	
				$data = get_question($id);
				//---------------- Get Path section --------------------//
				$result_sec = get_section(trim($data['TEST_ID']));
				$path_num = $result_sec->num_rows;
				if ($path_num == 1) {
					$path_data = $result_sec->fetch_array();
					$path_a = $path_data['TEST_NAME'];
				}
				//---------------- Get Path level --------------------//
				$result_level = get_level(trim($data['LEVEL_ID']));
				$path_num = $result_level->num_rows;

				if ($path_num == 1) {
					$path_data = $result_level->fetch_array();
					$path_b = $path_data['LEVEL_NAME'];
				}
				//---------------- Get Path skill --------------------//
				$result_skill = get_skill(trim($data['SKILL_ID']));	
				$path_num = $result_skill->num_rows;
				if ($path_num == 1) {
					$path_data = $result_skill->fetch_array();
					$path_c = $path_data['SKILL_NAME'];
				}
				//---------------- Get Path sub skill --------------------//
				$result_sskill = get_sub_skill(trim($data['SSKILL_ID']));
				$path_num = $result_sskill->num_rows;
				if ($path_num == 1) {
					$path_data = $result_sskill->fetch_array();
					$path_d = $path_data['SSKILL_NAME'];
				}
				//---------------- Get Path reason --------------------//
				$result_detail = get_detail(trim($data['DETAIL_ID']));
				$path_num = $result_detail->num_rows;

				if ($path_num == 1) {
					$path_data = $result_detail->fetch_array();
					$path_e = $path_data['DETAIL_NAME'];
				}
				echo "	
									<font size=2 color=brown>&nbsp;
										&nbsp; $path_a &nbsp;&nbsp;&raquo;&nbsp;&nbsp; $path_b &nbsp;&nbsp;&raquo;&nbsp;&nbsp; $path_c &nbsp;&nbsp;&raquo;&nbsp;&nbsp;
										$path_d &nbsp;&nbsp;&raquo;&nbsp;&nbsp; <br>&nbsp; &nbsp; $path_e  
									</font>";
				//-----------------//
				echo "
								</td>
							</tr>
							<tr valign=top>
								<td align=center rowspan=3 width=10%>
									$id
									<br><br><br>
									$msg_link	
									<br><br><b>[$i]</b>	
									<br><br>
									<input class='btn-delete' type=button value='Delete' 
											onclick=\"javascript:
												if(confirm('คุณต้องการลบข้อสอบข้อนี้ใช่หรือไม่ ?'))
												{
													window.location='?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&page=$_GET[page]&&del=quiz&&quiz_id=$id';
												}
											\">
											
								</td>
								<td align=left width=90%>
									$totem
								</td>
							</tr>
							<tr>	
								<td align=left width=100% bgcolor=dddddd><font size=2>$text</font>							
									<br><br><a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit=question&&question=$id target=_blank>
									<font color=red> >>  Edit Question << </font></a><br>&nbsp;
								</td>
							</tr>
							<tr>
								<td align=left width=90%><br>";
				
				$result_ans = get_answers(trim($id));
				$sub_num = $result_ans->num_rows;
				if ($sub_num) {
					for ($k = 1; $k <= $sub_num; $k++) {
						$sub_data = $result_ans->fetch_array();
						$ans_text = stripslashes($sub_data['ANSWERS_TEXT']);
						if ($sub_data['ANSWERS_CORRECT'] == 1) {
							$correct = "<font color=blue> True </font>";
						} else {
							$correct = "<font color=red> False </font>";
						}
						echo "&nbsp;&nbsp; $sub_data[ANSWERS_ID] : $correct : " . $ans_text . " <br>";
					}
				}
				echo "
								</td>
							</tr>
							<tr>
								<td colspan=2>
									<font size=2><b>&nbsp;Description : <br></b></font>";
				
				$result_des = get_description(trim($id));
				$is_des = $result_des->num_rows;

				if ($is_des == "1") {
					$des_data = $result_des->fetch_array();
					echo "<font size=2 color=blue>$des_data[TEXT]</font>";
				} else {
					echo "<div align=center><font size=2 color=red><b> - None Description - </b></font></div><br>";
				}
				echo "
								</td>
							</tr>
							<tr>
								<td colspan=2>";
				set_relate_form("by relate", $id, $totem_id);
				echo "
								</td>
							</tr>
						</table>";
			}
			if($total > 20){
				$next = $_GET['page'] + 1;
				if ($next > $all_page) {
					$next = $all_page;
				}
				$back = $next - 2;
				if ($next <= 1) {
					$back = 1;
				}
				if (!$_GET['page'] || $_GET['page'] == 0 || $_GET['page'] == 1) {
					$next = 2;
					$back = 1;
				}
				echo "	<br>
						<div align=center class='f-thai paginate'>
							<a href=?section=admin&&status=$_GET[status]&&type=$_GET[type]&&page=$back><font size=2 color=red>&raquo; Back &laquo;</font></a>
									&nbsp;&nbsp;&nbsp;&nbsp;<a href=#><font size=2 color=blue>Go to Top</font></a>&nbsp;&nbsp;&nbsp;&nbsp;
							<a href=?section=admin&&status=$_GET[status]&&type=$_GET[type]&&page=$next><font size=2 color=red>&raquo; Next &laquo;</font></a>
						</div>";
			}else{
				echo "	<br>
						<div align=center class='f-thai paginate'>
							<a href=#><font size=2 color=blue>Go to Top</font></a>
						</div>";
			}
		}
		//----------------------------------------------------------------------------------------------------//
	}
	echo "</div>";
}

function add_relate_form()
{
	include('../config/connection.php');
	$active = 0;
	if ($_GET['action'] === "add") {
		$today = date("Y-m-d");
		if ($_POST['type_id'] == 1 && $_POST['ref_name']) {
			$relate_text = $_POST['relate_detail'] ? $_POST['relate_detail'] : '';
			$detail = $relate_text;
			//$detail = addslashes($question_text);
			//$detail = str_replace("&quot;","",$detail);
			$detail = str_replace("&#039;", "'", $detail);
			$detail = str_replace("&lt;", "<", $detail);
			$detail = str_replace("&gt;", ">", $detail);
			echo "Passage: " . $detail;
			$strSQL = "INSERT INTO tbl_gquestion (GQUESTION_TYPE_ID,GQUESTION_NAME_REF,GQUESTION_TEXT,IS_ACTIVE,CREATDATE) VALUES(?,?,?,?,?)";
			$stmt = $conn->prepare($strSQL);
			$stmt->bind_param("sssss", $_POST['type_id'], $_POST['ref_name'], $detail, $active, $today);
			$stmt->execute();
			$stmt->close();
			header("Location:?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]");
		}
		if ($_POST['type_id'] == 2 && $_POST['pic_ref_name']) {
			$des_dir = $_SERVER['DOCUMENT_ROOT'] . "/files/picture/";
			$temp = $_FILES['pic_file']['tmp_name'];
			if ($_FILES['pic_file']['type'] == "image/jpeg" || $_FILES['pic_file']['type'] == "image/pjpeg") {
				$name = "" . date("Y-m-d-h-i-s") . "-" . $_FILES['pic_file']['name'];
				$des = $des_dir . $name;
				echo "$temp : $des";
				copy($temp, $des);
				unlink($temp);
				//------------------------------------------------------------//
				$strSQL = "INSERT INTO tbl_gquestion (GQUESTION_TYPE_ID,GQUESTION_NAME_REF,GQUESTION_TEXT,CREATDATE,IS_ACTIVE) VALUES(?,?,?,?,?)";
				$stmt = $conn->prepare($strSQL);
				$stmt->bind_param("sssss", $_POST['type_id'], $_POST['pic_ref_name'], $name, $today, $active);
				$stmt->execute();
				$stmt->close();
				header("Location:?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]");
			}
		}
		if ($_POST['type_id'] == "3" && $_POST['sound_ref_name']) {
			$prefix = "" . date("Y-m-d-H-i-s") . "-";
			$des_dir_mp3 = $_SERVER['DOCUMENT_ROOT'] . "/files/sound/";
			$temp_mp3 = $_FILES['sound_file']['tmp_name'];
			if (
				($_FILES['sound_file']['type'] == "audio/mp3" || $_FILES['sound_file']['type'] == "audio/mpeg" || $_FILES['sound_file']['type'] == "application/octet-stream")
			) {
				$name = $prefix . $_FILES['sound_file']['name'];
				$des = $des_dir_mp3 . $name;
				copy($temp_mp3, $des);
				unlink($temp_mp3);
				//------------------------------------------------------------//
				$strSQL = "INSERT INTO tbl_gquestion (GQUESTION_TYPE_ID,GQUESTION_NAME_REF,GQUESTION_TEXT,CREATDATE,IS_ACTIVE) VALUES(?,?,?,?,?)";
				$stmt = $conn->prepare($strSQL);
				$stmt->bind_param("sssss", $_POST['type_id'], $_POST['sound_ref_name'], $name, $today, $active);
				$stmt->execute();
				$stmt->close();
			}
			header("Location:?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&page=$_GET[page]");
		}
	}
	//------------------------------------------------------------------------------------//
	$font = "<font size=2>";
	echo "
		<form enctype='multipart/form-data' method='post' action='?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&action=add' class='f-thai'>
			<table align=center cellpadding=0 cellspacing=0 border=1 width=100%>
				<tr>
					<td align=center>$font 
					"; ?>
<input type=radio name=type_id value=1 onclick="
						javaScript:if(this.checked)
						{
							document.all.tb_a.style.display='';
							document.all.tb_b.style.display='none';
							document.all.tb_c.style.display='none';
							document.all.tb_d.style.display='';
						}">
Passage &nbsp;&nbsp;&nbsp;
<input type=radio name=type_id value=2 onclick="
						javaScript:if(this.checked)
						{
							document.all.tb_a.style.display='none';
							document.all.tb_b.style.display='';
							document.all.tb_c.style.display='none';
							document.all.tb_d.style.display='';
						}">
Picture &nbsp;&nbsp;&nbsp;
<input type=radio name=type_id value=3 onclick="
						javaScript:if(this.checked)
						{
							document.all.tb_a.style.display='none';
							document.all.tb_b.style.display='none';
							document.all.tb_c.style.display='';
							document.all.tb_d.style.display='';
						}">
Sound &nbsp;&nbsp;&nbsp;
<?php
	echo "
					</td>
				</tr>
			</table><br>
			<table align=center width=100% cellpadding=0 cellspacing=0 border=1 class=f-thai><tr><td>
			<!---------------------------------------------------------------------------------------------->
				<table align=center cellpadding=0 cellspacing=0 border=0 width=100% id='tb_a' style='display:none' class=f-thai>
					<tr height=15><td colspan=2></td></tr>
					<tr >
						<td width=15% align=right>$font Reference Name</td>
						<td >$font &nbsp;:&nbsp;</td>
						<td width=85% align=left><input type=text name=ref_name size=50></td>
					</tr>
					<tr height=15><td colspan=2></td></tr>
					<tr valign=top>
						<td align=right>$font Detail</td>
						<td>$font &nbsp;:&nbsp;</td>
						<td align=left>";
	//----------------------------------------------//
	$value = stripslashes($relate_text);
	echo "<textarea id='topic_detail' name='relate_detail' class='form-control topic_detail' placeholder='' rows='20'>
	$value</textarea>
						</td>
					</tr>
				</table>
				<table align=center cellpadding=0 cellspacing=0 border=0 width=100% id='tb_b' style='display:none' class=f-thai>
					<tr height=15><td colspan=2></td></tr>
					<tr >
						<td width=15% align=right>$font Reference Name</td>
						<td >$font &nbsp;:&nbsp;</td>
						<td width=85% align=left><input type=text name=pic_ref_name size=50></td>
					</tr>
					<tr height=15><td colspan=2></td></tr>
					<tr>
						<td width=15% align=right>$font Path File (.jpg)</td>
						<td >$font &nbsp;:&nbsp;</td>
						<td width=85% align=left><input type=file name='pic_file' size=50></td>
					</tr>
					<tr height=15><td colspan=2></td></tr>
					<tr>
						<td width=15% align=right></td>
						<td >$font &nbsp;:&nbsp;</td>
						<td width=85% align=left><font size=2 color=red>
								Don't use ' , \" or thai character in file name .
						</font></td>
					</tr>
				</table>
				<table align=center cellpadding=0 cellspacing=0 border=0 width=100% id='tb_c' style='display:none' class=f-thai>
					<tr height=15><td colspan=2></td></tr>
					<tr >
						<td width=15% align=right>$font Reference Name</td>
						<td >$font &nbsp;:&nbsp;</td>
						<td width=85% align=left><input type=text name=sound_ref_name size=50></td>
					</tr>
					<tr height=15><td colspan=2></td></tr>
					<tr>
						<td width=15% align=right>$font Path File (.mp3)</td>
						<td >$font &nbsp;:&nbsp;</td>
						<td width=85% align=left><input type=file name='sound_file' size=50></td>
					</tr>
					<tr height=15><td colspan=2></td></tr>
					<tr>
						<td width=15% align=right>&nbsp;</td>
						<td >$font &nbsp;:&nbsp;</td>
						<td width=85% align=left><font size=2 color=red>
								Don't use ' , \" or thai character in file name .
							</font></td>
					</tr>
				</table>
				<!---------------------------------------------------------------------------------------------->
				<br>
				<table align=center cellpadding=0 cellspacing=0 border=0 width=100% id='tb_d' style='display:none'>
					<tr>
						<td align=center><input type='submit' value='Add Relate Item' class='btn-add'></td>
					</tr>
					<tr>
						<td align=center><br><font size=2 color=red>- Warning : After Add Relate Item , The Item is Always Hidden. -</font><br>&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		</table>
	</form>";
	script_ckeditor_detail();
}

function last_item_list()
{
	include('../config/connection.php');
	$SQL = "SELECT * FROM tbl_gquestion order by GQUESTION_ID DESC limit 5";
	$query = $conn->prepare($SQL);
	$query->execute();
	$result = $query->get_result();
	$num = $result->num_rows;
	if ($num >= 1) {
		for ($i = 1; $i <= $num; $i++) {
			$data = $result->fetch_array();
			$font = "<font size=2>";
			$edit_msg = "";
			$is_active = $data['IS_ACTIVE'];
			$id = $data['GQUESTION_ID'];
			if ($data['GQUESTION_TYPE_ID'] == 1) {
				$type = "Passage";
				$msg = $data['GQUESTION_TEXT'];
				$edit_msg = "	<a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit_relate=form&&relate_id=$data[GQUESTION_ID] target=_blank>
								<font size=2 color=blue>Edit / Detail</font></a> 
							";
			}
			if ($data['GQUESTION_TYPE_ID'] == 2) {
				$type = "Picture";
				$msg = "" . str_replace("/home/engtest/domains/engtest.net/public_html/", "/", $data['GQUESTION_TEXT']) . "<br>
								<img src=../files/picture/" . ($data['GQUESTION_TEXT']) . " border=0 style='width: 75%;height: auto;'>";
			}
			if ($data['GQUESTION_TYPE_ID'] == 3) {
				$type = "Sound";
				$width = 300;
				$height = 60;
				$folder = "sound";
				$msg = str_replace("/home/engtest/domains/engtest.net/public_html/files/sound/", "", $data['GQUESTION_TEXT']);
				$msg = str_replace(".flv", ".mp3", $msg);
				$msg = "
						$data[GQUESTION_TEXT]<br>
						<div align=center >
							<audio  controls='controls' height=\"$height\" width=\"$width\" preload='auto'>
								<source src=\"../files/$folder/$msg\" >
							</audio>
						</div>";
			}
			if ($is_active == 1) {
				$msg_link = "<a tile='Show' href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit_item=active&&active=0&&item_id=$id><font size=2 color=red> Set Hidden </font></a>";
			}
			if ($is_active == 0) {
				$msg_link = "<a title='Hidden' href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit_item=active&&active=1&&item_id=$id><font size=2 color=green> Set Show </font></a>";
			}
			echo "
				<table align=center cellpadding=0 cellspacing=0 border=1 width=100% class=f-thai>
					<tr valign=top>
						<td align=center width=10%>$font $data[GQUESTION_ID] <br><br> $type <br><br> $msg_link <br><br> $edit_msg <br>&nbsp;</td>
						<td width=90%>
							<font size=2>$msg</font>
						</td>
					</tr>
					<tr>
						<td colspan=2> $font ";
			
			$result_qmap = get_questions_mapping_where_gquestion(trim($data['GQUESTION_ID']));
			$a_num = $result_qmap->num_rows;
			if ($a_num >= "1") {
				for ($k = 1; $k <= $a_num; $k++) {
					$a_data = $result_qmap->fetch_array();
					echo $a_data['QUESTIONS_ID'] . "&nbsp;&nbsp;";
					if ($k % 15 == 0) {
						echo "<br>";
					}
				}
			}
			if ($a_num == 0) {
				echo "<div align=center class=f-thai><font size=3 color=red><b>None Relate Question !!!</b></font><br></div>";
			}
			echo "
						</td>
					</tr>
				</table><br>";
		}
		echo "	<div align=center class='f-thai paginate'>
					<a href=#><font size=2 color=blue>Go to Top</font></a>
				</div>";
	}
}

function add_quiz_form()
{
	include('../config/connection.php');
	$font = "<font size=2>";
	if ($_POST['set_section'] && $_POST['set_level'] && $_POST['set_skill']) {
		unset($_SESSION["set_sub_skill"]);
	}
	if ($_POST['set_sub_skill']) {
		unset($_SESSION["set_reason"]);
	}
	if ($_POST['set_section'] >= "1") {
		$_SESSION['set_section'] = $_POST['set_section'];
	}
	if ($_POST['set_level'] >= "1") {
		$_SESSION['set_level'] = $_POST['set_level'];
	}
	if ($_POST['set_skill'] >= "1") {
		$_SESSION['set_skill'] = $_POST['set_skill'];
	}
	if ($_POST['set_sub_skill'] >= "1") {
		$_SESSION['set_sub_skill'] = $_POST['set_sub_skill'];
	}
	if ($_POST['set_reason'] >= "1") {
		$_SESSION['set_reason'] = $_POST['set_reason'];
	}
	//------------------------------------------------------------------------//
	if ($_POST['active'] === "change") {
		$SQL = "UPDATE tbl_questions SET TEST_ID = ?, LEVEL_ID=?, SKILL_ID=?, SSKILL_ID=?, DETAIL_ID=?  WHERE QUESTIONS_ID = ?";
		$query = $conn->prepare($SQL);
		$query->bind_param("ssssss", $_SESSION['set_section'], $_SESSION['set_level'], $_SESSION['set_skill'], $_SESSION['set_sub_skill'], $_SESSION['set_reason'], $_GET['question']);
		$query->execute();
		$query->close();
	}
	//------------------------------------------------------------------------//
	//echo "Section ID : $_SESSION[set_section]<br>Level ID : $_SESSION[set_level]<br>Skill ID : $_SESSION[set_skill]<br>
	//	Sub Skill ID : $_SESSION[set_sub_skill]<br>Reason ID : $_SESSION[set_reason]<br>";
	if ($_SESSION['set_section'] && $_SESSION['set_level'] && $_SESSION['set_skill'] && $_SESSION['set_sub_skill'] && $_SESSION['set_reason']) {
		$ans_a = stripslashes(htmlspecialchars($_POST['ans_a'], ENT_QUOTES));
		$ans_b = stripslashes(htmlspecialchars($_POST['ans_b'], ENT_QUOTES));
		$ans_c = stripslashes(htmlspecialchars($_POST['ans_c'], ENT_QUOTES));
		$ans_d = stripslashes(htmlspecialchars($_POST['ans_d'], ENT_QUOTES));
		//-----------------------------------------------------------//
		$ans_a = str_replace("‘", "&#039;", $ans_a);
		$ans_a = str_replace("’", "&#039;", $ans_a);
		$ans_a = str_replace("“", "&quot;", $ans_a);
		$ans_a = str_replace("”", "&quot;", $ans_a);
		$ans_a = str_replace("\"", "&quot;", $ans_a);
		//-----------------------------------------------------------//
		$ans_b = str_replace("‘", "&#039;", $ans_b);
		$ans_b = str_replace("’", "&#039;", $ans_b);
		$ans_b = str_replace("“", "&quot;", $ans_b);
		$ans_b = str_replace("”", "&quot;", $ans_b);
		$ans_b = str_replace("\"", "&quot;", $ans_b);
		//-----------------------------------------------------------//
		$ans_c = str_replace("‘", "&#039;", $ans_c);
		$ans_c = str_replace("’", "&#039;", $ans_c);
		$ans_c = str_replace("“", "&quot;", $ans_c);
		$ans_c = str_replace("”", "&quot;", $ans_c);
		$ans_c = str_replace("\"", "&quot;", $ans_c);
		//-----------------------------------------------------------//
		$ans_d = str_replace("‘", "&#039;", $ans_d);
		$ans_d = str_replace("’", "&#039;", $ans_d);
		$ans_d = str_replace("“", "&quot;", $ans_d);
		$ans_d = str_replace("”", "&quot;", $ans_d);
		$ans_d = str_replace("\"", "&quot;", $ans_d);
		//-----------------------------------------------------------//
		if (trim($_POST['correct']) && trim($_POST['quiz_text']) && trim($_POST['ans_a']) && trim($_POST['ans_b']) && trim($_POST['ans_c']) && trim($_POST['ans_d'])) {
			$today = date("Y-m-d");
			$detail = $_POST['quiz_text'];
			//$detail = addslashes($question_text);
			//$detail = str_replace("&quot;","",$detail);
			$detail = str_replace("&#039;", "'", $detail);
			$detail = str_replace("&lt;", "<", $detail);
			$detail = str_replace("&gt;", ">", $detail);
			//-------------------------------------------------------------------------------------//
			$strSQL = "SELECT * FROM tbl_questions order by QUESTIONS_ID DESC limit 1";
			$stmt = $conn->prepare($strSQL);
			$stmt->execute();
			$result_ques = $stmt->get_result();
			$num = $result_ques->num_rows;
			if ($num == 1) {
				$data = $result_ques->fetch_array();
				$last_id = $data['QUESTIONS_ID'] + 1;
			}
			if ($num == 0) {
				$last_id = "1";
			}
			$active = 0;
			$SQLques = "INSERT INTO tbl_questions (QUESTIONS_ID,QUESTIONS_TEXT,LEVEL_ID,TEST_ID,SKILL_ID,SSKILL_ID,DETAIL_ID,IS_ACTIVE,CREATDATE) VALUES(?,?,?,?,?,?,?,?,?)";
			$query_ques = $conn->prepare($SQLques);
			$query_ques->bind_param("sssssssss", $last_id, $detail, $_SESSION['set_level'], $_SESSION['set_section'], $_SESSION['set_skill'], $_SESSION['set_sub_skill'], $_SESSION['set_reason'], $active, $today);
			$query_ques->execute();
			$query_ques->close();
			if ($_POST['correct'] == "a") {
				$correct_a = "1";
			} else {
				$correct_a = "0";
			}
			if ($_POST['correct'] == "b") {
				$correct_b = "1";
			} else {
				$correct_b = "0";
			}
			if ($_POST['correct'] == "c") {
				$correct_c = "1";
			} else {
				$correct_c = "0";
			}
			if ($_POST['correct'] == "d") {
				$correct_d = "1";
			} else {
				$correct_d = "0";
			}
			
			insert_answers($last_id, $ans_a, $correct_a, $today);
			
			insert_answers($last_id, $ans_b, $correct_b, $today);
			
			insert_answers($last_id, $ans_c, $correct_c, $today);
			
			insert_answers($last_id, $ans_d, $correct_d, $today);
			header("Location:?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]");
		}
	}
	//------------------------------------------------------------------------//
	echo "
		<table align=center width=100% cellspading=0 cellspacing=0 border=1 class=f-thai>
			<form action=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type] method=post>
				<tr bgcolor=eeeeee height=30>
					<td width=28% align=center><font size=2> Section : ";
	//---- Section List ----//
	echo "<select name=set_section> <option value=0 > - Select Section - </option>";

	$section_name[1] = "School";
	$section_name[2] = "College";
	$section_name[3] = "Professional";
	$section_name[4] = "Everyone";
	for ($i = 1; $i <= 4; $i++) {
		if ($_SESSION['set_section'] == $i) {
			echo "<option value=$i selected>$section_name[$i]</option>";
			$section_msg = "$section_name[$i]";
		} else {
			echo "<option value=$i >$section_name[$i]</option>";
		}
	}
	echo "
					  </select>
				    </td>
				    <td width=28% align=center><font size=2> Level : ";
	//---- Section List ----//
	echo "<select name=set_level> <option value=0 > - Select Level - </option>";

	$level_name[1] = "Beginner";
	$level_name[2] = "Lower Intermediate";
	$level_name[3] = "Intermediate";
	$level_name[4] = "Upper Intermediate";
	$level_name[5] = "Advance";
	for ($i = 1; $i <= 5; $i++) {
		if ($_SESSION['set_level'] == $i) {
			echo "<option value=$i selected>$level_name[$i]</option>";
			$level_msg = "$level_name[$i]";
		} else {
			echo "<option value=$i >$level_name[$i]</option>";
		}
	}
	echo "
						</select>
					</td>
					<td width=34% align=center><font size=2> Skill : ";
	//---- Skill List ----//
	echo " <select name=set_skill> <option value=0 > - Select Skill - </option>";

	$skill_name[1] = "Reading Comprehension";
	$skill_name[2] = "Listening Comprehension";
	$skill_name[3] = "Semi-Speaking";
	$skill_name[4] = "Semi-Writing";
	$skill_name[5] = "Grammatical Structure";
	$skill_name[6] = "Integrated Skill : Cloze Test";
	$skill_name[7] = "Vocabulary Items";
	for ($i = 1; $i <= 7; $i++) {
		if ($_SESSION['set_skill'] == $i) {
			echo "<option value=$i selected>$skill_name[$i]</option>";
			$skill_msg = "$skill_name[$i]";
		} else {
			echo "<option value=$i >$skill_name[$i]</option>";
		}
	}
	echo "
							</select>
						</td>
						<td align=center width=10%>
							<input class='btn-set-path' type=submit value='&nbsp;&nbsp; Set First Path &nbsp;&nbsp;&nbsp;'>
						</td>
					</tr>
				</form>";
	//---- Sub Skill List ----//
	if ($_SESSION['set_section'] >= "1" && $_SESSION['set_level'] >= "1" && $_SESSION['set_skill'] >= "1") {
		echo "
					<tr  bgcolor=dddddd height=30>
						<form action=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type] method=post>
						<td align=left colspan=3><font size=2 >&nbsp; Sub Skill : 
							<select name=set_sub_skill> <option value=0 > - Select Sub Skill - </option>";

		$strSQL = "SELECT * FROM tbl_item_sskill WHERE TEST_ID=? && LEVEL_ID=? && SKILL_ID=? order by SSKILL_NAME ASC";
		$stmt = $conn->prepare($strSQL);
		$stmt->bind_param("sss", $_SESSION['set_section'], $_SESSION['set_level'], $_SESSION['set_skill']);
		$stmt->execute();
		$result_skill = $stmt->get_result();
		$num = $result_skill->num_rows;
		for ($i = 1; $i <= $num; $i++) {
			$data = $result_skill->fetch_array();
			$sub_skill_name = $data['SSKILL_NAME'];
			$sub_skill_id = $data['SSKILL_ID'];
			if ($_SESSION['set_sub_skill'] == $sub_skill_id) {
				echo "<option value=$sub_skill_id selected>$sub_skill_name</option>";
				$sub_skill_msg = "$sub_skill_name";
			} else {
				echo "<option value=$sub_skill_id >$sub_skill_name</option>";
			}
		}
		echo "
							</select>
						</td>
						<td align=center>				
							<input class='btn-set-path' type=submit value='Set Second Path' >
						</td>
					</form>
				</tr>";

		if ($_SESSION['set_sub_skill'] >= "1") {
			$SQLdetail = "SELECT * FROM tbl_item_detail WHERE TEST_ID=? && LEVEL_ID=? && SKILL_ID=? && SSKILL_ID = ? order by DETAIL_NAME ASC";
			$query_detail = $conn->prepare($SQLdetail);
			$query_detail->bind_param("ssss", $_SESSION['set_section'], $_SESSION['set_level'], $_SESSION['set_skill'], $_SESSION['set_sub_skill']);
			$query_detail->execute();
			$result_detail = $query_detail->get_result();
			$num = $result_detail->num_rows;
			echo "<tr bgcolor=cccccc height=30>
						<form action=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type] method=post>
						<td colspan=3><font size=2 >
								&nbsp; Reason : <select name=set_reason> <option value=0 > - Select Reason - </option>";
			for ($i = 1; $i <= $num; $i++) {
				$data = $result_detail->fetch_array();
				$detail_name = $data['DETAIL_NAME'];
				$detail_id = $data['DETAIL_ID'];
				if ($_SESSION['set_reason'] == $detail_id) {
					echo "<option value=$detail_id selected>$detail_name</option>";
					$reason_msg = "$detail_name";
				} else {
					echo "	<option value=$detail_id >$detail_name</option>";
				}
			}
			echo "
							</select>
						</td>
						<td align=center>				
							<input class='btn-set-path' type=submit value='&nbsp;&nbsp; Set Final Path &nbsp;&nbsp;' >
						</td>
						</form>
					</tr>";
		}
	}
	echo "
					<tr valign=middle>
						<form action=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type] method=post>
						<td colspan=4 >";

	if ($_SESSION['set_section'] && $_SESSION['set_level'] && $_SESSION['set_skill'] && $_SESSION['set_sub_skill'] && $_SESSION['set_reason']) {
		echo "	
						<font size=2 color=red>&nbsp;
							Create Path : $section_msg &nbsp;&nbsp;&raquo;&nbsp;&nbsp; $level_msg &nbsp;&nbsp;&raquo;&nbsp;&nbsp; $skill_msg &nbsp;&nbsp;&raquo;&nbsp;&nbsp;
							$sub_skill_msg &nbsp;&nbsp;&raquo;<br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							$reason_msg  
						</font>";
		//----------------------------------------------------------------------------------------//
		$value = stripslashes($_POST['quiz_text']);

		if ($_POST['correct'] == "a") {
			$check_a = "checked";
		} else {
			$check_a = "";
		}
		if ($_POST['correct'] == "b") {
			$check_b = "checked";
		} else {
			$check_b = "";
		}
		if ($_POST['correct'] == "c") {
			$check_c = "checked";
		} else {
			$check_c = "";
		}
		if ($_POST['correct'] == "d") {
			$check_d = "checked";
		} else {
			$check_d = "";
		}
		echo "
					<table align=center width=100% cellpadding=0 cellspacing=0 border=0 class=f-thai>
						<tr valign=middle>
					       <td colspan=3 width=90%> 
                                <textarea id='topic_detail' name='quiz_text' class='form-control topic_detail' placeholder='' rows='20' required>
                                    $value</textarea>
                           </td>
						</tr>
						<tr valign=middle>
							<td align=left width=80%>$font 
								<input type=radio name=correct value=a $check_a> : &nbsp; <input type=text name=ans_a size=80 value='" . $ans_a . "'>
							</td>
							<td align=center rowspan=4 width=20%>
								<input type=hidden name=action value=add>
								<input type=submit value='Add Question' class='btn-add'>
							</td>
						</tr>
						<tr valign=middle>
							<td align=left width=20%>$font 
								<input type=radio name=correct value=b $check_b> : &nbsp; <input type=text name=ans_b size=80 value='" . $ans_b . "'>
							</td>
						</tr>
						<tr valign=middle>
							<td align=left width=20%>$font 
								<input type=radio name=correct value=c $check_c> : &nbsp; <input type=text name=ans_c size=80 value='" . $ans_c . "'>
							</td>
						</tr>
						<tr valign=middle>
							<td align=left width=20%>$font 
								<input type=radio name=correct value=d $check_d> : &nbsp; <input type=text name=ans_d size=80 value='" . $ans_d . "'>
								</td>
						</tr>
					</table>";
					script_ckeditor_detail();
	}

	echo "
					</td>
				</form>
			</tr>
		</table>";
	
}

function last_quiz_list()
{
	include('../config/connection.php');
	$strSQL = "SELECT * FROM tbl_questions order by QUESTIONS_ID DESC limit 5";
	$stmt = $conn->prepare($strSQL);
	$stmt->execute();
	$result = $stmt->get_result();
	$num = $result->num_rows;
	if ($num >= 1) {
		for ($i = 1; $i <= $num; $i++) {
			$data = $result->fetch_array();
			$text = $data['QUESTIONS_TEXT'];
			$text = stripslashes($text);
			$text = str_replace("&#039;", "'", $text);
			$text = str_replace("&lt;", "<", $text);
			$text = str_replace("&gt;", ">", $text);
			$id = $data['QUESTIONS_ID'];
			$is_active = $data['IS_ACTIVE'];
			//---------------------------------------------------//
			$totem = "<font color=green> None Relate File or Passage </font>";
			$result_qmap = get_questions_mapping(trim($id));
			$is_totem = $result_qmap->num_rows;
			if ($is_totem == 1) {
				$totem_data = $result_qmap->fetch_array();
				$totem_type_id = $totem_data['GQUESTION_ID'];
				//-----------------------------------------//
				$result_relate = get_questions_relate(trim($totem_type_id));
				$a_have = $result_relate->num_rows;
				if ($a_have == 1) {
					$a_data = $result_relate->fetch_array();
					$totem_id = $a_data['GQUESTION_ID'];
					$totem_type_id = $a_data['GQUESTION_TYPE_ID'];
					$totem_msg = $a_data['GQUESTION_TEXT'];
					if ($totem_type_id == 1) {
						$totem_type_msg = "<font color=blue>Passage : ($totem_data[GQUESTION_ID])</font><br><br>";
						$totem_msg = get_relate_passage($totem_msg);
					}
					if ($totem_type_id == 2) {
						$totem_type_msg = "<font color=orange>Picture : ($totem_data[GQUESTION_ID])</font><br><br>";
						$totem_msg = get_relate_picture($totem_msg);
					}
					if ($totem_type_id == 3) {
						$totem_type_msg = "<font color=red>Sound : ($totem_data[GQUESTION_ID])</font><br><br>";
						$totem_msg = get_relate_sound($totem_msg);
					}

				}
				$totem = "" . $totem_type_msg . $totem_msg;
			}
			//******************************************************//
			if ($is_active == 1) {
				$msg_link = "<a title='Show' href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit=active&&active=0&&question=$id><font size=2 color=red> Set Hidden </font></a>";
			}
			if ($is_active == 0) {
				$msg_link = "<a title='Hidden' href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit=active&&active=1&&question=$id><font size=2 color=green> Set Show </font></a>";
			}
			echo " 	<br>
					<table align=center width=100% border=1 class=f-thai>
						<tr align=middle>
							<td colspan=2 align=left>";
			//-----------------//	
			$data = get_question(trim($id));
			//---------------- Get Path section --------------------//
			$result_sec = get_section(trim($data['TEST_ID']));
			$path_num = $result_sec->num_rows;
			if ($path_num == 1) {
				$path_data = $result_sec->fetch_array();
				$path_a = $path_data['TEST_NAME'];
			}
			//---------------- Get Path level --------------------//
			$result_level = get_level(trim($data['LEVEL_ID']));
			$path_num = $result_level->num_rows;
			if ($path_num == 1) {
				$path_data = $result_level->fetch_array();
				$path_b = $path_data['LEVEL_NAME'];
			}
			//---------------- Get Path skill --------------------//
			$result_skill = get_skill(trim($data['SKILL_ID']));	
			$path_num = $result_skill->num_rows;
			if ($path_num == 1) {
				$path_data = $result_skill->fetch_array();
				$path_c = $path_data['SKILL_NAME'];
			}
			//---------------- Get Path sub skill --------------------//
			$result_sskill = get_sub_skill(trim($data['SSKILL_ID']));
			$path_num = $result_sskill->num_rows;
			if ($path_num == 1) {
				$path_data = $result_sskill->fetch_array();
				$path_d = $path_data['SSKILL_NAME'];
			}
			//---------------- Get Path reason --------------------//
			$result_detail = get_detail(trim($data['DETAIL_ID']));
			$path_num = $result_detail->num_rows;
			if ($path_num == 1) {
				$path_data = $result_detail->fetch_array();
				$path_e = $path_data['DETAIL_NAME'];
			}
			echo "	
								<font size=2 color=brown>&nbsp;
									&nbsp; $path_a &nbsp;&nbsp;&raquo;&nbsp;&nbsp; $path_b &nbsp;&nbsp;&raquo;&nbsp;&nbsp; $path_c &nbsp;&nbsp;&raquo;&nbsp;&nbsp;
									$path_d &nbsp;&nbsp;&raquo;&nbsp;&nbsp; <br>&nbsp; &nbsp; $path_e  
								</font>
									";
			//-----------------//
			echo "
							</td>
						</tr>
						<tr valign=top>
							<td align=center rowspan=3 width=10%>
								$id
								<br><br><br>
								$msg_link							
							</td>
							<td align=left width=90%>
								$totem
							</td>
						</tr>
						<tr>	
							<td align=left width=100% bgcolor=dddddd><font size=2>$text</font>									
								<br><br><a href=?section=$_GET[section]&&status=$_GET[status]&&type=$_GET[type]&&edit=question&&question=$id target=_blank>
								<font color=red> >>  Edit Question << </font></a><br>&nbsp;
							</td>
						</tr>
						<tr>
							<td align=left width=90%><br>";
			
			$result_ans = get_answers(trim($id));
			$sub_num = $result_ans->num_rows;
			if ($sub_num) {
				for ($k = 1; $k <= $sub_num; $k++) {
					$sub_data = $result_ans->fetch_array();
					$ans_text = stripslashes($sub_data['ANSWERS_TEXT']);
					if ($sub_data['ANSWERS_CORRECT'] == 1) {
						$correct = "<font color=blue> True </font>";
					} else {
						$correct = "<font color=red> False </font>";
					}
					echo "&nbsp;&nbsp; $sub_data[ANSWERS_ID] : $correct : " . $ans_text . " <br>";
				}
			}
			echo "
							</td>
						</tr>
						<tr>
							<td colspan=2>
								<font size=2><b>&nbsp;Description : <br></b></font>";
		
			$result_des = get_description(trim($id));
			$is_des = $result_des->num_rows;
			if ($is_des == 1) {
				$des_data = $result_des->fetch_array();
				echo "<font  size=2 color=blue>$des_data[TEXT]</font>";
			} else {
				echo "	<div align=center><font size=2 color=red><b> - None Description - </b></font></div><br>";
			}
			echo "
							</td>
						</tr>
						<tr>
							<td colspan=2>";
			set_relate_form("by relate", $id, $totem_id);
			echo "
							</td>
						</tr>
					</table>";
		}
		echo "	<br>
				<div align=center class='f-thai paginate'>
					<a href=#><font size=2 color=blue>Go to Top</font></a>
				</div>";
	}
}


function script_ckeditor_detail()
{
	?>
<script>
CKEDITOR.replace('topic_detail', {

    extraPlugins: 'html5audio,lineheight,filebrowser,filetools,widget,clipboard,widgetselection,lineutils,undo,videoembed,ckeditorfa,codeTag,letterspacing,texttransform,templates,ajax,xml,simplebutton',

    line_height: '1px;1.1px;1.2px;1.3px;1.4px;1.5px;1.8px;2px;',
    allowedContent: true,

    contentsCss: '../bootstrap/fontawesome/css/all.min.css',

    height: 400,

    filebrowserUploadUrl: 'upload.php',

    filebrowserUploadMethod: 'form',

});
// icons font awesome
CKEDITOR.dtd.$removeEmpty.span = false;
</script>

<?php
}

function script_ckeditor_description()
{
?>
<script>
CKEDITOR.replace('description', {

    extraPlugins: 'lineheight,filetools,widget,clipboard,widgetselection,lineutils,undo,ckeditorfa,codeTag,letterspacing,texttransform,templates,ajax,xml',

    line_height: '1px;1.1px;1.2px;1.3px;1.4px;1.5px;1.8px;2px;',
    allowedContent: true,

    contentsCss: '../bootstrap/fontawesome/css/all.min.css',

    height: 150,

});
// icons font awesome
CKEDITOR.dtd.$removeEmpty.span = false;
</script>
<?php
}

function extra_test_system()
{
	if ($_GET['action'] === "active" && $_GET['active'] >= "0" && $_GET['extra_id']) {
		set_etest_active();
	}
	if ($_GET['action'] === "is_free" && $_GET['active'] >= "0" && $_GET['extra_id']) {
		set_etest_free();
	}
	if ($_GET['action'] === "est" && $_GET['active'] >= "0" && $_GET['extra_id']) {
		set_etest_est();
	}
	if ($_GET['action'] === "detail" && $_GET['extra_id']) {
		display_etest_detail();
	}
	if ($_GET['action'] === "edit_etest" && $_GET['extra_id']) {
		edit_extra_test();
	}
	if ($_GET['action'] === "add_quiz" && $_GET['extra_id'] && trim($_POST['quiz_id'])) {
		add_quiz_etest();
	}
	if ($_GET['action'] === "del_quiz" && $_GET['extra_id']) {
		del_quiz_etest();
	}
	if ($_GET['action'] === "add_etest") {
		add_etest();
	}
	if ($_GET['action'] === "del_etest" && $_GET['extra_id']) {
		del_etest();
	}
	if (!$_GET['action']) {
		etest_list();
	}

}

function set_etest_active()
{
	include('../config/connection.php');
	update_data('tbl_etest', 'IS_ACTIVE', $_GET['active'], 'ETEST_ID' ,trim($_GET['extra_id']));
	header("Location:?section=$_GET[section]&&status=$_GET[status]");
}
function set_etest_free()
{
	include('../config/connection.php');
	update_data('tbl_etest', 'IS_FREE', $_GET['active'], 'ETEST_ID' ,trim($_GET['extra_id']));
	header("Location:?section=$_GET[section]&&status=$_GET[status]");
}
function set_etest_est()
{
	include('../config/connection.php');
	update_data('tbl_etest', 'IS_EST', $_GET['active'], 'ETEST_ID' ,trim($_GET['extra_id']));
	header("Location:?section=$_GET[section]&&status=$_GET[status]");
}
function display_etest_detail()
{
	echo "
		<table align=center width=100% ellpadding=0 cellspacing=0 border=0 class=f-thai>
			<tr>
				<td width=100%>";
	edit_etest_form();
	echo "		</td>
			</tr>
		</table>";
}

function edit_etest_form()
{
	include('../config/connection.php');
	$result = get_etest(trim($_GET['extra_id']));
	$num = $result->num_rows;
	$font_black = "<font size=2>";
	if ($num == 1) {
		$data = $result->fetch_array();
		//------------------------------------------------------//
		$SQLetest = "SELECT * FROM tbl_etest_mapping WHERE ETEST_ID = ?";
		$query_etest = $conn->prepare($SQLetest);
		$query_etest->bind_param("s", $data['ETEST_ID']);
		$query_etest->execute();
		$result_etest = $query_etest->get_result();
		$quiz_num = $result_etest->num_rows;
		//------------------------------------------------------//
		echo "	<br>
					<table align=center width=100% cellpadding=0 cellspacing=0 border=0  bgcolor=f0f0f0 class=f-thai>
						<tr height=25>
							<td align=left>&nbsp;&nbsp; <b>
								<a href=?section=$_GET[section]&&status=$_GET[status]>$font_black Extra Test List </font></a>
								$font_black &nbsp;&nbsp;&raquo;&nbsp;&nbsp; </font>
								$font_black $data[ETEST_NAME] </font></b>
							</td>
						</tr>
					</table>
					<br>
					<table align=center width=100% cellpadding=0 cellspacing=0 border=0  bgcolor=f0f0f0 class=f-thai>
					<form method=post action=?section=$_GET[section]&&status=$_GET[status]&&action=edit_etest&&extra_id=$_GET[extra_id] class=f-thai>
						<tr height=15><td></td></tr>
						<tr height=25>
							<td width=20% align=right>$font_black <b> Extra Test ID </b></td>
							<td align=center>$font_black <b> &nbsp;&nbsp;:&nbsp;&nbsp; </b></td>
							<td width=20% align=left>$font_black $data[ETEST_ID]</td>
							<td width=15% align=right>$font_black <b> Name </b></td>
							<td align=center>$font_black <b> &nbsp;&nbsp;:&nbsp;&nbsp; </b></td>
							<td align=left colspan=4><input type=text size=40 name=extra_name value='$data[ETEST_NAME]' required></td>
						</tr>
						<tr height=25>
							<td width=15% align=right>$font_black <b> Time(Min) </b></td>
							<td align=center>$font_black <b> &nbsp;&nbsp;:&nbsp;&nbsp; </b></td>
							<td width=20% align=left><input type=number size=4     name=extra_time value='$data[ETEST_TIME]'></td>
							<td width=15% align=right>$font_black <b> Test Amount </b></td>
							<td align=center>$font_black <b> &nbsp;&nbsp;:&nbsp;&nbsp; </b></td>
							<td align=left><input type=number name='re_test' value='$data[RE_TEST]' size=4><font size=2> &nbsp; [100 = &infin; & Open All Times] </font></td>
							<td align=right>$font_black <b>Quiz Amount</b></td>
							<td align=center>$font_black <b> : </b></td>
							<td align=left>$font_black $quiz_num</td>
						</tr>
						<tr height=25>
							<td width=15% align=right>$font_black <b> Start </b></td>
							<td align=center>$font_black <b> &nbsp;&nbsp;:&nbsp;&nbsp; </b></td>
							<td width=20% align=left><input type=datetime-local size=20 name=started value='$data[start]'></td>
							<td width=15% align=right>$font_black <b> Stop </b></td>
							<td align=center>$font_black <b> &nbsp;&nbsp;:&nbsp;&nbsp; </b></td>
							<td align=left colspan=4><input type=datetime-local name='stopped' value='$data[stop]' size=20></td>
						</tr>
						<tr height=15><td></td></tr>
						<tr height=25>
							<td width=100% align=center colspan=9><input type=submit value='&nbsp; Edit Extra Test &nbsp;' class='btn-edit'></td>
						</tr>
						<tr height=15><td></td></tr>
					</form>
					</table>
					<br>
					<table align=center width=100% cellpadding=0 cellspacing=0 border=0  bgcolor=f0f0f0 class=f-thai>
						<tr height=10><td></td></tr>
						<tr>
							<form method=post action=?section=$_GET[section]&&status=$_GET[status]&&action=add_quiz&&extra_id=$_GET[extra_id]>
							<td width=50%>
								<table align=center width=100% cellpadding=0 cellspacing=0 border=0>
									<tr>
										<td align=right width=40%>$font_black <b> Add Quiz ID</b></td>
										<td align=center>$font_black <b> &nbsp;&nbsp;:&nbsp;&nbsp;</b></td>
										<td align=left width=20%><input type=text size=5 name=quiz_id required></td>
										<td align=left  width=40%><input type=submit value='Add Quiz' class='btn-add'></td>
									</tr>
								</table>
							</td>
							</form>
							<form method=post action=?section=$_GET[section]&&status=$_GET[status]&&action=del_quiz&&extra_id=$_GET[extra_id]>
							<td width=50%>
								<table align=center width=100% cellpadding=0 cellspacing=0 border=0>
									<tr>
										<td align=right width=40%>$font_black <b> Delete Quiz ID</b></td>
										<td align=center>$font_black <b> &nbsp;&nbsp;:&nbsp;&nbsp;</b></td>
										<td align=left width=20%><input type=text size=5 name=quiz_id required></td>
										<td align=left width=40%><input type=submit value='Delete Quiz' class='btn-delete'></td>
									</tr>
								</table>
							</td>
							</form>
						</tr>
						<tr height=10><td></td></tr>
					</table>
				";
		//-----------------------------------------------------------------//
		etest_quiz_list();
	}
}

function etest_quiz_list()
{
	include('../config/connection.php');
	$SQL = "SELECT * FROM tbl_etest_mapping WHERE ETEST_ID = ? order by QUESTIONS_ID ASC";
	$query = $conn->prepare($SQL);
	$query->bind_param("s", $_GET['extra_id']);
	$query->execute();
	$result = $query->get_result();
	$num = $result->num_rows;
	//----------------------------------------------------------------//
	if ($num >= 1) {
		$j = 1;
		while ($data = $result->fetch_assoc()) {
			$temp_id[$j] = trim($data['QUESTIONS_ID']);
			$j++;
		}
		for ($i = 1; $i <= $num; $i++) {
			$result_ques = get_questions_and_nums($temp_id[$i]);
			$is_have = $result_ques->num_rows;
			echo "<table align=center cellpadding=0 cellspacing=0 border=0 width=100% class=f-thai>";
			if ($is_have == 1) {
				echo "<tr><td>";
				//----------------------------------------------------------------------------------//
				$data = $result_ques->fetch_array();
				$text = $data['QUESTIONS_TEXT'];
				$text = stripslashes($text);
				$text = str_replace("&#039;", "'", $text);
				$text = str_replace("&lt;", "<", $text);
				$text = str_replace("&gt;", ">", $text);
				$id = trim($data['QUESTIONS_ID']);
				//---------------------------------------------------//
				$totem = "<font color=green> None Relate File or Passage </font>";
				$result_qmap = get_questions_mapping(trim($id));
				$is_totem = $result_qmap->num_rows;
				if ($is_totem == 1) {
					$totem_data = $result_qmap->fetch_array();
					$totem_type_id = trim($totem_data['GQUESTION_ID']);
					//-----------------------------------------//
					$result_relate = get_questions_relate($totem_type_id);
					$a_have = $result_relate->num_rows;
					if ($a_have == 1) {
						$a_data = $result_relate->fetch_array();
						$totem_type_id = trim($a_data['GQUESTION_TYPE_ID']);
						$totem_id = trim($a_data['GQUESTION_ID']);
						$totem_msg = $a_data['GQUESTION_TEXT'];
						if ($totem_type_id == 1) {
							$totem_type_msg = "<font color=blue>Passage : ($totem_data[GQUESTION_ID])</font><br><br>";
							$totem_msg = get_relate_passage($totem_msg);
						}
						if ($totem_type_id == 2) {
							$totem_type_msg = "<font color=orange>Picture : ($totem_data[GQUESTION_ID])</font><br><br>";
							$totem_msg = get_relate_picture($totem_msg);
						}
						if ($totem_type_id == 3) {
							$totem_type_msg = "<font color=red>Sound : ($totem_data[GQUESTION_ID])</font><br><br>";
							$totem_msg = get_relate_sound($totem_msg);
						}

					}
					$totem = "" . $totem_type_msg . $totem_msg;
				}
				//******************************************************//
				echo " <br>
						<table align=center width=100% border=1 class=f-thai>
							<tr align=middle>
								<td colspan=2 align=left>";
				//-----------------//	
				$data = get_question($id);
				//---------------- Get Path section --------------------//
				$result_sec = get_section(trim($data['TEST_ID']));
				$path_num = $result_sec->num_rows;
				if ($path_num == 1) {
					$path_data = $result_sec->fetch_array();
					$path_a = $path_data['TEST_NAME'];
				}
				//---------------- Get Path level --------------------//
				$result_level = get_level(trim($data['LEVEL_ID']));
				$path_num = $result_level->num_rows;
				if ($path_num == 1) {
					$path_data = $result_level->fetch_array();
					$path_b = $path_data['LEVEL_NAME'];
				}
				//---------------- Get Path skill --------------------//
				$result_skill = get_skill(trim($data['SKILL_ID']));	
				$path_num = $result_skill->num_rows;
				if ($path_num == 1) {
					$path_data = $result_skill->fetch_array();
					$path_c = $path_data['SKILL_NAME'];
				}
				//---------------- Get Path sub skill --------------------//
				$result_sskill = get_sub_skill(trim($data['SSKILL_ID']));
				$path_num = $result_sskill->num_rows;
				if ($path_num == 1) {
					$path_data = $result_sskill->fetch_array();
					$path_d = $path_data['SSKILL_NAME'];
				}
				//---------------- Get Path reason --------------------//
				$result_detail = get_detail(trim($data['DETAIL_ID']));
				$path_num = $result_detail->num_rows;
				if ($path_num == 1) {
					$path_data = $result_detail->fetch_array();
					$path_e = $path_data['DETAIL_NAME'];
				}
				echo "	
											<font size=2 color=brown>&nbsp;
												&nbsp; $path_a &nbsp;&nbsp;&raquo;&nbsp;&nbsp; $path_b &nbsp;&nbsp;&raquo;&nbsp;&nbsp; $path_c &nbsp;&nbsp;&raquo;&nbsp;&nbsp;
												$path_d &nbsp;&nbsp;&raquo;&nbsp;&nbsp; <br>&nbsp; &nbsp; $path_e  
											</font>
											";
				//-----------------//
				echo "
								</td>
							</tr>
							<tr valign=top>
								<td align=center rowspan=4 width=11%>
									$id
									<br><br><br>
									<p style='cursor: pointer;'
										onclick=\"javascript:
											if(confirm('คุณต้องการเอาข้อสอบข้อนี้ออกจากชุดข้อสอบนี้ใช่หรือไม่ ?'))
											{
												window.location='?section=$_GET[section]&&status=$_GET[status]&&action=del_quiz&&extra_id=$_GET[extra_id]&&quiz_id=$id';
											}
										\"><font size=2 color=red> [Cut Off] </font></p>
									<br><br><b>[$i]<b>								
								</td>
								<td align=left width=90%>
									$totem
								</td>
							</tr>
							<tr>	
								<td align=left width=100% bgcolor=dddddd><font size=2>$text</font>								
								</td>
							</tr>
							<tr>
								<td align=left width=100%>
									<a href='?section=$_GET[section]&&status=3&&edit=question&&question=$id' target=_blank>	
										<font size=2 color=blue>Edit Question</font>
									</a>
								</td>
							</tr>
							<tr>
								<td align=left width=90%><br>";
				
				$result_ans = get_answers(trim($id));
				$sub_num = $result_ans->num_rows;
				if ($sub_num) {
					for ($k = 1; $k <= $sub_num; $k++) {
						$sub_data = $result_ans->fetch_array();
						$ans_text = stripslashes($sub_data['ANSWERS_TEXT']);
						if ($sub_data['ANSWERS_CORRECT'] == "1") {
							$correct = "<font color=blue> True </font>";
						} else {
							$correct = "<font color=red> False </font>";
						}
						echo "&nbsp;&nbsp; $sub_data[ANSWERS_ID] : $correct : " . $ans_text . " <br>";
					}
				}
				echo "
								</td>
							</tr>
						</table>";
				//----------------------------------------------------------------------------------//
				echo "</td></tr>";
			} else {
				echo "<tr height=50><td width=100% align=center><font size=2 color=red> - Can't Found Question Detail - </font></td></tr>";
			}
			echo "</table><br>";
		}
	}
}
function edit_extra_test()
{
	include('../config/connection.php');
	$SQL = "UPDATE tbl_etest SET ETEST_NAME = ?, ETEST_TIME = ?, RE_TEST = ?, start = ?, stop = ? WHERE ETEST_ID = ?";
	$query = $conn->prepare($SQL);
	$query->bind_param("ssssss", $_POST['extra_name'], $_POST['extra_time'], $_POST['re_test'], $_POST['started'], $_POST['stopped'], $_GET['extra_id']);
	$query->execute();
	$query->close();
	header("Location:?section=$_GET[section]&&status=$_GET[status]&&action=detail&&extra_id=$_GET[extra_id]");
}
function add_quiz_etest()
{
	include('../config/connection.php');
	$now = date("Y-m-d");
	$time = 0;
	$SQL = "SELECT * FROM tbl_etest_mapping WHERE ETEST_ID=? && QUESTIONS_ID=?";
	$query = $conn->prepare($SQL);
	$query->bind_param("ss", $_GET['extra_id'], $_POST['quiz_id']);
	$query->execute();
	$result = $query->get_result(); 
	$num = $result->num_rows;
	if ($num == 0) {
		$strSQL = "INSERT INTO tbl_etest_mapping (ETEST_ID,QUESTIONS_ID,QUESTIONS_TIME,CREATDATE) VALUES(?,?,?,?)";
		$stmt = $conn->prepare($strSQL);
		$stmt->bind_param("ssis", $_GET['extra_id'], $_POST['quiz_id'], $time, $now);
		$stmt->execute();
		$stmt->close();
	}
	$query->close();
	header("Location:?section=$_GET[section]&&status=$_GET[status]&&action=detail&&extra_id=$_GET[extra_id]");
}
function del_quiz_etest()
{
	include('../config/connection.php');
	if ($_GET['quiz_id']) {
		$quiz_id = trim($_GET['quiz_id']);
	}
	if ($_POST['quiz_id']) {
		$quiz_id = trim($_POST['quiz_id']);
	}
	if (!$quiz_id) {
		header("Location:?section=$_GET[section]&&status=$_GET[status]&&action=detail&&extra_id=$_GET[extra_id]");
	}
	$SQL = "SELECT * FROM tbl_etest_mapping WHERE ETEST_ID=? && QUESTIONS_ID=?";
	$query = $conn->prepare($SQL);
	$query->bind_param("ss", $_GET['extra_id'], $quiz_id);
	$query->execute();
	$result = $query->get_result();
	$num = $result->num_rows;
	if ($num >= 1) {
		$msg = "DELETE FROM tbl_etest_mapping WHERE ETEST_ID=? && QUESTIONS_ID=?";
		$sub_stmt = $conn->prepare($msg);
		$sub_stmt->bind_param("ss", $_GET['extra_id'], $quiz_id);
		$sub_stmt->execute();
		$sub_stmt->close();
	}
	$query->close();
	header("Location:?section=$_GET[section]&&status=$_GET[status]&&action=detail&&extra_id=$_GET[extra_id]");
}
function add_etest()
{
	include('../config/connection.php');
	if (isset($_POST['add_name'])) {
		$now = date("Y-m-d");
		$datetime = date("Y-m-d H:i:s");
		$active = '0';
		$no = 'NULL';
		$etest_role = 'Standard Test';
		$name = trim($_POST['add_name']);
		$SQL = "SELECT * FROM tbl_etest ORDER BY ETEST_ID DESC limit 0,1";
		$query = $conn->prepare($SQL);
		$query->execute();
		$result = $query->get_result();
		$is_have = $result->num_rows;
		if ($is_have == 1) {
			$data = $result->fetch_array();
			$last_id = $data['ETEST_ID'] + 1;
			// var_dump($last_id);
		}
		if ($is_have == 0) {
			$last_id = 1;
		}
		$query->close();
		$strSQL = "INSERT INTO tbl_etest (ETEST_ID, ETEST_NAME, IS_SHOW, ETEST_TIME, ETEST_ROLEDESC, RE_TEST, IS_ACTIVE, IS_FREE, IS_PUBLIC, IS_EST, start, stop, CREATE_BY, CREATE_DT, DELETE_DT) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$stmt = $conn->prepare($strSQL);
		$stmt->bind_param("issssssssssssss", $last_id, $name, $active, $active, $etest_role, $active, $active, $active, $active, $active, $datetime, $datetime, $_SESSION["admin"], $now, $now);
		$stmt->execute();
		$stmt->close();
	}
	header("Location:?section=$_GET[section]&&status=$_GET[status]");
}
function del_etest()
{
	include('../config/connection.php');
	if (trim($_GET['extra_id'])) {
		delete_data('tbl_etest', 'ETEST_ID' , trim($_GET['extra_id']));
		
		delete_data('tbl_etest_mapping', 'ETEST_ID' , trim($_GET['extra_id']));
		
		delete_data('tbl_x_member_etest', 'etest_id' , trim($_GET['extra_id']));
	}
	header("Location:?section=$_GET[section]&&status=$_GET[status]");
}
function etest_list()
{
	include('../config/connection.php');
	$SQL = "SELECT ETEST_ID FROM tbl_etest order by ETEST_ID ASC";
	$query = $conn->prepare($SQL);
	$query->execute();
	$result = $query->get_result();
	$all_num = $result->num_rows;
	$query->close();
	// --------------------- //
	$per_page = 20;
	$all_page = $all_num / $per_page;
	$page_arr = explode(".", $all_page);
	if ($page_arr[1] > 0) {
		$all_page = $page_arr[0] + 1;
	} else {
		$all_page = $page_arr[0];
	}
	echo "<br><br>&nbsp;&nbsp; <font color=black size=2 class='f-thai'>Page : &nbsp;</font> ";
	for ($i = 1; $i <= $all_page; $i++) {
		if ($_GET['page'] == $i) {
			$color = "red";
		} else {
			$color = "blue";
		}
		echo " &nbsp;&nbsp;<a href='?section=$_GET[section]&&status=$_GET[status]&&page=$i'><font color=$color size=2 class='f-thai'>" . $i . "</font></a>&nbsp; ";
		if ($i % 20 == 0) {
			echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
	}
	echo "<br>";
	// --------------------- //
	if ($_GET['page']) {
		$start = $per_page * ($_GET['page'] - 1);
	} else {
		$start = 0;
	}
	$SQL = "SELECT * FROM tbl_etest order by ETEST_ID ASC limit $start,$per_page";
	$query = $conn->prepare($SQL);
	$query->execute();
	$result = $query->get_result();
	$num = $result->num_rows;
	$font_white = "<font size=2 color=white><b>";
	$font_black = "<font size=2 color=black>";
	$font_blue = "<font size=2 color=blue>";
	if ($num >= 1) {
		$j = 1;
		while ($row = $result->fetch_assoc()) {
			$temp_id[$j] = trim($row['ETEST_ID']);
			$temp_name[$j] = $row['ETEST_NAME'];
			$temp_time[$j] = $row['ETEST_TIME'];
			$temp_free[$j] = trim($row['IS_FREE']);
			$temp_est[$j] = trim($row['IS_EST']);
			$temp_active[$j] = trim($row['IS_ACTIVE']);
			$j++;
		}
		echo "	<br><br>
				<table width=100% cellspacing=0 cellpadding=0 border=0 align=center bgcolor=aaaaaa class=f-thai>
					<tr height=65>
						<td width=10% align=center>$font_white Extra ID</td>
						<td width=30% align=center>$font_white Name</td>
						<td width=10% align=center>$font_white Is Free</td>
						<td width=10% align=center>$font_white Status</td>
						<td width=10% align=center>$font_white Is EST</td>
						<td width=10% align=center>$font_white Time(min)</td>
						<td width=10% align=center>$font_white Quiz Amount</td>
						<td width=10% align=center>$font_white &nbsp;</td>
					</tr>
				</table>";
		for ($i = 1; $i <= $num; $i++) {
			$strSQL = "SELECT * FROM tbl_etest_mapping WHERE ETEST_ID=?";
			$query = $conn->prepare($strSQL);
			$query->bind_param("s", $temp_id[$i]);
			$query->execute();
			$result = $query->get_result();
			$quiz_num = $result->num_rows;
			//------------------------------------------------------//
			if ($temp_free[$i] == 1) {
				$free_active = "<a href=?section=$_GET[section]&&status=$_GET[status]&&action=is_free&&extra_id=$temp_id[$i]&&active=0><font size=2 color=green>Yes</font></a>";
			}
			if ($temp_free[$i] == 0) {
				$free_active = "<a href=?section=$_GET[section]&&status=$_GET[status]&&action=is_free&&extra_id=$temp_id[$i]&&active=1><font size=2 color=red>No</font></a>";
			}
			if ($temp_active[$i] == 1) {
				$is_active = "<a href=?section=$_GET[section]&&status=$_GET[status]&&action=active&&extra_id=$temp_id[$i]&&active=0><font size=2 color=green>Online</font></a>";
			}
			if ($temp_active[$i] == 0) {
				$is_active = "<a href=?section=$_GET[section]&&status=$_GET[status]&&action=active&&extra_id=$temp_id[$i]&&active=1><font size=2 color=red>Offline</font></a>";
			}
			if ($temp_est[$i] == 1) {
				$is_est = "<a href=?section=$_GET[section]&&status=$_GET[status]&&action=est&&extra_id=$temp_id[$i]&&active=0><font size=2 color=green>Yes</font></a>";
			}
			if ($temp_est[$i] == 0) {
				$is_est = "<a href=?section=$_GET[section]&&status=$_GET[status]&&action=est&&extra_id=$temp_id[$i]&&active=1><font size=2 color=red>No</font></a>";
			}
			echo "
				<table width=100% cellspacing=0 cellpadding=0 border=0 align=center bgcolor=f7f7f7 class=f-thai>
					<tr height=20>
						<td width=10% align=center>$font_black $temp_id[$i]</td>
						<td width=30% align=left><a href='?section=$_GET[section]&&status=$_GET[status]&&action=detail&&extra_id=$temp_id[$i]'>$font_blue $temp_name[$i]</a></td>
						<td width=10% align=center><b>$free_active</b></td>
						<td width=10% align=center><b>$is_active</b></td>
						<td width=10% align=center><b>$is_est</b></td>
						<td width=10% align=center>$font_black $temp_time[$i]</td>
						<td width=10% align=center>$font_black $quiz_num</td>
						<td width=10% align=center>
							<p style='cursor: pointer;'
								onclick=\"javascript:
									if(confirm('คุณต้องการลบชุดข้อสอบชุดนี้ใช่หรือไม่ ?'))
									{
										window.location='?section=$_GET[section]&&status=$_GET[status]&&action=del_etest&&extra_id=$temp_id[$i]';
									}
								\"><font size=2 color=red><b> Delete </b></font></p>
						</td>
					</tr>
				</table>";
		}
		$next = $_GET['page'] + 1;
		if ($next > $all_page) {
			$next = $all_page;
		}
		$back = $next - 2;
		if ($next <= 1) {
			$back = 1;
		}
		if (!$_GET['page'] || $_GET['page'] == "0" || $_GET['page'] == "1") {
			$next = "2";
			$back = "1";
		}
		echo "	<br><div align=center class='f-thai'>
					<a href=?section=admin&&status=$_GET[status]&&page=$back><font size=2 color=red>&raquo; Back &laquo;</font></a>
							&nbsp;&nbsp;&nbsp;&nbsp;<a href=#><font size=2 color=blue>Go to Top</font></a>&nbsp;&nbsp;&nbsp;&nbsp;
					<a href=?section=admin&&status=$_GET[status]&&page=$next><font size=2 color=red>&raquo; Next &laquo;</font></a>
				</div>";
	} else {
		echo "<div align=center class=f-thai><br><br><br><font size=2 color=red> - Can't Found Extra Test List - </font><br><br><br></div>";
	}
	echo "<br>
			<table align=center width=50% height=65 bgcolor='#f0f0f0' cellpadding=0 cellspacing=0 border=0 class=f-thai style='margin: 0 auto; padding: 0 15px;'>
				<form method=post action='?section=$_GET[section]&&status=$_GET[status]&&action=add_etest'>	
					<tr height=50>
						<td align=right><font size=2><b>Name</b></font></td>
						<td align=center><font size=2><b>&nbsp;:&nbsp;</b></font></td>
						<td align=left><input type='text' name='add_name' size=40 required></td>
						<td align=center><input type='submit' value='&nbsp;Add etest&nbsp;' class='btn-add'></td>
					</tr>
				</form>
			</table>";
}

function analyze_quiz_list()
{
	include('../config/connection.php');
	$strSQL = "SELECT QUESTIONS_ID FROM tbl_result_detail group by QUESTIONS_ID order by QUESTIONS_ID ASC";
	$query = $conn->prepare($strSQL);
	$query->execute();
	$result = $query->get_result();
	$all_num = $result->num_rows;
	$query->close();
	//--------------------------------------------------------------//
	$per_page = 20;
	$all_page = $all_num / $per_page;
	$page_arr = explode(".", $all_page);
	if ($page_arr[1] > 0) {
		$all_page = $page_arr[0] + 1;
	} else {
		$all_page = $page_arr[0];
	}
	echo "<br><br>&nbsp;&nbsp; <font color=black size=2 class='f-thai'>Page : &nbsp;</font> ";
	for ($i = 1; $i <= $all_page; $i++) {
		if ($_GET['page'] == $i) {
			$color = "red";
		} else {
			$color = "blue";
		}
		echo " &nbsp;&nbsp;<a href='?section=$_GET[section]&&status=$_GET[status]&&page=$i'><font color=$color size=2 class='f-thai'>" . $i . "</font></a>&nbsp; ";
		if ($i % 20 == 0) {
			echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
	}
	echo "<br><br>";
	//--------------------------------------------------------------//
	if ($_GET['page']) {
		$start = $per_page * ($_GET['page'] - 1);
	} else {
		$start = 0;
	}
	
	$SQL = "SELECT QUESTIONS_ID,RETEST_RESULT FROM tbl_result_detail group by QUESTIONS_ID order by QUESTIONS_ID ASC limit $start,$per_page";
	$query = $conn->prepare($SQL);
	$query->execute();
	$result_detail = $query->get_result();
	$num = $result_detail->num_rows;
	if ($num >= 1) {
		$j = 1;
		while ($row = $result_detail->fetch_assoc()) {
			$ques_id[$j] = trim($row['QUESTIONS_ID']);
			$j++;
		}
		for ($i = 1; $i <= $num; $i++) {
			$SQLans = "SELECT ANSWERS_ID,ANSWERS_CORRECT FROM tbl_answers WHERE QUESTIONS_ID = ? order by ANSWERS_ID";
			$query_ans = $conn->prepare($SQLans);
			$query_ans->bind_param("s", $ques_id[$i]);
			$query_ans->execute();
			$result_ans = $query_ans->get_result();
			$ans_num = $result_ans->num_rows;
			if ($ans_num == 4) {
				for ($k = 1; $k <= 4; $k++) {
					$ans_data = $result_ans->fetch_array();
					$ans_id[$k] = $ans_data['ANSWERS_ID'];
					if ($ans_data['ANSWERS_CORRECT'] == "1") {
						$ans_true = $ans_data['ANSWERS_ID'];
					}
				}
			}
			//-----------------------------------------------------//
			// echo "<font size=2>$i : Quiz Id = $ques_id[$i] : Ans ID = $ans_true</font><br>";
			//-----------------------------------------------------//
			$sum = 0;
			for ($k = 1; $k <= 5; $k++) {
				if ($ans_id[$k] != 0) {
					$msg_where[$k] = "SELECT RESULT_DETAIL_ID FROM tbl_result_detail WHERE QUESTIONS_ID='$ques_id[$i]' && RETEST_RESULT='$ans_id[$k]'";
				}
				if ($ans_id[$k] == 0) {
					$msg_where[$k] = "SELECT RESULT_DETAIL_ID FROM tbl_result_detail WHERE QUESTIONS_ID='$ques_id[$i]' && RETEST_RESULT='$ans_id[$k]'";
				}
				if (!$ans_id[$k]) {
					$msg_where[$k] = "SELECT RESULT_DETAIL_ID FROM tbl_result_detail WHERE QUESTIONS_ID='$ques_id[$i]' && RETEST_RESULT is NULL";
				}
				$query_result = $conn->prepare($msg_where[$k]);
				$query_result->execute();
				$result_result = $query_result->get_result();
				$num_each[$k] = $result_result->num_rows;
				$sum = $sum + $num_each[$k];
				// echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $k :Ans Id = $ans_id[$k] : Num = $num_each[$k] <br>";
			}
			for ($k = 1; $k <= 5; $k++) {
				$percent[$k] = 100 * $num_each[$k] / $sum;
				$arr_p = explode(".", $percent[$k]);
				if ($arr_p[1] > 0) {
					$percent[$k] = $arr_p[0] . "." . $arr_p[1][0] . $arr_p[1][1];
				} else {
					$percent[$k] = $arr_p[0];
				}
			}
			// echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; All : $sum <br><br>";
			//----------------------------------------------------//
			if ($ans_true == $ans_id[1]) {
				$bg_color[1] = " color='red' ";
			} else {
				$bg_color[1] = "";
			}
			if ($ans_true == $ans_id[2]) {
				$bg_color[2] = " color='red' ";
			} else {
				$bg_color[2] = "";
			}
			if ($ans_true == $ans_id[3]) {
				$bg_color[3] = " color='red' ";
			} else {
				$bg_color[3] = "";
			}
			if ($ans_true == $ans_id[4]) {
				$bg_color[4] = " color='red' ";
			} else {
				$bg_color[4] = "";
			}
			if ($sum <= 49) {
				$bg_color_a = "#f7f7f7";
			}
			if ($sum >= 50) {
				$bg_color_a = "#ccffcc";
			}
			if ($sum >= 101) {
				$bg_color_a = "#ffffcc";
			}
			if ($sum >= 501) {
				$bg_color_a = "#ffcccc";
			}
			echo "
				<table align=center cellpadding=0 cellspacing=0 width=100% class='f-thai'>
					<form method=post action=?section=$_GET[section]&&status=3&&type=10 target='_blank'>	
						<input type=hidden name=mode  value='1'>
						<input type=hidden name=find_id  value='$ques_id[$i]'>
						<input type=hidden value='search' name=action>
						<tr height=25 >
							<td rowspan=2 width=10% align=center bgcolor='#aaaaaa'><font size=2 color='white' ><b>No. $i </b></font></td>
							<td rowspan=2 width=10% align=center bgcolor='#f0f0f0'><font size=2 color='blue' >Quiz ID<br><br>[ $ques_id[$i] ]</font><br><br>
								<input type=submit value='&nbsp;Details&nbsp;' class='btn-set-relate'>
							</td>
							<td width=80% align=left bgcolor='$bg_color_a'>&nbsp;
									<font size=2 color='brown' >[Answer Correct ID : $ans_true] - [All Answer : $sum]</font>
							</td>
						</tr>
						<tr bgcolor='$bg_color_a'>
							<td>
								<table align=center cellpadding=0 cellspacing=0 width=100% >
									<tr>
										<td width=30% align=left>&nbsp;&nbsp;<font size=2 $bg_color[1]>Answer ID : $ans_id[1]</font></td>
										<td width=30% align=left>&nbsp;&nbsp;<font size=2 $bg_color[1]>Amount : $num_each[1]</font></td>
											<td width=40% align=left>&nbsp;&nbsp;<font size=2 $bg_color[1]>Percent : $percent[1] %</font></td>
									</tr>
								</table>
								<table align=center cellpadding=0 cellspacing=0 width=100% >
									<tr>
										<td width=30% align=left>&nbsp;&nbsp;<font size=2 $bg_color[2]>Answer ID : $ans_id[2]</font></td>
										<td width=30% align=left>&nbsp;&nbsp;<font size=2 $bg_color[2]>Amount : $num_each[2]</font></td>
										<td width=40% align=left>&nbsp;&nbsp;<font size=2 $bg_color[2]>Percent : $percent[2]%</font></td>
									</tr>
								</table>
								<table align=center cellpadding=0 cellspacing=0 width=100% >
									<tr>
										<td width=30% align=left>&nbsp;&nbsp;<font size=2 $bg_color[3]>Answer ID : $ans_id[3]</font></td>
										<td width=30% align=left>&nbsp;&nbsp;<font size=2 $bg_color[3]>Amount : $num_each[3]</font></td>
										<td width=40% align=left>&nbsp;&nbsp;<font size=2 $bg_color[3]>Percent : $percent[3] %</font></td>
									</tr>
								</table>
								<table align=center cellpadding=0 cellspacing=0 width=100% >
									<tr>
										<td width=30% align=left>&nbsp;&nbsp;<font size=2 $bg_color[4]>Answer ID : $ans_id[4]</font></td>
										<td width=30% align=left>&nbsp;&nbsp;<font size=2 $bg_color[4]>Amount : $num_each[4]</font></td>
										<td width=40% align=left>&nbsp;&nbsp;<font size=2 $bg_color[4]>Percent : $percent[4] %</font></td>
									</tr>
								</table>
								<table align=center cellpadding=0 cellspacing=0 width=100% >
									<tr>
										<td width=30% align=left>&nbsp;&nbsp;<font size=2 color='green' >Unanswered</font></td>
										<td width=30% align=left>&nbsp;&nbsp;<font size=2 color='green'>Amount : $num_each[5]</font></td>
										<td width=40% align=left>&nbsp;&nbsp;<font size=2 color='green'>Percent : $percent[5] %</font></td>
									</tr>
								</table>
							</td>
						</tr>
					</form>
				</table><br>";
		}

		$next = $_GET['page'] + 1;
		if ($next > $all_page) {
			$next = $all_page;
		}
		$back = $next - 2;
		if ($next <= 1) {
			$back = 1;
		}
		if (!$_GET['page'] || $_GET['page'] == "0" || $_GET['page'] == "1") {
			$next = "2";
			$back = "1";
		}
		echo "	<div align=center class='f-thai'>
					<a href=?section=admin&&status=$_GET[status]&&page=$back><font size=2 color=red>&raquo; Back &laquo;</font></a>
							&nbsp;&nbsp;&nbsp;&nbsp;<a href=#><font size=2 color=blue>Go to Top</font></a>&nbsp;&nbsp;&nbsp;&nbsp;
					<a href=?section=admin&&status=$_GET[status]&&page=$next><font size=2 color=red>&raquo; Next &laquo;</font></a>
				</div>";
	}
}

function comment_quiz()
{
	if (!$_GET['action']) {
		have_comment_quiz_list();
	}
	if ($_GET['action'] === "detail" && $_GET['quiz_id'] >= "1") {
		comment_quiz_detail();
	}
	if ($_GET['action'] === "set_status" && $_GET['quiz_id'] >= "1") {
		set_quiz_comment_status();
	}
}

function have_comment_quiz_list()
{
	include('../config/connection.php');
	$strSQL = "SELECT quiz_id FROM tbl_quiz_comment group by quiz_id order by date DESC";
	$query = $conn->prepare($strSQL);
	$query->execute();
	$result = $query->get_result();
	$all_num = $result->num_rows;
	$query->close();
	// --------------------- //
	$per_page = 20;
	$all_page = $all_num / $per_page;
	$page_arr = explode(".", $all_page);
	if ($page_arr[1] > 0) {
		$all_page = $page_arr[0] + 1;
	} else {
		$all_page = $page_arr[0];
	}
	echo "<br><br>&nbsp;&nbsp; <font color=black size=2 class='f-thai'>Page : &nbsp;</font> ";
	for ($i = 1; $i <= $all_page; $i++) {
		if ($_GET['page'] == $i) {
			$color = "red";
		} else {
			$color = "blue";
		}
		echo " &nbsp;&nbsp;<a href='?section=$_GET[section]&&status=$_GET[status]&&page=$i'><font color=$color size=2 class='f-thai'>" . $i . "</font></a>&nbsp; ";
		if ($i % 20 == 0) {
			echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
	}
	echo "<br>";
	// --------------------- //
	if ($_GET['page']) {
		$start = $per_page * ($_GET['page'] - 1);
	} else {
		$start = 0;
	}
	echo "<br><br><div align=center class='f-thai'><font size=3 color=green><b>Display quiz have comment [ $all_num ]</b></font></div><br><br>";

	$strSQL = "SELECT quiz_id FROM tbl_quiz_comment group by quiz_id order by date DESC limit $start,$per_page";
	$stmt = $conn->prepare($strSQL);
	$stmt->execute();
	$result = $stmt->get_result();
	$num = $result->num_rows;
	if ($num >= 1) {
		echo "	
				<table align=center width=100% cellpadding=0 cellspacing=0 border=0 class='f-thai'>
					<tr height=55 bgcolor='#d0d0d0'>
						<td align=center width=5%><font size=2><b>No.</b></font></td>
						<td align=center width=10%><font size=2><b>Quiz ID</b></font></td>
						<td align=center width=25%><font size=2><b>Skill</b></font></td>
						<td align=center width=25%><font size=2><b>Level</b></font></td>
						<td align=center width=25%><font size=2><b>[ Unanswered / Answered ]</b></font></td>
						<td align=center width=10%><font size=2><b>Status</b></font></td>
					</tr>
			
				</table>";
		for ($i = 1; $i <= $num; $i++) {
			$data = $result->fetch_array();
			$quiz_id = trim($data['quiz_id']);
			//----------------------------------------------------------------//
			$SQL = "SELECT SKILL_ID,LEVEL_ID FROM tbl_questions WHERE QUESTIONS_ID=?";
			$query_ques = $conn->prepare($SQL);
			$query_ques->bind_param("s", $quiz_id);
			$query_ques->execute();
			$result_ques = $query_ques->get_result();
			$is_have = $result_ques->num_rows;
			if ($is_have == 1) {
				$data_quiz = $result_ques->fetch_array();
				$skill_id = $data_quiz['SKILL_ID'];
				$level_id = $data_quiz['LEVEL_ID'];
				$skill[1] = "Reading";
				$skill[2] = "Listening";
				$skill[3] = "Speaking";
				$skill[4] = "Writing";
				$skill[5] = "Grammatical";
				$skill[6] = "Integrated Skill";
				$skill[7] = "Vocabulary";
				$level[1] = "Beginner";
				$level[2] = "Lower Intermediate";
				$level[3] = "Intermediate";
				$level[4] = "Upper Intermediate";
				$level[5] = "Advanced";
				$skill_name = $skill[$skill_id];
				$level_name = $level[$level_id];
			}
			//----------------------------------------------------------------//

			$unans_num = get_quiz_status_comment($quiz_id, 0);
			$ansed_num = get_quiz_status_comment($quiz_id, 1);
			if ($unans_num >= 1) {
				$status = "<font size=3 color=red><b>New</b></font>";
			} else {
				$status = "<font size=2 color=green><b>Old</b></font>";
			}
			//----------------------------------------------------------------//
			if ($i % 2 == 0) {
				$color = "f0ffff";
			} else {
				$color = "fffff0";
			}
			echo "	
				<table align=center width=100% cellpadding=0 cellspacing=0 border=0 class='f-thai'>
					<tr height=45 bgcolor='$color'>
						<td align=center width=5%><font size=2>$i</font></td>
						<td align=center width=10%><font size=2 color=blue>$quiz_id</font></td>
						<td align=center width=25%><font size=2 color=brown>$skill_name</font></td>
						<td align=center width=25%><font size=2 color='#ff44ff'>$level_name</font></td>
						<td align=center width=25%><font size=2>[ $unans_num / $ansed_num ]</font></td>
						<td align=center width=10%><a href='?section=$_GET[section]&&status=$_GET[status]&&action=detail&&quiz_id=$quiz_id'>$status</a></td>
					</tr>
				</table>";
		}
		if($all_num > 20){
			$next = $_GET['page'] + 1;
			if ($next > $all_page) {
				$next = $all_page;
			}
			$back = $next - 2;
			if ($next <= 1) {
				$back = 1;
			}
			if (!$_GET['page'] || $_GET['page'] == "0" || $_GET['page'] == "1") {
				$next = "2";
				$back = "1";
			}
			
			echo "	<br><div align=center class='f-thai'>
						<a href=?section=admin&&status=$_GET[status]&&page=$back><font size=2 color=red>&raquo; Back &laquo;</font></a>
								&nbsp;&nbsp;&nbsp;&nbsp;<a href=#><font size=2 color=blue>Go to Top</font></a>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href=?section=admin&&status=$_GET[status]&&page=$next><font size=2 color=red>&raquo; Next &laquo;</font></a>
					</div>";
		}else{
			echo "	<br><div align=center class='f-thai'>
						<a href=#><font size=2 color=blue>Go to Top</font></a>
					</div>";
		}
	}
}

function comment_quiz_detail()
{
	include('../config/connection.php');
	echo "<br><br><div align=center class='f-thai'><font size=3 color=green><b>Quiz Comment List</b></font></div><br><br>";
	//-----------------------------------------------------------------------//
	$page = $_GET['page'];
	if (!$_GET['page']) {
		$page = "1";
	}
	;
	$start = ($page - 1) * $amount;
	$result = get_questions_and_nums(trim($_GET['quiz_id']));
	$num = $result->num_rows;
	if ($num >= 1) {
		$j = 1;
		while ($row = $result->fetch_assoc()) {
			$ques_id[$j] = trim($row['QUESTIONS_ID']);
			$ques_text[$j] = $row['QUESTIONS_TEXT'];
			$j++;
		}
		for ($i = 1; $i <= $num; $i++) {
			$text = $ques_text[$i];
			$text = stripslashes($text);
			$text = str_replace("&#039;", "'", $text);
			$text = str_replace("&lt;", "<", $text);
			$text = str_replace("&gt;", ">", $text);
			$id = $ques_id[$i];
			//---------------------------------------------------//
			$totem = "<font color=green> None Relate File or Passage </font>";
			$result_qmap = get_questions_mapping(trim($id));	
			$is_totem = $result_qmap->num_rows;
			if ($is_totem == 1) {
				$totem_data = $result_qmap->fetch_array();
				$totem_type_id = $totem_data['GQUESTION_ID'];
				//-----------------------------------------//
				$result_relate = get_questions_relate(trim($totem_type_id));
				$a_have = $result_relate->num_rows;
				if ($a_have == 1) {
					$a_data = $result_relate->fetch_array();
					$totem_type_id = $a_data['GQUESTION_TYPE_ID'];
					$totem_id = $a_data['GQUESTION_ID'];
					$totem_msg = $a_data['GQUESTION_TEXT'];
					if ($totem_type_id == 1) {
						$totem_type_msg = "<font color=blue>Passage : ($totem_data[GQUESTION_ID])</font><br><br>";
						$totem_msg = get_relate_passage($totem_msg);
					}
					if ($totem_type_id == 2) {
						$totem_type_msg = "<font color=orange>Picture : ($totem_data[GQUESTION_ID])</font><br><br>";
						$totem_msg = get_relate_picture($totem_msg);
					}
					if ($totem_type_id == 3) {
						$totem_type_msg = "<font color=red>Sound : ($totem_data[GQUESTION_ID])</font><br><br>";
						$totem_msg = get_relate_sound($totem_msg);
					}

				}
				$totem = "" . $totem_type_msg . $totem_msg;
			}
			//******************************************************//
			echo " <br>
					<table align=center width=100% border=1 class='f-thai'>
						<tr align=middle>
							<td colspan=2 align=left>";
			//-----------------//	
			$data = get_question($id);
			//---------------- Get Path section --------------------//
			$result_sec = get_section(trim($data['TEST_ID']));
			$path_num = $result_sec->num_rows;
			if ($path_num == 1) {
				$path_data = $result_sec->fetch_array();
				$path_a = $path_data['TEST_NAME'];
			}
			//---------------- Get Path level --------------------//	
			$result_level = get_level(trim($data['LEVEL_ID']));
			$path_num = $result_level->num_rows;
			if ($path_num == 1) {
				$path_data = $result_level->fetch_array();
				$path_b = $path_data['LEVEL_NAME'];
			}
			//---------------- Get Path skill --------------------//
			$result_skill = get_skill(trim($data['SKILL_ID']));
			$path_num = $result_skill->num_rows;
			if ($path_num == 1) {
				$path_data = $result_skill->fetch_array();
				$path_c = $path_data['SKILL_NAME'];
			}
			//---------------- Get Path sub skill --------------------//
			$result_sskill = get_sub_skill(trim($data['SSKILL_ID']));	
			$path_num = $result_sskill->num_rows;
			if ($path_num == 1) {
				$path_data = $result_sskill->fetch_array();
				$path_d = $path_data['SSKILL_NAME'];
			}
			//---------------- Get Path reason --------------------//	
			$result_detail = get_detail(trim($data['DETAIL_ID']));
			$path_num = $result_detail->num_rows;
			if ($path_num == 1) {
				$path_data = $result_detail->fetch_array();
				$path_e = $path_data['DETAIL_NAME'];
			}
			echo "	
									<font size=2 color=brown>&nbsp;
										&nbsp; $path_a &nbsp;&nbsp;&raquo;&nbsp;&nbsp; $path_b &nbsp;&nbsp;&raquo;&nbsp;&nbsp; $path_c &nbsp;&nbsp;&raquo;&nbsp;&nbsp;
										$path_d &nbsp;&nbsp;&raquo;&nbsp;&nbsp; <br>&nbsp; &nbsp; $path_e  
									</font>
									";
			//-----------------//
			echo "
								</td>
							</tr>
							<tr valign=top>
								<td align=center rowspan=3 width=10%>
									$id
								</td>
								<td align=left width=90%>
									$totem
								</td>
							</tr>
							<tr>	
								<td align=left width=100% bgcolor=dddddd><font size=2>$text	</font>							
									<br><br>
										<a href=?section=$_GET[section]&&status=3&&type=$_GET[type]&&edit=question&&question=$id target=_blank>
											<font color=red> &raquo;  Edit Question &laquo; </font>
										</a><br>&nbsp;
								</td>
							</tr>
							<tr>
								<td align=left width=90%><br>
					";
			
			$result_ans = get_answers(trim($id));
			$sub_num = $result_ans->num_rows;
			if ($sub_num) {
				for ($k = 1; $k <= $sub_num; $k++) {
					$sub_data = $result_ans->fetch_array();
					$ans_text = stripslashes($sub_data['ANSWERS_TEXT']);
					if ($sub_data['ANSWERS_CORRECT'] == "1") {
						$correct = "<font color=blue> True </font>";
					} else {
						$correct = "<font color=red> False </font>";
					}
					echo "&nbsp;&nbsp; $sub_data[ANSWERS_ID] : $correct : " . $ans_text . " <br>";
				}
			}
			echo "
								</td>
							</tr>
							<tr>
								<td colspan=2>
									<font size=2><b>&nbsp;Description : <br></b></font>
									
					";
			
			$result_des = get_description(trim($id));
			$is_des = $result_des->num_rows;
			if ($is_des == 1) {
				$des_data = $result_des->fetch_array();
				echo "<font  size=2 color=blue>$des_data[TEXT]</font>";
			} else {
				echo "<div align=center><font size=2 color=red><b> - None Description - </b></font></div><br>";
			}
			echo "
								</td>
							</tr>
						</table><br><br>";
		}
	}
	//----------------------------------------------------------------------------------------------------------------//
	$SQLcomment = "SELECT * FROM tbl_quiz_comment WHERE quiz_id = ? order by date DESC";
	$query_comment = $conn->prepare($SQLcomment);
	$query_comment->bind_param("s", $_GET['quiz_id']);
	$query_comment->execute();
	$result_comment = $query_comment->get_result();
	$num = $result_comment->num_rows;
	if ($num >= 1) {
		for ($i = 1; $i <= $num; $i++) {
			$data = $result_comment->fetch_array();
			$mem_id = "";
			$email = "";
			$fname = "";
			$lname = "";
			//---------------------------------------------------------------------------------------------//
			$SQLmember = "SELECT * FROM tbl_x_member WHERE member_id = ?";
			$query_member = $conn->prepare($SQLmember);
			$query_member->bind_param("s", $data['mem_id']);
			$query_member->execute();
			$result_member = $query_member->get_result();
			$is_mem = $result_member->num_rows;
			if ($is_mem == 1) {
				$mem_data = $result_member->fetch_array();
				$mem_id = $mem_data['member_id'];
				$email = $mem_data['email'];
				$fname = $mem_data['fname'];
				$lname = $mem_data['lname'];
			}
			//---------------------------------------------------------------------------------------------//
			if ($data['status'] == 0) {
				$status = "<font size=2 color=red><b>[X]</b></font>";
			}
			if ($data['status'] == 1) {
				$status = "<font size=2 color=green><b>[O]</b></font>";
			}
			echo "
					<table align=center width=100% cellpadding=5 cellspacing=0 border=0 class='f-thai'>
						<tr height=35  bgcolor='#d7d7d7'>
							<td width=35% align=left><font size=2 >By : $fname &nbsp; $lname</font></td>
							<td width=35% align=left><font size=2 >Email : $email</font></td>
							<td width=25% align=left><font size=2 >Date : $data[date] </font></td>
							<td width=5% align=center>
								<a href='?section=$_GET[section]&&status=$_GET[status]&&action=set_status&&quiz_id=$_GET[quiz_id]&&mem_id=$data[mem_id]'>
									$status
								</a>
							</td>
						</tr>
						<tr height=35 bgcolor='#f0f0f0'>
							<td width=100% colspan=4><font size=2>$data[text]</font></td>
						</tr>
						<tr height=10 bgcolor='#f0f0f0'><td width=100% colspan=4></td></tr>
						<tr height=15><td width=100% colspan=4></td></tr>
					</table>";
		}
	}

}

function set_quiz_comment_status()
{
	include('../config/connection.php');
	$strSQL = "SELECT * FROM tbl_quiz_comment WHERE quiz_id = ? && mem_id=?";
	$stmt = $conn->prepare($strSQL);
	$stmt->bind_param("ss", $_GET['quiz_id'], $_GET['mem_id']);
	$stmt->execute();
	$result = $stmt->get_result();	
	$is_have = $result->num_rows;
	if ($is_have == 1) {
		$data = $result->fetch_array();
		$status = $data['status'];
		if ($status == 0) {
			$value = 1;
		}
		if ($status == 1) {
			$value = 0;
		}
		update_data('tbl_quiz_comment', 'status', $value, 'quiz_id' ,trim($_GET['quiz_id']));
	}
	header("Location:?section=$_GET[section]&&status=$_GET[status]&&action=detail&&quiz_id=$_GET[quiz_id]");
}

function get_skill_name($skill_id)
{
	include('../config/connection.php');
	$SQLskill = "SELECT * FROM tbl_item_skill WHERE SKILL_ID = ? group by SKILL_ID";
	$query_skill = $conn->prepare($SQLskill);
	$query_skill->bind_param("s", $skill_id);
	$query_skill->execute();
	$result_skill = $query_skill->get_result();
	$path_num = $result_skill->num_rows;
	if ($path_num == "1") {
		$path_data = $result_skill->fetch_array();
		$path_c = $path_data['SKILL_NAME'];
	}
	return $path_c;
}


function lesson_and_relate(){
	echo "<br><br>";
	echo "<div align=center class='f-thai'>
		 	<a href=?section=$_GET[section]&&status=$_GET[status]&&skill_id=1>[ Reading ]</a>&nbsp;&nbsp;
		 	<a href=?section=$_GET[section]&&status=$_GET[status]&&skill_id=2>[ Listening ]</a>&nbsp;&nbsp;
		 	<a href=?section=$_GET[section]&&status=$_GET[status]&&skill_id=3>[ Semi-Speaking ]</a>&nbsp;&nbsp;
		 	<a href=?section=$_GET[section]&&status=$_GET[status]&&skill_id=4>[ Semi-Writing ]</a>&nbsp;&nbsp;
		 	<a href=?section=$_GET[section]&&status=$_GET[status]&&skill_id=5>[ Grammatical ]</a>&nbsp;&nbsp;
		 	<a href=?section=$_GET[section]&&status=$_GET[status]&&skill_id=6>[ Integrated Skill ]</a>&nbsp;&nbsp;
		 	<a href=?section=$_GET[section]&&status=$_GET[status]&&skill_id=7>[ Vocabulary ]</a>&nbsp;&nbsp;
		  </div>";
	echo "<br><br>";
	if($_GET['action']==="add"){	add_e_relate();	}
	if($_GET['action']==="del"){	del_e_relate();	}
	if($_GET['skill_id']){	relate_list($_GET['skill_id']);	}
}

function add_e_relate(){
	include('../config/connection.php');
	if($_POST['skill_id']>=1&&$_POST['reason_id']>=1&&$_POST['topic_id']>=1)
	{
		$strSQL = "INSERT INTO tbl_e_switch (SKILL_ID,DETAIL_ID,TOPIC_ID) VALUES(?,?,?)";
		$stmt = $conn->prepare($strSQL);
		$stmt->bind_param("sss", $_POST['skill_id'], $_POST['reason_id'],$_POST['topic_id']);
		$stmt->execute();
		$stmt->close();
	}
	header("Location:?section=$_GET[section]&&status=$_GET[status]&&skill_id=$_POST[skill_id]");
}

function del_e_relate(){
	include('../config/connection.php');
	if($_GET['skill_id']>=1&&$_GET['reason_id']>=1&&$_GET['topic_id']>=1)
	{
		$SQL = "DELETE FROM tbl_e_switch WHERE SKILL_ID = ? && DETAIL_ID = ? && TOPIC_ID = ?";
		$stmt = $conn->prepare($SQL);
		$stmt->bind_param("sss", $_GET['skill_id'], $_GET['reason_id'],$_GET['topic_id']);
		$stmt->execute();
		$stmt->close();
	}
	header("Location:?section=$_GET[section]&&status=$_GET[status]&&skill_id=$_GET[skill_id]");
}

function relate_list($skill_id)
{
	include('../config/connection.php');
	$skill_name[1] = "Reading";			$skill_name[2] = "Listening";			
	$skill_name[3] = "Speaking";		$skill_name[4] = "Writing";		
	$skill_name[5] = "Grammatical";		$skill_name[6] = "Cloze : Test";	
	$skill_name[7] = "Vocabulary";		
	//--------------------------------------------------------------------------------------------------------------------//
	echo "<div align=center class='f-thai'><font color=green size=4><b>$skill_name[$skill_id]</b></font><br>&nbsp;</div>";
	//--------------------------------------------------------------------------------------------------------------------//
	$strSQL = "SELECT * FROM tbl_e_switch WHERE SKILL_ID = ? order by DETAIL_ID";
	$stmt = $conn->prepare($strSQL);
	$stmt->bind_param("s", $skill_id);
	$stmt->execute();
	$result = $stmt->get_result();
	$num = $result->num_rows;
	if($num>=1)
	{
		for($i=1;$i<=$num;$i++)
		{
			$data = $result->fetch_array();			
			$reason_id[$i] = trim($data['DETAIL_ID']);		
			$topic_id[$i] = trim($data['TOPIC_ID']);
		}
		for($i=1;$i<=$num;$i++)
		{
			$SQL = "SELECT * FROM tbl_item_detail WHERE DETAIL_ID = ? && SKILL_ID = ? group by DETAIL_ID";
			$query = $conn->prepare($SQL);
			$query->bind_param("ss", $reason_id[$i],$skill_id);
			$query->execute();
			$result_item = $query->get_result();
			$x_have = $result_item->num_rows;
			if($x_have==1){		
				$x_data = $result_item->fetch_array();		
				$reason_name[$i] = $x_data['DETAIL_NAME'];	
			}
		}
		//--------------------------------------------------------------------------------------------------------//
		for($i=1;$i<=$num;$i++)
		{
			$SQLtopic = "SELECT * FROM tbl_web_topic WHERE topic_id = ?";
			$query_topic = $conn->prepare($SQLtopic);
			$query_topic->bind_param("s", $topic_id[$i]);
			$query_topic->execute();
			$result_topic = $query_topic->get_result();
			$y_have = $result_topic->num_rows;
			if($y_have==1){		
				$y_data = $result_topic->fetch_array();		
				$topic_name[$i] = $y_data['topic_name'];	
			}
		}
		//--------------------------------------------------------------------------------------------------------//
		for($i=1;$i<=$num;$i++)
		{
			echo "
				<table align=center width=100% cellpadding=5 cellspacing=0 border=0 class='f-thai'>
					<tr height=25 bgcolor='f0f0f0'>
						<td width=8% align=center rowspan=2><font size=2><b>$i</b></font></td>
						<td align=left width=80%><font size=2><b> Reason Detail : [$reason_id[$i]] $reason_name[$i] </b></font></td>
						<td align=center width=12% rowspan=2>
							
							<p style='cursor: pointer;'
							onclick=\"javascript:
								if(confirm('คุณต้องการลบ Lesson ชุดนี้ใช่หรือไม่ ?'))
								{
									window.location='?section=$_GET[section]&&status=$_GET[status]&&action=del&&skill_id=$skill_id&&reason_id=$reason_id[$i]&&topic_id=$topic_id[$i]';
								}
							\"><font size=2 color=red><b> &laquo; Delete &raquo; </b></font></p>
						</td>
					</tr>
					<tr height=25 bgcolor='f0f0f0'>
						<td align=left ><font size=2><b> Elearning Topic : [$topic_id[$i]] $topic_name[$i] </b></font></td>
					</tr>
					<tr height=10 bgcolor='white'>
					</tr>
				</table>";
		}
	}
	else
	{
		echo "<br><br><div align=center class='f-thai'><font color=red size=3 ><b>[ No Relate Reason with Elearning in this Skill ]</b></font></div><br><br>&nbsp;";
	}
	echo "
		<br>
		<table align=center width=60% bgcolor='f0f0f0' border=0 class='f-thai' style='margin: 0 auto; padding: 0 10px;'>
			<form method=post action='?section=$_GET[section]&&status=$_GET[status]&&action=add'>
				<input type=hidden name='skill_id' value='$skill_id'>
				<tr height=70>
					<td width=15% align=right><font size=2><b>Reason ID</b></font></td></td>
					<td width=10% align=center><font size=2><b> : </b></font></td>
					<td width=15% align=left><input type=number name=reason_id size=5 required></td>
					<td width=15% align=right><font size=2><b>Topic ID</b></font></td>
					<td width=10% align=center><font size=2><b> : </b></font></td>
					<td width=15% align=left><input type=number name=topic_id size=5 required></td>
					<td width=20% align=center><input type=submit value=' Add Relation ' class='btn-add'></td>
				</tr>
			</form>
		</table><br>&nbsp;";
}


function get_question($question_id) {
	include('../config/connection.php');
	$strSQL = "SELECT * FROM tbl_questions WHERE QUESTIONS_ID=? ";
	$stmt = $conn->prepare($strSQL);
	$stmt->bind_param("s", $question_id);
	$stmt->execute();
	$result = $stmt->get_result();
	$data = $result->fetch_array();
	return $data;
}


function get_questions_and_nums($question_id){
	include('../config/connection.php');
	$strSQL = "SELECT * FROM tbl_questions WHERE QUESTIONS_ID=? ";
	$stmt = $conn->prepare($strSQL);
	$stmt->bind_param("s", $question_id);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result;
}

function get_section($test_id){
	include('../config/connection.php');
	$strSQL = "SELECT * FROM tbl_section WHERE TEST_ID = ? group by TEST_ID";
	$stmt = $conn->prepare($strSQL);
	$stmt->bind_param("s", $test_id);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result;
}

function get_level($level_id){
	include('../config/connection.php');
	$strSQL = "SELECT * FROM tbl_item_level WHERE LEVEL_ID = ? group by LEVEL_ID";
	$stmt = $conn->prepare($strSQL);
	$stmt->bind_param("s", $level_id);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result;
}

function get_skill($skill_id){
	include('../config/connection.php');
	$strSQL = "SELECT * FROM tbl_item_skill WHERE SKILL_ID = ? group by SKILL_ID";
	$stmt = $conn->prepare($strSQL);
	$stmt->bind_param("s", $skill_id);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result;
}

function get_sub_skill($sskill_id){
	include('../config/connection.php');
	$strSQL = "SELECT * FROM tbl_item_sskill WHERE SSKILL_ID=? group by SSKILL_ID";
	$stmt = $conn->prepare($strSQL);
	$stmt->bind_param("s", $sskill_id);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result;
}

function get_detail($detail_id){
	include('../config/connection.php');
	$strSQL = "SELECT * FROM tbl_item_detail WHERE DETAIL_ID = ? group by DETAIL_ID";
	$stmt = $conn->prepare($strSQL);
	$stmt->bind_param("s", $detail_id);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result;
}

function get_answers($question_id){
	include('../config/connection.php');
	$strSQL = "SELECT * FROM tbl_answers WHERE QUESTIONS_ID = ?";
	$stmt = $conn->prepare($strSQL);
	$stmt->bind_param("s", $question_id);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result;
}

function get_description($question_id){
	include('../config/connection.php');
	$strSQL = "SELECT * FROM tbl_description WHERE QUESTIONS_ID = ? ";
	$stmt = $conn->prepare($strSQL);
	$stmt->bind_param("s", $question_id);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result;
}

function get_questions_mapping($question_id){
	include('../config/connection.php');
	$strSQL = "SELECT * FROM tbl_questions_mapping WHERE QUESTIONS_ID = ?";
	$query = $conn->prepare($strSQL);
	$query->bind_param("s", $question_id);
	$query->execute();
	$result = $query->get_result();
	return $result;
}


function get_questions_mapping_where_gquestion($gquestion_id){
	include('../config/connection.php');
	$SQL = "SELECT * FROM tbl_questions_mapping WHERE GQUESTION_ID=? ";
	$stmt = $conn->prepare($SQL);
	$stmt->bind_param("s", $gquestion_id);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result;
}


function get_questions_relate($gquestion_id){
	include('../config/connection.php');
	$strSQL = "SELECT * FROM tbl_gquestion WHERE GQUESTION_ID=?";
	$stmt = $conn->prepare($strSQL);
	$stmt->bind_param("s", $gquestion_id);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result;
}

function get_relate_passage($message){
	$totem_msg = "<font size=2>" . $message . "</font>";
	return $totem_msg;
}

function get_relate_picture($totem_msg){
	$totem_msg = str_replace("/home/engtest/domains/engtest.net/public_html/", "https://www.engtest.net/", $totem_msg);
	$totem_msg = " <img src='" . $totem_msg . "' border=0 width=300> ";
	return $totem_msg;
}

function get_relate_sound($totem_msg){
	$totem_msg = str_replace("/home/engtest/domains/engtest.net/public_html/files/sound/", "", $totem_msg);
	$totem_msg = str_replace(".flv", ".mp3", $totem_msg);
	$totem_msg = "
		<div align=center >
			<audio  controls='controls' preload='auto'>
				<source src=\"https://www.engtest.net/files/sound/$totem_msg\" >
			</audio>
		</div>";
	return $totem_msg;
}

function get_etest($etest_id){
	include('../config/connection.php');
	$SQL = "SELECT * FROM tbl_etest WHERE ETEST_ID = ?";
	$query = $conn->prepare($SQL);
	$query->bind_param("s", $etest_id);
	$query->execute();
	$result = $query->get_result();
	return $result;
}

function delete_data($table, $column , $id){
	include('../config/connection.php');
	$SQL = "DELETE FROM $table WHERE $column = ?";
	$stmt = $conn->prepare($SQL);
	$stmt->bind_param("s", $id);
	$stmt->execute();
	$stmt->close();
}

function update_data($table, $column, $value, $where ,$id){
	include('../config/connection.php');
	$SQL = "UPDATE $table SET $column = ? WHERE $where = ?";
	$query = $conn->prepare($SQL);
	$query->bind_param("ss", $value, $id);
	$query->execute();
	$query->close();
}

function update_answers($text, $correct, $id){
	include('../config/connection.php');
	$SQL = "UPDATE tbl_answers SET ANSWERS_TEXT = ?, ANSWERS_CORRECT = ? WHERE ANSWERS_ID = ?";
	$query = $conn->prepare($SQL);
	$query->bind_param("sss", $text, $correct, $id);
	$query->execute();
}

function insert_answers($question_id, $ans, $correct, $date){
	include('../config/connection.php');
	$strSQL = "INSERT INTO tbl_answers (QUESTIONS_ID,ANSWERS_TEXT,ANSWERS_CORRECT,CREATDATE) VALUES(?,?,?,?)";
	$query = $conn->prepare($strSQL);
	$query->bind_param("ssss", $question_id, $ans, $correct, $date);
	$query->execute();
	$query->close();
}

function get_quiz_status_comment($quiz_id, $status){
	include('../config/connection.php');
	$SQL = "SELECT quiz_id FROM tbl_quiz_comment WHERE quiz_id=? && status=?";
	$query = $conn->prepare($SQL);
	$query->bind_param("ss", $quiz_id,$status);
	$query->execute();
	$result = $query->get_result();
	$num = $result->num_rows;
	$query->close();
	return $num;
}

function monthly_reports(){
	include('../config/connection.php');
	$time_line = 31;
	for($i=1;$i<=$time_line;$i++)
	{
		// $new_now[1][$i] = date("Y-m-d",time() - ( 60 * 60 * 24 * $i ))." 00:00:01";
		// $new_now[2][$i] = date("Y-m-d",time() - ( 60 * 60 * 24 * $i ))." 23:59:59";
		$now[$i] = date("Y-m-d",time() - ( 60 * 60 * 24 * $i ) - ( 60 * 60 * 24 * 1 ));
		// $now[$i] = date("Y-m-d",time() - ( 60 * 60 * 24 * $i ) - ( 60 * 60 * 24 * 6 ));
		$new_now[1][$i] = date("Y-m-d",time() - ( 60 * 60 * 24 * $i ) - ( 60 * 60 * 24 * 1 ))." 00:00:01";
		$new_now[2][$i] = date("Y-m-d",time() - ( 60 * 60 * 24 * $i ) - ( 60 * 60 * 24 * 1 ))." 23:59:59";
		// echo $new_now[1][$i]." : ".$new_now[2][$i]."<br>";
		//----------------------------------------------------------------------//		
		$SQL = "SELECT result_id FROM tbl_w_result WHERE create_date >= ? && create_date <= ? order by create_date";
		$query = $conn->prepare($SQL);
		$query->bind_param("ss", $new_now[1][$i], $new_now[2][$i]);
		$query->execute();
		$result = $query->get_result();
		$num = $result->num_rows;
		$all_test[$i] = $num;
		$query->close();
			
		//----------------------------------------------------------------------//	
		$strSQL = "SELECT result_id FROM tbl_w_result WHERE create_date >= ? && create_date <= ? && level_id >= 1 && skill_id >= 1 && etest_id = 0 order by create_date";
		$stmt = $conn->prepare($strSQL);
		$stmt->bind_param("ss", $new_now[1][$i], $new_now[2][$i]);
		$stmt->execute();
		$result = $stmt->get_result();
		$num = $result->num_rows;
		$evaluation[$i] = $num;
		$stmt->close();

		//----------------------------------------------------------------------//	
		$SQL = "SELECT result_id FROM tbl_w_result WHERE create_date >= ? && create_date <= ? && level_id = 0 && skill_id = 0 && etest_id > 1 order by create_date";
		$query = $conn->prepare($SQL);
		$query->bind_param("ss", $new_now[1][$i], $new_now[2][$i]);
		$query->execute();
		$result = $query->get_result();
		$num = $result->num_rows;
		$contest[$i] = $num;
		$query->close();
		
		
		//----------------------------------------------------------------------//		
		$strSQL = "SELECT result_id FROM tbl_w_result WHERE create_date >= ? && create_date <= ? group by member_id order by create_date";
		$stmt = $conn->prepare($strSQL);
		$stmt->bind_param("ss", $new_now[1][$i], $new_now[2][$i]);
		$stmt->execute();
		$result = $stmt->get_result();	
		$num = $result->num_rows;
		$all_mem[$i] = $num;
		$stmt->close();
		//----------------------------------------------------------------------//
		// if($all_test[$i]>$max_a)	{	$max_a = $all_test[$i];	}
		// if($evaluation[$i]>$max_b)	{	$max_b = $evaluation[$i];	}
		// if($contest[$i]>$max_c)		{	$max_c = $contest[$i];	}
		// if($all_mem[$i]>$max_d)		{	$max_d = $all_mem[$i];	}
	}
	//------------------------------ Detail -----------------------------------//
	echo "	<br><br>
			<table align=center width=75% cellpadding=0 cellspacing=0 border=1 style='margin: 0 auto;' class='f-thai'>
				<tr bgcolor='#e0e0e0' height=25>
					<td width=20% align=center ><font size=2 color=black><b>Date</b></font></td>
					<td width=20% align=center ><font size=2 color=brown><b>all Test (ครั้ง)</b></font></td>
					<td width=20% align=center ><font size=2 color=blue><b>Evaluation Test (ครั้ง)</b></font></td>
					<td width=20% align=center ><font size=2 color=red><b>EOL Contest (ครั้ง)</b></font></td>
					<td width=20% align=center ><font size=2 color=green><b>Member (คน)</b></font></td>
				</tr>";
				
	for($i=1;$i<=$time_line;$i++)
	{
		echo "
				<tr  height=25>
					<td width=20% align=center ><font size=2 color=black>$now[$i]</font></td>
					<td width=20% align=center ><font size=2 color=brown>$all_test[$i]</font></td>
					<td width=20% align=center ><font size=2 color=blue>$evaluation[$i]</font></td>
					<td width=20% align=center ><font size=2 color=red>$contest[$i]</font></td>
					<td width=20% align=center ><font size=2 color=green>$all_mem[$i]</font></td>
				</tr>";
	}
	echo "</table>";
}

function export_report_gepot_to_excel(){
	include('../config/connection.php');
	include('../config/format_time.php');
	$username = $_POST['username'] ? $_POST['username'] : '';
	$start_username = $_POST['start_username'] ? $_POST['start_username'] : '';
	$end_username = $_POST['end_username'] ? $_POST['end_username'] : '';
	echo "  <br><br>
        <table align=center width=40% bgcolor='#f0f0f0' cellpadding=0 cellspacing=0 border=1 style='margin: 0 auto;' class='f-thai'> 
            <form method=post action='?section=$_GET[section]&&status=17' accept-charset='UTF-8' align='center' style='height:30px;padding:5px;background:#f0f0f0;'>
                <tr height=20 valign=middle>
                    <td width=8% align=center><input type='text' name='username' placeholder='Username' value='$username' required></td>
                    <td width=3% align=center><input name='view_id' type='submit' value='Search' class='btn-set-relate'></td>
               </tr>
            </form>
        </table>"; 
    echo "<br>";
    echo "
        <table align=center width=72% bgcolor='#f0f0f0' cellpadding=0 cellspacing=0 border=1 style='margin: 0 auto;' class='f-thai'>
            <form method=post action='?section=$_GET[section]&&status=17' accept-charset='UTF-8' align='center' style='height:30px;padding:5px;background:#f0f0f0;'>
                <tr height=50 valign=middle>
                    <td align=center width=13%><font size=2 color=black><b>From &nbsp; : &nbsp;</b></font></td>
                    <td width=10% align=center><input type='text' name='start_username' value='$start_username' placeholder='Username' required></td>
                    <td align=center width=13%><font size=2 color=black><b>Until &nbsp; : &nbsp;</b></font></td>
                    <td width=10% align=center><input type='text' name='end_username' value='$end_username' placeholder='Username' required></td>
                    <td width=3% align=center><input name='view_from_util' type='submit' value='Search' class='btn-set-relate'></td>
               </tr>
            </form>
        </table><br>"; 

        if($_POST['view_id'] && $_POST['username']){
			$username = trim($_POST['username']);
			$strSQL = "SELECT member_id FROM tbl_x_member_general WHERE user LIKE '%$username%' ";
			$stmt = $conn->prepare($strSQL);
			$stmt->execute();
			$result = $stmt->get_result();
			$num = $result->num_rows;
			if($num){
				$data = $result->fetch_array();
				$focus_member_id = trim($data['member_id']);
			}
			$stmt->close();
            //-----------------------------------------------------------------------------//
			$strSQL = "SELECT * FROM tbl_w_result_gepot WHERE member_id = ? order by percent DESC";
			$stmt = $conn->prepare($strSQL);
			$stmt->bind_param("s", $focus_member_id);
			$stmt->execute();
			$result = $stmt->get_result();
			$num = $result->num_rows;
            if($num==1 || $num >= 1)
            {
				echo "
				<table align=center width=14% cellspacing=2 border=0 style='margin: 0 auto;' class='f-thai'>
					<tr>
						<td width=7%>
							<form method='post' action='../2010/export_full_report_gepot_to_excel.php' accept-charset='UTF-8' align='center'>
								<input type='hidden' name='member_id' value='$focus_member_id'>
								<input type='submit' value='Full Export' class='btn-add'>
							  </form>
						</td>
						<td width=7%>
							<form method='post' action='../2010/export_summary_report_gepot_to_excel.php' accept-charset='UTF-8' align='center'>
								<input type='hidden' name='member_id' value='$focus_member_id'>
								<input type='submit' value='Summary Export' class='btn-add'>
							  </form>
						</td>
					</tr>
				</table>";
                $result_data = $result->fetch_array();		
                //-----------------------------------------------------------------------------//
                $result_id = $result_data['result_id'];
				$member_id = $result_data['member_id'];
				$etest_id = $result_data['etest_id'];
				$percent = $result_data['percent'];
				$correct = $result_data['correct'];
				$wrong = $result_data['wrong'];
				$correct_listening = $result_data['correct_listening'];
				$wrong_listening = $result_data['wrong_listening'];
				$correct_reading = $result_data['correct_reading'];
				$wrong_reading = $result_data['wrong_reading'];
				$correct_grammar = $result_data['correct_grammar'];
				$wrong_grammar = $result_data['wrong_grammar'];
				$create_date = $result_data['create_date'];
                //-----------------------------------------------------------------------------//
                $arr_date_time = explode(" ",$create_date);		
                $msg_date = get_thai_day($arr_date_time[0])." &nbsp; ".get_thai_month($arr_date_time[0])." &nbsp; ".get_thai_year($arr_date_time[0])." &nbsp; 
                            &nbsp; เวลา ".$arr_date_time[1]." น. ";
                //-------------------------------------//
				$SQL = "SELECT * FROM tbl_x_member_general WHERE member_id = ?";
				$query = $conn->prepare($SQL);
				$query->bind_param("s", $focus_member_id);
				$query->execute();
				$result_member = $query->get_result();
				$data = $result_member->fetch_array();		
				$fname = $data['fname'];		
				$lname = $data['lname'];
                $gender = $data['gender'];
                //-------------------------------------------------------------------------------//
				$unans = (100 - ($correct + $wrong));
				$unans_lestening = (30 - ($correct_listening + $wrong_listening));
				$unans_reading = (40 - ($correct_reading + $wrong_reading));
				$unans_grammar = (30 - ($correct_grammar + $wrong_grammar));
				
				echo "
					<table align=center width=90% cellpadding=5 cellspacing=0 border=0 bgcolor='#f7f7f7' style='margin: 0 auto;' class='f-thai'>
						<tr height=25>
						<center><img src='../images/image2/gepot/GEPOT-4.webp' style='width:90%; margin-top:20px;border-radius:10px;'><br><br></center>
							<td width=20% align=right><font size=2 color=black><b>ผู้ทำแบบทดสอบ &nbsp; : &nbsp; </b></font></td>
							<td width=70% align=left colspan=3><font size=2 color=black><b>&nbsp; $fname &nbsp; &nbsp; $lname </b></font></td>
						</tr>
						<tr  height=25>
							<td align=right><font size=2 color=black><b>วันที่ทำการทดสอบ &nbsp; : &nbsp; </b></font></td>
							<td align=left ><font size=2 color=black><b>&nbsp; $msg_date </b></font></td>
						</tr>
						<tr  height=25>
							<td align=right><font size=2 color=black><b>
										ประเภทการทดสอบ &nbsp; : &nbsp;</b></font></td>
							<td align=left >
								<font size=2 color=black><b>
											&nbsp; General English Proficiency Online Test
								</b></font>
							</td>
						</tr>
						<tr  height=25>
							<td align=right><font size=2 color=black><b>คะแนนที่ได้ &nbsp; : &nbsp; </b></font></td>
							<td align=left >
								<font size=2 color=black><b>
										&nbsp; ตอบถูก $correct ข้อ &nbsp; &nbsp; ตอบผิด $wrong ข้อ &nbsp; &nbsp; ไม่ได้ตอบ $unans ข้อ &nbsp; &nbsp; คิดเป็น $percent %
								</b></font>
							</td>
						</tr>
					</table><br>";
				
				$text_msg[0] = "<font color=red>ไม่สามารถประเมินได้</font>";
				$text_msg[1] = "<font color=brown>พอใช้ ( Low )</font>";
				$text_msg[2] = "<font color=green>ปานกลาง ( Intermediate )</font>";
				$text_msg[3] = "<font color=blue>สูง ( High )</font>";
				
				$each_percent[1] = (($correct_listening + 0) - ($wrong_listening * 0.25)) + 0;
				$each_percent[2] = (($correct_reading + 0) - ($wrong_reading * 0.25)) + 0;
				$each_percent[3] = (($correct_grammar + 0) - ($wrong_grammar * 0.25)) + 0;
				
				if($each_percent[1]<=0)							    {	$skill_msg[1] = $text_msg[0]; 	}
				if($each_percent[1]>0&&$each_percent[1]<=10.75)	    {	$skill_msg[1] = $text_msg[1]; 	}
				if($each_percent[1]>10.75&&$each_percent[1]<=20.75)	{	$skill_msg[1] = $text_msg[2]; 	}
				if($each_percent[1]>20.75)							{	$skill_msg[1] = $text_msg[3]; 	}
				//------------------------------------------------------//
				if($each_percent[2]<=0)							    {	$skill_msg[2] = $text_msg[0]; 	}
				if($each_percent[2]>0&&$each_percent[2]<=14.75)	    {	$skill_msg[2] = $text_msg[1]; 	}
				if($each_percent[2]>14.75&&$each_percent[2]<=29.75)	{	$skill_msg[2] = $text_msg[2]; 	}
				if($each_percent[2]>29.75)							{	$skill_msg[2] = $text_msg[3]; 	}
				//------------------------------------------------------//
				if($each_percent[3]<=0)							    {	$skill_msg[3] = $text_msg[0]; 	}
				if($each_percent[3]>0&&$each_percent[3]<=10.75)	    {	$skill_msg[3] = $text_msg[1]; 	}
				if($each_percent[3]>10.75&&$each_percent[3]<=20.75)	{	$skill_msg[3] = $text_msg[2]; 	}
				if($each_percent[3]>20.75)							{	$skill_msg[3] = $text_msg[3]; 	}
                //------------------------------------------------------//
                //-------------- CEFR -----------------//
                $cefr_msg[0] = "<font color=red>A0</font>";
                $cefr_msg[1] = "<font color=red>A1</font>";
                $cefr_msg[2] = "<font color=brown>A2</font>";
                $cefr_msg[3] = "<font color=green>B1</font>";
                $cefr_msg[4] = "<font color=blue>B2</font>";
                $cefr_msg[5] = "<font color=blue>C1</font>";
                $cefr_msg[6] = "<font color=blue>C2</font>";
                    
				if($each_percent[1]<=0)							    {	$cefr_skill[1] = $cefr_msg[0]; 	}
				if($each_percent[1]>0&&$each_percent[1]<=6.75)		{	$cefr_skill[1] = $cefr_msg[1]; 	}
				if($each_percent[1]>6.75&&$each_percent[1]<=12.75)	{	$cefr_skill[1] = $cefr_msg[2]; 	}
				if($each_percent[1]>12.75&&$each_percent[1]<=18.75)	{	$cefr_skill[1] = $cefr_msg[3]; 	}
				if($each_percent[1]>18.75&&$each_percent[1]<=24.75)	{	$cefr_skill[1] = $cefr_msg[4]; 	}
				if($each_percent[1]>24.75&&$each_percent[1]<=29.75) {   $cefr_skill[1] = $cefr_msg[5];  }
				if($each_percent[1]>29.75)							{	$cefr_skill[1] = $cefr_msg[6]; 	}
				//------------------------------------------------------//
				if($each_percent[2]<=0)							    {	$cefr_skill[2] = $cefr_msg[0]; 	}
				if($each_percent[2]>0&&$each_percent[2]<=8.75)	    {	$cefr_skill[2] = $cefr_msg[1]; 	}
				if($each_percent[2]>8.75&&$each_percent[2]<=16.75)	{	$cefr_skill[2] = $cefr_msg[2]; 	}
				if($each_percent[2]>16.75&&$each_percent[2]<=24.75)	{	$cefr_skill[2] = $cefr_msg[3]; 	}
				if($each_percent[2]>24.75&&$each_percent[2]<=32.75)	{	$cefr_skill[2] = $cefr_msg[4]; 	}
				if($each_percent[2]>32.75&&$each_percent[2]<=39.75)	{	$cefr_skill[2] = $cefr_msg[5]; 	}
				if($each_percent[2]>39.75)							{	$cefr_skill[2] = $cefr_msg[6]; 	}
				//------------------------------------------------------//
				if($each_percent[3]<=0)							    {	$cefr_skill[3] = $cefr_msg[0]; 	}
				if($each_percent[3]>0&&$each_percent[3]<=6.75)		{	$cefr_skill[3] = $cefr_msg[1]; 	}
				if($each_percent[3]>6.75&&$each_percent[3]<=12.75)	{	$cefr_skill[3] = $cefr_msg[2]; 	}
				if($each_percent[3]>12.75&&$each_percent[3]<=18.75)	{	$cefr_skill[3] = $cefr_msg[3]; 	}
				if($each_percent[3]>18.75&&$each_percent[3]<=24.75)	{	$cefr_skill[3] = $cefr_msg[4]; 	}
				if($each_percent[3]>24.75&&$each_percent[3]<=29.75)	{	$cefr_skill[3] = $cefr_msg[5]; 	}
				if($each_percent[3]>29.75)							{	$cefr_skill[3] = $cefr_msg[6]; 	}
                
				echo "
					<table align=center width=90% cellpadding=5 cellspacing=2 border=0 style='margin: 0 auto;' class='f-thai'>
						<tr height=25 >
							<td align=center width=20% bgcolor='#aaaaaa'><font size=2 color='#ffffff'><b>ทักษะ ( Skill )</b></font></td>
							<td align=center width=45% bgcolor='#aaaaaa' colspan=3><font size=2 color='#ffffff'><b>คะแนน ( Score )</b></font></td>
							<td align=center bgcolor='#aaaaaa'><font size=2 color='#ffffff'><b>ระดับความสามารถ ( Level )</b></font></td>
							<td align=center bgcolor='#aaaaaa'><font size=2 color='#ffffff'><b>CEFR</b></font></td>
						</tr>
						<tr height=25 >
							<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2><b>การฟัง ( Listening )</b></font></td>
							<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบถูก ".($correct_listening+0)." ข้อ </font></td>
							<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบผิด ".($wrong_listening+0)." ข้อ </font></td>
							<td align=center bgcolor='#e0e0e0'><font size=2 >ไม่ได้ตอบ ".($unans_lestening+0)." ข้อ </font></td>
							<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$skill_msg[1]</font></td>
							<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$cefr_skill[1]</font></td>
						</tr>
						<tr height=25>
							<td align=center bgcolor='#e0e0e0' colspan=3><font size=2 >
								<b>คิดเป็น ".(round($each_percent[1],2)+0)." / ".($correct_listening+$wrong_listening+$unans_lestening+0)." คะแนน </b>
							</font></td>
						</tr>
						<tr height=25 >
							<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2><b>การอ่าน ( Reading )</b></font></td>
							<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบถูก ".($correct_reading+0)." ข้อ </font></td>
							<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบผิด ".($wrong_reading+0)." ข้อ </font></td>
							<td align=center bgcolor='#e0e0e0'><font size=2 >ไม่ได้ตอบ ".($unans_reading+0)." ข้อ </font></td>
							<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$skill_msg[2]</font></td>
							<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$cefr_skill[2]</font></td>
						</tr>
						<tr height=25>
							<td align=center bgcolor='#e0e0e0' colspan=3><font size=2 >
								<b>คิดเป็น ".(round($each_percent[2],2)+0)." / ".($correct_reading+$wrong_reading+$unans_reading+0)." คะแนน </b>
							</font></td>
						</tr>
						<tr height=25 >
							<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2><b>ไวยากรณ์ ( Grammar )</b></font></td>
							<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบถูก ".(($correct_grammar)+0)." ข้อ </font></td>
							<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบผิด ".(($wrong_grammar)+0)." ข้อ </font></td>
							<td align=center bgcolor='#e0e0e0'><font size=2 >ไม่ได้ตอบ ".(($unans_grammar)+0)." ข้อ </font></td>
							<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$skill_msg[3]</font></td>
							<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$cefr_skill[3]</font></td>
						</tr>
						<tr height=25>
							<td align=center bgcolor='#e0e0e0' colspan=3><font size=2 >
								<b>คิดเป็น ".(round($each_percent[3],2)+0)." / ".($correct_grammar+$wrong_grammar+$unans_grammar+0)." คะแนน </b>
							</font></td>
						</tr>
					</table><br>";
            }
            else{	
                echo "<p align='center'><font size=4 color=red><b> Not found. </b></font></p>";
            }
        }
        if($_POST['view_from_util'] && $_POST['start_username'] && $_POST['end_username'])
        {
            $start =  trim($_POST['start_username']);
			$end = trim($_POST['end_username']);
			$strSQL = "SELECT DISTINCT member_id FROM tbl_x_member_general WHERE user BETWEEN '$start' AND '$end' ORDER BY member_id ASC";
			$stmt = $conn->prepare($strSQL);
			$stmt->execute();
			$result = $stmt->get_result();
			$num = $result->num_rows;
			if($num >= 1){
				echo "<table align=center width=14% cellspacing=2 border=0 style='margin: 0 auto;' class='f-thai'>
						<tr>
							<td width=7%>
								<form method='post' action='../2010/export_full_report_gepot_to_excel.php' accept-charset='UTF-8' align='center'>
									<input type='hidden' name='start_username' value='$start'>
									<input type='hidden' name='end_username' value='$end'>
									<input type='submit' value='Full Export' class='btn-add'>
								</form></td>
							<td width=7%>
								<form method='post' action='../2010/export_summary_report_gepot_to_excel.php' accept-charset='UTF-8' align='center'>
									<input type='hidden' name='start_username' value='$start'>
									<input type='hidden' name='end_username' value='$end'>
									<input type='submit' value='Summary Export' class='btn-add'>
								</form>
							</td>
						</tr>
					  </table>";
					  
				$j = 1;
				while($row = $result->fetch_assoc()) {
					$temp_id[$j] = $row['member_id'];
					$j++;  
				}
				for($x=1;$x<=$num;$x++){
					$id = trim($temp_id[$x]);
					$SQL = "SELECT * FROM tbl_w_result_gepot WHERE member_id = ? order by percent DESC";
					$query = $conn->prepare($SQL);
					$query->bind_param("s", $id);
					$query->execute();
					$result_general = $query->get_result();
					$result_data = $result_general->fetch_array();	
					//-----------------------------------------------------------------------------//
					$result_id = $result_data['result_id'];
					$member_id = $result_data['member_id'];
					$etest_id = $result_data['etest_id'];
					$percent = $result_data['percent'];
					$correct = $result_data['correct'];
					$wrong = $result_data['wrong'];
					$correct_listening = $result_data['correct_listening'];
					$wrong_listening = $result_data['wrong_listening'];
					$correct_reading = $result_data['correct_reading'];
					$wrong_reading = $result_data['wrong_reading'];
					$correct_grammar = $result_data['correct_grammar'];
					$wrong_grammar = $result_data['wrong_grammar'];
					$create_date = $result_data['create_date'];
					//-----------------------------------------------------------------------------//
					$arr_date_time = explode(" ",$create_date);		
					$msg_date = get_thai_day($arr_date_time[0])." &nbsp; ".get_thai_month($arr_date_time[0])." &nbsp; ".get_thai_year($arr_date_time[0])." &nbsp; &nbsp; เวลา ".$arr_date_time[1]." น. ";
					//-------------------------------------//
					$SQL = "SELECT * FROM tbl_x_member_general WHERE member_id = ?";
					$query_member = $conn->prepare($SQL);
					$query_member->bind_param("s", $id);
					$query_member->execute();
					$result_member = $query_member->get_result();
					$data = $result_member->fetch_array();			
					$fname = $data['fname'];		
					$lname = $data['lname'];
					//-------------------------------------------------------------------------------//
					$unans = (100 - ($correct + $wrong));
					$unans_lestening = (30 - ($correct_listening + $wrong_listening));
					$unans_reading = (40 - ($correct_reading + $wrong_reading));
					$unans_grammar = (30 - ($correct_grammar + $wrong_grammar));
						
					//---------------------------------------------------------------------------------------//
					echo "
						<table align=center width=90% cellpadding=5 cellspacing=0 border=0 bgcolor='#f7f7f7' style='margin: 0 auto;' class='f-thai'>
							<tr height=25>
								<td width=2% align=right><font size=2 color=black><b>$x</b></font></td>
								<td width=20% align=right><font size=2 color=black><b>ผู้ทำแบบทดสอบ &nbsp; : &nbsp; </b></font></td>
								<td width=70% align=left colspan=3><font size=2 color=black><b>&nbsp; $fname &nbsp; &nbsp; $lname </b></font></td>
							</tr>
							<tr  height=25>
								<td></td>
								<td align=right><font size=2 color=black><b>วันที่ทำการทดสอบ &nbsp; : &nbsp; </b></font></td>
								<td align=left ><font size=2 color=black><b>&nbsp; $msg_date </b></font></td>
							</tr>
							<tr  height=25>
								<td></td>
								<td align=right><font size=2 color=black><b>
										ประเภทการทดสอบ &nbsp; : &nbsp;</b></font></td>
								<td align=left >
									<font size=2 color=black><b>
											&nbsp; General English Proficiency Online Test
									</b></font>
								</td>
							</tr>
							<tr  height=25>
								<td></td>
								<td align=right><font size=2 color=black><b>คะแนนที่ได้ &nbsp; : &nbsp; </b></font></td>
								<td align=left >
									<font size=2 color=black><b>
										&nbsp; ตอบถูก $correct ข้อ &nbsp; &nbsp; ตอบผิด $wrong ข้อ &nbsp; &nbsp; ไม่ได้ตอบ $unans ข้อ &nbsp; &nbsp; คิดเป็น $percent %
									</b></font>
								</td>
							</tr>
						</table>";
					//------------------------------------------------------//
					//------------------------------------------------------//
					$text_msg[0] = "<font color=red>ไม่สามารถประเมินได้</font>";
					$text_msg[1] = "<font color=brown>พอใช้ ( Low )</font>";
					$text_msg[2] = "<font color=green>ปานกลาง ( Intermediate )</font>";
					$text_msg[3] = "<font color=blue>สูง ( High )</font>";
			
					$each_percent[1] = (($correct_listening + 0) - ($wrong_listening * 0.25))+0;
					$each_percent[2] = (($correct_reading + 0) - ($wrong_reading * 0.25))+0;
					$each_percent[3] = (($correct_grammar + 0) - ($wrong_grammar * 0.25))+0;
						
					if($each_percent[1]<=0)							    {	$skill_msg[1] = $text_msg[0]; 	}
					if($each_percent[1]>0&&$each_percent[1]<=10.75)	    {	$skill_msg[1] = $text_msg[1]; 	}
					if($each_percent[1]>10.75&&$each_percent[1]<=20.75)	{	$skill_msg[1] = $text_msg[2]; 	}
					if($each_percent[1]>20.75)							{	$skill_msg[1] = $text_msg[3]; 	}
					//------------------------------------------------------//
					if($each_percent[2]<=0)							    {	$skill_msg[2] = $text_msg[0]; 	}
					if($each_percent[2]>0&&$each_percent[2]<=14.75)	    {	$skill_msg[2] = $text_msg[1]; 	}
					if($each_percent[2]>14.75&&$each_percent[2]<=29.75)	{	$skill_msg[2] = $text_msg[2]; 	}
					if($each_percent[2]>29.75)							{	$skill_msg[2] = $text_msg[3]; 	}
					//------------------------------------------------------//
					if($each_percent[3]<=0)							    {	$skill_msg[3] = $text_msg[0]; 	}
					if($each_percent[3]>0&&$each_percent[3]<=10.75)	    {	$skill_msg[3] = $text_msg[1]; 	}
					if($each_percent[3]>10.75&&$each_percent[3]<=20.75)	{	$skill_msg[3] = $text_msg[2]; 	}
					if($each_percent[3]>20.75)							{	$skill_msg[3] = $text_msg[3]; 	}
					//------------------------------------------------------//
					//-------------- CEFR -----------------//
					$cefr_msg[0] = "<font color=red>A0</font>";
					$cefr_msg[1] = "<font color=red>A1</font>";
					$cefr_msg[2] = "<font color=brown>A2</font>";
					$cefr_msg[3] = "<font color=green>B1</font>";
					$cefr_msg[4] = "<font color=blue>B2</font>";
					$cefr_msg[5] = "<font color=blue>C1</font>";
					$cefr_msg[6] = "<font color=blue>C2</font>";
						
					if($each_percent[1]<=0)							    {	$cefr_skill[1] = $cefr_msg[0]; 	}
					if($each_percent[1]>0&&$each_percent[1]<=6.75)		{	$cefr_skill[1] = $cefr_msg[1]; 	}
					if($each_percent[1]>6.75&&$each_percent[1]<=12.75)	{	$cefr_skill[1] = $cefr_msg[2]; 	}
					if($each_percent[1]>12.75&&$each_percent[1]<=18.75)	{	$cefr_skill[1] = $cefr_msg[3]; 	}
					if($each_percent[1]>18.75&&$each_percent[1]<=24.75)	{	$cefr_skill[1] = $cefr_msg[4]; 	}
					if($each_percent[1]>24.75&&$each_percent[1]<=29.75) {   $cefr_skill[1] = $cefr_msg[5];  }
					if($each_percent[1]>29.75)							{	$cefr_skill[1] = $cefr_msg[6]; 	}
					//------------------------------------------------------//
					if($each_percent[2]<=0)							    {	$cefr_skill[2] = $cefr_msg[0]; 	}
					if($each_percent[2]>0&&$each_percent[2]<=8.75)	    {	$cefr_skill[2] = $cefr_msg[1]; 	}
					if($each_percent[2]>8.75&&$each_percent[2]<=16.75)	{	$cefr_skill[2] = $cefr_msg[2]; 	}
					if($each_percent[2]>16.75&&$each_percent[2]<=24.75)	{	$cefr_skill[2] = $cefr_msg[3]; 	}
					if($each_percent[2]>24.75&&$each_percent[2]<=32.75)	{	$cefr_skill[2] = $cefr_msg[4]; 	}
					if($each_percent[2]>32.75&&$each_percent[2]<=39.75)	{	$cefr_skill[2] = $cefr_msg[5]; 	}
					if($each_percent[2]>39.75)							{	$cefr_skill[2] = $cefr_msg[6]; 	}
					//------------------------------------------------------//
					if($each_percent[3]<=0)							    {	$cefr_skill[3] = $cefr_msg[0]; 	}
					if($each_percent[3]>0&&$each_percent[3]<=6.75)		{	$cefr_skill[3] = $cefr_msg[1]; 	}
					if($each_percent[3]>6.75&&$each_percent[3]<=12.75)	{	$cefr_skill[3] = $cefr_msg[2]; 	}
					if($each_percent[3]>12.75&&$each_percent[3]<=18.75)	{	$cefr_skill[3] = $cefr_msg[3]; 	}
					if($each_percent[3]>18.75&&$each_percent[3]<=24.75)	{	$cefr_skill[3] = $cefr_msg[4]; 	}
					if($each_percent[3]>24.75&&$each_percent[3]<=29.75)	{	$cefr_skill[3] = $cefr_msg[5]; 	}
					if($each_percent[3]>29.75)							{	$cefr_skill[3] = $cefr_msg[6]; 	}
						
					echo "
						<table align=center width=90% cellpadding=5 cellspacing=2 border=0 style='margin: 0 auto;' class='f-thai'>
							<tr height=25 >
								<td align=center width=20% bgcolor='#aaaaaa'><font size=2 color='#ffffff'><b>ทักษะ ( Skill )</b></font></td>
								<td align=center width=45% bgcolor='#aaaaaa' colspan=3><font size=2 color='#ffffff'><b>คะแนน ( Score )</b></font></td>
								<td align=center bgcolor='#aaaaaa'><font size=2 color='#ffffff'><b>ระดับความสามารถ ( Level )</b></font></td>
								<td align=center bgcolor='#aaaaaa'><font size=2 color='#ffffff'><b>CEFR</b></font></td>
							</tr>
							<tr height=25 >
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2><b>การฟัง ( Listening )</b></font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบถูก ".($correct_listening+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบผิด ".($wrong_listening+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 >ไม่ได้ตอบ ".($unans_lestening+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$skill_msg[1]</font></td>
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$cefr_skill[1]</font></td>
							</tr>
							<tr height=25>
								<td align=center bgcolor='#e0e0e0' colspan=3><font size=2 >
										<b>คิดเป็น ".(round($each_percent[1],2)+0)." / ".($correct_listening+$wrong_listening+$unans_lestening+0)." คะแนน </b>
								</font></td>
							</tr>
							<tr height=25 >
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2><b>การอ่าน ( Reading )</b></font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบถูก ".($correct_reading+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบผิด ".($wrong_reading+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 >ไม่ได้ตอบ ".($unans_reading+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$skill_msg[2]</font></td>
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$cefr_skill[2]</font></td>
							</tr>
							<tr height=25>
								<td align=center bgcolor='#e0e0e0' colspan=3><font size=2 >
										<b>คิดเป็น ".(round($each_percent[2],2)+0)." / ".($correct_reading+$wrong_reading+$unans_reading+0)." คะแนน </b>
								</font></td>
							</tr>
							<tr height=25 >
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2><b>ไวยากรณ์ ( Grammar )</b></font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบถูก ".(($correct_grammar)+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบผิด ".(($wrong_grammar)+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 >ไม่ได้ตอบ ".(($unans_grammar)+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$skill_msg[3]</font></td>
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$cefr_skill[3]</font></td>
							</tr>
							<tr height=25>
								<td align=center bgcolor='#e0e0e0' colspan=3><font size=2 >
										<b>คิดเป็น ".(round($each_percent[3],2)+0)." / ".($correct_grammar+$wrong_grammar+$unans_grammar+0)." คะแนน </b>
								</font></td>
							</tr>
						</table><br>";		
				}
			}
			else{	
                echo "<p align='center'><font size=4 color=red><b> Not found. </b></font></p>";
            }
        }
}


function export_report_gepot_to_pdf(){
	include('../config/connection.php');
	include('../config/format_time.php');
	$username = $_POST['username'] ? $_POST['username'] : '';
	$start_username = $_POST['start_username'] ? $_POST['start_username'] : '';
	$end_username = $_POST['end_username'] ? $_POST['end_username'] : '';
	echo "<br><br>
        <table align=center width=40% bgcolor='#f0f0f0' cellpadding=0 cellspacing=0 border=1 style='margin: 0 auto;' class='f-thai'>
            <form method=post action='?section=$_GET[section]&&status=18' accept-charset='UTF-8' align='center' style='height:30px;padding:5px;background:#f0f0f0;'>
                <tr height=20 valign=middle>
                    <td width=8% align=center><input type='text' name='username' value='$username' placeholder='Username' required></td>
                    <td width=3% align=center><input name='view_id' type='submit' value='Search' class='btn-set-relate'></td>
               </tr>
            </form>
        </table><br>"; 
    echo "
        <table align=center width=72% bgcolor='#f0f0f0' cellpadding=0 cellspacing=0 border=1 style='margin: 0 auto;' class='f-thai'>
            <form method=post action='?section=$_GET[section]&&status=18' accept-charset='UTF-8' align='center' style='height:30px;padding:5px;background:#f0f0f0;'>
                <tr height=50 valign=middle>
                    <td align=center width=11%><font size=2 color=black><b>From &nbsp; : &nbsp;</b></font></td>
                    <td width=10% align=center><input type='text' name='start_username' value='$start_username' placeholder='Username' required></td>
                    <td align=center width=10%><font size=2 color=black><b>Until &nbsp; : &nbsp;</b></font></td>
                    <td width=10% align=center><input type='text' name='end_username' value='$end_username' placeholder='Username' required></td>
                    <td width=3% align=center><input name='view_from_util' type='submit' value='Search' class='btn-set-relate'></td>
               </tr>
            </form>
		</table><br>"; 
		
	if($_POST['view_id'] && $_POST['username']){
		$username = trim($_POST['username']);
		$strSQL = "SELECT member_id FROM tbl_x_member_general WHERE user LIKE '%$username%' ";
		$stmt = $conn->prepare($strSQL);
		$stmt->execute();
		$result = $stmt->get_result();
		$num = $result->num_rows;
		if($num){
			$data = $result->fetch_array();
			$focus_member_id = trim($data['member_id']);
		}
		$stmt->close();
        //-----------------------------------------------------------------------------//
		$strSQL = "SELECT * FROM tbl_w_result_gepot WHERE member_id = ? order by percent DESC";
		$stmt = $conn->prepare($strSQL);
		$stmt->bind_param("s", $focus_member_id);
		$stmt->execute();
		$result = $stmt->get_result();	
		$num = $result->num_rows;
		if($num==1)
		{
			echo "
			<table align=center width=14% cellspacing=2 border=0 style='margin: 0 auto;' class='f-thai'>
				<tr>
					<td width=7%>
						<form method='post' action='../2010/export_report_gepot_to_pdf.php' accept-charset='UTF-8' align='center' target='_blank'>
							<input type='hidden' name='member_id' value='$focus_member_id'>
							<input type='submit' value='Export To PDF' class='btn-add'>
						  </form>
					</td>
				</tr>
			</table>";
			$result_data =$result->fetch_array();
			//-----------------------------------------------------------------------------//
			$result_id = $result_data['result_id'];
			$member_id = $result_data['member_id'];
			$etest_id = $result_data['etest_id'];
			$percent = $result_data['percent'];
			$correct = $result_data['correct'];
			$wrong = $result_data['wrong'];
			$correct_listening = $result_data['correct_listening'];
			$wrong_listening = $result_data['wrong_listening'];
			$correct_reading = $result_data['correct_reading'];
			$wrong_reading = $result_data['wrong_reading'];
			$correct_grammar = $result_data['correct_grammar'];
			$wrong_grammar = $result_data['wrong_grammar'];
			$create_date = $result_data['create_date'];
			// ----------------------------------- //
			$arr_date_time = explode(" ",$create_date);		
			$msg_date = get_thai_day($arr_date_time[0])." &nbsp; ".get_thai_month($arr_date_time[0])." &nbsp; ".get_thai_year($arr_date_time[0])." &nbsp; 
								&nbsp; เวลา ".$arr_date_time[1]." น. ";
			// ----------------------------------- //
			$SQL = "SELECT * FROM tbl_x_member_general WHERE member_id = ?";
			$query = $conn->prepare($SQL);
			$query->bind_param("s", $focus_member_id);
			$query->execute();
			$result_member = $query->get_result();
			$data = $result_member->fetch_array();		
			$fname = $data['fname'];		
			$lname = $data['lname'];
			$gender = $data['gender'];
			$unans = (100 - ($correct + $wrong));
			$unans_lestening = (30 - ($correct_listening + $wrong_listening));
			$unans_reading = (40 - ($correct_reading + $wrong_reading));
			$unans_grammar = (30 - ($correct_grammar + $wrong_grammar));
						
			//---------------------------------------------------------------------------------------//
			echo "
				<table align=center width=90% cellpadding=5 cellspacing=0 border=0 bgcolor='#f7f7f7' style='margin: 0 auto;' class='f-thai'>
					<tr height=25>
						<td width=20% align=right><font size=2 color=black><b>ผู้ทำแบบทดสอบ &nbsp; : &nbsp; </b></font></td>
						<td width=70% align=left colspan=3><font size=2 color=black><b>&nbsp; $fname &nbsp; &nbsp; $lname </b></font></td>
					</tr>
					<tr  height=25>
						<td align=right><font size=2 color=black><b>วันที่ทำการทดสอบ &nbsp; : &nbsp; </b></font></td>
						<td align=left ><font size=2 color=black><b>&nbsp; $msg_date </b></font></td>
					</tr>
					<tr  height=25>
						<td align=right><font size=2 color=black><b>
							ประเภทการทดสอบ &nbsp; : &nbsp;</b></font></td>
						<td align=left >
							<font size=2 color=black><b>
								&nbsp; General English Proficiency Online Test
							</b></font>
						</td>
					</tr>
					<tr  height=25>
						<td align=right><font size=2 color=black><b>คะแนนที่ได้ &nbsp; : &nbsp; </b></font></td>
						<td align=left >
							<font size=2 color=black><b>
								&nbsp; ตอบถูก $correct ข้อ &nbsp; &nbsp; ตอบผิด $wrong ข้อ &nbsp; &nbsp; ไม่ได้ตอบ $unans ข้อ &nbsp; &nbsp; คิดเป็น $percent %
							</b></font>
						</td>
					</tr>
				</table>";
				//------------------------------------------------------//
				//------------------------------------------------------//
				$text_msg[0] = "<font color=red>ไม่สามารถประเมินได้</font>";
				$text_msg[1] = "<font color=brown>พอใช้ ( Low )</font>";
				$text_msg[2] = "<font color=green>ปานกลาง ( Intermediate )</font>";
				$text_msg[3] = "<font color=blue>สูง ( High )</font>";
			
				$each_percent[1] = (($correct_listening + 0) - ($wrong_listening * 0.25))+0;
				$each_percent[2] = (($correct_reading + 0) - ($wrong_reading * 0.25))+0;
				$each_percent[3] = (($correct_grammar + 0) - ($wrong_grammar * 0.25))+0;
						
				//------------------------------------------------------//
				if($each_percent[1]<=0)							    {	$skill_msg[1] = $text_msg[0]; 	}
				if($each_percent[1]>0&&$each_percent[1]<=10.75)	    {	$skill_msg[1] = $text_msg[1]; 	}
				if($each_percent[1]>10.75&&$each_percent[1]<=20.75)	{	$skill_msg[1] = $text_msg[2]; 	}
				if($each_percent[1]>20.75)							{	$skill_msg[1] = $text_msg[3]; 	}
				//------------------------------------------------------//
				if($each_percent[2]<=0)							    {	$skill_msg[2] = $text_msg[0]; 	}
				if($each_percent[2]>0&&$each_percent[2]<=14.75)	    {	$skill_msg[2] = $text_msg[1]; 	}
				if($each_percent[2]>14.75&&$each_percent[2]<=29.75)	{	$skill_msg[2] = $text_msg[2]; 	}
				if($each_percent[2]>29.75)							{	$skill_msg[2] = $text_msg[3]; 	}
				//------------------------------------------------------//
				if($each_percent[3]<=0)							    {	$skill_msg[3] = $text_msg[0]; 	}
				if($each_percent[3]>0&&$each_percent[3]<=10.75)	    {	$skill_msg[3] = $text_msg[1]; 	}
				if($each_percent[3]>10.75&&$each_percent[3]<=20.75)	{	$skill_msg[3] = $text_msg[2]; 	}
				if($each_percent[3]>20.75)							{	$skill_msg[3] = $text_msg[3]; 	}
				//------------------------------------------------------//
				//-------------- CEFR -----------------//
				$cefr_msg[0] = "<font color=red>A0</font>";
				$cefr_msg[1] = "<font color=red>A1</font>";
				$cefr_msg[2] = "<font color=brown>A2</font>";
				$cefr_msg[3] = "<font color=green>B1</font>";
				$cefr_msg[4] = "<font color=blue>B2</font>";
				$cefr_msg[5] = "<font color=blue>C1</font>";
				$cefr_msg[6] = "<font color=blue>C2</font>";
						
				if($each_percent[1]<=0)							    {	$cefr_skill[1] = $cefr_msg[0]; 	}
				if($each_percent[1]>0&&$each_percent[1]<=6.75)		{	$cefr_skill[1] = $cefr_msg[1]; 	}
				if($each_percent[1]>6.75&&$each_percent[1]<=12.75)	{	$cefr_skill[1] = $cefr_msg[2]; 	}
				if($each_percent[1]>12.75&&$each_percent[1]<=18.75)	{	$cefr_skill[1] = $cefr_msg[3]; 	}
				if($each_percent[1]>18.75&&$each_percent[1]<=24.75)	{	$cefr_skill[1] = $cefr_msg[4]; 	}
				if($each_percent[1]>24.75&&$each_percent[1]<=29.75) {   $cefr_skill[1] = $cefr_msg[5];  }
				if($each_percent[1]>29.75)							{	$cefr_skill[1] = $cefr_msg[6]; 	}
				//------------------------------------------------------//
				if($each_percent[2]<=0)							    {	$cefr_skill[2] = $cefr_msg[0]; 	}
				if($each_percent[2]>0&&$each_percent[2]<=8.75)	    {	$cefr_skill[2] = $cefr_msg[1]; 	}
				if($each_percent[2]>8.75&&$each_percent[2]<=16.75)	{	$cefr_skill[2] = $cefr_msg[2]; 	}
				if($each_percent[2]>16.75&&$each_percent[2]<=24.75)	{	$cefr_skill[2] = $cefr_msg[3]; 	}
				if($each_percent[2]>24.75&&$each_percent[2]<=32.75)	{	$cefr_skill[2] = $cefr_msg[4]; 	}
				if($each_percent[2]>32.75&&$each_percent[2]<=39.75)	{	$cefr_skill[2] = $cefr_msg[5]; 	}
				if($each_percent[2]>39.75)							{	$cefr_skill[2] = $cefr_msg[6]; 	}
				//------------------------------------------------------//
				if($each_percent[3]<=0)							    {	$cefr_skill[3] = $cefr_msg[0]; 	}
				if($each_percent[3]>0&&$each_percent[3]<=6.75)		{	$cefr_skill[3] = $cefr_msg[1]; 	}
				if($each_percent[3]>6.75&&$each_percent[3]<=12.75)	{	$cefr_skill[3] = $cefr_msg[2]; 	}
				if($each_percent[3]>12.75&&$each_percent[3]<=18.75)	{	$cefr_skill[3] = $cefr_msg[3]; 	}
				if($each_percent[3]>18.75&&$each_percent[3]<=24.75)	{	$cefr_skill[3] = $cefr_msg[4]; 	}
				if($each_percent[3]>24.75&&$each_percent[3]<=29.75)	{	$cefr_skill[3] = $cefr_msg[5]; 	}
				if($each_percent[3]>29.75)							{	$cefr_skill[3] = $cefr_msg[6]; 	}
				//-------------------ตารางคะแนนของเก่า-------------------------//
						
				echo "
						<table align=center width=90% cellpadding=5 cellspacing=2 border=0 style='margin: 0 auto;' class='f-thai'>
							<tr height=25 >
								<td align=center width=20% bgcolor='#aaaaaa'><font size=2 color='#ffffff'><b>ทักษะ ( Skill )</b></font></td>
								<td align=center width=45% bgcolor='#aaaaaa' colspan=3><font size=2 color='#ffffff'><b>คะแนน ( Score )</b></font></td>
								<td align=center bgcolor='#aaaaaa'><font size=2 color='#ffffff'><b>ระดับความสามารถ ( Level )</b></font></td>
								<td align=center bgcolor='#aaaaaa'><font size=2 color='#ffffff'><b>CEFR</b></font></td>
							</tr>
							<tr height=25 >
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2><b>การฟัง ( Listening )</b></font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบถูก ".($correct_listening+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบผิด ".($wrong_listening+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 >ไม่ได้ตอบ ".($unans_lestening+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$skill_msg[1]</font></td>
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$cefr_skill[1]</font></td>
							</tr>
							<tr height=25>
								<td align=center bgcolor='#e0e0e0' colspan=3><font size=2 >
									<b>คิดเป็น ".(round($each_percent[1],2)+0)." / ".($correct_listening+$wrong_listening+$unans_lestening+0)." คะแนน </b>
								</font></td>
							</tr>
							<tr height=25 >
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2><b>การอ่าน ( Reading )</b></font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบถูก ".($correct_reading+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบผิด ".($wrong_reading+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 >ไม่ได้ตอบ ".($unans_reading+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$skill_msg[2]</font></td>
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$cefr_skill[2]</font></td>
							</tr>
							<tr height=25>
								<td align=center bgcolor='#e0e0e0' colspan=3><font size=2 >
											<b>คิดเป็น ".(round($each_percent[2],2)+0)." / ".($correct_reading+$wrong_reading+$unans_reading+0)." คะแนน </b>
								</font></td>
							</tr>
							<tr height=25 >
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2><b>ไวยากรณ์ ( Grammar )</b></font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบถูก ".(($correct_grammar)+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบผิด ".(($wrong_grammar)+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 >ไม่ได้ตอบ ".(($unans_grammar)+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$skill_msg[3]</font></td>
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$cefr_skill[3]</font></td>
							</tr>
							<tr height=25>
								<td align=center bgcolor='#e0e0e0' colspan=3><font size=2 >
									<b>คิดเป็น ".(round($each_percent[3],2)+0)." / ".($correct_grammar+$wrong_grammar+$unans_grammar+0)." คะแนน </b>
								</font></td>
							</tr>
						</table><br>
					";
					
				}
				else{	
					echo "<p align='center'><font size=4 color=red><b> Not found. </b></font></p>";
				}
			}
			if($_POST['view_from_util'] && $_POST['start_username'] && $_POST['end_username'])
			{
				$start =  trim($_POST['start_username']);
				$end = trim($_POST['end_username']);
				$strSQL = "SELECT DISTINCT member_id FROM tbl_x_member_general WHERE user BETWEEN '$start' AND '$end' ORDER BY member_id ASC";
				$stmt = $conn->prepare($strSQL);
				$stmt->execute();
				$result = $stmt->get_result();
				$num = $result->num_rows;
				if($num >= 1){
					echo "<table align=center width=14% cellspacing=2 border=0 style='margin: 0 auto;' class='f-thai'>
							<tr>
								<td width=7%>
									<form method='post' action='../2010/export_report_gepot_to_pdf.php' accept-charset='UTF-8' align='center' target='_blank'>
										<input type='hidden' name='start_username' value='$start'>
										<input type='hidden' name='end_username' value='$end'>
										<input type='submit' value='Export To PDF' class='btn-add'>
									</form></td>
							</tr>
						  </table>";
					$j = 1;
					while($row = $result->fetch_assoc()) {
						$temp_id[$j] = $row['member_id'];
						$j++;  
					}
					for($x=1;$x<=$num;$x++){
						$id = trim($temp_id[$x]);	
						$SQL = "SELECT * FROM tbl_w_result_gepot WHERE member_id = ? order by percent DESC";
						$query = $conn->prepare($SQL);
						$query->bind_param("s", $id);
						$query->execute();
						$result_general = $query->get_result();
						$result_data = $result_general->fetch_array();	
						//-----------------------------------------------------------------------------//
						$result_id = $result_data['result_id'];
						$member_id = $result_data['member_id'];
						$etest_id = $result_data['etest_id'];
						$percent = $result_data['percent'];
						$correct = $result_data['correct'];
						$wrong = $result_data['wrong'];
						$correct_listening = $result_data['correct_listening'];
						$wrong_listening = $result_data['wrong_listening'];
						$correct_reading = $result_data['correct_reading'];
						$wrong_reading = $result_data['wrong_reading'];
						$correct_grammar = $result_data['correct_grammar'];
						$wrong_grammar = $result_data['wrong_grammar'];
						$create_date = $result_data['create_date'];
						// ----------------------------------- //
						$arr_date_time = explode(" ",$create_date);		
						$msg_date = get_thai_day($arr_date_time[0])." &nbsp; ".get_thai_month($arr_date_time[0])." &nbsp; ".get_thai_year($arr_date_time[0])." &nbsp; 
									&nbsp; เวลา ".$arr_date_time[1]." น. ";
						// ----------------------------------- //
						$SQL = "SELECT * FROM tbl_x_member_general WHERE member_id = ?";
						$query_member = $conn->prepare($SQL);
						$query_member->bind_param("s", $id);
						$query_member->execute();
						$result_member = $query_member->get_result();
						$data = $result_member->fetch_array();		
						$fname = $data['fname'];		
						$lname = $data['lname'];
						//-------------------------------------------------------------------------------//
						$unans = (100 - ($correct + $wrong));
						$unans_lestening = (30 - ($correct_listening + $wrong_listening));
						$unans_reading = (40 - ($correct_reading + $wrong_reading));
						$unans_grammar = (30 - ($correct_grammar + $wrong_grammar));
							
						//---------------------------------------------------------------------------------------//
						echo "
							<table align=center width=90% cellpadding=5 cellspacing=0 border=0 bgcolor='#f7f7f7' style='margin: 0 auto;' class='f-thai'>
								<tr height=25>
									<td width=2% align=right><font size=2 color=black><b>$x</b></font></td>
									<td width=20% align=right><font size=2 color=black><b>ผู้ทำแบบทดสอบ &nbsp; : &nbsp; </b></font></td>
									<td width=70% align=left colspan=3><font size=2 color=black><b>&nbsp; $fname &nbsp; &nbsp; $lname </b></font></td>
								</tr>
								<tr  height=25>
									<td></td>
									<td align=right><font size=2 color=black><b>วันที่ทำการทดสอบ &nbsp; : &nbsp; </b></font></td>
									<td align=left ><font size=2 color=black><b>&nbsp; $msg_date </b></font></td>
								</tr>
								<tr  height=25>
									<td></td>
									<td align=right><font size=2 color=black><b>
										ประเภทการทดสอบ &nbsp; : &nbsp;</b></font></td>
									<td align=left >
										<font size=2 color=black><b>
											&nbsp; General English Proficiency Online Test
										</b></font>
									</td>
								</tr>
								<tr  height=25>
									<td></td>
									<td align=right><font size=2 color=black><b>คะแนนที่ได้ &nbsp; : &nbsp; </b></font></td>
									<td align=left >
										<font size=2 color=black><b>
											&nbsp; ตอบถูก $correct ข้อ &nbsp; &nbsp; ตอบผิด $wrong ข้อ &nbsp; &nbsp; ไม่ได้ตอบ $unans ข้อ &nbsp; &nbsp; คิดเป็น $percent %
										</b></font>
									</td>
								</tr>
							</table>";
							//------------------------------------------------------//
							$text_msg[0] = "<font color=red>ไม่สามารถประเมินได้</font>";
							$text_msg[1] = "<font color=brown>พอใช้ ( Low )</font>";
							$text_msg[2] = "<font color=green>ปานกลาง ( Intermediate )</font>";
							$text_msg[3] = "<font color=blue>สูง ( High )</font>";
				
							$each_percent[1] = (($correct_listening + 0) - ($wrong_listening * 0.25))+0;
							$each_percent[2] = (($correct_reading + 0) - ($wrong_reading * 0.25))+0;
							$each_percent[3] = (($correct_grammar + 0) - ($wrong_grammar * 0.25))+0;
								
							//------------------------------------------------------//
							if($each_percent[1]<=0)							    {	$skill_msg[1] = $text_msg[0]; 	}
							if($each_percent[1]>0&&$each_percent[1]<=10.75)	    {	$skill_msg[1] = $text_msg[1]; 	}
							if($each_percent[1]>10.75&&$each_percent[1]<=20.75)	{	$skill_msg[1] = $text_msg[2]; 	}
							if($each_percent[1]>20.75)							{	$skill_msg[1] = $text_msg[3]; 	}
							//------------------------------------------------------//
							if($each_percent[2]<=0)							    {	$skill_msg[2] = $text_msg[0]; 	}
							if($each_percent[2]>0&&$each_percent[2]<=14.75)	    {	$skill_msg[2] = $text_msg[1]; 	}
							if($each_percent[2]>14.75&&$each_percent[2]<=29.75)	{	$skill_msg[2] = $text_msg[2]; 	}
							if($each_percent[2]>29.75)							{	$skill_msg[2] = $text_msg[3]; 	}
							//------------------------------------------------------//
							if($each_percent[3]<=0)							    {	$skill_msg[3] = $text_msg[0]; 	}
							if($each_percent[3]>0&&$each_percent[3]<=10.75)	    {	$skill_msg[3] = $text_msg[1]; 	}
							if($each_percent[3]>10.75&&$each_percent[3]<=20.75)	{	$skill_msg[3] = $text_msg[2]; 	}
							if($each_percent[3]>20.75)							{	$skill_msg[3] = $text_msg[3]; 	}
							//------------------------------------------------------//
							//-------------- CEFR -----------------//
							$cefr_msg[0] = "<font color=red>A0</font>";
							$cefr_msg[1] = "<font color=red>A1</font>";
							$cefr_msg[2] = "<font color=brown>A2</font>";
							$cefr_msg[3] = "<font color=green>B1</font>";
							$cefr_msg[4] = "<font color=blue>B2</font>";
							$cefr_msg[5] = "<font color=blue>C1</font>";
							$cefr_msg[6] = "<font color=blue>C2</font>";
							
							if($each_percent[1]<=0)							    {	$cefr_skill[1] = $cefr_msg[0]; 	}
							if($each_percent[1]>0&&$each_percent[1]<=6.75)		{	$cefr_skill[1] = $cefr_msg[1]; 	}
							if($each_percent[1]>6.75&&$each_percent[1]<=12.75)	{	$cefr_skill[1] = $cefr_msg[2]; 	}
							if($each_percent[1]>12.75&&$each_percent[1]<=18.75)	{	$cefr_skill[1] = $cefr_msg[3]; 	}
							if($each_percent[1]>18.75&&$each_percent[1]<=24.75)	{	$cefr_skill[1] = $cefr_msg[4]; 	}
							if($each_percent[1]>24.75&&$each_percent[1]<=29.75) {   $cefr_skill[1] = $cefr_msg[5];  }
							if($each_percent[1]>29.75)							{	$cefr_skill[1] = $cefr_msg[6]; 	}
							//------------------------------------------------------//
							if($each_percent[2]<=0)							    {	$cefr_skill[2] = $cefr_msg[0]; 	}
							if($each_percent[2]>0&&$each_percent[2]<=8.75)	    {	$cefr_skill[2] = $cefr_msg[1]; 	}
							if($each_percent[2]>8.75&&$each_percent[2]<=16.75)	{	$cefr_skill[2] = $cefr_msg[2]; 	}
							if($each_percent[2]>16.75&&$each_percent[2]<=24.75)	{	$cefr_skill[2] = $cefr_msg[3]; 	}
							if($each_percent[2]>24.75&&$each_percent[2]<=32.75)	{	$cefr_skill[2] = $cefr_msg[4]; 	}
							if($each_percent[2]>32.75&&$each_percent[2]<=39.75)	{	$cefr_skill[2] = $cefr_msg[5]; 	}
							if($each_percent[2]>39.75)							{	$cefr_skill[2] = $cefr_msg[6]; 	}
							//------------------------------------------------------//
							if($each_percent[3]<=0)							    {	$cefr_skill[3] = $cefr_msg[0]; 	}
							if($each_percent[3]>0&&$each_percent[3]<=6.75)		{	$cefr_skill[3] = $cefr_msg[1]; 	}
							if($each_percent[3]>6.75&&$each_percent[3]<=12.75)	{	$cefr_skill[3] = $cefr_msg[2]; 	}
							if($each_percent[3]>12.75&&$each_percent[3]<=18.75)	{	$cefr_skill[3] = $cefr_msg[3]; 	}
							if($each_percent[3]>18.75&&$each_percent[3]<=24.75)	{	$cefr_skill[3] = $cefr_msg[4]; 	}
							if($each_percent[3]>24.75&&$each_percent[3]<=29.75)	{	$cefr_skill[3] = $cefr_msg[5]; 	}
							if($each_percent[3]>29.75)							{	$cefr_skill[3] = $cefr_msg[6]; 	}
							//-------------------ตารางคะแนนของเก่า-------------------------//
							
							echo "
							<table align=center width=90% cellpadding=5 cellspacing=2 border=0 style='margin: 0 auto;' class='f-thai'>
								<tr height=25 >
									<td align=center width=20% bgcolor='#aaaaaa'><font size=2 color='#ffffff'><b>ทักษะ ( Skill )</b></font></td>
									<td align=center width=45% bgcolor='#aaaaaa' colspan=3><font size=2 color='#ffffff'><b>คะแนน ( Score )</b></font></td>
									<td align=center bgcolor='#aaaaaa'><font size=2 color='#ffffff'><b>ระดับความสามารถ ( Level )</b></font></td>
									<td align=center bgcolor='#aaaaaa'><font size=2 color='#ffffff'><b>CEFR</b></font></td>
								</tr>
								<tr height=25 >
									<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2><b>การฟัง ( Listening )</b></font></td>
									<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบถูก ".($correct_listening+0)." ข้อ </font></td>
									<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบผิด ".($wrong_listening+0)." ข้อ </font></td>
									<td align=center bgcolor='#e0e0e0'><font size=2 >ไม่ได้ตอบ ".($unans_lestening+0)." ข้อ </font></td>
									<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$skill_msg[1]</font></td>
									<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$cefr_skill[1]</font></td>
								</tr>
								<tr height=25>
									<td align=center bgcolor='#e0e0e0' colspan=3><font size=2 >
										<b>คิดเป็น ".(round($each_percent[1],2)+0)." / ".($correct_listening+$wrong_listening+$unans_lestening+0)." คะแนน </b>
									</font></td>
								</tr>
								<tr height=25 >
									<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2><b>การอ่าน ( Reading )</b></font></td>
									<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบถูก ".($correct_reading+0)." ข้อ </font></td>
									<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบผิด ".($wrong_reading+0)." ข้อ </font></td>
									<td align=center bgcolor='#e0e0e0'><font size=2 >ไม่ได้ตอบ ".($unans_reading+0)." ข้อ </font></td>
									<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$skill_msg[2]</font></td>
									<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$cefr_skill[2]</font></td>
								</tr>
								<tr height=25>
									<td align=center bgcolor='#e0e0e0' colspan=3><font size=2 >
										<b>คิดเป็น ".(round($each_percent[2],2)+0)." / ".($correct_reading+$wrong_reading+$unans_reading+0)." คะแนน </b>
									</font></td>
								</tr>
								<tr height=25 >
									<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2><b>ไวยากรณ์ ( Grammar )</b></font></td>
									<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบถูก ".(($correct_grammar)+0)." ข้อ </font></td>
									<td align=center bgcolor='#e0e0e0'><font size=2 >ตอบผิด ".(($wrong_grammar)+0)." ข้อ </font></td>
									<td align=center bgcolor='#e0e0e0'><font size=2 >ไม่ได้ตอบ ".(($unans_grammar)+0)." ข้อ </font></td>
									<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$skill_msg[3]</font></td>
									<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 >$cefr_skill[3]</font></td>
								</tr>
								<tr height=25>
									<td align=center bgcolor='#e0e0e0' colspan=3><font size=2 >
										<b>คิดเป็น ".(round($each_percent[3],2)+0)." / ".($correct_grammar+$wrong_grammar+$unans_grammar+0)." คะแนน </b>
									</font></td>
								</tr>
							</table><br>";	
					
					}
				}
				else{	
					echo "<p align='center'><font size=4 color=red><b> Not found. </b></font></p>";
				}
			}
}
?>