<?php include("./reusableComponents/session.php"); ?>
<?php include("./reusableComponents/header.php");?>

<?php
// Include content based on the 'type' parameter
$type = isset($_GET['type']) ? $_GET['type'] : 'published';

if ($type === 'published') {
    include './postsComponents/published.php';
} elseif ($type === 'drafts') {
    include './postsComponents/drafts.php';
} elseif ($type === 'view') {
    include './postsComponents/view.php';
} elseif ($type === 'edit') {
    include './postsComponents/edit.php';
}  elseif ($type === 'delete') {
    include __DIR__ . '/reusableComponents/delete-modal.php';
} else {
    // Handle invalid type, redirect or display an error message
    echo 'Invalid type parameter.';
}
?>

<?php include './reusableComponents/footer.php'; ?>