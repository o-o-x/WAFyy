<?php 

	//error_reporting(E_ALL);
	//ini_set("display_errors", 1);
 	require_once('login.php');

	// using json as the content type
	header('content-type: application/json; charset=utf-8');
	
	if(!$auth->isAuthorized())
	{	
		header('HTTP/1.0 401 Unauthorized');
		exit;
	}


	class Params
	{


	}


	class Unconfigured extends Params
	{

		public $value_limit = 10;

		
		public function ContainsNumbers($values)
		{
			foreach($values as $value)
				{
					if(preg_match('/[0-9]/', $value)){return true;}
				} return false;
		}

		
		public function ContainsAlpha($values)
		{
			foreach($values as $value)
				{
					if(preg_match('/[A-Za-z]/', $value)){return true;}
				} return false;
		}

		public function GetParamsLength($values)
		{
			$max = 0;
			$min = 1000000;

			foreach($values as $value)
				{
					//$max = strlen($value) 
					if(strlen($value) > $max)
					{
						$max = strlen($value);
					} 

					if(strlen($value) < $min)
					{
						$min = strlen($value);
					} 
				} 
				return array('min' => $min, 'max' => $max);
		}


		public function UniqChars($values)
		{
			$result = array();
			foreach($values as $value)
				{	
					$filtered = preg_replace('/[a-z0-9]/i','', $value);
					if($filtered != '') 
					{ 
						foreach (array_unique(str_split($filtered)) as $char) {
						array_push($result, $char);
						}

					}
				}
				if(!empty($result)) 
				{
					return array_values(array_unique($result));
				}
		}


		public function getParamsValues($name)
		{
			$data = (array) json_decode($name);
			global $db;
			$stack = array();
			$stmt = $db->prepare("SELECT value FROM unconfigured_params WHERE name = ?");
			$stmt->bindValue(1, $data['param_name'],SQLITE3_TEXT);	
			$res = $stmt->execute();
			
			while ($row = $res->fetchArray(SQLITE3_ASSOC))
			{
				array_push($stack,$row["value"]);
			}
			return json_encode($stack);
		}

		public function getAllParamsNames()
		{

			global $db;
			$stmt = $db->prepare("SELECT DISTINCT name FROM unconfigured_params WHERE name Not IN (SELECT DISTINCT name FROM configured_params_filtering)");
			$res = $stmt->execute();

			$stack = array();
			while ($row = $res->fetchArray(SQLITE3_ASSOC))
			{
				array_push($stack,$row["name"]);
			}

			$stack = array_unique($stack);
			foreach ($stack as $name) {
				$values = json_decode($this->getParamsValues(json_encode(array('param_name' => $name))));
				$result[] = array('name' => $name, 'contains_numbers' => $this->ContainsNumbers($values), 'contains_alpha' => $this->ContainsAlpha($values), 'uniq_char' => json_encode($this->UniqChars($values)), 'length' => json_encode($this->GetParamsLength($values)), 'values_amount' => count($values), 'value_limit' =>  $this->getValuesLimit() );
			}

			return json_encode($result);
		}


		public function deleteParam($name,$id)
		{

			global $db;
			$stmt = $db->prepare("DELETE FROM unconfigured_params WHERE name = ? AND id = ?");
			$stmt->bindValue(1, $name,SQLITE3_TEXT);	
			$stmt->bindValue(2, $id,SQLITE3_INTEGER);	
			$result = $stmt->execute();

		}


		public function getValuesLimit()
		{
		global $db;
		$stmt = $db->prepare("SELECT value FROM cogwheel WHERE nick = ?");
		$stmt->bindValue(1, 'value_limit',SQLITE3_TEXT);	
		$res = 	$stmt->execute();
		$row = $res->fetchArray(SQLITE3_ASSOC);

		return $row["value"];
		}
	

	}
	 


	class Configured extends Unconfigured
	{

		public function setNew($values)
		{
			$data = (array) json_decode($values);
			global $db;
			$stmt = $db->prepare("INSERT INTO configured_params_filtering (name,length,cont_letters,cont_numbers,cont_special_all,cont_special_history,special_chars) VALUES (?, ?, ?, ?, ?, ?, ?)");
			$stmt->bindValue(1, $data['param_name'],SQLITE3_TEXT);	
			$stmt->bindValue(2, $data['param_length'],SQLITE3_INTEGER);
			$stmt->bindValue(3, $data['param_letters'],SQLITE3_INTEGER);	
			$stmt->bindValue(4, $data['param_numbers'],SQLITE3_INTEGER);	
			$stmt->bindValue(5, $data['param_special_all'],SQLITE3_INTEGER);	
			$stmt->bindValue(6, $data['param_special_history'],SQLITE3_INTEGER);	

			if($data['param_special_history'])
			{
				//$values = json_decode($this->getParamsValues(json_encode(array('param_name' => $data['param_name']))));
				//$stmt->bindValue(7, json_encode($this->UniqChars($values)),SQLITE3_BLOB);	
				$stmt->bindValue(7, json_encode(str_split($data['special_chars'])),SQLITE3_BLOB);	
			}

			$result = $stmt->execute();

		return ($stmt->execute() ? '[{"ok"}]' : '[{"Problem ?"}]');
		}


		public function getFilterRules()
		{
			global $db;
			$stack = array();
			$stmt = $db->prepare("SELECT * FROM configured_params_filtering ORDER BY time DESC");
			$res = $stmt->execute();
			
			while ($row = $res->fetchArray(SQLITE3_BOTH))
			{
				$result[] = array('name' => $row["name"], 'length' => $row["length"], 'letters' => $row["cont_letters"], 'numbers' => $row["cont_numbers"], 'special_all' => $row["cont_special_all"], 'special_history' => $row["cont_special_history"], 'time' => $row["time"], 'special_chars' => $row["special_chars"]);
			}
			return json_encode($result);
		}



		public function removeFilter($values)
		{
			$data = (array) json_decode($values);
			global $db;
			$stack = array();
			$stmt = $db->prepare("DELETE FROM configured_params_filtering WHERE name = ?");
			$stmt->bindValue(1, $data['name'],SQLITE3_TEXT);	
			return ($stmt->execute() ? '[{"ok"}]' : '[{"Problem ?"}]');
		}

	}




	class Waf  
	{

		public function getPayloads()
		{
		global $db;
		$stmt = $db->prepare("SELECT * FROM waf_payloads");
		$res = 	$stmt->execute();

			while ($row = $res->fetchArray(SQLITE3_ASSOC))
			{
				$result[] = array('payload_type' => $row["type_of_payload"], 'payload_value' => $row["regex_value"]);
			}

		return json_encode($result);  // Use json array of array's

		}
	 
		public function setPayload($params)
		{

		$data = (array) json_decode($params);
		global $db;
		$stmt = $db->prepare("INSERT INTO waf_payloads (type_of_payload, regex_value) VALUES (?, ?)");
		$stmt->bindValue(1, $data['payload_type'],SQLITE3_TEXT);	
		$stmt->bindValue(2, $data['payload_value'],SQLITE3_TEXT);	
		$result = $stmt->execute();

		echo (1 ? '[{"ok"}]' : '[{"Problem ?"}]');

		}

	}



	class Cogwheel  
	{
		public function getWheels()
		{
		global $db;
		$stmt = $db->prepare("SELECT * FROM cogwheel");
		$res = 	$stmt->execute();

			while ($row = $res->fetchArray(SQLITE3_ASSOC))
			{
				$result[] = array('name' => $row["name"], 'value' => $row["value"], 'nick' => $row["nick"]);
			}

		return json_encode($result);  // Use json array of array's

		}

		public function setWheel($values)
		{

		$data = (array) json_decode($values);
		global $db;
		$stmt = $db->prepare("UPDATE cogwheel SET value = ? WHERE nick = ?");
		if($data['nick'] == 'encryptedpassword')
		{
			$data['value'] = hash('sha256', $data['value']);
		}
		$stmt->bindValue(1, $data['value'],SQLITE3_TEXT);
		$stmt->bindValue(2, $data['nick'],SQLITE3_TEXT);	
		$result = $stmt->execute();

		echo (1 ? '[{"ok"}]' : '[{"Problem ?"}]');


		}


	}



//Test Erea (: ###################################




if ($auth->isAuthorized())
{

		// for wiping entire data on DB use unlink('db/WAFyy.sqlite3');

		$db = new SQLite3('db/WAFyy.sqlite3');
		$db->exec("CREATE TABLE 'cogwheel' ('nick' TEXT PRIMARY KEY NOT NULL, 'name' TEXT, 'value' TEXT, 'date' DATETIME DEFAULT CURRENT_TIMESTAMP)");
		$db->exec("INSERT INTO 'cogwheel' ('nick','name','value') VALUES ('value_limit','Number of unique values to save per parameter','10')");
		$db->exec("INSERT INTO 'cogwheel' ('nick','name','value') VALUES ('special_char','All special chars allowed','#$%^&*()+=-[];,./{}|:<>?~')");
		$db->exec("INSERT INTO 'cogwheel' ('nick','name','value') VALUES ('encryptedpassword','Hashed password (sha256)','Pa$$w0rd')");
		$db->exec("INSERT INTO 'cogwheel' ('nick','name','value') VALUES ('salt','Salting my password','')");
		$db->exec('CREATE TABLE waf_payloads (type_of_payload STRING, regex_value STRING)');
		$db->exec('CREATE TABLE unconfigured_params (name STRING, value BLOB, time DATETIME DEFAULT CURRENT_TIMESTAMP, id INTEGER PRIMARY KEY NOT NULL)');
		$db->exec("CREATE TABLE configured_params_filtering (name STRING PRIMARY KEY NOT NULL, length INTEGER, cont_letters INTEGER, cont_numbers INTEGER, cont_special_all INTEGER, cont_special_history INTEGER, time DATETIME DEFAULT CURRENT_TIMESTAMP, 'special_chars' BLOB DEFAULT NULL)");


		$unconfigured = new Unconfigured;
		$configured = new Configured;
		$waf = new Waf;
		$cogwheel = new Cogwheel;






	//API - GET inputs # # # # # # # # # # # # # # # # #

	echo (isset($_GET['get_payload_list']) ? $waf->getPayloads():null);
	echo (isset($_GET['add_to_payload_list']) ? $waf->setPayload(@file_get_contents('php://input')):null);
	echo (isset($_GET['get_unconfigured_param']) ? $unconfigured->getAllParamsNames():null);
	echo (isset($_GET['get_unconfigured_params_values']) ? $unconfigured->getParamsValues(@file_get_contents('php://input')):null);
	echo (isset($_GET['add_to_filtering']) ? $configured->setNew(@file_get_contents('php://input')):null);
	echo (isset($_GET['get_filters']) ? $configured->getFilterRules():null);
	echo (isset($_GET['filter_remove']) ? $configured->removeFilter(@file_get_contents('php://input')):null);
	echo (isset($_GET['get_wheels']) ? $cogwheel->getWheels():null);
	echo (isset($_GET['set_wheel']) ? $cogwheel->setWheel(@file_get_contents('php://input')):null);






	$db->close();

}


?>
