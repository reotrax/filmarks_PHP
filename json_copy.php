<?php
require_once('config.php');
require_once('functions.php');

mb_language("uni");
mb_internal_encoding("utf-8"); //内部文字コードを変更
mb_http_input("auto");
mb_http_output("utf-8");


if (isset($_POST['read'])) {
	$post = htmlspecialchars($_POST['read']);

		// ---- ユーザーレビュー
		$dbh = connectDb();
		$sth1 = $dbh->prepare("SELECT * FROM filmarks ORDER BY review_date DESC LIMIT $post, 1");
		$sth1->execute();

		$userData = array();

		while($row = $sth1->fetch(PDO::FETCH_ASSOC)){
    		$userData[]=array(
    		'c_fav'		=>$row['c_fav'],
    		'fav'		=>$row['fav'],
    		'watch'		=>$row['watch'],
    		'want'		=>$row['want'],
    		'title_no'	=>$row['title_no'],
    		'user_no'	=>$row['user_no'],
    		'user_name'	=>$row['user_name'],
    		'user_img'	=>$row['user_img'],
    		'title'		=>$row['title'],
    		'title_img'	=>$row['title_img'],
    		'comment'	=>$row['comment'],
    		'review_date'=>$row['review_date'],
    		'rating'	=>$row['rating']
    		);
		}
		header('Content-Type/json: application/json');
		echo "{filmarks: ".json_encode($userData)."}";

} elseif (isset($_POST['list'])) {

	// ---- ユーザー登録映画の取得
	$post = htmlspecialchars($_POST['list']);

		$sql = '
		SELECT
		title 		AS title,
		title_origin AS title_origin,
		title_no 	AS title_no,
		year 		AS year,
		country 	AS country,
		duration 	AS duration,
		director 	AS director,
		writter 	AS writter,
		cast 		AS cast
		FROM movie LIMIT $post, 3
		';
		header('Content-Type/json: application/json');
		echo "{filmarks: ".json_encode(connectDb()->query($sql)->fetchAll(PDO::FETCH_ASSOC))."}";

} elseif (isset($_POST['grid3'])) {
	$post = htmlspecialchars($_POST['grid3']);
	$number = 3;
	getSql($post,$number);

} elseif (isset($_POST['grid4'])) {
	$post = htmlspecialchars($_POST['grid4']);
	$number = 4;
	getSql($post,$number);

} elseif (isset($_POST['grid5'])) {
	$post = htmlspecialchars($_POST['grid5']);
	$number = 5;
	getSql($post,$number);

} elseif (isset($_POST['info'])) {

	// ---- 映画情報の取得
	$post = htmlspecialchars($_POST['info']);
	getMovieInfo($post);
	// getSql(0,2);

} else {
	$post = 'error';
}

?>