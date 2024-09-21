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
    $createPost = new PostInsert();
    $configPost = $createPost->getConfig();
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] == $configPost['config']['method']) {
        $verificator = new Verificator();
        if ($verificator->checkFormWithFiles($configPost, $_POST, $_FILES, $errors)) {
            $post = new PostModel();
            
            // Validate user ID
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
                error_log("Form data: " . print_r($_POST, true));
                
                $post->setCategory((int)$_POST['post-category']);  // Convert to int
                $post->setTitle($_POST['title']);
                $post->setContent($_POST['post-content']);

                if ($_POST['post-category'] == '2') {  // Assuming 2 is the category ID for 'Évènement'
                    $post->setCity($_POST['event-city'] ?? '');
                    $post->setPlace($_POST['event-place'] ?? '');
                    $post->setDate($_POST['event-date'] ?? date('Y-m-d'));
                }
                
                if (isset($_FILES['post-image']) && $_FILES['post-image']['error'] == 0) {
                }
                $post->setViews(0);
                $post->setLikes(0);
                
                if (empty($errors)) {
                    try {
                        $post->save();
                        error_log("Post saved successfully. Post ID: " . $post->getId());
                        header("Location: /");
                        exit();
                    } catch (\Exception $e) {
                        error_log("Exception when saving post: " . $e->getMessage());
                        $errors[] = "Failed to save the post: " . $e->getMessage();
                    }
                }
            }
        } else {
            error_log("Form validation failed. Errors: " . print_r($errors, true));
        }
    }
    
    $myView = new View("Post/createpost", "front");
    $myView->assign("createPost", $configPost);
    $myView->assign("errorsForm", $errors);
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
