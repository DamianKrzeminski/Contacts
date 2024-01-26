<?php
/*
 * Singleton design pattern
 */
class Db
{
    /**
     * @var Db
     */
    private static $instance;

    /**
     * @var PDO
     */
    private $Db;

    /**
     * Db constructor.
     */
    private function __construct(){}

    /**
     * Creates Db object if one does not exist
     * @return Db
     */
    public static function getInstance()
    {
        if(!isset(self::$instance)) {
            self::$instance = new Db();
        }

        return self::$instance;
    }

    /**
     * Creates PDO connection if one does not exist
     * @return PDO
     */
    public function getDb() {
        if(isset($this->Db)) {
            return $this->Db;
        }

        $parameters = Config::getInstance()->getConfig();
        $db = new PDO('mysql:
            host='.$parameters->getHost().';
            dbname='.$parameters->getDbname().';
            charset=' . $parameters ->getCharset() .'',
            $parameters->getUsername(),
            $parameters->getPassword()
        );
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        return $db;
    }

    public function save($table, $object){
        if ($object->getId()) {
            $set = $this->prepareSet($object);
            $query = $this->getDb()->prepare("UPDATE $table SET $set WHERE id=:id");
        } else {
            $names = $this->prepareNames($object);
            $values = $this->preparevalues($object);

            $query = $this->getDb()->prepare("INSERT INTO $table ($names) VALUES ($values)");
        }

        $query = $this->bindParams($query, $object);
        return $query->execute();
    }

    public function prepareSet($object){
        foreach ($object->getObjectVars() as $varName => $varValue) {
                $set[] = "$varName=:$varName";
        }

        return implode(', ', $set);
    }

    public function prepareNames($object){
        foreach ($object->getObjectVars() as $varName => $varValue) {
            if($varName != 'id') {
                $names[] = $varName;
            }
        }

        return implode(', ', $names);
    }

    public function prepareValues($object){
        foreach ($object->getObjectVars() as $varName => $varValue) {
            if($varName != 'id') {
                $values[] = ":$varName";
            }
        }

        return implode(', ', $values);
    }

    /**
     * @param $query
     * @param $object
     * @return PDO
     */
    public function bindParams($query, $object) {
        foreach ($object->getObjectVars() as $varName => &$varValue) {
            if(!$object->getId() && $varName == 'id') {
                continue;
            }
            $query->bindParam(":$varName", $varValue);
        }
        return $query;
    }
}