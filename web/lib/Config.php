<?php
/*
 * Singleton design pattern
 */
class Config {
    /**
     * @var string
     */
    private $host       = 'localhost';
    /**
     * @var string
     */
    private $dbname     = 'contactsdb';
    /**
     * @var string
     */
    private $charset    = 'utf8';
    /**
     * @var string
     */
    private $username   = 'root';
    /**
     * @var string
     */
    private $password   = '';

    /**
     * @var Config
     */
    private static $instance;

    private function __construct(){}

    /**
     * Creates Config object if one does not exist
     * @return Config
     */
    public static function getInstance() {
        if(!isset(self::$instance)) {
            self::$instance = new Config;
        }

        return self::$instance;
    }

    /**
     * @return Config
     */
    public function getConfig() {
        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getDbname()
    {
        return $this->dbname;
    }

    /**
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
