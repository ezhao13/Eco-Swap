$(document).ready(function() {
    $('#insert-form').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Serialize the form data
        var formData = new FormData(this);
        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        // Send an AJAX request to process.php
        $.ajax({
            url: 'process.php',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                // Update the result div with the data received from the server
                $('#result').html(data);
                $('#insert-form')[0].reset(); // Reset the form   
            },
            error: function() {
                // Handle any errors
                $('#result').html('An error occurred.');
            }
        });
    });
});
