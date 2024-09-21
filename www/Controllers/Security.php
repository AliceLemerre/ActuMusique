<?php

namespace App\Controllers;
use App\Core\Verificator;
use App\Core\View;
use App\Models\User;
use App\Forms\UserInsert;
use App\Forms\UserLogin;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

        if ($_SERVER["REQUEST_METHOD"] == $configLogin["config"]["method"]) {
            $verificator = new Verificator();
            if ($verificator->checkForm($configLogin, $_REQUEST, $errors)) {
                $user = new User();
                $userFromDb = $user->getOneBy(["email" => $_REQUEST['email']], "object");
                if ($userFromDb && password_verify($_REQUEST['password'], $userFromDb->getPassword())) {
                    $_SESSION['userID'] = $userFromDb->getId();
                    $_SESSION['email'] = $userFromDb->getEmail();
                    $_SESSION['username'] = $userFromDb->getUsername();
                    $_SESSION['role'] = $userFromDb->getRole();
                    $_SESSION['message'] = "You have been successfully logged in.";
                    header("Location: /");
                    exit();
                } else {
                    echo "Identifiant ou mot de passe incorrect";
                    exit;
                }
            }
        }
     

        $myView = new View("Security/login", "front");
        $myView->assign("configFormLogin", $configLogin);
        $myView->assign("errorsForm", $errors); 
    }

    public function logout(): void
    {
        session_destroy();
        session_start();
        $_SESSION['message'] = "You have been successfully logged out.";
        header("Location: /");
        exit();
    }

    public function register(): void
    {
        $form = new UserInsert();
        $config = $form->getConfig();
        $errors = [];

        if ($_SERVER["REQUEST_METHOD"] == $config["config"]["method"]) {
            $verificator = new Verificator();
            if ($verificator->checkForm($config, $_REQUEST, $errors)) {
                $user = new User();
                $user->setUsername($_REQUEST['username']);
                $user->setEmail($_REQUEST['email']);
                $user->setPassword(password_hash($_REQUEST['password'], PASSWORD_DEFAULT));
                $user->setEmailConfirmation(false);
                $user->setResetPassword(false);
                $verificationCode = $this->generateVerificationCode();
                $user->setVerificationCode($verificationCode);
                
                if ($this->firstUserIsAdmin()) {
                    $user->setRole(0); // Super admin
                } else {
                    $user->setRole(2); //  user
                }

                $user->save();

                $_SESSION['userID'] = $user->getId();
                $_SESSION['email'] = $user->getEmail();
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['role'] = $user->getRole();

                $_SESSION['message'] = "Votre compte a été créé avec succès.";
                
                $this->sendVerificationEmail($user, $verificationCode);

                header("Location: /dashboard");
                exit();
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
            $mail->Username = 'actumusique09@gmail.com';
            $mail->Password = '@ctumusique04';
            $mail->SMTPSecure = 'tls';
            $mail->setFrom('actumusique09@gmail.com', 'ActuMusique');
            $mail->addAddress($user->getEmail(), $user->getUsername());

            $mail->Subject = "Vérification de votre compte";
            $mail->Body = "Bonjour " . $user->getUsername() . ",\n\n";
            $mail->Body .= "Merci de cliquer sur le lien pour vérifier votre compte : ";
            $mail->Body .= "http://128.199.45.92/verify?code=" . $verificationCode . "&email=" . $user->getEmail();

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
            $mail->Username = 'actumusique09@gmail.com';
            $mail->Password = '@ctumusique04';
            $mail->SMTPSecure = 'tls';
            $mail->setFrom('lemerre.alice@gmail.com', 'ActuMusique');
            $mail->addAddress($user->getEmail(), $user->getUsername());

            $mail->Subject = "Changement de mot de passe";
            $mail->Body = "Bonjour " . $user->getUsername() . ",\n\n";
            $mail->Body .= "Si vous avez demandé un changement de mot de passe cliquez sur ce lien : ";
            $mail->Body .= "http://128.199.45.92/changepassword?code=" . $verificationCode . "&email=" . $user->getEmail();

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
            $_SESSION['message'] = "Your email has been verified successfully.";
            header("Location: /dashboard");
            exit();
        } else {
            $_SESSION['message'] = "Invalid verification link.";
            header("Location: /");
            exit();
        }
    }
}