<?php
$menu0 = array(  //共通メニュー:ログイン前
 'ログイン'  => 'login.php',
);
$menu1 = array(  //一般従業員メニュー(urole = 1)
 'シフト希望'  => 'entry.php'  ,
);
$menu2 = array(  //人事担当者メニュー (urole = 8)
 '基本時給設定'  => 'basepay.php' ,
 '時給設定'  => 'pay.php' ,
);
$menu3 = array(  //店長メニュー(urole = 9)
 'スケジュール登録'  => 'holiday.php' ,
 'シフト決定'  => 'decide.php' ,
);
$menu4 = array(  //共通メニュー:ログイン後
 'ログアウト'  => 'logout.php',
);
echo '<ul class="nav navbar-nav">';
echo '<li><a href="index.php">ホーム</a></li>';
if(isset($_SESSION['urole']) ){
  $i = $_SESSION['urole'];
  $s = array(1=>'学生',8=>'人事',9=>'店長');
  echo '<li class="dropdown">';
  echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $s[$i] . 'ニュー<span class="caret"></span></a>';
  echo '<ul class="dropdown-menu">';
	if( $_SESSION['urole']==1){
		//一般従業員メニューの出力
		foreach($menu1 as $label=>$url){ //$menu1の要素を調べまわす
			echo '<li><a href="' .$url. '">' . $label . '</a></li>';
		}
	}
	if( $_SESSION['urole']==8){
		//人事担当者メニューの出力
 		foreach($menu2 as $label=>$url){ //$menu2の要素を調べまわす
			echo '<li><a href="' .$url. '">' . $label . '</a></li>';
		}
	}
	if( $_SESSION['urole']==9){
		//店長メニューの出力
		foreach($menu3 as $label=>$url){ //$menu3の要素を調べまわす
			echo '<li><a href="' .$url. '">' . $label . '</a></li>';
		}
	}
  echo '</ul>';
  echo '</li>';
	
}
echo '</ul>';
echo '<ul class="nav navbar-nav navbar-right">';
if(isset($_SESSION['urole']) ){
  echo '<li><a>' . $_SESSION['uname'] . 'さんがログイン中</a></li>';
  //共通メニューの出力
  foreach($menu4 as $label=>$url){ //$menu0の要素を調べまわす
    echo '<li><a href="' .$url. '">' . $label . '</a></li>';
  }
}else{
  echo '<li><a href="login.php">ログイン</a></li>';
}
echo '</ul>';
?>