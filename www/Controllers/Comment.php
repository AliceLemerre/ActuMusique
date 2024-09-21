<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\DB;
use App\Core\Verificator;
use App\Forms\CommentInsert;
use App\Models\Comment as CommentModel;
use App\Controllers\Security;
use App\Forms\CommentUpdate;


class Comment extends Security
{



    public function createComment(): void
    {
        $this->checkAuthentification("/login");

        $createComment = new CommentInsert();
        $configComment = $createComment->getConfig();
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] == $configComment['config']['method'] && empty($errors)) {
            $validator = new Verificator();
            if ($validator->checkForm($configComment, $_REQUEST, $errors)) {
                $comment = new CommentModel;
                foreach ($_REQUEST as $key => $value) {
                    $setterMethod = 'set' . ucfirst($key);
                    if (method_exists($comment, $setterMethod)) {
                        $comment->$setterMethod($value);
                    }
                }
                $comment->setUserId($_SESSION['userID']);
                $comment->setPostId($_SESSION['postID']);
                $comment->save();
                header("Location: /Post?id=" . $comment->getPostId());
                exit();
            }
        }

        $myView = new View("Comment/comment", "front");
        $myView->assign("createComment", $configComment);
        $myView->assign("errorsForm", $errors);
    }

    public function viewComment()
    {
        $this->checkAuthentification("/");

        $id = $_GET['id'];

        $myView = new View("Comment/viewComment", "front");

        $comment = new CommentModel;
        $myComment = $comment->getOneById($id, 'object');
        $myView->assign("comment", $myComment);
    }


    public function updateComment()
    {
        $this->checkAuthentification("/login");

        $updateComment = new CommentUpdate();
        $configComment = $updateComment->getConfig();
        $errors = [];


        if ($_SERVER['REQUEST_METHOD'] == $configComment['config']['method'] && empty($errors)) {
            $validator = new Verificator();

            if ($validator->checkForm($configComment, $_REQUEST, $_FILES, $errors)) {
                $comment = new CommentModel;

                foreach ($_REQUEST as $key => $value) {
                    $setterMethod = 'set' . ucfirst($key);
                    if (method_exists($comment, $setterMethod)) {
                        $comment->$setterMethod($value);
                    }
                }


                $comment->setPostId($_SESSION['postID']);
                $comment->setUserId($_SESSION['userID']);
                $comment->setId($_SESSION['commentID']);

                $comment->save();

                header("Location: /Post?id=" . $_SESSION['postID']);
                exit();
            }
        }

        $myView = new View("Comment/updateComment", "front");
        $myView->assign("updateComment", $configComment);
        $myView->assign("errorsForm", $errors);
    }

    public function deleteComment()
    {
        $security = new Security();
        $isAdmin = $security->checkAuthentification('/');
        if ($isAdmin == "admin") {

            if (isset($_GET['id'])) {
                $idToDelete = $_GET['id'];

                $commentModel = new CommentModel();
                $commentModel->delete($idToDelete);

                header('Location: /commentList');
                exit;
            } else {
                echo "ID du commentaire non spécifié";
                exit;
            }
        } else {
            header('location:/login');
            exit();
        }
    }

    public function listComments(): void
    {
        $security = new Security();
        $isAdmin = $security->checkAuthentification('/');
        if ($isAdmin == "admin") {
            $commentModel = new CommentModel;
            $comments = $commentModel->getCommentNotValidated();

            $myView = new View("Comment/CommentsList", "back");
            $myView->assign("comments", $comments);
        } else {
            header('location:/login');
            exit();
        }
    }

    public function validateComment()
    {
        $security = new Security();
        $isAdmin = $security->checkAuthentification('/');
        if ($isAdmin == "admin") {
            if (isset($_GET['id'])) {
                $commentIdToValidate = $_GET['id'];

                $commentModel = new CommentModel();
                $commentModel->validateCommentById($commentIdToValidate);

                header('Location: /commentList');
                exit;
            } else {
                echo "ID du commentaire non spécifié";
                exit;
            }
        } else {
            header('location:/login');
            exit();
        }
    }
}
