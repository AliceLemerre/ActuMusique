<?php

namespace App\Core;

class Verificator
{

    public function checkFormWithFiles($config, $data, $file, &$errors): bool
    {
        if (count($config['input']) != (count($data) + count($file))) {
            die("Tentative de Hack");
        } else {
            foreach ($config['input'] as $name => $input) {
                if ($input["name"] == "image" && !self::checkImageProject($file['image']['full_path'])) {
                    $errors[] = "image invalide";
                }
                if ($input["name"] == "title" && !self::checkProjectTitle($data['title'])) {
                    $errors[] = "titre invalide";
                }
                if ($input["name"] == "category" && !self::checkProjectCategory($data['category'])) {
                    $errors[] = "caégorie invalide";
                }
                if ($input["name"] == "description" && !self::checkPageDescription($data['description'])) {
                    $errors[] = "description invalide";
                }
                if ($input["name"] == "content" && !self::checkPageDescription($data['description'])) {
                    $errors[] = "contenu invalide";
                }
            }
        }
        return empty($errors);
    }


    public function checkForm($config, $data, &$errors): bool
    {
        if(count($config["input"]) != count($data))
        {
            die("Tentative de Hack");
        }else{
            foreach ($config["input"] as $name=>$input){
                if(!isset($data[$name])){
                    die("Tentative de Hack");
                }
                if($input["type"]=="email" && !self::checkEmail($data[$name])){
                    $errors[]="Email incorrect";
                }
                if (isset($input["name"]) && $input["name"] == "username" && !self::checkUsername($data[$name], $config['input'][$name])) {
                    $errors[] = "Nom d'utilisateur incorrect";
                }
                if ($input["type"] == "password" && !self::checkPassword($data[$name])) {
                    $errors[] = "Mot de passe incorrect";
                }
                if (isset($input["name"]) && $input["name"] == "passwordconfirm" && !self::checkPasswordConfirmation($data['password'], $data[$name])) {
                    $errors[] = "Les mots de passe ne correspondent pas";
                }
            }

        }

        return empty($errors);
    }



    public static function checkEmail(String $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function checkUsername(String $username, array $config): bool
    {
    return (
        strlen($username) >= $config['minlength']
    );
    }

    public static function checkPassword(String $password): bool
    {
        return (
            strlen($password) >= 8 &&
            preg_match("#[a-z]#", $password) &&
            preg_match("#[A-Z]#", $password) &&
            preg_match("#[0-9]#", $password)
        );
    }

    public static function checkPasswordConfirmation(String $password, string $passwordConfirmation): bool
    {
        return (
            $password === $passwordConfirmation
        );
    }

    public function checkImageProject($image)
    {
        $uploadDirectory = "uploads/";
        $fileName = basename($image);
        $targetFilePath = $uploadDirectory . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $allowedTypes = array("jpg", "jpeg", "png", "gif");
        if (!in_array($fileType, $allowedTypes)) {
            return false;
        }
        return true;
    }

    public function checkProjectTitle($title)
    {
        return (
            strlen($title) >= 5 &&
            preg_match("#[a-z]#", $title) &&
            preg_match("#[A-Z]#", $title)
        );
    }

    public function checkProjectCategory($title)
    {
        return (
            strlen($title) >= 5 &&
            preg_match("#[a-z]#", $title) &&
            preg_match("#[A-Z]#", $title)
        );
    }

    public function checkPageDescription($description)
    {
        return (
            strlen($description) >= 5
        );
    }

    public function checkPortfolio($config, $data, &$errors): bool
    {
        if (count($config['input']) != count($data)) {
            die("Tentative de Hack");
        } else {
            foreach ($config['input'] as $name => $input) {
                if (!isset($data[$name])) {
                    die();
                }
                if ($input["type"] == "text" && !self::checkPortfolioName($data[$name])) {
                    $errors[] = "Nom de Portfolio incorrect";
                }

                if ($input["type"] == "text" && !self::checkPortfolioCategory($data[$name])) {
                    $errors[] = "Catégorie de Portfolio incorrect";
                }
            }
        }
        return empty($errors);
    }
   
    public static function checkFirstname(string $firstname, array $config): bool
    {
        return (
            strlen($firstname) >= $config['minlength']
        );
    }

    public static function checkLastname(string $lastname, array $config): bool
    {
        return (
            strlen($lastname) >= $config['minlength']
        );
    }

    public static function checkPasswordConfirm(string $password, string $passwordConfirm): bool
    {
        return (
            $password === $passwordConfirm
        );
    }
    public static function checkPortfolioName(string $name): bool
    {
        return (
            strlen($name) >= 8
        );
    }

    public static function checkPortfolioCategory(string $category): bool
    {
        return (
            strlen($category) >= 2 &&
            $category === "Photographie" || $category === "Peinture"
        );
    }

}//check titre article
//check contenu article
//check article
//check contenu commentaire
