<?php

namespace Core\Mapper;

use DateTime;
use DateTimeZone;
use \Model\Player;
use \Model\Shopitems;

class ToJSON {
    public static function Player(Player $data){
        return array(
            "id" => $data->getId(),
            "name" => $data->getName()
        );
    }

    public static function ShopItem(ShopItems $data){
        return array(
            "id" => $data->getId(),
            "name" => $data->getName(),
            "detail" => $data->getDescription(),
            "cost" => $data->getCost()
        );
    }

    private static function FormatDate(DateTime $date){
        // create a $dt object with the UTC timezone
        $dt = new DateTime($date->format("Y-m-d H:i:s"), new DateTimeZone('UTC'));

        // change the timezone of the object without changing it's time
        $dt->setTimezone(new DateTimeZone('Europe/Brussels'));

        // format the datetime
        return $dt->format('Y-m-d H:i:s');
    }
}

//     public static function ConsumptionBuildingType(ConsumptionBuildingType $data){
//         return array(
//             "id" => $data->getId(),
//             "name" => $data->getName(),
//             "fr" => $data->getFr()
//         );
//     }

//     public static function ConsumptionEnergy(ConsumptionEnergy $data){
//         return array(
//             "id" => $data->getId(),
//             "name" => $data->getName(),
//             "fr" => $data->getFr()
//         );
//     }

//     public static function ConsumptionEnergyProvider(ConsumptionEnergyProvider $data){
//         return array(
//             "id" => $data->getId(),
//             "name" => $data->getName(),
//             "fr" => $data->getFr()
//         );
//     }

//     public static function ConsumptionHeatingSystem(ConsumptionHeatingSystem $data){
//         return array(
//             "id" => $data->getId(),
//             "name" => $data->getName(),
//             "fr" => $data->getFr()
//         );
//     }

//     public static function CallMe(Callme $data){
//         return array(
//             "id" => $data->getId(),
//             "phone" => $data->getPhone(),
//             "moment" => $data->getMoment(),
//             "received" => ToJSON::FormatDate($data->getReceived()),
//             "responded_by" => $data->getRespondedBy(),
//             "responded_by_user" => $data->getRespondedBy() != null ? ToJSON::GetFullName($data->getUser()) : '',
//             "responded_on" => $data->getRespondedOn() != null ? ToJSON::FormatDate($data->getRespondedOn()) : ''
//         );
//     }

//     public static function ContactMe(Contactme $data){
//         return array(
//             "id" => $data->getId(),
//             "name" => $data->getName(),
//             "phone" => $data->getPhone(),
//             "mail" => $data->getMail(),
//             "moment" => $data->getMoment(),
//             "message" => $data->getMessage(),
//             "ismypos" => $data->getIsmypos(),
//             "received" => ToJSON::FormatDate($data->getReceived()),
//             "responded_by" => $data->getRespondedBy(),
//             "responded_by_user" => $data->getRespondedBy() != null ? ToJSON::GetFullName($data->getUser()) : '',
//             "responded_on" => $data->getRespondedOn() != null ? ToJSON::FormatDate($data->getRespondedOn()) : '',
//         );
//     }

//     public static function Consumption(Consumption $data){
//         return array(
//             "id" => $data->getId(),
//             "energy" => $data->getEnergy(),
//             "heating_system" => $data->getHeatingSystem(),
//             "provider" => $data->getProvider(),
//             "zipcode" => $data->getZipcode(),
//             "monthlyFee" => $data->getMonthlyfee(),
//             "name" => $data->getName(),
//             "mail" => $data->getEmail(),
//             "phone" => $data->getPhone(),
//             "surface" => $data->getSurface(),
//             "monoConsumption" => $data->getMonoConsumption(),
//             "dayConsumption" => $data->getDayConsumption(),
//             "nightConsumption" => $data->getNightConsumption(),
//             "gazConsumption" => $data->getGazConsumption(),
//             "received" => $data->getReceived() != null ? ToJSON::FormatDate($data->getReceived()) : '',
//             "responded_by" => $data->getRespondedBy(),
//             "responded_by_user" => $data->getRespondedBy() != null ? ToJSON::GetFullName($data->getUser()) : '',
//             "responded_on" => $data->getRespondedOn() != null ? ToJSON::FormatDate($data->getRespondedOn()) : ''
//         );
//     }

//     public static function User(User $data, $withPassword){
//         return array(
//             "id" => $data->getId(),
//             "user" => $data->getUser(),
//             "firstname" => $data->getFirstname(),
//             "lastname" => $data->getLastname(),
//             "password" => $withPassword ? $data->getPassword() : "",
//             "isAdmin" => $data->getIsadmin(),
//             "isEnabled" => $data->getIsEnabled(),
//             "lastConnection" => ToJSON::FormatDate($data->getLastconnection()),
//         );
//     }


//     private static function GetFullName(User $user) {
//         return ucfirst(strtolower($user->getFirstname())).' '.ucfirst(strtolower($user->getLastname()));
//     }
