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
                            <a href="../eol_system/eol_system_club.php">
                                <img src="../images/image2/about web/menu_icon/EOL-System-Club-over.jpg"
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
                                <img src="../images/image2/about web/menu_icon/eol-platform.jpg"
                                    style="width:180px;height:130px;"></a>

                            <!-- <a href="https://www.engtest.net/eol_system/gepot.php">
                                <img src="https://www.engtest.net/image2/eol system/gepot-new.jpg"
                                    style="width:180px;height:130px;"></a> -->
                        </div>
                    </center>
                </div>

                <div style="padding:0px 150px;border:0px solid blue;" class="taviraj">
                    <center>
                        <div id="apDiv69" class="kanit" style="padding-top:20px;">
                            <h2><strong>EOL MEMBER CLUB</strong><br>
                                <span style="font-size:24px;color:#707070;">ระบบการเรียนรู้ภาษาอังกฤษออนไลน์
                                    สำหรับบุคคลทั่วไป</span>
                            </h2>
                            <hr style="width:100px;border:2px solid #f7941d" />
                            <img src="https://www.engtest.net/event/EOL-Member-Club-2023/member2024.png"
                                width="100%">
                        </div>
                        <BR><BR>

                    </center>

                    <center>
                        <a href="../shop/product_eol_member_club.php"><button
                                class="btn btn-lg btn-danger kanit btn_shortcut"><i class="fa fa-shopping-basket"></i>
                                Buy EOL SYSTEM CLUB</button></a>
                    </center>

                    <BR><BR>
                </div>
            </div>

        </div>
    </div>
    <?php footer(); ?>