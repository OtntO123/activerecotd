<?PHP
class Database {

	protected static $conn;

	static public function connect() {
		if(!self::$conn){
			new Database();
		}
		return self::$conn;
	}


	public function __construct() {	//Set PDO object and Test connectivity
		try {
			self::$conn = new PDO(databasesoftware . ':host=' . hostwebsite .';dbname=' . username, username, password);
			self::$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			echo 'Connection Successful To Database.';
		}
		catch (PDOException $e) {
			echo "Connection Error To Database: " . $e->getMessage();
		}
	}
}
