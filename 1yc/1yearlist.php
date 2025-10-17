<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');
include('../config/connection.php');
include('fn_1yc.php');
check_duel_login();
$date = date("Y-m-d H:i:s");
if ($_SESSION['x_member_1year'] != '') {
    $strSQL = "SELECT * FROM tbl_x_member_1year WHERE id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $_SESSION['x_member_1year']);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_have = $result->num_rows;
    if ($is_have) {
        $data = $result->fetch_array();
        $realdate = floor(((strtotime($date) - strtotime($data['startdate'])) / (60 * 60 * 24)) / 7);
    }
    mysqli_close($conn);
}
else {
    header("Location:../index.php");
    exit;
}
function check_duel_login()
{
    include('../config/connection.php');
    $session_id = session_id();
    $strSQL = "SELECT * FROM tbl_x_login_1year WHERE member_id = ? && ssid = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ss", $_SESSION['x_member_1year'], $session_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_ok = $result->num_rows;
    if ($is_ok == 0) {
        unset($_SESSION['x_member_1year']);
    }
    $stmt->close();
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>หลักสูตรเรียนภาษาอังกฤษออนไลน์ 1 ปี</title>
    <link rel="shortcut icon" type="image/x-icon" href="../images/image2/1year/1 year icon.ico">

    <!-- Bootstrap CSS -->

    <link rel="stylesheet" type="text/css" href="../bootstrap/LateralOnScrollSliding/css/demo.css" />
    <link rel="stylesheet" type="text/css" href="../bootstrap/LateralOnScrollSliding/css/style.css" />


    <style type="text/css">
    /* To create the middle line throughout the container, we’ll use a pseudo element that we’ll position in the middle of the container: */

    .ss-container:before {
        position: absolute;
        width: 4px;
        background: rgba(17, 17, 22, 0.8);
        top: 0px;
        left: 50%;
        margin-left: -2px;
        content: '';
        height: 100%;
    }

    /* < !--The row will serve as a wrapper for the left and right elements: */
    .ss-row {
        width: 100%;
        clear: both;
        float: left;
        position: relative;
        padding: 30px 0;
    }

    /* < !--The two lateral elements will occupy half of the width: */
    .ss-left,
    .ss-right {
        float: left;
        width: 48%;
        position: relative;
    }

    .ss-right {
        padding-left: 2%;
    }

    .ss-left {
        text-align: right;
        float: left;
        padding-right: 2%;
    }

    /* < !--The headings will have the following style:--> */
    .ss-container h2 {
        font-size: 40px;
        text-transform: uppercase;
        padding: 20px 0px;
    }

    .ss-container h3 {
        margin-top: 34px;
        padding: 10px 15px;
        background: rgba(26, 27, 33, 0.6);
        text-shadow: 1px 1px 1px rgba(26, 27, 33, 0.8)
    }

    /* < !--To create a circle, we’ll set the border radius of the anchor to 50% and we’ll add some neat box shadow:--> */
    .ss-circle {
        border-radius: 50%;
        overflow: hidden;
        display: block;
        text-indent: -9000px;
        text-align: left;
        box-shadow:
            0px 2px 5px rgba(0, 0, 0, 0.7) inset,
            0px 0px 0px 12px rgba(61, 64, 85, 0.3);
        background-size: cover;
        background-color: #f0f0f0;
        background-repeat: no-repeat;
        background-position: center center;
    }

    /* < !--We’ll have three different circle sizes and depending on which side we are we’ll make the circle float either left or right:--> */
    .ss-small .ss-circle {
        width: 100px;
        height: 100px;
    }

    .ss-medium .ss-circle {
        width: 200px;
        height: 200px;
    }

    .ss-large .ss-circle {
        width: 300px;
        height: 300px;
    }

    .ss-left .ss-circle {
        float: right;
        margin-right: 30%;
    }

    .ss-right .ss-circle {
        float: left;
        margin-left: 30%;
    }

    /* < !--We’ll use the pseudo element :before and :after in order to create the line and the arrow that will point to the middle line. The width will be defined as a percentage so that it adjust to the screen size. We’ll also center it by setting the top to 50% and correct the position by setting the margin-top to -3px. Depending on where we are (left or right side) we want the position to be different:--> */
    .ss-circle-deco:before {
        width: 29%;
        height: 0px;
        border-bottom: 5px dotted #ddd;
        border-bottom: 5px dotted rgba(17, 17, 22, 0.3);
        box-shadow: 0px 1px 1px #fff;
        position: absolute;
        top: 50%;
        content: '';
        margin-top: -3px;
    }

    .ss-left .ss-circle-deco:before {
        right: 2%;
    }

    .ss-right .ss-circle-deco:before {
        left: 2%;
    }

    /* < !--The little arrow will be created by the border style and depending on if it’s a child of the left or right side, we’ll set the according border and position:--> */
    .ss-circle-deco:after {
        width: 0px;
        height: 0px;
        border-top: 10px solid transparent;
        border-bottom: 10px solid transparent;
        content: '';
        position: absolute;
        top: 50%;
        margin-top: -10px;
    }

    .ss-left .ss-circle-deco:after {
        right: 0;
        border-right: 10px solid rgba(17, 17, 22, 0.8);
    }

    .ss-right .ss-circle-deco:after {
        left: 0;
        border-left: 10px solid rgba(17, 17, 22, 0.8);
    }

    /*< !--Because of the different circle sizes,we’ll need to adjust the position of the headings on the other side. We want them to be at the height of the arrow, so we’ll set the margins differently (the one for ss-small is already set in the circle itself):--> */
    .ss-container .ss-medium h3 {
        margin-top: 82px;
    }

    .ss-container .ss-large h3 {
        margin-top: 133px;
    }

    .ss-container .ss-left h3 {
        border-right: 5px solid rgba(164, 166, 181, 0.8);
    }

    .ss-container .ss-right h3 {
        border-left: 5px solid rgba(164, 166, 181, 0.8);
    }

    /* < !--The style for the description:--> */
    .ss-container h3 span {
        color: rgba(255, 255, 255, 0.8);
        font-size: 13px;
        display: block;
        padding-bottom: 5px;
    }

    .ss-container h3 a {
        font-size: 18px;
        color: rgba(255, 255, 255, 0.9);
        display: block;
    }

    .ss-container h3 a:hover {
        color: rgba(255, 255, 255, 1);
    }

    /* < !--Each circle is going to have a different background image:--> */
    .fontsub {
        font-size: 18px;
    }

    .fontsub a {
        font-size: 18px;
    }

    ul.st_navigation {
        position: absolute;
        width: 100%;
        top: 140px;
        left: -300px;
        list-style: none;
    }

    ul.st_navigation li {
        float: left;
        clear: both;
        margin-bottom: 8px;
        position: relative;
        width: 100%;
    }

    ul.st_navigation li span.st_link {
        background-color: #000;
        float: left;
        position: relative;
        line-height: 50px;
        padding: 0px 20px;
        -moz-box-shadow: 0px 0px 2px #000;
        -webkit-box-shadow: 0px 0px 2px #000;
        box-shadow: 0px 0px 2px #000;
    }

    ul.st_navigation li span.st_arrow_down,
    ul.st_navigation li span.st_arrow_up {
        position: absolute;
        margin-left: 15px;
        width: 40px;
        height: 50px;
        cursor: pointer;
        -moz-box-shadow: 0px 0px 2px #000;
        -webkit-box-shadow: 0px 0px 2px #000;
        box-shadow: 0px 0px 2px #000;
    }

    .st_wrapper {
        position: absolute;
        width: 100%;
        height: 126px;
        overflow-y: hidden;
        top: 90px;
        left: 0px;
    }

    .st_thumbs {
        height: 60px;
        margin: 0;
        position: fixed;
        left: 55px;
        top: 86%;
        width: 93%;
        z-index: 100;
    }

    .st_thumbs img {
        float: left;
        margin: 3px 3px 0px 0px;
        cursor: pointer;
        -moz-box-shadow: 1px 1px 5px #000;
        -webkit-box-shadow: 1px 1px 5px #000;
        box-shadow: 1px 1px 5px #000;
        opacity: 0.7;
        filter: progid:DXImageTransform.Microsoft.Alpha(opacity=70);
    }

    .st_thumbs a {
        background: rgba(0, 0, 0, 0.2);
        font-size: 16px;
        font-weight: bold;
        width: 40px;
        height: 40px;
        line-height: 40px;
        margin: 5px;
        float: left;
        border-radius: 50%;
        display: block;
        text-align: center;
        -webkit-transition: background 0.2s linear;
        -moz-transition: background 0.2s linear;
        -o-transition: background 0.2s linear;
        -ms-transition: background 0.2s linear;
        transition: background 0.2s linear;
    }

    .st_thumbs a:hover {
        margin-top: -5px;
        width: 50px;
        height: 50px;
        line-height: 50px;
        font-size: 20px;
        text-align: center;
        background: rgba(0, 0, 0, 0.9);
        color: #fff;
    }

    .st_thumbs img {
        float: left;
        margin: 3px 3px 0px 0px;
        cursor: pointer;
        -moz-box-shadow: 1px 1px 5px #000;
        -webkit-box-shadow: 1px 1px 5px #000;
        box-shadow: 1px 1px 5px #000;
        opacity: 0.7;
        filter: progid:DXImageTransform.Microsoft.Alpha(opacity=70);
    }

    .container {
        overflow: hidden;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <center>
                <img src="../images/image2/1year/bg-1-year-head.jpg">
            </center>
            <a href="../1yearcourse.php" title="Home">
                <img src="../images/image2/1year/button/home-08.png" width="50" height="50"
                    style="position:absolute;z-index:250;left:50%;margin-left:350px;top:5px;">
            </a>

            <a href="../inc/logout.php" title="logout">
                <img src="../images/image2/1year/button/log-out.png"
                    style="position:absolute;z-index:250;left:50%;margin-left:420px;top:5px;">
            </a>

            <div class="clr"></div>
        </div>

        <center>
            <img src="../images/image2/1year/name-head.jpg"
                style="border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;">

            <ul id="st_nav" class="st_navigation">
                <li class="album">
                    <div class="st_wrapper st_thumbs_wrapper">
                        <div class="st_thumbs">
                            <?php
for ($i = 1; $i <= 52; $i++) {
    echo "<a href='#week$i'>W$i</a>";
}
?>
                        </div>
                    </div>
                </li>
            </ul>
        </center>
        <?php
//echo $realdate;
echo show($realdate);

?>
    </div>
    <!-- jQuery -->
    <script type="text/javascript" src="../bootstrap/LateralOnScrollSliding/js/modernizr.custom.js">
    </script>
    <script type="text/javascript" src="../bootstrap/LateralOnScrollSliding/js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="../bootstrap/LateralOnScrollSliding/js/jquery.easing.1.3.js">
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

    window.onload = function() {
        MM_preloadImages();
    }

    // scroll  buttton week
    $(function() {
        //the ul element 
        var $list = $('#st_nav');

        buildThumbs();

        function buildThumbs() {
            $list.children('li.album').each(function() {
                var $elem = $(this);
                var $thumbs_wrapper = $elem.find('.st_thumbs_wrapper');
                var $thumbs = $thumbs_wrapper.children(':first');
                //each thumb has 180px and we add 3 of margin
                var finalW = $thumbs.find('a').length * 50;
                // $thumbs.css('width', finalW + 'px');
                //make this element scrollable
                console.log(finalW);
                makeScrollable($thumbs_wrapper, $thumbs);
            });
        }

        function makeScrollable($outer, $inner) {
            var extra = 2000;
            //Get menu width
            var divWidth = $outer.width();
            //Remove scrollbars
            $outer.css({
                overflow: 'hidden'
            });
            //Find last image in container
            var lastElem = $inner.find('a:last');
            $outer.scrollLeft(0);
            console.log($outer.width());
            console.log(lastElem);
            console.log(lastElem[0].offsetLeft);
            console.log(lastElem.outerWidth());
            //When user move mouse over menu
            $outer.unbind('mousemove').bind('mousemove', function(e) {
                var containerWidth = lastElem[0].offsetLeft + lastElem.outerWidth() + 2 *
                    extra;
                var left = (e.pageX - $outer.offset().left) * (containerWidth - divWidth) /
                    divWidth - extra;
                $outer.scrollLeft(-500);
            });
        }
    });
    // ---------------------------------//
    $(document).ready(function() {
        $(".tbntoggle").hover(function() {
            var id = $(this).attr("id");
            var splID = id.split("_");
            //  $("#menu"+splID[1]).toggle(200);
            $('#menu' + splID[1]).fadeIn();
        }, function() {
            var id = $(this).attr("id");
            var splID = id.split("_");
            $('#menu' + splID[1]).fadeOut(200);
        });
    });
    $(function() {
        var $sidescroll = (function() {
            // the row elements
            var $rows = $('#ss-container > div.ss-row'),
                // we will cache the inviewport rows and the outside viewport rows
                $rowsViewport, $rowsOutViewport,
                // navigation menu links    ss-links
                $links = $('.st_thumbs > a'),
                // the window element
                $win = $(window),
                // we will store the window sizes here
                winSize = {},
                // used in the scroll setTimeout function
                anim = false,
                // page scroll speed
                scollPageSpeed = 800,
                // page scroll easing
                scollPageEasing = 'easeInOutExpo',
                // perspective?
                hasPerspective = false,

                perspective = hasPerspective && Modernizr.csstransforms3d,
                // initialize function
                init = function() {
                    // get window sizes
                    getWinSize();
                    // initialize events
                    initEvents();
                    // define the inviewport selector
                    defineViewport();
                    // gets the elements that match the previous selector
                    setViewportRows();
                    // if perspective add css
                    if (perspective) {
                        $rows.css({
                            '-webkit-perspective': 600,
                            '-webkit-perspective-origin': '50% 0%'
                        });
                    }
                    // show the pointers for the inviewport rows
                    $rowsViewport.find('a.ss-circle').addClass('ss-circle-deco');
                    // set positions for each row
                    placeRows();
                },
                // defines a selector that gathers the row elems that are initially visible.
                // the element is visible if its top is less than the window's height.
                // these elements will not be affected when scrolling the page.
                defineViewport = function() {
                    $.extend($.expr[':'], {
                        inviewport: function(el) {
                            if ($(el).offset().top < winSize.height) {
                                return true;
                            }
                            return false;
                        }
                    });
                },
                // checks which rows are initially visible 
                setViewportRows = function() {
                    $rowsViewport = $rows.filter(':inviewport');
                    $rowsOutViewport = $rows.not($rowsViewport)
                },
                // get window sizes
                getWinSize = function() {
                    winSize.width = $win.width();
                    winSize.height = $win.height();
                },
                // initialize some events
                initEvents = function() {
                    // navigation menu links.
                    // scroll to the respective section.
                    $links.on('click.Scrolling', function(event) {
                        // scroll to the element that has id = menu's href
                        $('html, body').stop().animate({
                            scrollTop: $($(this).attr('href')).offset().top
                        }, scollPageSpeed, scollPageEasing);
                        return false;
                    });
                    $(window).on({
                        // on window resize we need to redefine which rows are initially visible (this ones we will not animate).
                        'resize.Scrolling': function(event) {
                            // get the window sizes again
                            getWinSize();
                            // redefine which rows are initially visible (:inviewport)
                            setViewportRows();
                            // remove pointers for every row
                            $rows.find('a.ss-circle').removeClass(
                                'ss-circle-deco');
                            // show inviewport rows and respective pointers
                            $rowsViewport.each(function() {
                                $(this).find('div.ss-left')
                                    .css({
                                        left: '0%'
                                    })
                                    .end()
                                    .find('div.ss-right')
                                    .css({
                                        right: '0%'
                                    })
                                    .end()
                                    .find('a.ss-circle')
                                    .addClass('ss-circle-deco');
                            });
                        },
                        // when scrolling the page change the position of each row	
                        'scroll.Scrolling': function(event) {
                            // set a timeout to avoid that the 
                            // placeRows function gets called on every scroll trigger
                            if (anim) return false;
                            anim = true;
                            setTimeout(function() {
                                placeRows();
                                anim = false;

                            }, 10);
                        }
                    });
                },
                // sets the position of the rows (left and right row elements).
                // Both of these elements will start with -50% for the left/right (not visible)
                // and this value should be 0% (final position) when the element is on the
                // center of the window.
                placeRows = function() {
                    // how much we scrolled so far
                    var winscroll = $win.scrollTop(),
                        // the y value for the center of the screen
                        winCenter = winSize.height / 2 + winscroll;
                    // for every row that is not inviewport
                    $rowsOutViewport.each(function(i) {
                        var $row = $(this),
                            // the left side element
                            $rowL = $row.find('div.ss-left'),
                            // the right side element
                            $rowR = $row.find('div.ss-right'),
                            // top value
                            rowT = $row.offset().top;
                        // hide the row if it is under the viewport
                        if (rowT > winSize.height + winscroll) {
                            if (perspective) {
                                $rowL.css({
                                    '-webkit-transform': 'translate3d(-75%, 0, 0) rotateY(-90deg) translate3d(-75%, 0, 0)',
                                    'opacity': 0
                                });
                                $rowR.css({
                                    '-webkit-transform': 'translate3d(75%, 0, 0) rotateY(90deg) translate3d(75%, 0, 0)',
                                    'opacity': 0
                                });
                            } else {

                                $rowL.css({
                                    left: '-50%'
                                });
                                $rowR.css({
                                    right: '-50%'
                                });
                            }
                        }
                        // if not, the row should become visible (0% of left/right) as it gets closer to the center of the screen.
                        else {
                            // row's height
                            var rowH = $row.height(),
                                // the value on each scrolling step will be proporcional to the distance from the center of the screen to its height
                                factor = (((rowT + rowH / 2) - winCenter) / (winSize
                                    .height / 2 + rowH / 2)),
                                // value for the left / right of each side of the row.
                                // 0% is the limit
                                val = Math.max(factor * 50, 0);

                            if (val <= 0) {

                                // when 0% is reached show the pointer for that row
                                if (!$row.data('pointer')) {

                                    $row.data('pointer', true);
                                    $row.find('.ss-circle').addClass(
                                        'ss-circle-deco');
                                }
                            } else {
                                // the pointer should not be shown
                                if ($row.data('pointer')) {

                                    $row.data('pointer', false);
                                    $row.find('.ss-circle').removeClass(
                                        'ss-circle-deco');
                                }
                            }

                            // set calculated values
                            if (perspective) {
                                var t = Math.max(factor * 75, 0),
                                    r = Math.max(factor * 90, 0),
                                    o = Math.min(Math.abs(factor - 1), 1);
                                $rowL.css({
                                    '-webkit-transform': 'translate3d(-' +
                                        t + '%, 0, 0) rotateY(-' + r +
                                        'deg) translate3d(-' + t +
                                        '%, 0, 0)',
                                    'opacity': o
                                });
                                $rowR.css({
                                    '-webkit-transform': 'translate3d(' +
                                        t + '%, 0, 0) rotateY(' + r +
                                        'deg) translate3d(' + t +
                                        '%, 0, 0)',
                                    'opacity': o
                                });

                            } else {
                                $rowL.css({
                                    left: -val + '%'
                                });
                                $rowR.css({
                                    right: -val + '%'
                                });
                            }
                        }
                    });
                };
            return {
                init: init
            };
        })();
        $sidescroll.init();
    });
    </script>
</body>

</html>