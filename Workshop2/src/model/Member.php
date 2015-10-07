<?php


namespace model;


class Member
{
    private $id;
    private $boats;
    private $name;
    private $ssn;


    public function __construct($name, $ssn, $id = 0){
        $this->name = $name;
        $this->ssn = $ssn;
        $this->id = $id;

        $this->boats = new dal\BoatRepository($this->id);

    }

    public function GetAllBoats(){
        return $this->boats->GetAllBoats();
    }

    public function DeleteAllBoats(){
        $this->boats->DeleteAllBoats();
    }

    public function GetBoatCount(){
        return count($this->GetAllBoats());
    }

    public function GetName(){
        return $this->name;
    }

    public function GetSSN(){
        return $this->ssn;
    }

    public function SetID($id){
        $this->id = $id;
    }

    public function GetID(){
        return $this->id;
    }

    public function GetMemberById($id){

    }
}
