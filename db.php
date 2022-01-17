<?php

class database {
	
	private $host 		= 'localhost';
    private $dbname 	= 'umi9956';
    private $username 	= 'umi777';
    private $password 	= '13579XyZ';
    private $charset 	= 'utf8';
	private $mysqli;
	
	function __construct () {

		$this->mysqli = @new PDO('mysql:host='.$this->host.';dbname='.$this->dbname,$this->username,$this->password);

	}

	function person_card ($person_id) {

		$dbh = $this->mysqli;
		$sql = $dbh->prepare('SELECT * FROM `oneway_person_card` WHERE `ID`=?');
        $sql->execute(array($person_id));
		$res = $sql->fetchAll(PDO::FETCH_ASSOC);
		print_r(empty($res));
	return isset($res[0]) ? $res[0] : 1;

	}
	
	function person_slider ($person_id) {

		$dbh = $this->mysqli;
		$sql = $dbh->prepare('SELECT * FROM `oneway_person_slider` WHERE `person_id`=?');
        $sql->execute(array($person_id));
		$res = $sql->fetchAll(PDO::FETCH_ASSOC);
	
	return $res;;
	}

	function person_slider_likes ($person_id) {

		$dbh = $this->mysqli;
/* 		$sql = $dbh->prepare('	SELECT `slider_id`,`slider_like`, COUNT(*)
								FROM `oneway_person_slider_like` 
								WHERE `slider_id` IN(SELECT `ID` FROM `oneway_person_slider` WHERE `person_id`=?) AND `slider_like`=true 
								GROUP BY `slider_id`'); */

		$sql = $dbh->prepare('
			SELECT 
				`slider_id`, COUNT(`slider_like`) AS `count_like`
			FROM 
				`oneway_person_slider`
				LEFT JOIN `oneway_person_slider_like` ON oneway_person_slider.ID = oneway_person_slider_like.slider_id
			WHERE `person_id` = ? AND `slider_like`=true
			GROUP BY `slider_id`
			ORDER BY `slider_id`
			');
//		var_dump($sql);
		$sql->execute(array($person_id));
//		var_dump($sql->rowCount());
		
		$tres = $sql->fetchAll(PDO::FETCH_KEY_PAIR);
			foreach ($tres as $v){
			//$res[$v["slider_id"]] = $v["count_like"];
		}
		
	return $tres;
	}
	
	function person_slider_liked ($person_id) {
	
		$dbh = $this->mysqli;
/* 		$sql = $dbh->prepare('
			SELECT 
				`slider_like` 
			FROM 
				`oneway_person_slider_like` 
			WHERE 
				`slider_id` = ? 
				AND `ip_adress` = ?
			'); */
		$sql = $dbh->prepare('
			SELECT 
				`slider_id`, 
				`slider_like` 
			FROM 
				`oneway_person_slider_like`
				LEFT JOIN `oneway_person_slider` ON oneway_person_slider.ID = oneway_person_slider_like.slider_id
			WHERE
				`person_id` = ?
				AND
				`ip_adress` = ?
			');
		$sql->execute(array($person_id,$_SERVER['REMOTE_ADDR']));
		$res = $sql->fetchAll(PDO::FETCH_KEY_PAIR);
		//echo "person_slider_liked \n"; var_dump($res);
	
	return $res;
	}

	function person_slider_like ($slide_id, $ip_adress) {
		//echo ("<script>console.log(".$slide_id."-".$ip_adress.")</script>");
		$dbh = $this->mysqli;
		$sql = $dbh->prepare('UPDATE `oneway_person_slider_like` SET `slider_like` = 1 WHERE `oneway_person_slider_like`.`slider_id` = ? AND `oneway_person_slider_like`.`ip_adress` = ?;');
		$sql->bindValue(1,$slide_id,PDO::PARAM_INT);
		$sql->bindValue(2,$ip_adress,PDO::PARAM_STR);
		if ($sql->execute()){
			$rowCount=$sql->rowCount();
			var_dump ($rowCount);
			if ($rowCount==0) {
			$sql = $dbh->prepare('INSERT INTO `oneway_person_slider_like` VALUE (NULL, ? , ? , 1)');
			$sql->bindValue(1,$slide_id,PDO::PARAM_INT);
			$sql->bindValue(2,$ip_adress,PDO::PARAM_STR);
			//echo ("<script>console.log('false')</script>");
			$sql->execute();
			}
			//var_dump ($sql->rowCount());
		};
		$sql = $dbh->prepare('	SELECT `slider_id`,`slider_like`, COUNT(*)
								FROM `oneway_person_slider_like` 
								WHERE `slider_id`=? AND `slider_like`=true 
								GROUP BY `slider_id`');
		$sql->execute(array($slide_id));
		$res = $sql->fetchAll(PDO::FETCH_CLASS);

	
	return $res[0]->slider_like;;
	}

	function person_slider_dislike ($slide_id, $ip_adress) {
	
		$dbh = $this->mysqli;
		$sql = $dbh->prepare('UPDATE `oneway_person_slider_like` SET `slider_like` = 1 WHERE `oneway_person_slider_like`.`slider_id` = ? AND `oneway_person_slider_like`.`ip_adress` = ?;');
		$sql->execute(array($slide_id,$ip_adress));
		$sql = $dbh->prepare('	SELECT `slider_id`,`slider_like`, COUNT(*)
								FROM `oneway_person_slider_like` 
								WHERE `slider_id`=? AND `slider_like`=true 
								GROUP BY `slider_id`');
		$sql->execute(array($slide_id));
		$res = $sql->fetchAll();
		
	return json_encode($res[0]);
	}
	
	function test($slide_id, $ip_adress) {

		$dbh = $this->mysqli;
		$sql = $dbh->prepare('	SELECT *
								FROM `oneway_person_slider_like` 
								WHERE `slider_id`=? AND `ip_adress`=? 
							');
		$sql->execute(array($slide_id,$ip_adress));
		$res = $sql->fetch(PDO::FETCH_ASSOC);
		if (empty($res)) {
			$sql = $dbh->prepare('INSERT INTO `oneway_person_slider_like`(slider_id,ip_adress,slider_like) 
			VALUE (? , ? , 1)');
			$sql->execute(array($slide_id,$ip_adress));
			$sql = $dbh->prepare('	SELECT *
									FROM `oneway_person_slider_like` 
									WHERE `slider_id`=? AND `ip_adress`=? 
								');
			$sql->execute(array($slide_id,$ip_adress));
			$res = $sql->fetch(PDO::FETCH_ASSOC);
			$sql = $dbh->prepare('	SELECT COUNT(*) AS `like_count`
								FROM `oneway_person_slider_like` 
								WHERE `slider_id`=? AND `slider_like`=true 
								');
			$sql->execute(array($slide_id));
			$res += $sql->fetch(PDO::FETCH_ASSOC);
			
		}else{
			$sql = $dbh->prepare('UPDATE `oneway_person_slider_like` SET `slider_like` = ? WHERE `oneway_person_slider_like`.`slider_id` = ? AND `oneway_person_slider_like`.`ip_adress` = ?;');
			$res = $sql->execute(array(!$res["slider_like"],$slide_id,$ip_adress));
			//$res = $sql->fetch(PDO::FETCH_ASSOC);
			$sql = $dbh->prepare('	SELECT *
									FROM `oneway_person_slider_like` 
									WHERE `slider_id`=? AND `ip_adress`=? 
								');
			$sql->execute(array($slide_id,$ip_adress));
			$res = $sql->fetch(PDO::FETCH_ASSOC);
			$sql = $dbh->prepare('	SELECT COUNT(*) AS `like_count`
								FROM `oneway_person_slider_like` 
								WHERE `slider_id`=? AND `slider_like`=true 
								');
			$sql->execute(array($slide_id));
			$res += $sql->fetch(PDO::FETCH_ASSOC);
		}

	return($res);
	// Type your code here

	}
	
}
