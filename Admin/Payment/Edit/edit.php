<?php
include '../../payment/api/editHeader.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $data['first_name'] . ' ' . $data['last_name']; ?> Repository</title>
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

    <link rel="stylesheet" href="edit.css">
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
                  Members Details
                </h1>
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/coop/Admin/Payment/payment.php" class="text-decoration-none">Payment Repositories</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Member Payment</li>
                  </ol>
                </nav>
                <div class="row" style="margin-top: 2em;">
                  <div class="col-lg-12" id="acc-nav">
                  <p>Account Number</p>
                  <!-- Auto generated -->
                  <p id="acc-number"><?php echo $account_number; ?>
                    <button class="btn" onclick="copyToClipboard('#acc-number')"><i class="bi bi-clipboard"></i></button>
                  </p>
                </div>

                <!-- Table Loan -->
                <div class="col-lg-12 px-md-4">
                  <div class="table-responsive">
                    <h2>Loan trails</h2>
                      <table class="table table-hover table-bordered" >
                        <thead>
                            <tr class="table-primary <?php echo ($row['remarks'] == 'Paid') ? 'paid' : ''; ?>">                              <th>#</th>
                              <th class="fw-semibold">Loan ID</th>
                              <th class="fw-semibold">Customer name</th>
                              <th class="fw-semibold">Loan type</th>
                              <th class="fw-semibold">Date of applying</th>
                              <th class="fw-semibold">Loan borrowed</th>
                              <th class="fw-semibold">Loan to pay</th>
                              <th class="fw-semibold">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                          <!-- You can fetch the user's loan data here and loop through it -->
                          <?php
                            include '../../payment/api/editTable.php';
                          ?>
                        </tbody>
                      </table>
                  </div>
                </div>
                <!-- /Table Loan -->
                
                <!-- Table -->
                <form action="/coop/Admin/Payment/api/editData.php" method="post" onsubmit="saveForm(event)" id="account-submit">                  
                  <div class="row m-3">
                  <h2>Accounting</h2>
                  <p>Loan reference number: 
                    <?php if (isset($loanData["loanNo"])) {
                    // You can access $data["loanNo"] here
                      echo $loanData["loanNo"];
                    } ?>
                  </p>
                    <input type="hidden" name="account_number" value="<?php echo $account_number; ?>">
                    <input type="hidden" name="loanNo" value="<?php if (isset($loanData["loanNo"])) {echo $loanData["loanNo"];} ?>">
                    <input type="hidden" name="application_status" value="None">
                    <div class="col-lg-12">
                      <div class="row d-flex">
                        <div class="col-lg-6">
                          <label for="currentBalance">Current Balance</label>
                          <input type="text" class="form-control" id="currentBalance" value="<?php echo $data["balance"]; ?>" disabled readonly>
                        </div>

                        <div class="col-lg-6">
                          <label for="balance">Amount</label>
                          <input type="text" class="form-control" name="balance" id="balance">
                        </div>

                        <div class="col-lg-6">
                          <label for="totalBalance">Total Balance</label>
                          <input type="text" class="form-control" name="totalBalance" id="totalBalance" readonly>
                        </div>
                      </div>
                      

                    <label for="remarks">Remarks</label>
                    <select class="form-control" name="remarks" id="remarks">
                      <option value="Paid">Paid</option>
                      <option value="Unpaid">Unpaid</option>
                    </select>
                    <button class="btn btn-success btn-lg" type="submit" style="float: right; margin-top: 10px;">Save</button>
                    </div>
                </form>

                  <!-- /Table -->
                  <!-- Fetching data -->
                  <div class="col-lg-12">
                    <div class="row" >
                      <div class="col-lg-4">
                        <p><strong>Last Name:</strong> <span id="lastNameText"><?php echo $data['last_name']; ?></span></p>
                        <p><strong>Citizenship:</strong> <span id="citizenshipText"><?php echo $data['citizenship']; ?></span></p>
                        <p><strong>Civil Status:</strong> <span id="civil_status"><?php echo $data['civil_status']; ?></span></p>
                        <p><strong>City Address:</strong> <span id="cityAddressText"><?php echo $data['city_address']; ?></span></p>
                        <p><strong>Phone Number:</strong> <span id="contactAddressText"><?php echo $data['phone_num']; ?></span></p>
                        <p><strong>Work Position:</strong> <span id="workPositionText"><?php echo $data['position']; ?></span></p>
                        <p><strong>Balance:</strong> <span id="balance"><?php echo $data['balance']; ?></span></p>

                      </div>
                      <div class="col-lg-4">
                        <p><strong>Middle Name:</strong> <span id="middleNameText"><?php echo $data['middle_name']; ?></span></p>
                        <p><strong>Provincial Address:</strong> <span id="provincialAddressText"><?php echo $data['provincial_address']; ?></span></p>
                        <p><strong>Mailing Address:</strong> <span id="mailingAddressText"><?php echo $data['mailing_address']; ?></span></p>
                        <p><strong>Place of Birth:</strong> <span id="placeOfBirthText"><?php echo $data['birth_place']; ?></span></p>
                        <p><strong>Nature of work:</strong> <span id="natureOfWork"><?php echo $data['natureOf_work']; ?></span></p>
                        <p><strong>Account Status:</strong> <span id="natureOfWork"><?php echo $data['account_status']; ?></span></p>
                        <p><strong>Remarks:</strong> <span id="remarks"><?php echo $data['remarks']; ?></span></p>

                      </div>
                      <div class="col-lg-4">
                        <p><strong>First Name:</strong> <span id="firstNameText"><?php echo $data['first_name']; ?></span></p>
                        <p><strong>Name of Spouse:</strong> <span id="spouseNameText"><?php echo $data['spouse_name']; ?></span></p>
                        <p><strong>Tax Identification Number:</strong> <span id="taxIdentificationNumberText"><?php echo $data['taxID_num']; ?></span></p>
                        <p><strong>Date of Birth:</strong> <span id="dateOfBirthText"><?php echo $data['birth_date']; ?></span></p>
                        <p><strong>Date of Employment:</strong> <span id="date_employed"><?php echo $data['date_employed']; ?></span></p>
                        <p><strong>Amount of shares:</strong> <span id="amountOfshares"><?php echo $data['amountOf_share']; ?></span></p>
                      </div>
                    </div>
                  </div>
                  
                  <!-- /Fetching Data -->
              </div>
            </div>
          </div>
        </div>
        <!-- /#page-content-wrapper -->
              <!-- /#page-content-wrapper -->
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdn2.hubspot.net/hubfs/476360/Chart.js"></script>
<!-- Sidebar -->
<script src="script.js"></script>
<!-- Fetching data -->
<script src="/coop/Admin/Repositories/static/fetch.js"></script>
<!-- Clipboard -->
<script src="/coop/Admin/Repositories/static/clipboard.js"></script>
<!-- Script -->
<script>
document.getElementById("remarks").disabled = true;

document.getElementById("balance").addEventListener("input", function () {
  var amount = parseFloat(this.value);
  var currentBalance = parseFloat(document.getElementById("currentBalance").value);
  var totalBalance = document.getElementById("totalBalance");
  var remarks = document.getElementById("remarks");

  if (isNaN(amount) || amount <= 0) {
    totalBalance.value = currentBalance.toFixed(2);
    remarks.value = "Unpaid";
    alert("Warning: Invalid input. Please enter a valid positive number.");
  } else {
    var newBalance = currentBalance - amount;
    totalBalance.value = newBalance.toFixed(2);
    remarks.value = newBalance === 0 ? "Paid" : "Unpaid";
  }
});


function saveForm(event) {
  var amount = parseFloat(document.getElementById("balance").value);
  if (isNaN(amount) || amount <= 0) {
    alert("Please enter a valid amount.");
    return false; // Prevent the form from being submitted
  }
  // If the amount is valid, you can proceed with form submission or other actions
  // Add your logic here for form submission or other actions
  // For example, you can call a function to submit the form data
  document.getElementById("account-submit").submit();
}

</script>
</body>
</html>
