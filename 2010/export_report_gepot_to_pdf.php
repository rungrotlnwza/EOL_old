<?php
ob_start();		
session_start();
header('Content-Type: text/html; charset=utf-8');
include('../config/connection.php');
include('../config/format_time.php');
echo "<script type=\"text/javascript\">
        window.print();
      </script>";	

pre_page();
if($_POST['member_id']){
    $focus_member_id = trim($_POST['member_id']);	
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
            echo "<div class=parent align=center>";
            echo "<table border=0 width=100% id=parent><tr><td align=center>";
                echo "<img id=img src='../images/image2/gepot/GEPOT-4.webp' width=90%></img>";
                    echo "
                        <table class=child align=center width=90% cellpadding=5 cellspacing=2 border=0 bgcolor='#e0e0e0' style='margin: 0 auto;' class='f-thai'>
                            <tr height=25>";
                        echo "				
                                <td width=2% align=right></td>
                                <td width=20% align=right><font size=2 face=tahoma color=black><b>ผู้ทำแบบทดสอบ &nbsp; : &nbsp; </b></font></td>
                                <td width=70% align=left colspan=3><font size=2 face=tahoma color=black><b>&nbsp; $fname &nbsp; &nbsp; $lname </b></font></td>
                            </tr>
                            <tr  height=25>
                                <td></td>
                                <td width=20% align=right><font size=2 face=tahoma color=black><b>วันที่ทำการทดสอบ &nbsp; : &nbsp; </b></font></td>
                                <td align=left ><font size=2 face=tahoma color=black><b>&nbsp; $msg_date </b></font></td>
                            </tr>
                            <tr  height=25>
                                <td></td>
                                <td align=right width=20%><font size=2 face=tahoma color=black><b>
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
                                <td align=left >
                                    <font size=2 face=tahoma color=black><b>
                                        &nbsp; ตอบถูก $correct ข้อ &nbsp; &nbsp; ตอบผิด $wrong ข้อ &nbsp; &nbsp; ไม่ได้ตอบ $unans ข้อ &nbsp; &nbsp; คิดเป็น $percent %
                                    </b></font>
                                </td>
                            </tr>
                        </table>
                    ";
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
            if($each_percent[1]<=0)					        	{	$skill_msg[1] = $text_msg[0]; 	}
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
    <table align=center width=100% cellpadding=5 cellspacing=2 border=0 style='margin: 0 auto;' class='f-thai'>
        <tr height=25 >
            <td align=center width=25% bgcolor='#aaaaaa'><font size=2 face=tahoma color='#ffffff'><b>ทักษะ ( Skill )</b></font></td>
            <td align=center width=45% bgcolor='#aaaaaa' colspan=3><font size=2 face=tahoma color='#ffffff'><b>คะแนน ( Score )</b></font></td>
            <td align=center bgcolor='#aaaaaa'><font size=2 face=tahoma color='#ffffff'><b>ระดับความสามารถ ( Level )</b></font></td>
            <td align=center bgcolor='#aaaaaa'><font size=2 face=tahoma color='#ffffff'><b>CEFR</b></font></td>
        </tr>
        <tr height=25 >
            <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma><b>การฟัง ( Listening )</b></font></td>
            <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบถูก ".($correct_listening+0)." ข้อ </font></td>
            <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบผิด ".($wrong_listening+0)." ข้อ </font></td>
            <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ไม่ได้ตอบ ".($unans_lestening+0)." ข้อ </font></td>
            <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$skill_msg[1]</font></td>
            <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$cefr_skill[1]</font></td>
        </tr>
        <tr height=25>
            <td align=center bgcolor='#e0e0e0' colspan=3><font size=2 face=tahoma >
                <b>คิดเป็น ".(round($each_percent[1],2)+0)." / ".($correct_listening+$wrong_listening+$unans_lestening+0)." คะแนน </b>
            </font></td>
        </tr>
        <tr height=25 >
            <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma><b>การอ่าน ( Reading )</b></font></td>
            <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบถูก ".($correct_reading+0)." ข้อ </font></td>
            <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบผิด ".($wrong_reading+0)." ข้อ </font></td>
            <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ไม่ได้ตอบ ".($unans_reading+0)." ข้อ </font></td>
            <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$skill_msg[2]</font></td>
            <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$cefr_skill[2]</font></td>
        </tr>
        <tr height=25>
            <td align=center bgcolor='#e0e0e0' colspan=3><font size=2 face=tahoma >
                <b>คิดเป็น ".(round($each_percent[2],2)+0)." / ".($correct_reading+$wrong_reading+$unans_reading+0)." คะแนน </b>
            </font></td>
        </tr>
        <tr height=25 >
            <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma><b>ไวยากรณ์ ( Grammar )</b></font></td>
            <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบถูก ".(($correct_grammar)+0)." ข้อ </font></td>
            <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบผิด ".(($wrong_grammar)+0)." ข้อ </font></td>
            <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ไม่ได้ตอบ ".(($unans_grammar)+0)." ข้อ </font></td>
            <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$skill_msg[3]</font></td>
            <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$cefr_skill[3]</font></td>
        </tr>
        <tr height=25>
            <td align=center bgcolor='#e0e0e0' colspan=3><font size=2 face=tahoma >
                <b>คิดเป็น ".(round($each_percent[3],2)+0)." / ".($correct_grammar+$wrong_grammar+$unans_grammar+0)." คะแนน </b>
            </font></td>
        </tr>
    </table>";
            
            // ------------------ CEFR	--------------------------------
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
                
            //------------------------ CEFR
            if($percent<=0)					        {	$color_c[0] = $color_b;	}else{ $color_c[0] = $color_a; }
            if($percent>=0.25&&$percent<=15.75)	    {	$color_c[1] = $color_b;	}else{ $color_c[1] = $color_a; }
            if($percent>15.75&&$percent<=35.75)	    {	$color_c[2] = $color_b;	}else{ $color_c[2] = $color_a; }
            if($percent>35.75&&$percent<=60.75)	    {	$color_c[3] = $color_b;	}else{ $color_c[3] = $color_a; }
            if($percent>60.75&&$percent<=80.75)	    {	$color_c[4] = $color_b;	}else{ $color_c[4] = $color_a; }
            if($percent>80.75&&$percent<=99.75)	    {	$color_c[5] = $color_b;	}else{ $color_c[5] = $color_a; }
            if($percent>99.75&&$percent<=100)	    {	$color_c[6] = $color_b;	}else{ $color_c[6] = $color_bottom; }
            echo "
                <table class=child align=center width=90% cellpadding=5 cellspacing=2 border=0 style='margin: 0 auto;' class='f-thai'>
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
                    </table>";
                echo "</td></tr></table>";
                echo "</div>";
        
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
            $id = $temp_id[$x];
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
			// $num = $result->num_rows;		
			$fname = $data['fname'];		
			$lname = $data['lname'];
            //-------------------------------------------------------------------------------//
            $unans = (100 - ($correct + $wrong));
            $unans_lestening = (30 - ($correct_listening + $wrong_listening));
            $unans_reading = (40 - ($correct_reading + $wrong_reading));
            $unans_grammar = (30 - ($correct_grammar + $wrong_grammar));	
                
                //---------------------------------------------------------------------------------------//
                echo "<div class=parent align=center>";
                echo "<table border=0 width=90% id=parent><tr><td align=center>";
                echo "<img id=img src='../images/image2/gepot/GEPOT-4.webp' width=90%></img>";
                    echo "
                        <table class=child align=center width=90% cellpadding=5 cellspacing=2 border=0 bgcolor='#e0e0e0' style='margin: 0 auto;' class='f-thai'>
                            <tr height=25>";
                        echo "				
                                <td width=2% align=center></td>
                                <td width=20% align=right><font size=2 face=tahoma color=black><b>ผู้ทำแบบทดสอบ &nbsp; : &nbsp; </b></font></td>
                                <td width=70% align=left colspan=3><font size=2 face=tahoma color=black><b>&nbsp; $fname &nbsp; &nbsp; $lname </b></font></td>
                            </tr>
                            <tr  height=25>
                                <td></td>
                                <td width=20% align=right><font size=2 face=tahoma color=black><b>วันที่ทำการทดสอบ &nbsp; : &nbsp; </b></font></td>
                                <td align=left ><font size=2 face=tahoma color=black><b>&nbsp; $msg_date </b></font></td>
                            </tr>
                            <tr  height=25>
                                <td></td>
                                <td align=right width=20%><font size=2 face=tahoma color=black><b>
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
                                <td align=left >
                                    <font size=2 face=tahoma color=black><b>
                                        &nbsp; ตอบถูก $correct ข้อ &nbsp; &nbsp; ตอบผิด $wrong ข้อ &nbsp; &nbsp; ไม่ได้ตอบ $unans ข้อ &nbsp; &nbsp; คิดเป็น $percent %
                                    </b></font>
                                </td>
                            </tr>
                        </table>
                    ";
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
                //--------------------------------------------------//
                
                echo "
                    <table align=center width=100% cellpadding=5 cellspacing=2 border=0 style='margin: 0 auto;' class='f-thai'>
                        <tr height=25 >
                            <td align=center width=25% bgcolor='#aaaaaa'><font size=2 face=tahoma color='#ffffff'><b>ทักษะ ( Skill )</b></font></td>
                            <td align=center width=45% bgcolor='#aaaaaa' colspan=3><font size=2 face=tahoma color='#ffffff'><b>คะแนน ( Score )</b></font></td>
                            <td align=center bgcolor='#aaaaaa'><font size=2 face=tahoma color='#ffffff'><b>ระดับความสามารถ ( Level )</b></font></td>
                            <td align=center bgcolor='#aaaaaa'><font size=2 face=tahoma color='#ffffff'><b>CEFR</b></font></td>
                        </tr>
                        <tr height=25 >
                            <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma><b>การฟัง ( Listening )</b></font></td>
                            <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบถูก ".($correct_listening+0)." ข้อ </font></td>
                            <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบผิด ".($wrong_listening+0)." ข้อ </font></td>
                            <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ไม่ได้ตอบ ".($unans_lestening+0)." ข้อ </font></td>
                            <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$skill_msg[1]</font></td>
                            <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$cefr_skill[1]</font></td>
                        </tr>
                        <tr height=25>
                            <td align=center bgcolor='#e0e0e0' colspan=3><font size=2 face=tahoma >
                                <b>คิดเป็น ".(round($each_percent[1],2)+0)." / ".($correct_listening+$wrong_listening+$unans_lestening+0)." คะแนน </b>
                            </font></td>
                        </tr>
                        <tr height=25 >
                            <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma><b>การอ่าน ( Reading )</b></font></td>
                            <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบถูก ".($correct_reading+0)." ข้อ </font></td>
                            <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบผิด ".($wrong_reading+0)." ข้อ </font></td>
                            <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ไม่ได้ตอบ ".($unans_reading+0)." ข้อ </font></td>
                            <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$skill_msg[2]</font></td>
                            <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$cefr_skill[2]</font></td>
                        </tr>
                        <tr height=25>
                            <td align=center bgcolor='#e0e0e0' colspan=3><font size=2 face=tahoma >
                                <b>คิดเป็น ".(round($each_percent[2],2)+0)." / ".($correct_reading+$wrong_reading+$unans_reading+0)." คะแนน </b>
                            </font></td>
                        </tr>
                        <tr height=25 >
                            <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma><b>ไวยากรณ์ ( Grammar )</b></font></td>
                            <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบถูก ".(($correct_grammar)+0)." ข้อ </font></td>
                            <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบผิด ".(($wrong_grammar)+0)." ข้อ </font></td>
                            <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ไม่ได้ตอบ ".(($unans_grammar)+0)." ข้อ </font></td>
                            <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$skill_msg[3]</font></td>
                            <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$cefr_skill[3]</font></td>
                        </tr>
                        <tr height=25>
                            <td align=center bgcolor='#e0e0e0' colspan=3><font size=2 face=tahoma >
                                <b>คิดเป็น ".(round($each_percent[3],2)+0)." / ".($correct_grammar+$wrong_grammar+$unans_grammar+0)." คะแนน </b>
                            </font></td>
                        </tr>
                    </table>";
                
                // ------------------ CEFR	--------------------------------
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
                    
                //------------------------ CEFR
                if($percent<=0)					        {	$color_c[0] = $color_b;	}else{ $color_c[0] = $color_a; }
                if($percent>=0.25&&$percent<=15.75)	    {	$color_c[1] = $color_b;	}else{ $color_c[1] = $color_a; }
                if($percent>15.75&&$percent<=35.75)	    {	$color_c[2] = $color_b;	}else{ $color_c[2] = $color_a; }
                if($percent>35.75&&$percent<=60.75)	    {	$color_c[3] = $color_b;	}else{ $color_c[3] = $color_a; }
                if($percent>60.75&&$percent<=80.75)	    {	$color_c[4] = $color_b;	}else{ $color_c[4] = $color_a; }
                if($percent>80.75&&$percent<=99.75)	    {	$color_c[5] = $color_b;	}else{ $color_c[5] = $color_a; }
                if($percent>99.75&&$percent<=100)	    {	$color_c[6] = $color_b;	}else{ $color_c[6] = $color_bottom; }
                
                echo "
                <table class=child align=center width=90% cellpadding=5 cellspacing=2 border=0 style='margin: 0 auto;' class='f-thai'>
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
                        </table>
                    ";
                    echo "</td></tr></table><br><br><br>";
                    echo "</div>";
        
        }
        
    }
}
function pre_page(){
    ?>
<style type="text/css">
@media print {
    .parent {
        overflow: scroll;
        display: block;
        width: 100%;
    }

    table#parent {
        width: 100%;
    }

    img#img {
        width: 100%
    }

    table.child {
        width: 100%
    }

}
</style>
<?php
        }
?>