<?php
include(__DIR__ . "/db/db.php");

$post_title = '';
$post_content = '';
$post_category = '';
$post_image = '';
$post_comments = '';
$post_date = '';
$post_author = '';
$post_id = '';

$category_title = 'Cybersecurity';

$getPosts_query = "SELECT posts.*, users.username AS user_name, category.category_title
    FROM posts
    LEFT JOIN users ON posts.user_id = users.id
    LEFT JOIN category ON posts.category_id = category.id
    WHERE category_title=?";

$getPosts_stmt = $db->prepare($getPosts_query);
$getPosts_stmt->bind_param("s", $category_title);
$getPosts_stmt->execute();
$postsResult = $getPosts_stmt->get_result();

include('./components/navigation.php');
include('./components/content.php');
include('./components/sidebar.php');
include('./components/footer.php');
