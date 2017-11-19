<?PHP

class table {
	static public function tablecontect($tabl, $tablename) {	//display result within table function
		$str = "<div><table style='width:100%'><caption>" . $tablename . "</caption>";
		foreach($tabl as $i => $k) {	
			$str .= "<tr>";
			if ($k == $tabl[0]) {	//first line of type name
				foreach($k as $m => $n) {
					if (!is_numeric($m)) {
						$str .= "<th>$m</th>";
					}
				}
				$str .= "</tr><tr>";
			}
			foreach($k as $j => $o) {	//split data
				if (!is_numeric($j)) {
					$str .= "<td>$o</td>";
				}
			}
				$str .= "</tr>";
		}
		$str .= "</table></div>";
		return $str;	//answer question and display result
	}
}
