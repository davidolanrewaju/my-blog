document.addEventListener("DOMContentLoaded", function () {
  let currentLink = window.location.href;

  let links = document.querySelectorAll(".tab");

  let post_subLinks = document.querySelectorAll(".post-sub-link");

  // Check if the current URL contains the word 'posts'
  if (
    currentLink.includes("type") ||
    currentLink.includes("p_id")
  ) {
    links.forEach(function (link) {
      if (link.href === currentLink) {
        link.classList.add("active");
      }
    });
  } else {
    // Check if the clicked tab matches the current URL
    links.forEach(function (link) {
      if (link.href === currentLink) {
        link.classList.add("active");
      }
    });
  }

  //Post sublinks - published and drafts
  post_subLinks.forEach(function (post_subLink) {
    if (post_subLink.href === currentLink) {
      post_subLink.classList.add("active-sublink");
    }
  });
});
