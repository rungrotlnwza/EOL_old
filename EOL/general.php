<?php
	ob_start();		
	session_start();
	pre_page();
	//check_duel_login();
	//check_available_time();
	if($_GET['action'] === "record")	{	est_record();	}
	if($_GET['action'] === "result")	{	est_result();	}
	if($_GET['action'] !== "record" && $_GET['action'] !== "result")	{	main();	}

	function main()
	{
		display_profile();
		if(!$_GET['action'])				{	pre_test();	}
		if($_GET['action'] === "set_test")	{	set_test();	}
		if($_GET['action'] === "test")		{	est_test();	}
		if($_GET['action'] === "report" && $_GET['report_section'] === "general") 
		{	
			if($_GET['result_id']) { result($_GET['result_id']); }
		}
		display_footer();
	}
function est_result()
{
	include('../config/connection.php');
	//-------------------------------------------------------------------//
	echo "
		<table align=center border=0>
			<tr height=200>
				<td align=center>
					<font size=2 face=tahoma color=blue><b>- ระบบกำลังวิเคราะห์ผลโปรดรอซักครู่ ( Now Loading... ) -</b></font>
				</td>
			</tr>
		</table>";
	if($_SESSION['amount']>=1&&$_SESSION['etest']>=1)
	{
		$strSQL = "SELECT * FROM tbl_w_result_general ORDER BY result_id DESC limit 0,1";
		$stmt = $conn->prepare($strSQL);
		$stmt->execute();
		$result = $stmt->get_result();
		$num = $result->num_rows;
		if($num==1)
		{
			$data = $result->fetch_array();
			$last_id = $data['result_id'] + 1;
		}else{ $last_id = 1; }
		for($i=1;$i<=$_SESSION['amount'];$i++) 
		{ 
			$ans_id=0; 
			for($k=1;$k<=4;$k++) {
				if($_SESSION['ans'][$i][$k]-$_SESSION['ans'][$i][$k]==0&&$_SESSION['ans'][$i][$k]>=1)
				{
					$ans_id = $_SESSION['ans'][$i][$k];
					$ans_correct = 1;
					$SQL = "SELECT * FROM tbl_answers WHERE QUESTIONS_ID=? && ANSWERS_CORRECT=? && ANSWERS_ID=?";
					$query = $conn->prepare($SQL);
					$query->bind_param("sis", $_SESSION['quiz']['id'][$i],$ans_correct,$ans_id);
					$query->execute();
					$result_ans = $query->get_result();
					$correct = $result_ans->num_rows;
					if($correct==1){ $sum = $sum + 1; }else{ $sum = $sum - 0.25; }
				}
			}
			$SQL = "INSERT INTO tbl_w_result_general_detail (result_id,quiz_id,ans_id) VALUES(?,?,?)";
			$stmt = $conn->prepare($SQL);
			$stmt->bind_param("sss", $last_id, $_SESSION['quiz']['id'][$i], $ans_id);
			$stmt->execute();
			$stmt->close();
		}
		$now = date("Y-m-d H:i:s");
		$skill_id = 0;
		$level_id = 0;
		$SQL = "INSERT INTO tbl_w_result_general (result_id,member_id,etest_id,percent,create_date,skill_id,level_id)
			VALUES(?,?,?,?,?,?,?)";
		$stmt = $conn->prepare($SQL);
		$stmt->bind_param("sssdsii", $last_id, $_SESSION['y_member_id'], $_SESSION['etest'], $sum, $now, $skill_id,
			$level_id);
		$stmt->execute();
		$stmt->close();
	}
	unset($_SESSION['amount']);
	unset($_SESSION['quiz']['id']);
	unset($_SESSION['quiz']['relate_id']);
	unset($_SESSION['all_page']);
	unset($_SESSION['ans']);
	unset($_SESSION['all_time']);
	echo "<script>
			window.location = 'general.php?section=business&&action=report&&report_section=general&&result_id=$last_id'
		 </script>";
    }
    function est_record()
    {
 		$next = $_GET["next"]; $page = $_GET['page'];
		if($_SESSION['all_page'][$page]-$_SESSION['all_page'][$page]==0 && $_SESSION['all_page'][$page]>=1)
		{
			$start = $_SESSION['all_page'][$page]; $stop = $_SESSION['all_page'][$page+1]-1;
			if($stop<=0){ $stop=$_SESSION['amount']; } 
			if($start>=1&&$stop>=1&&$start<=$stop) 
			{ 
				for($i=$start;$i<=$stop;$i++) {
					for($k=1;$k<=4;$k++) 
					{ 
						$ans_name="ans_" .$i."_".$k; 
						if($_POST[$ans_name]>=1){ $_SESSION['ans'][$i][$k] = $_POST[$ans_name]; }else{ $_SESSION['ans'][$i][$k] = 0; }
					}
				}
			}
			for($i=$start;$i<=$stop;$i++) 
			{ 
				$sound_play="played_" .$i; 
				if($_POST[$sound_play]==1)
				{
					$_SESSION['sound'][$i]="1" ; 
				} 
			} 
		} if($_GET['finish']==="finish" )
		{
            $msg_link="<script>window.location='?action=result'</script>" ; 
		} else{
            $msg_link="<script>document.getElementById('back_form').submit()</script>" ; 
		} echo "
				<form id='back_form' method=post action='?action=test&&page=$next'>
					<input type=hidden name='time_left' value='" .trim($_POST['time_left'])."'>
                </form>
                $msg_link
                ";
    }
    function est_test()
    {
        include('../config/connection.php');

        if($_SESSION['amount']==0||$_SESSION['y_member_id']!=$_SESSION['tester'])
        { 
			echo "<script>
                	window.location = '?action=set_test'
                  </script>"; 
		}else{
        	set_time();
            if($_GET['action']==="test")
            {
				echo "	<body onLoad='begintimer()'>";
                ?>

			<script language='javascript'>
				if (document.images) {
					var parselimit = document.config.fn_time.value
				}

				function hide(id, id2, end) {
					document.getElementById(id).style.display = 'none';
					document.getElementById(id2).style.display = 'none';
					document.getElementById(end).style.display = '';
					document.getElementById(end).innerHTML = 'Completed';
				}
			</script>
<?php
				echo "<img src='../images/image2/gepot/GEPOT-3.jpg' width=99.8%>";
				display_time_left();
			}
			if($_SESSION['all_page']){	$count = count($_SESSION['all_page']);	}
			if($_GET['page']-$_GET['page']==0 && $_GET['page']>=1){	$page = $_GET['page']; }
			if($page>=$count){	$page = $count;	}
			if(!$page){	$page = 1; }
			//------------------------------------------------------------------//
			echo "<form name='quiz_form' id='quiz_form' method='post'>
					<input type=hidden name='time_left' >";
					
			$start = $_SESSION['all_page'][$page];		
			$stop = $_SESSION['all_page'][$page+1]-1;
			if($stop<=0){ $stop = $_SESSION['amount']; }
			if($start>=1 && $stop>=1 && $start<=$stop)
			{
				for($i=$start;$i<=$stop;$i++)
				{
					$relate_text = "";
					if($_SESSION['quiz']['relate_id'][$i]!=$_SESSION['quiz']['relate_id'][$i-1]&&$_SESSION['quiz']['relate_id'][$i]!="none")
					{
                        $strSQL = "SELECT GQUESTION_TYPE_ID,GQUESTION_TEXT FROM tbl_gquestion WHERE GQUESTION_ID=?";
                        $stmt = $conn->prepare($strSQL);
                        $stmt->bind_param("s", $_SESSION['quiz']['relate_id'][$i]);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $is_have = $result->num_rows;
						if($is_have==1)
						{
							$data = $result->fetch_array();			
                            $relate_type = $data['GQUESTION_TYPE_ID'];		
                            $relate_text = $data['GQUESTION_TEXT'];
							$bg_color = "bgcolor='#F7E8E8'";
							if($relate_type==3)
							{
								if(is_mobile())
								{
									$relate_text = str_replace("/home/engtest/domains/engtest.net/public_html/files/sound/","",$relate_text);
									$relate_text = str_replace(".flv",".mp3",$relate_text);	
									$relate_text = "<div align=center>
													<br>
														<a target='_blank' href='https://www.engtest.net/files/sound/$relate_text'>
															<font size=4 face=tahoma color=red><b>&raquo; Click to Listen the Sound &laquo;</b></font>
														</a>
													<br>&nbsp;
													</div> ";	
								}
								else
								{
									if($_SESSION['sound'][$i]!=1)
									{	
										$folder = "sound"; 
										$relate_text = str_replace("/home/engtest/domains/engtest.net/public_html/files/sound/","",$relate_text);	
										$relate_text = str_replace(".flv",".mp3",$relate_text);	
																					
										$relate_text = "
														<div id='box_".$i."' align=center  style='cursor:pointer'
															onclick=\"
																if(confirm('สามารถฟังเสียงนี้ได้เพียงครั้งเดียว ต้องการฟังเดี๋ยวนี้หรือไม่'))
																	{	
																		document.getElementById('box_".$i."').style.display='none';	
																		document.getElementById('sound_".$i."').style.display='';
																		document.getElementById('played_".$i."').value='1';
																	}\">
															<font size=2 face=tahoma color=blue><b>กดที่นี่เพื่อฟังเสียง สามารถฟังได้เพียงครั้งเดียวเท่านั้น</b></font>
														</div>
														<div id='sound_".$i."' align=center style=\"display:none\">
															<audio id='player_".$i."' preload='auto' onended=\"hide('btnp_".$i."','btnp2_".$i."','finish_".$i."')\">
																<source src=\"https://www.engtest.net/files/$folder/$relate_text\">
															</audio>
															<div id='btnp_".$i."' class='yui3-button' onclick=\"document.getElementById('player_".$i."').play();\">Play</div>
															<div id='btnp2_".$i."' class='yui3-button' onclick=\"document.getElementById('player_".$i."').pause();\">Pause</div>
															<div id='finish_".$i."' class='yui3-button' style='display:none'></div>
														</div>
														<input type=hidden id='played_".$i."' name='played_".$i."' size=10>";					
													
									}
									else{	$relate_text = "<div align=center><font size=2 face=tahoma color=red><b>คุณได้ฟังเสียงนี้ไปแล้ว</b></font></div>";	}
								}
								$bg_color = "";
							}
							// if($relate_type=="2")
							// {	
							// 	$relate_text = str_replace("/home/engtest/domains/engtest.net/public_html/","","../".$relate_text);	
							// 	$relate_text = "<div align=center><img src='$msg_relate' border=0 width=300></div>";
							// }
							echo "<br>
								<table align=center width=90% cellpadding=5 cellspacing=0 border=0 $bg_color style='border-radius:5px'>
									<tr height=25>
										<td><font size=2 face=verdana>$relate_text</font></td>
									</tr>
								</table>";
						}
					}
                    $SQL = "SELECT QUESTIONS_TEXT FROM tbl_questions WHERE QUESTIONS_ID=?";
                    $query = $conn->prepare($SQL);
                    $query->bind_param("s", $_SESSION['quiz']['id'][$i]);
                    $query->execute();
                    $result_quiz = $query->get_result();
                    $is_have = $result_quiz->num_rows;
					if($is_have==1)
					{
						$data = $result_quiz->fetch_array();		
                        $quiz_text = $data['QUESTIONS_TEXT'];
						echo "
								<br>
								<table align=center width=90% cellpadding=5 cellspacing=0 border=0 >
									<tr height=25 valign=top>
										<td align=center width=5% rowspan=2 ><font size=2 face=verdana >$i.</font></td>
										<td align=left width=95%><font size=2 face=verdana > $quiz_text </font></td>
									</tr>
									<tr height=25>
										<td>";
                                            $SQLans = "SELECT ANSWERS_ID,ANSWERS_TEXT FROM tbl_answers WHERE QUESTIONS_ID=? order by ANSWERS_ID ASC";
                                            $query_ans = $conn->prepare($SQLans);
                                            $query_ans->bind_param("s", $_SESSION['quiz']['id'][$i]);
                                            $query_ans->execute();
                                            $result_ans = $query_ans->get_result();
                                            $ans_num = $result_ans->num_rows;
											if($ans_num>=1)
											{
												echo "<table align=left cellpadding=0 cellspacing=0 border=0>";
												for($k=1;$k<=$ans_num;$k++)
												{
													$check[$k] = 0;
													$data = $result_ans->fetch_array();		
													$ans_id = $data['ANSWERS_ID'];		
                                                    $ans_text = $data['ANSWERS_TEXT'];
													//----------------------------------------------------------------------------//
													if($k==1)
													{		
														$check_event = "document.getElementById('ans_".$i."_2').checked=''
																		document.getElementById('ans_".$i."_3').checked=''
																		document.getElementById('ans_".$i."_4').checked=''";
														$click_event = "
																		if( document.getElementById('ans_".$i."_1').checked=='')
																		{	document.getElementById('ans_".$i."_1').checked='checked'	}
																		else
																		{	document.getElementById('ans_".$i."_1').checked=''	}".$check_event;
													}
													if($k==2)
													{		
														$check_event = "document.getElementById('ans_".$i."_1').checked=''
																		document.getElementById('ans_".$i."_3').checked=''
																		document.getElementById('ans_".$i."_4').checked=''";
														$click_event = "
																		if( document.getElementById('ans_".$i."_2').checked=='')
																		{	document.getElementById('ans_".$i."_2').checked='checked'	}
																		else
																		{	document.getElementById('ans_".$i."_2').checked=''	}".$check_event;
													}
													if($k==3)
													{		
														$check_event = "document.getElementById('ans_".$i."_1').checked=''
																		document.getElementById('ans_".$i."_2').checked=''
																		document.getElementById('ans_".$i."_4').checked=''";
														$click_event = "
																		if( document.getElementById('ans_".$i."_3').checked=='')
																		{	document.getElementById('ans_".$i."_3').checked='checked'	}
																		else
																		{	document.getElementById('ans_".$i."_3').checked=''	}".$check_event;
													}
													if($k==4)
													{		
														$check_event = "document.getElementById('ans_".$i."_1').checked=''
																		document.getElementById('ans_".$i."_2').checked=''
																		document.getElementById('ans_".$i."_3').checked=''";
														$click_event = "
																		if( document.getElementById('ans_".$i."_4').checked=='')
																		{	document.getElementById('ans_".$i."_4').checked='checked'	}
																		else
																		{	document.getElementById('ans_".$i."_4').checked=''	}".$check_event;
													}
													if($_SESSION['ans'][$i][$k]>=1){ $check[$k] = "checked"; }else{	$check[$i] = ""; }
													//----------------------------------------------------------------------------//
													echo "
														<tr height=25 valign=top>
															<td align=left ><input name='ans_".$i."_".$k."' id='ans_".$i."_".$k."' type=checkbox  
																onclick=\"$check_event\" value='$ans_id' $check[$k]>&nbsp;</td>
															<td align=left onclick=\"$click_event\"><font size=2 face=verdana>$ans_text</font></td>
														</tr>";
												}
												echo "</table>";
											}
						echo "
										</td>
									</tr>
								</table>";
					}
				}
			}
			if($count>=1)
			{
				if($page+1>$count)	{ $next = 1; }else{	$next = $page+1; }
				if($page-1<=0)		{ $back = $count; }else{ $back = $page-1; }
				echo "
						<br>
						<table align=center width=90% cellpadding=5 cellspacing=0 border=0 bgcolor='#f7f7f7' style='border-radius:5px'>
							<tr height=25 valign=top>
								<td align=left width=15%>
									<img  src='../images/image2/gepot/back1.png' onmouseover=\"this.src='../images/image2/gepot/back2.png';\" onmouseout=\"this.src='../images/image2/gepot/back1.png';\" style='cursor:pointer'
										onclick=\"javascript: document.getElementById('quiz_form').action='?action=record&&page=$page&&next=$back'; document.getElementById('quiz_form').submit(); \">
								</td>
								<td align=right width=11%><font size=2 face=verdana>Page&nbsp;:&nbsp;</font></td>
								<td align=left width=59%><font size=2 face=verdana>
							
					";
				for($i=1;$i<=$count;$i++)
				{
					if($i<=9)			{	$num = "[0".$i."]";	}
					if($i>=10&&$i<=99)	{	$num = "[".$i."]";	}
					if($page==$i){	$color = "red";	}else{	$color = "blue";	}
					echo "&nbsp;<a onclick=\"javascript:document.getElementById('quiz_form').action='?action=record&&page=$page&&next=$i';
									document.getElementById('quiz_form').submit(); \" style='cursor:pointer'>
									<font color='$color'>$num</font></a>&nbsp;";
					if($i%10==0){	echo "<br>";	}
				}
				echo "
								</font></td>
								<td align=right width=15%>
									<img  src='../images/image2/gepot/next1.png' onmouseover=\"this.src='../images/image2/gepot/next2.png';\" onmouseout=\"this.src='../images/image2/gepot/next1.png';\"  style='cursor:pointer'
										onclick=\"javascript: document.getElementById('quiz_form').action='?action=record&&page=$page&&next=$next'; document.getElementById('quiz_form').submit(); \" >
								</td>
							</tr>
						</table>";
			}
			echo "
				<table align=center width=90% cellpadding=0 cellspacing=0 border=0>
					<tr height=20><td></td></tr>
					<tr height=12 bgcolor='#777777' style='border-radius:5px'><td></td></tr>
					<tr height=75><td align=center>
						<img  src='../images/image2/gepot/finish1.png' onmouseover=\"this.src='../images/image2/gepot/finish2.png';\" onmouseout=\"this.src='../images/image2/gepot/finish1.png';\" width='170' height='40' style='cursor:pointer'
						onclick=\"javascript: if(confirm('Do you want to finish this test ? '))
							{
								document.getElementById('quiz_form').action='?action=record&&page=$page&&next=$next&&finish=finish';
								document.getElementById('quiz_form').submit();
							}\">
					</td></tr>
				</table>
			</form>"; 
		}
	}
	function set_time()
	{
		if($_SESSION['all_time']&&$_SESSION['all_time']-$_SESSION['all_time']==0)	
		{	
			$_SESSION['fn_time'] = $_SESSION['all_time'];
            unset($_SESSION['all_time']);
		}
		if($_SESSION['fn_time']&&$_POST['time_left'])	{	$_SESSION['fn_time'] = $_POST['time_left'];		}
		echo "
				<form name=config>
					<input type=hidden  value='$_SESSION[fn_time]' name='fn_time'  readonly>
					<input type=hidden  name='time_min'  readonly>
					<input type=hidden  name='time_sec'  readonly>
				</form>
			";
	}
	function display_time_left()
	{
		echo "	<br><br>
				<table id=tbl_time_left align=center width=250 cellpadding=0 cellspacing=0 border=0>
					<tr height=30>
						<td bgcolor=eeeeee style='border-radius: 5px;'>
							<div id='dplay' align=center>
						</div>
					</td></tr>
				</table>
			";
	}
	function set_test()
	{
        include('../config/connection.php');
        unset($_SESSION['etest']);
        unset($_SESSION['amount']);
        unset($_SESSION['quiz_id']);
        unset($_SESSION['all_page']);
        unset($_SESSION['all_time']);
        unset($_SESSION['ans']);
        unset($_SESSION['sound']);
		//----------------------------------------------------------------------------------------------//
		if($_POST['event_pass']==1)
		{
			$_SESSION['tester'] = $_SESSION['y_member_id'];
			echo "	
				<center>
					<table width=90% align=center cellpadding=0 cellspacing=0 border=0 >
						<tr>
							<td align=center>
								<img src='../images/image2/gepot/set-test-page.png' width='90%' style='margin-top:25px; border-radius:10px;'>	
							</td>
						</tr>
					</table>
					<table>
						<tr height=70>
							<form method='post' action='?action=test'>
								<td align=center>
									<input type=hidden name='event_start' value='1'>
									<input align=center id=event_start type='submit' class='yui3-button' value=' Start GEPOT Test'>
								</td>
							</form>
						</tr>
					</table>
				</center>";
			//------------------------------------------------------------------------------------------//
            $is_est = 2;
            $strSQL = "SELECT ETEST_ID FROM tbl_etest WHERE IS_EST=?";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("i", $is_est);
            $stmt->execute();
            $result = $stmt->get_result();
            $num = $result->num_rows;
			if($num>=1){ $rand = rand(1,$num) - 1; }
			//---------------------------  Choose number of test  ----------------------------------------//
			$count = 0;			
			$page_num = 1;
            $SQL = "SELECT ETEST_ID,ETEST_TIME FROM tbl_etest WHERE IS_EST=? limit $rand,1";
            $query = $conn->prepare($SQL);
            $query->bind_param("i", $is_est);
            $query->execute();
            $result_etest = $query->get_result();
            $is_have = $result_etest->num_rows;
			if($is_have==1)
			{	
				$data = $result_etest->fetch_array();		
                $etest_id = $data['ETEST_ID'];	
				$_SESSION['etest'] = $etest_id;	
                $_SESSION['all_time'] = $data['ETEST_TIME'] * 60;	
			}
			//----------------------------------------------------------------------//
			for($k=1;$k<=4;$k++)
			{
				if($k==1){	$skill_id = 2;	}
				if($k==2){	$skill_id = 1;	}
				if($k==3){	$skill_id = 5;	}
				if($k==4){	$skill_id = 4;	}
				
				$event = "";
                $msg = 	"SELECT A.QUESTIONS_ID,B.SKILL_ID,C.GQUESTION_ID FROM tbl_etest_mapping AS A,tbl_questions AS B,tbl_questions_mapping AS C WHERE
                A.ETEST_ID = ? && A.QUESTIONS_ID=B.QUESTIONS_ID && A.QUESTIONS_ID=C.QUESTIONS_ID && 
                B.SKILL_ID = ? order by C.GQUESTION_ID ASC,B.QUESTIONS_ID ASC";

                $stmt_map = $conn->prepare($msg);
                $stmt_map->bind_param("si", $etest_id, $skill_id);
                $stmt_map->execute();
                $result_mapping = $stmt_map->get_result();
                $num = $result_mapping->num_rows;

				for($i=1;$i<=$num;$i++)
				{
					$count = $count+1;		
					$data = $result_mapping->fetch_array();
					$quiz['id'][$count] = $data['QUESTIONS_ID'];		
					$quiz['skill_id'][$count] = $data['SKILL_ID'];			
					$quiz['relate_id'][$count] = $data['GQUESTION_ID'];		
					if($i!=$num){	
                        $event = $event." A.QUESTIONS_ID != $data[QUESTIONS_ID] && ";	}
					else{	
                        $event = $event." A.QUESTIONS_ID != $data[QUESTIONS_ID] ";	}
					if($count-$page[$page_num-1]>=4||$count==1||$quiz['skill_id'][$count-1]!=$quiz['skill_id'][$count]) // 1 Relate per Quiz / First Page / Change Skill
					{
						if($quiz['relate_id'][$count]!=$quiz['relate_id'][$count-1]){	$page[$page_num] = $count;		$page_num = $page_num + 1;	}
					}
				}	
				if($event){	$event = " && ( ".$event." ) ";	}	
                $str =  "SELECT A.QUESTIONS_ID,B.SKILL_ID FROM tbl_etest_mapping AS A,tbl_questions AS B WHERE
						A.ETEST_ID=? && A.QUESTIONS_ID=B.QUESTIONS_ID && B.SKILL_ID=? $event order by B.QUESTIONS_ID ASC";
                $query_map = $conn->prepare($str);
                $query_map->bind_param("si", $etest_id, $skill_id);
                $query_map->execute();
                $result_map = $query_map->get_result();
                $rows = $result_map->num_rows;
				for($i=1;$i<=$rows;$i++)
				{
					$count = $count+1;		
					$data = $result_map->fetch_array();
					$quiz['id'][$count] = $data['QUESTIONS_ID'];		
					$quiz['skill_id'][$count] = $data['SKILL_ID'];			
					$quiz['relate_id'][$count] = "none";	
					if($quiz['relate_id'][$count]!=$quiz['relate_id'][$count-1])
					{	$page[$page_num] = $count;		$page_num = $page_num + 1;	}
					if(($page[$page_num-1]+5)<=$count){	$page[$page_num] = $count;		$page_num = $page_num + 1;	}
				}
			}	
			//---------------------------------------//
			$_SESSION['amount'] = $count;		$_SESSION['quiz'] = $quiz;		$_SESSION['all_page'] = $page;
			//---------------------------------------//
		}
		else{	echo "<script>window.location='?'</script>";	}
	}
	function pre_test()
	{
		include('../config/connection.php');
		include('../config/format_time.php');
		// echo "	
		// 	<table width=90% align=center cellpadding=0 cellspacing=0 border=0 >		
		// 		<tr>
		// 			<td align=center>
		// 				<img src='../images/image2/gepot/pre-test-page.png' width='90%' style='margin-top:25px; border-radius:10px;'>	
		// 			</td>
		// 		</tr>
		// 		<tr>
		// 			<td colspan=2 >";
		// 				//-----------------------------------------------------------------//
        //                 $is_est = 2; 
        //                 $strSQL = "SELECT ETEST_ID FROM tbl_etest WHERE IS_EST=? order by ETEST_ID";
        //                 $stmt = $conn->prepare($strSQL);
        //                 $stmt->bind_param("i", $is_est);
        //                 $stmt->execute();
        //                 $result = $stmt->get_result();
        //                 $num = $result->num_rows;
		// 				if($num>=1)
		// 				{
		// 					for($i=1;$i<=$num;$i++)
		// 					{
		// 						$data = $result->fetch_array();		
        //                         $etest_id = $data['ETEST_ID'];
		// 						if($i!=$num)
		// 						{	$event = $event." ETEST_ID='$etest_id' || ";	}
		// 						else
		// 						{	$event = $event." ETEST_ID='$etest_id' ";	}
		// 					}
		// 				}
		// 				if($event)
		// 				{
		// 					$event = "( $event )";
		// 					$date_event = date("Y-m-d H:i:s",time() - ( 60 * 60 * 24 * 30 ));
		// 					$now = date("Y-m-d H:i:s",time());;
                                                
        //                     $SQL = "SELECT result_id,create_date FROM tbl_w_result_general WHERE $event && member_id=? order by create_date DESC limit 0,1";
        //                     $query = $conn->prepare($SQL);
        //                     $query->bind_param("s", $_SESSION['y_member_id']);
        //                     $query->execute();
        //                     $result_general = $query->get_result();
        //                     $is_have = $result_general->num_rows;
		// 					if($is_have==1)
		// 					{
		// 						$data = $result_general->fetch_array();		
        //                         $last_test = $data['create_date'];
		// 						//---------------------------------------------------------------------//
		// 						$arr = explode(" ",$last_test);			
		// 						$msg_last = get_thai_day($arr[0])." ".get_thai_month($arr[0])." ".get_thai_year($arr[0]);
		// 						$msg_last = "<font color=white>".$msg_last."</font>";
		// 						$result_id = $data[0];
		// 						$pass_msg = 0;
		// 					}
		// 					if($is_have==0)
		// 					{                       
		// 						$msg_last = "<font color=green> ไม่พบข้อมูลการใช้าน GEPOT ครั้งล่าสุด </font>";
		// 						$event_wait = 1; 
		// 					}		
		// 					if($event_wait==1) {	
        //                         $event_pass = 1;	
        //                         $pass_msg = "";	
		// 					}
		// 					else {	
		// 					    $event_pass = 0;	
		// 						$pass_msg = " disabled='true' ";	
		// 					}			
		// 				}
		// 				//-----------------------------------------------------------------//
		// 				echo "<br>
		// 					<table align=center width=60% cellpadding=0 cellspacing=1 border=0>";
									
		// 					if ($pass_msg == "" or $_SESSION['y_member_id']==1 or $_SESSION['y_member_id']==4 or $_SESSION['y_member_id']==6) 
		// 					{
									
		// 						echo "
		// 							<tr height=30 border=1>
		// 								<td align=center bgcolor='#C1CDC1' width='40%'><font size=2 face=tahoma border=1><b>ทดสอบ GEPOT ครั้งล่าสุดเมื่อ</b></font></td>
		// 								<td align=center colspan=3 bgcolor='#C1CDC1'><font size=2 face=tahoma border=1> $msg_last </font></td>
		// 							</tr>
		// 							<tr height=100 >
		// 								<form method='post' action='?action=set_test'>
		// 									<td align=center colspan=4>
		// 										<input type=checkbox id=notice onclick=\"javascript:
		// 											var notice_chk = document.getElementById('notice').checked;
		// 											if (notice_chk == false){
		// 												document.getElementById('btnpretest').disabled = true;
		// 											}else{
		// 												document.getElementById('btnpretest').disabled = false;
		// 											}
		// 										\">
		// 										<font color=red  size=2>ข้าพเจ้ายอมรับเงื่อนไขในการใช้ระบบ (I accept the terms of use)</br></br></font>";
							
		// 								$SQLtime = "SELECT * FROM tbl_x_general_time order by time DESC limit 0,1";
		// 								$query_time = $conn->prepare($SQLtime);
		// 								$query_time->execute();
		// 								$result_time = $query_time->get_result();
		// 								$data = $result_time->fetch_array();
							
		// 								if ($_SESSION['y_member_id']==1 or $_SESSION['y_member_id']==4 or $_SESSION['y_member_id']==6) 
		// 								{
		// 									echo "
		// 										<input type=hidden name='event_pass' value='1'>
		// 										<input id='btnpretest' type='submit' class='yui3-button' value=' I want to use this test [GEPOT].' disabled>";
		// 								}
										
		// 								//กำหนดวันสอบ
		// 								else if (date("Y-m-d") <= $data[1] || date("Y-m-d") >= $data[2]) 
		// 								{
		// 									echo "<input id='btnnotime' type='submit' class='yui3-button' value=' Currently Unavailable ' disabled>";
		// 								}
										
		// 								else {
		// 									echo "<input type=hidden name='event_pass' value='1'>
		// 										  <input id='btnpretest' type='submit' class='yui3-button' value=' I want to use this test [GEPOT].' disabled>";
		// 								}
										
		// 								echo "</td>
		// 								</form>";	
		// 					}		
		// 					else if ($pass_msg == 0) 
		// 					{
		// 						echo "
		// 							<tr height=30>
		// 								<td align=center bgcolor='#FF6A6A' width='40%'><font size=2 face=tahoma ><b>ทดสอบ GEPOT ครั้งล่าสุดเมื่อ</b></font></td>
		// 								<td align=center colspan=3 bgcolor='#FF6A6A'><font size=2 face=tahoma > $msg_last </font></td>
		// 							</tr>
		// 							<tr height=100 >
		// 								<td align=center colspan=4>
		// 									<input type=button class='yui3-button' value=' Click to show report.' onclick=\"window.location.href='?section=business&&action=report&&report_section=general&&result_id=$result_id'\">
		// 								</td>
		// 							</tr>";	
		// 					}
					
		// 			echo "	</table>
		// 			</td>
		// 		</tr>
		// 	</table>";
		$SQL = "SELECT result_id,create_date FROM tbl_w_result_general WHERE member_id = ? ORDER BY create_date DESC limit 0,1";
    $query = $conn->prepare($SQL);
    $query->bind_param("s", $_SESSION['y_member_id']);
    $query->execute();
    $data_result = $query->get_result();
    $is_have_exam = $data_result->num_rows;
    if ($is_have_exam == 1) {
        $data = $data_result->fetch_array();
        $last_test = $data['create_date'];

        $arr = explode(" ", $last_test);

        $msg_last = get_thai_day($arr[0]) . " " . get_thai_month($arr[0]) . " " . get_thai_year($arr[0]);
        $msg_last = "<font color=white>" . $msg_last . "</font>";
        $result_id = $data[0];
        $pass_msg = 1;
    }
    if ($is_have_exam == 0) {
        $msg_last = "<font color=green> ไม่พบข้อมูลการใช้งาน GEPOT ครั้งล่าสุด </font>";
        $pass_msg = 0;
    }

    $query->close();
    echo "
		<table width=90% align=center cellpadding=0 cellspacing=0 border=0 >		
            <tr>
                <td align=center>
                    <img src='../images/image2/gepot/pre-test-page.png' width='90%' style='margin-top:25px; border-radius:10px;'>	
                </td>
            </tr>
            <tr>
                <td colspan=2 >";

    echo "<br><table align=center width=60% cellpadding=0 cellspacing=1 border=0>";
    // -------------------------------------- //
    if ($pass_msg == 0 || $_SESSION['y_member_id'] == 6) {
        echo "
			    <tr height=30 border=1 style='background:#C1CDC1; border-radius:5px;'>
			  	    <td align=center  width='40%'>
                        <font size=2 face=tahoma border=1>
                            <b>ทดสอบ GEPOT ครั้งล่าสุดเมื่อ</b>
                        </font>
                    </td>
			  	    <td align=center colspan=3 >
                        <font size=2 face=tahoma border=1> $msg_last </font>
                    </td>
			    </tr>
			    <tr height=100 >		
				    <form method='post' action='?action=set_test'>
					    <td align=center colspan=4>		
                            <input type=checkbox id=notice onclick=\"javascript:
                                var notice_chk = document.getElementById('notice').checked;
                                if (notice_chk == false){
                                    document.getElementById('btnpretest').disabled = true;
                                }else{
                                    document.getElementById('btnpretest').disabled = false;
                                    document.getElementById('btnpretest').onmouseenter = function() {mouseEnter()};
                                    document.getElementById('btnpretest').onmouseleave = function() {mouseLeave()};
                                }
                                \"><font color=red  size=2>ข้าพเจ้ายอมรับเงื่อนไขในการใช้ระบบ (I accept the terms of use)</br></br></font>";
        // -------------------------- //

        $msg = "SELECT * FROM tbl_x_general_time ORDER BY time DESC limit 0,1";
        $stmt_time = $conn->prepare($msg);
        $stmt_time->execute();
        $result = $stmt_time->get_result();
        $data = $result->fetch_array();

        if ($_SESSION['y_member_id'] == 6) {
            echo "
                <input type=hidden name='event_pass' value='1'>
                <input id='btnpretest' type='submit' class='yui3-button' value=' I want to use this test [GEPOT].' disabled>";
        } else if (date("Y-m-d") <= $data[1] || date("Y-m-d") >= $data[2]) {
            echo "  <input id='btnnotime' type='submit' class='yui3-button' value=' Currently Unavailable ' disabled>";

        } else {
            echo "  <input type=hidden name='event_pass' value='1'>
                <input id='btnpretest' type='submit' class='yui3-button' value=' I want to use this test [GEPOT].' disabled>";
        }
        echo "</td>
            </form>
        </tr>";
        $stmt_time->close();
    }
    if ($pass_msg == 1) {
        echo "
            <tr height=30>
                <td align=center bgcolor='#FF6A6A' width='40%'><font size=2 face=tahoma ><b>ทดสอบ GEPOT ครั้งล่าสุดเมื่อ</b></font></td>
                <td align=center colspan=3 bgcolor='#FF6A6A'><font size=2 face=tahoma > $msg_last </font></td>
            </tr>
            <tr height=100 >
                <td align=center colspan=4>
                    <input type=button class='yui3-button' value=' Click to show report.' onclick=\"window.location.href='?section=business&&action=report&&report_section=general&&result_id=$result_id'\">
                </td>
            </tr>";
    }
    echo "     </table>
            </td>
        </tr>
    </table>";
	}
	function display_profile()
	{
		include('../config/connection.php');
        $strSQL = "SELECT * FROM tbl_x_member_general WHERE member_id=?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("i", $_SESSION['y_member_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $is_member = $result->num_rows;
		if ($is_member == 1) {
			$datatop = $result->fetch_array();
			$gender = $datatop['gender'];
			if ($gender == 0) {
				$gender = 1;
			}
			$msg_image = "../2010/member_images/icon_user_0" . $gender . ".jpg";
		} else {
			echo "<script type=\"text/javascript\">
						window.location=\"../index.php\";
				  </script>";
			exit();
		}
		//---------------------------------------------------------------------------------------------------//
		echo "<div id='container'>
				<div id='header'>
					<!---- info user ----->
					<div id='info_user'>   
						<div id='pic_profile'>
							<img src='" . $msg_image . "' height='100'  width='100'>
						</div>
						<div id='user_text'>
							<p style='margin-top:75px; font-weight:bold;'>$datatop[fname] &nbsp;&nbsp;$datatop[lname]</p>
						</div>   
						<div id='logoutPic'>
							<a href='../inc/logout.php'>
								<img src='../images/image2/eol system/button/logout-06.webp' style='margin-top:52px;'>
							</a>
						</div>
					</div>
				</div>
				<!------- main content --------->
				<div id='content'>
					<div id='pic_border'>
						<img src='../images/image2/eol system/head-box-02.png' width='1024'>
					</div>
					<div id='content-div'>";		
	}
	
	
	function result($id) 
	{
		include('../config/connection.php');
		include('../config/format_time.php');
		$focus_member_id = $_SESSION['y_member_id'];	
		$rs_id = trim($id);
		//-----------------------------------------------------------------------------//
		$strSQL = "SELECT * FROM tbl_w_result_general WHERE member_id=? AND result_id=?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("is", $focus_member_id, $rs_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $num = $result->num_rows;
		if($num==1)
		{
			$result_data = $result->fetch_array();		
			//-----------------------------------------------------------------------------//
			$result_id = $result_data['result_id'];
			$member_id =  $result_data['member_id'];			
			$level_id = $result_data['level_id'];			
			$skill_id =  $result_data['skill_id'];			
			$create_date = $result_data['create_date'];	
			$etest_id = $result_data['etest_id'];
			//-----------------------------------------------------------------------------//
			$arr_date_time = explode(" ",$create_date);		
			$msg_date = get_thai_day($arr_date_time[0])." &nbsp; ".get_thai_month($arr_date_time[0])." &nbsp; ".get_thai_year($arr_date_time[0])." &nbsp;&nbsp; เวลา ".$arr_date_time[1]." น. ";
			//-------------------------------------//
			$SQL = "SELECT * FROM tbl_x_member_general WHERE member_id=?";
			$query = $conn->prepare($SQL);
			$query->bind_param("i", $focus_member_id);
			$query->execute();
			$result_mem = $query->get_result();
			$is_have = $result_mem->num_rows;	
			$data = $result_mem->fetch_array();
			$fname = $data['fname'];		
			$lname = $data['lname'];
			//-------------------------------------------------------------------------------//
			if($etest_id)
			{
				//------------------------ Get All point ----------------------------------------//
				$SQLdetail = "SELECT * FROM tbl_w_result_general_detail WHERE result_id=? group by quiz_id";
				$query_detail = $conn->prepare($SQLdetail);
				$query_detail->bind_param("s", $result_id);
				$query_detail->execute();
				$result_detail = $query_detail->get_result();
				$total_amount = $result_detail->num_rows;	
				//------------------------ Get Pass point ----------------------------------------//
				if($total_amount>=1)
				{
					$amount = NULL;
					$wrong = NULL;
					$unans = NULL;
					$result = NULL;
					for($i=1;$i<=$total_amount;$i++)
					{	
						$sub_data = $result_detail->fetch_array();		
						$quiz_id = $sub_data['quiz_id'];
						$result_ans = $sub_data['ans_id'];
						//-----------------------------------------------------------------------//
						$SQLquiz = "SELECT SKILL_ID FROM tbl_questions WHERE QUESTIONS_ID=?";
						$query_quiz = $conn->prepare($SQLquiz);
						$query_quiz->bind_param("s", $quiz_id);
						$query_quiz->execute();
						$result_quiz = $query_quiz->get_result();
						$is_have = $result_quiz->num_rows;	
						if($is_have==1){ 
							$skill_data = $result_quiz->fetch_array();	 
							$skill_id = $skill_data['SKILL_ID']; 
						}
						//-----------------------------------------------------------------------//
						$is_correct = 1;
						$SQLans = "SELECT ANSWERS_ID FROM tbl_answers WHERE QUESTIONS_ID=? AND ANSWERS_CORRECT=?";
						$query_ans = $conn->prepare($SQLans);
						$query_ans->bind_param("si", $quiz_id,$is_correct);
						$query_ans->execute();
						$result_answer = $query_ans->get_result();
						$is_true = $result_answer->num_rows;	
						if($is_true==1)
						{
							$check = $result_answer->fetch_array();
							//--------------------------------------------------------------//
							if($result_ans == $check['ANSWERS_ID'])
							{ $amount[$skill_id] = $amount[$skill_id] + 1; }
							if($result_ans != $check['ANSWERS_ID'] && $result_ans!=0)
							{ $wrong[$skill_id] = $wrong[$skill_id] + 1; }
							if($result_ans == 0)
							{ $unans[$skill_id] = $unans[$skill_id] + 1; }
							//--------------------------------------------------------------//
							
						}
					}
					$result['pass'] = $amount;
					$result['wrong'] = $wrong;
					$result['unans'] = $unans;
					$all_pass = $result['pass'][1] + $result['pass'][2] + $result['pass'][4] + $result['pass'][5];
					$all_wrong = $result['wrong'][1] + $result['wrong'][2] + $result['wrong'][4] + $result['wrong'][5];
					$all_unans = $result['unans'][1] + $result['unans'][2] + $result['unans'][4] + $result['unans'][5];
					$percent = (($all_pass + 0) - ($all_wrong * 0.25)) * ( 100 / $total_amount);
				}
				//---------------------------------------------------------------------------------------//
				echo "
						<table align=center width=90% cellpadding=5 cellspacing=0 border=0 bgcolor='#f7f7f7'>
							<tr height=25>
								<center><img src='../images/image2/gepot/GEPOT-4.jpg' style='width:90%; margin-top:20px;border-radius:10px;'></img><br><br></center>
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
										&nbsp; General English Proficiency Online Test
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
						</table><br>
					";
				//------------------------------------------------------//
				$text_msg[0] = "<font color=red>ไม่สามารถประเมินได้</font>";
				$text_msg[1] = "<font color=brown>พอใช้ ( Low )</font>";
				$text_msg[2] = "<font color=green>ปานกลาง ( Intermediate )</font>";
				$text_msg[3] = "<font color=blue>สูง ( High )</font>";
				$each_percent[1] = (($result['pass'][1] + 0) - ($result['wrong'][1] * 0.25))+0;
				$each_percent[2] = (($result['pass'][2] + 0) - ($result['wrong'][2] * 0.25))+0;
				$each_percent[3] = (($result['pass'][4] + $result['pass'][5] + 0) - ( ($result['wrong'][4] + $result['wrong'][5] ) * 0.25))+0;
				
				//---- CEFR
				$each_percent[4] = $each_percent[1] + $each_percent[3];
				
				//------------------------------------------------------//
				if ($each_percent[1] <= 0) {
					$skill_msg[1] = $text_msg[0];
				}
				if ($each_percent[1] > 0 && $each_percent[1] <= 10.75) {
					$skill_msg[1] = $text_msg[1];
				}
				if ($each_percent[1] > 10.75 && $each_percent[1] <= 20.75) {
					$skill_msg[1] = $text_msg[2];
				}
				if ($each_percent[1] > 20.75) {
					$skill_msg[1] = $text_msg[3];
				}
				//------------------------------------------------------//
				if ($each_percent[2] <= 0) {
					$skill_msg[2] = $text_msg[0];
				}
				if ($each_percent[2] > 0 && $each_percent[2] <= 14.75) {
					$skill_msg[2] = $text_msg[1];
				}
				if ($each_percent[2] > 14.75 && $each_percent[2] <= 29.75) {
					$skill_msg[2] = $text_msg[2];
				}
				if ($each_percent[2] > 29.75) {
					$skill_msg[2] = $text_msg[3];
				}
				//------------------------------------------------------//
				if ($each_percent[3] <= 0) {
					$skill_msg[3] = $text_msg[0];
				}
				if ($each_percent[3] > 0 && $each_percent[3] <= 10.75) {
					$skill_msg[3] = $text_msg[1];
				}
				if ($each_percent[3] > 10.75 && $each_percent[3] <= 20.75) {
					$skill_msg[3] = $text_msg[2];
				}
				if ($each_percent[3] > 20.75) {
					$skill_msg[3] = $text_msg[3];
				}
				//-------------- CEFR -----------------//
				$cefr_msg[0] = "<font color=red>A0</font>";
				$cefr_msg[1] = "<font color=red>A1</font>";
				$cefr_msg[2] = "<font color=brown>A2</font>";
				$cefr_msg[3] = "<font color=green>B1</font>";
				$cefr_msg[4] = "<font color=blue>B2</font>";
				$cefr_msg[5] = "<font color=blue>C1</font>";
				$cefr_msg[6] = "<font color=blue>C2</font>";
			
				if ($each_percent[1] <= 0) {
					$cefr_skill[1] = $cefr_msg[0];
				}
				if ($each_percent[1] > 0 && $each_percent[1] <= 6.75) {
					$cefr_skill[1] = $cefr_msg[1];
				}
				if ($each_percent[1] > 6.75 && $each_percent[1] <= 12.75) {
					$cefr_skill[1] = $cefr_msg[2];
				}
				if ($each_percent[1] > 12.75 && $each_percent[1] <= 18.75) {
					$cefr_skill[1] = $cefr_msg[3];
				}
				if ($each_percent[1] > 18.75 && $each_percent[1] <= 24.75) {
					$cefr_skill[1] = $cefr_msg[4];
				}
				if ($each_percent[1] > 24.75 && $each_percent[1] <= 29.75) {
					$cefr_skill[1] = $cefr_msg[5];
				}
				if ($each_percent[1] > 29.75) {
					$cefr_skill[1] = $cefr_msg[6];
				}
				//------------------------------------------------------//
				if ($each_percent[2] <= 0) {
					$cefr_skill[2] = $cefr_msg[0];
				}
				if ($each_percent[2] > 0 && $each_percent[2] <= 8.75) {
					$cefr_skill[2] = $cefr_msg[1];
				}
				if ($each_percent[2] > 8.75 && $each_percent[2] <= 16.75) {
					$cefr_skill[2] = $cefr_msg[2];
				}
				if ($each_percent[2] > 16.75 && $each_percent[2] <= 24.75) {
					$cefr_skill[2] = $cefr_msg[3];
				}
				if ($each_percent[2] > 24.75 && $each_percent[2] <= 32.75) {
					$cefr_skill[2] = $cefr_msg[4];
				}
				if ($each_percent[2] > 32.75 && $each_percent[2] <= 39.75) {
					$cefr_skill[2] = $cefr_msg[5];
				}
				if ($each_percent[2] > 39.75) {
					$cefr_skill[2] = $cefr_msg[6];
				}
				//------------------------------------------------------//
				if ($each_percent[3] <= 0) {
					$cefr_skill[3] = $cefr_msg[0];
				}
				if ($each_percent[3] > 0 && $each_percent[3] <= 6.75) {
					$cefr_skill[3] = $cefr_msg[1];
				}
				if ($each_percent[3] > 6.75 && $each_percent[3] <= 12.75) {
					$cefr_skill[3] = $cefr_msg[2];
				}
				if ($each_percent[3] > 12.75 && $each_percent[3] <= 18.75) {
					$cefr_skill[3] = $cefr_msg[3];
				}
				if ($each_percent[3] > 18.75 && $each_percent[3] <= 24.75) {
					$cefr_skill[3] = $cefr_msg[4];
				}
				if ($each_percent[3] > 24.75 && $each_percent[3] <= 29.75) {
					$cefr_skill[3] = $cefr_msg[5];
				}
				if ($each_percent[3] > 29.75) {
					$cefr_skill[3] = $cefr_msg[6];
				}
				//------------------------------------------------------//
				
				echo "
						<table align=center width=90% cellpadding=5 cellspacing=2 border=0>
							<tr height=25 >
								<td align=center width=20% bgcolor='#aaaaaa'><font size=2 face=tahoma color='#ffffff'><b>ทักษะ ( Skill )</b></font></td>
								<td align=center width=45% bgcolor='#aaaaaa' colspan=3><font size=2 face=tahoma color='#ffffff'><b>คะแนน ( Score )</b></font></td>
								<td align=center bgcolor='#aaaaaa'><font size=2 face=tahoma color='#ffffff'><b>ระดับความสามารถ ( Level )</b></font></td>
								<td align=center bgcolor='#aaaaaa'><font size=2 face=tahoma color='#ffffff'><b>CEFR</b></font></td>
							</tr>
							<tr height=25 >
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma><b>การฟัง ( Listening )</b></font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบถูก ".($result['pass'][2]+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบผิด ".($result['wrong'][2]+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ไม่ได้ตอบ ".($result['unans'][2]+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$skill_msg[2]</font></td>
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$cefr_skill[2]</font></td>
							</tr>
							<tr height=25>
								<td align=center bgcolor='#e0e0e0' colspan=3><font size=2 face=tahoma >
									<b>คิดเป็น ".(round($each_percent[2],2)+0)." / ".($result['pass'][2]+$result['wrong'][2]+$result['unans'][2]+0)." คะแนน </b>
								</font></td>
							</tr>
							<tr height=25 >
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma><b>การอ่าน ( Reading )</b></font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบถูก ".($result['pass'][1]+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบผิด ".($result['wrong'][1]+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ไม่ได้ตอบ ".($result['unans'][1]+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$skill_msg[1]</font></td>
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$cefr_skill[1]</font></td>
							</tr>
							<tr height=25>
								<td align=center bgcolor='#e0e0e0' colspan=3><font size=2 face=tahoma >
									<b>คิดเป็น ".(round($each_percent[1],2)+0)." / ".($result['pass'][1]+$result['wrong'][1]+$result['unans'][1]+0)." คะแนน </b>
								</font></td>
							</tr>
							<tr height=25 >
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma><b>ไวยากรณ์ ( Grammar )</b></font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบถูก ".(($result['pass'][4]+$result['pass'][5])+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบผิด ".(($result['wrong'][4]+$result['wrong'][5])+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ไม่ได้ตอบ ".(($result['unans'][4]+$result['unans'][5])+0)." ข้อ </font></td>
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$skill_msg[3]</font></td>
								<td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$cefr_skill[3]</font></td>
							</tr>
							<tr height=25>
								<td align=center bgcolor='#e0e0e0' colspan=3><font size=2 face=tahoma >
									<b>คิดเป็น ".(round($each_percent[3],2)+0)." / ".($result['pass'][4]+$result['wrong'][4]+$result['unans'][4]+$result['pass'][5]+$result['wrong'][5]+$result['unans'][5])." คะแนน </b>
								</font></td>
							</tr>
						</table><br>
					";
				
				// -------------------------- CEFR	-------------------------------- //
				
				$color_a = "bgcolor='#f0f0f0'";
				$color_b = "bgcolor='#ffe0e0'";
				$color_bottom = "bgcolor='#C4FAFC'";
				$color_top_score = "bgcolor='#E2F9F9'";
				if ($percent <= 0) {
					$color[0] = $color_b;
					$color_m[0] = $color_b;
				} else {
					$color[0] = $color_a;
					$color_m[0] = $color_a;
				}
				if ($percent >= 0.25 && $percent <= 7.75) {
					$color[1] = $color_b;
					$color_m[1] = $color_b;
					$color_g[1] = $color_b;
				} else {
					$color[1] = $color_a;
					$color_m[1] = $color_a;
					$color_g[1] = $color_a;
				}
				if ($percent > 7.75 && $percent <= 15.75) {
					$color[2] = $color_b;
					$color_m[1] = $color_b;
					$color_g[1] = $color_b;
				} else {
					$color[2] = $color_a;
				}
				if ($percent > 15.75 && $percent <= 25.75) {
					$color[3] = $color_b;
					$color_m[2] = $color_b;
					$color_g[2] = $color_b;
				} else {
					$color[3] = $color_a;
					$color_m[2] = $color_a;
					$color_g[2] = $color_a;
				}
				if ($percent > 25.75 && $percent <= 35.75) {
					$color[4] = $color_b;
					$color_m[2] = $color_b;
					$color_g[2] = $color_b;
				} else {
					$color[4] = $color_a;
				}
				if ($percent > 35.75 && $percent <= 45.75) {
					$color[5] = $color_b;
					$color_m[3] = $color_b;
					$color_g[3] = $color_b;
				} else {
					$color[5] = $color_a;
					$color_m[3] = $color_a;
					$color_g[3] = $color_a;
				}
				if ($percent > 45.75 && $percent <= 60.75) {
					$color[6] = $color_b;
					$color_m[3] = $color_b;
					$color_g[3] = $color_b;
				} else {
					$color[6] = $color_a;
				}
				if ($percent > 60.75 && $percent <= 70.75) {
					$color[7] = $color_b;
					$color_m[4] = $color_b;
					$color_g[4] = $color_b;
				} else {
					$color[7] = $color_a;
					$color_m[4] = $color_a;
					$color_g[4] = $color_a;
				}
				if ($percent > 70.75 && $percent <= 80.75) {
					$color[8] = $color_b;
					$color_m[4] = $color_b;
					$color_g[4] = $color_b;
				} else {
					$color[8] = $color_a;
				}
				if ($percent > 80.75 && $percent <= 90.75) {
					$color[9] = $color_b;
					$color_m[5] = $color_b;
					$color_g[5] = $color_b;
				} else {
					$color[9] = $color_a;
					$color_m[5] = $color_a;
					$color_g[5] = $color_a;
				}
				if ($percent > 90.75 && $percent <= 99.75) {
					$color[10] = $color_b;
					$color_m[6] = $color_b;
					$color_g[5] = $color_b;
				} else {
					$color[10] = $color_a;
					$color_m[6] = $color_a;
				}
				if ($percent > 99.75 && $percent <= 100) {
					$color[11] = $color_b;
					$color_m[7] = $color_b;
				} else {
					$color[11] = $color_bottom;
					$color_m[7] = $color_bottom;
				}

				//------------- CEFR ----------- //
				if ($percent <= 0) {
					$color_c[0] = $color_b;
				} else {
					$color_c[0] = $color_a;
				}
				if ($percent >= 0.25 && $percent <= 15.75) {
					$color_c[1] = $color_b;
				} else {
					$color_c[1] = $color_a;
				}
				if ($percent > 15.75 && $percent <= 35.75) {
					$color_c[2] = $color_b;
				} else {
					$color_c[2] = $color_a;
				}
				if ($percent > 35.75 && $percent <= 60.75) {
					$color_c[3] = $color_b;
				} else {
					$color_c[3] = $color_a;
				}
				if ($percent > 60.75 && $percent <= 80.75) {
					$color_c[4] = $color_b;
				} else {
					$color_c[4] = $color_a;
				}
				if ($percent > 80.75 && $percent <= 99.75) {
					$color_c[5] = $color_b;
				} else {
					$color_c[5] = $color_a;
				}
				if ($percent > 99.75 && $percent <= 100) {
					$color_c[6] = $color_b;
				} else {
					$color_c[6] = $color_bottom;
				}
				echo "
					<table align=center width=90% cellpadding=5 cellspacing=2 border=0>
						<tr height=25>
							<td align=center bgcolor='#aaaaaa'>
								<font size=2 face=tahoma color='#ffffff'><b>GEPOT by EOL</b></font>
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
					</table><br><br>&nbsp;
					
					<center>
					<form>
						<input type=\"button\" class='yui3-button' value=\"Print this result\" onClick=\"window.open('../EOL/gen_report_general.php?result_id=$rs_id','_blank')\"> 
						<input type=\"button\" class='yui3-button' value=\"Certification TH\" onClick=\"window.open('../EOL/get_certificate_gepot_th.php?result_id=$rs_id','_blank')\">
						<input type=\"button\" class='yui3-button' value=\"Certification EN\" onClick=\"window.open('../EOL/get_certificate_gepot_eng.php?result_id=$rs_id','_blank')\">
					</form>
					</center>
					";

					
			}
		}
		else{ header("Location:?section=$_GET[section]"); }
	}
	
	
	
	// function check_duel_login()
	// {
	// 	$sql = config();	
	// 	$session_id = session_id();
	// 	$table = $sql[tb_x_login];				$where = " where member_id='$_SESSION[y_member_id]' && session_id='$session_id ' ";
	// 	$query = select($table,$where);			$is_ok = mysql_num_rows($query);
	// 	if($is_ok==0)
	// 	{	
	// 		session_unregister(y_member_id);
	// 	}	
	// }
	
	// function check_available_time()
	// {
	// 	$sql = config();	
	// 	$now = date("Y-m-d H:i:s");		
	// 	$table = $sql[tb_x_member_time];		$where = " where member_id='$_SESSION[y_member_id]' && stop>='$now' order by stop DESC limit 0,1 ";
	// 	$query = select($table,$where);			$is_ok = mysql_num_rows($query);
	// 	if($is_ok==0){	header("Location:../?section=business");	}
	// }
	function pre_page()
	{
		?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>General English Proficiency Online Test :: ระบบทดสอบภาษาอังกฤษออนไลน์ </title>
    <link rel='shortcut icon' type='image/x-icon' href='../images/image2/eol-icon.png'>
    <link rel="stylesheet" href="../bootstrap/css/page-gepot.css">
    <link rel="stylesheet" href="../bootstrap/css/button-gepot.css">
    <style type="text/css">
    #tbl_time_left {
        position: sticky;
        top: 10px;
    }

    input[type="checkbox"] {
        font-size: 16px;
    }

    body {
        margin-left: 0px;
        margin-top: -15px;
    }

    #event_start:hover {
        background-color: #008000f0;
    }
    </style>
</head>

<body>
    <?php
		// echo "
		// 		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
		// 		<meta name='keywords' content='ภาษาอังกฤษ,engtest,english,eol,สอน,สอนอังกฤษ,อิงลิซออนไลน์,dic,dictionary'>
		// 		<title>English Test Online :: ระบบทดสอบภาษาอังกฤษออนไลน์ </title>
		// 		<link href='../css/testpage.css' rel='stylesheet'>
		// 		</head>
		// 	";
			
		// if($_GET[start]=="first")
		// {
		// $value = "  result_id='0' , member_id='$_SESSION[y_member_id]' , skill_id='0' , level_id='0' , etest_id='$_SESSION[etest]' ,  
		// 		create_date=now() , percent='0' ";
		// mysql_query("INSERT INTO tbl_w_result_general SET $value ");
		// }
        
// 		if($_GET['action']=="test")
// 		{
// 			echo "	<body onLoad='begintimer()'>";
			
		

// ?>
    // <?php
// 		}else{	echo "<body>";	}
	}
	// function display_header()
	// {
	// 	echo "<img src='https://www.engtest.net/2010/temp_images/temp/system/header-standard-test.jpg' border=0>";
	// }
	function display_footer()
	{
		echo "
            </div>
        </div>
        <!-----------end main cotent------------>
    </div>
    <!------------------- end container -------------->";
    ?>
    <script language="javascript">
    if (document.images) {
        MM_preloadImages();
    }

    function begintimer() {
        if (!document.images)
            return
        if (parselimit == 1)
            window.location = '?action=record&&page=$page&&next=$next&&finish=finish';
        else {
            parselimit -= 1
            curmin = Math.floor(parselimit / 60)
            cursec = parselimit % 60
            if (curmin != 0) {
                curtime = "<font face=tahoma size=3>เวลาที่เหลือ : <font color=red> " + curmin +
                    " </font>นาที กับ <font color=red>" + cursec + " </font>วินาที </font>"
                document.config.time_min.value = curmin
                document.config.time_sec.value = cursec
                document.quiz_form.time_left.value = parselimit
                //document.next_form.time_left.value=parselimit
                //document.back_form.time_left.value=parselimit
                //document.num_form.time_left.value=parselimit
            } else

            if (cursec == 0) {
                alert('หมดเวลาแล้วจ้า');
            } else {
                curtime = "<font face=tahoma size=2>เวลาที่เหลือ <font color=red>" + cursec +
                    " </font>วินาที </font>"
                document.config.time_min.value = curmin
                document.config.time_sec.value = cursec
                document.quiz_form.time_left.value = parselimit
                //document.next_form.time_left.value=parselimit
                //document.back_form.time_left.value=parselimit
                //document.num_form.time_left.value=parselimit
            }
            document.getElementById('dplay').innerHTML = curtime;
            setTimeout("begintimer()", 1000)
        }
    }

    function MM_preloadImages() { //v3.0
        var d = document;
        if (d.images) {
            if (!d.MM_p) d.MM_p = new Array();
            var i, j = d.MM_p.length,
                a = MM_preloadImages.arguments;
            for (i = 0; i < a.length; i++)
                if (a[i].indexOf("#") != 0) {
                    d.MM_p[j] = new Image;
                    d.MM_p[j++].src = a[i];
                }
        }
    }
    </script>
</body>
<!------------------- end body -------------->

</html>
<!------------------- end html -------------->
<?php
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
		// http://wurfl.sourceforge.net/


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
			"gradiente",
			"grundig",
			"haier",
			"hedy",
			"hitachi",
			"htc",
			"huawei",
			"hutchison",
			"inno",
			"ipad",
			"ipaq",
			"ipod",
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
			"palm",
			"panasonic",
			"pantech",
			"philips",
			"phone",
			"pg-",
			"playstation",
			"pocket",
			"pt-",
			"qc-",
			"qtek",
			"rover",
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