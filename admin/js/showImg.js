document.getElementById('post-image').addEventListener('change', function (event) {
    const input = event.target;
    const imgElement = document.getElementById('post-img');

    // Check if a file is selected
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            // Update the src attribute with the data URL of the selected image
            imgElement.src = e.target.result;
        };

        // Read the selected image as a data URL
        reader.readAsDataURL(input.files[0]);
    }
});