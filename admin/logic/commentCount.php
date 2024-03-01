<?php
include("../db/db.php");

// Get username from session.php: ($user)
//Use username to get user_id from users table
//Query to get user_id
$user_id = "";
if (isset($user)) {
    $getUserId_query = "SELECT id FROM users WHERE username=?";
    $getUserId_stmt = $db->prepare($getUserId_query);
    $getUserId_stmt->bind_param("s", $user);
    $getUserId_stmt->execute();
    $getUserIdResult = $getUserId_stmt->get_result();

    if ($getUserIdResult->num_rows > 0) {
        $userIdRow = $getUserIdResult->fetch_assoc();
        $user_id .= $userIdRow['id'];
    }
    $getUserIdResult->close();
}

// Query to get the total number of published posts for a specific user
$totalComments = "";

$getTotalComments_query = "SELECT COUNT(comments.id) AS total_posts
    FROM comments
    LEFT JOIN posts ON comments.post_id = posts.id
    LEFT JOIN users ON comments.user_id = users.id
    WHERE posts.user_id = ?";

$getTotalComments_stmt = $db->prepare($getTotalComments_query);
$getTotalComments_stmt->bind_param("i", $user_id);
$getTotalComments_stmt->execute();
$totalCommentsResult = $getTotalComments_stmt->get_result();

if ($totalCommentsResult->num_rows > 0) {
    $totalCommentsRow = $totalCommentsResult->fetch_assoc();
    $totalComments .= $totalCommentsRow['total_posts'];
} else {
    $totalComments = "No posts found for this user.";
}
$getTotalComments_stmt->close();



//Update posts table to handle comments count
$updateCommentCount = 'UPDATE posts SET post_comments_count = (
    SELECT COUNT(comments.id) 
    FROM comments 
    WHERE comments.post_id = posts.id
    )';

$updateCommentCount_stmt = $db->prepare($updateCommentCount);
$updateCommentCount_stmt->execute();
$updateCommentCount_stmt->close();