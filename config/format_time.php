<?php

		$thai["day"]["1"] = "วันจันทร์";

		$thai["day"]["2"] = "วันอังคาร";

		$thai["day"]["3"] = "วันพุธ";

		$thai["day"]["4"] = "วันพฤหัส";

		$thai["day"]["5"] = "วันศุกร์";

		$thai["day"]["6"] = "วันเสาร์";

		$thai["day"]["7"] = "วันอาทิตย์";

		$thai["month"]["1"] = "มกราคม";

		$thai["month"]["2"] = "กุมภาพันธ์";

		$thai["month"]["3"] = "มีนาคม";

		$thai["month"]["4"] = "เมษายน";

		$thai["month"]["5"] = "พฤษภาคม";

		$thai["month"]["6"] = "มิถุนายน";

		$thai["month"]["7"] = "กรกฏาคม";

		$thai["month"]["8"] = "สิงหาคม";

		$thai["month"]["9"] = "กันยายน";

		$thai["month"]["10"] = "ตุลาคม";

		$thai["month"]["11"] = "พฤศจิกายน";

		$thai["month"]["12"] = "ธันวาคม";

		// //-------------------------------------- PNG Display Script ------------------------------------------------------//
		function get_month($num){
			switch ($num) {
				case 1:
					$month = "มกราคม";
					break;
				case 2:
					$month = "กุมภาพันธ์";
					break;
				case 3:
					$month = "มีนาคม";
					break;
				case 4:
					$month = "เมษายน";
					break;
				case 5:
					$month = "พฤษภาคม";
					break;
				case 6:
					$month = "มิถุนายน";
					break;
				case 7:
					$month = "กรกฏาคม";
					break;
				case 8:
					$month = "สิงหาคม";
					break;
				case 9:
					$month = "กันยายน";
					break;
				case 10:
					$month = "ตุลาคม";
					break;
				case 11:
					$month = "พฤศจิกายน";
					break;
				case 12:
					$month = "ธันวาคม";
					break;
			}
			return $month;
		}

		function get_thai_year($date)
		{

			global $thai;

			$array_date = explode("-",$date);

			$year = $array_date[0] + 543 ;

			return $year;

		}

		function get_thai_month($date)
		{

			global $thai;

			$array_date = explode("-",$date);

			$num = $array_date[1] + 0;

			$month = get_month($num);

			return $month;

		}

		function get_thai_day($date)
		{

			global $thai;

			$array_date = explode("-",$date);

			$day = $array_date[2] + 0 ;

			return $day;

		}

		function date_dif($date_in,$date_out)
		{

			$format = "-";

			$array_date_in = explode($format,$date_in);

			$array_date_out = explode($format,$date_out);

			$date_in = gregoriantojd($array_date_in[1], $array_date_in[2], $array_date_in[0]);

			$date_out = gregoriantojd($array_date_out[1], $array_date_out[2], $array_date_out[0]);

			$total = $date_out - $date_in;

			return $total;

		}
?>