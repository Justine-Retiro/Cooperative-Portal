<?php
include __DIR__ . "/../api/session.php";
require_once __DIR__ . '/../api/connection.php';
include 'api/fetchHeader.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Account Overview</title>
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

    <!-- <link rel="stylesheet" href="account.css"> -->
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
            <a href="/coop/Member/Dashboard/dashboard.php">
              <span class="fa-stack fa-lg pull-left">
                <i class="bi bi-border-all"></i>
              </span>
              <span class="nav-text">Dashboard</span>
            </a>
          </li>
          <li>
            <a href="/coop/Member/Account/account.php">
              <span class="fa-stack fa-lg pull-left">
                <i class="bi bi-person"></i>
              </span>
              <span class="nav-text">Profile</span>
            </a>
          </li>
          <li>
            <a href="/coop/Member/Account/account.php">
              <span class="fa-stack fa-lg pull-left">
                <i class="bi bi-inbox"></i>
              </span>
              <span class="nav-text">Account</span>
            </a>
          </li>
          <li>
            <a href="/coop/Member/Loan/loan.php">
              <span class="fa-stack fa-lg pull-left"
                ><i class="bi bi-wallet2"></i></span>
                <span class="nav-text">Loan</span> 
              </a
            >
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
                  Account Overview
                </h1>
                <div class="container-wrapper-contents">
                  <div class="row">
                    <div class="col mb-3 px-4 py-3 border border-dark-subtle rounded">
                        <div class="row w-auto d-flex justify-content-between">
                            <div class="col-lg-3">
                                <table>
                                    <tr>
                                        <td>Loan Balance</td>
                                    </tr>
                                    <tr>
                                      <th class="fw-normal" style="font-size: 25px;"><?php echo number_format($_SESSION['balance'], 2, '.', ',')?></th>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table>
                                    <tr>
                                        <td>Remarks</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-normal" style="font-size: 25px;"><?php echo $_SESSION['remarks'] ?></th>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3">
                              <table>
                                  <tr>
                                      <td>Amount of Shares</td>
                                  </tr>
                                  <tr>
                                      <th class="fw-normal" style="font-size: 25px;"><?php echo number_format($_SESSION['amountOf_share'], 2, '.', ',')?></th>
                                  </tr>
                              </table>
                          </div>
                          <div class="col-md-3 pe-1">
                            <table>
                                <tr>
                                    <td>Loan Application Status:</td>
                                </tr>
                                <tr>
                                  <div id="loanStatusContainer">
                                    <th class="fw-normal" style="font-size: 25px;"><?php echo $_SESSION['application_status']?></th>
                                  </div>
                                </tr>
                            </table>
                        </div>
                      </div>
                  </div>
                </div>
                    <!-- Reports -->
                <div class="col-md-12 mt-md-5">
                    <div class="card">
                      <div class="card-header d-flex justify-content-between align-items-center">
                          <h3 class="pt-2">Accounting Trails</h3>
                          <div class="dropdown">
                            <button type="button" class="btn btn-link dropdown-toggle p-0" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                              <li><button class="dropdown-item" onclick="location.reload();">Refresh</button></li>
                            </ul>
                          </div>
                        </div>

                        <div class="table table-responsive">
                        <table class="table table-hover">
                          <thead class="table-primary">
                            <tr>
                              <th>Description</th>
                              <th>Date</th>
                              <th>Remarks</th>
                              <th>Balance</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                                include 'api/fetchTable.php';
                            ?>
                          </tbody>
                        </table>
                      </div>
                  </div>
                </div>
                  <!-- /Reports -->
                  <!-- Loan Trails -->
                  <div class="col-md-12 mt-md-5">
                    <div class="card">
                      <div class="card-header d-flex justify-content-between align-items-center">
                          <h3 class="pt-2">Loan Trails</h3>
                          <div class="dropdown">
                            <button type="button" class="btn btn-link dropdown-toggle p-0" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                              <li><button class="dropdown-item" onclick="location.reload();">Refresh</button></li>
                            </ul>
                          </div>
                        </div>

                        <div class="table table-responsive">
                        <table class="table table-hover">
                          <thead class="table-primary">
                            <tr>
                              <th>Loan No.</th>
                              <th>Loan Type</th>
                              <th>Date</th>
                              <th>Loan Amount</th>
                              <th>Amount pay</th>
                              <th>Due Date</th>
                              <th>Loan status</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                                include 'api/fetchLoanTable.php';
                            ?>
                          </tbody>
                        </table>
                      </div>
                  </div>
                </div>
                  <!-- /Loan Trails -->
              </div>
            </div>
          </div>
        </div>
        <!-- /#page-content-wrapper -->
              <!-- /#page-content-wrapper -->
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Sidebar -->
<script src="script.js"></script>

<!-- Status -->
<script>
  // Get the loan status container element
  const loanStatusContainer = document.getElementById('loanStatusContainer');

  // Assign PHP variable to JavaScript variable
  const actionTaken = "<?php echo $_SESSION['application_status']; ?>";

  // Check the loan application status and apply fade-out effect if rejected or accepted
  if (actionTaken === 'Rejected' || actionTaken === 'Accepted') {
    // Apply fade-out effect after 2 seconds
    setTimeout(() => {
      loanStatusContainer.style.opacity = '0';
      // Remove the element from the DOM after the fade-out effect
      setTimeout(() => {
        loanStatusContainer.remove();
      }, 1000);
    }, 2000);
  }
</script>
</body>
</html>
