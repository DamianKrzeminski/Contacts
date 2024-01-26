<?php

interface  ModelInterface {
    public function getAll();
    public function getOneById($id);
    public function save($post);
    public function delete($id);
}