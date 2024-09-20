<?php

namespace App\Core;

class Verify
{

    private array $data;
    protected array $errors = [];
    private array $erreur = [];



    public function __construct($configForm, $data)
    {
        $this->data = $data;
        foreach($configForm["inputs"] as $name=>$configInput){
            if(!empty($configInput["email"])){
                $this->isEmail($name);
            }
            if(!empty($configInput["password"])){
                $this->isPassword($name);
            }
            if(!empty($configInput["minLength"])){
                $this->isMinLength($name, $configInput["minLength"]);
            }
            if(!empty($configInput["maxLength"])){
                $this->isMaxLength($name, $configInput["maxLength"]);
            }
        }

    }

    public function isEmail(string $key): self
    {
        if (!filter_var($this->data[$key], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$key] = "Le format de l'email est incorrect";
        }
        return $this;
    }

    public function isPassword(string $key): self
    {
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $this->data[$key])) {
            $this->errors[$key] = "Votre mot de passe doit faire plus de 8 caractères avec minuscule et chiffre";
        }
        return $this;
    }
    public function isMinLength(string $key, int $min): self
    {
        if (strlen($this->data[$key]) < $min) {
            $this->errors[$key] = "Le champs ".$key." doit faire plus de ".$min." caractères";
        }
        return $this;
    }
    public function isMaxLength(string $key, int $max): self
    {
        if (strlen($this->data[$key]) > $max) {
            $this->errors[$key] = "Le champs ".$key." doit faire moins de ".$max." caractères";
        }
        return $this;
    }

}