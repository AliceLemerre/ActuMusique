<?php

namespace App\Controllers;

use App\Core\Verificator;
use App\Core\View;
use App\Forms\DeleteAccountConfig;
use App\Forms\ResetConfig;
use App\Forms\UserChangePassword;
use App\Models\User as UserModel;
use App\Controllers\Security;

class User extends Security
{
    public function profile(): void
    {
        $this->checkAuthentification("/login");

        $user = new UserModel();
        $resetConfig = new ResetConfig();
        $resetAssign = $resetConfig->getConfig();

        $foundUser = $user->getOneBy(["email" => $_SESSION['email']], "object");

        $deleteConfig = new DeleteAccountConfig();
        $deleteAssign = $deleteConfig->getConfig($foundUser->getEmail());

        $myView = new View("User/profile", "front");
        $myView->assign("user", $foundUser);
        $myView->assign("resetAssign", $resetAssign);
        $myView->assign("deleteAssign", $deleteAssign);
    }

    public function resetpassword(): void
    {
        $this->checkAuthentification("/login");

        $security = new Security();
        $user = new UserModel();

        $codeVerification = $security->generateVerificationCode();

        $foundUser = $user->getOneBy(["email" => $_SESSION['email']], "object");
        $foundUser->setVerificationCode($codeVerification);
        $foundUser->save();

        $emailSent = $security->sendChangePasswordEmail($foundUser, $codeVerification);
        if ($emailSent) {
            header('Location: /profile');
            exit();
        }
    }

    public function changepassword(): void
    {
        $this->checkAuthentification("/login");

        $user = new UserModel();
        $userChangePassword = new UserChangePassword();
        $changePassword = $userChangePassword->getConfig();
        $errors = [];

        $foundUser = $user->getOneBy(["email" => $_SESSION['email']], "object");

        $email = $_GET['email'] ?? '';
        $code = $_GET['code'] ?? '';

        if ($email && $code && $email == $_SESSION['email'] && $code == $foundUser->getVerificationCode()) {
            $_SESSION['verified'] = true;
        }


        if ($_SERVER['REQUEST_METHOD'] == $changePassword['config']['method'] && empty($errors) && isset($_SESSION['verified']) && $_SESSION['verified']) {
            $verificator = new Verificator();
            if ($verificator->checkForm($changePassword, $_REQUEST, $errors)) {
                foreach ($_REQUEST as $key => $value) {
                    $setterMethod = 'set' . ucfirst($key);
                    if (method_exists($foundUser, $setterMethod)) {
                        $foundUser->$setterMethod($value);
                    }
                }
                $foundUser->save();
                header("Location: /profile");
                exit();
            }
        }

        $myView = new View("User/changepassword", "front");
        $myView->assign("configForm", $changePassword);
        $myView->assign("errorsForm", $errors);
    }

    public function hardelete(): void
    {

        $this->checkAuthentification("/login");

        $user = new UserModel();
        $foundUser = $user->getOneBy(["email" => $_SESSION['email']], "object");

        if ($foundUser && isset($_GET['delete']) && $_GET['delete'] == "true") {
            $delete = $_GET['delete'];
            if ($delete == "true") {
                $idUser = $foundUser->getId();
                $foundUser->delete($idUser);
                header("Location: /register");
                exit();
            }
        } elseif ($foundUser && isset($_GET['delete']) && $_GET['delete'] == "false") {
            header("Location: /profile");
            exit();
        }
        $myView = new View("User/hardelete", "front");
    }

    public function listUsers()
    {
        $myView = new View("User/listuser", "back");
    }
}
