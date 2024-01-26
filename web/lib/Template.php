<?php
/*
 * Facade design pattern
 * We can change method drawTemplate() without making everyone to change their code to draw template
 * It's like a black box with a button, you press it and it works (and you don't have to worry what's inside).
 */
class Template implements TemplateInterface
{
    /**
     * @var string
     */
    private $action;
    /**
     * @var integer
     */
    private $elementId;
    /**
     * @var ContactsModel
     */
    private $model;

    public function drawTemplate(){
        $this->includeTemplateByAction($this->action);
    }

    /**
     * @param $action
     */
    public function includeTemplateByAction($action){
        switch ($action) {
            case (''):
                include_once('template/home.phtml');
                break;
            case ('contact'):
                include_once('template/contact.phtml');
                break;
            case ('list'):
            case ('delete'):
                include_once('template/list.phtml');
                break;
            case ('add'):
            case ('edit'):
                include_once('template/addEdit.phtml');
                break;
            default:
                include_once('template/404.phtml');
                break;
        }
    }

    /**
     * @return string
     */
    public function getPageLabel(){
        switch ($this->action) {
            case '':
                $label = 'Home';
                break;
            case 'contact':
                $label = 'Contact';
                break;
            case 'list':
                $label = 'Contacts';
                break;
            case 'add':
                $label = 'Add contact';
                break;
            case 'edit':
                $label = 'Edit contact';
                break;
            default:
                $label = htmlspecialchars($this->action);
                break;
        }

        return $label;
    }

    /**
     * @param $action
     * @return Template
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param $elementId
     * @return Template
     */
    public function setElementId($elementId) {
        $this->elementId = $elementId;
        return $this;
    }

    /**
     * @return integer
     */
    public function getElementId()
    {
        return $this->elementId;
    }

    /**
     * @param $model
     * @return Template
     */
    public function setModel($model) {
        $this->model = $model;
        return $this;
    }

    /**
     * @return Template
     */
    public function getModel($name)
    {
        if (!isset($this->model[$name])) {
            return false;
        }

        return $this->model[$name];
    }


    /**
     * @param $category
     * @param $contact
     * @return bool
     */
    public function isSelectSelected($category, $contact){
        if(!$category instanceof Category){
            return false;
        }

        if(empty($category->getId())){
            return false;
        }

        if(!$contact instanceof Contact){
            return false;
        }

        if(empty($contact->getCategoryId())){
            return false;
        }

        if($category->getId() == $contact->getCategoryId()){
            return true;
        }

        return false;
    }
}