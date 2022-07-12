<?php

abstract class Model{
public $bdd;

function __construct(){

    $this->bdd=new PDO('mysql:host=localhost;dbname=vivre_en_colonie;charset=utf8','root','');

}

}