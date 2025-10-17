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
    $strSQL = "SELECT * FROM tbl_w_result_gepot WHERE member_id = ? order by percent DESC";
	$stmt = $conn->prepare($strSQL);
	$stmt->bind_param("s", $focus_member_id);
	$stmt->execute();
	$result = $stmt->get_result();
	// $data = $result->fetch_array();	
	$num = $result->num_rows;
    if($num==1)
    {
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
        // $num = $result->num_rows;		
        $fname = $data['fname'];		
        $lname = $data['lname'];
        $unans = (100 - ($correct + $wrong));
        $unans_lestening = (30 - ($correct_listening + $wrong_listening));
        $unans_reading = (40 - ($correct_reading + $wrong_reading));
        $unans_grammar = (30 - ($correct_grammar + $wrong_grammar));
            
            //---------------------------------------------------------------------------------------//
            $html = '
                    <table align=center width=90% cellpadding=5 cellspacing=0 border=1 >
                        <tr height=25>
                            <td width=20% align=right><font size=2 face=tahoma color=black><b>ผู้ทำแบบทดสอบ &nbsp; : &nbsp; </b></font></td>
                            <td width=70% align=left colspan=5><font size=2 face=tahoma color=black><b>&nbsp; '.$fname.' &nbsp; &nbsp; '.$lname.' </b></font></td>
                        </tr>
                        <tr  height=25>
                            <td align=right><font size=2 face=tahoma color=black><b>วันที่ทำการทดสอบ &nbsp; : &nbsp; </b></font></td>
                            <td align=left colspan=5><font size=2 face=tahoma color=black><b>&nbsp;' .$msg_date .'</b></font></td>
                        </tr>
                        <tr  height=25>
                            <td align=right><font size=2 face=tahoma color=black><b>
                                ประเภทการทดสอบ &nbsp; : &nbsp;</b></font></td>
                            <td align=left colspan=5>
                                <font size=2 face=tahoma color=black><b>
                                    &nbsp; General English Proficiency Online Test
                                </b></font>
                            </td>
                        </tr>
                        <tr  height=25>
                            <td align=right><font size=2 face=tahoma color=black><b>คะแนนที่ได้ &nbsp; : &nbsp; </b></font></td>
                            <td align=left colspan=5>
                                <font size=2 face=tahoma color=black><b>
                                    &nbsp; ตอบถูก '.$correct.' ข้อ &nbsp; &nbsp; ตอบผิด '.$wrong.' ข้อ &nbsp; &nbsp; ไม่ได้ตอบ '.$unans.' ข้อ &nbsp; &nbsp; คิดเป็น '.$percent.' %
                                </b></font>
                            </td>
                        </tr>
                    </table>
                ';
            //------------------------------------------------------//
            //echo " &nbsp; &nbsp; Total : ".$result_point." / ".$total_amount." &nbsp;&nbsp; Percent : ".$percent." % <br>";
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
            
            $html .= '
                    <table align=center width=90% cellpadding=5 cellspacing=2 border=1>
                        <tr height=25 >
                            <td align=center width=20%><font size=2 face=tahoma><b>ทักษะ ( Skill )</b></font></td>
                            <td align=center width=45% colspan=3><font size=2 face=tahoma><b>คะแนน ( Score )</b></font></td>
                            <td align=center><font size=2 face=tahoma><b>ระดับความสามารถ ( Level )</b></font></td>
                            <td align=center><font size=2 face=tahoma><b>CEFR</b></font></td>
                        </tr>
                        <tr height=25 >
                            <td align=center rowspan=2><font size=2 face=tahoma><b>การฟัง ( Listening )</b></font></td>
                            <td align=center><font size=2 face=tahoma >ตอบถูก '.($correct_listening+0).' ข้อ </font></td>
                            <td align=center><font size=2 face=tahoma >ตอบผิด '.($wrong_listening+0).' ข้อ </font></td>
                            <td align=center><font size=2 face=tahoma >ไม่ได้ตอบ '.($unans_lestening+0).' ข้อ </font></td>
                            <td align=center rowspan=2><font size=2 face=tahoma >'.$skill_msg[1].'</font></td>
                            <td align=center rowspan=2><font size=2 face=tahoma >'.$cefr_skill[1].'</font></td>
                        </tr>
                        <tr height=25>
                            <td align=center colspan=3><font size=2 face=tahoma >
                                <b>คิดเป็น '.(round($each_percent[1],2)+0).' / '.($correct_listening+$wrong_listening+$unans_lestening+0).' คะแนน </b>
                            </font></td>
                        </tr>
                        <tr height=25 >
                            <td align=center rowspan=2><font size=2 face=tahoma><b>การอ่าน ( Reading )</b></font></td>
                            <td align=center><font size=2 face=tahoma >ตอบถูก '.($correct_reading+0).' ข้อ </font></td>
                            <td align=center><font size=2 face=tahoma >ตอบผิด '.($wrong_reading+0).' ข้อ </font></td>
                            <td align=center><font size=2 face=tahoma >ไม่ได้ตอบ '.($unans_reading+0).' ข้อ </font></td>
                            <td align=center rowspan=2><font size=2 face=tahoma >'.$skill_msg[2].'</font></td>
                            <td align=center rowspan=2><font size=2 face=tahoma >'.$cefr_skill[2].'</font></td>
                        </tr>
                        <tr height=25>
                            <td align=center colspan=3><font size=2 face=tahoma >
                                <b>คิดเป็น '.(round($each_percent[2],2)+0).' / '.($correct_reading+$wrong_reading+$unans_reading+0).' คะแนน </b>
                            </font></td>
                        </tr>
                        <tr height=25 >
                            <td align=center rowspan=2><font size=2 face=tahoma><b>ไวยากรณ์ ( Grammar )</b></font></td>
                            <td align=center><font size=2 face=tahoma >ตอบถูก '.(($correct_grammar)+0).' ข้อ </font></td>
                            <td align=center><font size=2 face=tahoma >ตอบผิด '.(($wrong_grammar)+0).' ข้อ </font></td>
                            <td align=center><font size=2 face=tahoma >ไม่ได้ตอบ '.(($unans_grammar)+0).' ข้อ </font></td>
                            <td align=center rowspan=2><font size=2 face=tahoma >'.$skill_msg[3].'</font></td>
                            <td align=center rowspan=2><font size=2 face=tahoma >'.$cefr_skill[3].'</font></td>
                        </tr>
                        <tr height=25>
                            <td align=center colspan=3><font size=2 face=tahoma >
                                <b>คิดเป็น '.(round($each_percent[3],2)+0).' / '.($correct_grammar+$wrong_grammar+$unans_grammar+0).' คะแนน </b>
                            </font></td>
                        </tr>
                    </table><br>
                ';        
        
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
    
    $strSQL = "SELECT DISTINCT member_id FROM tbl_x_member_general WHERE user BETWEEN '$start' AND '$end' ORDER BY member_id ASC";
	$stmt = $conn->prepare($strSQL);
	$stmt->execute();
	$result = $stmt->get_result();
	$num = $result->num_rows;

    if($num >= 1){
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
            // $table = $sql[tb_x_general];			
            // $where = " where member_id='$id' ";
            // $query = select($table,$where);		
            // $is_have = mysql_num_rows($query);
            // $data = mysql_fetch_array($query);		
            // $fname = $data[fname];		
            // $lname = $data[lname];

            $SQL = "SELECT * FROM tbl_x_member_general WHERE member_id = ?";
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
            //---------------------------------------------------------------------------------------//
                $html = '
                        <table align=center width=90% cellpadding=5 cellspacing=0 border=0 >
                            <tr height=25>			
                                <td width=2% align=right><font size=2 face=tahoma color=black><b>'.$x.'</b></font></td>
                                <td width=15% align=right><font size=2 face=tahoma color=black><b>ผู้ทำแบบทดสอบ &nbsp; : &nbsp; </b></font></td>
                                <td width=70% align=left colspan=3><font size=2 face=tahoma color=black><b>&nbsp;'. $fname .'&nbsp; &nbsp;'. $lname .'</b></font></td>
                            </tr>
                            <tr  height=25>
                                <td></td>
                                <td width=15% align=right><font size=2 face=tahoma color=black><b>วันที่ทำการทดสอบ &nbsp; : &nbsp; </b></font></td>
                                <td align=left ><font size=2 face=tahoma color=black><b>&nbsp;'.$msg_date.' </b></font></td>
                            </tr>
                            <tr  height=25>
                                <td></td>
                                <td align=right width=15%><font size=2 face=tahoma color=black><b>
                                    ประเภทการทดสอบ &nbsp; : &nbsp;</b></font></td>
                                <td align=left >
                                    <font size=2 face=tahoma color=black><b>
                                        &nbsp; General English Proficiency Online Test
                                    </b></font>
                                </td>
                            </tr>
                            <tr  height=25>
                                <td></td>
                                <td align=right width=15%><font size=2 face=tahoma color=black><b>คะแนนที่ได้ &nbsp; : &nbsp; </b></font></td>
                                <td align=left colspan=3>
                                    <font size=2 face=tahoma color=black ><b>
                                        &nbsp; ตอบถูก '.$correct.' ข้อ &nbsp; &nbsp; ตอบผิด '.$wrong.' ข้อ &nbsp; &nbsp; ไม่ได้ตอบ '.$unans.' ข้อ &nbsp; &nbsp; คิดเป็น '.$percent.' %
                                    </b></font>
                                </td>
                            </tr>
                        </table>';
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
                
                $html .= '
                        <table align=center width=90% cellpadding=5 cellspacing=2 border=1>
                            <tr height=25 >
                                <td align=center width=20% ><font size=2 face=tahoma ><b>ทักษะ ( Skill )</b></font></td>
                                <td align=center width=45% colspan=3><font size=2 face=tahoma ><b>คะแนน ( Score )</b></font></td>
                                <td align=center ><font size=2 face=tahoma ><b>ระดับความสามารถ ( Level )</b></font></td>
                                <td align=center ><font size=2 face=tahoma ><b>CEFR</b></font></td>
                            </tr>
                            <tr height=25 >
                                <td align=center rowspan=2><font size=2 face=tahoma><b>การฟัง ( Listening )</b></font></td>
                                <td align=center><font size=2 face=tahoma >ตอบถูก '.($correct_listening+0).' ข้อ </font></td>
                                <td align=center><font size=2 face=tahoma >ตอบผิด '.($wrong_listening+0).' ข้อ </font></td>
                                <td align=center><font size=2 face=tahoma >ไม่ได้ตอบ '.($unans_lestening+0).' ข้อ </font></td>
                                <td align=center rowspan=2><font size=2 face=tahoma >'.$skill_msg[1].'</font></td>
                                <td align=center rowspan=2><font size=2 face=tahoma >'.$cefr_skill[1].'</font></td>
                            </tr>
                            <tr height=25>
                                <td align=center colspan=3><font size=2 face=tahoma >
                                    <b>คิดเป็น '.(round($each_percent[1],2)+0).' / '.($correct_listening+$wrong_listening+$unans_lestening+0).' คะแนน </b>
                                </font></td>
                            </tr>
                            <tr height=25 >
                                <td align=center rowspan=2><font size=2 face=tahoma><b>การอ่าน ( Reading )</b></font></td>
                                <td align=center><font size=2 face=tahoma >ตอบถูก '.($correct_reading+0).' ข้อ </font></td>
                                <td align=center><font size=2 face=tahoma >ตอบผิด '.($wrong_reading+0).' ข้อ </font></td>
                                <td align=center><font size=2 face=tahoma >ไม่ได้ตอบ '.($unans_reading+0).' ข้อ </font></td>
                                <td align=center rowspan=2><font size=2 face=tahoma >'.$skill_msg[2].'</font></td>
                                <td align=center rowspan=2><font size=2 face=tahoma >'.$cefr_skill[2].'</font></td>
                            </tr>
                            <tr height=25>
                                <td align=center colspan=3><font size=2 face=tahoma >
                                    <b>คิดเป็น '.(round($each_percent[2],2)+0).' / '.($correct_reading+$wrong_reading+$unans_reading+0).' คะแนน </b>
                                </font></td>
                            </tr>
                            <tr height=25 >
                                <td align=center rowspan=2><font size=2 face=tahoma><b>ไวยากรณ์ ( Grammar )</b></font></td>
                                <td align=center><font size=2 face=tahoma >ตอบถูก '.(($correct_grammar)+0).' ข้อ </font></td>
                                <td align=center><font size=2 face=tahoma >ตอบผิด '.(($wrong_grammar)+0).' ข้อ </font></td>
                                <td align=center><font size=2 face=tahoma >ไม่ได้ตอบ '.(($unans_grammar)+0).' ข้อ </font></td>
                                <td align=center rowspan=2><font size=2 face=tahoma >'.$skill_msg[3].'</font></td>
                                <td align=center rowspan=2><font size=2 face=tahoma >'.$cefr_skill[3].'</font></td>
                            </tr>
                            <tr height=25>
                                <td align=center colspan=3><font size=2 face=tahoma >
                                    <b>คิดเป็น '.(round($each_percent[3],2)+0).' / '.($correct_grammar+$wrong_grammar+$unans_grammar+0).' คะแนน </b>
                                </font></td>
                            </tr>
                        </table><br>
                    ';
            
        
            header('Content-Type:application/xls');
            header('Content-Disposition:attachment;filename=report.xls');
            echo $html;
        }
    }
}
?>