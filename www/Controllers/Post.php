<?php

namespace App\Controllers;

use App\Core\View;
use App\Forms\PostInsert;
use App\Core\Verificator;
use App\Models\Post as PostModel;
use App\Models\User as UserModel;
use App\Controllers\Security;
use App\Core\DB;

class Post extends Security
{
    public function createPost(): void
    {
        $security = new Security();
        // $isAdmin = $security->checkAuthentification('/');
        // if ($isAdmin == "admin") {

        $createPost = new PostInsert();
        $configPost = $createPost->getConfig();
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] == $configPost['config']['method']) {
            $verificator = new Verificator();
            if ($verificator->checkFormWithFiles($configPost, $_POST, $_FILES, $errors)) {
                $post = new PostModel();
                
                $userId = $_SESSION['userID'] ?? null;
                if (!$userId) {
                    $errors[] = "User ID not found in session. Please log in.";
                } else {
                    $userModel = new UserModel();
                    $user = $userModel->getOneBy(['id' => $userId]);
                    if (!$user) {
                        $errors[] = "Invalid user ID. User does not exist.";
                    } else {
                        $post->setUserId($userId);
                    }
                }

                if (empty($errors)) {
                    $post->setCategory($_POST['post-category']);
                    $post->setTitle($_POST['title']);
                    $post->setContent($_POST['post-content']);

                    if ($_POST['post-category'] == 'Évènement') {
                        $post->setCity($_POST['event-city'] ?? '');
                        $post->setPlace($_POST['event-place'] ?? '');
                        $post->setDate($_POST['event-date'] ?? date('Y-m-d'));
                    }
                    
                    if (isset($_FILES['post-image']) && $_FILES['post-image']['error'] == 0) {
                        $uploadDirectory = "uploads/";
                        $fileName = uniqid() . '_' . basename($_FILES['post-image']['name']);
                        $targetFilePath = $uploadDirectory . $fileName;
                        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                        $allowedTypes = array("jpg", "jpeg", "png", "gif", "webp");
                        
                        if (in_array(strtolower($fileType), $allowedTypes)) {
                            if (move_uploaded_file($_FILES["post-image"]["tmp_name"], $targetFilePath)) {
                                $post->setImage($fileName);
                            } else {
                                $errors[] = "Erreur pendant l'upload de l'image.";
                            }
                        } else {
                            $errors[] = "Formats autorisés : JPG, JPEG, PNG, GIF, et WEBP.";
                        }
                    }
                    
                    if (empty($errors)) {
                        try {
                            $post->save();
                            header("Location: /");
                            exit();
                        } catch (\Exception $e) {
                            $errors[] = "échec de récupération du post: " . $e->getMessage();
                        }
                    }
                }
            }
        }
        
        $myView = new View("Post/create-post", "front");
        $myView->assign("createPost", $configPost);
        $myView->assign("errorsForm", $errors);
        
        // } else {
        //     header('location:/login');
        //     exit();
        // }
    }

    public function listPosts(): void
    {
      //  $security = new Security();
     //   $isAdmin = $security->checkAuthentification('/');
      //  if ($isSuperAdmin == "superAdmin") {

            $postModel = new PostModel;
            $posts = $postModel->getAllData();

            $myView = new View("Dashboard/dashboard-posts", "back");
            $myView->assign("posts", $posts);

            
       // } else {
        //    header('location:/login');
        //    exit();
      //  }
    }

    public function deletePosts()
    {
        $security = new Security();
        $isAdmin = $security->checkAuthentification('/');
        if ($isSuperAdmin == "superAdmin") {

            if (isset($_GET['id'])) {
                $idToDelete = $_GET['id'];

                $projectModel = new PostModel();
                $projectModel->delete($idToDelete);

                header('Location: /projectList');
                exit;
            } else {
                echo "ID du projectaire non spécifié";
                exit;
            }
        } else {
            header('location:/login');
            exit();
        }
    }}
