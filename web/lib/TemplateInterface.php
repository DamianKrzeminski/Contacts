<?php

interface TemplateInterface {
    public function setModel($model);
    public function getModel($name);
    public function setAction($action);
    public function getAction();
    public function setElementId($id);
    public function getElementId();

    public function drawTemplate();
    public function isSelectSelected($element1, $element2);
}