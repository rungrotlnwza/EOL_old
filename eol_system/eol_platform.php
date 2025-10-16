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

    #sub_menu a.active {
        color: orange;
    }

    #sub_menu a {
        color: #00000;
        text-decoration: none;
    }

    #sub_menu a:hover {
        color: orangered;
    }

    .title_font_color {
        color: #fb921d;
        font-weight: bold;
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
                                <img src="../images/image2/about web/menu_icon/1year-course-new.jpg"
                                    style="width:180px;height:130px;"></a>
                            <a href="../eol_system/Intelligence.php">
                                <img src="../images/image2/about web/menu_icon/Intelligence-package-new.jpg"
                                    style="width:180px;height:130px;"></a>
                            <a href="../eol_system/corporate.php">
                                <img src="../images/image2/about web/menu_icon/coporate-new.jpg"
                                    style="width:180px;height:130px;"></a>
                            <a href="../eol_system/eol_platform.php">
                                <img src="../images/image2/about web/menu_icon/over-eol-platform.jpg"
                                    style="width:180px;height:130px;"></a>
                        </div>
                    </center>
                </div>

                <div style="padding:0px 150px;border:0px solid blue;" class="taviraj">
                    <center>
                        <div id="apDiv69" class="kanit" style="padding-top:20px;">
                            <h2><strong>EOL CORPORATE PLATFORM</strong><br>
                                <span style="font-size:24px;color:#707070;">สำหรับองค์กร</span>
                            </h2>
                            <hr style="width:100px;border:2px solid #f7941d" />
                        </div>
                    </center>
                    <div class="text_paragraph">

                        <center>
                            <img src="https://www.engtest.net/event/corporate-platform-2023/poster-corporate-platform-2023.png"
                                width="100%" style="border-radius:10px">
                            <br>
                            <br>
                            <img src="https://www.engtest.net/event/EOL Corporate Package 2022/poster-corporate.png"
                                width="100%" style="border-radius:10px">
                            <br>
                            <br>
                            <img src="https://www.engtest.net/New EOL/eol_system/3keys-success.jpg" width="90%"
                                style="border-radius:10px">
                            <br><br>
                        </center>
                        <br>

                        <!-- <p style="text-align: center;">
                            <font size="2" face="tahoma" color="white"><b>
                                    <font size="5" face="Times New Roman"><a
                                            href="https://www.engtest.net/event/Package-against-Covid/eol-order-platform.pdf"
                                            target="_blank">Download &gt;&gt;เอกสารรายละเอียดการอบรม</a></font>
                                </b></font>
                        </p> -->
                        <center>

                            <a href="https://www.engtest.net/shop/product_eol_platform.php"><button
                                    class="btn btn-lg btn-danger kanit btn_shortcut"><i
                                        class="fa fa-shopping-basket"></i> Buy CORPORATE PLATFORM </button></a>

                        </center>

                    </div>
                    <BR><BR>
                </div>
            </div>
        </div>
    </div>
    <?php footer(); ?>