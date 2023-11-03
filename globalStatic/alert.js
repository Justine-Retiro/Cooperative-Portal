$(document).ready(function() {
    $('form').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: 'api/login.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                // Redirect to userPage.php after successful login
                window.location.href = '/diary/userSide/userPage.php';
            },
            error: function(xhr, status, error) {
                if (xhr.status === 401) {
                    alert(xhr.responseText);
                }
            }
        });
    });
});