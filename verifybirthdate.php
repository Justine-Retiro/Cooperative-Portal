<?php
session_start(); // Start the session

require_once "globalApi/connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <!-- CDN'S -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="/coop/globalStatic/style.css">
</head>
<body>
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <form action="/coop/globalApi/verifybirthdate.php" method="post">
            <div class="row px-4 vw-md" >
                <div class="col-lg-12 p-5 w-100">
                    <h2 class="me-md-5">Verification</h2>
                    <div class="row justify-content-center" >
                        <div class="col-lg-12 my-2">
                            <label for="birthdate">Birthdate</label>
                            <input type="date" class="form-control" placeholder="birthdate" name="birthdate" id="birthdate">
                            <button type="submit" class="btn btn-success mt-3 w-100">Verify</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

<!-- CDN's -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<!-- Alert validation -->
<script>
$(document).ready(function() {
    $('form').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: '/coop/globalApi/verifybirthdate.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    if (data.role === 'admin') {
                        window.location.href = '/coop/Admin/Dashboard/dashboard.php';
                    } else if (data.role === 'mem') {
                        window.location.href = '/coop/Member/Dashboard/dashboard.php';
                    } else {
                        window.location.href = '/coop/';
                    }
                } else {
                    // Alert for wrong birthdate
                    alert(data.message);
                }
            },
        });
    });
});
</script>
</body>
</html>