<?php
namespace App\Forms;
class UserInsert
{

    public function getConfig(): array
    {
        return [
            "config"=> [
                        "method"=>"POST",
                        "action"=>"register",
                        "submit"=>"S'inscrire",
                        "class"=>"card-form",
                        "id"=>"form-register"
                     ],
                    "button" => [
                        "submit" => "S'inscrire",
                        "class" => "button"
                    ],
            "input"=>[
                "username"=>[
                    "name"=>"username",
                    "type"=>"text", 
                    "class"=>"input-form" ,
                    "label"=>"Nom d'utilisateur",
                    "placeholder"=>"nom d'utilisateur", 
                    "minlength"=>4, 
                    "required"=>true, 
                    "error"=>"Le nom d'utilisateur doit faire plus de 4 caractères"
                ],
                "email"=>[
                    "name"=>"email",
                    "type"=>"email", 
                    "class"=>"input-form", 
                    "label"=>"Adresse mail",
                    "placeholder"=>"adresse mail", 
                    "required"=>true, 
                    "error"=>"Le format de l'email est incorrect"
                ],
                "password"=>[
                    "name"=>"password",
                    "type"=>"password", 
                    "class"=>"input-form", 
                    "label"=>"Mot de passe",
                    "placeholder"=>"mot de passe", 
                    "required"=>true, 
                    "error"=>"Votre mot de passe doit faire plus de 8 caractères"
                ],
                "passwordConfirm"=>[
                    "name"=>"passwordConfirm",
                    "type"=>"password", 
                    "class"=>"input-form", 
                    "confirm"=>"pwd", 
                    "label"=>"Confirmation du mot de passe",
                    "placeholder"=>"confirmation du mot de passe", 
                    "required"=>true, 
                    "error"=>"Vos mots de passe ne correspondent pas"
                ],
            ]
        ];
    }

}