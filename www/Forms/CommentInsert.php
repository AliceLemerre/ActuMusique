<?php
namespace App\Forms;

class PostInsert
{
    public function getConfig(): array
    {
        if (!isset($_SESSION['userID'])) {
            return [
                "config" => [
                    "title" => "Vous devez être connnecté pour commenter",
                    "class" => "form"
                ],
                "input" => []
            ];
        }

        return [
            "config" => [
                "title" => "Rédiger un commentaire",
                "method" => "POST",
                "action" => "comment",
                "submit" => "Publier le commentaire",
                "class" => "form"
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
                    "name" => "comment-content",
                    "type" => "textarea",
                    "class" => "form-input",
                    "placeholder" => "Rédigez votre commentaire",
                    "required" => true,
                    "error" => "Le contenu du commentaire doit faire plus de 5 caractères"
                ],
        
        ];
    }
}