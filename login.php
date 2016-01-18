<?php 


	 //error_reporting(E_ALL);
	 //ini_set("display_errors", 1);

	//avoid clickjacking
 	header('X-Frame-Options: DENY');
	header('Access-Control-Allow-Origin: '.$_SERVER['SERVER_NAME']);

	// BCRYPT include for PHP < 5.5
	require_once 'include/bcrypt.php';

	// Jcryption includes
	require_once 'jcryption/include/sqAES.php';
	require_once 'jcryption/include/JCryption.php';

	if(!file_exists("db/WAFyy.sqlite3") || filesize("db/WAFyy.sqlite3") < 1){header("Location: start.php");}

	$pdb = new SQLite3('db/WAFyy.sqlite3');


	function getPassword()
	{
		global $pdb;
		$stmt = $pdb->prepare("SELECT value FROM cogwheel WHERE nick = ?");
		$stmt->bindValue(1, 'encryptedpassword',SQLITE3_TEXT);	
		$res = $stmt->execute();
		$row = $res->fetchArray(SQLITE3_BOTH);
		return ($row['value']);
	}

		// get password from DB
		$password = getPassword();

		// define salted password in a global parameter
		define("SYSTEMPASSWORD", $password);
		
		// define cookie name
		define("COOKIENAME", 'ships');


	class Authorization
	{

	private $authorized;
	private $login_failed;
	private $system_password_encrypted;


	public function __construct()
	{
		session_start();
		// the salt and password encrypting is probably unnecessary protection but is done just
		// for the sake of being very secure
		if(!isset($_SESSION[COOKIENAME.'_salt']) && !isset($_COOKIE[COOKIENAME.'_salt']))
		{
			// create a random salt for this session if a cookie doesn't already exist for it
			$_SESSION[COOKIENAME.'_salt'] = self::generateSalt(20);
		}
		else if(!isset($_SESSION[COOKIENAME.'_salt']) && isset($_COOKIE[COOKIENAME.'_salt']))
		{
			// session doesn't exist, but cookie does so grab it
			$_SESSION[COOKIENAME.'_salt'] = $_COOKIE[COOKIENAME.'_salt'];
		}

		// salted and encrypted password used for checking
		$this->system_password_encrypted = hash('sha256', (SYSTEMPASSWORD.'_'.$_SESSION[COOKIENAME.'_salt']) );

		$this->authorized =
			// no password
			SYSTEMPASSWORD == ''
			// correct password stored in session
			|| isset($_SESSION[COOKIENAME.'password']) && $_SESSION[COOKIENAME.'password'] == $this->system_password_encrypted 
			// correct password stored in cookie
			|| isset($_COOKIE[COOKIENAME]) && isset($_COOKIE[COOKIENAME.'_salt']) && hash('sha256', (SYSTEMPASSWORD."_".$_COOKIE[COOKIENAME.'_salt']) ) == $_COOKIE[COOKIENAME];
	}

	public function attemptGrant($password)
	{
		if (password_verify($password, SYSTEMPASSWORD)) {

			$expire = time()+60*15; //set expiration to 15 minutes

			setcookie(COOKIENAME, $this->system_password_encrypted, $expire, null, null, null, true);
			setcookie(COOKIENAME.'_salt', $_SESSION[COOKIENAME.'_salt'], $expire, null, null, null, true);

			$_SESSION[COOKIENAME.'password'] = $this->system_password_encrypted;
			$this->authorized = true;
			return true;
		}

		$this->login_failed = true;
		return false;
	}

	public function revoke()
	{
		//destroy everything - cookies and session vars
		setcookie(COOKIENAME, "", time()-86400, null, null, null, true);
		setcookie(COOKIENAME."_salt", "", time()-86400, null, null, null, true);
		unset($_COOKIE[COOKIENAME]);
		unset($_COOKIE[COOKIENAME.'_salt']);
		session_unset();
		session_destroy();
		$this->authorized = false;
	}


	public function isAuthorized()
	{
		return $this->authorized;      
	}

	public function isFailedLogin()
	{
		return $this->login_failed;
	}

	private static function generateSalt($saltSize)
	{
		$set = 'ABCDEFGHiJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		$setLast = strlen($set) - 1;
		$salt = '';
		while ($saltSize-- > 0) {
			$salt .= $set[mt_rand(0, $setLast)];
		}
		return $salt;
	}

}
	// check user authentication, login and logout
	$auth = new Authorization();

	// check if user has attempted to log in
	function Login($values)
	{
		global $auth;
		$data = (array) json_decode($values);
		$auth->attemptGrant($data['password']);
		if(!$auth->isAuthorized())
		{	
			header('HTTP/1.0 401 Unauthorized');
		}
	}

	// check authorization status
	if(isset($_GET['status']))
	{	
		if(!$auth->isAuthorized())
			header('HTTP/1.0 401 Unauthorized');
		else
			header('HTTP/1.0 200 authorized');
	}

	// check if user has attempted to log out
	if (isset($_POST['logout']) && isset($_GET['logout'])){
		$auth->revoke();
		echo 'ok!';
		header('HTTP/1.0 401 Unauthorized');
	}

	if(!$auth->isAuthorized() && isset($_GET['login']))
	{	
		JCryption::decrypt();
		Login($_POST['data']);
	}

?>