<?php
namespace Mapc\Common;

// 참고한 곳
// https://gist.github.com/danferth/9512172
// https://ncube.net/php-database-class-for-mysql-which-uses-the-pdo-extension/

if(! class_exists('Database')) {

    class Database {

        public $pdo;
        public $error;

        protected $stmt;
        protected $options;

        public function __construct($config) {

            $dsn = $config['dbadapter'] . ':host=' . $config['dbhost'] . ';dbname=' . $config['dbname'] . ";port=3306;charset=utf8";
            $options = array(
                \PDO::ATTR_PERSISTENT    => true,
                \PDO::ATTR_ERRMODE       => \PDO::ERRMODE_EXCEPTION
                );
            try {
                $this->pdo = new \PDO(
                    $dsn,
                    $config['dbuser'],
                    $config['dbpass']
                );
                $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                $this->error = $e->getMessage();
            }

        }

        public function prepare(string $query)
        {
            $this->stmt = $this->pdo->prepare($query);
        }

        public function bindValue($placeholder, $value, $type = null)
        {
            if (is_null($type)) {
                switch (true) {
                    case is_int($value):
                        $type = \PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = \PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = \PDO::PARAM_NULL;
                        break;
                    default:
                        $type = \PDO::PARAM_STR;
                        break;
                }
            }

            $this->stmt->bindValue($placeholder, $value, $type);
        }

        public function bindValueArray(array $params)
        {
            if (!empty($params)) {
                foreach ($params as $key => $val) {
                    $this->bindValue($key, $val);
                }
            }
        }

        public function execute(array $param = array())
        {
            if (is_array($param) && !empty($param)) {
                foreach($param as $key => $val) {
                    $this->bindValue($key, $val);
                }
            }

            return $this->stmt->execute();
        }

        public function fetchAll($args = \PDO::FETCH_ASSOC)
        {
            return $this->stmt->fetchAll($args);
        }

        public function fetch($args = \PDO::FETCH_ASSOC)
        {
            return $this->stmt->fetch($args);
        }

        public function rowCount()
        {
            return $this->stmt->rowCount();
        }

        public function lastInsertId(){
            return $this->pdo->lastInsertId();
        }

        public function beginTransaction(){
            return $this->pdo->beginTransaction();
        }

        public function commit(){
            return $this->pdo->commit();
        }

        public function rollBack(){
            return $this->pdo->rollBack();
        }

        public function debugDumpParams(){
            return $this->stmt->debugDumpParams();
        }

        public function errorInfo()
        {
            $error = $this->stmt->errorInfo();
            $this->error = $error[0] . ' ' . $error[2];
        }

        public function close()
        {
            $this->pdo = null;
        }

        public function __call($method, $args)
        {
            if (method_exists($this->pdo, $method)) {
                return call_user_func_array(array(&$this->pdo, $method), $args);
            } else if (method_exists($this->stmt, $method)) {
                return call_user_func_array(array(&$this->stmt, $method), $args);
            } else {
                return 'Method \'' . $method . '\' not exists';
            }
        }
    }

}

// this is it




/*

<?php

// DB 설정
define('DB_HOST', 'localhost');
define('DB_NAME', '');
define('DB_USER', '');
define('DB_PASS', '');

define('DB_ERROR_MODE', ''); // SILENT, WARNING

class DB
{
    public $pdo;
    public $error;

    protected $host;
    protected $user;
    protected $pass;
    protected $dbname;
    protected $stmt;
    protected $options;

    public function __construct(array $options = array())
    {
        require_once NT_CONFIG_PATH.DIRECTORY_SEPARATOR.'db.php';

        $this->options = array();

        switch (DB_ERROR_MODE) {
            case 'SILENT':
                $this->options[\PDO::ATTR_ERRMODE] = \PDO::ERRMODE_SILENT;
                break;
            case 'WARNING':
                $this->options[\PDO::ATTR_ERRMODE] = \PDO::ERRMODE_WARNING;
                break;
            default:
                $this->options[\PDO::ATTR_ERRMODE] = \PDO::ERRMODE_EXCEPTION;
                break;
        }

        if (!empty($options))
            $this->options = array_merge($this->options, $options);

        $this->host   = DB_HOST;
        $this->user   = DB_USER;
        $this->pass   = DB_PASS;
        $this->dbname = DB_NAME;

        try {
            $this->pdo = new \PDO('mysql:host='.$this->host.';dbname='.$this->dbname.';charset=utf8', $this->user, $this->pass, $this->options);
        } catch(\Exception $e) {
            $this->error = 'Connection failed: ' . $e->getMessage();
        }
    }

    public function prepare(string $query)
    {
        $this->stmt = $this->pdo->prepare($query);
    }

    public function bindValue($placeholder, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = \PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = \PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = \PDO::PARAM_NULL;
                    break;
                default:
                    $type = \PDO::PARAM_STR;
                    break;
            }
        }

        $this->stmt->bindValue($placeholder, $value, $type);
    }

    public function bindValueArray(array $params)
    {
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $this->bindValue($key, $val);
            }
        }
    }

    public function execute(array $param = array())
    {
        if (is_array($param) && !empty($param)) {
            foreach($param as $key => $val) {
                $this->bindValue($key, $val);
            }
        }

        return $this->stmt->execute();
    }

    public function fetchAll($args = \PDO::FETCH_ASSOC)
    {
        return $this->stmt->fetchAll($args);
    }

    public function fetch($args = \PDO::FETCH_ASSOC)
    {
        return $this->stmt->fetch($args);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    public function lastInsertId(){
        return $this->pdo->lastInsertId();
    }

    public function beginTransaction(){
        return $this->pdo->beginTransaction();
    }

    public function commit(){
        return $this->pdo->commit();
    }

    public function rollBack(){
        return $this->pdo->rollBack();
    }

    public function debugDumpParams(){
        return $this->stmt->debugDumpParams();
    }

    public function errorInfo()
    {
        $error = $this->stmt->errorInfo();
        $this->error = $error[0] . ' ' . $error[2];
    }

    public function close()
    {
        $this->pdo = null;
    }

    public function __call($method, $args)
    {
        if (method_exists($this->pdo, $method)) {
            return call_user_func_array(array(&$this->pdo, $method), $args);
        } else if (method_exists($this->stmt, $method)) {
            return call_user_func_array(array(&$this->stmt, $method), $args);
        } else {
            return 'Method \'' . $method . '\' not exists';
        }
    }
}

*/

























/*


if(! class_exists('Database')) {

	class Database extends \PDO {

	    public function __construct($config){
print_r($config);
	        try {
	            parent::__construct(
	            	$config['dbadapter'] . ':host=' . $config['dbhost'] . ';dbname=' . $config['dbname'] . ";port=3306;charset=utf8",
	            	$config['dbuser'],
	            	$config['dbpass']
	            );
	            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        } catch(PDOException $e){                
	            die('ERROR: '. $e->getMessage());
	        }

	    }
	}

}
*/
