<?php
ob_start();
session_start();
include('../config/connection.php');
include('./config/connection.php');
include('../inc/user_info.php');
if ($_SESSION["x_member_id"] == '') {
    echo "<script type=\"text/javascript\">
                window.location=\"../index.php\";
          </script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>EOL System</title>
    <link rel='shortcut icon' type='image/x-icon' href='../images/image2/eol-icon.png'>
    <link rel="stylesheet" href="../bootstrap/css/tabbar.css">
    <link rel="stylesheet" href="../bootstrap/css/mainpage.css">
    <link rel="stylesheet" href="../bootstrap/css/eoltest.css">
    <style>
    .welcome {
        position: absolute;
        right: 35px;
        font-size: 2rem;
        font-weight: 600;
        font-family: fantasy;
        top: 28px;
    }

    .edit-profile {
        position: absolute;
        left: 140px;
        font-size: 1.5rem;
        font-weight: 600;
        font-family: fantasy;
        top: 48px;
    }

    .sub-member,
    .personal {
        position: absolute;
        left: 166px;
        font-size: 1.6rem;
        font-weight: 600;
        font-family: monospace;
        top: 390px;
    }

    .table-admin {
        width: 95%;
        max-width: 95%;
        border-radius: 5px;
        background: #67686847;
    }
    </style>

</head>

<body>
    <!--------------------------main content --------------------------->
    <div id="container">
        <div id="header">
            <a href="../index.php"><img src="../images/image2/logo/logo-02.png" width="270" height="118"
                    style="float:left;margin-left:20px; margin-top: 175px;" />
            </a>
            <!---- info user ----->
            <div id="info_user">
                <?php
$data = new info();
echo $data->loadinfo('test');
?>
                <div id="logoutPic">
                    <a href="../inc/logout.php"><img src="../images/image2/eol system/button/logout-06.png"
                            style="margin-top:13px;" /></a>
                </div>
            </div>
        </div>
        <!------- main content--------->
        <div id="content">
            <div id="pic_border">
                <img src="../images/image2/eol system/head-box-02.png" width="1024" />
            </div>

            <div id="content-div">

                <?php

if ($_SESSION["x_member_id"] != '') {
    include("eoloption.php");
}

?>
            </div>

            <div class='modal1' id='prompt1'>
                <h2> Rename Group</h2>
                <!-- input form. you can press enter too -->
                <form method="post" action='?section=business&&action=re_group'>
                    <input type="text" name="rename" id="rename"
                        style="width:220px; height:25px; border:1px solid #666; padding-left:5px;"><input type="text"
                        name="idrename" id="idrename" readonly style="border:none;color:#fff;" class="txt_rename">
                    <br><br>
                    <font id="txt_alert" style="color:red;display:none;"> ไม่สามารถเปลี่ยนชื่อ None Group ได้ </font>
                    <br>
                    <input type="submit" id="btn_rename" value="Save" class="btntest btn-save"
                        style="cursor:pointer;" />
                    <input type="button" value="Cancel" class="close btntest btn-cancel"
                        style="cursor:pointer;margin-left:10px;" />
                </form>
            </div>

            <div class='modal1' id='prompt2'>
                <h2> Edit Sub Account</h2>
                <!-- input form. you can press enter too -->
                <form method="post" action=''>
                    <b>New Username :</b> <input type="text" name="rename-subAcc" id="rename-subAcc"
                        style="width:195px; height:25px; border:1px solid #666;margin-left:16px;padding-left:5px;">
                    <input type="text" name="idre-sub" id="idre-sub" readonly style="border:none;color:#fff;width:70px;"
                        class="txt_rename"><br><br>
                    <b>New Password :</b><input type="password" name="pass" id="pass"
                        style="width:200px; height:25px; border:1px  solid #666;margin-left:22px;"><br><br>
                    <b>Re-New password :</b><input type="password" name="re-pass" id="re-pass"
                        style="width:200px; height:25px; border:1px  solid #666;"><br><br><br>
                    <div id="imgload" style="display:none; margin-top:10px; margin-left:130px;"> <img
                            src="../images/image2/eol system/loading2.gif" /></div>
                    <div id="editerror" style="margin-top:-20px;float:right;height:30px;width:250px;"></div>
                    <input type="button" id="btn_rename" value="Save" class="btntest btn-save"
                        style="cursor:pointer;margin-left:130px;" onclick="edit_subAcc_Call()" />
                    <input type="button" value="Cancel" class="close btntest btn-cancel"
                        style="cursor:pointer;margin-left:30px;" />
                </form>
            </div>

            <div class='modal1' id='prompt3'>
                <h2> Edit Master Account</h2>
                <!-- input form. you can press enter too -->
                <form method="post" action=''>
                    <b>New Username :</b> <input type="text" name="rename-masterAcc" id="rename-masterAcc"
                        style="width:195px; height:25px; border:1px solid #666;margin-left:16px;padding-left:5px;">
                    <input type="text" name="idre-mas" id="idre-mas" readonly style="border:none;color:#fff;width:70px;"
                        class="txt_rename"><br><br>
                    <b>New Password :</b><input type="password" name="pwd" id="pwd"
                        style="width:200px; height:25px; border:1px  solid #666;margin-left:22px;"><br><br>
                    <b>Re-New password :</b><input type="password" name="re-pwd" id="re-pwd"
                        style="width:200px; height:25px; border:1px  solid #666;"><br><br><br>
                    <div id="imgload" style="display:none; margin-top:10px; margin-left:130px;"> <img
                            src="../images/image2/eol system/loading2.gif" /></div>
                    <div id="master_error" style="margin-top:-20px;float:right;height:30px;width:250px;"></div>
                    <input type="button" id="btn_rename" value="Save" class="btntest btn-save"
                        style="cursor:pointer;margin-left:130px;" onclick="edit_masterAcc_Call()" />
                    <input type="button" value="Cancel" class="close btntest btn-cancel"
                        style="cursor:pointer;margin-left:30px;" />
                </form>
            </div>

        </div>
        <!-----------end main cotent------------>
    </div>

    <!------------------- footer -------------->
    <div>
        <center style="margin-bottom:10px; margin-top:-3px;"><b>Copyright © 2024 By English Online Co.,Ltd. All rights
                reserved.</b>
        </center>
    </div>
    <script src='../bootstrap/js/jquery.min.js'></script>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery-tools/1.2.7/jquery.tools.min.js'>
    </script>
    <script>
    const tabs = document.querySelectorAll('[data-tab-target]');
    const tabContents = document.querySelectorAll('[data-tab-content]')
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = document.querySelector(tab.dataset.tabTarget);
            tabContents.forEach(tabContent => {
                tabContent.classList.remove('active');
            })
            tabs.forEach(tab => {
                tab.classList.remove('active');
            })
            tab.classList.add('active');
            target.classList.add('active');
        })
    })
    </script>
    <script>
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

    function rename() {
        var idname = $('#group_id').val();
        if (idname != 0) {
            var namegroup = $("#group_id :selected").text();
            var name = namegroup.split('[');
            $("#rename").val(name[0]);
            $("#idrename").val(idname);
            $("#btn_rename").removeAttr("disabled");
            $("#txt_alert").hide();
        } else {
            $("#btn_rename").attr("disabled", "disabled");
            $("#txt_alert").show();
        }
    }

    function alt1() {
        var id = $("#idre-sub").val();
        var name = $("#rename-subAcc").val();
        alert(name + id);
    }

    function edit_subAcc(Obj) {
        var id = Obj.id;
        //$(Obj).attr("data-user").val();
        $("#rename-subAcc").val($("#userdata_" + id).text());
        $("#idre-sub").val(id);
        $("#pass").val("")
        $("#re-pass").val("")
        $("#editerror").html("");
        //alert($("#idre-sub").val());
    }

    function edit_masterAcc(Obj) {
        var id = Obj.id;
        $("#rename-masterAcc").val($("#userdata_" + id).text());
        $("#idre-mas").val(id);
        $("#pwd").val("")
        $("#re-pwd").val("")
        $("#master_error").html("");
    }

    function clear() {
        $("#editerror").val("");
        $("#master_error").val("");
    }

    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m, key, value) {
            vars[key] = value;
        });
        return vars;
    }

    function edit_subAcc_Call() {
        var idsub = $("#idre-sub").val();
        let page = getUrlVars()["page"];

        if (!page) {
            page = '1';
        }

        $.ajax({
            type: "POST",
            url: "edit_subAcc.php",
            data: {
                rename: $("#rename-subAcc").val(),
                newpass: $("#pass").val(),
                repass: $("#re-pass").val(),
                member: idsub
            },
            beforeSend: function() {
                $("#imgload").show();
            },
            complete: function() {
                $("#imgload").hide();
            },
            success: function(response) {
                $("#poduct_order").html(response);

                if (response == 'OK') {
                    window.location = "eoltest.php?section=business&&page=" + page;
                } else {
                    $("#editerror").html(response);
                }
            },
            error: function(error) {
                $("#editerror").html(error);
            }
        });
    }

    function edit_masterAcc_Call() {
        var idmas = $("#idre-mas").val();
        let page = getUrlVars()["page"];

        if (!page) {
            page = '1';
        }
        $.ajax({
            type: "POST",
            url: "edit_masterAcc.php",
            data: {
                rename: $("#rename-masterAcc").val(),
                newpass: $("#pwd").val(),
                repass: $("#re-pwd").val(),
                member: idmas
            },
            beforeSend: function() {
                $("#imgload").show();
            },
            complete: function() {
                $("#imgload").hide();
            },
            success: function(response) {
                if (response == 'OK') {
                    window.location = "eoltest.php?section=business&&status=manage_admin&&page=" + page;
                } else {
                    $("#master_error").html(response);
                }
            },
            error: function(error) {
                $("#master_error").html(error);
            }
        });
    }
    $(function() {
        $(window).bind("beforeunload", function(event) {

            var msg = "ยืนยันต้องการปิดหน้านี้ ?";
            $(window).bind("unload", function(event) {
                event.stopImmediatePropagation();

                $.ajax({
                    type: "POST",
                    url: "../inc/updatetimeout.php",
                    data: '',
                    success: function(response) {
                        if (response == 'OK') {
                            alert(msg);
                        }
                    },
                    async: false
                });
            });
            return;
        });
        $("a").click(function() {
            $(window).unbind("beforeunload");
        });
    });

    function changelistExam(obj) {
        var idinput = $(obj).attr('data-select');
        var level = $('#level' + idinput).val();
        var skill = $('#skill_id' + idinput).val();
        //alert(skill +'  '+level); 
        $.ajax({
            type: "POST",
            url: "addExamlist.php",
            data: {
                label: 'change',
                skill_id: skill,
                level_id: level
            },
            beforeSend: function() {
                $("#imgloading").show();
            },
            complete: function() {
                $("#imgloading").hide();
            },
            success: function(response) {
                $('#topic' + idinput).html(response);
            },
            error: function(error) {
                //$("#showpost").append('<p align="center"></p>');
            }
        });
    }

    function Input_Eng() {
        if (event.keyCode >= 3585) {
            event.returnValue = false;
        }
    }

    function checknum() {
        if (event.keyCode < 48 || event.keyCode > 57) {
            event.returnValue = false;
        }
    }

    function addNewExam() {
        var numquiz = 0;
        $('input[name="num[]"]').each(function() {
            numquiz += parseInt($(this).val());
        });
        if (numquiz < 30) {
            $.ajax({
                type: "POST",
                url: "addExamlist.php",
                data: {
                    label: 'newlist'
                },
                beforeSend: function() {
                    $("#imgloading").show();
                },
                complete: function() {
                    $("#imgloading").hide();
                },
                success: function(response) {
                    $('#tbcreate').append(response);
                },
                error: function(error) {
                    //$("#showpost").append('<p align="center"></p>');
                }
            });
        }
    }

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

    function Removetr(obj) {
        $(obj).parent().parent().remove();
    }
    </script>
</body>

</html>