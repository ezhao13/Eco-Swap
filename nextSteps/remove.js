$(document).ready(function() {
    $('#remove-form').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Serialize the form data
        var formData = $(this).serialize();
        console.log(formData);

        // Send an AJAX request to remove.php
        $.ajax({
            url: 'remove.php',
            type: 'post',
            data: formData,
            success: function(data) {
                // Update the result div with the data received from the server
                $('#result').html(data);
                $('#remove-form')[0].reset(); // Reset the form   
            },
            error: function() {
                // Handle any errors
                $('#result').html('An error occurred.');
            }
        });
    });
});
