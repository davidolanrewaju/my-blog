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
$totalPublishedPosts = "";
$publishedKeyword = "Publish";
$getTotalPublishedPosts_query = "SELECT COUNT(posts.id) AS total_posts
    FROM posts
    WHERE posts.user_id = ? AND posts.post_status = ?";
$getTotalPublishedPosts_stmt = $db->prepare($getTotalPublishedPosts_query);
$getTotalPublishedPosts_stmt->bind_param("is", $user_id, $publishedKeyword);
$getTotalPublishedPosts_stmt->execute();
$totalPublishedPostsResult = $getTotalPublishedPosts_stmt->get_result();

if ($totalPublishedPostsResult->num_rows > 0) {
    $totalPublishedPostsRow = $totalPublishedPostsResult->fetch_assoc();
    $totalPublishedPosts .= $totalPublishedPostsRow['total_posts'];
} else {
    $totalPublishedPosts = "No posts found for this user.";
}
$getTotalPublishedPosts_stmt->close();



// Query to get the total number of drafted posts for a specific user
$totalDraftedPosts = "";
$draftKeyword = "Draft";
$getTotalDraftedPosts_query = "SELECT COUNT(posts.id) AS total_posts
    FROM posts
    WHERE posts.user_id = ? AND posts.post_status = ?";
$getTotalDraftedPosts_stmt = $db->prepare($getTotalDraftedPosts_query);
$getTotalDraftedPosts_stmt->bind_param("is", $user_id, $draftKeyword);
$getTotalDraftedPosts_stmt->execute();
$totalDraftedPostsResult = $getTotalDraftedPosts_stmt->get_result();

if ($totalDraftedPostsResult->num_rows > 0) {
    $totalDraftedPostsRow = $totalDraftedPostsResult->fetch_assoc();
    $totalDraftedPosts .= $totalDraftedPostsRow['total_posts'];
} else {
    $totalDraftedPosts = "No posts found for this user.";
}

$getTotalDraftedPosts_stmt->close();