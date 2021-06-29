<?php
/**
 * Created by PhpStorm.
 * User: istac
 * Date: 3/17/2018
 * Time: 6:07 PM
 */

namespace Core\Mapper;


use Core\Model\SetPasswordModel;
use Model\Model\Consumption;
use Model\Model\Contactme;
use Model\Model\Callme;
use Model\Model\User;
use Model\Model\Log;

class FromJSON
{
    public static function LogVisit($json){
        $values = json_decode($json);
        if($values != null){
            $result = new Log();
            if(isset($values->{"referer"})) $result->setReferer($values->{"referer"});
            return $result;
        }
    }

    public static function SetPassword($json){
        $values = json_decode($json);
        if($values != null){
            $result = new SetPasswordModel();
            if(isset($values->{"password"})) $result->NewPassword = $values->{"password"};
            if(isset($values->{"oldPassword"})) $result->OldPassword = $values->{"oldPassword"};
            return $result;
        }
    }

    public static function User($json){
        $values = json_decode($json);
        if($values != null){
            $result = new User();

            if(isset($values->{"id"})) $result->setId($values->{"id"});
            if(isset($values->{"user"})) $result->setUser($values->{"user"});
            if(isset($values->{"firstname"})) $result->setFirstname($values->{"firstname"});
            if(isset($values->{"lastname"})) $result->setLastname($values->{"lastname"});
            if(isset($values->{"password"})) $result->setPassword(password_hash($values->{"password"}, PASSWORD_DEFAULT));
            if(isset($values->{"lastConnection"})) $result->setLastconnection($values->{"lastConnection"});

            if(isset($values->{"isAdmin"}) && $values->{"isAdmin"} == 1)
            {
                $result->setIsadmin(true);
            }
            else
            {
                $result->setIsadmin(false);
            }

            if(isset($values->{"isEnabled"}) && $values->{"isEnabled"} == 1)
            {
                $result->setIsEnabled(true);
            }
            else
            {
                $result->setIsEnabled(false);
            }

            return $result;
        }
    }

    public static function ContactMe($json){
        $values = json_decode($json);
        if($values != null){
            $result = new Contactme();

            if(isset($values->{"id"})) $result->setId($values->{"id"});
            if(isset($values->{"name"})) $result->setName($values->{"name"});
            if(isset($values->{"mail"})) $result->setMail($values->{"mail"});
            if(isset($values->{"phone"})) $result->setPhone($values->{"phone"});
            if(isset($values->{"mail"})) $result->setMail($values->{"mail"});
            if(isset($values->{"moment"})) $result->setMoment($values->{"moment"});
            if(isset($values->{"message"})) $result->setMessage($values->{"message"});
            if(isset($values->{"ismypos"})) $result->setIsmypos($values->{"ismypos"});
            if(isset($values->{"received"})) $result->setReceived($values->{"received"});

            return $result;
        }
    }

    public static function CallMe($json){
        $values = json_decode($json);
        if($values != null){
            $result = new Callme();

            if(isset($values->{"id"})) $result->setId($values->{"id"});
            if(isset($values->{"phone"})) $result->setPhone($values->{"phone"});
            if(isset($values->{"moment"})) $result->setMoment($values->{"moment"});
            if(isset($values->{"received"})) $result->setReceived($values->{"received"});

            return $result;
        }
    }

    public static function Consumption($json){
        $values = json_decode($json);
        if($values != null){
            $result = new Consumption();

            if(isset($values->{"id"})) $result->setId($values->{"id"});
            if(isset($values->{"energy"})) $result->setEnergy($values->{"energy"});
            if(isset($values->{"heating_system"})) $result->setHeatingSystem($values->{"heating_system"});
            if(isset($values->{"provider"})) $result->setProvider($values->{"provider"});
            if(isset($values->{"zipcode"})) $result->setZipcode($values->{"zipcode"});
            if(isset($values->{"monthlyFee"})) $result->setMonthlyfee($values->{"monthlyFee"});
            if(isset($values->{"name"})) $result->setName($values->{"name"});
            if(isset($values->{"mail"})) $result->setEmail($values->{"mail"});
            if(isset($values->{"phone"})) $result->setPhone($values->{"phone"});
            if(isset($values->{"surface"})) $result->setSurface($values->{"surface"});
            if(isset($values->{"received"})) $result->setReceived($values->{"received"});
            if(isset($values->{"monoConsumption"})) $result->setMonoConsumption($values->{"monoConsumption"});
            if(isset($values->{"dayConsumption"})) $result->setDayConsumption($values->{"dayConsumption"});
            if(isset($values->{"nightConsumption"})) $result->setNightConsumption($values->{"nightConsumption"});
            if(isset($values->{"gazConsumption"})) $result->setGazConsumption($values->{"gazConsumption"});

            return $result;
        }
    }
}