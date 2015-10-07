<?php

namespace view;

use model\Type;

class Boat
{
    /* @var $navView \model\dal\NavigationView */
    private $navView;

    /* @var $boatRepository \model\dal\BoatRepository */
    private $boatRepository;

    private static $length = "BoatView::Length";
    private static $type = "BoatView::Type";
    private static $save = "BoatView::SaveBoat";
    private static $deleteBoat = "BoatView::Delete";
    private static $editBoat = "BoatView:Edit";

    private static $memberPosition = "member";
    private static $boatPosition = "boat";

    public function __construct(NavigationView $navView) {
        $this->navView = $navView;
        $this->boatRepository = new \model\dal\BoatRepository();
    }

    public function GetBoatDetails(\model\Boat $boat){
        return 'Type: ' . $boat->GetType() . ' - Length: ' . $boat->GetLength() . ' ' . $this->GetBoatAdminLinks($boat) . PHP_EOL;
    }

    private function GetBoatAdminLinks(\model\Boat $boat){
        $ret = '';
        $ret .= $this->navView->GetEditBoatLink(self::$boatPosition . '=' . $boat->GetID(), "Edit boat" . ' ');
        $ret .= $this->navView->GetDeleteBoatLink(self::$boatPosition . '=' . $boat->GetID(), "Delete");

        return $ret;
    }

    public function getPostLength(){
        if(isset($_POST[self::$length])) {
            return $_POST[self::$length];
        }
        return null;
    }

    public function getPostType(){
        if(isset($_POST[self::$type])) {
            return $_POST[self::$type];
        }
        return null;
    }

    public function getOwnerID(){
        if(isset($_GET[self::$memberPosition])){
            return $_GET[self::$memberPosition];
        }
        return null;
    }

    public function GetNewBoat(){
        return new \model\Boat($this->getPostType(), $this->getPostLength(), $this->getOwnerID());
    }

    // ADD NEW BOAT

    public function HasAddedBoat(){
        //TODO: Validation?
        if(isset($_POST[self::$save])) {
            return true;
        } else {
            return false;
        }
    }

    public function AddedSuccess(){
        return "<p>A new boat has been added!</p>";
    }

        public function AddBoat() {
        return "
    <h2>Add new boat</h2>
    <form method='post' >
        <fieldset>
        <legend>Register a new boat - Write the length and pick a type:</legend>
            <label for='" . self::$length . "' >Length :</label>
            <input type='text' size='20' name='" . self::$length . "' id='" . self::$length . "' value='' />
            <br/>
            <label for='" . self::$type . "' >Type :</label>
            <select name='" . self::$type . "'>
                " . $this->GetTypeOptionsHTML() . "
            </select>
            <br/>
          <input id='submit' type='submit' name='" . self::$save . "'  value='Save' />
          <br/>
        </fieldset>
    </form>";
    }

    // EDIT BOAT

    public function HasEditedBoat(){
        if(isset($_POST[self::$editBoat])) {
            return true;
        } else {
            return false;
        }
    }

    public function GetUpdatedBoatID(){
        if ($_GET[self::$boatPosition]) {
            return $_GET[self::$boatPosition];
        }
        return null;
    }

    public function UpdateSuccess(){
        return "<p>Boat has been updated!</p>";
    }

    //TODO: Set dropdown to current type?
    public function EditBoat(){
        $id = $_GET[self::$boatPosition];
        $boatToEdit = $this->boatRepository->GetBoatById($id);

        $ret = '<h2>Edit boat</h2>';
        $ret .= "
        <form method='post' >
        <fieldset>
            <label for='" . self::$length . "' >Length :</label>
            <input type='text' size='20' name='" . self::$length
            . "' id='" . self::$length . "' value='" . $boatToEdit->GetLength()  . "' />
            <br/>
            <label for='" . self::$type . "' >Type :</label>
            <select name='" . self::$type . "'>
                " . $this->GetTypeOptionsHTML($boatToEdit->GetType()) . "
            </select>
            <br/>
          <input id='submit' type='submit' name='" . self::$editBoat . "'  value='Save' />
          <br/>
        </fieldset>
    </form>";
        return $ret;
    }

    private function GetTypeOptionsHTML($current = null){
        $ret = '';
        foreach(Type::GetTypes() as $type){
            $selected = ($type == $current) ? ' selected="selected"' : '';
            $ret .= '<option value="' . $type . '"' . $selected . '>' . $type . '</option>"';
        }

        return $ret;
    }


    // DELETE BOAT

    public function WantsToDeleteBoat(){
        return isset($_POST[self::$deleteBoat]);
    }

    // TODO: Should this be handled by the view?
    public function GetBoatToDelete(){
        $id = $_GET[self::$boatPosition];
        $userToDelete = $this->boatRepository->GetBoatById($id);
        return $userToDelete;
    }

    public function DeleteBoat(){
        $id = $_GET[self::$boatPosition];
        $boatToDelete = $this->boatRepository->GetBoatById($id);

        $ret = '<p>Are you sure you want to delete '. $boatToDelete->GetType()
                . ' (' . $boatToDelete->GetLength() .  'm)' . '?</p>';
        $ret .= '
            <form method="post">
                <input id="submit" type="submit" name="' . self::$deleteBoat . '"  value="Delete" />
            </form>';
        return $ret;
    }

    public function DeletedSuccess(){
        return "<p>Boat has been deleted!</p>";
    }


}
