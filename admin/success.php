<?php include("./reusableComponents/session.php"); ?>
<?php $status_message = isset($_GET['status']) ? urldecode($_GET['status']) : 'Operation completed successfully.';?>
<?php include './reusableComponents/header.php'; ?>

<div class="success-container">
    <div class="success-content">
        <img src="../admin/css/assets/success.png" alt="" width="100" height="100">
        <p><?php echo $status_message; ?></p>
    </div>
</div>


<?php include './reusableComponents/footer.php'; ?>