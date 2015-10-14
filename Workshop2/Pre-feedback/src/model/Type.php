<?php


namespace model;

//Class to simulate Enum
class Type
{
    const Sailboat = 'Sailboat';
    const Motorsailer = 'Motorsailer';
    const Kayak = 'Kayak';
    const Canoe = 'Canoe';
    const Other = 'Other';

    public static function GetTypes(){
        return array(
            self::Sailboat,
            self::Motorsailer,
            self::Kayak,
            self::Canoe,
            self::Other
        );
    }

    public static function IsType($type){
        foreach(self::GetTypes() as $valid){
            if($type == $valid){
                return true;
            }
        }
        return false;
    }

}