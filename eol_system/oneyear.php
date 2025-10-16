<?php
include('../inc/header.php');
include('../inc/footer.php');
include('../inc/info_user.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <style>
    .text_paragraph {
        font-size: 16px;
    }

    .title_font_menu {
        font-family: kanit;
        font-weight: bold;
        color: #fb921d;
        font-size: 24px;
        padding-bottom: 10px;
    }

    .btn_shortcut {
        padding: 15px;
        width: 300px;
    }

    .btn_shortcut:hover {
        background: #fb921d;
        color: black;
    }
    </style>
</head>

<body>
    <div class="container shadow_side" style="width:1150px !important;background:#ffffff;margin-top:45px;">

        <?= callheader(); ?>

        <div class="row kanit">
            <div class="col-xs-12" style="padding:0px;margin:0px;">
                <div id="apDiv68" style="border-top:1px solid #d27f19;border-bottom:4px solid #f7941d">
                    <center>
                        <div id="apdiv3menubar" style="background:#f3f3f3;">
                            <a href="../eol_system/eol_member_club.php">
                                <img src="../images/image2/about web/menu_icon/EOL-System-Club.jpg"
                                    style="width:180px;height:130px;"></a>
                            <a href="../eol_system/personal.php">
                                <img src="../images/image2/about web/menu_icon/personal-new.jpg"
                                    style="width:180px;height:130px;"></a>
                            <a href="../eol_system/oneyear.php">
                                <img src="../images/image2/about web/menu_icon/over-1year-course.jpg"
                                    style="width:180px;height:130px;"></a>
                            <a href="../eol_system/Intelligence.php">
                                <img src="../images/image2/about web/menu_icon/Intelligence-package-new.jpg"
                                    style="width:180px;height:130px;"></a>
                            <a href="../eol_system/corporate.php">
                                <img src="../images/image2/about web/menu_icon/coporate-new.jpg"
                                    style="width:180px;height:130px;"></a>
                            <a href="../eol_system/eol_platform.php">
                                <img src="../images/image2/about web/menu_icon/eol-platform.jpg"
                                    style="width:180px;height:130px;"></a>

                            <!-- <a href="https://www.engtest.net/eol_system/gepot.php">
                                <img src="https://www.engtest.net/image2/eol system/gepot-new.jpg"
                                    style="width:180px;height:130px;"></a> -->
                        </div>
                    </center>
                </div>

                <div style="padding:0px 150px;border:0px solid blue;" class="taviraj">
                    <div id="apDiv69" class="kanit" style="padding-top:20px;">
                        <center>
                            <h2><strong>1 YEAR COURSE</strong><br>
                                <span style="font-size:24px;color:#707070;">เรียนตามหลักสูตรต่อเนื่อง 52 สัปดาห์</span>
                            </h2>
                        </center>
                        <BR><BR>
                        <div class="text_paragraph">
                            <div class="title_font_menu">1 YEAR COURSE</div><br>
                            &emsp;&emsp;52 สัปดาห์ กับการเรียนรู้ภาษาอังกฤษ ไปทีละสัปดาห์
                            โดยบทเรียนจะเป็นไปตามแผนการเรียนที่นักวิชาการกำหนด (ซึ่งผู้เรียน สามารถเรียนย้อนหลังได้)
                            คุณจะพบทั้งการเรียนจากบทเรียน รวบรวมเนื้อหาพร้อมประโยค และแบบฝึกหัด ครอบคลุมทั้ง 6 ทักษะ
                            การเรียนจาก VDO สถานการณ์ต่างๆ ในหัวข้อนั้นๆ
                            มีการทบทวนบทเรียนโดยผ่านการเรียนปนเล่นกับแบบฝึกหัดที่เป็นเกมส์ และมี ระบบประเมินผลทุก 3
                            เดือน
                            เพื่อดูพัฒนาการของตัวเอง<br><br>

                            <!-- <img src="https://www.engtest.net/event/1yearscourse/New_Banner Oneyears.png" width="100%"> -->
                        </div>
                        <center>

                            <img src="https://www.engtest.net/event/1yearscourse/92691184.png" width="100%">
                            <script type="text/javascript">
                            function blink() {
                                var blinks = document.getElementsByTagName('blink');
                                for (var i = blinks.length - 1; i >= 0; i--) {
                                    var s = blinks[i];
                                    s.style.visibility = (s.style.visibility === 'visible') ? 'hidden' : 'visible';
                                }
                                window.setTimeout(blink, 1000);
                            }
                            if (document.addEventListener) document.addEventListener("DOMContentLoaded", blink,
                                false);
                            else if (window.addEventListener) window.addEventListener("load", blink, false);
                            else if (window.attachEvent) window.attachEvent("onload", blink);
                            else window.onload = blink;
                            </script>
                            <br>
                            <br>
                            <hr style="width:100px;border:2px solid #f7941d" />
                            <p style="text-align: center;"><b><a
                                        href="https://www.engtest.net/forum/detail.php?type_id=02-02&&topic_id=4763"
                                        target="_blank">
                                        <blink style="color: #FF33CC;">เอกสารรายละเอียดหลักสูตร</blink>
                                    </a><b></p>
                        </center>
                    </div>

                    <BR><BR>
                    <center>
                        <a href="https://www.engtest.net/shop/product_1year.php"><button
                                class="btn btn-lg btn-danger kanit btn_shortcut"><i class="fa fa-shopping-basket"></i>
                                Buy 1
                                YEAR COURSE</button></a>
                    </center>
                    <!-- <a href="#"><button class="btn btn-lg btn-confirm kanit btn_shortcut pull-right"><i
                                class="fa fa-sign-in"></i> Log In 1 YEAR COURSE</button></a> -->
                    <BR><BR><BR><BR>
                </div>
            </div>

        </div>
    </div>
    <?php footer(); ?>