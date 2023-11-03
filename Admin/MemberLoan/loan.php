<?php
  require_once __DIR__ ."/api/connection.php";

  $sql_user = "SELECT * FROM clients";
  $stmt_user = $conn->prepare($sql_user);
  $stmt_user->execute();
  $result_user = $stmt_user->get_result();

  // Fetch the loan applications and the action taken
  $sql = "SELECT c.account_number, la.loanNo, la.customer_name, la.college, la.loan_type, 
          la.application_date, la.application_status, la.amount, la.action_taken
          FROM clients c
          INNER JOIN loan_applications la ON c.account_number = la.account_number";

  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <!-- CDN's -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <!-- Style -->
    <link rel="stylesheet" href="style.css" />

    <link rel="stylesheet" href="loan.css">
</head>
  <body>
    <nav class="navbar navbar-default no-margin">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header fixed-brand px-4">
        
        <a class="navbar-brand" href="#">NEUST Credit Cooperative Partners</a>
        <button
          type="button"
          class="btn navbar-toggle collapsed"
          data-toggle="collapse"
          id="menu-toggle">
          <i class="bi bi-list"></i>
        </button>
      </div>
      <!-- navbar-header-->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li>
            <button
              class="navbar-toggle collapse in"
              data-toggle="collapse"
              id="menu-toggle-2"
            >
              <span
                class="glyphicon glyphicon-th-large"
                aria-hidden="true"
              ></span>
            </button>
          </li>
        </ul>
      </div>
      <!-- bs-example-navbar-collapse-1 -->
    </nav>
    <div id="wrapper">
      <!-- Sidebar -->
      <div id="sidebar-wrapper">
        <ul class="sidebar-nav nav-pills nav-stacked" id="menu">
          <div class="logo-container">
            <img src="/coop/Assets/logo.png" alt="">
          </div>
          <li>Menu</li>
          <li>
            <a href="/coop/Admin/Dashboard/dashboard.php">
              <span class="fa-stack fa-lg pull-left">
                <i class="bi bi-border-all"></i>
              </span>
              <span class="nav-text">Dashboard</span>
            </a>
          </li>
          <li>
            <a href="/coop/Admin/Repositories/repositories.php">
              <span class="fa-stack fa-lg pull-left">
                <i class="bi bi-inbox"></i>
              </span>
              <span class="nav-text">Repositories</span>
            </a>
          </li>
          <li>
            <a href="/coop/Admin/MemberLoan/loan.php">
              <span class="fa-stack fa-lg pull-left">
                <i class="bi bi-archive"></i>
              </span>
              <span class="nav-text">Members Loan</span>
            </a>
          </li>
          <li>
            <a href="/coop/Admin/Payment/payment.php">
              <span class="fa-stack fa-lg pull-left"
                ><i class="bi bi-wallet2"></i></span>
                <span class="nav-text">Payment</span> 
              </a
            >
          </li>
          <li>
            <a href="/Account/account.html">
              <span class="fa-stack fa-lg pull-left">
                <i class="bi bi-person"></i>
              </span>
              <span class="nav-text">Profile</span>
            </a>
          </li>
         

          <li>Settings</li>
          <li>
            <a href="#"
              ><span class="fa-stack fa-lg pull-left"
                ><i class="bi bi-info-circle"></i></span
              ><span class="nav-text">Help</span></a
            >
          </li>
          <li>
            <a href="/coop/globalApi/logout.php"
              ><span class="fa-stack fa-lg pull-left">
                <i class="bi bi-box-arrow-left"></i></span
              ><span class="nav-text">Logout</span></a
            >
          </li>
        </ul>
      </div>
      <!-- /#sidebar-wrapper -->

      <!-- Page Content -->
        <div id="page-content-wrapper">
          <div class="container-fluid xyz">
            <div class="row">
              <div class="col-lg-12">
                <h1>
                  Members Repositories
                </h1>
                <div class="row" style="margin-top: 2em;">
                  <!-- Table -->
                  <div class="row">
                    
                    <div class="col-lg-12">
                      <div class="row">
                        <div class="row">
                          <div class="col-lg-11">
                            <!-- Whole top bar -->
                            <div class="row d-flex justify-content-between">
                              <div class="col-lg-4 border w-auto pe-4 " style="border-radius: 10px;">
                                <div class="row py-1 d-flex align-items-center">
                                  <div class="col-md-3  w-auto" >
                                    <button class="btn text-primary fw-medium" onclick="filterLoans('all')">All </button>
                                  </div>
                                  <div class="col-md-3 w-auto" >
                                    <button class="btn text-primary-emphasis fw-medium" onclick="filterLoans('pending')">Pending <span><?php
                                    // Assuming you have established a database connection

                                    // Include the connection.php file
                                    require_once __DIR__ ."/api/connection.php";
                                    // Prepare the SQL query
                                    $query = "SELECT COUNT(application_status) AS pending FROM loan_applications WHERE application_status = 'Pending' ";

                                    // Execute the query
                                    $result = mysqli_query($conn, $query);

                                    // Check if the query was successful
                                    if ($result) {
                                        // Fetch the result as an associative array
                                        $row = mysqli_fetch_assoc($result);

                                        // Access the count of total members
                                        $totalPending = $row['pending'];

                                        // Output the count
                                        echo $totalPending . "" ;
                                    } else {
                                        // Handle the query error
                                        echo "Error: " . mysqli_error($conn);
                                    }
                                    ?>
                                </span></button>
                                  </div>
                                  <div class="col-md-3 w-auto" >
                                    <button class="btn text-success fw-medium" onclick="filterLoans('accepted')">Accepted <span><?php
                                    // Assuming you have established a database connection

                                    // Include the connection.php file
                                    require_once __DIR__ ."/api/connection.php";
                                    // Prepare the SQL query
                                    $query = "SELECT COUNT(application_status) AS accepted FROM loan_applications WHERE application_status = 'Accepted' ";

                                    // Execute the query
                                    $result = mysqli_query($conn, $query);

                                    // Check if the query was successful
                                    if ($result) {
                                        // Fetch the result as an associative array
                                        $row = mysqli_fetch_assoc($result);

                                        // Access the count of total members
                                        $totalAccepted = $row['accepted'];

                                        // Output the count
                                        echo $totalAccepted . "" ;
                                    } else {
                                        // Handle the query error
                                        echo "Error: " . mysqli_error($conn);
                                    }
                                    ?></span></button>
                                  </div>
                                  <div class="col-md-3 w-auto" >
                                    <button class="btn text-danger fw-medium" onclick="filterLoans('rejected')">Rejected <span><?php
                                    // Assuming you have established a database connection

                                    // Include the connection.php file
                                    require_once __DIR__ ."/api/connection.php";
                                    // Prepare the SQL query
                                    $query = "SELECT COUNT(application_status) AS pending FROM loan_applications WHERE application_status = 'Rejected' ";

                                    // Execute the query
                                    $result = mysqli_query($conn, $query);

                                    // Check if the query was successful
                                    if ($result) {
                                        // Fetch the result as an associative array
                                        $row = mysqli_fetch_assoc($result);

                                        // Access the count of total members
                                        $totalPending = $row['pending'];

                                        // Output the count
                                        echo $totalPending . "" ;
                                    } else {
                                        // Handle the query error
                                        echo "Error: " . mysqli_error($conn);
                                    }
                                    ?></span></button>
                                  </div>
                                  
                                </div>
                                
                              </div>
                               <!-- Search bar -->
                              <div class="col-lg-3" id="search-top-bar">
                                <div class="input-group" >
                                  <input class="form-control border-end-0 border rounded-pill" type="text" placeholder="Search" id="search-input">
                                  <span class="input-group-append">
                                      <button class="btn btn-outline-secondary bg-white border-start-0 border rounded-pill ms-n3" type="button">
                                          <i class="fa fa-search"></i>
                                      </button>
                                  </span>
                                </div>
                              </div>
                               <!-- /Search bar -->
                            </div>
                             
                          </div>
                          <!-- /Whole top bar -->
                          </div>
                        </div>
                        
                      </div>
                      <div class="table table-responsive">
                          <table id="loan-applications" class="table" style="font-size: large;">
                          <!-- Reserved -->
                          </table>  
                      </div>
                    </div>
                </div>
                  <!-- /Table -->
              </div>
            </div>
          </div>
        </div>
        <!-- /#page-content-wrapper -->
              <!-- /#page-content-wrapper -->
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Sidebar -->
<script src="script.js"></script>
<!-- Getting the total of appointments -->
<script>
function filterLoans(status) {
    $.ajax({
        url: '/coop/Admin/MemberLoan/api/fetchLoans.php',
        type: 'GET',
        data: { status: status },
        success: function(data) {
            // Assuming the PHP script returns the filtered loan applications as HTML
            // Replace the existing loan applications with the filtered ones
            $('#loan-applications').html(data);
        },
        error: function(xhr, status, error) {
            // Handle any errors
            console.error('An error occurred:', error);
        }
    });
}

</script>
<!-- Actions for the loan -->
<script>
$(document).ready(function() {
  filterLoans('all');
    $(document).on('click', '.accept-btn, .reject-btn', function() {
        var loanNo = $(this).data('loan-no');
        var action = $(this).hasClass('accept-btn') ? 'Accepted' : 'Rejected';
        var buttonContainer = $(this).parent();
        processLoanAction(loanNo, action, buttonContainer);
    });

    $('#search-input').on('keyup', function() {
        var query = $(this).val();
        searchLoans(query);
    });

    function processLoanAction(loanNo, action, buttonContainer) {
        $.ajax({
            type: 'POST',
            url: '/coop/Admin/MemberLoan/api/processLoanAction.php',
            data: { loanNo: loanNo, action: action },
            success: function(response) {
                // Handle the response from your PHP script
                // You can update the table or provide user feedback here
                var actionText = action.charAt(0).toUpperCase() + action.slice(1);
                buttonContainer.html('<span>' + actionText + '</span>');
            },
            error: function(xhr, status, error) {
                // Handle errors, if any
            }
        });
    }

    function searchLoans(query) {
    $.ajax({
        url: '/coop/Admin/MemberLoan/api/searchLoans.php',
        type: 'GET',
        data: { query: query },
        success: function(data) {
            $('#loan-applications').html(data);
        },
        error: function(xhr, status, error) {
            console.error('An error occurred:', error);
        }
    });
}
});
</script>
</body>
</html>
