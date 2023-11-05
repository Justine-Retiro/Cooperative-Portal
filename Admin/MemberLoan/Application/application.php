<?php
if (isset($_GET["account_number"]) && isset($_GET["loan_id"])) {
  $account_number = $_GET["account_number"];
  $loan_id = $_GET["loan_id"];
  
  // Retrieve the account details from the database and display them
  require_once $_SERVER['DOCUMENT_ROOT'] . "/coop/Admin/Repositories/api/connection.php";
  $query = "SELECT * FROM loan_applications WHERE account_number = ? AND loanNo = ?";
  $stmt1 = $conn->prepare($query);
  $stmt1->bind_param("ss", $account_number, $loan_id);
  $stmt1->execute();
  $result1 = $stmt1->get_result();
  $data = $result1->fetch_assoc(); // Fetch the data into an associative array

  // Fetch the loan amount
  $loanAmount = $data['amount_before'];
  $loanAfter = $data['amount_after'];
  
  // Calculate the due date (30 days from now)
  // Calculate the due date based on loan term type and time to pay
  if ($data['loan_term_Type'] === 'month/s') {
      $dueDate = date('F d, Y', strtotime('+' . $data['time_pay'] . ' months'));
  } else if ($data['loan_term_Type'] === 'year/s') {
      $dueDate = date('F d, Y', strtotime('+' . $data['time_pay'] . ' years'));
  } else {
      // Default to 30 days if loan term type is not recognized
      $dueDate = date('F d, Y', strtotime('+30 days'));
  }
  // Store the due date in a variable to pass it to the server side
  $_SESSION['dueDate'] = $dueDate;
  

  
  // Calculate the interest (3% per month)
  $interest = $loanAmount * 0.05;

}
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

    <link rel="stylesheet" href="application.css">
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
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/coop/Admin/MemberLoan/loan.php" class="text-decoration-none">Members Loan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Application</li>
                  </ol>
                </nav>
                <h1>
                  Member loan application
                </h1>
                <div class="row" style="margin-top: 2em;">
                <!-- Table Trails -->
                  <div class="col-lg-12 px-3">
                    <h2>Loan user trails</h2>
                    <div class="">
                        <table class="table table-hover table-bordered table-fixed table-lock-height">
                          <thead class="table-primary" >
                            <tr>
                                <th>#</th>
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
                            $sql = "SELECT c.account_number, la.loanNo, la.customer_name, la.college, la.loan_type, 
                            la.application_date, la.application_status, la.amount_before, la.amount_after, la.remarks
                            FROM clients c
                            INNER JOIN loan_applications la ON la.account_number = c.account_number
                            WHERE c.account_number = ?";
                            
                            $stmt2 = $conn->prepare($sql);
                            $stmt2->bind_param("s", $account_number);
                            $stmt2->execute();
                            $result2 = $stmt2->get_result();
                            $counter = 1;

                            if ($result2->num_rows > 0){
                              while ($row = $result2->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $counter . "</td>";
                                echo "<td>" . $row["loanNo"] . "</td>";
                                echo "<td>" . $row["customer_name"] . "</td>";
                                echo "<td>" . $row["loan_type"] . "</td>";
                                echo "<td>" . $row["application_date"] . "</td>";
                                echo "<td>" . $row["amount_before"] . "</td>";
                                echo "<td>" . $row["amount_after"] . "</td>";
                                echo "<td>" . $row["remarks"] . "</td>";
                                echo "</tr>";
                                $counter++;
                              }
                            }
                            ?>
                          </tbody>
                        </table>
                    </div>
                  </div>
                  <!-- Table -->
                  <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                          <label for="name" class="form-label">Name</label>  
                          <input type="text" class="form-control" id="name" value="<?php echo $data['customer_name']; ?>" placeholder="" disabled readonly>
                            
                        </div>
                        <div class="mb-3">
                          <label for="college">College/Dept</label>  
                          <input type="text" class="form-control" id="college" placeholder="College/Dept" value="<?php echo $data['college']; ?>" disabled readonly>
                            
                        </div>
                        <div class="mb-3">
                          <label for="contact">Contact No.</label>  
                          <input type="text" class="form-control" id="contact" placeholder="Contact No." value="<?php echo $data['contact_num']; ?>" disabled readonly>
                            
                        </div>
                        <div class="mb-3">
                          <label for="dob">Date of Birth</label>
                          <input type="date" class="form-control" id="dob" placeholder="Date of Birth" value="<?php echo $data['birth_date']; ?>" disabled readonly>
      
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">  
                          <label for="age">Age</label>
                          <input type="number" class="form-control" id="age" placeholder="Age" value="<?php echo $data['age']; ?>" disabled readonly>
                            
                        </div>
                        <div class="mb-3">
                          <label for="doe">Date of Employed</label>  
                          <input type="date" class="form-control" id="doe" placeholder="Date of Employed" value="<?php echo $data['date_employed']; ?>" disabled readonly>
                            
                        </div>
                        <div class="mb-3">
                          <label for="retirement">Year of Retirement</label>  
                          <input type="number" class="form-control" id="retirement" placeholder="Year of Retirement" value="<?php echo $data['retirement_year']; ?>" disabled readonly>
                            
                        </div>
                        <div class="mb-3">
                          <label for="position">Work Position</label>  
                          <input type="text" class="form-control" id="position" placeholder="Work Position" value="<?php echo $data['work_position']; ?>" disabled readonly>
                            
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3" >
                            <label for="loan_type">Loan Type</label>
                            <select class="form-control" id="loan_type" name="loan_type" disabled readonly>
                                <?php
                                    $loan_type = $data['loan_type'];
                                    if ($loan_type == 'Regular') {
                                        echo '<option value="Regular" selected>Regular</option>';
                                        echo '<option value="Providential">Providential</option>';
                                        echo '<option value="Others">Others</option>';
                                    } elseif ($loan_type == 'Providential') {
                                        echo '<option value="Regular">Regular</option>';
                                        echo '<option value="Providential" selected>Providential</option>';
                                        echo '<option value="Others">Others</option>';
                                    } elseif ($loan_type == 'Others') {
                                        echo '<option value="Regular">Regular</option>';
                                        echo '<option value="Providential">Providential</option>';
                                        echo '<option value="Others" selected>Others</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                          <label for="doa">Date of Application</label>  
                          <input type="date" class="form-control" id="doa" placeholder="Date of Application" value="<?php echo $data['application_date']; ?>" disabled readonly>
                        </div>
                        <div class="mb-3">
                          <label for="amount">Loan Amount</label>  
                          <input type="text" class="form-control" id="amount" value="<?php echo $data['amount_before']; ?>" disabled readonly>
                        </div>
                        <div class="mb-3 float-end">
                          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            More details
                          </button>
                        </div>
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
                        <div class="mb-3">
                          <label for="signature">Upload picture of signature</label>  
                          <input type="file" class="form-control" id="signature" onchange="previewImage(event)">
                          <!-- Modal for image viewer -->
                          <div class="modal" id="imageModal">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Signature Preview</h5>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                  <img id="signaturePreview" src="" alt="Signature Preview" style="width: 100%;">
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- End of Modal -->

                          <!-- /Modal -->
                          
                          <!-- Button trigger modal -->
                          

                          <!-- Modal -->
                          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-5" id="exampleModalLabel">More details</h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <form id="loanActionForm" action="/coop/Admin/MemberLoan/api/processLoanAction.php" method="post">
                                      <input type="hidden" name="dueDate" value="<?php echo $dueDate; ?>">
                                      <input type="hidden" name="loanNo" value="<?php echo $data['loanNo']; ?>">
                                      <input type="hidden" id="loanAction" name="action">
                                  </form>
                                  <p>Loan Amount: ₱ <?php echo number_format($loanAmount, 2, '.', ','); ?></p>
                                  <p>Amount to pay: ₱ <?php echo number_format($loanAfter, 2, '.', ','); ?></p>
                                  <p>Time to pay: <?php echo $data['time_pay'] . " " . $data['loan_term_Type'];?></p>
                                  <p>End of dute date to pay: <?php echo $dueDate; ?></p>
                                  <p>Interest: 5%</p>

                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- /Modal -->

                        </div>
                        <br>
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="float-end">
                              <button type="button" class="accept-btn btn btn-success">Accept</button>
                              <button type="button" class="reject-btn btn btn-danger">Reject</button>
                            </div>

                          </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdn2.hubspot.net/hubfs/476360/Chart.js"></script>
<!-- Sidebar -->
<script src="script.js"></script>
<!-- Application -->
<script>
$(document).ready(function() {
  // Check if the loan has already been accepted
  var isLoanAccepted = "<?php echo $data['action_taken']; ?>";

  // Function to process the loan action
  function processLoanAction(loanNo, action, dueDate, buttonContainer) {
    $.ajax({
      type: 'POST',
      url: '/coop/Admin/MemberLoan/api/processLoanAction.php',
      data: { loanNo: loanNo, action: action, dueDate: dueDate }, // Include dueDate in the data sent
      success: function(response) {       
        // Redirect to /Admin/MemberLoan/loan.php
        window.location.href = '/coop/Admin/MemberLoan/loan.php';
      },
      error: function(xhr, status, error) {
        // Handle errors, if any
      }
    });
  }

  // Hide or show the accept and reject buttons based on the loan acceptance status
  if (isLoanAccepted == 'Accepted' || isLoanAccepted == 'Rejected') {
    $('.accept-btn, .reject-btn').hide();
  } else {
    $('.accept-btn, .reject-btn').show();
  }

  // Add event listeners to the accept and reject buttons
  $('.accept-btn').click(function() {
    var loanNo = <?php echo $data['loanNo']; ?>;
    var account_number = <?php echo $data['account_number']; ?>;
    var action = 'Accepted';
    var dueDate = $('input[name="dueDate"]').val(); // Get the dueDate from the form
    var buttonContainer = $(this);
    processLoanAction(loanNo, action, dueDate, account_number, buttonContainer); // Include dueDate in the function call
  });

  $('.reject-btn').click(function() {
    var loanNo = <?php echo $data['loanNo']; ?>;
    var action = 'Rejected';
    var account_number = <?php echo $data['account_number']; ?>;
    var dueDate = $('input[name="dueDate"]').val(); // Get the dueDate from the form
    var buttonContainer = $(this);
    processLoanAction(loanNo, action, dueDate, account_number, buttonContainer); // Include dueDate in the function call
  });
});
</script>
</body>
</html>
