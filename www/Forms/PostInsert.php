<?php
namespace App\Forms;

class PostInsert
{
    public function getConfig(): array
    {
      
        return [
            "config" => [
                "method" => "POST",
                "title" => "Rédiger un nouveau post",
                "action" => "post",
                "submit" => "Publier le post",
                "class" => "form"
            ],
            "input" => [
                "post-category" => [
                    "html" => "select",
                    "name" => "post-category",
                    "type" => "select",
                    "class" => "form-input",
                    "placeholder" => "Catégorie de post",
                    "required" => true,
                    "error" => "Cette catégorie de post n'existe pas",
                    "options" => [
                        "article" => [
                            "value" => "Article",
                            "label" => "Article"
                        ],
                        "event" => [
                            "value" => "Évènement",
                            "label" => "Évènement"
                        ]       
                    ]
                ],
                "title" => [
                    "html" => "input",
                    "name" => "title",
                    "type" => "text",
                    "class" => "form-input",
                    "placeholder" => "Titre du post",
                    "minlength" => 5, 
                    "required" => true,
                    "error" => "Le titre du post doit faire plus de 5 caractères"
                ],
                "image" => [
                    "html" => "input",
                    "name" => "post-image",
                    "type" => "file",
                    "accept" => "image/*",
                    "class" => "form-input",
                    "placeholder" => "choisissez une image",
                    "error" => "L'image doit être de type, jpg, png, webp ou gif"
                ],

                "content" => [
                    "content" => "tinymce.init({
                        selector: 'textarea',
                        plugins: 'tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
                        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                        tinycomments_mode: 'embedded',
                        tinycomments_author: 'Author name',
                        mergetags_list: [
                            { value: 'First.Name', title: 'First Name' },
                            { value: 'Email', title: 'Email' },
                        ],
                    });",
                    "html" => "textarea",
                    "name" => "post-content",
                    "type" => "textarea",
                    "class" => "form-input",
                    "placeholder" => "Rédigez votre post",
                    "required" => true,
                    "error" => "Le contenu du commentaire doit faire plus de 10 caractères"
                ],


                "city" => [
                    "html" => "input",
                    "name" => "event-city",
                    "type" => "text",
                    "class" => "form-input event-field",
                    "placeholder" => "Ville de l'événement",
                    "required" => true,
                    "error" => "La ville est requise pour un événement",
                    "data-show-for" => "event" 
                ],
                "place" => [
                    "html" => "input",
                    "name" => "event-place",
                    "type" => "text",
                    "class" => "form-input event-field",
                    "placeholder" => "Lieu de l'événement",
                    "required" => true,
                    "error" => "Le lieu est requis pour un événement",
                    "data-show-for" => "event"
                ],
                "date" => [
                    "html" => "input",
                    "name" => "event-date",
                    "type" => "date",
                    "class" => "form-input event-field",
                    "required" => true,
                    "error" => "La date est requise pour un événement",
                    "data-show-for" => "event"
                ],
                "userID" => [
                    "html" => "input",
                    "name" => "userId",
                    "type" => "hidden",
                    "value" => $_SESSION['userID'] ?? '',
                    "required" => true,
                ],
            ]
        ];
    }
}