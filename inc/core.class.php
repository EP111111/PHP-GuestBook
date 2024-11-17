<?php

/**
 * Database and User Management System
 * @author Ericp11111
 */

if (!defined('DIRECT_VISIT_CHECK')) {
    exit('Access Denied');
}

class Database {

    private static $_instance; // To store the instance
    private $link; // Database connection identifier

    private $db_host = 'localhost';
    private $db_port = 3306;

    private $db_user = 'root';
    private $db_pwd = 'root';

    private $db_dbname = 'stuBook';

    // Constructor
    private function __construct() {
        $this->_connect();
    }

    // Database connection method
    private function _connect() {
        $PHP = substr(PHP_VERSION, 0, 1);
        if ($PHP < 7) {
            $this->link = mysql_connect($this->db_host . ":" . $this->db_port, $this->db_user, $this->db_pwd);
            mysql_query("set names 'utf8mb4'");
            mysql_select_db($this->db_dbname, $this->link);
        } else {
            $this->link = mysqli_connect($this->db_host . ":" . $this->db_port, $this->db_user, $this->db_pwd, $this->db_dbname);
            mysqli_query($this->link, "set names 'utf8mb4'");
        }

        if (!$this->link) {
            $this->err('Failed to connect to database!!');
        }
    }

    // Prevent cloning
    private function __clone() {}

    // Get instance method
    public static function getInstance() {
        if (!self::$_instance instanceof self)
            self::$_instance = new self();
        return self::$_instance;
    }

    /** 
     * Execute a MySQL query
     * @param string $sql SQL statement to execute
     * @param bool $fetchfirst Whether to return only the first result
     * @return mixed Query result (false if no results)
     */
    public function Query($sql, $fetchfirst = false) {
        $PHP = substr(PHP_VERSION, 0, 1);
        $resultset = array();

        if ($PHP < 7) {
            $result = mysql_query($sql) or $this->err($sql);
            if (is_bool($result))
                return $result;

            while ($row = mysql_fetch_array($result)) {
                if ($fetchfirst) return $row;
                array_push($resultset, $row);
            }
        } else {
            $result = mysqli_query($this->link, $sql) or $this->err($sql);
            if (is_bool($result))
                return $result;

            while ($row = mysqli_fetch_array($result)) {
                if ($fetchfirst) return $row;
                array_push($resultset, $row);
            }
        }
        return $resultset;
    }

    /** 
     * Insert data into a table
     * @param string $tablename Table name
     * @param array $key Column names
     * @param array $value Column values
     * @return bool true if successful
     */
    public function Insert($tablename, $key, $value) {
        if (is_array($key))
            $key2 = join("`,`", $key);
        else
            $key2 = $key;

        if (is_array($value))
            $value2 = join("','", $value);
        else
            $value2 = $value;

        $sql = "INSERT INTO `" . $tablename . "` (`" . $key2 . "`) VALUES ('" . $value2 . "')";
        $this->Query($sql);
        return true;
    }

    /** 
     * Select data from a table
     * @param array|string $toSelect Columns to select
     * @param array|null $alias Column aliases
     * @param string $tablename Table name
     * @param string|null $condition SQL condition
     * @param bool $fetchfirst Whether to return only the first result
     * @return mixed Query result
     */
    public function Select($toSelect, $alias, $tablename, $condition, $fetchfirst = false) {
        if (is_array($toSelect) && is_array($alias) && count($alias) > 1 && count($alias) == count($toSelect)) {
            for ($i = 0; $i < count($alias); $i++) {
                $toSelect[$i] .= " as '" . $alias[$i] . "'";
            }
        }

        if (is_array($toSelect))
            $toSelect2 = join(",", $toSelect);
        else
            $toSelect2 = $toSelect;

        $sql = "SELECT " . $toSelect2 . " FROM " . $tablename;

        if ($condition)
            $sql .= " WHERE " . $condition;

        return $this->Query($sql, $fetchfirst);
    }

    /** 
     * Update data in a table
     * @param string $tablename Table name
     * @param array|string $key Column names
     * @param array|string $value Column values
     * @param string|null $condition SQL condition
     * @return bool true if successful
     */
    public function Update($tablename, $key, $value, $condition) {
        if (is_array($key) && is_array($value)) {
            $setArray = array();
            for ($i = 0; $i < count($key); $i++) {
                array_push($setArray, $key[$i] . "='" . $value[$i] . "'");
            }
            $set = join(",", $setArray);
        } else {
            $set = $key . "='" . $value . "'";
        }

        $sql = "UPDATE " . $tablename . " SET " . $set;
        if ($condition)
            $sql .= " WHERE " . $condition;

        return $this->Query($sql);
    }

    /** 
     * Delete data from a table
     * @param string $tablename Table name
     * @param string|null $condition SQL condition
     * @return bool true if successful
     */
    public function Delete($tablename, $condition) {
        $sql = "DELETE FROM " . $tablename;
        if ($condition) {
            $sql .= " WHERE " . $condition;
        }
        return $this->Query($sql);
    }

    // Display error message
    private function err($message) {
        echo "[Database Class] ERROR: " . $message;
        die();
    }
}

class User {

    private $userid; // User ID
    private $username; // Username
    private $password_md5; // Encrypted password
    private $level; // User level: 0=User, 1=Admin, 2=SuperAdmin
    private $avatar; // Avatar URL

    // Constructor
    public function __construct($userid) {
        $db = Database::getInstance();
        $Result = $db->Select("*", null, "user", "id='$userid'", true);
        if (!$Result) {
            $this->err("__construct(): Error instantiating User object, user not found");
        }

        $this->userid = $Result['id'];
        $this->username = $Result['username'];
        $this->password_md5 = $Result['password'];
        $this->level = $Result['level'];
        $this->avatar = $Result['avatar'];
    }

    // Get methods
    public function getUserid() {
        return $this->userid;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password_md5;
    }

    public function getLevel() {
        return $this->level;
    }

    public function getAvatar() {
        return $this->avatar ?: "default.jpg";
    }

    // Set methods
    public function setPassword($newPassword) {
        $db = Database::getInstance();
        $Result = $db->Update("user", "password", md5($newPassword), "id=" . $this->userid);
        if ($Result) {
            $this->password_md5 = md5($newPassword);
        } else {
            $this->err("setPassword(): Error updating user password");
        }
    }

    public function setAvatar($newAvatar) {
        $db = Database::getInstance();
        $Result = $db->Update("user", "avatar", $newAvatar, "id=" . $this->userid);
        if ($Result) {
            $this->avatar = $newAvatar;
        } else {
            $this->err("setAvatar(): Error updating user avatar");
        }
    }

    // Display error message
    private function err($message) {
        echo "[User Class] ERROR: " . $message;
        die();
    }
}

class Comment {
    private $cid; // Comment ID
    private $owner; // Author
    private $cdate; // Publish date
    private $text; // Content

    // Constructor
    public function __construct($cid) {
        $db = Database::getInstance();
        $Result = $db->Select("*", null, "comments", "id='$cid'", true);
        if (!$Result) {
            $this->err("__construct(): Error instantiating Comment object, comment not found");
        }

        $this->cid = $Result['id'];
        $this->owner = $Result['owner'];
        $this->cdate = $Result['date'];
        $this->text = $Result['text'];
    }

    // Get methods
    public function getId() {
        return $this->cid;
    }

    public function getOwner() {
        return $this->owner;
    }

    public function getDate() {
        return $this->cdate;
    }

    public function getText() {
        return $this->text;
    }

    // Set methods
    public function setDate($date) {
        $this->cdate = $date;
    }

    public function setText($text) {
        $this->text = $text;
    }

    // Display error message
    private function err($message) {
        echo "[Comment Class] ERROR: " . $message;
        die();
    }
}

?>
