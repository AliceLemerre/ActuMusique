<?php

namespace App\Controllers;
use App\Core\Verificator;
use App\Core\View;
use App\Models\User;
use App\Forms\UserInsert;
use App\Forms\UserLogin;
use PHPMailer\PHPMailer\PHPMailer;

class Security
{

    public function checkAuthentification(string $return): string
    {
        $security = new Security();
        if (!$security->isAuthentificated() && $return == "/login") {
            header('Location: /login');
            exit;
        }
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['email']) && $this->isAdmin($_SESSION['email'])) {
            return "admin";
        } elseif ($this->isAuthentificated() && !$this->isAdmin($_SESSION['email'])) {
            return "user";
        } else {
            return "visitor";
        }
    }

    public function isAuthentificated(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION['userID']);
    }

    public function isAdmin(string $email): bool
    {
        $user = new User();
        $isAdmin = $user->isAdmin($email);
        return $isAdmin;
    }

    public function isVisitor(): bool
    {
        $isAuth = $this->isAuthentificated();

        if ($isAuth) {
            return false;
        }

        return true;
    }


    public function login(): void
    {
        $formLogin = new UserLogin();
        $configLogin = $formLogin->getConfig();
        $errors = [];



        $myView = new View("Security/login", "front");
        $myView->assign("configFormLogin", $configLogin);
        $myView->assign("errorsForm", $errors); 
    }
    public function logout(): void
    {
        $myView = new View("Security/logout", "front");
    }
    public function register(): void
    {
        $form = new UserInsert();
        $config = $form->getConfig();

        $errors = [];

        // Est ce que le formulaire a été soumis
        if( $_SERVER["REQUEST_METHOD"] == $config["config"]["method"] )
        {
            // Ensuite est-ce que les données sont OK
            $verificator = new Verificator();
            if($verificator->checkForm($config, $_REQUEST, $errors)){
                $user = new \App\Models\User();
                $user->setUsername($_REQUEST['username']);
                $user->setEmail($_REQUEST['email']);
                $user->setPassword($_REQUEST['password']);
                $user->save();
            }
        }

        $myView = new View("Security/register", "front");
        $myView->assign("configForm", $config);
        $myView->assign("errorsForm", $errors);

    }

    public function generateVerificationCode(): string
    {
        return uniqid();
    }

    public function isExistAlready(string $email): void
    {
        $existingUser = User::populate($email);
        if (!empty($existingUser)) {
            header('Location: /login');
            exit();
        }
    }

    public function firstUserIsAdmin(): bool
    {
        $user = new User();
        if ($user->count() == 0) {
            return true;
        } else {
            return false;
        }
    }


    private function sendVerificationEmail(User $user, string $verificationCode): bool
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->Username = 'pierregueitdessus@gmail.com';
            $mail->Password = 'osgg kuxx dvli pezc';
            $mail->SMTPSecure = 'tls';
            $mail->setFrom('pierregueitdessus@gmail.com', 'OpenCMF');
            $mail->addAddress($user->getEmail(), $user->getFirstname());

            $mail->Subject = "Vérification de votre compte";
            $mail->Body = "Bonjour " . $user->getFirstname() . ",\n\n";
            $mail->Body .= "Merci de cliquer sur le lien suivant pour vérifier votre compte : ";
            $mail->Body .= "http://5.250.178.213/verify?code=" . $verificationCode . "&email=" . $user->getEmail();

            $mail->send();
            return true;
        } catch (Exception $e) {
            echo 'Erreur lors de l\'envoi de l\'e-mail : ', $mail->ErrorInfo;
            return false;
        }
    }

    public function sendChangePasswordEmail(User $user, string $verificationCode): bool
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->Username = 'pierregueitdessus@gmail.com';
            $mail->Password = 'osgg kuxx dvli pezc';
            $mail->SMTPSecure = 'tls';
            $mail->setFrom('pierregueitdessus@gmail.com', 'OpenCMF');
            $mail->addAddress($user->getEmail(), $user->getFirstname());

            $mail->Subject = "Changement de mot de passe";
            $mail->Body = "Bonjour " . $user->getFirstname() . ",\n\n";
            $mail->Body .= "Si vous avez demander un changement de mot de passe cliquez sur ce lien : ";
            $mail->Body .= "http://5.250.178.213/changepassword?code=" . $verificationCode . "&email=" . $user->getEmail();

            $mail->send();
            return true;
        } catch (Exception $e) {
            echo 'Erreur lors de l\'envoi de l\'e-mail : ', $mail->ErrorInfo;
            return false;
        }
    }

    public function verify(): void
    {
        $request = $_REQUEST;
        $user = new User();
        $userGetByEmail = $user->getOneBy(["email" => $request['email']], "object");
        if (!empty($userGetByEmail) && $userGetByEmail->getVerificationCode() == $request['code'] && $userGetByEmail->getEmail() == $request['email']) {
            $userGetByEmail->setEmailconfirmation(1);
            $userGetByEmail->save();
            session_start();
            $_SESSION['userID'] = $userGetByEmail->getId();
            $_SESSION['email'] = $userGetByEmail->getEmail();
            header("Location: /portfolio");
            exit();
        }
    }



}