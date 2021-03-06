<?php


namespace view;


class Member
{
    private $repository;
    private $boatView;
    private $navView;

    private static $name = "MemberView::Name";
    private static $ssn = "MemberView::Ssn";
    private static $registration = "MemberView::Register";
    private static $messageId = "MemberView::MessageId";
    private static $deleteMember = "MemberView::Delete";
    private static $editMember = "MemberView::Edit";


    private static $updateName = "MemberView::UpdateName";
    private static $updateSsn = "MemberView::UpdateSsn";

    private static $memberPosition = "member";
    private $message;

    public function __construct(\model\dal\MemberRepository $repo, NavigationView $navView ,Boat $boatView){
        $this->repository = $repo;
        $this->boatView = $boatView;
        $this->navView = $navView;
    }

    public function ViewAll(){
        $ret = '<h1>A list of all members</h1>';
        $ret .= '<ul>';

        foreach($this->repository->GetAll() as $member){
            /* @var $member \model\Member */
            $ret .= '<li>Name: ' . $member->GetName() . '  - ID: ' . $member->GetID() . ' - Boats: ' . $member->GetBoatCount() . ' ' . $this->GetAdminLinks($member) . '</li>';
        }
        $ret .= '</ul>';

        return $ret;
    }

    public function ViewAllVerbose(){
        $ret = '<h1>A verbose list of all members</h1>';
        $ret .= '<ul>';

        foreach($this->repository->GetAll() as $member){
            /* @var $member \model\Member */
            $ret .= '<li>Name: ' . $member->GetName() . ' - Personal identification number: ' . $member->GetSSN() . ' - ID: ' . $member->GetID() . ' ' . $this->GetAdminLinks($member) . PHP_EOL;
            $ret .= '<ul>';
            foreach($member->GetAllBoats() as $boat){
                $ret .= '<li>' . $this->boatView->GetBoatDetails($boat) . '</li>';
            }
            $ret .= '</ul>';
            $ret .= '</li>';
        }
        $ret .= '</ul>';
        return $ret;
    }

    private function GetAdminLinks(\model\Member $member){
        $ret = '';
        $ret .= $this->navView->GetViewMemberLink(self::$memberPosition . '=' . $member->GetID(), "View " . $member->GetName()) . ' ';
        $ret .= $this->navView->GetEditMemberLink(self::$memberPosition . '=' . $member->GetID(), "Edit") . ' ';
        $ret .= $this->navView->GetDeleteMemberLink(self::$memberPosition . '=' . $member->GetID(), "Delete" . ' ');
        $ret .= $this->navView->GetAddBoatLink(self::$memberPosition . '=' . $member->GetID(), "Add boat");
        return $ret;
    }

    public function ViewMember(){
        $id = $_GET['member'];
        $userToShow = $this->repository->GetUserById($id);

        $ret = '<h1>'.$userToShow->GetName().'</h1>';
        $ret .= '<ul>';
        $ret .= '<li>Id: ' . $userToShow->GetID().'</li>';
        $ret .= '<li>Personal identification number: ' . $userToShow->GetSSN(). '</li>';
        $ret .= '<li>Boats assigned to this user: </li>';
        $ret .= '<ul>';
        foreach($userToShow->GetAllBoats() as $boat){
            $ret .= '<li>' . $this->boatView->GetBoatDetails($boat) . '</li>';
        }
        $ret .= '</ul>';
        $ret .= '</li>';
        $ret .= '</ul>';
        return $ret;
    }

    public function EditMember(){
        $id = $_GET['member'];
        $userToEdit = $this->repository->GetUserById($id);

        $ret = '<h2>Edit member</h2>';
        $ret .= "
            <form method='post' >
            <fieldset>
              <p id='" . self::$messageId . "'>" . $this->message ."</p>
              <label for='" . self::$updateName . "' >Name :</label>
              <input type='text' size='20' name='" . self::$updateName . "' id='" . self::$updateName . "' value='" . $userToEdit->GetName()  ."' />
              <br/>
              <label for='" . self::$updateSsn . "' >Social security number  :</label>
              <input type='text' size='20' name='" . self::$updateSsn . "' id='" . self::$updateSsn . "' value='". $userToEdit->GetSSN() ."' />
              <br/>
              <input id='submit' type='submit' name='" . self::$editMember . "'  value='Update' />
              <br/>
            </fieldset>
    			</form>";
        return $ret;
    }

    public function AddMember(){
        return "
          <h2>Add new member</h2>
            <form method='post' >
            <fieldset>
            <legend>Register a new user - Write name and social security number</legend>
              <p id='" . self::$messageId . "'>" . $this->message ."</p>
              <label for='" . self::$name . "' >Name :</label>
              <input type='text' size='20' name='" . self::$name . "' id='" . self::$name . "' value='" . strip_tags($this->GetRegisterName())  ."' />
              <br/>
              <label for='" . self::$ssn . "' >Social security number  :</label>
              <input type='text' size='20' name='" . self::$ssn . "' id='" . self::$ssn . "' value='' />
              <br/>
              <input id='submit' type='submit' name='" . self::$registration . "'  value='Register' />
              <br/>
            </fieldset>
    			</form>

    		";
    }

    public function GetRegisterName(){
        if(isset($_POST[self::$name])) {
            return $_POST[self::$name];
        }
        return null;
    }

    public function GetRegisterSsn(){
        if(isset($_POST[self::$ssn])) {
            return $_POST[self::$ssn];
        }
        return null;
    }

    public function GetUpdateSsn(){
        if(isset($_POST[self::$updateSsn])) {
            return $_POST[self::$updateSsn];
        }
        return null;
    }

    public function GetUpdateName(){
        if(isset($_POST[self::$updateName])) {
            return $_POST[self::$updateName];
        }
        return null;
    }

    public function AddedSuccess(){
        return "<p>A new member has been added!</p>";
    }

    public function UpdateSuccess(){
        return "<p>User has been updated!</p>";
    }

    private function GetIdToEdit(){
        return $_GET['member'];
    }
    public function GetUpdatedMember(){
        $id = $this->GetIdToEdit();
        return new \model\Member($this->GetUpdateName(), $this->GetUpdateSsn(), $id);
    }

    public function HasEditedMember(){
        //Check if member has been submitted and no errors occur
        if(isset($_POST[self::$editMember])) {
            return $this->ValidateMember($this->GetUpdateName(), $this->GetUpdateSsn());
        }
        return false;
    }

    public function HasAddedMember(){
        //Check if member has been submitted and no errors occur
        if(isset($_POST[self::$registration])) {
            return $this->ValidateMember($this->GetRegisterName(), $this->GetRegisterSsn());
        }
        return false;
    }

    private function ValidateMember($name, $ssn){

        try{
            new \model\Member($name, $ssn);
            return true;
        }catch(\model\ShortNameException $e){
            $this->message = "Name must be atleast 3 characters long.";
        }catch(\model\InvalidNameException $e){
            $this->message = "Name contains invalid characters.";
        }catch(\model\InvalidSSNException $e){
            $this->message = "Social security number must valid.";
        }
        return false;
    }

    public function GetNewMember(){
        //Check if member has been submitted and no errors occur
        return new \model\Member($this->GetRegisterName(), $this->GetRegisterSsn());
    }

    public function WantsToDeleteMember(){
        return isset($_POST[self::$deleteMember]);
    }

    public function GetMemberToDelete(){
        $id = $_GET['member'];
        $userToDelete = $this->repository->GetUserById($id);
        return $userToDelete;
    }

    public function DeletedSuccess(){
        return "<p>Member has been deleted!</p>";
    }

    public function DeleteMember(){
        $id = $_GET['member'];
        $userToDelete = $this->repository->GetUserById($id);

        $ret = '<p>Are you sure you want to delete '. $userToDelete->GetName() .'?</p>';
        $ret .= '
            <form method="post">
                <input id="submit" type="submit" name="' . self::$deleteMember . '"  value="Delete" />
            </form>';
        return $ret;
    }

}
