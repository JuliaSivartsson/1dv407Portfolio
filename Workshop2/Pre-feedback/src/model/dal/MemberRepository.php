<?php


namespace model\dal;


class MemberRepository extends DatabaseConnection
{
    public function Save(\model\Member $member){
        if($member->GetID() > 0){
            $this->Update($member);
        }else{
            $this->Create($member);
        }
    }

    private function Create(\model\Member $member){
        $stmt = $this->db->prepare("INSERT INTO member (name, ssn) VALUE (?,?)");
        $stmt->execute(array($member->GetName(), $member->GetSSN()));
        $member->SetID($this->db->lastInsertId());
    }

    private function Update(\model\Member $member){
        $stmt = $this->db->prepare("UPDATE member SET name = ?, ssn = ? WHERE id = ?");
        $stmt->execute(array($member->GetName(), $member->GetSSN(), $member->GetID()));
    }

    public function Delete(\model\Member $member){
        $member->DeleteAllBoats();

        $stmt = $this->db->prepare("DELETE FROM member WHERE id = ?");
        $stmt->execute(array($member->GetID()));
    }

    public function GetAll(){
        $ret = array();

        $stmt = $this->db->prepare("SELECT * FROM member ORDER BY name");
        $stmt->execute();

        while($member = $stmt->fetchObject()){
            $ret[] =  new \model\Member($member->name, $member->ssn, $member->id);
        }

        return $ret;
    }

    public function GetUserById($id){
        $stmt = $this->db->prepare("SELECT * FROM member WHERE id = ?");
        $stmt->execute(array($id));

        if($member = $stmt->fetchObject()){
            return new \model\Member($member->name, $member->ssn, $member->id);
        }

        throw new \Exception("Member not found");
    }


}