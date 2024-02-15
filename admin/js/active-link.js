document.addEventListener('DOMContentLoaded', function () {
    let currentLink = window.location.href;
    
    let links = document.querySelectorAll('.tab');
    
    links.forEach(function (link) {
        if(link == currentLink) {
            link.classList.add('active');
        };
    });
});
