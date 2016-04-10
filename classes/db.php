 <?php 
 	class DB{
 		private static $_instance = null;
 		private $_pdo,
 				$_query,
 				$_error = false,
 				$_results,
 				$_count = 0;

 		private function __construct(){
 			try{
 				//PDO requires DB info, username and password as parameters
 				$this->_pdo = new PDO('mysql:host=' . config::get('mysql/host') . ';dbname=' . config::get('mysql/db'), config::get('mysql/username'), config::get('mysql/password'));
 			//	echo "Connected!<br />";
 			}
 			catch(PDOException $e){
 				die($e->getMessage());
 			}
 		}

 		public static function getInstance(){
 			//Check if instance is already created
 			if(!isset(self::$_instance)){
 				self::$_instance = new DB();
 			}
 			return self::$_instance;
 		}

 		public function query($sql, $params = array()){
 			//So that it won't fetch previous error.
 			$this->_error = false;
 			if($this->_query = $this->_pdo->prepare($sql)){
 			//	echo "Success";
 				$x = 1;
 				if(count($params)){
 					foreach ($params as $param) {
 						$this->_query->bindValue($x, $param);
 						$x++;
 					}
 				}

 				if($this->_query->execute()){
 				//	echo "Executed!";
 					$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
 					$this->_count = $this->_query->rowCount();
 				}
 				else{
 					$this->_error = true;
 				}
 			}
 			return $this;
 		}

 		private function action($action, $table, $where = array()){
 			if(count($where) == 3){
 				$operators = array('=', '<', '>', '<=', '>=');

 				$field 		= $where[0];
 				$operator 	= $where[1];
 				$value 		= $where[2];

 				if(in_array($operator, $operators)){
 					$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

 					if(!$this->query($sql, array($value))->error()){
 						return $this;
 					}
 				}
 			}
 			return false;
 		}

 		public function get($table, $where){
 			return $this->action('SELECT *', $table, $where);
 		}

 		public function delete($table, $where){
 			return $this->action('DELETE *', $table, $where);
 		}

 		public function results(){
 			return $this->_results;
 		}

 		public function first(){
 			return $this->results()[0];
 		}

 		public function error(){
 			return $this->_error;
 		}

 		public function count(){
 			return $this->_count;
 		}
 	}
 ?>