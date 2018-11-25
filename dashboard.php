<!--  This site was created in Webflow. http://www.webflow.com  -->
<!--  Last Published: Sun Sep 23 2018 17:03:28 GMT+0000 (UTC)  -->
<html data-wf-page="5b95845306db3608b8637846" data-wf-site="5ac55225016bff3a51ced38b">
<head>
  <meta charset="utf-8">
  <title>Dashboard v2</title>
  <meta content="Dashboard v2" property="og:title">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta content="Webflow" name="generator">
  <link href="css/normalize.css" rel="stylesheet" type="text/css">
  <link href="css/webflow.css" rel="stylesheet" type="text/css">
  <link href="css/yadayadadebt.webflow.css" rel="stylesheet" type="text/css">
  <!-- Ravi's changes to include signon BEGIN-->
  <script src="https://www.gstatic.com/firebasejs/5.4.2/firebase.js"></script>
  <script>
    // Initialize Firebase
    var config = {
      apiKey: "AIzaSyCUk7ZdY62cOKXINe_nSuXVEEOAOsOzrHU",
      authDomain: "yadayada-4e02c.firebaseapp.com",
      databaseURL: "https://yadayada-4e02c.firebaseio.com",
      projectId: "yadayada-4e02c",
      storageBucket: "yadayada-4e02c.appspot.com",
      messagingSenderId: "11800929915"
    };
    firebase.initializeApp(config);
  </script>
  <script src="https://cdn.firebase.com/libs/firebaseui/3.4.0/firebaseui.js"></script>
  <link type="text/css" rel="stylesheet" href="https://cdn.firebase.com/libs/firebaseui/3.4.0/firebaseui.css" />
  <!-- Ravi's changes to include signon END-->
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js" type="text/javascript"></script>
  <script type="text/javascript">WebFont.load({  google: {    families: ["Inconsolata:400,700","Merriweather:300,300italic,400,400italic,700,700italic,900,900italic","Roboto:300,regular,500"]  }});</script>
  <!-- [if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script><![endif] -->
  <script type="text/javascript">!function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);</script>
  <link href="https://daks2k3a4ib2z.cloudfront.net/img/favicon.ico" rel="shortcut icon" type="image/x-icon">
  <link href="https://daks2k3a4ib2z.cloudfront.net/img/webclip.png" rel="apple-touch-icon">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
  <body class='body'>
<?php
setlocale(LC_MONETARY,"en_US");

include 'dbconnection.php';

$user_id = $_REQUEST['user_id'];
$sql = "SELECT debt_identifier,
               nick_name,
               debt_type,
               original_balance,
               original_term,
               interest_type,
               CASE WHEN debt_type = 'Legal Obligation' THEN 1000 ELSE interest_rate END AS interest_rate,
               remaining_balance,
               remaining_term,
               minimum_payment,
               CASE WHEN debt_type = 'Legal Obligation' THEN remaining_balance ELSE round(remaining_balance * interest_rate/100/12,2) END AS monthly_payment
          FROM yadayada.debt_user_input
         WHERE user_id = '$user_id'
         ORDER BY interest_rate DESC";

$result = $con->query($sql);

$total_minimum_monthly_payment=0;
while ($row = $result->fetch_assoc()) {
  //If debt is legal obligation then the minimum monthly payment is that of remaining_balance; if not, it's balance * interest / 12
  if ($row['debt_type'] == 'Legal Obligation') {
    $total_minimum_monthly_payment = $total_minimum_monthly_payment + $row['remaining_balance'];
  }
  else {
    $total_minimum_monthly_payment = $total_minimum_monthly_payment + $row['remaining_balance'] * $row['interest_rate']/100/12;
  }
}

//the first time user comes to dasboard, set the monthly amount to the total monthly minimum
if($_REQUEST['monthly-amount'] == 0) {
  $user_monthly_amount=$total_minimum_monthly_payment;
}
else {
  $user_monthly_amount=$_REQUEST['monthly-amount'];
}

//if the user can affort a monthly payment above the total minimum monthly payment then allocte that extra money to
//debt that has the highest APY
$result = $con->query($sql);
$monthly_payments = array();
$excess_monthly_available = $user_monthly_amount - $total_minimum_monthly_payment;

$i=0;
while($row = $result->fetch_assoc()) {

  if ($excess_monthly_available <= 0) {
    $monthly_payments[] = $row['monthly_payment'];
  }
  else {
    if ($row['debt_type'] <> 'Legal Obligation') {
      if ($excess_monthly_available <= $row['remaining_balance'] - $row['monthly_payment']) {
        $monthly_payments[] = $excess_monthly_available;
        $excess_monthly_available = 0;
      }
      else {
        $monthly_payments[] = $row['remaining_balance'];
        $excess_monthly_available = $row['remaining_balance'] - $row['monthly_payment'];
      }
    }
    else {
      $monthly_payments[] = $row['monthly_payment'];
    }
  }

  //echo $row['nick_name'] . ' ' . $i . ' ' . $monthly_payments[$i];
  $i++;

}

$result = $con->query($sql);

if ($result->num_rows > 0) {

    echo  "<div data-collapse='medium' data-animation='default' data-duration='400' class='navigation-bar dark w-nav'>
        <div class='w-container'>
          <a href='index.php' class='brand-link white w-nav-brand'>
            <h1 class='brand-text'>Yada Yada Debt</h1>
            <div class='icon gold nav-icons'>  </div>
          </a>
          <nav role='navigation' class='navigation-menu w-nav-menu'>
            <a href='index.php' class='navigation-link white w-nav-link'>Home</a>
            <a href='#' class='navigation-link white w-nav-link'>About</a>
            <a href='#' class='navigation-link white w-nav-link'>Contact</a>
            <a href='/yadayada/login.php' class='navigation-link w-nav-link' id ='linkSignIn'>Sign In</a>   <!-- TBD -->
            <a href='#' class='navigation-link w-nav-link' id ='linkSignOut'>Sign Out</a>
          </nav>
          <div class='hamburger-button white w-nav-button'>
            <div class='w-icon-nav-menu'></div>
          </div>
        </div>
      </div>
      <div class='section-2'>
        <div class='container-top-24 w-container'>
          <h2 class='section-heading'>Let&#x27;s see your options</h2>
          <div>
            <form action='dashboard.php' method='get' id='monthly-amount-available' name='monthly-amount-available' data-name='Monthly Amount Available'>

              <!-- <div class='section-subheading'>[first name]if you have <input type='text' id='monthly-amount' name='monthly-amount' data-name='monthly-amount' placeholder='$900.00' maxlength='200' class='form-field'> set aside this month, you can...<br></div> -->
              <div class='section-subheading'>
                <label for='first-name' id='first-name'></label>if you have
                <input type='text' id='monthly-amount' name='monthly-amount' data-name='monthly-amount' value=" . number_format($user_monthly_amount,2) . " maxlength='200' class='form-field'> set aside this month, you can...<br>
              </div>
                <input type='hidden' name='user_id' id='user_id' value=" . $user_id . ">
                <input type='submit' value='Recalculate' id='recalculate'>
            </form>
            <div data-duration-in='300' data-duration-out='100' class='w-tabs'>
              <div class='tab-title-menu w-tab-menu'>
                <a data-w-tab='Tab 1' class='tab w-inline-block w-tab-link w--current'>
                  <div>Pay</div>
                </a>
                <a data-w-tab='Tab 2' class='tab w-inline-block w-tab-link'>
                  <div>Invest</div>
                </a>
              </div>
              <div class='w-tab-content'>
                <div data-w-tab='Tab 1' class='w-tab-pane w--tab-active'>
                  <div class='tooltip info outside'>
                    <div id='icon-payday-loan' class='icon gold solid'></div>
                    <div>Below are our recommendations for this month to help you pay off your debt.</div>
                  </div>
                  <div>
                  <!--   <div class='bottom-16'><a href='debt-sources-edit.php'>Update or add sources</a></div> -->

                  ";

                    // output data of each row
                    $i=0;
                    while($row = $result->fetch_assoc()) {

                      if ($row['debt_type'] == 'Payday Loan') {
                        echo "
                          <div id='debt-source-block' class='div-block box thin'>
                            <div id='select-type' class='row w-row'>
                              <div class='debt-sources-type-elements w-col w-col-2 w-col-medium-2 w-col-small-2'>
                                <div id='icon-payday-loan' class='icon solid large'></div>
                              </div>
                              <div class='debt-sources-type-elements w-col w-col-10 w-col-medium-10 w-col-small-10'>
                                <p id='credit-card-balance-filled' class='form-label start'>Payday loan </p><a href='debt-sources-edit.php?user_id=" . $user_id . "&debt_identifier=" . $row['debt_identifier'] . "' class='link-float-right'>Edit</a>
                                <p class='card_header'>" . $row['debt_identifier'] . "</p>
                                <div class='data-descriptor dashboard w-row'>
                                  <div class='w-col w-col-3 w-col-tiny-tiny-stack'>
                                    <p id='credit-card-balance-filled' class='form-label start'>Monthly Payment</p>
                                    <p id='credit-card-balance-filled' class='medium block'>$" . number_format($monthly_payments[$i++],2) . "</p>
                                  </div>
                                  <div class='w-col w-col-3 w-col-tiny-tiny-stack'>
                                    <p id='credit-card-balance-filled' class='form-label start'>Remaining balance</p>
                                    <p id='credit-card-balance-filled' class='medium block'>$" . number_format($row['remaining_balance'],2) . "</p>
                                  </div>
                                  <div class='w-col w-col-3 w-col-tiny-tiny-stack'>
                                    <p id='credit-card-balance-filled' class='form-label start'>Interest Rate</p>
                                    <p id='credit-card-balance-filled' class='medium block'>" . number_format($row['interest_rate'],2) . "%</p>
                                  </div>
                                  <div class='w-col w-col-3 w-col-tiny-tiny-stack'>
                                    <p id='credit-card-balance-filled' class='form-label start'>Remaining Term</p>
                                    <p id='credit-card-balance-filled' class='medium block good'>" .$row['remaining_term'] . "</p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>";

                        }

                        if ($row['debt_type'] == 'Credit Card') {
                          echo "
                            <div id='debt-source-block' class='div-block box thin'>
                              <div id='select-type' class='row w-row'>
                                <div class='debt-sources-type-elements w-col w-col-2 w-col-medium-2 w-col-small-2'>
                                  <div id='icon-credit-card' class='icon large'></div>
                                </div>
                                <div class='debt-sources-type-elements w-col w-col-10 w-col-medium-10 w-col-small-10'>
                                  <p id='credit-card-balance-filled' class='form-label start'>Credit Card </p><a href='debt-sources-edit.php?user_id=" . $user_id . "&debt_identifier=" . $row['debt_identifier'] . "' class='link-float-right'>Edit</a>
                                  <p class='card_header'>" . $row['debt_identifier'] . "</p>
                                  <div class='data-descriptor dashboard w-row'>
                                    <div class='w-col w-col-3 w-col-tiny-tiny-stack'>
                                      <p id='credit-card-balance-filled' class='form-label start'>Monthly Payment</p>
                                      <p id='credit-card-balance-filled' class='medium block'>$" . number_format($monthly_payments[$i++],2) . "</p>
                                    </div>
                                    <div class='w-col w-col-3 w-col-tiny-tiny-stack'>
                                      <p id='credit-card-balance-filled' class='form-label start'>Remaining balance</p>
                                      <p id='credit-card-balance-filled' class='medium block'>$" . number_format($row['remaining_balance'],2) . "</p>
                                    </div>
                                    <div class='w-col w-col-3 w-col-tiny-tiny-stack'>
                                      <p id='credit-card-balance-filled' class='form-label start'>Interest Rate</p>
                                      <p id='credit-card-balance-filled' class='medium block'>" . number_format($row['interest_rate'],2) . "%</p>
                                    </div>
                                    <div class='w-col w-col-3 w-col-tiny-tiny-stack'>
                                    <p id='credit-card-balance-filled' class='form-label start'></p>
                                    <p id='credit-card-balance-filled' class='medium block good'></p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>";

                        }

                        if ($row['debt_type'] == 'Student Loan') {
                            echo "
                              <div id='debt-source-block' class='div-block box thin'>
                                <div id='select-type' class='row w-row'>
                                  <div class='debt-sources-type-elements w-col w-col-2 w-col-medium-2 w-col-small-2'>
                                    <div id='icon-student-loan' class='icon large solid'></div>
                                  </div>
                                  <div class='debt-sources-type-elements w-col w-col-10 w-col-medium-10 w-col-small-10'>
                                    <p id='credit-card-balance-filled' class='form-label start'>Student Loan </p><a href='debt-sources-edit.php?user_id=" . $user_id . "&debt_identifier=" . $row['debt_identifier'] . "' class='link-float-right'>Edit</a>
                                    <p class='card_header'>" . $row['debt_identifier'] . "</p>
                                    <div class='data-descriptor dashboard w-row'>
                                      <div class='w-col w-col-3 w-col-tiny-tiny-stack'>
                                        <p id='credit-card-balance-filled' class='form-label start'>Monthly Payment</p>
                                        <p id='credit-card-balance-filled' class='medium block'>$" . number_format($monthly_payments[$i++],2) . "</p>
                                      </div>
                                      <div class='w-col w-col-3 w-col-tiny-tiny-stack'>
                                        <p id='credit-card-balance-filled' class='form-label start'>Remaining balance</p>
                                        <p id='credit-card-balance-filled' class='medium block'>$" . number_format($row['remaining_balance'],2) . "</p>
                                      </div>
                                      <div class='w-col w-col-3 w-col-tiny-tiny-stack'>
                                        <p id='credit-card-balance-filled' class='form-label start'>Interest Rate</p>
                                        <p id='credit-card-balance-filled' class='medium block'>" . number_format($row['interest_rate'],2) . "%</p>
                                      </div>
                                      <div class='w-col w-col-3 w-col-tiny-tiny-stack'>
                                      <p id='credit-card-balance-filled' class='form-label start'>Remaining Term</p>
                                      <p id='credit-card-balance-filled' class='medium block good'>" .$row['remaining_term'] . "</p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>";

                          }

                          if ($row['debt_type'] == 'Legal Obligation') {
                            echo "
                              <div id='debt-source-block' class='div-block box thin'>
                                <div id='select-type' class='row w-row'>
                                  <div class='debt-sources-type-elements w-col w-col-2 w-col-medium-2 w-col-small-2'>
                                    <div id='icon-student-loan' class='icon large solid'></div>
                                  </div>
                                  <div class='debt-sources-type-elements w-col w-col-10 w-col-medium-10 w-col-small-10'>
                                    <p id='credit-card-balance-filled' class='form-label start'>Legal Obligation </p><a href='debt-sources-edit.php?user_id=" . $user_id . "&debt_identifier=" . $row['debt_identifier'] . "' class='link-float-right'>Edit</a>
                                    <p class='card_header'>" . $row['debt_identifier'] . "</p>
                                    <div class='data-descriptor dashboard w-row'>
                                      <div class='w-col w-col-3 w-col-tiny-tiny-stack'>
                                        <p id='credit-card-balance-filled' class='form-label start'>Monthly Payment</p>
                                        <p id='credit-card-balance-filled' class='medium block'>$" . number_format($monthly_payments[$i++],2) . "</p>
                                      </div>
                                      <div class='w-col w-col-3 w-col-tiny-tiny-stack'>
                                        <p id='credit-card-balance-filled' class='form-label start'></p>
                                        <p id='credit-card-balance-filled' class='medium block'></p>
                                      </div>
                                      <div class='w-col w-col-3 w-col-tiny-tiny-stack'>
                                        <p id='credit-card-balance-filled' class='form-label start'></p>
                                        <p id='credit-card-balance-filled' class='medium block'></p>
                                      </div>
                                      <div class='w-col w-col-3 w-col-tiny-tiny-stack'>
                                      <p id='credit-card-balance-filled' class='form-label start'>Remaining Term</p>
                                      <p id='credit-card-balance-filled' class='medium block good'>" .$row['remaining_term'] . "</p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>";

                          }

                          if ($row['debt_type'] == 'Loan') {
                            echo "
                              <div id='debt-source-block' class='div-block box thin'>
                                <div id='select-type' class='row w-row'>
                                  <div class='debt-sources-type-elements w-col w-col-2 w-col-medium-2 w-col-small-2'>
                                    <div id='icon-student-loan' class='icon large solid'></div>
                                  </div>
                                  <div class='debt-sources-type-elements w-col w-col-10 w-col-medium-10 w-col-small-10'>
                                    <p id='credit-card-balance-filled' class='form-label start'>Loan </p><a href='debt-sources-edit.php?user_id=" . $user_id . "&debt_identifier=" . $row['debt_identifier'] . "' class='link-float-right'>Edit</a>
                                    <p class='card_header'>" . $row['debt_identifier'] . "</p>
                                    <div class='data-descriptor dashboard w-row'>
                                      <div class='w-col w-col-3 w-col-tiny-tiny-stack'>
                                        <p id='credit-card-balance-filled' class='form-label start'>Monthly Payment</p>
                                        <p id='credit-card-balance-filled' class='medium block'>$" . number_format($monthly_payments[$i++],2) . "</p>
                                      </div>
                                      <div class='w-col w-col-3 w-col-tiny-tiny-stack'>
                                        <p id='credit-card-balance-filled' class='form-label start'>Remaining balance</p>
                                        <p id='credit-card-balance-filled' class='medium block'>$" . number_format($row['remaining_balance'],2) . "</p>
                                      </div>
                                      <div class='w-col w-col-3 w-col-tiny-tiny-stack'>
                                        <p id='credit-card-balance-filled' class='form-label start'>Interest Rate</p>
                                        <p id='credit-card-balance-filled' class='medium block'>" . number_format($row['interest_rate'],2) . "%</p>
                                      </div>
                                      <div class='w-col w-col-3 w-col-tiny-tiny-stack'>
                                      <p id='credit-card-balance-filled' class='form-label start'>Remaining Term</p>
                                      <p id='credit-card-balance-filled' class='medium block good'>" .$row['remaining_term'] . "</p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>";
                              //$i++;
                          }

                        }

                        echo
                        "  </div>
                </div>
                <div data-w-tab='Tab 2' class='w-tab-pane'></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class='cta-section'>
        <div class='w-container'>
          <div class='w-row'>
            <div class='column-2 w-col w-col-6 w-col-small-6 w-col-tiny-6'>
            <a href='debt-sources.php?user_id=" . $user_id . "' id='addDebt' class='hollow-button strong'>Add Debt</a></div>
          </div>
        </div>
      </div>
      <div class='footer accent'>
        <div class='w-container'>
          <h1 class='footer-brand-text'>Yada Yada Debt</h1>
          <div class='w-row'>
            <div class='w-col w-col-6'>
              <p>Yada Yada Debt&#x27;s goal it to help those that don&#x27;t get the time of day from Financial Advisors.</p>
              <div><a href='#' class='social-icon-link w-inline-block'><img src='images/social-03.svg' width='20'></a><a href='#' class='social-icon-link w-inline-block'><img src='images/social-18.svg' width='20'></a><a href='#' class='social-icon-link w-inline-block'><img src='images/social-09.svg' width='20'></a><a href='#' class='social-icon-link w-inline-block'><img src='images/social-06.svg' width='20'></a></div>
            </div>
            <div class='w-col w-col-3'><a href='#' class='footer-link'>Money</a><a href='#' class='footer-link'>Debt</a><a href='#' class='footer-link'>Advice</a></div>
            <div class='w-col w-col-3'><a href='#' class='footer-link'>About us</a><a href='#' class='footer-link'>Legal</a></div>
          </div>
        </div>
      </div>";
    }
?>
  </body>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" type="text/javascript" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="js/webflow.js" type="text/javascript"></script>
  <!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->
  <!-- Ravi's changes to include signon BEGIN-->
  <script>
    firebase.auth().onAuthStateChanged(user => {
        // If user is logged in then show log out button, profile button BUT hide the log in button
            if (user) {
                document.getElementById("linkSignOut").style.display = 'inline-block';
                document.getElementById("linkSignIn").style.display = 'none';
            }
            // If user is logged out then show log in button BUT hide the log out button and profile button
            else {
                document.getElementById("linkSignIn").style.display = 'inline-block';
                document.getElementById("linkSignOut").style.display = 'none';
            }
    })
    firebase.auth().onAuthStateChanged(user => {
        if (user) {
            console.log('User is signed in ' + user.displayName);
            //document.getElementsByName("first-name").value = user.displayName;
            $('#first-name').text(user.displayName);
        }
        else {
            console.log('No user is signed in');
            window.location = "login.php"
        }
    })
    document.getElementById("linkSignOut").addEventListener('click', function (event) {
        firebase.auth().signOut();
        console.log('User was signed out');
    })
  </script>
  <!-- Ravi's changes to include signon END-->

  <script>
  $(document).ready(function(){
    var user_monthly_amount = Number(document.getElementById('monthly-amount').value);
    var total_minimum_monthly_payment = Number('<?php echo $total_minimum_monthly_payment; ?>');

    if (user_monthly_amount < total_minimum_monthly_payment) {
      alert("The monthly amount you have set aside does NOT meet your minimum monthly obligations.");
      document.getElementById('monthly-amount').value = total_minimum_monthly_payment;
    }

  });
  </script>
</html>
