function openDeleteModal(event) {
  // document.getElementById("deletePostId").value = postId;
  event.preventDefault();
  document.getElementById("deleteModal").style.display = "block";
}

function cancelDelete() {
  document.getElementById("deleteModal").style.display = "none";
}
