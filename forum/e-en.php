<?php
include('../inc/header.php');
include('../inc/footer.php');
include('../inc/info_user.php');
include('../config/format_time.php');
include('./config/connection.php');
include('../config/connection.php');
include('paging.inc.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <style>
    .thumbnail_icon {
        display: inline-block;
        border: 0px solid orange;
        width: 110px;
        text-align: center;
        font-family: Kanit;
        height: 135px;
    }

    .modified_text {
        min-width: 100px;
        display: inline-block;
    }

    .icon_circle {
        border-radius: 50%;
        width: 64px;
        height: 64px;
        background: #565656;
    }

    .icon_circle.active {
        background: #f7941d;
    }

    .icon_circle:hover {
        transform: translateY(-2px);
        box-shadow: 3px 10px 20px rgba(0, 0, 0, .3);
    }

    .title_english_room {
        font-size: 13px;
        padding-top: 10px;
        color: black !important;
    }

    .title_english_room.active {
        color: #f7941d !important;
    }

    .title_english_room:hover {
        color: #f7941d !important;
    }

    .img_hover:hover {
        transform: translateY(-10px);
        box-shadow: 3px 10px 20px rgba(0, 0, 0, .3);
    }

    .img_hover {
        border-radius: 230px;
    }

    .over_a.alink:hover {
        color: black;
        font-weight: bold;
        font-size: 16px;
    }

    .over_b:hover {
        color: black;
    }

    .headline:hover {
        color: black;
        font-weight: bold;
        font-size: 15px;
    }
    </style>
</head>

<body>
    <div class="container shadow_side" style="width:1150px !important;background:#ffffff;margin-top:45px;">
        <?= callheader(); ?>

        <?php

$_conf["list"]["thumbnail"] = array(
    "0" => array(
        "name" => "One day One sentence",
        "icon" => "fa-calendar-check-o",
        "url" => "../forum/e-en.php?type_id=03-01",
        "type_id" => "03-01",
    ),
    "1" => array(
        "name" => "English for News",
        "icon" => "fa-newspaper-o",
        "url" => "../forum/e-en.php?type_id=03-12",
        "type_id" => "03-12",
    ),
    "2" => array(
        "name" => "Easy English",
        "icon" => "fa-child",
        "url" => "../forum/e-en.php?type_id=03-10",
        "type_id" => "03-10",
    ),
    "3" => array(
        "name" => "Comprehensive Listening",
        "icon" => "fa-heart",
        "url" => "../forum/e-en.php?type_id=03-11",
        "type_id" => "03-11",
    ),
    "4" => array(
        // "name" => "Proverbs / Slang / Idioms",
        "name" => "Communicative English",
        "icon" => "fa-text-width",
        "url" => "../forum/e-en.php?type_id=03-03",
        "type_id" => "03-03",
    ),
    "5" => array(
        // "name" => "Everyday English",
        "name" => "Grammar & Writing",
        "icon" => "fa-leanpub",
        "url" => "../forum/e-en.php?type_id=03-15",
        "type_id" => "03-15",
    ),
    "6" => array(
        // "name" => "Impressive Quote",
        "name" => "Pronunciation & Phonetic",
        "icon" => "fa-briefcase",
        "url" => "../forum/e-en.php?type_id=03-08",
        "type_id" => "03-08",
    ),
    "7" => array(
        "name" => "Song of Souls",
        "icon" => "fa-music",
        "url" => "../forum/e-en.php?type_id=03-07",
        "type_id" => "03-07",
    ),
    "8" => array(
        // "name" => "Trendy Movie",
        "name" => "Movie World",
        "icon" => "fa-film",
        "url" => "../forum/e-en.php?type_id=03-05",
        "type_id" => "03-05",
    ),
);

?>

        <div class="row kanit">
            <div class="col-xs-12" style="padding:0px 0px;">
                <div id="apDiv68" style="border-top:1px solid #d27f19;border-bottom:4px solid #f7941d">
                    <center>
                        <div id="apdiv3menubar" style="background:#f3f3f3;">
                            <div class="row kanit">
                                <div class="col-xs-12">
                                    <?php
for ($i = 0; $i < count($_conf["list"]["thumbnail"]); $i++) {
    $menu_list = $_conf['list']['thumbnail'][$i];

?>
                                    <div class="thumbnail_icon <?=($_GET['type_id'] == $menu_list['type_id']) ? 'active' : ""; ?>"
                                        style="vertical-align: top;">
                                        <a href="<?= $menu_list['url']; ?>" class="over_a">
                                            <div style="width:100%;border:0px solid blue;margin-top:15px;">
                                                <center>
                                                    <div
                                                        class="icon_circle <?=($_GET['type_id'] == $menu_list['type_id']) ? 'active' : ""; ?>">
                                                        <i class="fa <?= $menu_list['icon']; ?>"
                                                            style="font-size:30px;padding:15px 0px;color:#ffffff;"></i>
                                                    </div>
                                                    <div
                                                        class="title_english_room <?=($_GET['type_id'] == $menu_list['type_id']) ? 'active' : ""; ?>">
                                                        <?= $menu_list["name"]; ?>
                                                    </div>
                                                </center>
                                            </div>
                                        </a>
                                    </div>
                                    <?php
}?>
                                </div>
                            </div>
                        </div>
                    </center>
                </div>
            </div>

        </div>

        <div id="apDiv69">
            <?php
include('./config/connection.php');
include('../config/connection.php');
$type = '03-01';
$typeid = '03-01';
$name_type = 'One day One sentence';
$current_page = "1";
if (isset($_GET['type_id'])) {

    if (trim($_GET['type_id'])) {
        $type = $conn->real_escape_string($_GET['type_id']);
    }
    if ($type == '02-01' || $type == '02-02' || $type == '03-01' || $type == '03-12' || $type == '03-10' || $type == '03-03' || $type == '03-11' || $type == '03-15' || $type == '03-08' || $type == '03-07' || $type == '03-05') {
        $type_id = $type;
    }
    else {
        exit();
    }

    // check type forum 
    $type_namesql = "SELECT type_name FROM  tbl_web_type WHERE type_id=?";
    $stmt = $conn->prepare($type_namesql);
    $stmt->bind_param("s", $type_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $name = $result->fetch_assoc();
    //has type forum
    if ($name['type_name'] != '') {
        $arrayname = array('One day One sentence' => '03-01', 'English From News' => '03-12', 'Gripping Variety' => '03-09', 'Communicative English' => '03-03', ' Comprehensive Listening' => '03-11',
            'Song of Souls' => '03-07', 'Movie World' => '03-05', 'Grammar & Writing' => '03-15', 'Thais English' => '03-02', 'Easy English' => '03-10', 'Pronunciation & Phonetic' => '03-08',
            'Event Gallery' => '02-01', 'Trendy Movie' => '05-04', 'Admission' => '07-02', 'CU-TEP' => '07-03', 'TU-GET' => '07-04', 'TOEFL' => '07-05', 'TOEIC' => '07-06', 'IELTS' => '07-07', 'ข่าวประชาสัมพันธ์' => '02-02');
        $keyvalue = array_search($type, $arrayname);
        $name_type = $keyvalue;
        $typeid = trim($_GET['type_id']);
        // รวม proverb/ Slang/Idioms
        if ($type == '03-03') {
            $type = " (tbl_web_type.type_id='03-03' || tbl_web_type.type_id='03-13' || tbl_web_type.type_id='03-16') ";
        }
        else {
            $type = "tbl_web_type.type_id='$typeid'";
        }
    }
    else { // no type forum  set defualt forum= 03-01
        $type = "tbl_web_type.type_id='03-01'";
        $name_type = 'One day One sentence';
    }
    $stmt->close();
}
if (isset($_GET['page'])) {
    $current_page = $_GET['page'];
}
?>
            <br>
            <center>
                <h3>
                    <font color="orange">
                        <?php echo $name_type; ?>
                    </font>
                </h3>
            </center>
            <br>

            <?php

$rows_per_page = "7";
//count row of topic
$sql_count = "SELECT  COUNT(*)
                                FROM tbl_web_type,tbl_web_topic,tbl_web_admin 
                                WHERE tbl_web_type.type_id=tbl_web_topic.type_id AND tbl_web_admin.admin_id=tbl_web_topic.admin_id 
                                AND " . $type . " AND tbl_web_topic.topic_active='1'";

$query = $conn->prepare($sql_count);
$query->execute();
$result = $query->get_result();
$count_row = $result->fetch_array();

$total_pages = paging_total_pages($count_row['0'], $rows_per_page);
$query->close();
// check page not more total_page
if ($current_page > $total_pages) {
    $current_page = $total_pages;
}
if ($_GET['page'] == '') {
    $start_row = "0";
}
else {
    $start_row = paging_start_row($current_page, $rows_per_page);
}
$sql_q = "SELECT  topic_id,topic_name,topic_headline,topic_image,topic_view,nickname,tbl_web_type.type_id,tbl_web_topic.topic_create 
                                FROM tbl_web_type,tbl_web_topic,tbl_web_admin 
                                WHERE tbl_web_type.type_id=tbl_web_topic.type_id AND tbl_web_admin.admin_id=tbl_web_topic.admin_id 
                                AND " . $type . " AND tbl_web_topic.topic_active='1' ORDER BY tbl_web_topic.topic_id 
                                DESC LIMIT " . $start_row . "," . $rows_per_page . " ";

$stmt = $conn->prepare($sql_q);
$stmt->execute();
$result = $stmt->get_result();

?>


            <table width=98% height=80 border=0 align=center cellpadding=0 cellspacing=0>
                <tr height=5>
                    <td width=15% align=center></td>
                </tr>
                <?php

while ($row = $result->fetch_array()) {

    $date_now = date("Y-m-d");
    $date_create = $row['topic_create'];
    $dif = date_dif($date_create, $date_now);
    $arr_date = explode("-", $date_create);
    $msg_date = $arr_date[2] . "-" . $arr_date[1] . "-" . $arr_date[0];
    if ($dif <= "14") {
        $new = "&nbsp;<img src=../2010/temp_images/icon_new.gif border=0 style='border-radius:5px;'>";
    }
    else {
        $new = "";
    }
?>
                <tr valign=top>
                    <td width=15% rowspan=3 align=center>
                        <div class='imgborder'><a href='detail.php?type_id=<?= $row[' type_id']; ?>&&topic_id=
                                <?= $row['topic_id']; ?>' target=_blank>
                                <img class="img_hover" src=../2010/user_images/<?= $row['topic_image']?> width=84
                                    height=84 />
                            </a></div>
                    </td>
                    <td width=85% align=center>
                        <div align=left class="alink1">
                            <font size=2 face=tahoma><b><a class='over_a alink'
                                        href=detail.php?type_id=<?= $row['type_id']; ?>&&topic_id=<?= $row['topic_id']; ?>
                                        target=_blank>
                                        <?= $row['topic_name']?>
                                    </a>
                                    <?php echo "&nbsp;&nbsp;$new"; ?>
                                </b></font>
                        </div>
                    </td>
                </tr>
                <tr valign=top>
                    <td align=center style="padding-right:5px;">
                        <div align=left class='alink '>
                            <font size=2 color=#3333 face=tahoma><b> <a class='over_b headline'
                                        href=detail.php?type_id=<?= $row['type_id']; ?>&&topic_id=<?= $row['topic_id']; ?>
                                        target=_blank>
                                        <?= $row['topic_headline']; ?>
                                    </a></b></font>
                        </div>
                    </td>
                </tr>

                <tr valign=top>
                    <td align=center>
                        <div align=left>
                            <font size=2 color=#0000 face=tahoma> <b>
                                    <div class="text-grey"
                                        style="font-size:14x !important;border:0px solid blue;margin:0px;">
                                        <div class="modified_text" style="font-size:12px !important;margin:0px;"><i
                                                class="fa fa-calendar-check-o"></i>&nbsp;
                                            <?= date("d M Y", strtotime($msg_date)); ?>
                                        </div>
                                        <div class="modified_text" style="font-size:12px !important;margin:0px;"><i
                                                class="fa fa-user-circle-o"></i>&nbsp;
                                            <?= $row['nickname']; ?>
                                        </div>
                                        <div class="modified_text" style="font-size:12px !important;margin:0px;"><i
                                                class="fa fa-eye"></i>&nbsp;View&nbsp;
                                            <?= number_format($row['topic_view'], 0); ?>
                                        </div>
                                    </div>
                                </b></font>
                        </div>
                    </td>
                </tr>

                <tr valign=top>
                    <td height=1 colspan=2 align=center>
                        <hr width=1000 align=right style="margin-right:20px;color:black" />
                    </td>

                    <?php
}
$stmt->close();
?>
                </tr>

            </table>

            <?php
$page_range = 8;
$qry_string = ""; //no query string
//link number of page
$page_str = paging_pagenum($current_page, $total_pages, $page_range, $qry_string, $typeid);
//print number of page
mysqli_close($conn);
echo "<p align='center'>$page_str</p>";
?>
        </div>

    </div>

    <?php footer(); ?>
</body>

</html>