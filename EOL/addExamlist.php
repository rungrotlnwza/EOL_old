 <?php
error_reporting(E_ALL);
session_start();
include('../config/connection.php');
function add_listExam($detail_name)
{
	$_SESSION["listId"] = $_SESSION["listId"] + 1;
	$int = $_SESSION["listId"];
	$_SESSION["inputId"][$int] = $int;
	echo '<tr>
			<td>
				<select id="skill_id' . $int . '" name="skill_id[]" style="float:left;"class="selector" onchange="changelistExam(this)" data-select="' . $int . '">
					<option value=1 > Reading Comprehension</option>
					<option value=2 > Listening Comprehension</option>
					<option value=3 > Semi - Speaking</option>
					<option value=4 > Semi - Writing</option>
					<option value=7 > Vocabulary </option>
					<option value=5 > Grammar </option>
				</select>
			</td>
			<td>
				<select id="level' . $int . '"  name="level[]" style="float:left;" class="selector" onchange="changelistExam(this)" data-select="' . $int . '">
					<option value=1 >Beginner</option>
					<option value=2 >Lower Intermediate</option>
					<option value=3 >Intermediate</option>
					<option value=4 >Upper Intermediate</option>
					<option value=5 >Advanced </option>
				</select>
                <select id="topic' . $int . '"name="topic[]" style="width:300px;margin-left:5px; margin-right:5px;" class="selector">' . $detail_name . '<option value=1 >music</option>
  				</select>จำนวน <input type="text" name="num[]"  class="txtdetail" style="width:50px;" size=3 onkeypress="checknum()" maxlength="2"/>ข้อ<button class="btnremove_exam" onclick="javascript:Removetr(this);"></button>
			</td>
   		  </tr>';
}
function select_list($skill_id, $level)
{
	include('../config/connection.php');

	$strSQL = "SELECT DETAIL_ID,DETAIL_NAME,DETAIL_CODE,SSKILL_ID FROM tbl_item_detail WHERE SKILL_ID = ? GROUP BY DETAIL_NAME ORDER BY DETAIL_ID";
	$stmt = $conn->prepare($strSQL);
	$stmt->bind_param("s", $skill_id);
	$stmt->execute();
	$resulte_detail = $stmt->get_result();
	$row = $resulte_detail->num_rows;

	while ($detail = $resulte_detail->fetch_assoc()) {

		$test_id = 1;
		$sskil_id = $detail['SSKILL_ID'];
		$detail_id = $detail['DETAIL_ID'];

		$SQL = "SELECT QUESTIONS_ID FROM tbl_questions WHERE TEST_ID = ? && LEVEL_ID = ? && SKILL_ID = ? && SSKILL_ID = ? && DETAIL_ID = ?";
		$query = $conn->prepare($SQL);
		$query->bind_param("issss", $test_id, $level, $skill_id, $sskil_id, $detail_id);
		$query->execute();
		$result = $query->get_result();
		$amout = $result->num_rows;
		$query->close();

		if ($amout > 0) {
			$text .= '<option value="' . $detail['DETAIL_ID'] . '" title="' . $detail['DETAIL_NAME'] . '">' . substr($detail['DETAIL_NAME'], 0, 48) . '[' . $amout . ']</option>';
		}
	}

	$stmt->close();
	return $text;
}

/*input from ajax */

if (isset($_POST['label'])) {
	if ($_POST['label'] == 'newlist') {
		//add new row from create exam
		add_listExam(select_list(1, 1));
	} elseif ($_POST['label'] == 'change') {
		if (isset($_POST['skill_id']) && isset($_POST['level_id'])) {
			$skill = $conn->real_escape_string(trim($_POST['skill_id']));
			$level = $conn->real_escape_string(trim($_POST['level_id']));
			echo select_list($skill, $level);

		} else {
			return false;
		}
	}
}
mysqli_close($conn);
?>