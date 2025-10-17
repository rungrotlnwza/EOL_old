<?php
include('../inc/header.php');
include('../inc/footer.php');
include('../inc/info_user.php');
include('../config/connection.php');
$error = array();
if ($_SESSION['x_member_id'] != '') {
    echo "<script type=\"text/javascript\">
		window.location=\"../index.php\";
	</script>";
    exit();
}
else {
    if ($_GET['action'] == 'add') {
        
        if (!$_POST['fname']) {
            $error['fname'] = "Please Insert First Name";
        }
        if (!$_POST['lname']) {
            $error['lname'] = "Please Insert Last Name";
        }
        if (!$_POST['user']) {
            $error['user'] = "Please Insert Username";
        }
        $texuser = $_POST['user'];
        if (preg_match("/^[ก-๙]+$/", $texuser)) {
            $error['user'] = "UserName กรุณากรอกเฉพาะตัวอักษร a-z, A-Z, 0-9 เท่านั้น";
        }
        if ($_POST['user'] && strlen($_POST['user']) <= 7) {
            $error['user'] = "Username must have 8-20 Characters long";
        }
        if (!$_POST['pass']) {
            $error['pass'] = "Please Insert Password";
        }
        $textpass = $_POST['pass'];
        if (preg_match("/^[ก-๙]+$/", $textpass)) {
            $error['pass'] = "Password กรุณากรอกเฉพาะตัวอักษร a-z, A-Z, 0-9 เท่านั้น";
        }
        if ($_POST['pass'] && strlen($_POST['pass']) <= 7) {
            $error['pass'] = "Password must have 8-20 Characters long";
        }
        if (!$_POST['email']) {
            $error['email'] = "Please Insert Email";
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error['email'] = "Email is incorrect";
        }
        if (!$_POST['gender']) {
            $error['gender'] = "Please Choose Gender.";
        }
        if (!$_POST['tel']) {
            $error['tel'] = "Please Insert Tel.";
        }
        if(isset($_POST['g-recaptcha-response'])){
            $captcha=$_POST['g-recaptcha-response'];
        }
        if (!$captcha) {
            $error['captcha'] = "โปรดยืนยันตัวตนของคุณ";
        }
        $secretKey = "6LfiLXUaAAAAANcB8khOlRKNkYlaUbYFHesERj3W";
        $ip = $_SERVER['REMOTE_ADDR'];
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
        $responseKey = json_decode($response,true);
        if (intval($responseKey["success"]) !== 1 ) {
            $error['reply'] = "โปรดทำการยืนยันให้ถูกต้อง";
        }
        if (!$error) {
            
            $user = $conn->real_escape_string(trim($_POST["user"]));

            // check username from tb_x_member_1year
            $SQL = "SELECT * FROM tbl_x_member_1year WHERE user = ?";
            $query = $conn->prepare($SQL);
            $query->bind_param("s", $user);
            $query->execute();
            $result = $query->get_result();
            $is_same = $result->num_rows;
            $query->close();
            
            // check username from tb_x_member
            $strSQL = "SELECT * FROM tbl_x_member WHERE user = ?";
            $sub_query = $conn->prepare($strSQL);
            $sub_query->bind_param("s",$user);
            $sub_query->execute();
            $result = $sub_query->get_result();
            $is_have = $result->num_rows; 
            $sub_query->close();
            if ($is_have != 0 || $is_same != 0) {
                $error['user'] = "This Username is already registered";
            }
            else {
               
                $pass = $conn->real_escape_string(trim($_POST["pass"]));
                $fname = $conn->real_escape_string(trim($_POST["fname"]));
                $lname = $conn->real_escape_string(trim($_POST["lname"]));
                $nickname = '';
                $gender = $_POST["gender"] ? $_POST["gender"] : '0';
                $birthday = $_POST["datebirth"] ? $_POST["datebirth"] : '0000-00-00';
                $education = '';
                $education_level = '0';
                $address = '';
                $email = $conn->real_escape_string(trim($_POST["email"]));
                $tel = $conn->real_escape_string(trim($_POST["tel"]));
                $create_date = date("Y-m-d H:i:s");

                $SQL = "SELECT * FROM tbl_x_member ORDER BY member_id DESC LIMIT 0,1";
                $query = $conn->prepare($SQL);
                $query->execute();
                $result = $query->get_result();
                $is_have = $result->num_rows; 
                if ($is_have == 1) {
                    $sub_data = $result->fetch_array();
                    $next_id = $sub_data["member_id"] + 1;
                }
                if ($is_have == 0) {
                    $next_id = 1;
                }
                $query->close();
               
                $strSQL = "INSERT INTO tbl_x_member (member_id, user, pass , fname, lname, nickname ,gender, education_level,  education, birthday, address, email, tel, create_date) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $stmt = $conn->prepare($strSQL);
                $stmt->bind_param("ssssssssssssss",$next_id, $user, $pass, $fname, $lname, $nickname, $gender,  $education_level, $education, $birthday, $address, $email, $tel, $create_date);
                $stmt->execute();
                $stmt->close();
                mysqli_close($conn);
                
                echo "<script type=\"text/javascript\">";
                echo "alert('สมัครสมาชิกสำเร็จ  Login เข้าสู่ระบบ');";
                echo "window.location=\"../index.php\";";
                echo "</script>";
                // if (isset($_SESSION['order_waiting'])) {
                //     echo "window.location=\"../shop/cart_confirm_payment.php\";";
                // }
                // else {
                //     echo "window.location=\"../index.php\";";

                // }
                // echo "</script>";
                exit();
            }
        }
        //---------------------------------------------//
        
    }
}
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
        color: #000000;
        text-decoration: none;
    }

    #sub_menu a:hover {
        color: orangered;
    }

    .title_font_color {
        color: #fb921d;
        font-weight: bold;
    }

    .text-red {
        color: red;
    }

    .title_font_menu {
        font-family: kanit;
        font-weight: bold;
        padding-bottom: 10px;
    }

    .text-center {
        text-align: center;
    }

    #form_register div.row {
        padding: 5px;
        height: 45px;
    }

    #form_register div.row.* {
        padding: 5px;
        height: 45px;
    }

    .text-right {
        text-align: right;
    }

    #chkbox_male_text,
    #chkbox_female_text,
    #check_accept_text {
        cursor: pointer;
    }
    </style>
    <link href="https://www.engtest.net/bootstrap/css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <div class="container shadow_side" style="width:1150px !important;background:#ffffff;margin-top:45px;">

        <?= callheader(); ?>
        <?php
if (!$_POST['gender']) {
    $select_a = "checked";
}
if ($_POST['gender'] == 1) {
    $select_a = "checked";
}
if ($_POST['gender'] == 2) {
    $select_b = "checked";
}

?>
        <div class="row kanit">
            <div class="col-xs-12" style="padding:0px;margin:0px;border-top:1px solid grey;">

                <div style="padding:0px 150px;border:0px solid blue;" class="taviraj">
                    <center>
                        <div id="apDiv69" class="kanit" style="padding-top:20px;">
                            <h2><strong>REGISTER</strong><br>
                                <span style="font-size:24px;color:#707070;">แบบฟอร์มสมาชิกใหม่</span>
                            </h2>
                            <hr style="width:100px;border:2px solid #f7941d" />
                        </div>
                    </center>
                    <div class="text_paragraph">
                        <center>
                            <div class="text-red text-center bold" style="font-size:14px;">Username และ Password
                                จะต้องเป็น a-z, A-Z, 0-9 ความยาว 8-20
                                ตัวอักษรเท่านั้น<BR>และต้องใส่ข้อมูลให้ครบในส่วนที่มีเครื่องหมาย *</div>
                        </center>
                        <BR>
                        <div class="row">
                            <div class="col-xs-12" id="form_register">
                                <form id='register_form' name='register_form' method=post enctype="multipart/form-data"
                                    action='register_account.php?action=add'>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="row">
                                                <div class="col-xs-4">Firstname<b class="text-red"> *</b></div>
                                                <div class="col-xs-8"><input type="text" name="fname"
                                                        class="form-control" placeholder="Firstname" required="true"
                                                        value="<?= $_POST['fname']; ?>"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-4">Lastname<b class="text-red"> *</b></div>
                                                <div class="col-xs-8"><input type="text" name="lname"
                                                        class="form-control" placeholder="Lastname" required="true"
                                                        value="<?= $_POST['lname']; ?>"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-4">Gender <b class="text-red"> *</b></div>
                                                <div class="col-xs-8"><input type="radio" name="gender" id="chkbox_male"
                                                        value="1" <?= $select_a ?> /> <span
                                                        id="chkbox_male_text">Male</span>
                                                    &emsp;&emsp;&emsp;&emsp;<input type="radio" name="gender"
                                                        id="chkbox_female" value="2" <?= $select_b; ?> /> <span
                                                        id="chkbox_female_text">Female</span></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-4">Phone<b class="text-red"> *</b></div>
                                                <div class="col-xs-8"><input type="" name="tel" class="form-control"
                                                        required="true" placeholder="Phone"
                                                        value="<?= $_POST['tel']; ?>" maxlength="15">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-xs-6">
                                            <div class="row">
                                                <div class="col-xs-4">Username<b class="text-red"> *</b></div>
                                                <div class="col-xs-8"><input type="text" name="user"
                                                        class="form-control" maxlength="20" placeholder="Username"
                                                        required="true" value="<?= $_POST['user']; ?>"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-4">Password<b class="text-red"> *</b></div>
                                                <div class="col-xs-8"><input type="password" name="pass"
                                                        class="form-control" maxlength="20" placeholder="Password"
                                                        required="true" value="<?= $_POST['pass']; ?>"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-4">Date of Birth </div>
                                                <div class="col-xs-8">
                                                    <input type="text" name="datebirth" id="datebirth"
                                                        class="form-control datepicker" data-date-format="yyyy-mm-dd"
                                                        placeholder="YYYY-MM-DD" readonly required="true"
                                                        value="<?= $_POST['datebirth']; ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-4">E-mail<b class="text-red"> *</b></div>
                                                <div class="col-xs-8"><input type="email" name="email"
                                                        class="form-control" placeholder="email@example.com"
                                                        required="true" value="<?= $_POST['email']; ?>"></div>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <BR>
                                            ข้อกำหนดในการใช้งานระบบ<BR>
                                            <textarea style="width:100%;height: 150px;font-size:14px;" readonly>        1. การทดสอบในระบบ EOL System เป็นการทดสอบออนไลน์ จัดทำโดยบริษัทอิงลิชออนไลน์ จำกัด บริษัทจึงมีข้อตกลงเบื้องต้นขึ้น เพื่อท่านสมาชิกหรือท่านที่จะขอใช้บริการ โดยหลังจากที่อ่านจบแล้วให้ท่านกดปุ่ม " ยอมรับ " เพื่อเข้าสู่ขั้นตอนกรอกแบบฟอร์มสมาชิกใหม่ ขอให้ท่านอ่านและทำความเข้าใจโดยละเอียด เพื่อรักษาสิทธิประโยชน์ในการใช้บริการของส่วนรวม และส่วนตัวท่านเอง ในขั้นตอนการกรอกแบบฟอร์มใบสมัครนั้น สมาชิกจะต้องกรอกข้อมูลต่างๆ ตามความเป็นจริง
        2. สมาชิกจะต้องซื้อผลิตภัณฑ์กับทางบริษัทฯ เพื่อเพิ่มวันใช้งานในระบบ ให้สามารถเข้าใช้งานได้ และสมาชิกจะต้องจัดหาอุปกรณ์ในการติดต่อเข้าใช้ระบบอินเตอร์เน็ต และรับผิดชอบค่าใช้จ่ายส่วนอื่นๆ ด้วยตัวเอง
        3. การกำหนดรหัสผ่าน ทางบริษัทขอสงวนสิทธิ์ไม่ให้ใช้คำเหล่านี้ได้แก่ "webmaster", "hostmaster", "admin", "administrator", "postmaster" หรือคำอื่นๆที่ระบุว่าเป็นผู้ดูแลระบบ เป็นชื่อติดต่อบริการ (username, password, login name) 
        4. ชื่อผู้ติดต่อบริการ (username) และรหัสผ่าน (password) ต้องใช้ภาษาอังกฤษเท่านั้น และจะต้องรักษา username และ password เป็นความลับ ซึ่งถ้าเกิดเหตุอันมิพึงประสงค์กับการทดสอบของท่าน บริษัทจะไม่รับผิดชอบใดๆ ทั้งสิ้น อันเนื่องมาจากการที่ท่านได้ให้ username และ password แก่บุคคลอื่นที่ไม่เกี่ยวข้อง
        5. ทางบริษัทฯ ถือว่าความเป็นส่วนตัวเป็นเรื่องที่สำคัญมากสำหรับการใช้งาน ดังนั้น บริษัทฯจะไม่เข้าไปยุ่งกับข้อมูลของท่าน นอกเหนือจากข้อกำหนดที่ได้ตกลง
        6. สมาชิกจะได้รับข่าวสารจากทางบริษัทอย่างต่อเนื่อง โดยสมาชิกติดตามข้อมูลข่าวสารได้ทางเว็บของทาง บริษัทฯ และทางจดหมายอิเล็กทรอนิคส์ (E-Mail)
        7. ห้ามใช้ข้อความที่ไม่สุภาพ หรือเป็นการหมิ่นประมาทผู้อื่นในการสื่อสาร ไม่ว่ากรณีใดๆทั้งสิ้น ทั้งนี้เพื่อสร้างวัฒนธรรมที่ดีในการใช้ระบบของบริษัทฯ
        8. บริษัทไม่ขอรับประกันความเสียหายของข้อมูลการเข้าใช้งานระบบการทดสอบออนไลน์ การใช้บริการของสมาชิก ชึ่งอาจไม่สามารถให้บริการได้ตลอด 24 ชั่วโมง เพราะเครื่องเซิร์ฟเวอร์ของหน่วยงานอาจจะเกิดการเสียหายขึ้นได้โดยอุบัติเหตุที่ไม่คาดคิด แต่อย่างไรก็ดีระบบที่บริษัทฯ เลือกมาให้บริการกับท่านเป็นระบบที่ดีและมีความปลอดภัย ซึ่งในภาวะการทำงานปกติจะไม่เกิดความเสียหายใดๆ
        9. ข้อความ ข้อสอบ ที่อยู่ในการทดสอบในระบบ EOL System ถือเป็นทรัพย์สินของบริษัทฯ ขอสงวนลิขสิทธิ์ ในข้อความ ข้อสอบ เสียง ภาพเหล่านี้ ห้ามมิให้สมาชิกนำไปเผยแพร่ ดัดแปลง แก้ไขใดๆ ทั้งสิ้น
        10. หากมีการเปลี่ยนแปลงข้อตกลงการใช้บริการ การทดสอบในระบบ EOL System ในการให้บริการของบริษัทฯ จะแจ้งให้สมาชิกทราบ โดยขึ้นที่หน้าจอ “ข้อตกลงในการใช้บริการ”
        11. หากบริษัทฯ พบว่าสมาชิกท่านใด ละเมิดข้อตกลงที่ตั้งไว้ บริษัทฯขอสงวนสิทธิ์ในการระงับการให้บริการกับ สมาชิกท่านนั้นโดยมิต้องแจ้งให้ทราบล่วงหน้า 
</textarea>
                                            <BR>
                                            <BR>
                                            <input type="checkbox" id="check_accept" name="check_accept" /><span
                                                id="check_accept_text"> &emsp;<font style="color:red;">
                                                    ข้าพเจ้ายอมรับเงื่อนไขในการใช้ระบบ (I accept the EOL terms of use)
                                                </font></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="g-recaptcha"
                                                data-sitekey="6LfiLXUaAAAAAPu12aw99mPwxrOelLbxDpuQnHjl"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 text-center">
                                            <BR>
                                            <button type="submit" id="btnregister" disabled class="btn btn-lg btn-info"
                                                style="border:0px; background:orange !important">Register</button>
                                            <BR><BR>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div id="errortext">
                                                <?php
if ($error['fname']) {
    $txt = $error['fname'] . '\n';
}
if ($error['lname']) {
    $txt .= $error['lname'] . '\n';
}
if ($error['user']) {
    $txt .= $error['user'] . '\n';
}
if ($error['pass']) {
    $txt .= $error['pass'] . '\n';
}
if ($error['email']) {
    $txt .= $error['email'] . '\n';
}
// if ($error['gender']) {
//     $txt .= $error['gender'] . '\n';
// }
if ($error['tel']) {
    $txt .= $error['tel'] . '\n';
}
if ($error['captcha']) {
    $txt .= $error['captcha']. '\n';
}
if ($error['reply']) {
    $txt .= $error['reply']. '\n';
}
if ($error) {
    echo "<script  type=\"text/javascript\">alert('" . $txt . "');</script>";
}
?>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <?php footer(); ?>

    <script type="text/javascript" src="https://www.engtest.net/bootstrap/js/bootstrap-datetimepicker.js"
        charset="UTF-8"></script>
    <script>
    $('.datepicker').datetimepicker({
        //language:  'fr',
        weekStart: 0,
        todayBtn: 0,
        autoclose: 1,
        todayHighlight: 0,
        startView: 4,
        forceParse: 0,
        showMeridian: 0,
        minView: 2,
    });

    $("#check_accept").click(function() {
        if ($(this).is(":checked")) {
            $("#btnregister").attr("disabled", false);
        } else {
            $("#btnregister").attr("disabled", true);
        }
    });

    $("#check_accept_text").click(function() {
        $("#check_accept").click();
    });

    $("#chkbox_male_text").click(function() {
        $("#chkbox_male").click();
    });

    $("#chkbox_female_text").click(function() {
        $("#chkbox_female").click();
    });
    </script>