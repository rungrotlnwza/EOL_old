<?php
ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <title>EOL System | ทดสอบภาษาอังกฤษ แบบฝึกหัดภาษาอังกฤษ เรียนภาษาอังกฤษออนไลน์ ภาษาอังกฤษในชีวิตประจำวัน</title>
    <link rel="shortcut icon" type="image/x-icon" href="../images/image2/eol-icon.png">
    <!-- Bootstrap CSS -->
    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../bootstrap/css/backoffice.css">

    <script type="text/javascript" src="../js/ckeditor/ckeditor.js"></script>

    <script type="text/javascript" src="../js/ckeditor/plugins/emojione/libs/emojione/emojione.min.js"></script>
    <style>

    </style>
</head>

<body>

    <?php
    if (!isset($_SESSION["admin_id"])) {
        $_SESSION["admin_id"] = NULL;
    }
    if (!isset($_SESSION["admin"])) {
        $_SESSION["admin"] = NULL;
    }
    if ($_GET['section'] === "admin") {
        // error_reporting(E_ALL);
        // ini_set('display_errors', 1);
        include('fn_admin.php');
    }
    if ($_GET['section'] === "office") {
        // error_reporting(E_ALL);
        // ini_set('display_errors', 1);
        include('fn_office.php');
    }

    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

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

    function changelistExam(obj) {
        var idinput = $(obj).attr('data-select');
        var level = $('#level' + idinput).val();
        var skill = $('#skill_id' + idinput).val();
        //alert(skill +'  '+level); 
        $.ajax({
            type: "POST",
            url: "../EOL/addExamlist.php",
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
                url: "../EOL/addExamlist.php",
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

    function Removetr(obj) {
        $(obj).parent().parent().remove();
    }
    </script>

</body>

</html>