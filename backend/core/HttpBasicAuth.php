<?php

namespace Core;

use Model\Model\UserQuery;
use Slim\Middleware\HttpBasicAuthentication\AuthenticatorInterface;

class HttpBasicAuthenticator implements AuthenticatorInterface {
    public function __invoke(array $arguments) {
        $query = new UserQuery();
        $user = $query->findByUser($arguments["user"])->getFirst();
        if($user == null) return false;
        if($user->getIsEnabled() == false) return false;
        $_SESSION["user"] = $user->getUser();
        $_SESSION["userId"] = $user->getId();
        $_SESSION["isAdmin"] = $user->getIsadmin();
        $user->setLastConnection(date("Y-m-d h:i:s"));
        $user->save();
        return password_verify($arguments["password"], $user->getPassword());
    }
}

class HttpBasicAuthenticatorWithAdminPriviliege implements AuthenticatorInterface {
    public function __invoke(array $arguments) {
        $query = new UserQuery();
        $user = $query->findByUser($arguments["user"])->getFirst();
        if($user == null) return false;
        if($user->getIsEnabled() == false) return false;
        $_SESSION["user"] = $user->getUser();
        $_SESSION["userId"] = $user->getId();
        $_SESSION["isAdmin"] = $user->getIsadmin();
        $user->setLastConnection(date("Y-m-d h:i:s"));
        $user->save();
        return (password_verify($arguments["password"], $user->getPassword())) && $user->getIsadmin();
    }
}