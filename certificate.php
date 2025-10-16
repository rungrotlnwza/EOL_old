<?php
session_start();

// ตรวจสอบ session
$session = isset($_SESSION['x_member_1year']) || isset($_SESSION['x_member_id']) || isset($_SESSION['y_member_id']);
if (!$session) {
    header('Location: index.php');
    exit();
}

// เชื่อมต่อฐานข้อมูล
$conn = mysqli_connect("localhost", "engtest_online", "sTEZY1UM", "engtest_online");
$conn->set_charset("utf8mb4");
if (!$conn) {
    die("Failed to connect to database " . mysqli_error($conn));
}

// หา member_id
$member_id = '';
if (isset($_SESSION['x_member_1year'])) {
    $member_id = $_SESSION['x_member_1year'];
} elseif (isset($_SESSION['x_member_id'])) {
    $member_id = $_SESSION['x_member_id'];
} elseif (isset($_SESSION['y_member_id'])) {
    $member_id = $_SESSION['y_member_id'];
}

// กำหนด skills ที่ต้องผ่าน
$required_skills = array(1, 2, 3, 4, 5, 7);
$skill_names = array(
    1 => "Reading Comprehension",
    2 => "Listening Comprehension",
    3 => "Semi-Speaking",
    4 => "Semi-Writing",
    5 => "Grammar",
    7 => "Vocabulary",
);

$passing_score = 50;
$intermediate_level = 2;
$passed_skills = array();

foreach ($required_skills as $skill_id) {
    $strSQL = "SELECT MAX(percent) as max_score, level_id FROM tbl_w_result 
               WHERE member_id = '$member_id' AND skill_id = '$skill_id' AND percent >= $passing_score AND level_id >= $intermediate_level
               ORDER BY percent DESC LIMIT 1";
    $result = mysqli_query($conn, $strSQL);
    $data = mysqli_fetch_array($result);
    if ($data && $data['max_score'] !== null) {
        $passed_skills[] = $skill_id;
    }
    mysqli_free_result($result);
}
// Get user name
$strSQL = "SELECT fname, lname FROM tbl_x_member WHERE member_id = '$member_id'";
$result = mysqli_query($conn, $strSQL);
$user_data = mysqli_fetch_array($result);
$user_name = "";
if ($user_data) {
    $fname = isset($user_data['fname']) ? $user_data['fname'] : '';
    $lname = isset($user_data['lname']) ? $user_data['lname'] : '';
    $user_name = trim($fname . ' ' . $lname);
}
mysqli_free_result($result);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EOL Certificate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .text_certificate {
            font-size: 2rem;
            top: 200px;
            left: 50%;
            transform: translateX(-50%);
        }

        @media (max-width: 375px) {
            .text_certificate {
                top: 100px;
                font-size: 1rem;
            }
        }

        @media (min-width: 390px) {
            .text_certificate {
                top: 110px;
                font-size: 1rem;
            }
        }

        @media (min-width: 413px) {
            .text_certificate {
                top: 120px;
                font-size: 1rem;
            }
        }

        @media (min-width: 520px) {
            .text_certificate {
                top: 160px;
                font-size: 1rem;
            }
        }

        @media (min-width: 760px) {
            .text_certificate {
                top: 210px;
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row py-5">
            <div class="col-12  d-flex flex-column align-items-center justify-content-center position-relative<?php if (count($passed_skills) < count($required_skills)) echo ' d-none'; ?> mx-auto" style="max-width: 700px;">
                <div class="w-100 position-relative certificate">
                    <img src="./b827f4b6-e92a-4ec6-893a-5c01f20f9598.jpg" alt="Certificate" class="img-fluid w-100">
                    <div class="text_certificate position-absolute fw-bold mb-5 text-center" style="white-space: nowrap;">
                        <?= $fname, ' ', $lname ?>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <button id="download-pdf" class="btn btn-primary">ดาวน์โหลด Certificate</button>
            </div>
        </div>
    </div>
    <div class="alert alert-warning nopassed<?php if (count($passed_skills) == count($required_skills)) echo ' d-none'; ?>">
        <h4>คุณยังสอบผ่านทักษะที่กำหนดไม่ครบในระดับ Intermediate (Level 2) หรือสูงกว่า</h4>
        <p><strong>ทักษะที่ยังไม่ผ่าน:</strong> <?php
                                                if (count($passed_skills) < count($required_skills)) {
                                                    $missing_skills = array_diff($required_skills, $passed_skills);
                                                    $missing_names = array();
                                                    foreach ($missing_skills as $skill) {
                                                        $missing_names[] = $skill_names[$skill];
                                                    }
                                                    echo htmlspecialchars(implode(', ', $missing_names));
                                                } else {
                                                    echo '-';
                                                }
                                                ?></p>
        <p>กรุณาทำข้อสอบทุกทักษะในระดับ Intermediate ให้ครบก่อนรับใบประกาศนียบัตร</p>
        <a href="../EOL/eoltest.php?section=business" class="btn btn-primary mt-3">ไปหน้าทำข้อสอบ</a>
    </div>
    </div>
    <!-- Bootstrap 5 loaded via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <!-- html2canvas and jsPDF CDN -->
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var btn = document.getElementById('download-pdf');
            if (btn) {
                btn.addEventListener('click', function() {
                    var cert = document.querySelector('.certificate');
                    html2canvas(cert, {
                        scale: 2
                    }).then(function(canvas) {
                        var imgData = canvas.toDataURL('image/png');
                        var pdf = new window.jspdf.jsPDF({
                            orientation: 'landscape',
                            unit: 'px',
                            format: [cert.offsetWidth, cert.offsetHeight]
                        });
                        pdf.addImage(imgData, 'PNG', 0, 0, cert.offsetWidth, cert.offsetHeight);
                        pdf.save('certificate.pdf');
                    });
                });
            }
        });
    </script>
</body>

</html>