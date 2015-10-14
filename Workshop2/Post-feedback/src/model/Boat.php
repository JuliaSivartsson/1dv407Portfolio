<?php

namespace model;

class Boat
{
    private $id;
    private $type;
    private $length;
    private $owner;

    public function __construct($type, $length, $ownerID, $id = 0){
        $this->SetType($type);
        $this->SetLength($length);
        $this->SetOwner($ownerID);
        $this->SetID($id);
    }

    public function GetType(){
        return $this->type;
    }

    public function SetType($type){
        if(Type::IsType($type) == false){
            throw new \Exception("Type not valid");
        }

        $this->type = $type;
    }

    public function GetOwner(){
        return $this->owner;
    }

    public function SetOwner($ownerID){
        $this->owner = $ownerID;
    }

    public function GetLength(){
        return $this->length;
    }

    public function SetLength($length){
        //Make compatible for entering 2,14
        $this->length = str_replace(',', '.', $length);
    }

    public function SetID($id){
        $this->id = $id;
    }

    public function GetID(){
        return $this->id;
    }

}
