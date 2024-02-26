document.addEventListener("DOMContentLoaded", function () {
  let currentLink = window.location.href;

  let homeLinks = document.querySelectorAll(".link");

  homeLinks.forEach(function (homeLink) {
    if (homeLink.href === currentLink) {
      console.log(currentLink);
      homeLink.classList.add("active-home");
    }
  });
});
