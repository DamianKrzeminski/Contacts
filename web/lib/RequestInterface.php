<?php

interface RequestInterface {
    public function setAction();
    public function getAction();
    public function setId();
    public function getId();
    public function getPost();
    public function isPostSet();
    public function getPostModel();
}
?>