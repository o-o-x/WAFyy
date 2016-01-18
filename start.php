<?php


	 	// error_reporting(E_ALL);
	 	// ini_set("display_errors", 1);
if(file_exists("db/WAFyy.sqlite3") && filesize("db/WAFyy.sqlite3") > 0)
{
	header("Location: index.php");
	die('Blocked after first time');
}


if(!isset($_GET['first_time_password'])){

	die('<form action="">Enter your 10 characters password for the first time and hit Enter.. <input name="first_time_password" class="form-control" autocomplete="off" id="first_time_password" placeholder="Ex: Pa$sw0rd1267" type="password"></form>');

}else{

		if(strlen($_GET['first_time_password']) < 10) die('ERROR: Password length < 10');

	 	// BCRYPT include for PHP < 5.5
		require_once 'include/bcrypt.php';

		$password = password_hash($_GET['first_time_password'], PASSWORD_DEFAULT);

		$db = new SQLite3('db/WAFyy.sqlite3');
		$db->exec("CREATE TABLE configured_params_filtering (name STRING PRIMARY KEY NOT NULL, length INTEGER, cont_letters INTEGER, cont_numbers INTEGER, cont_special_all INTEGER, cont_special_history INTEGER, time DATETIME DEFAULT CURRENT_TIMESTAMP, 'special_chars' BLOB DEFAULT NULL, 'headers' INTEGER DEFAULT NULL);");
		$db->exec("CREATE TABLE 'unconfigured_params' (name STRING,'value' BLOB, 'time'  DATETIME DEFAULT CURRENT_TIMESTAMP  , 'id'  INTEGER PRIMARY KEY NOT NULL  , 'headers' BOOLEAN DEFAULT NULL);");
		$db->exec("CREATE TABLE 'regex' ('regex_value' TEXT PRIMARY KEY NOT NULL, 'type' TEXT DEFAULT NULL);");
		$db->exec("CREATE TABLE 'regex_console' ('lines' TEXT NOT NULL, 'date'  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP);");




		// cogwheel 
		$db->exec("CREATE TABLE 'cogwheel' ('nick' TEXT PRIMARY KEY NOT NULL, 'name' TEXT, 'value' TEXT, 'date' DATETIME DEFAULT CURRENT_TIMESTAMP, 'rows' INTEGER DEFAULT 1);");

		$db->exec("INSERT INTO 'cogwheel' ('nick', 'name', 'value', 'rows') VALUES ('value_limit','Number of unique values to save per parameter', '10', '1')");
		$db->exec("INSERT INTO 'cogwheel' ('nick', 'name', 'value', 'rows') VALUES ('special_char','All special chars allowed','#$%^&*()+=-[];,./{}|:<>?~', '1')");
		$db->exec("INSERT INTO 'cogwheel' ('nick', 'name', 'value', 'rows') VALUES ('encryptedpassword','Hashed password (BCRYPT)','".$password."', '1')");
		$db->exec("INSERT INTO 'cogwheel' ('nick', 'name', 'value', 'rows') VALUES ('collect_headers','Collect new headers', '1', '1')");
		$db->exec("INSERT INTO 'cogwheel' ('nick', 'name', 'value', 'rows') VALUES ('collect_params','Collect new parameters', '1', '1')");
		$db->exec("INSERT INTO 'cogwheel' ('nick', 'name', 'value', 'rows') VALUES ('letters_violation','Filiter violation stealth error (LETTERS)', 'in·tel·li·gent barking', '1')");
		$db->exec("INSERT INTO 'cogwheel' ('nick', 'name', 'value', 'rows') VALUES ('numbers_violation','Filiter violation stealth error (NUMBERS)', 'barking num·ber of times', '1')");
		$db->exec("INSERT INTO 'cogwheel' ('nick', 'name', 'value', 'rows') VALUES ('length_violation','Filiter violation stealth error (LENGTH)', 'lo·ng barking', '1')");
		$db->exec("INSERT INTO 'cogwheel' ('nick', 'name', 'value', 'rows') VALUES ('special_violation','Filiter violation stealth error (SPECIAL-CHARS)', 'sp·cial barking', '1')");
		$db->exec("INSERT INTO 'cogwheel' ('nick', 'name', 'value', 'rows') VALUES ('notes','Notes !@#@$#^%','Write down what ever you whold like to remember.. ;}', '7')");

		header("Location: index.php");



	}


?>