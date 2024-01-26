<?php
/*
 * Facade design pattern
 * We can change method start() without making everyone to change their code to use the app.
 * It's like a black box with a button, you press it and it works (and you don't have to worry what's inside).
 */
class Application implements ApplicationInterface
{
    /**
     * @var $request Request;
     */
    private $request;

    /**
     * @var $template Template
     */
    private $template;

    /**
     * @var $model
     */
    private $model = array();

    public function __construct() {
        $this->setRequest(new Request());
        $this->setTemplate(new Template());
        $this->setModel('contacts', new ContactsModel());
        $this->setModel('categories', new CategoriesModel());
    }

    public function start(){
        $this->handlePost();
        $this->handleGet();
    }

    public function handlePost(){
        if($this->request->isPostSet()) {
            switch ($this->request->getPostModel()) {
                case 'contacts' :
                    $this->model['contacts']->save($this->request->getPost());
                    break;
            }
        }
    }

    public function handleGet(){
        switch ($this->request->getAction()){
            case 'delete' :
                $this->model['contacts']->delete($this->request->getId());
            default:
                $this->template->setModel($this->model);
                $this->template->setAction($this->request->getAction());
                $this->template->setElementId($this->request->getId());
                $this->template->drawTemplate();
                break;
        }
    }

    /**
     * @param Request $request
     * @return Application
     */
    public function setRequest(Request $request){
        if(!isset($this->request)) {
            $this->request = $request;
        }
        return $this;
    }

    /**
     * @return Request
     */
    public function getRequest(){
        return $this->request;
    }

    /**
     * @param Template $template
     * @return Application
     */
    public function setTemplate(Template $template){
        if(!isset($this->template)) {
            $this->template = $template;
        }
        return $this;
    }

    /**
     * @return Template
     */
    public function getTemplate(){
        return $this->template;
    }

    /**
     * @param $model
     * @return Application
     */
    public function setModel($name, $model){
        if(!isset($this->model[$name])) {
            $this->model[$name] = $model;
        }
        return $this;
    }

    /**
     * @return ContactsModel
     */
    public function getModel(){
        return $this->model;
    }

}
