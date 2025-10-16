<?php
session_start();
// require('info_user.php');
?>
<meta charset="UTF-8">
<!-- <meta name="theme-color" content="#f75b1e"> -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
<!-- The above 2 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="ทดสอบภาษาอังกฤษ แบบฝึกหัดภาษาอังกฤษ เรียนภาษาอังกฤษออนไลน์ ภาษาอังกฤษในชีวิตประจำวัน">
<meta name="author" content="บริษัท อิงลิซออนไลน์ จำกัด">
<meta name="keywords"
    content="English Online,EngTest.net,EngTest,English online test,EOL System,แบบทดสอบภาษาอังกฤษอิงลิซ ออนไลน์,ทดสอบภาษาอังกฤษ,อิงเทส,อิงเทสดอทเน็ต,แบบฝึกหัดภาษาอังกฤษ,อีโอแอล ซิสเต็ม,ทดสอบภาษาอังกฤษ,แบบฝึกหัดภาษาอังกฤษ,เรียนภาษาอังกฤษออนไลน์,ภาษาอังกฤษในชีวิตประจำวัน" />
<link rel='shortcut icon' type='image/x-icon' href='https://www.engtest.net/images/image2/logo/logo-02.ico'>

<!-- Note there is no responsive meta tag here -->

<title>EOL System | ทดสอบภาษาอังกฤษ แบบฝึกหัดภาษาอังกฤษ เรียนภาษาอังกฤษออนไลน์ ภาษาอังกฤษในชีวิตประจำวัน</title>

<!-- Bootstrap core CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link
    href="https://fonts.googleapis.com/css?family=Athiti|Chonburi|Itim|Kanit:300|Maitree|Mitr|Pattaya|Pridi|Prompt|Sriracha|Taviraj|Trirong"
    rel="stylesheet">
<link href="https://www.engtest.net/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<style>
.kanit {
    font-family: 'Kanit', sans-serif;
}

.prompt {
    font-family: 'Prompt', sans-serif;
}

.itim {
    font-family: 'Itim', cursive;
}

.pridi {
    font-family: 'Pridi', serif;
}

.trirong {
    font-family: 'Trirong', serif;
}

.taviraj {
    font-family: 'Taviraj', serif;
}

.mitr {
    font-family: 'Mitr', sans-serif;
}

.athiti {
    font-family: 'Athiti', sans-serif;
}

.maitree {
    font-family: 'Maitree', serif;
}

.sriracha {
    font-family: 'Sriracha', cursive;
}

.pattaya {
    font-family: 'Pattaya', sans-serif;
}

.chonburi {
    font-family: 'Chonburi', cursive;
}

.row-eq-height {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
}

.btn-confirm {
    background: #ef972d;
    border: 1px solid #ef972d;
    color: #fff;
}

.btn-confirm:hover {
    background: #E48511;
    border: 1px solid #E48511;
    color: #fff;
}

.title_section {
    padding-top: 10px;
    font-family: 'Mitr', sans-serif;
    font-size: 24px;
    color: #f7941d;
}

.content_section {
    border: 1px solid #f7941d;
    border-top: 5px solid #f7941d;
    padding: 15px;
}

.over_a {
    text-decoration: none !important;
}

.text-bold {
    font-weight: bold;
}

.text-white {
    color: #FFFFFF !important;
}

.text-grey {
    color: grey !important;
}

.text-black {
    color: #000000 !important;
}

.text-blue {
    color: blue !important;
}

.text-red {
    color: red !important;
}

.font-tahoma {
    font-family: tahoma !important;
}

.font-small {
    font-size: 80% !important;
}

.title_3_menu {
    height: 60px;
    text-align: center;
    font-family: 'kanit', sans-serif;
    font-size: 20px;
    color: #ffffff;
    line-height: 60px;
}

.icon_circle {
    border-radius: 50%;
    width: 64px;
    height: 64px;
    background: #f7941d;
}

.title_english_room {
    color: #f7941d;
    font-size: 24px;
    padding-top: 35px;
    font-weight: bold;
    font-family: kanit;
}

.no-space {
    padding: 0px !important;
}

.form-control,
.btn {
    -webkit-border-radius: 0 !important;
    -moz-border-radius: 0 !important;
    border-radius: 5px !important;
}

.form-control .btn:hover {
    color: black !important;
}

.shadow_side {
    width: 300px;
    margin: 0 auto;
    box-shadow: -60px 0px 100px -90px #000000, 60px 0px 100px -90px #000000;
}

.column-items:hover {
    border-radius: 4px;
    transform: translateY(-10px);
    box-shadow: 3px 10px 20px rgba(0, 0, 0, .3);
}

.site_map li {
    border-bottom: 1px solid #eee;
    list-style: none;
    padding: 0px;
    position: relative;
}

.site_map {
    padding: 0;
    list-style-type: none;
}

.bodyfooter {
    margin-top: 10px;
}

.icon_circle:hover {
    background: black;
}

.title_english_room:hover {
    color: black;
}

.title_3_menu:hover {
    color: black;
}

.content_section.kanit:hover {
    background: #80808021;
}

.title_section:hover {
    color: black;
}

.dropdown-toggle:hover {
    color: black;
    font-weight: bold;
}

.content_section:hover {
    background: #80808021;
}


#login:hover {
    color: black !important;
    font-weight: bold;
}

a#signup span:hover {
    color: black !important;
    font-weight: bold;
}

a#forgot span:hover {
    color: black !important;
    font-weight: bold;
}

button#activity:hover {
    background: #f75b1e !important;
    color: #000 !important;
    font-weight: bold;
}

button#news_events:hover {
    background: #f75b1e !important;
    color: #000 !important;
    font-weight: bold;
}

.news_events_img:hover {
    transform: translateY(-5px);
    box-shadow: 3px 10px 20px rgba(0, 0, 0, .3);
}

.activity_img:hover {
    transform: translateY(-5px);
    box-shadow: 3px 10px 20px rgba(0, 0, 0, .3);
}

.social_eol:hover {
    transform: translateY(-5px);
    box-shadow: 3px 10px 20px rgba(0, 0, 0, .4);
    background: none !important;
}

body {
    margin-bottom: 0px !important;
    padding-bottom: 0px !important;

}
</style>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> -->
<nav class="navbar navbar-inverse navbar-fixed-top" style="background:#f7941d;border:#f7941d;color:#FFFFFF !important;">
    <div class="container" style="width:1150px !important;color:#FFFFFF !important;">
        <div class="navbar-header">
            <a class="navbar-brand" href="https://www.engtest.net/" style="color:#FFFFFF !important;">
                <img src="https://www.engtest.net/images/index/logo-eol.png" style="height:40px;margin-top:-10px;" />
            </a>
        </div>
    </div>
</nav>
<?php

function callheader()
{
?>
<!--Banner-->
<div class="row">
    <div class="col-xs-12" style="padding:10px;background:#525252;">
        <img src="https://www.engtest.net/images/index/TEOC11.webp" style="width:100%;">
    </div>
</div>
<!--Log in-->
<div class="row row-eq-height">
    <div class="col-xs-5" style="padding:10px;background:#f6b047;">
        <a href="https://www.engtest.net/" class="over_a" title="Home">
            <img src="https://www.engtest.net/images/index/EOL19Year.png" style="height:60px;">
        </a>
        <div style="display:inline-block;padding-left:10px;"><?= social(); ?></div>
    </div>
    <div class="col-xs-7 kanit" style="padding:15px 75px 5px;background:#f6b047;">
        <?php
    $data = new info();
    echo $data->loadinfo('normal');
?>
    </div>
</div>
<!--Menu-->
<div class="row">
    <div class="col-xs-12" style="padding:10px;background:#ffffff;">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav" style="font-size:95%;">
                <li style="color:black;"><a class="dropdown-toggle" href="https://www.engtest.net/">HOME</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">EOL
                        CONTEST <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a class="pridi"
                                href="https://www.engtest.net/forum/detail.php?type_id=02-03&&topic_id=4754">Thailand
                                English Online Contest ครั้งที่ 5
                            </a>
                        </li>
                        <li>
                            <a class="pridi"
                                href="https://www.engtest.net/forum/detail.php?type_id=02-03&&topic_id=4717">Thailand
                                English Online Contest ครั้งที่ 4
                            </a>
                        </li>
                        <li>
                            <a class="pridi"
                                href="https://www.engtest.net/forum/detail.php?type_id=02-03&&topic_id=4609">Thailand
                                English Online Contest ครั้งที่ 3
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">ABOUT
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a class="pridi" href="https://www.engtest.net/info/about_eol.php">เกี่ยวกับ EOL</a>
                        </li>
                        <li>
                            <a class="pridi" href="https://www.engtest.net/info/whatiseol.php">What is EOL</a>
                        </li>
                        <li>
                            <a class="pridi" href="https://www.engtest.net/info/eol.php">กว่าจะเป็น EOL</a>
                        </li>
                        <li>
                            <a class="pridi" href="https://www.engtest.net/info/safe.php">ความปลอดภัยของเว็บไซต์</a>
                        </li>
                        <li>
                            <a class="pridi" href="https://www.engtest.net/info/privacy.php">นโยบายความเป็นส่วนตัว</a>
                        </li>
                        <li><a class="pridi"
                                href="https://www.engtest.net/info/stop.php">ข้อร้องเรียนและการระงับข้อพิพาท</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">EOL
                        SYSTEM <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a class="pridi" href="https://www.engtest.net/eol_system/eol_member_club.php">EOL
                                Member Club</a>
                        </li>
                        <li>
                            <a class="pridi" href="https://www.engtest.net/eol_system/personal.php">EOL Personal</a>
                        </li>
                        <li>
                            <a class="pridi" href="https://www.engtest.net/eol_system/oneyear.php">1 Year Course</a>
                        </li>
                        <li>
                            <a class="pridi" href="https://www.engtest.net/eol_system/Intelligence.php">EOL
                                Intelligence</a>
                        </li>
                        <li>
                            <a class="pridi" href="https://www.engtest.net/eol_system/corporate.php">EOL Corporate</a>
                        </li>
                        <li>
                            <a class="pridi" href="https://www.engtest.net/eol_system/eol_platform.php">EOL Corporate
                                Platform</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                        aria-expanded="false">PRODUCT
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a class="pridi"
                                href="https://www.engtest.net/shop/product_eol_member_club.php">สั่งซื้อสินค้า</a>
                        </li>
                        <li>
                            <a class="pridi"
                                href="https://www.engtest.net/shop/policy-change-product.php">นโยบายการเปลี่ยนสินค้า</a>
                        </li>
                        <li>
                            <a class="pridi" href="https://www.engtest.net/shop/warranty.php">การรับประกันสินค้า</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">EOL
                        COLUMN <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a class="pridi" href="https://www.engtest.net/forum/e-en.php?type_id=03-01">One day One
                                sentence</a>
                        </li>
                        <li>
                            <a class="pridi" href="https://www.engtest.net/forum/e-en.php?type_id=03-12">English from
                                News</a>
                        </li>
                        <li>
                            <a class="pridi" href="https://www.engtest.net/forum/e-en.php?type_id=03-10">Easy
                                English</a>
                        </li>
                        <li>
                            <a class="pridi" href="https://www.engtest.net/forum/e-en.php?type_id=03-11">Comprehensive
                                Listening</a>
                        </li>
                        <li>
                            <a class="pridi" href="https://www.engtest.net/forum/e-en.php?type_id=03-03">Grammar &
                                Writing</a>
                        </li>
                        <li>
                            <a class="pridi" href="https://www.engtest.net/forum/e-en.php?type_id=03-15">Communicative
                                English</a>
                        </li>
                        <li>
                            <a class="pridi" href="https://www.engtest.net/forum/e-en.phptype_id=03-08">Pronunciation &
                                Phonetic</a>
                        </li>
                        <li>
                            <a class="pridi" href="https://www.engtest.net/forum/e-en.php?type_id=03-07">Song of
                                Souls</a>
                        </li>
                        <li>
                            <a class="pridi" href="https://www.engtest.net/forum/e-en.php?type_id=03-05">Movie World</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                        aria-expanded="false">STANDARD
                        TEST <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a class="pridi" href="https://www.engtest.net/exam_list/eol-standard-test.php">GEPOT
                                Testing</a></li>
                        <li><a class="pridi" href="https://www.engtest.net/exam_list/admission.php">Admission</a></li>
                        <li><a class="pridi" href="https://www.engtest.net/exam_list/cu-tep.php">CU-TEP</a></li>
                        <li><a class="pridi" href="https://www.engtest.net/exam_list/cefr.php">CEFR</a></li>
                        <li><a class="pridi" href="https://www.engtest.net/exam_list/toefl.php">TOFEL</a></li>
                        <li><a class="pridi" href="https://www.engtest.net/exam_list/toeic.php">TOEIC</a></li>
                        <li><a class="pridi" href="https://www.engtest.net/exam_list/ielts.php">IELTS</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                        aria-expanded="false">CONTACT
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a class="pridi" href="https://www.engtest.net/contact/contact.php">ติดต่อเรา</a></li>
                        <li><a class="pridi" href="https://www.engtest.net/contact/work.php">ร่วมงานกับเรา</a></li>
                    </ul>
                </li>
                <?php
                $session = isset($_SESSION['x_member_1year']) || isset($_SESSION['x_member_id']) || isset($_SESSION['y_member_id']);
                ?>
                <li style="<?php if (!$session) echo 'display:none;'; ?>">
                    <a class="dropdown-toggle" href="https://www.engtest.net/certificate.php">CERTIFICATE</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php
}

function social()
{
    echo '<div id="apDiv70">
        <a class="social_eol" href="https://www.facebook.com/EOLSystem" target=_blank><img src="https://www.engtest.net/images/logo social/facebook.png" width="30" height="30" /></a>
        <a class="social_eol" href="https://www.instagram.com/engtesteol" target=_blank><img src="https://www.engtest.net/images/logo social/instagram.png" width="30" height="30" /></a>
        <a class="social_eol" href="https://twitter.com/engtest_eol" target=_blank><img src="https://www.engtest.net/images/logo social/twitter.png" width="30" height="30" /></a>
        <a class="social_eol" href="https://www.youtube.com/channel/UC2eLEAWZFnGlwjc08cFuPNw" target=_blank><img src="https://www.engtest.net/images/logo social/youtube.png" width="30" height="30" /></a>
        <a class="social_eol" href="https://line.me/ti/p/7na4n6fiSU" target=_blank><img src="https://www.engtest.net/images/logo social/linelogo.png" width="30" height="30" style="border-radius:20px;"/></a>
        <a class="social_eol" href="https://qr-official.line.me/L/gR0G8iQqGG.png" target=_blank><img src="https://www.engtest.net/images/logo social/line_at.png" width="30" height="30" style="border-radius:20px;"/></a>
      </div>';
}
?>