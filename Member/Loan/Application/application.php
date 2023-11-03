<?php
include __DIR__ . "/../../api/session.php";
require_once __DIR__ . '/../../api/connection.php';

// Generate a random 4-digit loan reference number
$loanRefNo = rand(0, 99999);
$loanRefNo = str_pad(rand(0, 99999), 4, "1", STR_PAD_LEFT);

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
                <div class="row py-md-4 d-flex align-items-center">
                    <div class="col-lg-12">
                      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="/Loan/loan.html" class="text-decoration-none">Loan</a></li>
                          <li class="breadcrumb-item active" aria-current="page">Application</li>
                        </ol>
                      </nav>
                      
                      <h1 id="user-greet">Application for loan</h1>
                    </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <form action="/coop/Member/Loan/api/newLoan.php" method="post" onsubmit="return validateForm()">
                    <div class="row">
                      <div class="col-lg-4">
                            <input type="hidden" name="loanNo" value="<?php echo $loanRefNo; ?>">
                            <input type="hidden" name="application_status" value="Pending">
                            <label for="name">Name</label>  
                            <?php
                            require_once __DIR__ . '/../../api/connection.php';

                            $sql = "SELECT * FROM clients WHERE account_number = '{$_SESSION['account_number']}'";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $customerName = $row["first_name"] . " " . $row["last_name"];
                            ?>

                            <input type="text" class="form-control" name="customer_name" id="name" value="<?php echo $customerName; ?>">

                            <label for="college">College/Dept</label>  
                            <input type="text" class="form-control" name="college" id="college" placeholder="College/Dept">
                              
                            <label for="contact">Contact No.</label>  
                            <input type="number" class="form-control" name="contact" id="contact" placeholder="Contact No.">
                              
                            <label for="dob">Date of Birth</label>
                            <input type="date" class="form-control" name="dob" id="dob" placeholder="Date of Birth">
                        </div>
                        <div class="col-lg-4">
                            <label for="age">Age</label>
                            <input type="number" class="form-control" name="age" id="age" placeholder="Age">
                          
                            <label for="doe">Date of Employed</label>  
                            <input type="date" class="form-control" name="doe" id="doe" placeholder="Date of Employed">
                              
                            <label for="retirement">Year of Retirement</label>  
                            <input type="number" class="form-control" name="retirement" id="retirement" placeholder="Year of Retirement">
                          
                            <label for="work_position">Work Position</label>  
                            <input type="text" class="form-control" name="work_position" id="work_position" placeholder="Work Position">
                              
                        </div>
                        <div class="col-lg-4">

                            <label for="loan_type">Loan Type</label>
                            <select class="form-control" id="loan_type" name="loan_type">
                                <option value="Regular" selected>Regular</option>
                                <option value="Providential">Providential</option>
                                <option value="Others">Others</option>
                            </select>

                            <label for="doa">Date of Application</label>  
                            <input type="date" class="form-control" name="doa" id="doa" placeholder="Date of Application">
                          
                            <label for="amount">Loan Amount</label>  
                            <input type="number" class="form-control" name="amount" id="amount" placeholder="Loan Amount">
                        </div>
                        <div class="col-lg-12">
                          <br>
                          <h4 >Terms and agreement</h4>
                          <p>I hereby authorize the NEUST Community Credit Cooperative/NEUST Cashier to deduct
                            the monthly amortization of my loan from my pay slip. 
                            I AGREE THAT ANY LATE PAYMENT
                            WILL BE SUBJECTED TO A PENALTY OF 3% PER MONTH OF DELAY. Furthermore, default in
                            payments for three (3) months will be ground for the coop to take this matter into court and the
                            balance should be due and demandable.</p>
                            
                              <label for="signature">Upload picture of signature</label>  
                              <input type="file" class="form-control" name="signature" id="signature">
                            <br>
                            <button class="btn btn-primary" type="submit" style="float: right;">Apply</button>
                        </div>
                    </div>
                      
                    </form>
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
<!-- Validation Script-->
<script>
  function validateForm() {
    // Get the values of the required fields
    var name = document.getElementById("name").value;
    var college = document.getElementById("college").value;
    var number = document.getElementById("contact").value;
    var amount = document.getElementById("amount").value;
    var dateofApplication = document.getElementById("doa").value;
    // var signature = document.getElementById("signature").value;

    // Check if the required fields are empty
    if (
      name === "" ||
      college === "" ||
      number === "" ||
      amount === "" ||
      dateofApplication === ""
      // signature === ""
    ) {
      alert("Please fill out all required fields.");
      return false; // Prevent form submission
    }
  }
</script>
</body>
</html>