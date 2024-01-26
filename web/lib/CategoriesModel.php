<?php

class CategoriesModel implements ModelInterface
{
    /**
     * @var PDO
     */
    private $db;
    /**
     * @var $categories stdClass
     */
    private $categories;

    public function __construct() {
        $this->db = Db::getInstance()->getDb();
    }

    /**
     * @return array
     */
    public function getAll(){
        if(!isset($this->categories)){
            $this->categories = $this->db->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_CLASS, 'Category');
        }

        return $this->categories;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function getOneById($id){
        if (!$id) {
            return false;
        }
        $query = $this->db->prepare("SELECT * FROM categories WHERE id=:id");
        $query->bindParam(':id', $id);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_CLASS, 'Category')[0];
    }

    /**
     * @param $post
     */
    public function save($post){}

    /**
     * @param $id
     */
    public function delete($id){}

    /**
     * @param $categoryId
     * @return string
     */
    public function getCategoryLabelById($categoryId){
        foreach($this->getAll() as $index => $category) {
            if($category->getId() == $categoryId ) {
                return $this->getAll()[$index]->getLabel();
            }
        }

        return false;
    }
}