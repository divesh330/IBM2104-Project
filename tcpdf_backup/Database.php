<?php

	class Database{
		
		private static $servername = "localhost";
		private static $username = "vwmyfcgdzj";
		private static $password = "V8MVSNSqmm";
		private static $dbname = "vwmyfcgdzj";		
		
		/* database connection */
		private static $databaseConnection = null;	
		
		private function __construct(){}
		
		private function __clone(){} 
		
		private function __destruct(){
			echo 'Hi';
		}
		
		public function getConnection(){
			
			if(!self::$databaseConnection){				
				try{
					self::$databaseConnection = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
				}catch(mysqli_sql_exception $e){
					die($e->getMessage());
				}
			}
			return self::$databaseConnection;
			
		}
				
	}

?>