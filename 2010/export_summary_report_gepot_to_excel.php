<?php 
ob_start();		
session_start();
header('Content-Type: text/html; charset=utf-8');
include('../config/connection.php');
include('../config/format_time.php');

if($_POST['member_id']){
    $focus_member_id = trim($_POST['member_id']);	
    //--------------------------------------------------//
    // $table = $sql[tb_w_result_gepot];			
    // $where = " where member_id='$focus_member_id' order by percent DESC";
    // $query = select($table,$where);		
    // $num = mysql_num_rows($query);
    $strSQL = "SELECT * FROM tb_w_result_gepot WHERE member_id = ? order by percent DESC";
	$stmt = $conn->prepare($strSQL);
	$stmt->bind_param("s", $focus_member_id);
	$stmt->execute();
	$result = $stmt->get_result();
	// $data = $result->fetch_array();	
	$num = $result->num_rows;
    if($num>=1)
    {
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
        $SQL = "SELECT * FROM tb_x_member_general WHERE member_id = ?";
        $query = $conn->prepare($SQL);
        $query->bind_param("s", $focus_member_id);
        $query->execute();
        $result_member = $query->get_result();
        $data = $result_member->fetch_array();	
        // $num = $result->num_rows;		
        $fname = $data['fname'];		
        $lname = $data['lname'];
        $unans = (100 - ($correct + $wrong));
        $unans_lestening = (30 - ($correct_listening + $wrong_listening));
        $unans_reading = (40 - ($correct_reading + $wrong_reading));
        $unans_grammar = (30 - ($correct_grammar + $wrong_grammar));
            
        $html = '<table align=center width=50% cellpadding=5 cellspacing=2 border=1>
        <tr>
            <td colspan=8></td>
        </tr>
        <tr>
            <td rowspan=2 align=center><font size=2 face=tahoma ><b>Name</b></font></td>
            <td align=center colspan=7><font size=2 face=tahoma ><b>Score</b></font></td>
        </tr>
        <tr>
            <td align=center>การฟัง 30 คะแนน</td>
            <td align=center>การอ่าน 40 คะแนน</td>
            <td align=center>ไวยากรณ์ 30 คะแนน</td>
            <td align=center>ผลรวม 100 คะแนน</td>
            <td align=center>GEPOT Test</td>
            <td align=center>CEFR</td>
            <td align=center>TOEIC</td>
        </tr>
</table>';



    //---------------------------------------------------------------------------------------//


    $each_percent[1] = (($correct_listening + 0) - ($wrong_listening * 0.25))+0;
    $each_percent[2] = (($correct_reading + 0) - ($wrong_reading * 0.25))+0;
    $each_percent[3] = (($correct_grammar + 0) - ($wrong_grammar * 0.25))+0;
    //-------------- CEFR -----------------//
    $cefr_msg[0] = "<font color=red> - </font>";
    $cefr_msg[1] = "<font color=green>A1</font>";
    $cefr_msg[2] = "<font color=green>A2</font>";
    $cefr_msg[3] = "<font color=green>B1</font>";
    $cefr_msg[4] = "<font color=green>B2</font>";
    $cefr_msg[5] = "<font color=green>C1</font>";
    $cefr_msg[6] = "<font color=green>C2</font>";

    //------------------------ CEFR
    if($percent<=0)					        {	$cefr_level = $cefr_msg[0];	}
    if($percent>=0.25&&$percent<=15.75)	    {	$cefr_level = $cefr_msg[1];	}
    if($percent>15.75&&$percent<=35.75)	    {	$cefr_level = $cefr_msg[2];	}
    if($percent>35.75&&$percent<=60.75)	    {	$cefr_level = $cefr_msg[3];	}
    if($percent>60.75&&$percent<=80.75)	    {	$cefr_level = $cefr_msg[4];	}
    if($percent>80.75&&$percent<=99.75)	    {	$cefr_level = $cefr_msg[5];	}
    if($percent>99.75&&$percent<=100)	    {	$cefr_level = $cefr_msg[6];	}
    //------------------------------------------------------//
    $gepot_msg[0] = "<font color=red>0</font>";
    $gepot_msg[1] = "<font color=red>1 - 15</font>";
    $gepot_msg[2] = "<font color=red>16 - 35</font>";
    $gepot_msg[3] = "<font color=red>36 - 60</font>";
    $gepot_msg[4] = "<font color=red>61 - 80</font>";
    $gepot_msg[5] = "<font color=red>81 - 99</font>";
    $gepot_msg[6] = "<font color=red>100</font>";

    if($percent<=0)					        {	$gepot_level = $gepot_msg[0];	}
    if($percent>=0.25&&$percent<=15.75)	    {	$gepot_level = $gepot_msg[1];	}
    if($percent>15.75&&$percent<=35.75)	    {	$gepot_level = $gepot_msg[2];	}
    if($percent>35.75&&$percent<=60.75)	    {	$gepot_level = $gepot_msg[3];	}
    if($percent>60.75&&$percent<=80.75)	    {	$gepot_level = $gepot_msg[4];	}
    if($percent>80.75&&$percent<=99.75)	    {	$gepot_level = $gepot_msg[5];	}
    if($percent>99.75&&$percent<=100)	    {	$gepot_level = $gepot_msg[6];	}
    //------------------------------------------------------//
    $toeic_msg[0] = "<font color=red>-</font>";
    $toeic_msg[1] = "<font color=brown>0 - 250</font>";
    $toeic_msg[2] = "<font color=brown>255 - 400</font>";
    $toeic_msg[3] = "<font color=brown>405 - 600</font>";
    $toeic_msg[4] = "<font color=brown>605 -780</font>";
    $toeic_msg[5] = "<font color=brown>785 - 900</font>";
    $toeic_msg[6] = "<font color=brown>905 - 989</font>";
    $toeic_msg[7] = "<font color=brown>100</font>";

    if($percent<=0)					        {	$toeic_level = $toeic_msg[0];	}
    if($percent>=0.25&&$percent<=15.75)	    {	$toeic_level = $toeic_msg[1];	}
    if($percent>15.75&&$percent<=35.75)	    {	$toeic_level = $toeic_msg[2];	}
    if($percent>35.75&&$percent<=60.75)	    {	$toeic_level = $toeic_msg[3];	}
    if($percent>60.75&&$percent<=80.75)	    {	$toeic_level = $toeic_msg[4];	}
    if($percent>80.75&&$percent<=90.75)	    {	$toeic_level = $toeic_msg[5];	}
    if($percent>90.75&&$percent<=99.75)		{	$toeic_level = $toeic_msg[6];	}
    if($percent>99.75&&$percent<=100)	    {	$toeic_level = $toeic_msg[7];	}



$html .= '
    <table align=center width=50% cellpadding=5 cellspacing=2 border=1>
        <tr>
            <td align=center><font size=2 face=tahoma ><b>'.$fname.'&nbsp; &nbsp;'. $lname .'</font></td>
            <td align=center><font size=2 face=tahoma >
                <b>'.(round($each_percent[1],2)+0).'</b>
                </font>
            </td>
            <td align=center><font size=2 face=tahoma >
                <b>'.(round($each_percent[2],2)+0).'</b>
                </font>
            </td>
            <td align=center><font size=2 face=tahoma >
                <b>'.(round($each_percent[3],2)+0).'</b>
                </font>
            </td>
            <td align=center><font size=2 face=tahoma >'.$percent.'</font></td>
            <td align=center><font size=2 face=tahoma >'.$gepot_level.'</font></td>
            <td align=center><font size=2 face=tahoma >'.$cefr_level.'</font></td>
            <td align=center><font size=2 face=tahoma >'.$toeic_level.'</font></td>
        </tr>
    </table><br>';		
            
            // ------------------ CEFR	--------------------------------
        
        
        header('Content-Type:application/xls');
        header('Content-Disposition:attachment;filename=report.xls');
        echo $html;
    }
    else{	
        echo "<p align='center'><font size=4 color=red><b> Not found. </b></font></p>";
    }
}
if($_POST['start_username'] && $_POST['end_username'])
{
    $start =  trim($_POST['start_username']);
    $end = trim($_POST['end_username']);
    
    $strSQL = "SELECT DISTINCT member_id FROM tb_x_member_general WHERE user BETWEEN '$start' AND '$end' ORDER BY member_id ASC";
	$stmt = $conn->prepare($strSQL);
	$stmt->execute();
	$result = $stmt->get_result();
	$num = $result->num_rows;
            
    // $strSQL = "SELECT DISTINCT member_id FROM tb_w_result_gepot WHERE member_id BETWEEN '$start' AND '$end' ORDER BY member_id ASC";
	// $stmt = $conn->prepare($strSQL);
	// // $stmt->bind_param("s", $focus_member_id);
	// $stmt->execute();
	// $result = $stmt->get_result();
	// $data = $result->fetch_array();	
	$num = $result->num_rows;
    $html = '<table align=center width=50% cellpadding=5 cellspacing=2 border=1>
                        <tr>
                            <td colspan=9></td>
                        </tr>
                        <tr>
                            <td align=center><b>ที่</b></td>
                            <td align=center><font size=2 face=tahoma ><b>ชื่อ - สกุล</b></font></td>
                            <td align=center>การฟัง 30 คะแนน</td>
                            <td align=center>การอ่าน 40 คะแนน</td>
                            <td align=center>ไวยากรณ์ 30 คะแนน</td>
                            <td align=center>ผลรวม 100 คะแนน</td>
                            <td align=center>GEPOT Test</td>
                            <td align=center>CEFR</td>
                            <td align=center>TOEIC</td>
                        </tr>
            </table>';
    if($num >= 1){
        $j = 1;
		while($row = $result->fetch_assoc()) {
			$temp_id[$j] = $row['member_id'];
			$j++;  
		}
        for($x=1;$x<=$num;$x++){
            // $result = mysql_fetch_array($query_b);
            $id = $temp_id[$x];
            // $table_a = "SELECT * FROM tbl_w_result_gepot WHERE member_id='$id' order by percent DESC"; 
            // $query_a = mysql_query($table_a);
            // $result_data = mysql_fetch_array($query_a);	
            $SQL = "SELECT * FROM tb_w_result_gepot WHERE member_id = ? order by percent DESC";
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
            $SQL = "SELECT * FROM tb_x_member_general WHERE member_id = ?";
			$query_member = $conn->prepare($SQL);
			$query_member->bind_param("s", $id);
			$query_member->execute();
			$result_member = $query_member->get_result();
			$data = $result_member->fetch_array();	
			// $num = $result->num_rows;		
			$fname = $data['fname'];		
			$lname = $data['lname'];
            //-------------------------------------------------------------------------------//
            $unans = (100 - ($correct + $wrong));
            $unans_lestening = (30 - ($correct_listening + $wrong_listening));
            $unans_reading = (40 - ($correct_reading + $wrong_reading));
            $unans_grammar = (30 - ($correct_grammar + $wrong_grammar));

            $each_percent[1] = (($correct_listening + 0) - ($wrong_listening * 0.25))+0;
            $each_percent[2] = (($correct_reading + 0) - ($wrong_reading * 0.25))+0;
            $each_percent[3] = (($correct_grammar + 0) - ($wrong_grammar * 0.25))+0;
            
            //-------------- CEFR -----------------//
            $cefr_msg[0] = "<font color=red> - </font>";
            $cefr_msg[1] = "<font color=green>A1</font>";
            $cefr_msg[2] = "<font color=green>A2</font>";
            $cefr_msg[3] = "<font color=green>B1</font>";
            $cefr_msg[4] = "<font color=green>B2</font>";
            $cefr_msg[5] = "<font color=green>C1</font>";
            $cefr_msg[6] = "<font color=green>C2</font>";
            
            //------------------------ CEFR
            if($percent<=0)					        {	$cefr_level = $cefr_msg[0];	}
            if($percent>=0.25&&$percent<=15.75)	    {	$cefr_level = $cefr_msg[1];	}
            if($percent>15.75&&$percent<=35.75)	    {	$cefr_level = $cefr_msg[2];	}
            if($percent>35.75&&$percent<=60.75)	    {	$cefr_level = $cefr_msg[3];	}
            if($percent>60.75&&$percent<=80.75)	    {	$cefr_level = $cefr_msg[4];	}
            if($percent>80.75&&$percent<=99.75)	    {	$cefr_level = $cefr_msg[5];	}
            if($percent>99.75&&$percent<=100)	    {	$cefr_level = $cefr_msg[6];	}
            //------------------------------------------------------//
            $gepot_msg[0] = "<font color=red>0</font>";
            $gepot_msg[1] = "<font color=red>1-15</font>";
            $gepot_msg[2] = "<font color=red>16-35</font>";
            $gepot_msg[3] = "<font color=red>36-60</font>";
            $gepot_msg[4] = "<font color=red>61-80</font>";
            $gepot_msg[5] = "<font color=red>81-99</font>";
            $gepot_msg[6] = "<font color=red>100</font>";

            if($percent<=0)					        {	$gepot_level = $gepot_msg[0];	}
            if($percent>=0.25&&$percent<=15.75)	    {	$gepot_level = $gepot_msg[1];	}
            if($percent>15.75&&$percent<=35.75)	    {	$gepot_level = $gepot_msg[2];	}
            if($percent>35.75&&$percent<=60.75)	    {	$gepot_level = $gepot_msg[3];	}
            if($percent>60.75&&$percent<=80.75)	    {	$gepot_level = $gepot_msg[4];	}
            if($percent>80.75&&$percent<=99.75)	    {	$gepot_level = $gepot_msg[5];	}
            if($percent>99.75&&$percent<=100)	    {	$gepot_level = $gepot_msg[6];	}
            //------------------------------------------------------//
            $toeic_msg[0] = "<font color=red>-</font>";
            $toeic_msg[1] = "<font color=brown>0-250</font>";
            $toeic_msg[2] = "<font color=brown>255-400</font>";
            $toeic_msg[3] = "<font color=brown>405-600</font>";
            $toeic_msg[4] = "<font color=brown>605-780</font>";
            $toeic_msg[5] = "<font color=brown>785-900</font>";
            $toeic_msg[6] = "<font color=brown>905-989</font>";
            $toeic_msg[7] = "<font color=brown>100</font>";
            
            if($percent<=0)					        {	$toeic_level = $toeic_msg[0];	}
            if($percent>=0.25&&$percent<=15.75)	    {	$toeic_level = $toeic_msg[1];	}
            if($percent>15.75&&$percent<=35.75)	    {	$toeic_level = $toeic_msg[2];	}
            if($percent>35.75&&$percent<=60.75)	    {	$toeic_level = $toeic_msg[3];	}
            if($percent>60.75&&$percent<=80.75)	    {	$toeic_level = $toeic_msg[4];	}
            if($percent>80.75&&$percent<=90.75)	    {	$toeic_level = $toeic_msg[5];	}
            if($percent>90.75&&$percent<=99.75)		{	$toeic_level = $toeic_msg[6];	}
            if($percent>99.75&&$percent<=100)	    {	$toeic_level = $toeic_msg[7];	}
            
            
            //-------------------ตารางคะแนนของเก่า-------------------------//
            
            $html .= '
                    <table align=center width=50% cellpadding=5 cellspacing=2 border=1>
                        <tr>
                            <td align=center><b>'.$x.'</b></td>
                            <td align=center><font size=2 face=tahoma ><b>'.$fname.'&nbsp; &nbsp;'. $lname .'</font></td>
                            <td align=center><font size=2 face=tahoma >
                                <b>'.(round($each_percent[1],2)+0).'</b>
                                </font>
                            </td>
                            <td align=center><font size=2 face=tahoma >
                                <b>'.(round($each_percent[2],2)+0).'</b>
                                </font>
                            </td>
                            <td align=center><font size=2 face=tahoma >
                                <b>'.(round($each_percent[3],2)+0).'</b>
                                </font>
                            </td>
                            <td align=center><font size=2 face=tahoma >'.$percent.'</font></td>
                            <td align=center><font size=2 face=tahoma >'.$gepot_level.'</font></td>
                            <td align=center><font size=2 face=tahoma >'.$cefr_level.'</font></td>
                            <td align=center><font size=2 face=tahoma >'.$toeic_level.'</font></td>
                        </tr>
                    </table>';	
            
        }
        header('Content-Type:application/xls');
        header('Content-Disposition:attachment;filename=report.xls');
        echo $html;
        
    }
}
?>