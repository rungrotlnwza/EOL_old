<?php
ob_start();
include('../inc/header.php');
include('../inc/footer.php');
include('../inc/info_user.php');
include('../config/format_time.php');
include('../config/connection.php');
include('paging.inc.php');


$type = $conn->real_escape_string(trim($_GET['type_id']));
$topic_id = $conn->real_escape_string(trim($_GET['topic_id']));
if (!$type == '03-01' || !$type == '03-09' || !$type == '03-03' || !$type == '03-11' || !$type == '03-07' || !$type == '03-05' || !$type == '03-15' || !$type == '03-12' || !$type == '03-10' || !$type == '03-08' || !$type == '02-01' || !$type == '07-02' || !$type == '07-03' || !$type == '07-04' || !$type == '07-05' || !$type == '07-06' || !$type == '07-07' || !$type == '02-06' || $type == '') {
    exit();
}
if (!preg_match("/^[0-9 \-]+$/", $type)) {
    exit();
}
if (!preg_match("/^[0-9]+$/", $topic_id)) {
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

</head>


<body>
    <div class="container shadow_side" style="width:1150px !important;background:#ffffff;margin-top:45px;">

        <?= callheader(); ?>

        <?php
        @include("cache-kit.php");
        $cache_active = true;
        $cache_folder = "cache/$type/";

        function callback($buffer)
        {
            return $buffer;
        }
        $page_cache = acmeCache::fetch($topic_id, 28800);

        if (!$page_cache) {
            ob_start("callback");
?>

        <div class="row kanit">
            <div class="col-xs-12" style="padding:10px 50px;">
                <center>
                    <?php

    include('./config/connection.php');
    include('../config/connection.php');

    $active = '1';
    $sql = "SELECT * FROM tbl_web_topic WHERE type_id=? AND topic_id=? AND topic_active=? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $type, $topic_id, $active);
    $stmt->execute();
    $rows = $stmt->get_result();
    $result = $rows->fetch_assoc();

                    ?>
                    <div>
                        <?php
    // check if not null data
    if ($result) {
        $arrayname = array(
            'One day One sentence' => '03-01',
            'Sporty Sport' => '03-09',
            'Grammar & Writing' => '03-15',
            'Effective Writing' => '03-11',
            'Songs of Souls' => '03-07',
            'Movie World' => '03-05',
            'Communicative English' => '03-03',
            'English from news' => '03-12',
            'Easy English' => '03-10',
            'Pronunciation & Phonetic' => '03-08',
            'Event Gallery' => '02-01',
            'Admission' => '07-02',
            'CU-TEP' => '07-03',
            'TU-GET' => '07-04',
            'TOEFL' => '07-05',
            'TOEIC' => '07-06',
            'IELTS' => '07-07',
            'ข่าวประชาสัมพันธ์' => '02-06'
        );
        $keyvalue = array_search($type, $arrayname);

        // update view topic
        $strSQL = "UPDATE tbl_web_topic SET topic_view=topic_view+1 WHERE topic_id=?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $topic_id);
        $stmt->execute();
        $stmt->close();

        $admin_id = trim($result['admin_id']);
        $msgSQL = "SELECT * FROM tbl_web_admin WHERE admin_id=?";
        $stmt = $conn->prepare($msgSQL);
        $stmt->bind_param("s", $admin_id);
        $stmt->execute();
        $query = $stmt->get_result();
        $admin = $query->fetch_assoc();

        if ($query->num_rows > 0) {
            $admin_name = $admin['nickname'];
        }

        echo "<script type=\"text/javascript\" src=\"https://w.sharethis.com/button/buttons.js\"></script>
						  <script type=\"text/javascript\">stLight.options({publisher:'3f499af7-b2f4-4e23-9e23-abc05608eaa6'});</script>
                            <table align=center width=95% cellpadding=0 cellspacing=0 border=0 >
                                <tr height=10><td colspan=3></td></tr>
                                <tr >
                                    <td width=10% align=center >
                                        <img src='../2010/user_images/$_GET[topic_id].jpg?v=1' width=100 style='border-radius: 10%;'> 
                                    </td>
                                    <td align=center>&nbsp;&nbsp;&nbsp;</td>
                                    <td width=90% align=left>
                                            <font size=2 face=tahoma color=black><b>$result[topic_name]</b></font>
                                            <br>
                                            <a href=../index.php><font color='#f98d2b' face=tahoma size=2 ><b>Home</b></font></a>
                                            <a href=e-en.php?type_id=$_GET[type_id]> <font color=black face=tahoma size=2 ><b>&nbsp;&raquo;&nbsp;$keyvalue </b></font></a>
                                            <font color=black face=tahoma size=2 ><b>&nbsp;&raquo;&nbsp;</b></font>
                                            <a href=?&&type_id=$_GET[type_id]&&topic_id=$_GET[topic_id]><font color='#1ea9c3' face=tahoma size=2 ><b>$result[topic_name]</b></a>
                                            <br>
                                            <font size=2 face=tahoma color=black><b>Headline : </b>$result[topic_headline]</font>
                                            <br>
                                            <font size=2 face=tahoma color=black><b>Date : </b> 
                                                " . get_thai_day($result['topic_create']) . " &nbsp; " . get_thai_month($result['topic_create']) . " &nbsp; " . get_thai_year($result['topic_create']) . "
                                            </font>
                                            <br>
                                            <font size=2 face=tahoma color=black><b>View :</b> $result[topic_view]</font>
                                            <br>
                                            <font size=2 face=tahoma color=black><b>By $admin_name </b></font>
                                    </td>
                                </tr>
                                <tr height=10><td colspan=3></td></tr>
                                <tr height=2 bgcolor=gray><td colspan=3></td></tr>
                                <tr height=10><td colspan=3></td></tr>
                                <tr height=50>
                                    <td align=right colspan=3>
                                        <img src=\"../images/index/EOL19Year.png\" width=\"220\" height=\"195\"/>
                                        <span class=\"st_facebook_button\" displayText=\"Facebook\"></span>
                                        <span class=\"st_twitter_button\" displayText=\"Tweet\"></span>
                                        <span class=\"st_email_button\" displayText=\"Email\"></span>

                                    </td>
                                </tr>
                            </table>";
        echo "
                            <table align=center width=95% cellpadding=0 cellspacing=0 border=0>
                                <tr height=30>
                                    <td>&nbsp;&nbsp;</td>
                                    <td width=100% align=left>
                                        " . $result['topic_detail'] . "
                                    </td>
                                    <td>&nbsp;&nbsp;</td>
                                </tr>
                                <tr height=30>
                                    <td colspan=2></td>
                                </tr>
                            </table>";

    } else {
        echo ' <div style="margin:100px 0px 0px 0px;font-size:14px;">ไ่ม่มีข้อมูล</div>';
    }
    $stmt->close();
                        ?>
                </center>
            </div>
        </div>
        <?php
    $page_cache = ob_get_contents();
    ob_end_flush();
    acmeCache::save($topic_id, $page_cache);
} else {
    // update view topic
    $strSQL = "UPDATE tbl_web_topic SET topic_view=topic_view+1 WHERE topic_id=?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $topic_id);
    $stmt->execute();
    $stmt->close();
    echo $page_cache;
    // echo "Cache Data";
}
?>
    </div>
    <?php footer(); ?>

</body>

</html>