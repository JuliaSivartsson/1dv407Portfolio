<?php


namespace model;

class ShortNameException extends \Exception{}
class InvalidNameException extends \Exception{}
class InvalidSSNException extends \Exception{}

class Member
{
    private $id;
    private $boats;
    private $name;
    private $ssn;


    public function __construct($name, $ssn, $id = 0){
        $this->name = trim($name);
        $this->ssn = $ssn;
        $this->id = $id;

        if (mb_strlen($this->name) < 3) {
            throw new ShortNameException();
        }

        if ($this->name !== strip_tags($this->name)) {
            throw new InvalidNameException();
        }

        if (!preg_match("/^((18|19|20)?[0-9]{2})(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])(-)?[0-9pPtTfF][0-9]{3}$/", $this->ssn)) {
            throw new InvalidSSNException();
        }

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
