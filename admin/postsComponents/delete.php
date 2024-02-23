<?php
include(__DIR__ . "/../../db/db.php");

$post_id = isset($_GET['post_id']) ? $_GET['post_id'] : null;

if (isset($post_id)) {
    // Perform the deletion in your database
    $deletePost_query = "DELETE FROM posts WHERE id = ?";
    $deletePost_stmt = $db->prepare($deletePost_query);
    $deletePost_stmt->bind_param("i", $post_id);
    $deletePost_stmt->execute();

    if (!$deletePost_stmt->errno) {
        // Redirect to a success page
        $status_message = 'Post deleted successfully';
         header("Location: ../success.php?status=" . urlencode($status_message));
        exit();
    }
    $deletePost_stmt->close();
}
