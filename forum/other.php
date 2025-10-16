<?php
include('../inc/header.php');
include('../inc/footer.php');
include('../inc/info_user.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
    .tb-school {
        background-color: #ccc !important;
        border-radius: 10px;
        padding-top: 5px;
    }

    .main {
        background-color: #ffc112 !important;
        border-radius: 10px;
        padding: 40px 0 40px 0;
    }

    .even {
        background-color: #ffa502d6 !important;
        border-radius: 10px;
        padding: 15px 5px 15px 22px;
    }

    .odd {
        background-color: #ffe5b5 !important;
        border-radius: 10px;
        padding: 15px 5px 15px 22px;
    }
    </style>
</head>

<body>
    <div class="container shadow_side" style="width:1150px !important;background:#ffffff;margin-top:45px;">

        <?= callheader(); ?>

        <div class="row kanit">
            <div class="col-xs-12" style="padding:10px 50px;">
                <div style="height:auto;font-size:13px;">
                    <?php
                    if ($_GET['type'] === "school") {

                        school_rollup();

                    } else if ($_GET['type'] === "feedback") {
                        feedback_rollup();
                    } else if ($_GET['type'] === "advertise") {
                        advertise();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php footer(); ?>

</body>

</html>

<?php
function school_rollup()
{
    include('../config/connection.php');
    $topic[0] = "โรงเรียน";
    $topic[1] = "อุดมศึกษา";
    $topic[2] = "การศึกษานอกระบบ";
    $topic[3] = "องค์กร";
    $school = "โรงเรียน";
    $nf_education_center = "ศูนย์การศึกษานอกระบบ";
    $nf_education = "กศน_";
    $university = "มหาวิทยาลัย";
    $college = "วิทยาลัย";
    $organize = "องค์กร";
    $office = "สำนักงาน";
    $company = "บริษัท";

    echo "<hr><h2><center>รายชื่อลูกค้าที่ใช้บริการ EOL System</center></h2><hr>";
    echo "<div class='main'>";
    // --------------- โรงเรียน --------------- //
    $num = 0;
    $amount = 0;
    $SQL = "SELECT * FROM tbl_web_school WHERE is_active=1 and school_name LIKE '$school%' && school_name NOT LIKE '%$nf_education_center%' ";
    $query = $conn->prepare($SQL);
    $query->execute();
    $result = $query->get_result();
    $num = $result->num_rows;

    echo "<table align='center' class='tb-school' width=90% cellpadding=0 cellspacing=0 border=0>
            <tr height=55>
                <td width='5%'></td><td colspan=4><font size=5 face=tahoma color=black><b>&nbsp; $topic[0]<b>
                </td>
            </tr>
            <tr height=35 align='middle'>";

    for ($i = 0; $i <= $num; $i++) {
        $data = $result->fetch_array();
        $amount++;
        echo "  <td width='5%'></td>
                <td width='35%' align='left'>
                    $data[school_name]
                </td>";

        if ($amount % 2 == 0) {
            echo "</tr><tr valign=middle height=10><td></td></tr><tr>";
        }
    }
    echo "</tr>";
    echo "</tr><tr><td colspan=4>&nbsp;</td></tr>";
    echo "</table><br>";
    $query->close();

    // -------------- อุดมศึกษา ---------------- //
    $num = 0;
    $amount = 0;
    $SQL = "SELECT * FROM tbl_web_school WHERE is_active=1 and school_name LIKE '$university%' or school_name LIKE '$college%' ";
    $query = $conn->prepare($SQL);
    $query->execute();
    $result = $query->get_result();
    $num = $result->num_rows;

    echo "<table align='center' class='tb-school' width=90% cellpadding=0 cellspacing=0 border=0>
            <tr height=55>
                <td width='5%'></td><td colspan=4><font size=5 face=tahoma color=black><b>&nbsp; $topic[1]<b>
                </td>
            </tr>
            <tr height=35 align='middle'>";

    for ($i = 0; $i <= $num; $i++) {
        $data = $result->fetch_array();
        $amount++;
        echo "  <td width='5%'></td>
                <td width='35%' align='left'>
                    $data[school_name]
                </td>";

        if ($amount % 2 == 0) {
            echo "</tr><tr valign=middle height=10><td></td></tr><tr>";
        }
    }
    echo "</tr>";
    echo "</tr><tr><td colspan=4>&nbsp;</td></tr>";
    echo "</table><br>";
    $query->close();

    // --------------- กศน --------------- //
    $num = 0;
    $amount = 0;
    $SQL = "SELECT * FROM tbl_web_school WHERE is_active=1 and school_name LIKE '$nf_education_center%' or school_name LIKE '$nf_education%'";
    $query = $conn->prepare($SQL);
    $query->execute();
    $result = $query->get_result();
    $num = $result->num_rows;

    echo "<table align='center' class='tb-school' width=90% cellpadding=0 cellspacing=0 border=0>
            <tr height=55>
                <td width='5%'></td><td colspan=4><font size=5 face=tahoma color=black><b>&nbsp; $topic[2]<b>
                </td>
            </tr>
            <tr height=35 align='middle'>";

    for ($i = 0; $i < $num; $i++) {
        $data = $result->fetch_array();
        $amount++;
        echo "  <td width='5%'></td>
                <td width='35%' align='left'>
                    $data[school_name]
                </td>";

        if ($amount % 2 == 0) {
            echo "</tr><tr valign=middle height=10><td></td></tr><tr>";
        }
    }
    echo "</tr>";
    echo "</tr><tr><td colspan=4>&nbsp;</td></tr>";
    echo "</table><br>";
    $query->close();

    // -------------- องค์กร ---------------- //
    $num = 0;
    $amount = 0;
    $SQL = "SELECT * FROM tbl_web_school WHERE is_active=1 and school_name LIKE '$organize%' or school_name LIKE '$company%' or school_name LIKE '$office%' ";
    $query = $conn->prepare($SQL);
    $query->execute();
    $result = $query->get_result();
    $num = $result->num_rows;

    echo "<table align='center' class='tb-school' width=90% cellpadding=0 cellspacing=0 border=0>
            <tr height=55>
                <td width='5%'></td><td colspan=4><font size=5 face=tahoma color=black><b>&nbsp; $topic[3]<b>
                </td>
            </tr>
            <tr height=35 align='middle'>";

    for ($i = 0; $i < $num; $i++) {
        $data = $result->fetch_array();
        $amount++;
        echo "  <td width='5%'></td>
                <td width='35%' align='left'>
                    $data[school_name]
                </td>";

        if ($amount % 2 == 0) {
            echo "</tr><tr valign=middle height=10><td></td></tr><tr>";
        }
    }
    echo "</tr>";
    echo "</tr><tr><td colspan=4>&nbsp;</td></tr>";
    echo "</table>";
    echo "</div>";
    echo "<hr>";
    $query->close();

}

function feedback_rollup()
{
    include('../config/connection.php');
    $SQL = "SELECT * FROM tbl_web_feedback WHERE is_active=1 ORDER BY feedback_id ASC";
    $query = $conn->prepare($SQL);
    $query->execute();
    $result = $query->get_result();
    $num = $result->num_rows;
    $amount = 0;
    echo "<hr><h2><center>ความคิดเห็นของผู้ใช้บริการ EOL System</center></h2><hr>";
    echo "  <div class='main'>
                <table align='center' class='tb-feedback' width=90% cellpadding=0 cellspacing=0 border=0>";

    for ($i = 0; $i < $num; $i++) {
        $data = $result->fetch_array();
        $amount++;
        if ($i % 2 == 0) {
            $class = 'class=even';
        } else {
            $class = 'class=odd';
        }
        echo "  <tr height=50 align='left' class=sub-tb-feedback>  
                   
                    <td width='82%' $class>
                        $data[feedback_detail]
                    </td>
                    
                </tr>";

    }

    echo "  </table>
        </div>";
    echo "<hr>";
    $query->close();
}

function advertise()
{
   ?>
<style>
.center {
    text-align: center;
}

.bold-text {
    font-weight: bold;
}

.discount_tag {
    position: absolute;
    top: 15px;
    left: 80px;
    border: 0px solid blue;
    font-size: 22px;
    font-weight: bolder;
    color: red;
}
</style>
<div style="font-size:36px;width:100%;">
    <center><b>ตำแหน่งในการลงโฆษณา</b></center>
    <center><b style="color:#ed1b25;">ADS ZONE</b></center>
    <hr style="width:10%;border:2px solid #f78c22;">
    <a href="../images/image/sponser/ads_zone.jpg" target="_blank"><img
            src="../images/image/sponser/ads_zone_thumbnail.jpg" style="width:100%;padding-top:10px;" /></a>
    <BR>
    <BR>
</div>
<div style="font-size:24px;width:100%;">
    <center><b>อัตราค่าโฆษณา (หน้าแรกของเว็บไซต์)</b></center><BR>
    <table style="font-size:18px;width:95%;" border="1" bordercolor="grey">
        <tr style="background:#f3f3f3;">
            <td class="center bold-text" rowspan="2">Banner</td>
            <td class="center bold-text" rowspan="2">1 เดือน</td>
            <td class="center bold-text" colspan="3">Promotion ลงระยะยาว</td>
            <td class="center bold-text" rowspan="2">ประเภท</td>
        </tr>
        <tr style="background:#f3f3f3;">
            <td class="center bold-text">3 เดือน</td>
            <td class="center bold-text">6 เดือน</td>
            <td class="center bold-text">12 เดือน</td>
        </tr>
        <tr style="height:75px;line-height: 20px;">
            <td class="center bold" rowspan="2" style="background:#ed1b25;color:#FFF;"><span
                    style="font-size:24px;">150x150</span><br>pixel</td>
            <td class="center bold-text" rowspan="2">20,000.-</td>
            <td class="center">
                <div style="width:100%;border:0px solid blue;position:relative;">
                    <img src="https://www.clker.com/cliparts/R/Z/t/o/x/W/starburst-no-drop-shadow-md.png"
                        style="width:100px;">
                    <div class="discount_tag">ลด<BR>10%</div>
                </div>
            </td>
            <td class="center">
                <div style="width:100%;border:0px solid blue;position:relative;">
                    <img src="https://www.clker.com/cliparts/R/Z/t/o/x/W/starburst-no-drop-shadow-md.png"
                        style="width:100px;">
                    <div class="discount_tag">ลด<BR>15%</div>
                </div>
            </td>
            <td class="center">
                <div style="width:100%;border:0px solid blue;position:relative;">
                    <img src="https://www.clker.com/cliparts/R/Z/t/o/x/W/starburst-no-drop-shadow-md.png"
                        style="width:100px;">
                    <div class="discount_tag">ลด<BR>20%</div>
                </div>
            </td>
            <td class="center" rowspan="2">Fixed banner</td>
        </tr>
        <tr>
            <td class="center" style="background:#ed1b25;color:#FFF;">เดือนละ 18,000.-</td>
            <td class="center" style="background:#ed1b25;color:#FFF;">เดือนละ 17,000.-</td>
            <td class="center" style="background:#ed1b25;color:#FFF;">เดือนละ 16,000.-</td>
        </tr>
        <tr style="height:75px;line-height: 20px;">
            <td class="center bold-text" rowspan="2" style="background:#f78c22;color:#fff;"><span
                    style="font-size:24px;">150x100</span><br>pixel</td>
            <td class="center bold-text" rowspan="2">15,000.-</td>
            <td class="center">
                <div style="width:100%;border:0px solid blue;position:relative;">
                    <img src="https://www.clker.com/cliparts/R/Z/t/o/x/W/starburst-no-drop-shadow-md.png"
                        style="width:100px;">
                    <div class="discount_tag">ลด<BR>10%</div>
                </div>
            </td>
            <td class="center">
                <div style="width:100%;border:0px solid blue;position:relative;">
                    <img src="https://www.clker.com/cliparts/R/Z/t/o/x/W/starburst-no-drop-shadow-md.png"
                        style="width:100px;">
                    <div class="discount_tag">ลด<BR>15%</div>
                </div>
            </td>
            <td class="center">
                <div style="width:100%;border:0px solid blue;position:relative;">
                    <img src="https://www.clker.com/cliparts/R/Z/t/o/x/W/starburst-no-drop-shadow-md.png"
                        style="width:100px;">
                    <div class="discount_tag">ลด<BR>20%</div>
                </div>
            </td>
            <td class="center" rowspan="2">Fixed banner</td>
        </tr>
        <tr>
            <td class="center" style="background:#f78c22;color:#fff;">เดือนละ 13,500.-</td>
            <td class="center" style="background:#f78c22;color:#fff;">เดือนละ 12,750.-</td>
            <td class="center" style="background:#f78c22;color:#fff;">เดือนละ 12,000.-</td>
        </tr>
    </table>
    <BR>
    <div style="font-size:16px;">
        *เงื่อนไขในการลงโฆษณา<BR>
        - ไม่รับลงโฆษณาทุกประเภทที่ไม่เหมาะสำหรับเยาวชน<BR>
        - ไม่รับลงโฆษณาประเภทผิดกฎหมายแพ่ง อาญา กฎหมายลิขสิทธิ์ ศีลธรรม ของไทย<BR>
    </div>
</div>
<BR><BR>
<div style="width:100%;background:red;color:#fff;font-size:24px;text-align:center;padding:10px;border-radius:8px">
    สนใจติดต่อสอบถาม 02 170 8725, 066 115 2916, 066 115 2454, 066 115 2545
</div>
<BR>
<?php
}
?>