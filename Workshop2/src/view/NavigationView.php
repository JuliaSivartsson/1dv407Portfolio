<?php
namespace view;
class NavigationView
{
    //Application Actions
    const ViewAllVerbose = "ViewAllVerbose";
    const ViewAll = "ViewAll";
    const ViewMember = "ViewMember";
    const EditMember = "EditMember";
    const AddMember = "AddMember";
    const DeleteMember = "DeleteMember";
    const EditBoat = "EditBoat";
    const AddBoat = "AddBoat";
    const DeleteBoat = "DeleteBoat";

    private static $action = "action";

    public function GetAction(){
        if(isset($_GET[self::$action])){
            return $_GET[self::$action];
        }
        return null;
    }

    public function ShowInstructions(){
        return '
    <h2>Menu</h2>
    <ol>
        <li><a href="?' . self::$action . '=' . self::ViewAll . '">View All</a></li>
        <li><a href="?' . self::$action . '=' . self::ViewAllVerbose . '">View All Verbose</a></li>
        <li><a href="?' . self::$action . '=' . self::AddMember . '">Add Member</a></li>
    </ol>
        ';
    }

    //Links
    public function GetDeleteMemberLink($extra, $title){
        return '<a href="?' . self::$action . '=' . self::DeleteMember . '&' . $extra . '">' . $title . '</a>';
    }

    public function GetEditMemberLink($extra, $title){
        return '<a href="?' . self::$action . '=' . self::EditMember . '&' . $extra . '">' . $title . '</a>';
    }

    public function GetViewMemberLink($extra, $title){
        return '<a href="?' . self::$action . '=' . self::ViewMember . '&' . $extra . '">' . $title . '</a>';
    }

    public function GetAddBoatLink($extra, $title){
        return '<a href="?' . self::$action . '=' . self::AddBoat . '&' . $extra . '">' . $title . '</a>';
    }

    public function GetEditBoatLink($extra, $title){
        return '<a href="?' . self::$action . '=' . self::EditBoat . '&' . $extra . '">' . $title . '</a>';
    }

    public function GetDeleteBoatLink($extra, $title){
        return '<a href="?' . self::$action . '=' . self::DeleteBoat . '&' . $extra . '">' . $title . '</a>';
    }

    public function GetBackLink(){
        return '<div><a href="?">Go back</a></div>';
    }
}
