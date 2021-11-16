<?php
namespace Database;

class DB {
	/**
	 * Conexion MySQLi
	 * 
	 * @var object
	 */
	private $connection;

	/**
	 * Error
	 * 
	 * @var string
	 */
	private $error;


    public function __construct($hostname, $username, $password, $dbname, $port)
	{

		if (extension_loaded('mysqli')) {
			$this->connect($hostname, $username, $password, $dbname, $port);			

			if (!$this->connection) {
				$this->connection = null;
				$this->error = (string)mysqli_connect_errno() . '-' . mysqli_connect_error();
			}
		}
		else {
			$this->error = "No se pudo cargar la extension mysqli";
		}
	}

    private function connect($hostname, $username, $password, $dbname, $port)
	{
		$this->connection = @mysqli_connect($hostname, $username, $password, $dbname, $port);

		if (!$this->connection) {
			$this->connection = null;
			$this->error = (string)mysqli_connect_errno() . '-' . mysqli_connect_error();
		}
		else{
			mysqli_set_charset($this->connection, "utf8");
		}
	}

    public function query($query, $params=null)
	{
		$this->error = '';
		$resultSet = null;

		$retArray = array();

		if (is_null($params)){
			if ($resultSet = mysqli_query($this->connection, $query)){
				while($row = $this->fetchArrayAssoc($resultSet)){
					$retArray[] = $row;
				}

	        	return $retArray;
			}
			else{
				$this->error = (string)mysqli_errno($this->connection) . '-' . mysqli_error($this->connection);
				return false;
			}
		}
		else{			
			if ($prepared_stmt = mysqli_prepare($this->connection, $query)){
				$paramTypes = $this->arrayMySQLType($params);

				if (count($params) == 1){
					$prepared_stmt->bind_param($paramTypes, $params[0]);
				}
				else{
					array_unshift($params, $paramTypes);
				
					$tmp_params = array();
		        	foreach($params as $key => $value) $tmp_params[$key] = &$params[$key];

		        	call_user_func_array(array($prepared_stmt, 'bind_param'), $tmp_params); 
				}	

				if(mysqli_stmt_execute($prepared_stmt)){
					$resultSet = mysqli_stmt_get_result($prepared_stmt);

		        	mysqli_stmt_close($prepared_stmt);

		        	while($row = $this->fetchArrayAssoc($resultSet)){
						$retArray[] = $row;
					}

		        	return $retArray;
		        }
		        else {
		        	$this->error = (string)mysqli_stmt_errno($prepared_stmt) . '-' . mysqli_stmt_error($prepared_stmt);
		        	return false;
		        }
			}
			else {
				$this->error = (string)mysqli_errno($this->connection) . '-' . mysqli_error($this->connection);
				return false;
			}
		}
	}

    private function arrayMySQLType($arrayParams)
	{
		$arrayTypes = '';
		$size = count($arrayParams);

		for ($i = 0; $i <= $size-1; $i++) {
		    if (gettype($arrayParams[$i])=='string'){
		    	$arrayTypes = $arrayTypes . 's';
		    } 
		    else if(gettype($arrayParams[$i])=='integer') {
		    	$arrayTypes = $arrayTypes . 'i';
		    } 
		    else if(gettype($arrayParams[$i])=='double') {
		    	$arrayTypes = $arrayTypes . 'd';
		    }
		    else{
		    	$arrayTypes = $arrayTypes . 'b'; // BLOB
		    }
		}

		return $arrayTypes;
	}
    
    private function fetchArrayAssoc($resultSet)
	{
		return mysqli_fetch_array($resultSet, MYSQLI_ASSOC);
	}

    public function getError()
	{
		return $this->error;
	}
}

?>