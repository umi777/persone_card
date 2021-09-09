<?php

class database {
	
	private $host 		= 'localhost';
    private $dbname 	= 'umi9956';
    private $username 	= 'umi777';
    private $password 	= '000000Az';
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
		
	return $res[0];

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
		$sql = $dbh->prepare('	SELECT `slider_id`,`slider_like`, COUNT(*)
								FROM `oneway_person_slider_like` 
								WHERE `slider_id` IN(SELECT `ID` FROM `oneway_person_slider` WHERE `person_id`=?) AND `slider_like`=true 
								GROUP BY `slider_id`');
//		var_dump($sql);
		$sql->execute(array($person_id));
//		var_dump($sql->rowCount());
		
		$tres = $sql->fetchAll(PDO::FETCH_ASSOC);
			foreach ($tres as $v){
			$res[$v["slider_id"]] = $v["COUNT(*)"];
		}
		
	return $res;
	}
	
	function person_slider_liked ($slide_id) {
	
		$dbh = $this->mysqli;
		$sql = $dbh->prepare('SELECT `slider_like` FROM `oneway_person_slider_like` WHERE `oneway_person_slider_like`.`slider_id` = ? AND `oneway_person_slider_like`.`ip_adress` = ?');
		$sql->execute(array($slide_id,$_SERVER['REMOTE_ADDR']));
		$res = $sql->fetchAll(PDO::FETCH_CLASS);
		//var_dump($res);
	
	return $res[0]->slider_like;
	}

	function person_slider_like ($slide_id, $ip_adress) {
	
		$dbh = $this->mysqli;
		$sql = $dbh->prepare('UPDATE `oneway_person_slider_like` SET `slider_like` = 1 WHERE `oneway_person_slider_like`.`slider_id` = ? AND `oneway_person_slider_like`.`ip_adress` = ?;');
		$sql->execute(array($slide_id,$ip_adress));
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
		$sql = $dbh->prepare('UPDATE `oneway_person_slider_like` SET `slider_like` = 0 WHERE `oneway_person_slider_like`.`slider_id` = ? AND `oneway_person_slider_like`.`ip_adress` = ?;');
		$sql->execute(array($slide_id,$ip_adress));
		
		
	return $res;
	}
	
}
