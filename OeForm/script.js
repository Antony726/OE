$(document).ready(function() {
    $('#Dept, #year').change(function() {
        var dept = $('#Dept').val();
        var year = $('#year').val();
        $.ajax({
            type: 'POST',
            url: 'getSubjects.php',
            data: {dept: dept, year: year},
            success: function(response) {
                $('#subject').html(response);
            }
        });
    });

    // Intercept form submission
    $('#myForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        // Perform AJAX request
        var formData = $(this).serialize(); // Serialize form data
        $.ajax({
            type: 'POST',
            url: 'students.php', // Change to the appropriate URL
            data: formData,
            success: function(response) {
                // Handle success response
                console.log(response);
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error(xhr.responseText);
            }
        });
    });

   $.ajax({
        type: 'GET',
        url: 'https://worldtimeapi.org/api/timezone/Asia/Kolkata',
        success: function(response) {
            var currentTimestamp = Date.parse(response.utc_datetime);
            var disableTimestamp = Date.parse('2024-04-010T12:36:00');
            console.log(currentTimestamp<disableTimestamp)
    
            if (currentTimestamp > disableTimestamp) {
                $('#submitButton').prop('disabled', true);
            } 
        },
        error: function(xhr, status, error) {
            console.error('Error fetching time:', error);
        }
    });
});