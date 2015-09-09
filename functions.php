<?php
function connectDb() {
	$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',);
    try {
    	// $dbh = new PDO(DSN, DB_USER, DB_PASSWORD);
    	// $dbh->query('SET NAMES UTF-8');
     	// return $dbh;
        return new PDO(DSN, DB_USER, DB_PASSWORD, $options);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}

function getSql($post, $number) {
	$name = '\'filmarks\'';
	$sql = '
		SELECT
		user_img	AS user_img,
		user_no 	AS user_no,
		review_date AS review_date,
		rating 		AS rating,
		c_fav 		AS c_fav,
		fav 		AS fav,
		title 		AS title,
		title_no 	AS title_no,
		title_img	AS title_img
		FROM filmarks WHERE user_name='.$name.'ORDER BY review_date DESC LIMIT '.$post.', '.$number.'
		';

		header('Content-Type/json: application/json');

		// MySQLの返り値が null([]) でない場合に実行
		if (json_encode(connectDb()->query($sql)->fetchAll(PDO::FETCH_ASSOC))!='[]') {
			echo "{filmarks: ".json_encode(connectDb()->query($sql)->fetchAll(PDO::FETCH_ASSOC))."}";
		}
}

function getMovieInfo($post) {
	$post = '\''.$post.'\'';
	$sql = '
		SELECT
		title 		AS title,
		title_origin AS title_origin,
		year 		AS year,
		country 	AS country,
		duration 	AS duration,
		director 	AS director,
		writer  	AS writer,
		cast 		AS cast
		FROM movie WHERE id='.$post.' LIMIT 0, 1
		';

		header('Content-Type/json: application/json');

		// MySQLの返り値が null([]) でない場合に実行
		if (json_encode(connectDb()->query($sql)->fetchAll(PDO::FETCH_ASSOC))!='[]') {
			echo "{movie: ".json_encode(connectDb()->query($sql)->fetchAll(PDO::FETCH_ASSOC))."}";
		}
}

?>