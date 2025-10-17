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
        font-size: 18px;
        text-decoration: none;
    }

    #sub_menu a:hover {
        color: orangered;
    }

    .title_font_color {
        color: #fb921d;
    }
    </style>
</head>

<body>
    <div class="container shadow_side" style="width:1150px !important;background:#ffffff;margin-top:45px;">

        <?= callheader(); ?>

        <div class="row kanit">
            <div class="col-xs-12" style="padding:0px;margin:0px;">
                <div id="sub_menu"
                    style="border-top:1px solid #f7941d;border-bottom:1px solid #f7941d; padding:10px;text-align:center;background:#f3f3f3;">
                    <a href="../shop/product_eol_member_club.php" style="padding-right:30px;"> •
                        สินค้า</a>
                    <a href="../shop/payment.php" class="active" style="padding-right:30px;">•
                        วิธีการสั่งซื้อ</a>
                    <a href="../shop/policy-change-product.php">•
                        นโยบายการเปลี่ยนสินค้า</a>
                </div>

                <div style="padding:0px 150px;border:0px solid blue;" class="taviraj">
                    <center>
                        <div id="apDiv69" class="kanit" style="padding-top:20px;">
                            <h2><strong>วิธีการสั่งซื้อ</strong><br>
                                <span style="font-size:24px;color:#707070;">การสั่งซื้อสินค้า</span>
                            </h2>
                            <hr style="width:100px;border:2px solid #f7941d" />
                            <img src="../images/shop/order.jpg" width="100%">
                        </div>
                    </center>
                    <BR><BR>
                </div>
            </div>

        </div>
    </div>
    <?php footer(); ?>