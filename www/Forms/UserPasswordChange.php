<?php

namespace App\Forms;

class UserChangePassword
{

    public function getConfig(): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "changepassword",
                "submit" => "Confirmer le nouveau mot de passe",
                "class" => "card-form"
            ],
            "input" => [
                "password" => [
                    "name" => "password",
                    "type" => "password",
                    "class" => "input-form",
                    "label" => "Nouveau mot de passe",
                    "placeholder" => "********",
                    "required" => true,
                    "error" => "Votre mot de passe doit faire plus de 8 caractères"
                ],
                "passwordconfirm" => [
                    "name" => "passwordconfirm",
                    "type" => "password",
                    "class" => "input-form",
                    "confirm" => "password",
                    "label" => "Confirmation du mot de passe",
                    "placeholder" => "********",
                    "required" => true,
                    "error" => "Vos mots de passe ne correspondent pas"
                ],
            ],
        ];
    }

}
