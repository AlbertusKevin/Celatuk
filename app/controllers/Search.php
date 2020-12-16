<?php

class Search extends Controller
{
    public function searchByPeople()
    {
        echo json_encode($this->model('Search_Model')->getUser($_POST['keyword']));
    }
    public function searchByGroup()
    {
        echo json_encode($this->model('Search_Model')->getGroup($_POST['keyword']));
    }
}
