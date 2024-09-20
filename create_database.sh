#! /bin/bash


if [ $# -gt 0 ]; then
    echo "POSTGRES_USER=$1" > temp_env
    echo "POSTGRES_PASSWORD=$2" >> temp_env
    sed -i '/^POSTGRES_USER=/d' .env
    sed -i '/^POSTGRES_PASSWORD=/d' .env
    sed -i '/^POSTGRES_USER=/d' www/Core/.env
    sed -i '/^POSTGRES_PASSWORD=/d' www/Core/.env
    cat temp_env >> www/Core/.env
    cat temp_env >> .env
    rm temp_env
else
    while true; do
        echo "1) Voici les étapes pour mettre en route le site"
        echo "2) Créer le combo user/password de la base de donnée"
        echo "3) Renseigner les valeurs d'un serveur"
        echo "4) Quitter"

        read -p "Entrer votre choix :" choice

        if [ ! -f .env ]; then
            touch .env
        fi

        if [ "$choice" -eq 1 ]; then
            echo
            echo "D'abord créez le combo user/password de la base de donnée"
            echo
            echo "Ensuite pour lancer le site en local : docker compose up -d --build"
            echo
            echo "Lancez le site sur le localhost"
            echo
            echo "Pour le mettre en production :"
            echo
            echo "Renseigner les valeurs d'un serveur"
            echo
            echo "Lancer le script deploy_script"
            echo
            echo
        elif [ "$choice" -eq 2 ]; then
            read -p "Entrez le nom d'utilisateur PostgreSQL : " username
            read -sp "Entrez le mot de passe PostgreSQL : " password
            echo "POSTGRES_USER=$username" > temp_env
            echo "POSTGRES_PASSWORD=$password" >> temp_env
            sed -i '/^POSTGRES_USER=/d' .env
            sed -i '/^POSTGRES_PASSWORD=/d' .env
            sed -i '/^POSTGRES_USER=/d' www/Core/.env
            sed -i '/^POSTGRES_PASSWORD=/d' www/Core/.env
            cat temp_env >> www/Core/.env
            cat temp_env >> .env
            rm temp_env
            echo
            echo "Les variables d'environnement ont été écrites dans le fichier .env."
            echo
        elif [ "$choice" -eq 3 ]; then
            read -p "Entrez l'ip du serveur : " remote_ip
            read -sp "Entrez le password du serveur : " remote_password
            echo "REMOTE_IP=$remote_ip" > temp_env
            echo "REMOTE_PASSWORD=$remote_password" >> temp_env
            sed -i '/^REMOTE_IP=/d' .env
            sed -i '/^REMOTE_PASSWORD=/d' .env
            sed -i '/^REMOTE_IP=/d' www/Core/.env
            sed -i '/^REMOTE_PASSWORD=/d' www/Core/.env
            cat temp_env >> www/Core/.env
            cat temp_env >> .env
            rm temp_env
            echo
            echo "Les variables d'environnement ont été écrites dans le fichier .env."
            echo
        elif [ "$choice" -eq 4 ]; then
            echo
            echo "Au revoir !"
            echo
            break
        else
            echo
            echo "Choix invalide. Veuillez entrer 1, 2 ou 3."
            echo
        fi
    done;
fi