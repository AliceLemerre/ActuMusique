<?php

namespace App\Controllers;

use App\Core\View;
use App\Forms\PostInsert;
use App\Core\Verificator;
use App\Models\Post as PostModel;
use App\Models\User as UserModel;
use App\Controllers\Security;

class Post extends Security
{
    public function createPost(): void
    {
        $security = new Security();
        // For now, we'll assume the user is logged in and has a valid session
        // In the future, uncomment these lines for proper authentication
        // $isAdmin = $security->checkAuthentification('/');
        // if ($isAdmin == "admin") {

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
                    // Check if user exists in the database
                    $userModel = new UserModel();
                    $user = $userModel->getOneBy(['id' => $userId]);
                    if (!$user) {
                        $errors[] = "Invalid user ID. User does not exist.";
                    } else {
                        $post->setUserId($userId);
                    }
                }

                if (empty($errors)) {
                    // Collect form data
                    $post->setCategory($_POST['post-category']);
                    $post->setTitle($_POST['title']);
                    $post->setContent($_POST['post-content']);

                    // Handle event-specific fields
                    if ($_POST['post-category'] == 'Évènement') {
                        $post->setCity($_POST['event-city'] ?? '');
                        $post->setPlace($_POST['event-place'] ?? '');
                        $post->setDate($_POST['event-date'] ?? date('Y-m-d'));
                    }
                    
                    // Handle image upload
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
                                $errors[] = "Sorry, there was an error uploading your file.";
                            }
                        } else {
                            $errors[] = "Sorry, only JPG, JPEG, PNG, GIF, and WEBP files are allowed.";
                        }
                    }
                    
                    // If no errors, save to database
                    if (empty($errors)) {
                        try {
                            $post->save();
                            // Redirect on success
                            header("Location: /posts");
                            exit();
                        } catch (\Exception $e) {
                            $errors[] = "Failed to save the post: " . $e->getMessage();
                        }
                    }
                }
            }
        }
        
        // If we reach here, either it's a GET request or there were errors
        $myView = new View("Post/createpost", "front");
        $myView->assign("createPost", $configPost);
        $myView->assign("errorsForm", $errors);
        
        // Uncomment this when ready to implement authentication
        // } else {
        //     header('location:/login');
        //     exit();
        // }
    }

    // ... (rest of the class remains the same)
}