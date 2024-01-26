<?php

class ContactsModel implements ModelInterface
{
    /**
     * @var Db
     */
    private $db;
    /**
     * @var ContactsModel stdClass
     */
    private $contacts;

    public function __construct() {
        $this->db = Db::getInstance();
    }

    /**
     * @return array of Contact
     */
    public function getAll() {
        if(!isset($this->contacts)){
            $this->contacts = $this->db->getDb()->query("SELECT * FROM contacts")->fetchAll(PDO::FETCH_CLASS, 'Contact');
        }

        return $this->contacts;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function getOneById($id){
        if (!$id) {
            return false;
        }

        $query = $this->db->getDb()->prepare("SELECT * FROM contacts WHERE id=:id");
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, 'Contact')[0];
    }

    /**
     * @param $post
     * @return bool
     */
    public function save($post) {
        if($this->checkIfExactContactExists($post)){
            return false;
        };

        $contact = $this->prepareContact($post);
        return $this->db->save('contacts', $contact);
    }

    public function prepareContact($post){
        $contact = new Contact();
        foreach ($contact->getObjectVars() as $varName => $varValue) {
            $method = 'set' . ucfirst($varName);
            if(method_exists($contact, $method)) {
                $contact->$method($post[$varName]);
            }
        }

        return $contact;
    }

    /**
     * @param $id
     * #@return bool
     */
    public function delete($id) {
        $query = $this->db->getDb()->prepare("DELETE FROM contacts WHERE id = :id");
        $query->bindParam(':id', $id);
        return $query->execute();
    }

    /**
     * @param $post
     * @return bool
     */
    public function checkIfExactContactExists($post){
        $query = $this->db->getDb()->prepare("
            SELECT id FROM contacts 
            WHERE name=:name AND surname=:surname AND phone=:phone AND email=:email AND address=:address AND note=:note 
              AND categoryId=:categoryId");
        $query = $this->bindParams($query, $post);
        $query->execute();

        if($query->fetchAll()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $query
     * @param $post
     * @return PDO
     */
    public function bindParams($query, $post) {
        $query->bindParam(':name', $post['name']);
        $query->bindParam(':surname', $post['surname']);
        $query->bindParam(':phone', $post['phone']);
        $query->bindParam(':email', $post['email']);
        $query->bindParam(':address', $post['address']);
        $query->bindParam(':note', $post['note']);
        $query->bindParam(':categoryId', $post['categoryId']);

        return $query;
    }
}
