<?php
include __DIR__ . "/../api/session.php";
require_once __DIR__ . '/../api/connection.php';


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

        <!-- Content -->

        <div class="page-content-wrapper">
            <div class="container-fluid xyz">
                <div class="row d-flex align-items-center">
                    <div class="col-lg-9 py-3">
                        <h1 id="user-greet">Loan Overview</h1>
                    </div>
                </div>
                <div class="row">
                      <div class="col-lg-11">
                        <a class="btn btn-primary float-end mb-4" href="/coop/Member/Loan/Application/application.php" role="button">
                            <i class="bi bi-receipt-cutoff px-1"></i>
                            Apply loan
                        </a>
                    </div>
                </div>
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
                                $sql = "SELECT * FROM loan_applications WHERE account_number IN (SELECT account_number FROM clients WHERE user_id = " . $_SESSION['user_id'] . ") ORDER BY loan_id DESC";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                  while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['loanNo'] . "</td>";
                                    echo "<td>" . $row['loan_type'] . "</td>";
                                    echo "<td>" . $row['application_date'] . "</td>";
                                    echo "<td>" . $row['amount_before'] . "</td>";
                                    echo "<td>" . $row['amount_after'] . "</td>";
                                    echo "<td>" . $row['dueDate'] . "</td>";
                                    echo "<td>" . $row['application_status'] . "</td>";
                                    echo "</tr>";
                                  }
                                } else {
                                  echo "<tr>";
                                  echo "<td colspan='7'>No loan applications found.</td>";
                                  echo "</tr>";
                                }
                            ?>
                          </tbody>
                        </table>
                      </div>
                  </div>
                </div>
            </div>
        </div>

<!-- CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdn2.hubspot.net/hubfs/476360/utils.js"></script>
<!-- Sidebar Script -->
<script src="script.js"></script>
</body>
</html>