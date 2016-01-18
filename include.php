<?php


//error_reporting(E_ALL);
//ini_set("display_errors", 1);

$db = new SQLite3(realpath(dirname(__FILE__)).'/db/WAFyy.sqlite3');
$value_limit = intval(wheelValue('value_limit'));
$special = wheelValue('special_char');
$collect_headers = wheelValue('collect_headers');
$collect_params = wheelValue('collect_params');

// errors syntax from database

	$error = array('letters' => wheelValue('letters_violation'), 'numbers' => wheelValue('numbers_violation'), 'length' => wheelValue('length_violation'), 'special' => wheelValue('special_violation'));

$req = $_REQUEST; 
$headers = apache_request_headers();


		function wheelValue($wheelnick)
		{

			global $db;
			$stmt = $db->prepare("SELECT value FROM cogwheel WHERE nick = ?");
			$stmt->bindValue(1, $wheelnick,SQLITE3_TEXT);	
			$row = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
			if($row){
				return $row['value'];
			}else{
				return 0;
			}

		}


		function valueExist($name,$value)
		{

			global $db;
			$stmt = $db->prepare("SELECT name,value FROM unconfigured_params WHERE name = ? AND value = ?");
			$stmt->bindValue(1, $name,SQLITE3_TEXT);	
			$stmt->bindValue(2, $value,SQLITE3_BLOB);
			if($stmt->execute()->fetchArray(SQLITE3_ASSOC)){
				return 1;
			}else{
				return 0;
			}

		}



		function checkFilter($name,$value)
		{

			global $db;
			global $special;
			global $error;

			$stmt = $db->prepare("SELECT * FROM configured_params_filtering WHERE name = ?");
			$stmt->bindValue(1, $name,SQLITE3_TEXT);	
			$res = $stmt->execute();
			
			if($row = $res->fetchArray(SQLITE3_ASSOC)){

				if($row['cont_letters'] != 1 && ContainsAlpha($value)) kill($error['letters'],$name);
				if($row['cont_numbers'] != 1 && ContainsNumbers($value)) kill($error['numbers'],$name);
				if($row['length'] < strlen($value)) kill($error['length'],$name,$name);
				
				if(ContainsSpecial($value))
				{
					if($row['cont_special_all'])
					{
						$chars = str_split(preg_replace('/[a-z0-9]/i','', $value));
						foreach ($chars as $char) {
							if(!strpbrk($special, $char)) kill($error['special'],$name);
						}
						
					}

					elseif($row['cont_special_history'])
					{
						$history = implode('',json_decode($row['special_chars']));
						$chars = str_split(preg_replace('/[a-z0-9]/i','', $value));
						foreach ($chars as $char) {
							if(!strpbrk($history, $char)) kill($error['special'],$name);
						}

					}else kill($error['special'],$name);
				}

			}
			else
			{ 
				regexCompare($name, $value);
				return false;
			}

		}

		function kill($msg,$param_name)
		{
			header('HTTP/1.0 777 FILTER VIOLATION');
			header('content-type: application/json; charset=utf-8');

			die($msg.' : '.$param_name);
		}

		function ContainsSpecial($value)
		{
			if(preg_replace('/[a-z0-9]/i','', $value)){return true;}
			return false;
		}

		function ContainsNumbers($value)
		{
			if(preg_match('/[0-9]/', $value)){return true;}
			return false;
		}

		
		function ContainsAlpha($value)
		{

			if(preg_match('/[A-Za-z]/', $value)){return true;}
			return false;
		}


		function deleteParam($name,$id)
		{

			global $db;
			$stmt = $db->prepare("DELETE FROM unconfigured_params WHERE name = ? AND id = ?");
			$stmt->bindValue(1, $name,SQLITE3_TEXT);	
			$stmt->bindValue(2, $id,SQLITE3_INTEGER);	
			$result = $stmt->execute();

		}


		function enforceLimit($parameter_name)
		{

			global $db;
			global $value_limit;
			$stmt = $db->prepare("SELECT id FROM unconfigured_params WHERE name = ? ORDER BY id DESC");
			$stmt->bindValue(1, $parameter_name,SQLITE3_TEXT);	
			$res = $stmt->execute();
			$rows = 0;
				while ($row = $res->fetchArray(SQLITE3_ASSOC))
				{
					if($rows>=$value_limit)
					{
						deleteParam($parameter_name,$row["id"]);		
					}
					$rows++;
				}
			return $rows;
		}

		function setNew($name,$value,$isheader)
		{

			global $db;
			if(!valueExist($name,$value)){
				$stmt = $db->prepare("INSERT INTO unconfigured_params (name, value, headers) VALUES (?, ?, ?)");
				$stmt->bindValue(1, $name,SQLITE3_TEXT);	
				$stmt->bindValue(2, $value,SQLITE3_BLOB);
				$stmt->bindValue(3, $isheader,SQLITE3_INTEGER);
				$stmt->execute();
				enforceLimit($name);
			}
		}


		function regexCompare($name, $value)
		{
			global $db;
			$stmt = $db->prepare("SELECT rowid, * FROM regex");
			$res = 	$stmt->execute();

				while ($row = $res->fetchArray(SQLITE3_ASSOC))
				{
					if(stristr($value,$row["regex_value"])) newRegexViolation($name .' => '. $value . ' (trigger: ' . $row["regex_value"] . ')');
				}

		}

		function newRegexViolation($value)
		{

			global $db;
			if(isset($value)){
				$stmt = $db->prepare("INSERT INTO regex_console (lines) VALUES (?)");
				$stmt->bindValue(1, $value,SQLITE3_TEXT);	
				$stmt->execute();
			}
		}


			global $collect_headers; // collect new headers ?
			global $collect_params; // collect new parameters ?

		foreach($req as $name => $value)
		{
			if(!checkFilter($name,$value) && $collect_params == 1) setNew($name,$value,false);
		}

		foreach($headers as $name => $value)
		{
			if(!checkFilter($name,$value) && $collect_headers == 1) setNew($name,$value,true);
		}


$db->close();

?>
