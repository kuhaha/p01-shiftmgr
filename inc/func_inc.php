<?php

function changeMonth($url, $y, $m){
	// previous month
	$y1 = ($m==1)  ? $y-1 : $y;
	$m1 = ($m==1)  ? 12 : $m - 1;
	$d1 = $y1 . $m1;
	// next month
	$y2 = ($m==12) ? $y+1 : $y;
	$m2 = ($m==12) ? 1  : $m + 1;
	$d2 = $y2 . $m2;

	echo "<h1>{$y}年{$m}月</h1>";
	echo '<div>';
	echo '<a href="'. $url.'?ym='.$d1.'">&lt;&lt;先月&gt;&gt;</a>';
	echo '<a href="'. $url.'">&lt;&lt;今月&gt;&gt;</a>';
	echo '<a href="'. $url.'?ym='.$d2.'">&lt;&lt;来月&gt;&gt;</a>';
	echo '</div>';
}
function printMonth($y, $m) {

	$wn_jp = array("日", "月", "火", "水", "木", "金", "土");
	$wn_en = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
	$wn = $wn_jp;
	$d = days($y, $m);
	$w = wday($y, $m, 1);

	echo '<tr>';
	echo td("日", array("rowspan"=>2));
	$t = $w;
	for ($i = 1; $i <= $d; $i++) {
		$attr = attr($t);
		echo td( $i, $attr);
		$t = ($t+1) % 7;
	}
	echo '</tr>';
	echo '<tr>';
	$t = $w;
	for ($i = 1; $i <= $d; $i++) {
		$attr = attr($t);
		echo td( $wn[$t], $attr);
		$t=($t+1) % 7;
	}
	echo '</tr>';

}


function getMonth($y, $m) {

	$wn_jp = array("日", "月", "火", "水", "木", "金", "土");
	$wn_en = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
	$wn = $wn_jp;

	$d = days($y, $m);
	$w = wday($y, $m, 1);

	$result = array();
	$t = $w;
	for ($i = 1; $i <= $d; $i++) {
		$attr = attr($t);
		$result[$i] = td( $i, $attr) . td( $wn[$t], $attr);
		$t = ($t+1) % 7;
	}
	return $result;
}
/*
 * attr(): return week (number) of a day $t: 0--6 の曜日の数字
 */
function attr($t){
	$attr = array();
	if ($t == 0){
		$attr["class"] = "bg-danger";
	}else if($t==6){
		$attr["class"] = "bg-success";
	}
	return $attr;
}

/*
 * days(): return days (number) of a month
 */
function days($y,$m){
	$time = mktime(0, 0, 0, $m, 1, $y);
	return date('t', $time);
}

/*
 * wday(): return week (0,1,..,6) of a day
 */
function wday($y,$m,$d){
	$time = mktime(0, 0, 0, $m, $d, $y);
	return  date('w', $time);
}


function td($str,$attr=array()){
	return tag("td", $str, $attr);
}
function th($str,$attr=array()){
	return tag("th", $str,$attr);
}
function tag($name, $str,$attr=array()){
	$tag = '<' . $name ;
	foreach ($attr as $a=>$v){
		$tag .= ' ' . $a . '=' . q2($v);
	}
	$tag .= '>' . $str . '</' . $name . '>';
	return $tag;
}
function q1($s){
	return "'" . $s . "'";
}

function q2($s){
	return '"' . $s . '"';
}