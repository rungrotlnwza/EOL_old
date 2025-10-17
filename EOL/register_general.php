<?php
session_start();
include('../config/connection.php');
date_default_timezone_set('Asia/Bangkok');
$select_a = NULL;
$select_b = NULL;  
if ($_SESSION["fname"] != '' && $_SESSION["lname"] != '')
{
echo "<script type=\"text/javascript\">
	        window.location=\"general.php\";
	  </script>";
exit();
}
if($_GET['action'] === 'add'){
	if (!$_POST['fname']) {
    	$error['fname'] = "Please Insert First Name"; }
	if (!$_POST['lname']) {
    	$error['lname'] = "Please Insert Last Name"; }
	if (!$_POST['gender']){	
		$error['gender'] = "Please Select Gender"; }
	if (!$_POST['datebirth']){
		$error['datebirth'] = "Please Insert Date of Birth ";	}
	if($_POST['datebirth'])
	{	
		$arr = explode("-",$_POST['datebirth']);	
		if(count($arr)==3)
		{	
			$birth_pass = checkdate($arr[1],$arr[2],$arr[0]);
			if($birth_pass==false)
			{
				$error['datebirth'] = "Date of Birth is incorrect";	
			}
		}
		else
		{
			$error['datebirth'] = "Date of Birth is incorrect";	
		}
	}
	if(!$_POST['education_a'] || $_POST['education_a']==0)
	{	$error['education_a'] = "Please Select Education Level";	}
	if(!$_POST['email']){	$error['email'] = "Please Insert Email";	}
	if(!filter_var($_POST['email'] ,FILTER_VALIDATE_EMAIL)){$error['email'] = "Email is incorrect";	}
	if(!$error)
	{
		//---------------------------------------------//
        $fname = $conn->real_escape_string(trim($_POST["fname"]));
        $lname = $conn->real_escape_string(trim($_POST["lname"]));
        if ($fname == '' && $lname == '') {
            echo "<script type=\"text/javascript\">
                        alert('An error occurred during registration. Please register again.');
                        window.location=\"register_general.php\";
                  </script>";
            exit();
        }
        $gender = $_POST["gender"] ? $_POST["gender"] : '0';
        $birthday = $_POST["datebirth"] ? $_POST["datebirth"] : '0000-00-00';
        $education_level = $_POST['education_a'] ? $_POST['education_a'] : '0';
        $address = $_POST['address'] ? $_POST['address'] : '';
        $email = $conn->real_escape_string(trim($_POST["email"]));
        $tel = $conn->real_escape_string(trim($_POST["tel"]));
        $create_date = date("Y-m-d H:i:s");
        $strSQL = "UPDATE tbl_x_member_general SET fname = ?, lname = ?, gender = ?, education_level = ?, birthday = ?, address = ?, email = ?, tel = ?, create_date = ? WHERE member_id = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("ssssssssss", $fname, $lname, $gender,  $education_level, $birthday, $address, $email, $tel, $create_date, $_SESSION['y_member_id']);
        $stmt->execute();
        $stmt->close();
        mysqli_close($conn);
        
		echo "<script type=\"text/javascript\">
		         alert('Successfully registered into the system.');
	             window.location=\"general.php\";
             </script>";
        exit();
	}
	//---------------------------------------------//	
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register GEPOT</title>
    <link rel="stylesheet" type="text/css" href="../calendar/epoch_styles.css" />

    <style type="text/css">
    body {
        background-color: #f09731;
    }

    .hi {
        width: 200px;
        border: solid 1px #666;
        z-index: 100;
    }

    .hi16 {
        border: solid 1px #666;
        width: 319px;
    }

    .wi {
        border: solid 1px #666;
        height: 26px;
    }

    .hi:hover,
    .h16:hover.textarea:hover {
        -moz-box-shadow: 0px 0px 3px #f09721;
        -webkit-box-shadow: 0px 2px 3px #f09721;
        box-shadow: 0px 0px 3px #f09721;
        border: solid 1px #f09731;
    }

    #apDiv3 {
        position: absolute;
        left: 50%;
        width: 980px;
        margin-left: -486px;
    }

    a:link {
        color: #FFFF99;
        text-decoration: none;
    }

    a:visited {
        color: #FFFF99;
        text-decoration: none;
    }

    a:hover {
        color: #FFFF00;
        text-decoration: none;
    }

    a:active {
        text-decoration: none;
    }

    #Divform {
        position: absolute;
        float: none;
        left: 50%;
        margin-left: -310px;
        top: 1050px;
        width: 620px;
        height: 550px;
    }

    table.register td:first-child {
        font-family: Arial, Helvetica, sans-serif;
        width: 120px;
        font-weight: bold;
        color: #666;
    }

    input:focus {
        border: solid 1px #FF681C;
    }

    .btnregister {
        border: 1px solid #333;
        cursor: pointer;
        margin-right: 20px;
        width: 120px;
        color: #ffffff;
        font-weight: bold;
        height: 28px;
        background: #666;
    }

    #btnregister,
    input[disabled=false] {
        background: #0000008f;
        color: #ccc;
        cursor: not-allowed;
    }

    .btnregister:hover {
        background: #999;
    }
    </style>

</head>

<body>
    <div id="apDiv3"><img src="../images/image2/register/RegisterGEPOT.webp" width="980" height="1600" /></div>
    <div id='Divform'>
        <center>
            <font color=red size=3>โปรดกรอกข้อมูลลงในช่องที่มีเครื่องหมาย (*) ให้ครบถ้วน และถูกต้อง </font>
        </center><br>
        <table border='0' width='90%' class='register'>
            <form id='register_form' name='register_form' method='post' enctype="multipart/form-data"
                action='register_general.php?action=add'>
                <tr>
                    <td>
                        <font color='red' size='2'>*</font>First Name
                    </td>
                    <td><input type="text" name="fname" class="hi wi" value='<?=$_POST['fname']?>' required /></td>
                </tr>
                <tr>
                    <td>
                        <font color='red' size='2'>*</font>Last Name
                    </td>
                    <td><input type="text" name="lname" class="hi wi" value='<?=$_POST['lname']?>' required /></td>
                </tr>
                <?
                    if($_POST['gender']==1){$select_a = "checked";}else{$select_b = "";}
                    if($_POST['gender']==2){$select_b = "checked";}else{$select_a = "";}
                ?>
                <tr></tr>
                <tr>
                    <td>
                        <font color='red' size='2'>*</font>Gender
                    </td>
                    <td><input type="radio" name="gender" value="1" <?=$select_a?> />Male <input type="radio"
                            name="gender" value="2" <?=$select_b?> />Female</td>
                </tr>
                <tr></tr>
                <tr>
                    <td>
                        <font color='red' size='2'>*</font>Date of Birth
                    </td>
                    <td><input type="text" name="datebirth" id="datebirth" class="hi wi"
                            value='<?=$_POST['datebirth']?>' />
                        <font color=red size=2 style="margin-left:10px;">Ex 2012-01-31</font>
                    </td>
                </tr>
                <?
                    if($_POST['education_a']==1){	$check[1] = "selected";	}
					if($_POST['education_a']==2){	$check[2] = "selected";	}
					if($_POST['education_a']==3){	$check[3] = "selected";	}
					if($_POST['education_a']==4){	$check[4] = "selected";	}
					if($_POST['education_a']==5){	$check[5] = "selected";	}
					if($_POST['education_a']==6){	$check[6] = "selected";	}
					if($_POST['education_a']==7){	$check[7] = "selected";	}
                ?>
                <tr>
                    <td>
                        <font color='red' size='2'>*</font>Education
                    </td>
                    <td><select name="education_a" size="1" id="education_a" class="hi wi" style="width: 205px;">
                            <option value=''>- Select your education Level -</option>
                            <option value='1' <?=$check[1]?>>ระดับประถมศึกษาตอนต้น</option>
                            <option value='2' <?=$check[2]?>>ระดับประถมศึกษาตอนปลาย</option>
                            <option value='3' <?=$check[3]?>>ระดับมัธยมศึกษาตอนต้น</option>
                            <option value='4' <?=$check[4]?>>ระดับมัธยมศึกษาตอนปลาย</option>
                            <option value='5' <?=$check[5]?>>ระดับอุดมศึกษา</option>
                            <option value='6' <?=$check[6]?>>ระดับปริญญาตรี</option>
                            <option value='7' <?=$check[7]?>>อื่นๆ</option>
                        </select></td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td><span id="sprytextarea1">
                            <textarea name="address" cols="41" rows="7"></textarea>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <font color=red size=2>*</font>E-mail
                    </td>
                    <td><input type="text" name="email" class="hi16 wi" value='<?=$_POST['email']?>' required /></td>
                </tr>
                <tr>
                    <td>Tel</td>
                    <td><input type="text" name="tel" class="hi wi" value='<?=$_POST['tel']?>' /><br></td>
                </tr>
                <tr></tr>
                <tr>
                    <td></td>
                    <td><input type='checkbox' id='notice' onclick="javascript:
			var notice_chk = document.getElementById('notice').checked;
			if (notice_chk == false){
				document.getElementById('btnregister').disabled = true;
                document.getElementById('btnregister').style.background = '';
                document.getElementById('btnregister').style.color = '#ccc';
                document.getElementById('btnregister').style.cursor = 'not-allowed';
			}else{
				document.getElementById('btnregister').disabled = false;
                document.getElementById('btnregister').style.background = '#008000f0';
                document.getElementById('btnregister').style.color = '#fff';
                document.getElementById('btnregister').style.cursor = 'pointer';
			}
			">
                        <font color=red size=2>ข้าพเจ้ายอมรับเงื่อนไขในการใช้ระบบ (I accept the terms of use)</font>
                    </td>
                </tr>
                <tr></tr>
                <tr>
                    <td></td>
                    <td><input type="submit" id="btnregister" value="   Register   " disabled class='btnregister' />
                        <input type="button" name="button2" id="button2" value="   Back to Main   " class='btnregister'
                            onclick="javascript:window.location='../inc/logout.php';" />
                    </td>
                </tr>
                <div id="errortext">
                    <?php
    if($error['fname'])       {	$txt= $error['fname'].'\n';	}
	if($error['lname'])       {	$txt.=$error['lname'].'\n';	}
	if($error['gender'])	  {	$txt.= $error['gender'].'\n';	}
	if($error['datebirth'])   {	$txt.= $error['datebirth'].'\n';	}
	if($error['education_a']) {	$txt.= $error['education_a'].'\n';	}
	if($error['email'])       {	$txt.= $error['email'].'\n';	}
	
	
	if($error)
	{
	  echo  "<script  type=\"text/javascript\">
			    alert('".$txt."');
		    </script>";
	}
 ?>
                </div>
            </form>
        </table>
    </div>

    <script type="text/javascript" src="../calendar/epoch_classes.js"></script>
    <script type="text/javascript">
    var birth;
    window.onload = function() {
        birth = new Epoch('epoch_popup', 'popup', document.getElementById('datebirth'));
        MM_preloadImages();
    };

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
    </script>

</body>

</html>