$(document).ready(function() {
    $('#login-form').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Serialize the form data
        var formData = $(this).serialize();
        console.log(formData);

        // Send an AJAX request to login.php
        $.ajax({
            url: 'login.php',
            type: 'post',
            data: formData,
            success: function(data) {
                // Update the result div with the data received from the server
                $('#result').html(data);
                $('#login-form')[0].reset(); // Reset the form   
            },
            error: function() {
                // Handle any errors
                $('#result').html('An error occurred.');
            }
        });
    });
});
