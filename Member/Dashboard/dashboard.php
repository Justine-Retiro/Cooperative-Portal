<?php
include __DIR__ . "/../api/session.php";
require_once __DIR__ . '/../api/connection.php';

$sql = "SELECT * FROM clients WHERE user_id = " . $_SESSION['user_id'];
$result = $conn->query($sql);

$sql = "SELECT balance FROM clients WHERE user_id = " . $_SESSION['user_id'];
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$_SESSION['balance'] = $row['balance'];

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

    <link rel="stylesheet" href="dashboard.css">
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
            <div class="row"></div>
              <div class="col-lg-12">
                <h1 id="user-greet">
                  Hi, <?php echo "<span>" . $_SESSION['first_name'] . " " . $_SESSION['last_name'] . "</span>"?>
                </h1>
                <h1>
                  Dashboard Overview
                </h1>
                <div class="row" style="margin-top: 2em;">
                  <!-- Chart -->
                  <div class="col-lg-2 w-auto">
                    <div id="card-container">
                      <div id="card-title">
                          <table>
                            <tr>
                                <td>Account Balance</td>
                            </tr>
                            <tr>
                              <th style="font-size: 25px;">₱ <?php echo number_format($_SESSION["balance"], 2, '.', ',')?></th>
                            </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Reports -->
                  <div class="col-md-12 mt-md-5">
                    <div class="card">
                      <div class="card-header">
                        <h3 class="pt-2">History</h3>
                        <div class="dropdown">
                          <button type="button" class="btn btn-link dropdown-toggle p-0" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                          </button>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><button class="dropdown-item" onclick="location.reload();">Refresh</button></li>
                          </ul>
                        </div>
                      </div>
                      <div class="table-responsive text-nowrap">
                        <table class="table">
                          <tr>
                            <th>Transaction</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Status</th>
                          </tr>
                          <tr>
                            <td>Loan Request Application</td>
                            <td>Loan Request</td>
                            <td>13 Apr 2025</td>
                            <td>Pending</td>
                          </tr>
                          <tr>
                            <td>Loan Payment</td>
                            <td>Loan Payment</td>
                            <td>01 Jun 2024</td>
                            <td>Paid</td>
                          </tr>
                          <tr>
                            <td>Loan Request Application</td>
                            <td>Loan Request</td>
                            <td>13 Apr 2025</td>
                            <td>Pending</td>
                          </tr>
                          <tr>
                            <td>Loan Request Application</td>
                            <td>Loan Request</td>
                            <td>13 Apr 2025</td>
                            <td>Pending</td>
                          </tr>
                          <tr>
                            <td>Loan Payment</td>
                            <td>Loan Payment</td>
                            <td>01 Jun 2024</td>
                            <td>Paid</td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                  
                  
                  <!-- /Reports -->
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

<!-- Chart -->
<script src="chart.js"></script>
</body>
</html>
