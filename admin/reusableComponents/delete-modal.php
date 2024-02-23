<div id="deleteModal" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to delete this post?</p>
        <form id="deleteForm" action="../admin/postsComponents/delete.php" method="get">
            <input type="hidden" name="post_id" id="deletePostId" value="<?php echo $post_id; ?>">
            <button class="btn" type="button" onclick="cancelDelete()">Cancel</button>
            <button class="btn" type="submit">Delete</button>
        </form>
    </div>
</div>