<?PHP
/*Note:
Public		-Visible in all
Protected	-Visible in a class and its parent & child class
Private		-Visible only in a class
Static		-Usable out of class

This		-Refer to the Calling object
Self		-Like This but only For static
Parent		-Call sth from its Parent class
Static		-Call sth from its Child class
*/
if(1){
ini_set('display_errors', 'On');	//Debug
error_reporting(E_ALL | E_STRICT);
}

class Manage {	
    public static function autoload($class) {
        //you can put any file name or directory here
        include $class . '.php';
    }
}
spl_autoload_register(array('Manage', 'autoload'));	//autoload classes

define("username", "kz233");
define("password", "luy642EA2");
define("databasesoftware", "mysql");
define("hostwebsite", "sql.njit.edu");

new htmlpage();

class htmlpage{
	private $html;
	public function __construct(){
	$this->html = "	<html lang='en'>
			<head>
				<meta charset='utf-8'>
				<title>Sql Active Record</title>
				<meta name='description' content='Sql Active Record'>
				<meta name='author' content='Kan'>
				<link rel='stylesheet' href='css/styles.css?v=1.0'>
			</head>
			<body>";
	$this->htmlform();
	$this->autoshowtable();
	}


	public function htmlform() {	//Select SQL form
	$this->html .= '<form action="index.php" method="post" enctype="multipart/form-data">
			<h1 style="color:LightGreen;">Select SQL Code: </h1>

			<select name="databasename">
			<option value="accounts">accounts</option>
			<option value="todos">todos</option>
			</select>

			<select name="collection">';
			$Allcollectionfunctions = get_class_methods("collections");
			unset($Allcollectionfunctions[0]);
			foreach ($Allcollectionfunctions as $functionname)
				$this->html .="<option value=$functionname>$functionname</option>";
	$this->html .= '</select>

			<input type="submit" value="Run" name="submit">
			</form>';
	}
	
	public function autoshowtable() {
		if(isset($_POST["submit"])) {
			$this->html .= $_POST["databasename"]::$_POST["collection"]();
		}
	}

	public function __destruct() {
	$this->html .= "</body>";
	$this->html .= "</html>";
	echo $this->html;
	}


}





abstract class collections{

	static public function executeScode($Scode){
		$conn = Database::connect();
		if($conn){			
			$launchcode = $conn->prepare($Scode);
			$launchcode->execute();
			$DataTitle = static::$modelNM;
			$launchcode->setFetchMode(PDO::FETCH_CLASS, $DataTitle);
			$Result = $launchcode->fetchAll();
			return $Result;
		}
	}

	static public function ShowData($id = ""){
		$id = ($id !== "") ? "= " . $id : "";
		$Scode = 'SELECT * FROM ' . get_called_class() . " WHERE id " . $id;
		$Result = self::executeScode($Scode);
		return table::tablecontect($Result, $Scode);
	}

	static public function ShowDataID_5(){
		$Result = self::ShowData("5");
		return $Result;
	}

	static public function SQLDelete(){
		$record = new static::$modelNM();
		$record->fname = "Dalven";
		$record->lname = "Kelwen";
		$record->GoFunction("Delete");
		return self::showData();
	}

	static public function SQLUpdate(){
		$record = new static::$modelNM();
		$record->id = 7;
		$record->email = 'kel@njit.edu';
		$record->fname = "Dalven";
		$record->lname = "Kelwen";
		$record->phone = "44144414";
		$record->birthday = "1994-01-01";
		$record->gender = "male";
		$record->password = "31s";
		$record->GoFunction("Update");
		return self::showData();		
	}

	static public function SQLInsert(){
		$record = new static::$modelNM();
		$record->id = 7;	//Will be UNSET()
		$record->email = 'kel@njit.edu';
		$record->fname = "Dalven";
		$record->lname = "Kelwen";
		$record->phone = "44144414";
		$record->birthday = "1994-01-01";
		$record->gender = "male";
		$record->password = "31s";
		$record->GoFunction("Insert");
		return self::showData();
	}
}

class accounts extends collections{
	protected static $modelNM = "account";
}

class todos extends collections{

	protected static $modelNM = "todo";
}


abstract class model{
	public function GoFunction($action){
		$conn = Database::connect();
		if($conn){
			$content = get_object_vars($this);
			$Scode = $this->$action($content);
			$launchcode = $conn->prepare($Scode); 
			$Result = $launchcode->execute();
			$Result = ($Result = 1) ? " Successful " : " Error ";
			echo "SQL Code : </br>" . $Scode . "<hr>" . $action . " Operation " . $Result . "<hr>";
		}		
	}

	private function Insert($content) {
	unset($content['id']);
	$insertInto = "INSERT INTO " . get_called_class() . "s (";
	$Keystring = implode(',', array_keys($content)) . ") ";
	$valuestring = implode("','", $content);
	$Scode = $insertInto . $Keystring . "VALUES ('" . $valuestring . "');";
	return $Scode;
	}

	private function Update($content) {
	$where = " WHERE id = " . $content['id'];
	unset($content['id']);
	$update = "UPDATE " . get_called_class() . "s SET ";
	foreach ($content as $key => $value)
		$update .= ($value !== Null) ? " $key = \"$value\", " : "";
	$update = substr($update, 0, -2);
	$Scode = $update . $where;
	return $Scode;
	}

	private function Delete($content) {
	$where = " WHERE";
	foreach ($content as $key => $value)
		$where .= ($value !== Null) ? " $key = \"$value\" AND" : "";
	$where = substr($where, 0, -4);
	$Scode = "DELETE FROM " .  get_called_class() . "s" . $where . ";";
	return $Scode;
	}

	//private function Find() {}
}

class account extends model{
	public $id;
	public $email;
	public $fname;
	public $lname;
	public $phone;
	public $birthday;
	public $gender;
	public $password;
}

class todo extends model{
	public $id;
	public $owneremail;
	public $ownerid;
	public $createddate;
	public $duedate;
	public $message;
	public $isdone;
}
