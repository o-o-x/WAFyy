<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$db = new SQLite3('/var/lib/openshift/55e445b32d5271628800001e/app-root/runtime/repo/WAFyy/db/WAFyy.sqlite3');
$value_limit = intval(wheelValue('value_limit'));
$special = wheelValue('special_char');
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
			$stmt = $db->prepare("SELECT * FROM configured_params_filtering WHERE name = ?");
			$stmt->bindValue(1, $name,SQLITE3_TEXT);	
			$res = $stmt->execute();
			
			if($row = $res->fetchArray(SQLITE3_ASSOC)){

				if($row['cont_letters'] != 1 && ContainsAlpha($value)) die('Letters NOT allowed');
				if($row['cont_numbers'] != 1 && ContainsNumbers($value)) die('Numbers NOT allowed');
				if($row['length'] < strlen($value)) die('Length NOT allowed');
				
				if(ContainsSpecial($value))
				{
					if($row['cont_special_all'])
					{
						$chars = str_split(preg_replace('/[a-z0-9]/i','', $value));
						foreach ($chars as $char) {
							if(!strpbrk($special, $char)) die('Not listed in characters allowd (all)');
						}
						
					}

					elseif($row['cont_special_history'])
					{
						$history = implode('',json_decode($row['special_chars']));
						$chars = str_split(preg_replace('/[a-z0-9]/i','', $value));
						foreach ($chars as $char) {
							if(!strpbrk($history, $char)) die('Not listed in characters allowd (history)');
						}

					}else die('Special characters NOT allowd');
				}

			}
			else
			{ 
				return false;
			}

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


		foreach($req as $name => $value)
		{
			if(!checkFilter($name,$value)) setNew($name,$value,false);
		}

		foreach($headers as $name => $value)
		{
			if(!checkFilter($name,$value)) setNew($name,$value,true);
		}


$db->close();

?>
