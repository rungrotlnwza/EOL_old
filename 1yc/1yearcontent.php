<?php
ob_start();
session_start();
include('../config/connection.php');
date_default_timezone_set('Asia/Bangkok');

if ($_SESSION['x_member_1year'] != '') {
    $strSQL = "SELECT * FROM tbl_x_member_1year WHERE id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $_SESSION['x_member_1year']);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_have = $result->num_rows;
    if ($is_have) {
        $data = $result->fetch_array();
    }

    $SQL = "SELECT logid FROM  tbl_x_log_member_1year WHERE id = ? ORDER BY logdate DESC LIMIT 0,1";
    $query = $conn->prepare($SQL);
    $query->bind_param("s", $_SESSION['x_member_1year']);
    $query->execute();
    $result = $query->get_result();
    $is_have = $result->num_rows;
    if ($is_have == 1) {
        $logtime = $result->fetch_array();
        $now = date("Y-m-d H:i:s");
        $str = "UPDATE tbl_x_log_member_1year SET outdate = ? WHERE logid = ? ";
        $sub_query = $conn->prepare($str);
        $sub_query->bind_param("ss", $now, $logtime['logid']);
        $sub_query->execute();
        $sub_query->close();
    }
    $query->close();
    mysqli_close($conn);
}
else {
    header("Location:../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>หลักสูตรเรียนภาษาอังกฤษออนไลน์ 1 ปี</title>
    <link rel="shortcut icon" type="image/x-icon" href="../images/image2/1year/1 year icon.ico">
    <link rel="stylesheet" href="../bootstrap/css/1yearcontent.css">
</head>

<body>
    <img src="../images/image2/1year/lessons(bg)-01.jpg" class="bg">
    <a href="../1yearcourse.php" title="Home">
        <img src="../images/image2/1year/button/home-08.png" width="45" height="43"
            style="position:absolute;z-index:250;left:50%;margin-left:350px;top:8px;">
    </a>

    <div style="position:relative;">
        <div class="head">
            <center>
                <img src="../images/image2/1year/status-02.png"
                    style="position:absolute;z-index:200;left:50%;margin-left:-680px; border-bottom-left-radius: 35%; border-bottom-right-radius: 35%;">
            </center>
        </div>

        <br>

        <a href="../inc/logout.php" title="logout">
            <img src="../images/image2/1year/button/log-out.png" width="45" height="42"
                style="position:absolute;z-index:250;left:50%;margin-left:420px;top:9px;"></a>
        <div style="position:absolute;z-index:200;left:50%;margin-left:-470px; top:15px;font-weight:bold;">
            Welcome :
            <?php
if ($data['fname'] == "") {
    echo $data['user'];
}
else {
    echo $data['fname'];
}
?>
        </div>
        <div style="position:relative; width: 1050px;margin: 0px auto; top: 60px;">
            <img src="<?php
if ($_GET['section'] === 'logtime') {
    echo '../images/image2/1year/font(record).png';
}
else if ($_GET['section'] === 'faq') {
    echo '../images/image2/1year/font(Q&A).png';
}
elseif ($_GET['section'] === 'management') {
    // echo '../images/image2/1year/button/management.png';
    echo '../images/image2/1year/font(record).png';
}
else {
    echo '../images/image2/1year/font(lessons).png';
}
?>" style="float:left;margin-left:30%;margin-top:50px;">
            <div style="position:absolute;float:left;margin-left:50px;margin-top:90px;z-index:200;">
                <a href="1yearlist.php" style="width:200px;height:100px;">
                    <img src="../images/image2/1year/button/back.png">
                </a>
            </div>
            <img src="../images/image2/1year/logo 1 year.png" style="float:right;">
        </div>
    </div>
    <div style="position:relative; width: 1050px; margin: 0px auto;">
        <div class="pjblock" align="center">
            <table style="font-size:10pt;">
                <tr>
                    <td>
                        <br><br>
                        <table width=90% align=center style='z-index:500;'>
                            <tr>
                                <td style='padding:10px;'>
                                    <div align=left style='background:#fff;padding:10px;width:1020px;min-height:300px;height:auto;-moz-box-shadow: 0px 5px 18px #333;margin-top:77px;
                               -webkit-box-shadow:  0px 5px 18px #333;
                               box-shadow:0px 5px 18px #333; border-radius: 8px;'>
                                        <table width=80% align=center style='z-index:500;'>
                                            <tr>
                                                <td>
                                                    <?php
if ($_GET['section'] === 'logtime') {
    timeLog();
}
elseif ($_GET['section'] === 'faq') {
    faq_ans();
}
elseif ($_GET['section'] === 'management') {
    if ($_GET['action'] === 'delete' && $_GET['member_id']) {
        delete_user();
    }
    else {
        management();
    }
}
else {
    main_lesson();
}
?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <br><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class='modal1' id='prompt3'>
        <h2> Edit User Account</h2>
        <!-- input form. you can press enter too -->
        <form method="post" action=''>
            <b>New Username :</b> <input type="text" name="rename-Acc" id="rename-Acc"
                style="width:195px; height:25px; border:1px solid #666;margin-left:16px;padding-left:5px;">
            <input type="text" name="idre-acc" id="idre-acc" readonly style="border:none;color:#fff;width:70px;"
                class="txt_rename"><br><br>
            <b>New Password :</b><input type="password" name="pwd" id="pwd"
                style="width:200px; height:25px; border:1px  solid #666;margin-left:22px;"><br><br>
            <b>Re-New password :</b><input type="password" name="re-pwd" id="re-pwd"
                style="width:200px; height:25px; border:1px  solid #666;"><br><br><br>
            <div id="imgload" style="display:none; margin-top:10px; margin-left:130px;"> <img
                    src="../images/image2/eol system/loading2.gif" /></div>
            <div id="editerror" style="margin-top:-20px;float:right;height:30px;width:250px;"></div>
            <input type="button" id="btn_rename" value="Save" class="btntest btn-save"
                style="cursor:pointer;margin-left:130px;" onclick="edit_userAcc_Call()" />
            <input type="button" value="Cancel" class="close btntest btn-cancel"
                style="cursor:pointer;margin-left:30px;" />
        </form>
    </div>

    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery-tools/1.2.7/jquery.tools.min.js'>
    </script>

    <script type="text/javascript">
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

    $(document).ready(function() {
        var triggers = $('.modalInput').overlay({
            mask: {
                color: '#666',
                loadSpeed: 100,
                opacity: 0.7
            },

            closeOnClick: true,
            top: 100
        });
        MM_preloadImages();
    });

    function addfaq() {
        if ($('#txtfaq').val() != '') {
            $.ajax({
                type: "POST",
                url: "managefaq.php",
                data: {
                    faqtopic: $('#txtfaq').val(),
                },
                beforeSend: function() {
                    $("#imag_load").show();
                },
                complete: function() {
                    $("#imag_load").hide();
                },
                success: function(response) {
                    if (response != 'NO') {
                        $(".divshowfaq").prepend(response);
                        $("#diverror").hide();
                    } else {
                        $("#diverror").show();
                    }
                    $("#imag_load").hide();
                    $("#txtfaq").val('');
                },
                error: function(error) {
                    //$("#showpost").append('<p align="center">ข้อมูลผิดพลาด</p>');
                },
            });
        }
    }

    function ans(id) {
        if ($('#txtfaq').val() != '') {
            $.ajax({
                type: "POST",
                url: "managefaq.php",
                data: {
                    detail: $('#txtfaq').val(),
                    faqid: id
                },
                beforeSend: function() {
                    $("#imag_load").show();
                },
                complete: function() {
                    $("#imag_load").hide();
                },
                success: function(response) {
                    if (response != 'NO') {
                        $(".listfaq").append(response);
                        $("#diverror").hide();
                    } else {
                        $("#diverror").show();
                    }
                    $("#imag_load").hide();
                    $("#txtfaq").val('');
                },
                error: function(error) {
                    //$("#showpost").append('<p align="center">ข้อมูลผิดพลาด</p>');
                },
            });
        }
    }

    function edit_userAcc(Obj) {
        var id = Obj.id;
        $("#rename-Acc").val($("#userdata_" + id).text());
        $("#idre-acc").val(id);
        $("#pwd").val("")
        $("#re-pwd").val("")
        $("#editerror").html("");
    }

    function edit_userAcc_Call() {
        var idacc = $("#idre-acc").val();
        let page = getUrlVars()["page"];

        if (!page) {
            page = '1';
        }
        $.ajax({
            type: "POST",
            url: "editAccount.php",
            data: {
                rename: $("#rename-Acc").val(),
                newpass: $("#pwd").val(),
                repass: $("#re-pwd").val(),
                member: idacc
            },
            beforeSend: function() {
                $("#imgload").show();
            },
            complete: function() {
                $("#imgload").hide();
            },
            success: function(response) {
                if (response == 'OK') {
                    window.location = "1yearcontent.php?section=management&&page=" + page;
                } else {
                    $("#editerror").html(response);
                }
            },
            error: function(error) {
                $("#editerror").html(error);
            }
        });
    }

    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m, key, value) {
            vars[key] = value;
        });
        return vars;
    }
    </script>
</body>

</html>

<?php
function timeLog()
{
    include('../config/connection.php');
    $fullName = "";
    if (isset($_GET['member_id'])) {
        $member_id = trim($_GET['member_id']);
        $strSQL = "SELECT * FROM tbl_x_member_1year WHERE id = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $member_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_array();

        if (trim($data['fname']) && trim($data['lname'])) {
            $fullName = "<font size=3 color='red'>" . $data['fname'] . "  " . $data['lname'] . "</font>";
        }
        else {
            $fullName = "<font size=3 color='red'> - </font>";
        }
        $stmt->close();
        $SQL = "SELECT * FROM tbl_1year_result WHERE member_id = ?";
        $query = $conn->prepare($SQL);
        $query->bind_param("s", $member_id);
        $query->execute();
        $result = $query->get_result();
        $is_have = $result->num_rows;
        $percent = [];
        $etest_id = [];
        $test_time = [];
        $j = 1;
        echo "<table align=center width=100% cellpadding=5 cellspacing=1 border=0 >
                <tr>
                    <td colspan=2>" . $fullName . "</td>
                </tr>";
        if ($is_have >= 1) {
            while ($sub_data = $result->fetch_assoc()) {
                $etest_id[$j] = $sub_data['etest_id'];
                $percent[$j] = $sub_data['score'];
                if ($etest_id[$j] == 136) {
                    #ทดสอบครั้งที่ 1
                    $test_time[$j] = "1";
                }
                elseif ($etest_id[$j] == 137) {
                    #ทดสอบครั้งที่ 2
                    $test_time[$j] = "2";
                }
                else {
                    #ทดสอบครั้งที่ 3
                    $test_time[$j] = "3";
                }
                echo "<tr height=25>
                        <td align=left width=4%>
                            <b>การประเมินผลครั้งที่ &nbsp; : &nbsp; $test_time[$j] </b>
                        </td>
                        <td align=left width=20%>
                            <b>&nbsp; คะแนนที่ได้ &nbsp; : &nbsp; คิดเป็น $percent[$j] % </b>
                        </td>
                     </tr>";
                $j++;
            }
        }
        else {
            echo "<tr>
                     <td><font size=2 face=tahoma color=green>&nbsp;&nbsp;-ไม่มีคะแนนประเมินผล</font></td>
                  </tr>";
        }
        echo "</table>";
        $query->close();


    }
    else {
        $member_id = $_SESSION['x_member_1year'];
    }
    $strSQL = "SELECT * FROM tbl_x_log_member_1year WHERE id = ? ORDER BY logdate DESC";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $re_num = $result->num_rows;

    if ($re_num >= 1) {
        echo "	<br>	
				<table align=center width=100% cellpadding=5 cellspacing=1 border=0 >
					<tr>
						<td width=35% bgcolor='#aaaaaa' align=center><font size=2 face=tahoma color=white><b>Last login</b></font></td>
						<td width=20% bgcolor='#aaaaaa' align=center><font size=2 face=tahoma color=white><b>From</b></font></td>
						<td width=20% bgcolor='#aaaaaa' align=center><font size=2 face=tahoma color=white><b>Untill</b></font></td>
						<td width=20% bgcolor='#aaaaaa' align=center><font size=2 face=tahoma color=white><b>Total time</b></font></td>
					</tr>";

        for ($k = 1; $k <= $re_num; $k++) {
            $data = $result->fetch_array();
            $splittime1 = explode(" ", $data['logdate']);
            $splittime2 = explode(" ", $data['outdate']);
            $timediff[$k] = diff2time($splittime1[1], $splittime2[1]);
            $lastime = $data["logdate"];
            $hour = floor($timediff[$k] / 60);
            if ($hour > 0) {
                $htxt = $hour . " ชั่วโมง ";
            }
            else {
                $htxt = "";
            }

            $total = "<font color=green title='$lastime'> $htxt " . floor($timediff[$k] % 60) . ' นาที </font>';
            //------------------------------------------------------------------------------------------//

            echo "
                    <tr>
                        <td bgcolor='#f0f0f0' align=left>
                            <font size=2 face=tahoma color='blue'>&nbsp;&nbsp;" . process_date(strtotime($data['logdate'])) . "</font>
                        </td>
                        <td bgcolor='#f0f0f0' align=center>
                            <font size=2 face=tahoma color='brown'>$data[logdate]</font>
                        </td>
                        <td bgcolor='#f0f0f0' align=center>
                            <font size=2 face=tahoma color='green'>$data[outdate]</font>
                        </td>
                        <td bgcolor='#f0f0f0' align=center>
                            <font size=2 face=tahoma color='red'>$total</font>
                        </td>
                    </tr>";

        }
        $hour = floor(array_sum($timediff) / 60);
        if ($hour > 0) {
            $htxt = $hour . " ชั่วโมง ";
        }
        $sum = "<font color=red > $htxt " . floor(array_sum($timediff) % 60) . ' นาที </font>';
        echo "  <tr>
					<td bgcolor='#f0f0f0' align=center >
                        <font size=2 face=tahoma color='brown'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
                    </td>
					<td bgcolor='#f0f0f0' align=center >
                        <font size=2 face=tahoma color='brown'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
                    </td>
				    <td bgcolor='#f0f0f0' align=center>
                        <font size=2 face=tahoma color='red'><b>รวมเวลา</b></font>
                    </td>				
				    <td bgcolor='#f0f0f0' align=center>
                        <font size=2 face=tahoma color='red'>$sum</font>
                    </td>	
				</tr>
			</table>";

    }
    else {
        echo "<center><h3 style='color:red;'> - No data -</h3></center>";
    }
    $stmt->close();
    mysqli_close($conn);
}

function faq_ans()
{
    if ($_GET['section'] == 'faq' && $_GET['faqId'] && ($_SESSION['x_member_1year'] == 1)) {
        //Admin page ans
        detailFaq();
        formAns();
    }
    else if ($_GET['section'] == 'faq' && $_GET['faqId']) {
        //member page ans
        detailFaq();
        formAns();
    }
    else if ($_GET['section'] == 'faq') {
        //member page
        main_faq();
    }
    else {
        echo 'No page';
    }
}

function main_lesson()
{
    include('../config/connection.php');
    $topic_id = $conn->real_escape_string($_GET["topic_id"]);
    $strSQL = "SELECT * FROM tbl_web_topic WHERE topic_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $topic_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_have = $result->num_rows;
    if ($is_have) {
        $data = $result->fetch_array();
        $detail = stripslashes($data['topic_detail']);
        echo $detail;
    }
    $stmt->close();
    mysqli_close($conn);
}
function diff2time($time_a, $time_b)
{
    $now_time1 = strtotime(date("Y-m-d " . $time_a));
    $now_time2 = strtotime(date("Y-m-d " . $time_b));
    $time_diff = abs($now_time2 - $now_time1);
    // $time_diff_h=floor($time_diff/3600); // จำนวนชั่วโมงที่ต่างกัน  
    // $time_diff_m=floor(($time_diff%3600)/60); // จำวนวนนาทีที่ต่างกัน  
    $time_diff_m = floor($time_diff / 60);
    // $time_diff_s=($time_diff%3600)%60; // จำนวนวินาทีที่ต่างกัน  
    return $time_diff_m;

}

function process_date($timestamp)
{
    $diff = time() - $timestamp;
    $periods = array("วินาที", "นาที", "ชั่วโมง");
    $word = "ที่แล้ว";
    if ($diff < 60) { // second
        $i = 0;
        $diff = ($diff == 1) ? "" : $diff;
        $text = "$diff $periods[$i]$word";
    }
    else if ($diff < 3600) { // minutes
        $i = 1;
        $diff = round($diff / 60);
        $diff = ($diff == 3 || $diff == 4) ? "" : $diff;
        $text = "$diff $periods[$i]$word";
    }
    else if ($diff < 86400) { // hours
        $i = 2;
        $diff = round($diff / 3600);
        $diff = ($diff != 1) ? $diff : "" . $diff;
        $text = "$diff $periods[$i]$word";
    }
    else if ($diff < 172800) { // days
        $diff = round($diff / 86400);
        $text = "$diff  วันที่แล้ว เมื่อเวลา " . date("G:i", $timestamp) . " น.";
    }
    else {
        $thMonth = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $date = date("j", $timestamp);
        $month = $thMonth[date("m", $timestamp) - 1];
        $y = date("Y", $timestamp) + 543;
        $t1 = "$date $month $y";
        $t2 = "$date $month";
        if ($timestamp > strtotime(date("Y-01-01 00:00:00"))) {
            $text = " เมื่อวันที่ " . $t2 . " เวลา " . date("G:i ", $timestamp) . " น.";
        }
        else {
            $text = " เมื่อวันที่ " . $t1 . " เวลา " . date("G:i ", $timestamp) . " น.";
        }
    }
    return $text;
}

function detailFaq()
{
    include('../config/connection.php');
    $faqId = $conn->real_escape_string($_GET["faqId"]);
    $strSQL = "UPDATE tbl_x_faq1year SET view = view+1 WHERE faqId = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $faqId);
    $stmt->execute();
    $stmt->close();

    $SQL = "SELECT m.user, m.fname, f.faqId, f.topic, f.date, f.view FROM tbl_x_faq1year f, tbl_x_member_1year m WHERE m.id = f.userId && f.faqId = ?";
    $query = $conn->prepare($SQL);
    $query->bind_param("s", $faqId);
    $query->execute();
    $result = $query->get_result();
    $data = $result->fetch_array();
    $name_ques = $data['fname'] ? $data['fname'] : $data['user'];

    $str = "SELECT * FROM tbl_x_member_1year  WHERE id = ?";
    $sub_stmt = $conn->prepare($str);
    $sub_stmt->bind_param("s", $_SESSION['x_member_1year']);
    $sub_stmt->execute();
    $result = $sub_stmt->get_result();
    $data_admin = $result->fetch_array();
    $admin = $data_admin['admin'];
    $sub_stmt->close();

    echo "  <div class='divshowfaq'>
			    <div class='listfaq' id='$data[faqId]'>
			        <p><b>$name_ques</b></p>
					<div class='txtcontent'>
			            <p>$data[topic]</p>
						<p align=right>" . process_date(strtotime($data['date'])) . "</p>
					</div>";

    $strSQL = "SELECT m.user, m.fname, f.faqId, f.detail, f.date, f.ansId FROM tbl_x_faq_ans1year f, tbl_x_member_1year m WHERE m.id = f.userId && f.faqId = ? ORDER BY f.ansId ASC";
    $sub_query = $conn->prepare($strSQL);
    $sub_query->bind_param("s", $data['faqId']);
    $sub_query->execute();
    $result = $sub_query->get_result();

    if ($admin == 1) {
        while ($data = $result->fetch_array()) {
            $name_ans = $data['fname'] ? $data['fname'] : $data['user'];
            echo "
					<div class='txtcontentsub' style='margin-left:20px;'>
					    <p><b>Answer :</b></p>
			            <p>$data[detail]</p>
						    <font style='float:left;'>By : $name_ans</font><font style='float:right;'>" . process_date(strtotime($data['date'])) . " </font>
						    <br>
						<div class='delete'>  
						    <a href='#' onclick=\"javascript:
							    if(confirm('Do you want to delete this answer ?'))
							    {	window.location='1yearcontent.php?section=faq&faqId=$_GET[faqId]&delfaq=$data[ansId]&action=delfaq';	}
						    \">ลบ </a>
						</div>
						<div class='clear'></div>
					</div>";
        }
        if ($_GET['action'] == "delfaq") {
            include('../config/connection.php');
            $strSQL = "DELETE FROM tbl_x_faq_ans1year WHERE ansId = ? && faqId = ? ";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("ss", $_GET['delfaq'], $_GET['faqId']);
            $stmt->execute();
            $stmt->close();
            header("Location:?section=$_GET[section]&faqId=$_GET[faqId]");
        }
        if ($_GET['action'] == "delete_faq") {

            $strSQL = "SELECT * FROM tbl_x_faq1year WHERE faqId = ? ";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("s", $_GET['faqId']);
            $stmt->execute();
            $result1 = $stmt->get_result();
            $is_faq = $result1->num_rows;
            $stmt->close();

            $SQL = "SELECT * FROM tbl_x_faq_ans1year WHERE faqId = ? ";
            $query = $conn->prepare($SQL);
            $query->bind_param("s", $_GET['faqId']);
            $query->execute();
            $result2 = $query->get_result();
            $is_faq_ans = $result2->num_rows;
            $query->close();

            if ($is_faq_ans >= 1) {
                $SQL = "DELETE FROM tbl_x_faq_ans1year WHERE faqId = ? ";
                $query = $conn->prepare($SQL);
                $query->bind_param("s", $_GET['faqId']);
                $query->execute();
                $query->close();
            }

            if ($is_faq == 1) {
                $strSQL = "DELETE FROM tbl_x_faq1year WHERE faqId = ? ";
                $stmt = $conn->prepare($strSQL);
                $stmt->bind_param("s", $_GET['faqId']);
                $stmt->execute();
                $stmt->close();
            }
            header("Location:?section=$_GET[section]&page=1");
        }
    }
    while ($data = $result->fetch_array()) {
        $name_ans = $data['fname'] ? $data['fname'] : $data['user'];
        echo "
				<div class='txtcontentsub' style='margin-left:20px;'>
					<p><b>Answer :</b></p>
			        <p>$data[detail]</p>
					<font style='float:left;'>By : $name_ans </font><font style='float:right;'>" . process_date(strtotime($data['date'])) . " </font>
					<div class='clear'></div>
				</div>";
    }
    echo "
		    </div>
		</div>";
    $sub_query->close();
    mysqli_close($conn);
}

function formAns()
{
    echo "  <div class='divfaq' style='margin-top:50px;'>
                <form  id='faq_form' name='faq_form' >
                ตอบกลับ : 
                <br>
                <br>
                <textarea id='txtfaq' name='txtfaq' class='tx'  maxlength='1000'></textarea><br><br>
                        <input type='button' id='btnfaq' class='btn' value='Post' onclick='ans($_GET[faqId])'>
                        <input type ='reset'  class='btn' value='Cancel'/>
                </form>
			    <br>
			    <img id='imag_load' src='../images/image2/eol system/loading2.gif' style='display:none; margin-left:100px;' ><br>
		    </div>";
}

function main_faq()
{
    include('../config/connection.php');
    echo "  <div class='divfaq'>
                <form  id='faq_form' name='faq_form' >
                    หัวข้อ : 
                    <br>
                    <br>
                    <textarea id='txtfaq' class='tx'  maxlength='1000'></textarea>
                    <br><br>
                    <input type='button' id='btnfaq' class='btn' value='Post' onclick='addfaq()'>
                    <input type ='reset'  class='btn' value='Cancel'/>
                </form>
			    <br>
			    <img id='imag_load' src='../images/image2/eol system/loading2.gif' style='display:none; margin-left:100px;' ><br>
			    <label id='diverror' style='display:none; margin-left:100px;'>มีความผิดพลาดในการเพิ่มข้อมูล</label>
			</div>
			<div class='divshowfaq'>";

    $strSQL = "SELECT * FROM tbl_x_member_1year  WHERE id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $_SESSION['x_member_1year']);
    $stmt->execute();
    $result = $stmt->get_result();
    $data_admin = $result->fetch_array();
    $admin = $data_admin['admin'];
    $stmt->close();

    $start = ($_GET['page'] - 1) * 10;
    $end = $start + 10;

    if ($admin == 1) {

        $SQL = "SELECT m.user, m.fname, f.faqId, f.topic, f.date, f.view
        FROM  tbl_x_faq1year f, tbl_x_member_1year m
        WHERE m.id = f.userId ORDER BY f.faqId DESC
        limit $start , $end";
        $stmt = $conn->prepare($SQL);
        $stmt->execute();
        $result1 = $stmt->get_result();

        $str = "SELECT m.fname, f.faqId, f.topic, f.date, f.view
        FROM  tbl_x_faq1year f, tbl_x_member_1year m
        WHERE m.id = f.userId ORDER BY f.faqId DESC";
        $query = $conn->prepare($str);
        $query->execute();
        $result2 = $query->get_result();
    }
    else {
        $SQL = "SELECT m.user, m.fname, f.faqId, f.topic, f.date, f.view
        FROM  tbl_x_faq1year f, tbl_x_member_1year m
        WHERE f.userId = ? && m.id = f.userId ORDER BY f.faqId DESC
        limit $start , $end";
        $stmt = $conn->prepare($SQL);
        $stmt->bind_param("s", $_SESSION['x_member_1year']);
        $stmt->execute();
        $result1 = $stmt->get_result();

        $str = "SELECT m.fname, f.faqId, f.topic, f.date, f.view
        FROM  tbl_x_faq1year f, tbl_x_member_1year m
        WHERE f.userId = ? && m.id = f.userId ORDER BY f.faqId DESC";
        $query = $conn->prepare($str);
        $query->bind_param("s", $_SESSION['x_member_1year']);
        $query->execute();
        $result2 = $query->get_result();
    }
    $max_results = 10;
    $total_results = $result2->num_rows;
    $total_pages = ceil($total_results / $max_results);
    $query->close();
    if ($admin == 1) {
        while ($data = $result1->fetch_array()) {
            $name_ques = $data['fname'] ? $data['fname'] : $data['user'];
            $topic = htmlentities($data['topic']);
            echo "  <div class='listfaq' id='$data[faqId]'>
			            <p><b>$name_ques</b></p>
					    <div class='txtcontent'>
					        <p><b>Question : </b></p>
			                <a href='1yearcontent.php?section=faq&faqId=$data[faqId]'><p>$topic</p></a>
						    <p align=right>" . process_date(strtotime($data['date'])) . "   </p>
						    <div class='delete'>
						        <a href='#'
							        onclick=\"javascript:
							        if(confirm('Do you want to delete this Q&A ?'))
							        {	window.location='1yearcontent.php?section=faq&page=1&action=delete_faq&faqId=$data[faqId]';	}
						        \">ลบ</a>
                            </div>
					    </div>";

            $strSQL = "SELECT m.user, m.fname, f.faqId, f.detail, f.date
            FROM tbl_x_faq_ans1year f, tbl_x_member_1year m
            WHERE m.id = f.userId && f.faqId = ? ORDER BY f.ansId ASC";
            $sub_stmt = $conn->prepare($strSQL);
            $sub_stmt->bind_param("s", $data['faqId']);
            $sub_stmt->execute();
            $result = $sub_stmt->get_result();

            while ($data_sub = $result->fetch_array()) {
                $name_ans = $data_sub['fname'] ? $data['fname'] : $data_sub['user'];
                $detail = htmlentities($data_sub['detail']);
                echo "
					    <div class='txtcontentsub' style='margin-left:20px;'>
					        <p><b>Answer :</b></p>
			                <p>$detail</p>
						    <font style='float:left;'>By : $name_ans </font><font style='float:right;'>" . process_date(strtotime($data_sub['date'])) . " </font>
					        <div class='clear'></div>
					    </div>";
            }
            echo "  </div>";
            $sub_stmt->close();
        }
    }

    while ($data = $result1->fetch_array()) {
        $name_ques = $data['fname'] ? $data['fname'] : $data['user'];
        echo "  <div class='listfaq' id='$data[faqId]'>
			        <p><b>$name_ques</b></p>
					<div class='txtcontent'>
					    <p><b>Question : </b></p>
			            <a href='1yearcontent.php?section=faq&faqId=$data[faqId]'><p>$data[topic]</p></a>
						<p align=right>" . process_date(strtotime($data['date'])) . "   </p>
					</div>";

        $strSQL = "SELECT m.user, m.fname, f.faqId, f.detail, f.date
                FROM tbl_x_faq_ans1year f, tbl_x_member_1year m
                WHERE m.id = f.userId && f.faqId = ? ORDER BY f.ansId ASC";
        $sub_stmt = $conn->prepare($strSQL);
        $sub_stmt->bind_param("s", $data['faqId']);
        $sub_stmt->execute();
        $result = $sub_stmt->get_result();

        while ($data_sub = $result->fetch_array()) {
            $name_ans = $data_sub['fname'] ? $data['fname'] : $data_sub['user'];
            echo "
                    <div class='txtcontentsub' style='margin-left:20px;'>
                        <p><b>Answer :</b></p>
                        <p>$data_sub[detail]</p>
                        <font style='float:left;'>By : $name_ans </font><font style='float:right;'>" . process_date(strtotime($data_sub['date'])) . " </font>
                        <div class='clear'></div>
                    </div>";
        }
        echo " </div>";
        $sub_stmt->close();
    }
    $stmt->close();
    echo "</div>";

    echo "<div class='page' id='$_GET[page]'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($_GET["page"] == $i) {
            $color = "#DF013A";
        }
        else {
            $color = "black";
        }
        echo "<a href='1yearcontent.php?section=faq&page=$i' style='color:$color;'>$i</a>&nbsp&nbsp&nbsp";
    }
    echo "</div>";
    mysqli_close($conn);

}

function management()
{
    include('../config/connection.php');
    $active = 1;
    $per_page = 20;
    if ($_GET["page"] && ($_GET["page"] - $_GET["page"] == 0 && $_GET["page"] >= 1)) {
        $page = $_GET["page"];
    }
    else {
        $page = 1;
    }
    $search_name = isset($_POST['search']) ? trim($_POST['search']) : '';
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../bootstrap/css/form-search-lesson-topic.css">
<style type="text/css">
/* Styles for wrapping the search box */
.main {
    width: 40%;
    margin: 10px 266px 1px auto;
    position: relative;
    right: -260px;
}
</style>
<div class="main">
    <!-- Another variation with a button -->
    <form action="?section=<?= $_GET['section']?>" method="post">
        <div class="input-group">
            <input name="search" type="text" class="form-control" placeholder="Search by Firstname or Username"
                value="<?= $search_name?>">
            <div class="input-group-append">
                <button class="btn btn-secondary" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </form>
</div>
<?php
    $SQL = "SELECT * FROM tbl_x_member_1year WHERE active = ? ORDER BY time_login DESC";
    $query = $conn->prepare($SQL);
    $query->bind_param("s", $active);
    $query->execute();
    $result = $query->get_result();
    $total_page = $result->num_rows;
    $query->close();

    if ($per_page != $total_page) {
        $all_page = $total_page / $per_page;
        $arr = explode(".", $all_page);
        if ($arr[1] >= 1) {
            $all_page = $arr[0] + 1;
        }
        else {
            $all_page = $arr[0];
        }
    }
    else {
        $all_page = 1;
    }
    $start = ($page - 1) * $per_page;
    $limit = " limit $start,$per_page";
    if (isset($_POST['search'])) {
        $search = isset($_POST['search']) ? trim($_POST['search']) : '';
        echo $search . '<br>';
        $topic = "%{$search}%";
        $strSQL = "SELECT * FROM tbl_x_member_1year WHERE active = ? && user like '$topic' OR fname like '$topic'";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $active);
        $stmt->execute();
        $result = $stmt->get_result();
        $num = $result->num_rows;
        $all_page = 1;
        echo $num;
        if ($num == 0) {
            echo "  <hr><br>
                    <table align=center width=95% cellpadding=0 cellspacing=0 border=0 >
                        <tr valign=top height=30 align=center>
                            <td align=center width=95%><font size=3 face=tahoma color=red><b>Sorry!!! Not Found Data </b></font></td>
                        </tr>
                        <tr valign=top height=30 align=center>
                            <td align=center width=95%><font size=3 face=tahoma color=red> Please try again </font></td>
                        </tr>
                    </table>";
        }
    }
    else {
        $strSQL = "SELECT * FROM tbl_x_member_1year WHERE active = ? ORDER BY time_login DESC $limit";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $active);
        $stmt->execute();
        $result = $stmt->get_result();
        $num = $result->num_rows;
    }

    if ($num >= 1) {

        echo "<br><table align=center width=80% cellpadding=0 cellspacing=2 border=0  class='noborder table-admin table' >
        <form id='member_list' name='member_list' method=post >
            <tr height=55>
                <td width=25% bgcolor='#676868' align=center><font size=2 face=tahoma color=white><b>First name - Last name</b></font></td>
                <td width=17% bgcolor='#676868' align=center><font size=2 face=tahoma color=white><b>Username</b></font></td>
                <td width=17% bgcolor='#676868' align=center><font size=2 face=tahoma color=white><b>Password</b></font></td>
                <td width=19% bgcolor='#676868' align=center><font size=2 face=tahoma color=white><b>Oprerating time</b></font></td>
                <td width=20% bgcolor='#676868' align=center color=white><font size=2 face=tahoma color=white><b>Management</b></font></td>
            </tr>";

        for ($i = 1; $i <= $num; $i++) {
            $htxt = NULL;
            $hour = NULL;
            $splittime1 = NULL;
            $splittime2 = NULL;
            $stop_msg = "";
            $data = $result->fetch_array();
            $user[$i] = $data['user'];
            $pass[$i] = $data['pass'];
            $id[$i] = $data['id'];
            if (trim($data['fname']) && trim($data['lname'])) {
                $is_mem = "true";
                $fname[$i] = trim($data['fname']);
                $lname[$i] = trim($data['lname']);
            }
            else {
                $is_mem = "false";
                $msg_name = "<div align=center><font color=red face=tahoma size=2> - </font></div>";
            }
            if (trim($data['time_login'])) {
                $lastime = $data['time_login'];
                $stop_msg = "<font color=red title='เข้าใช้ครั่งล่าสุดเมื่อ " . $lastime . "'> " . $lastime . "</font>";
            }
            else {
                $stop_msg = "<font color='red'> - </font>";
            }
            if ($is_mem == "true") {
                $msg_name = "<table align=center width=100% cellpadding=0 cellspacing=0 border=0 >
                                    <tr class='line_name'>
                                        <td align=left width=50%>
                                            &nbsp;" . $fname[$i] . "&nbsp;
                                        </td>
                                        <td align=left width=50%>
                                            &nbsp;" . $lname[$i] . "&nbsp;
                                        </td>
                                    </tr>
                             </table>";
            }
            if ($i % 2 == 0) {
                $color = "#f0f0f0";
            }
            else {
                $color = "#f7f7f7";
            }
            echo "
                <tr height=28 class='line_hover'>
                    <td bgcolor='$color' align=left> <font face=tahoma size=2>$msg_name</font></td>
                    <td bgcolor='$color' align=center><font size=2 face=tahoma id='userdata_$id[$i]'><b>$user[$i]</b></font></td>
                    <td bgcolor='$color' align=center><font size=2 face=tahoma ><b>$pass[$i]</b></font></td>
                    <td bgcolor='$color' align=center><font size=2 face=tahoma >$stop_msg</font></td>
                    <td bgcolor='$color' align=center>
                        <button class='modalInput' rel='#prompt3' type='botton' style='width:20px;background:none; border:none;margin-right:20px;' id='$id[$i]' onclick='edit_userAcc(this)'><img src='../images/icon/edit.png' border=0 style='width:20px;cursor:pointer;margin-right:15px;'
                            title='Edit Username and Password'
                        ></button>
                        <img src='../images/icon/bin.png' border=0 style='width:13%;cursor:pointer;'
                            title='Delete this User Account'
                            onclick=\"javascript:
                                        if(confirm('Do you want to delete this account?'))
                                        {	window.location='?section=$_GET[section]&&action=delete&&member_id=$id[$i]&&page=$page';	}
                                    \"
                        >
                        <a target=_blank href='?section=logtime&&member_id=$id[$i]' title='View Personal Record'><img src='../images/icon/report.png' border=0  style='width:12.5%; margin-right:15px; margin-left:15px;'></a>
                    </td>
                </tr>";
        }
        echo "</form>
        </table>
        <table align=center width=100% cellpadding=5 cellspacing=0 border=0 >
            <form method=post action='?section=$_GET[section]&&page=$page'>	
                <tr valign=top>
                    <td width=7% align=left>
                        <font size=2 face=tahoma color=red><b>Page :</b></font>
                    </td>
                    <td width=100% align=left>";

        for ($p = 1; $p <= $all_page; $p++) {
            if ($p >= 1 && $p < 10) {
                $page_num = "[000$p]";
            }
            elseif ($p > 9 && $p < 100) {
                $page_num = "[00$p]";
            }
            elseif ($p > 100 && $p < 1000) {
                $page_num = "[0$p]";
            }
            else {
                $page_num = "[$p]";
            }
            if ($_GET["page"] == $p) {
                $p_color = "#DF013A";
            }
            else {
                $p_color = "black";
            }
            if ((!$_GET["page"] || $_GET["page"] - $_GET["page"] != 0 || $_GET["page"] <= 0) && $p == 1) {
                $p_color = "red";
            }
            echo "&nbsp;<a href='?section=$_GET[section]&&page=$p'><font size=2 face=tahoma color='$p_color'>$page_num</font></a>";
            if ($p % 20 == 0) {
                echo "<br>";
            }
        }
        echo "      </td>
                </tr>
            </form>
        </table><br>";
    }

}

function delete_user()
{
    include('../config/connection.php');
    if ($_SESSION["x_member_1year"] == 4 && $_GET['member_id']) {
        $id = trim($_GET['member_id']);
        $SQL = "DELETE FROM tbl_x_member_1year WHERE id = ?";
        $query = $conn->prepare($SQL);
        $query->bind_param("s", $id);
        $query->execute();
        $query->close();
        header("Location:?section=$_GET[section]&page=1");
    }
}

?>