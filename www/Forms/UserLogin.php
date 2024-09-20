<?php
namespace App\Forms;
class UserLogin
{

    public function getConfig(): array
    {
        return [
            "config"=> [
                        "method"=>"POST",
                        "action"=>"login",
                        "submit"=>"Se connecter",
                        "class"=>"card-form",
                        "id"=>"form-login"
            ],
            "input"=>[
                "email"=>[
                    "type"=>"email", 
                    "class"=>"input-form", 
                    "label"=>"Adresse mail",
                    "placeholder"=>"adresse mail", 
                    "required"=>true, 
                    "error"=>"Le format de l'email est incorrect"
                ],
                "password"=>[
                    "type"=>"password",
                    "class"=>"input-form",
                    "label"=>"Mot de passe",
                    "placeholder"=>"mot de passe",
                    "required"=>true,
                    "error"=>"Votre mot de passe doit faire plus de 8 caractères avec minuscule et chiffre"
                ],
            ]
        ];
    }

}