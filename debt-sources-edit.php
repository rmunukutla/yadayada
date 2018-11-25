'<!--  This site was created in Webflow. http://www.webflow.com  -->
<!--  Last Published: Fri Aug 03 2018 14:28:40 GMT+0000 (UTC)  -->
<html data-wf-page="5b6067feee5ea259901bf5c7" data-wf-site="5ac55225016bff3a51ced38b">
<head>
  <meta charset="utf-8">
  <title>Yada Yada Debt Sources</title>
  <meta content="Yada Yada Debt Sources" property="og:title">
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

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
    $(document).ready(function(){
      var userVar = 1;
      var submitted = 0;
      $("#saveButton").click(function() {
        //TODO: Add post functionality to save inputs

        //Ravi's code changes begin
        var input_names = document.getElementsByClassName('w-input');
        var dataString = "";
        console.log ("hello");
        $.each(input_names, function(index, obj) {
          console.log(obj.name + ": " + obj.value);
          dataString = dataString + obj.name + ":" + obj.value + ";";
        })
        $.ajax({
          type:"post",
          url:"php/debt-sources-update-backend.php?user_id=" + document.getElementById('uid').value + "&debt_identifier=" + document.getElementById('debt_identifier').value,
          data:dataString,
          cache:false,
          success: function(html){
            if (html != ""){
              $('#msg').html(html);
              console.log(html);
            }
            else if (html == ""){
              //$('#msg').html(html);
              //console.log(html);
              window.location = "dashboard.php?user_id=" + document.getElementById('uid').value;
            }
          },
          error: function(html){
            $('#msg').html(html);
          }
        });
        //Ravi's code changes end

        var count = 0;
        $("[id$=input-box").each(function(){
            var input = $(this);
            if(input.is(":visible")) {
              count++;
              input.find("input[type=submit]").click();
            }
        });

        return false;

      });

      //Remove code changes begin
      $("#removeLink").click(function() {
        console.log('Remove clicked');
        $.ajax({
          type:"post",
          url:"php/remove-debt.php?user_id=" + document.getElementById('uid').value + "&debt_identifier=" + document.getElementById('debt_identifier').value,
          cache:false,
          success: function(html){
            if (html != ""){
              $('#msg').html(html);
              console.log(html);
            }
            else if (html == ""){
              //$('#msg').html(html);
              //console.log(html);
              window.location = "dashboard.php?user_id=" + document.getElementById('uid').value;
            }
          },
          error: function(html){
            $('#msg').html(html);
          }
        });

        return false;

      });
      //Remove end

      $("#continueButton").click(function() {
        //TODO: Add functionality to go to next page.
      });
      $("#source-clickable").click(function() {
        var count = 0;
        $("[id$=input-box").each(function(){
            var input = $(this);
            if(input.is(":visible")) {
              count++;
              input.find("input[type=submit]").click();
            }
        });
        submitted = 0;
        count = 0;
      });
    });
  </script>
  <link href="https://daks2k3a4ib2z.cloudfront.net/img/favicon.ico" rel="shortcut icon" type="image/x-icon">
  <link href="https://daks2k3a4ib2z.cloudfront.net/img/webclip.png" rel="apple-touch-icon">
</head>
<body class="body">
  <?php
  include 'dbconnection.php';

  $user_id = $_REQUEST['user_id'];

  $sql = "SELECT debt_identifier,
                 nick_name,
                 debt_type,
                 original_balance,
                 original_term,
                 interest_type,
                 interest_rate,
                 remaining_balance,
                 remaining_term,
                 minimum_payment
            FROM yadayada.debt_user_input
           WHERE user_id = '" . $_REQUEST['user_id'] . "'
             AND debt_identifier = '" . $_REQUEST['debt_identifier'] . "'";

  $result = $con->query($sql);
  $row = $result->fetch_assoc();
  ?>

  <div data-collapse="medium" data-animation="default" data-duration="400" class="navigation-bar dark w-nav">
    <div class="w-container">
      <a href="index.php" class="brand-link white w-nav-brand">
        <h1 class="brand-text">Yada Yada Debt</h1>
        <div class="icon gold nav-icons">  </div>
      </a>
      <nav role="navigation" class="navigation-menu w-nav-menu">
        <a href="index.php" class="navigation-link white w-nav-link">Home</a>
        <a href="#" class="navigation-link white w-nav-link">About</a>
        <a href="#" class="navigation-link white w-nav-link">Contact</a>
        <!-- Ravi's changes to include signon BEGIN-->
        <a href="/yadayada/login.php" class="navigation-link w-nav-link" id ="linkSignIn">Sign In</a>   <!-- TBD -->
        <a href="#" class="navigation-link w-nav-link" id ="linkSignOut">Sign Out</a>
        <input type="hidden" name="uid" id="uid" value==<?php echo $_REQUEST['user_id'];?>>
        <input type ="hidden" name="debt_identifier" id="debt_identifier" value=<?php echo $_REQUEST['debt_identifier'];?>>
        <!-- Ravi's changes to include signon END-->
      </nav>
    </div>
  </div>

  <div class="section-2">
    <div class="container-top-24 w-container">
      <div>

        <!-- Credit Card -->
        <?php if ($row['debt_type'] == 'Credit Card') : ?>
          <div>
            <div id='credit-card-form' class='w-form'>
              <div>
                <div class='row w-row'>
                  <div class='debt-sources-type-elements w-clearfix w-col w-col-6'>
                    <h4 id='subsectionHeader-credit-card' class='heading'>Credit Card</h4>
                    <a id="removeLink" href='#' data-w-id='2868bbbb-a940-b8ab-10e9-8bd8e9acd28b' class='link2'>Remove</a></div>
                  <div class='debt-sources-type-elements w-col w-col-6'>
                    <div id='icon-credit-card' class='icon regular'></div>
                    <div id='icon-student-loan' class='icon solid disabled'></div>
                    <div id='icon-payday-loan' class='icon solid disabled'></div>
                    <div id='icon-loan' class='icon solid disabled'></div>
                    <div id='icon-legal-obligation' class='icon solid disabled'></div>
                  </div>
                </div>
              </div>

              <form autocomplete='off' id='wf-form-Credit-Card-Form' name='wf-form-Credit-Card-Form' data-name='Credit Card Form' class='ajax'>
                <label for='Credit-Card-Nickname' class='form-label'>Nickname</label>
                <input type='text' class='w-input' maxlength='256' name='Credit-Card-Nickname' data-name='Credit Card Nickname' value='<?php echo $row['nick_name'];?>' id='Credit-Card-Nickname' required=''>
                <div class='data-descriptor'>
                  <div>At this point, what is your...</div>
                </div><label for='credit-card-balance' class='form-label'>Balance</label>
                <input type='number' step='0.01' class='w-input' maxlength='256' name='credit-card-balance' data-name='Credit Card Balance' value=<?php echo $row['remaining_balance'];?> id='credit-card-balance' required=''>
                <label for='credit-card-min-payment' class='form-label'>Minimum Payment</label>
                <input type='number' step='0.01' class='w-input' maxlength='256' name='credit-card-min-payment' data-name='Credit Card Min Payment' value=<?php echo $row['minimum_payment'];?> id='credit-card-min-payment' required=''>
                <label for='credit-card-apr' class='form-label'>APR</label>
                <input type='number' step='0.01' class='w-input' maxlength='256' name='credit-card-apr' data-name='Credit Card Apr' value=<?php echo $row['interest_rate'];?> id='credit-card-apr' required=''>
                <input type='submit' value='Add' style='display: none' data-wait='Please wait...' data-w-id='2868bbbb-a940-b8ab-10e9-8bd8e9acd2a8' class='button w-button'></form>

            </div>
          </div>

      <?php elseif ($row['debt_type'] == 'Student Loan') : ?>
        <!-- Student Loan -->
        <div id="debt-student-loan-input-box" class="div-block box">
          <div id="student-loan-form" class="w-form">
            <div>
              <div id="select-type" class="row w-row">
                <div class="debt-sources-type-elements w-clearfix w-col w-col-6">
                  <h4 id="subsectionHeader-student-loan" class="heading">Student Loan</h4>
                  <a href="#" id="removeLink" data-w-id="c5633638-eaa6-b16a-b819-0fd57d5d78b2" class="link2">Remove</a></div>
                <div class="debt-sources-type-elements w-col w-col-6">
                  <div id="icon-credit-card" class="icon regular disabled"></div>
                  <div id="icon-student-loan" class="icon solid"></div>
                  <div id="icon-payday-loan" class="icon solid disabled"></div>
                  <div id="icon-loan" class="icon solid disabled"></div>
                  <div id="icon-legal-obligation" class="icon solid disabled"></div>
                </div>
              </div>
            </div>
            <form autocomplete="off" id="wf-form-Student-Loan-Form" name="wf-form-Student-Loan-Form" data-name="Student Loan Form">
              <label for="Student-Loan-Nickname" class="form-label">Nickname</label>
              <input type="text" class="w-input" maxlength="256" name="Student-Loan-Nickname" data-name="Student Loan Nickname" value='<?php echo $row['nick_name'];?>' placeholder="e.g. For My Great Education" id="Student-Loan-Nickname" required="">
              <div class="data-descriptor">
                <div>At this point, what was your...</div>
              </div><label for="Student-Loan-Remaining-Balance" class="form-label">Remaining Balance</label>
              <input type="number" step="0.01" class="w-input" maxlength="256" name="Student-Loan-Remaining-Balance" data-name="Student Loan Remaining Balance" value=<?php echo $row['remaining_balance'];?> placeholder="e.g. $86,000.00" id="Original-Student-Loan-Amount" required="">
              <label for="Student-Loan-Interest-Rate" class="form-label">Interest Rate</label>
              <input type="number" step="0.01" class="w-input" maxlength="256" name="Student-Loan-Interest-Rate" data-name="Student Loan Interest Rate" value=<?php echo $row['interest_rate'];?> placeholder="e.g.  4.45%" id="Student-Loan-Interest-Rate" required="">
              <label for="Student-Loan-Remain-Term" class="form-label">Remaining Term</label>
              <select id="Student-Loan-Remain-Term" name="Student-Loan-Remain-Term" data-name="Student Loan Remain Term" class="w-input" required="">
                <option value="">Select one...</option><option value="1 month" <?php if($row['remaining_term']==1) echo 'selected="selected"'; ?> >1 month</option><option value="2 months" <?php if($row['remaining_term']==2) echo 'selected="selected"'; ?>>2 months</option><option value="3 months" <?php if($row['remaining_term']==3) echo 'selected="selected"'; ?> >3 months</option><option value="4 months" <?php if($row['remaining_term']==4) echo 'selected="selected"'; ?>>4 months</option><option value="5 months" <?php if($row['remaining_term']==5) echo 'selected="selected"'; ?>>5 months</option><option value="6 months" <?php if($row['remaining_term']==6) echo 'selected="selected"'; ?>>6 months</option><option value="7 months" <?php if($row['remaining_term']==7) echo 'selected="selected"'; ?>>7 months</option><option value="8 months" <?php if($row['remaining_term']==8) echo 'selected="selected"'; ?>>8 months</option><option value="9 months" <?php if($row['remaining_term']==9) echo 'selected="selected"'; ?>>9 months</option><option value="10 months" <?php if($row['remaining_term']==10) echo 'selected="selected"'; ?>>10 months</option><option value="11 months" <?php if($row['remaining_term']==11) echo 'selected="selected"'; ?>>11 months</option><option value="12 months" <?php if($row['remaining_term']==12) echo 'selected="selected"'; ?>>12 months (1 year)</option><option value="13 months" <?php if($row['remaining_term']==13) echo 'selected="selected"'; ?>>13 months</option><option value="14 months" <?php if($row['remaining_term']==14) echo 'selected="selected"'; ?>>14 months</option><option value="15 months" <?php if($row['remaining_term']==15) echo 'selected="selected"'; ?>>15 months</option><option value="16 months" <?php if($row['remaining_term']==16) echo 'selected="selected"'; ?>>16 months</option><option value="17 months" <?php if($row['remaining_term']==17) echo 'selected="selected"'; ?>>17 months</option><option value="18 months" <?php if($row['remaining_term']==18) echo 'selected="selected"'; ?>>18 months</option><option value="19 months" <?php if($row['remaining_term']==19) echo 'selected="selected"'; ?>>19 months</option><option value="20 months" <?php if($row['remaining_term']==20) echo 'selected="selected"'; ?>>20 months</option><option value="21 months" <?php if($row['remaining_term']==21) echo 'selected="selected"'; ?>>21 months</option><option value="22 months" <?php if($row['remaining_term']==22) echo 'selected="selected"'; ?>>22 months</option><option value="23 months" <?php if($row['remaining_term']==23) echo 'selected="selected"'; ?>>23 months</option><option value="24 months" <?php if($row['remaining_term']==24) echo 'selected="selected"'; ?>>24 months (2 years)</option><option value="25 months" <?php if($row['remaining_term']==25) echo 'selected="selected"'; ?>>25 months</option><option value="26 months" <?php if($row['remaining_term']==26) echo 'selected="selected"'; ?>>26 months</option><option value="27 months" <?php if($row['remaining_term']==27) echo 'selected="selected"'; ?>>27 months</option><option value="28 months" <?php if($row['remaining_term']==28) echo 'selected="selected"'; ?>>28 months</option><option value="29 months" <?php if($row['remaining_term']==29) echo 'selected="selected"'; ?>>29 months</option><option value="30 months" <?php if($row['remaining_term']==30) echo 'selected="selected"'; ?>>30 months</option><option value="31 months" <?php if($row['remaining_term']==31) echo 'selected="selected"'; ?>>31 months</option><option value="32 months" <?php if($row['remaining_term']==32) echo 'selected="selected"'; ?>>32 months</option><option value="33 months" <?php if($row['remaining_term']==33) echo 'selected="selected"'; ?>>33 months</option><option value="34 months" <?php if($row['remaining_term']==34) echo 'selected="selected"'; ?>>34 months</option><option value="35 months" <?php if($row['remaining_term']==35) echo 'selected="selected"'; ?>>35 months</option><option value="36 months" <?php if($row['remaining_term']==36) echo 'selected="selected"'; ?>>36 months (3 years)</option><option value="37 months" <?php if($row['remaining_term']==37) echo 'selected="selected"'; ?>>37 months</option><option value="38 months" <?php if($row['remaining_term']==38) echo 'selected="selected"'; ?>>38 months</option><option value="39 months" <?php if($row['remaining_term']==39) echo 'selected="selected"'; ?>>39 months</option><option value="40 months" <?php if($row['remaining_term']==40) echo 'selected="selected"'; ?>>40 months</option><option value="41 months" <?php if($row['remaining_term']==41) echo 'selected="selected"'; ?>>41 months</option><option value="42 months" <?php if($row['remaining_term']==42) echo 'selected="selected"'; ?>>42 months</option><option value="43 months" <?php if($row['remaining_term']==43) echo 'selected="selected"'; ?>>43 months</option><option value="44 months" <?php if($row['remaining_term']==44) echo 'selected="selected"'; ?>>44 months</option><option value="45 months" <?php if($row['remaining_term']==45) echo 'selected="selected"'; ?>>45 months</option><option value="46 months" <?php if($row['remaining_term']==46) echo 'selected="selected"'; ?>>46 months</option><option value="47 months" <?php if($row['remaining_term']==47) echo 'selected="selected"'; ?>>47 months</option><option value="48 months" <?php if($row['remaining_term']==48) echo 'selected="selected"'; ?>>48 months (4 years)</option><option value="49 months" <?php if($row['remaining_term']==49) echo 'selected="selected"'; ?>>49 months</option><option value="50 months" <?php if($row['remaining_term']==50) echo 'selected="selected"'; ?>>50 months</option><option value="51 months" <?php if($row['remaining_term']==51) echo 'selected="selected"'; ?>>51 months</option><option value="52 months" <?php if($row['remaining_term']==52) echo 'selected="selected"'; ?>>52 months</option><option value="53 months" <?php if($row['remaining_term']==53) echo 'selected="selected"'; ?>>53 months</option><option value="54 months" <?php if($row['remaining_term']==54) echo 'selected="selected"'; ?>>54 months</option><option value="55 months" <?php if($row['remaining_term']==55) echo 'selected="selected"'; ?>>55 months</option><option value="56 months" <?php if($row['remaining_term']==56) echo 'selected="selected"'; ?>>56 months</option><option value="57 months" <?php if($row['remaining_term']==57) echo 'selected="selected"'; ?>>57 months</option><option value="58 months" <?php if($row['remaining_term']==58) echo 'selected="selected"'; ?>>58 months</option><option value="59 months" <?php if($row['remaining_term']==59) echo 'selected="selected"'; ?>>59 months</option><option value="60 months" <?php if($row['remaining_term']==60) echo 'selected="selected"'; ?>>60 months (5 years)</option><option value="61 months" <?php if($row['remaining_term']==61) echo 'selected="selected"'; ?>>61 months</option><option value="62 months" <?php if($row['remaining_term']==62) echo 'selected="selected"'; ?>>62 months</option><option value="63 months" <?php if($row['remaining_term']==63) echo 'selected="selected"'; ?>>63 months</option><option value="64 months" <?php if($row['remaining_term']==64) echo 'selected="selected"'; ?>>64 months</option><option value="65 months" <?php if($row['remaining_term']==65) echo 'selected="selected"'; ?>>65 months</option><option value="66 months" <?php if($row['remaining_term']==66) echo 'selected="selected"'; ?>>66 months</option><option value="67 months" <?php if($row['remaining_term']==67) echo 'selected="selected"'; ?>>67 months</option><option value="68 months" <?php if($row['remaining_term']==68) echo 'selected="selected"'; ?>>68 months</option><option value="69 months" <?php if($row['remaining_term']==69) echo 'selected="selected"'; ?>>69 months</option><option value="70 months" <?php if($row['remaining_term']==70) echo 'selected="selected"'; ?>>70 months</option><option value="71 months" <?php if($row['remaining_term']==71) echo 'selected="selected"'; ?>>71 months</option><option value="72 months" <?php if($row['remaining_term']==72) echo 'selected="selected"'; ?>>72 months (6 years)</option><option value="73 months" <?php if($row['remaining_term']==73) echo 'selected="selected"'; ?>>73 months</option><option value="74 months" <?php if($row['remaining_term']==74) echo 'selected="selected"'; ?>>74 months</option><option value="75 months" <?php if($row['remaining_term']==75) echo 'selected="selected"'; ?>>75 months</option><option value="76 months" <?php if($row['remaining_term']==76) echo 'selected="selected"'; ?>>76 months</option><option value="77 months" <?php if($row['remaining_term']==77) echo 'selected="selected"'; ?>>77 months</option><option value="78 months" <?php if($row['remaining_term']==78) echo 'selected="selected"'; ?>>78 months</option><option value="79 months" <?php if($row['remaining_term']==79) echo 'selected="selected"'; ?>>79 months</option><option value="80 months" <?php if($row['remaining_term']==80) echo 'selected="selected"'; ?>>80 months</option><option value="81 months" <?php if($row['remaining_term']==81) echo 'selected="selected"'; ?>>81 months</option><option value="82 months" <?php if($row['remaining_term']==82) echo 'selected="selected"'; ?>>82 months</option><option value="83 months" <?php if($row['remaining_term']==83) echo 'selected="selected"'; ?>>83 months</option><option value="84 months" <?php if($row['remaining_term']==84) echo 'selected="selected"'; ?>>84 months (7 years)</option><option value="85 months" <?php if($row['remaining_term']==85) echo 'selected="selected"'; ?>>85 months</option><option value="86 months" <?php if($row['remaining_term']==86) echo 'selected="selected"'; ?>>86 months</option><option value="87 months" <?php if($row['remaining_term']==87) echo 'selected="selected"'; ?>>87 months</option><option value="88 months" <?php if($row['remaining_term']==88) echo 'selected="selected"'; ?>>88 months</option><option value="89 months" <?php if($row['remaining_term']==89) echo 'selected="selected"'; ?>>89 months</option><option value="90 months" <?php if($row['remaining_term']==90) echo 'selected="selected"'; ?>>90 months</option><option value="91 months" <?php if($row['remaining_term']==91) echo 'selected="selected"'; ?>>91 months</option><option value="92 months" <?php if($row['remaining_term']==92) echo 'selected="selected"'; ?>>92 months</option><option value="93 months" <?php if($row['remaining_term']==93) echo 'selected="selected"'; ?>>93 months</option><option value="94 months" <?php if($row['remaining_term']==94) echo 'selected="selected"'; ?>>94 months</option><option value="95 months" <?php if($row['remaining_term']==95) echo 'selected="selected"'; ?>>95 months</option><option value="96 months" <?php if($row['remaining_term']==96) echo 'selected="selected"'; ?>>96 months (8 years)</option><option value="97 months" <?php if($row['remaining_term']==97) echo 'selected="selected"'; ?>>97 months</option><option value="98 months" <?php if($row['remaining_term']==98) echo 'selected="selected"'; ?>>98 months</option><option value="99 months" <?php if($row['remaining_term']==99) echo 'selected="selected"'; ?>>99 months</option><option value="100 months" <?php if($row['remaining_term']==100) echo 'selected="selected"'; ?>>100 months</option><option value="101 months" <?php if($row['remaining_term']==101) echo 'selected="selected"'; ?>>101 months</option><option value="102 months" <?php if($row['remaining_term']==102) echo 'selected="selected"'; ?>>102 months</option></select><input type="submit" value="Add" style="display: none" data-wait="Please wait..." data-w-id="c5633638-eaa6-b16a-b819-0fd57d5d78cf" class="button w-button"></form>

              </div>
            </div>

            <?php elseif ($row['debt_type'] == 'Payday Loan') : ?>
              <!-- Payday Loan -->

                <div >
                <div id='payday-loan-form' class='w-form'>
                <div>
                <div id='select-type' class='row w-row'>
                  <div class='debt-sources-type-elements w-clearfix w-col w-col-6'>
                    <h4 id='subsectionHeader-payday-loan' class='heading'>Payday Loan</h4>
                    <a href='#' id="removeLink" data-w-id='3ddb9951-50d1-3b02-708d-a904c024696b' class='link2'>Remove</a></div>
                  <div class='debt-sources-type-elements w-col w-col-6'>
                    <div id='icon-credit-card' class='icon regular disabled'></div>
                    <div id='icon-student-loan' class='icon solid disabled'></div>
                    <div id='icon-payday-loan' class='icon solid'></div>
                    <div id='icon-loan' class='icon solid disabled'></div>
                    <div id='icon-legal-obligation' class='icon solid disabled'></div>
                  </div>
                </div>
                </div>
                <form autocomplete='off' id='wf-form-Payday-Loan-Form' name='wf-form-Payday-Loan-Form' data-name='Payday Loan Form'>
                <label for='Payday-Loan-Nickname' class='form-label'>Nickname</label>
                <input type='text' class='w-input' maxlength='256' name='Payday-Loan-Nickname' data-name='Payday Loan Nickname' value='<?php echo $row['nick_name'];?>' placeholder='e.g. A Quick Fix' id='Payday-Loan-Nickname' required=''>
                <div class='data-descriptor'>
                  <div>So tell me, what was your...</div>
                </div><label for='Payday-Remaining-Balance' class='form-label'>Remaining Balance</label>
                <input type='number' step='0.01' class='w-input' maxlength='256' name='Payday-Remaining-Balance' data-name='Payday Remaining Balance' value=<?php echo $row['remaining_balance'];?> placeholder='e.g. $1,000.00' id='Original-Payday-Loan-Amount' required=''>
                <label for='Payday-Loan-Interest-Rate' class='form-label'>Interest Rate</label>
                <input type='number' step='0.01' class='w-input' maxlength='256' name='Payday-Loan-Interest-Rate' data-name='Payday Loan Interest Rate' value=<?php echo $row['interest_rate'];?> placeholder='e.g.  400%' id='Payday-Loan-Interest-Rate' required=''>
                <label for='Payday-Loan-Remain-Term' class='form-label'>Remaining Term</label>
                <select id='Payday-Remaining-Term' name='Legal-Obligation-Remaining-Term' data-name='Payday Remaining Term' class='w-input' required=''>
                  <option value="">Select one...</option><option value="1 month" <?php if($row['remaining_term']==1) echo 'selected="selected"'; ?> >1 month</option><option value="2 months" <?php if($row['remaining_term']==2) echo 'selected="selected"'; ?>>2 months</option><option value="3 months" <?php if($row['remaining_term']==3) echo 'selected="selected"'; ?> >3 months</option><option value="4 months" <?php if($row['remaining_term']==4) echo 'selected="selected"'; ?>>4 months</option><option value="5 months" <?php if($row['remaining_term']==5) echo 'selected="selected"'; ?>>5 months</option><option value="6 months" <?php if($row['remaining_term']==6) echo 'selected="selected"'; ?>>6 months</option><option value="7 months" <?php if($row['remaining_term']==7) echo 'selected="selected"'; ?>>7 months</option><option value="8 months" <?php if($row['remaining_term']==8) echo 'selected="selected"'; ?>>8 months</option><option value="9 months" <?php if($row['remaining_term']==9) echo 'selected="selected"'; ?>>9 months</option><option value="10 months" <?php if($row['remaining_term']==10) echo 'selected="selected"'; ?>>10 months</option><option value="11 months" <?php if($row['remaining_term']==11) echo 'selected="selected"'; ?>>11 months</option><option value="12 months" <?php if($row['remaining_term']==12) echo 'selected="selected"'; ?>>12 months (1 year)</option><option value="13 months" <?php if($row['remaining_term']==13) echo 'selected="selected"'; ?>>13 months</option><option value="14 months" <?php if($row['remaining_term']==14) echo 'selected="selected"'; ?>>14 months</option><option value="15 months" <?php if($row['remaining_term']==15) echo 'selected="selected"'; ?>>15 months</option><option value="16 months" <?php if($row['remaining_term']==16) echo 'selected="selected"'; ?>>16 months</option><option value="17 months" <?php if($row['remaining_term']==17) echo 'selected="selected"'; ?>>17 months</option><option value="18 months" <?php if($row['remaining_term']==18) echo 'selected="selected"'; ?>>18 months</option><option value="19 months" <?php if($row['remaining_term']==19) echo 'selected="selected"'; ?>>19 months</option><option value="20 months" <?php if($row['remaining_term']==20) echo 'selected="selected"'; ?>>20 months</option><option value="21 months" <?php if($row['remaining_term']==21) echo 'selected="selected"'; ?>>21 months</option><option value="22 months" <?php if($row['remaining_term']==22) echo 'selected="selected"'; ?>>22 months</option><option value="23 months" <?php if($row['remaining_term']==23) echo 'selected="selected"'; ?>>23 months</option><option value="24 months" <?php if($row['remaining_term']==24) echo 'selected="selected"'; ?>>24 months (2 years)</option><option value="25 months" <?php if($row['remaining_term']==25) echo 'selected="selected"'; ?>>25 months</option><option value="26 months" <?php if($row['remaining_term']==26) echo 'selected="selected"'; ?>>26 months</option><option value="27 months" <?php if($row['remaining_term']==27) echo 'selected="selected"'; ?>>27 months</option><option value="28 months" <?php if($row['remaining_term']==28) echo 'selected="selected"'; ?>>28 months</option><option value="29 months" <?php if($row['remaining_term']==29) echo 'selected="selected"'; ?>>29 months</option><option value="30 months" <?php if($row['remaining_term']==30) echo 'selected="selected"'; ?>>30 months</option><option value="31 months" <?php if($row['remaining_term']==31) echo 'selected="selected"'; ?>>31 months</option><option value="32 months" <?php if($row['remaining_term']==32) echo 'selected="selected"'; ?>>32 months</option><option value="33 months" <?php if($row['remaining_term']==33) echo 'selected="selected"'; ?>>33 months</option><option value="34 months" <?php if($row['remaining_term']==34) echo 'selected="selected"'; ?>>34 months</option><option value="35 months" <?php if($row['remaining_term']==35) echo 'selected="selected"'; ?>>35 months</option><option value="36 months" <?php if($row['remaining_term']==36) echo 'selected="selected"'; ?>>36 months (3 years)</option><option value="37 months" <?php if($row['remaining_term']==37) echo 'selected="selected"'; ?>>37 months</option><option value="38 months" <?php if($row['remaining_term']==38) echo 'selected="selected"'; ?>>38 months</option><option value="39 months" <?php if($row['remaining_term']==39) echo 'selected="selected"'; ?>>39 months</option><option value="40 months" <?php if($row['remaining_term']==40) echo 'selected="selected"'; ?>>40 months</option><option value="41 months" <?php if($row['remaining_term']==41) echo 'selected="selected"'; ?>>41 months</option><option value="42 months" <?php if($row['remaining_term']==42) echo 'selected="selected"'; ?>>42 months</option><option value="43 months" <?php if($row['remaining_term']==43) echo 'selected="selected"'; ?>>43 months</option><option value="44 months" <?php if($row['remaining_term']==44) echo 'selected="selected"'; ?>>44 months</option><option value="45 months" <?php if($row['remaining_term']==45) echo 'selected="selected"'; ?>>45 months</option><option value="46 months" <?php if($row['remaining_term']==46) echo 'selected="selected"'; ?>>46 months</option><option value="47 months" <?php if($row['remaining_term']==47) echo 'selected="selected"'; ?>>47 months</option><option value="48 months" <?php if($row['remaining_term']==48) echo 'selected="selected"'; ?>>48 months (4 years)</option><option value="49 months" <?php if($row['remaining_term']==49) echo 'selected="selected"'; ?>>49 months</option><option value="50 months" <?php if($row['remaining_term']==50) echo 'selected="selected"'; ?>>50 months</option><option value="51 months" <?php if($row['remaining_term']==51) echo 'selected="selected"'; ?>>51 months</option><option value="52 months" <?php if($row['remaining_term']==52) echo 'selected="selected"'; ?>>52 months</option><option value="53 months" <?php if($row['remaining_term']==53) echo 'selected="selected"'; ?>>53 months</option><option value="54 months" <?php if($row['remaining_term']==54) echo 'selected="selected"'; ?>>54 months</option><option value="55 months" <?php if($row['remaining_term']==55) echo 'selected="selected"'; ?>>55 months</option><option value="56 months" <?php if($row['remaining_term']==56) echo 'selected="selected"'; ?>>56 months</option><option value="57 months" <?php if($row['remaining_term']==57) echo 'selected="selected"'; ?>>57 months</option><option value="58 months" <?php if($row['remaining_term']==58) echo 'selected="selected"'; ?>>58 months</option><option value="59 months" <?php if($row['remaining_term']==59) echo 'selected="selected"'; ?>>59 months</option><option value="60 months" <?php if($row['remaining_term']==60) echo 'selected="selected"'; ?>>60 months (5 years)</option><option value="61 months" <?php if($row['remaining_term']==61) echo 'selected="selected"'; ?>>61 months</option><option value="62 months" <?php if($row['remaining_term']==62) echo 'selected="selected"'; ?>>62 months</option><option value="63 months" <?php if($row['remaining_term']==63) echo 'selected="selected"'; ?>>63 months</option><option value="64 months" <?php if($row['remaining_term']==64) echo 'selected="selected"'; ?>>64 months</option><option value="65 months" <?php if($row['remaining_term']==65) echo 'selected="selected"'; ?>>65 months</option><option value="66 months" <?php if($row['remaining_term']==66) echo 'selected="selected"'; ?>>66 months</option><option value="67 months" <?php if($row['remaining_term']==67) echo 'selected="selected"'; ?>>67 months</option><option value="68 months" <?php if($row['remaining_term']==68) echo 'selected="selected"'; ?>>68 months</option><option value="69 months" <?php if($row['remaining_term']==69) echo 'selected="selected"'; ?>>69 months</option><option value="70 months" <?php if($row['remaining_term']==70) echo 'selected="selected"'; ?>>70 months</option><option value="71 months" <?php if($row['remaining_term']==71) echo 'selected="selected"'; ?>>71 months</option><option value="72 months" <?php if($row['remaining_term']==72) echo 'selected="selected"'; ?>>72 months (6 years)</option><option value="73 months" <?php if($row['remaining_term']==73) echo 'selected="selected"'; ?>>73 months</option><option value="74 months" <?php if($row['remaining_term']==74) echo 'selected="selected"'; ?>>74 months</option><option value="75 months" <?php if($row['remaining_term']==75) echo 'selected="selected"'; ?>>75 months</option><option value="76 months" <?php if($row['remaining_term']==76) echo 'selected="selected"'; ?>>76 months</option><option value="77 months" <?php if($row['remaining_term']==77) echo 'selected="selected"'; ?>>77 months</option><option value="78 months" <?php if($row['remaining_term']==78) echo 'selected="selected"'; ?>>78 months</option><option value="79 months" <?php if($row['remaining_term']==79) echo 'selected="selected"'; ?>>79 months</option><option value="80 months" <?php if($row['remaining_term']==80) echo 'selected="selected"'; ?>>80 months</option><option value="81 months" <?php if($row['remaining_term']==81) echo 'selected="selected"'; ?>>81 months</option><option value="82 months" <?php if($row['remaining_term']==82) echo 'selected="selected"'; ?>>82 months</option><option value="83 months" <?php if($row['remaining_term']==83) echo 'selected="selected"'; ?>>83 months</option><option value="84 months" <?php if($row['remaining_term']==84) echo 'selected="selected"'; ?>>84 months (7 years)</option><option value="85 months" <?php if($row['remaining_term']==85) echo 'selected="selected"'; ?>>85 months</option><option value="86 months" <?php if($row['remaining_term']==86) echo 'selected="selected"'; ?>>86 months</option><option value="87 months" <?php if($row['remaining_term']==87) echo 'selected="selected"'; ?>>87 months</option><option value="88 months" <?php if($row['remaining_term']==88) echo 'selected="selected"'; ?>>88 months</option><option value="89 months" <?php if($row['remaining_term']==89) echo 'selected="selected"'; ?>>89 months</option><option value="90 months" <?php if($row['remaining_term']==90) echo 'selected="selected"'; ?>>90 months</option><option value="91 months" <?php if($row['remaining_term']==91) echo 'selected="selected"'; ?>>91 months</option><option value="92 months" <?php if($row['remaining_term']==92) echo 'selected="selected"'; ?>>92 months</option><option value="93 months" <?php if($row['remaining_term']==93) echo 'selected="selected"'; ?>>93 months</option><option value="94 months" <?php if($row['remaining_term']==94) echo 'selected="selected"'; ?>>94 months</option><option value="95 months" <?php if($row['remaining_term']==95) echo 'selected="selected"'; ?>>95 months</option><option value="96 months" <?php if($row['remaining_term']==96) echo 'selected="selected"'; ?>>96 months (8 years)</option><option value="97 months" <?php if($row['remaining_term']==97) echo 'selected="selected"'; ?>>97 months</option><option value="98 months" <?php if($row['remaining_term']==98) echo 'selected="selected"'; ?>>98 months</option><option value="99 months" <?php if($row['remaining_term']==99) echo 'selected="selected"'; ?>>99 months</option><option value="100 months" <?php if($row['remaining_term']==100) echo 'selected="selected"'; ?>>100 months</option><option value="101 months" <?php if($row['remaining_term']==101) echo 'selected="selected"'; ?>>101 months</option><option value="102 months" <?php if($row['remaining_term']==102) echo 'selected="selected"'; ?>>102 months</option></select><input type="submit" value="Add" style="display: none" data-wait="Please wait..." data-w-id="c5633638-eaa6-b16a-b819-0fd57d5d78cf" class="button w-button"></form>
              </div>
            </div>

          <?php elseif ($row['debt_type'] == 'Loan') : ?>
            <!-- Payday Loan -->
            <div >
            <div id='loan-form' class='w-form'>
            <div>
            <div id='select-type' class='row w-row'>
              <div class='debt-sources-type-elements w-clearfix w-col w-col-6'>
                <h4 id='subsectionHeader-loan' class='heading'>Loan</h4>
                <a href='#' id="removeLink" data-w-id='6061c2fa-9f89-d152-9cd0-270f3c2a2fe5' class='link2'>Remove</a></div>
              <div class='debt-sources-type-elements w-col w-col-6'>
                <div id='icon-credit-card' class='icon regular disabled'></div>
                <div id='icon-student-loan' class='icon solid disabled'></div>
                <div id='icon-payday-loan' class='icon solid disabled'></div>
                <div id='icon-loan' class='icon solid'></div>
                <div id='icon-legal-obligation' class='icon solid disabled'></div>
              </div>
            </div>
            </div>
            <form autocomplete='off' id='wf-form-Loan-Form' name='wf-form-Loan-Form' data-name='Loan Form'>
            <label for='Loan-Nickname' class='form-label'>Nickname</label>
            <input type='text' class='w-input' maxlength='256' name='Loan-Nickname' value='<?php echo $row['nick_name'];?>' data-name='Loan Nickname' placeholder='e.g. For My Car' id='Loan-Nickname' required=''>
            <div class='data-descriptor'>
              <div>So tell me, what was your...</div>
            </div><label for='Remaining-Loan-Balance' class='form-label'>Remaining Loan Balance</label>
            <input type='number' step='0.01' class='w-input' maxlength='256' name='Remaining-Loan-Amount' value=<?php echo $row['remaining_balance'];?> data-name='Remaining Loan Amount' placeholder='e.g. $30,000.00' id='Original-Loan-Amount' required=''>
            <label for='Loan-Interest-Rate' class='form-label'>Interest Rate</label>
            <input type='number' step='0.01' class='w-input' maxlength='256' name='Loan-Interest-Rate' value=<?php echo $row['interest_rate'];?> data-name='Loan Interest Rate' placeholder='e.g.  29.99%' id='Loan-Interest-Rate' required=''>
            <label for='Loan-Remain-Term' class='form-label'>Remaining Term</label><select id='Loan-Remain-Term' name='Loan-Remain-Term' data-name='Loan Remain Term' class='w-input' required=''>
              <option value="">Select one...</option><option value="1 month" <?php if($row['remaining_term']==1) echo 'selected="selected"'; ?> >1 month</option><option value="2 months" <?php if($row['remaining_term']==2) echo 'selected="selected"'; ?>>2 months</option><option value="3 months" <?php if($row['remaining_term']==3) echo 'selected="selected"'; ?> >3 months</option><option value="4 months" <?php if($row['remaining_term']==4) echo 'selected="selected"'; ?>>4 months</option><option value="5 months" <?php if($row['remaining_term']==5) echo 'selected="selected"'; ?>>5 months</option><option value="6 months" <?php if($row['remaining_term']==6) echo 'selected="selected"'; ?>>6 months</option><option value="7 months" <?php if($row['remaining_term']==7) echo 'selected="selected"'; ?>>7 months</option><option value="8 months" <?php if($row['remaining_term']==8) echo 'selected="selected"'; ?>>8 months</option><option value="9 months" <?php if($row['remaining_term']==9) echo 'selected="selected"'; ?>>9 months</option><option value="10 months" <?php if($row['remaining_term']==10) echo 'selected="selected"'; ?>>10 months</option><option value="11 months" <?php if($row['remaining_term']==11) echo 'selected="selected"'; ?>>11 months</option><option value="12 months" <?php if($row['remaining_term']==12) echo 'selected="selected"'; ?>>12 months (1 year)</option><option value="13 months" <?php if($row['remaining_term']==13) echo 'selected="selected"'; ?>>13 months</option><option value="14 months" <?php if($row['remaining_term']==14) echo 'selected="selected"'; ?>>14 months</option><option value="15 months" <?php if($row['remaining_term']==15) echo 'selected="selected"'; ?>>15 months</option><option value="16 months" <?php if($row['remaining_term']==16) echo 'selected="selected"'; ?>>16 months</option><option value="17 months" <?php if($row['remaining_term']==17) echo 'selected="selected"'; ?>>17 months</option><option value="18 months" <?php if($row['remaining_term']==18) echo 'selected="selected"'; ?>>18 months</option><option value="19 months" <?php if($row['remaining_term']==19) echo 'selected="selected"'; ?>>19 months</option><option value="20 months" <?php if($row['remaining_term']==20) echo 'selected="selected"'; ?>>20 months</option><option value="21 months" <?php if($row['remaining_term']==21) echo 'selected="selected"'; ?>>21 months</option><option value="22 months" <?php if($row['remaining_term']==22) echo 'selected="selected"'; ?>>22 months</option><option value="23 months" <?php if($row['remaining_term']==23) echo 'selected="selected"'; ?>>23 months</option><option value="24 months" <?php if($row['remaining_term']==24) echo 'selected="selected"'; ?>>24 months (2 years)</option><option value="25 months" <?php if($row['remaining_term']==25) echo 'selected="selected"'; ?>>25 months</option><option value="26 months" <?php if($row['remaining_term']==26) echo 'selected="selected"'; ?>>26 months</option><option value="27 months" <?php if($row['remaining_term']==27) echo 'selected="selected"'; ?>>27 months</option><option value="28 months" <?php if($row['remaining_term']==28) echo 'selected="selected"'; ?>>28 months</option><option value="29 months" <?php if($row['remaining_term']==29) echo 'selected="selected"'; ?>>29 months</option><option value="30 months" <?php if($row['remaining_term']==30) echo 'selected="selected"'; ?>>30 months</option><option value="31 months" <?php if($row['remaining_term']==31) echo 'selected="selected"'; ?>>31 months</option><option value="32 months" <?php if($row['remaining_term']==32) echo 'selected="selected"'; ?>>32 months</option><option value="33 months" <?php if($row['remaining_term']==33) echo 'selected="selected"'; ?>>33 months</option><option value="34 months" <?php if($row['remaining_term']==34) echo 'selected="selected"'; ?>>34 months</option><option value="35 months" <?php if($row['remaining_term']==35) echo 'selected="selected"'; ?>>35 months</option><option value="36 months" <?php if($row['remaining_term']==36) echo 'selected="selected"'; ?>>36 months (3 years)</option><option value="37 months" <?php if($row['remaining_term']==37) echo 'selected="selected"'; ?>>37 months</option><option value="38 months" <?php if($row['remaining_term']==38) echo 'selected="selected"'; ?>>38 months</option><option value="39 months" <?php if($row['remaining_term']==39) echo 'selected="selected"'; ?>>39 months</option><option value="40 months" <?php if($row['remaining_term']==40) echo 'selected="selected"'; ?>>40 months</option><option value="41 months" <?php if($row['remaining_term']==41) echo 'selected="selected"'; ?>>41 months</option><option value="42 months" <?php if($row['remaining_term']==42) echo 'selected="selected"'; ?>>42 months</option><option value="43 months" <?php if($row['remaining_term']==43) echo 'selected="selected"'; ?>>43 months</option><option value="44 months" <?php if($row['remaining_term']==44) echo 'selected="selected"'; ?>>44 months</option><option value="45 months" <?php if($row['remaining_term']==45) echo 'selected="selected"'; ?>>45 months</option><option value="46 months" <?php if($row['remaining_term']==46) echo 'selected="selected"'; ?>>46 months</option><option value="47 months" <?php if($row['remaining_term']==47) echo 'selected="selected"'; ?>>47 months</option><option value="48 months" <?php if($row['remaining_term']==48) echo 'selected="selected"'; ?>>48 months (4 years)</option><option value="49 months" <?php if($row['remaining_term']==49) echo 'selected="selected"'; ?>>49 months</option><option value="50 months" <?php if($row['remaining_term']==50) echo 'selected="selected"'; ?>>50 months</option><option value="51 months" <?php if($row['remaining_term']==51) echo 'selected="selected"'; ?>>51 months</option><option value="52 months" <?php if($row['remaining_term']==52) echo 'selected="selected"'; ?>>52 months</option><option value="53 months" <?php if($row['remaining_term']==53) echo 'selected="selected"'; ?>>53 months</option><option value="54 months" <?php if($row['remaining_term']==54) echo 'selected="selected"'; ?>>54 months</option><option value="55 months" <?php if($row['remaining_term']==55) echo 'selected="selected"'; ?>>55 months</option><option value="56 months" <?php if($row['remaining_term']==56) echo 'selected="selected"'; ?>>56 months</option><option value="57 months" <?php if($row['remaining_term']==57) echo 'selected="selected"'; ?>>57 months</option><option value="58 months" <?php if($row['remaining_term']==58) echo 'selected="selected"'; ?>>58 months</option><option value="59 months" <?php if($row['remaining_term']==59) echo 'selected="selected"'; ?>>59 months</option><option value="60 months" <?php if($row['remaining_term']==60) echo 'selected="selected"'; ?>>60 months (5 years)</option><option value="61 months" <?php if($row['remaining_term']==61) echo 'selected="selected"'; ?>>61 months</option><option value="62 months" <?php if($row['remaining_term']==62) echo 'selected="selected"'; ?>>62 months</option><option value="63 months" <?php if($row['remaining_term']==63) echo 'selected="selected"'; ?>>63 months</option><option value="64 months" <?php if($row['remaining_term']==64) echo 'selected="selected"'; ?>>64 months</option><option value="65 months" <?php if($row['remaining_term']==65) echo 'selected="selected"'; ?>>65 months</option><option value="66 months" <?php if($row['remaining_term']==66) echo 'selected="selected"'; ?>>66 months</option><option value="67 months" <?php if($row['remaining_term']==67) echo 'selected="selected"'; ?>>67 months</option><option value="68 months" <?php if($row['remaining_term']==68) echo 'selected="selected"'; ?>>68 months</option><option value="69 months" <?php if($row['remaining_term']==69) echo 'selected="selected"'; ?>>69 months</option><option value="70 months" <?php if($row['remaining_term']==70) echo 'selected="selected"'; ?>>70 months</option><option value="71 months" <?php if($row['remaining_term']==71) echo 'selected="selected"'; ?>>71 months</option><option value="72 months" <?php if($row['remaining_term']==72) echo 'selected="selected"'; ?>>72 months (6 years)</option><option value="73 months" <?php if($row['remaining_term']==73) echo 'selected="selected"'; ?>>73 months</option><option value="74 months" <?php if($row['remaining_term']==74) echo 'selected="selected"'; ?>>74 months</option><option value="75 months" <?php if($row['remaining_term']==75) echo 'selected="selected"'; ?>>75 months</option><option value="76 months" <?php if($row['remaining_term']==76) echo 'selected="selected"'; ?>>76 months</option><option value="77 months" <?php if($row['remaining_term']==77) echo 'selected="selected"'; ?>>77 months</option><option value="78 months" <?php if($row['remaining_term']==78) echo 'selected="selected"'; ?>>78 months</option><option value="79 months" <?php if($row['remaining_term']==79) echo 'selected="selected"'; ?>>79 months</option><option value="80 months" <?php if($row['remaining_term']==80) echo 'selected="selected"'; ?>>80 months</option><option value="81 months" <?php if($row['remaining_term']==81) echo 'selected="selected"'; ?>>81 months</option><option value="82 months" <?php if($row['remaining_term']==82) echo 'selected="selected"'; ?>>82 months</option><option value="83 months" <?php if($row['remaining_term']==83) echo 'selected="selected"'; ?>>83 months</option><option value="84 months" <?php if($row['remaining_term']==84) echo 'selected="selected"'; ?>>84 months (7 years)</option><option value="85 months" <?php if($row['remaining_term']==85) echo 'selected="selected"'; ?>>85 months</option><option value="86 months" <?php if($row['remaining_term']==86) echo 'selected="selected"'; ?>>86 months</option><option value="87 months" <?php if($row['remaining_term']==87) echo 'selected="selected"'; ?>>87 months</option><option value="88 months" <?php if($row['remaining_term']==88) echo 'selected="selected"'; ?>>88 months</option><option value="89 months" <?php if($row['remaining_term']==89) echo 'selected="selected"'; ?>>89 months</option><option value="90 months" <?php if($row['remaining_term']==90) echo 'selected="selected"'; ?>>90 months</option><option value="91 months" <?php if($row['remaining_term']==91) echo 'selected="selected"'; ?>>91 months</option><option value="92 months" <?php if($row['remaining_term']==92) echo 'selected="selected"'; ?>>92 months</option><option value="93 months" <?php if($row['remaining_term']==93) echo 'selected="selected"'; ?>>93 months</option><option value="94 months" <?php if($row['remaining_term']==94) echo 'selected="selected"'; ?>>94 months</option><option value="95 months" <?php if($row['remaining_term']==95) echo 'selected="selected"'; ?>>95 months</option><option value="96 months" <?php if($row['remaining_term']==96) echo 'selected="selected"'; ?>>96 months (8 years)</option><option value="97 months" <?php if($row['remaining_term']==97) echo 'selected="selected"'; ?>>97 months</option><option value="98 months" <?php if($row['remaining_term']==98) echo 'selected="selected"'; ?>>98 months</option><option value="99 months" <?php if($row['remaining_term']==99) echo 'selected="selected"'; ?>>99 months</option><option value="100 months" <?php if($row['remaining_term']==100) echo 'selected="selected"'; ?>>100 months</option><option value="101 months" <?php if($row['remaining_term']==101) echo 'selected="selected"'; ?>>101 months</option><option value="102 months" <?php if($row['remaining_term']==102) echo 'selected="selected"'; ?>>102 months</option></select><input type="submit" value="Add" style="display: none" data-wait="Please wait..." data-w-id="c5633638-eaa6-b16a-b819-0fd57d5d78cf" class="button w-button"></form>

          </div>
        </div>

      <?php elseif ($row['debt_type'] == 'Legal Obligation') : ?>
        <!-- Payday Loan -->
        <div>
        <div id='loan-form' class='w-form'>
        <div>
        <div id='select-type' class='row w-row'>
          <div class='debt-sources-type-elements w-clearfix w-col w-col-6'>
            <h4 id='subsectionHeader-legalObligatoin' class='heading'>Legal Obligation</h4>
            <a href='#' id="removeLink" data-w-id='4c586f89-5d7c-5b89-448b-aae55028d09c' class='link2'>Remove</a></div>
          <div class='debt-sources-type-elements w-col w-col-6'>
            <div id='icon-credit-card' class='icon regular disabled'></div>
            <div id='icon-student-loan' class='icon solid disabled'></div>
            <div id='icon-payday-loan' class='icon solid disabled'></div>
            <div id='icon-loan' class='icon solid disabled'></div>
            <div id='icon-legal-obligation' class='icon solid'></div>
          </div>
        </div>
        </div>
        <form autocomplete='off' id='wf-form-Loan-Form' name='wf-form-Loan-Form' data-name='Loan Form'>
        <label for='Legal-Obligation-Nickname' class='form-label'>Nickname</label>
        <input type='text' class='w-input' maxlength='256' name='Legal-Obligation-Nickname' value='<?php echo $row['nick_name'];?>' data-name='Legal Obligation Nickname' placeholder='e.g. Child Support' id='Legal-Obligation-Nickname' required=''>
        <div class='data-descriptor'>
          <div>So tell me, what is your...</div>
        </div><label for='Legal-Obligation-Amount' class='form-label'>Monthly Payment</label>
        <input type='number' step='0.01' class='w-input' maxlength='256' name='Legal-Obligation-Amount' value=<?php echo $row['remaining_balance'];?> data-name='Legal Obligation Amount' placeholder='e.g. $30,000.00' id='Legal-Obligation-Amount' required=''>
        <label for='Legal-Obligation-Remaining-Term' class='form-label'>Remaining Term</label>
        <select id='Legal-Obligation-Remaining-Term' name='Legal-Obligation-Remaining-Term' data-name='Legal Obligation Remaining Term' class='w-input' required=''>
          <option value="">Select one...</option><option value="1 month" <?php if($row['remaining_term']==1) echo 'selected="selected"'; ?> >1 month</option><option value="2 months" <?php if($row['remaining_term']==2) echo 'selected="selected"'; ?>>2 months</option><option value="3 months" <?php if($row['remaining_term']==3) echo 'selected="selected"'; ?> >3 months</option><option value="4 months" <?php if($row['remaining_term']==4) echo 'selected="selected"'; ?>>4 months</option><option value="5 months" <?php if($row['remaining_term']==5) echo 'selected="selected"'; ?>>5 months</option><option value="6 months" <?php if($row['remaining_term']==6) echo 'selected="selected"'; ?>>6 months</option><option value="7 months" <?php if($row['remaining_term']==7) echo 'selected="selected"'; ?>>7 months</option><option value="8 months" <?php if($row['remaining_term']==8) echo 'selected="selected"'; ?>>8 months</option><option value="9 months" <?php if($row['remaining_term']==9) echo 'selected="selected"'; ?>>9 months</option><option value="10 months" <?php if($row['remaining_term']==10) echo 'selected="selected"'; ?>>10 months</option><option value="11 months" <?php if($row['remaining_term']==11) echo 'selected="selected"'; ?>>11 months</option><option value="12 months" <?php if($row['remaining_term']==12) echo 'selected="selected"'; ?>>12 months (1 year)</option><option value="13 months" <?php if($row['remaining_term']==13) echo 'selected="selected"'; ?>>13 months</option><option value="14 months" <?php if($row['remaining_term']==14) echo 'selected="selected"'; ?>>14 months</option><option value="15 months" <?php if($row['remaining_term']==15) echo 'selected="selected"'; ?>>15 months</option><option value="16 months" <?php if($row['remaining_term']==16) echo 'selected="selected"'; ?>>16 months</option><option value="17 months" <?php if($row['remaining_term']==17) echo 'selected="selected"'; ?>>17 months</option><option value="18 months" <?php if($row['remaining_term']==18) echo 'selected="selected"'; ?>>18 months</option><option value="19 months" <?php if($row['remaining_term']==19) echo 'selected="selected"'; ?>>19 months</option><option value="20 months" <?php if($row['remaining_term']==20) echo 'selected="selected"'; ?>>20 months</option><option value="21 months" <?php if($row['remaining_term']==21) echo 'selected="selected"'; ?>>21 months</option><option value="22 months" <?php if($row['remaining_term']==22) echo 'selected="selected"'; ?>>22 months</option><option value="23 months" <?php if($row['remaining_term']==23) echo 'selected="selected"'; ?>>23 months</option><option value="24 months" <?php if($row['remaining_term']==24) echo 'selected="selected"'; ?>>24 months (2 years)</option><option value="25 months" <?php if($row['remaining_term']==25) echo 'selected="selected"'; ?>>25 months</option><option value="26 months" <?php if($row['remaining_term']==26) echo 'selected="selected"'; ?>>26 months</option><option value="27 months" <?php if($row['remaining_term']==27) echo 'selected="selected"'; ?>>27 months</option><option value="28 months" <?php if($row['remaining_term']==28) echo 'selected="selected"'; ?>>28 months</option><option value="29 months" <?php if($row['remaining_term']==29) echo 'selected="selected"'; ?>>29 months</option><option value="30 months" <?php if($row['remaining_term']==30) echo 'selected="selected"'; ?>>30 months</option><option value="31 months" <?php if($row['remaining_term']==31) echo 'selected="selected"'; ?>>31 months</option><option value="32 months" <?php if($row['remaining_term']==32) echo 'selected="selected"'; ?>>32 months</option><option value="33 months" <?php if($row['remaining_term']==33) echo 'selected="selected"'; ?>>33 months</option><option value="34 months" <?php if($row['remaining_term']==34) echo 'selected="selected"'; ?>>34 months</option><option value="35 months" <?php if($row['remaining_term']==35) echo 'selected="selected"'; ?>>35 months</option><option value="36 months" <?php if($row['remaining_term']==36) echo 'selected="selected"'; ?>>36 months (3 years)</option><option value="37 months" <?php if($row['remaining_term']==37) echo 'selected="selected"'; ?>>37 months</option><option value="38 months" <?php if($row['remaining_term']==38) echo 'selected="selected"'; ?>>38 months</option><option value="39 months" <?php if($row['remaining_term']==39) echo 'selected="selected"'; ?>>39 months</option><option value="40 months" <?php if($row['remaining_term']==40) echo 'selected="selected"'; ?>>40 months</option><option value="41 months" <?php if($row['remaining_term']==41) echo 'selected="selected"'; ?>>41 months</option><option value="42 months" <?php if($row['remaining_term']==42) echo 'selected="selected"'; ?>>42 months</option><option value="43 months" <?php if($row['remaining_term']==43) echo 'selected="selected"'; ?>>43 months</option><option value="44 months" <?php if($row['remaining_term']==44) echo 'selected="selected"'; ?>>44 months</option><option value="45 months" <?php if($row['remaining_term']==45) echo 'selected="selected"'; ?>>45 months</option><option value="46 months" <?php if($row['remaining_term']==46) echo 'selected="selected"'; ?>>46 months</option><option value="47 months" <?php if($row['remaining_term']==47) echo 'selected="selected"'; ?>>47 months</option><option value="48 months" <?php if($row['remaining_term']==48) echo 'selected="selected"'; ?>>48 months (4 years)</option><option value="49 months" <?php if($row['remaining_term']==49) echo 'selected="selected"'; ?>>49 months</option><option value="50 months" <?php if($row['remaining_term']==50) echo 'selected="selected"'; ?>>50 months</option><option value="51 months" <?php if($row['remaining_term']==51) echo 'selected="selected"'; ?>>51 months</option><option value="52 months" <?php if($row['remaining_term']==52) echo 'selected="selected"'; ?>>52 months</option><option value="53 months" <?php if($row['remaining_term']==53) echo 'selected="selected"'; ?>>53 months</option><option value="54 months" <?php if($row['remaining_term']==54) echo 'selected="selected"'; ?>>54 months</option><option value="55 months" <?php if($row['remaining_term']==55) echo 'selected="selected"'; ?>>55 months</option><option value="56 months" <?php if($row['remaining_term']==56) echo 'selected="selected"'; ?>>56 months</option><option value="57 months" <?php if($row['remaining_term']==57) echo 'selected="selected"'; ?>>57 months</option><option value="58 months" <?php if($row['remaining_term']==58) echo 'selected="selected"'; ?>>58 months</option><option value="59 months" <?php if($row['remaining_term']==59) echo 'selected="selected"'; ?>>59 months</option><option value="60 months" <?php if($row['remaining_term']==60) echo 'selected="selected"'; ?>>60 months (5 years)</option><option value="61 months" <?php if($row['remaining_term']==61) echo 'selected="selected"'; ?>>61 months</option><option value="62 months" <?php if($row['remaining_term']==62) echo 'selected="selected"'; ?>>62 months</option><option value="63 months" <?php if($row['remaining_term']==63) echo 'selected="selected"'; ?>>63 months</option><option value="64 months" <?php if($row['remaining_term']==64) echo 'selected="selected"'; ?>>64 months</option><option value="65 months" <?php if($row['remaining_term']==65) echo 'selected="selected"'; ?>>65 months</option><option value="66 months" <?php if($row['remaining_term']==66) echo 'selected="selected"'; ?>>66 months</option><option value="67 months" <?php if($row['remaining_term']==67) echo 'selected="selected"'; ?>>67 months</option><option value="68 months" <?php if($row['remaining_term']==68) echo 'selected="selected"'; ?>>68 months</option><option value="69 months" <?php if($row['remaining_term']==69) echo 'selected="selected"'; ?>>69 months</option><option value="70 months" <?php if($row['remaining_term']==70) echo 'selected="selected"'; ?>>70 months</option><option value="71 months" <?php if($row['remaining_term']==71) echo 'selected="selected"'; ?>>71 months</option><option value="72 months" <?php if($row['remaining_term']==72) echo 'selected="selected"'; ?>>72 months (6 years)</option><option value="73 months" <?php if($row['remaining_term']==73) echo 'selected="selected"'; ?>>73 months</option><option value="74 months" <?php if($row['remaining_term']==74) echo 'selected="selected"'; ?>>74 months</option><option value="75 months" <?php if($row['remaining_term']==75) echo 'selected="selected"'; ?>>75 months</option><option value="76 months" <?php if($row['remaining_term']==76) echo 'selected="selected"'; ?>>76 months</option><option value="77 months" <?php if($row['remaining_term']==77) echo 'selected="selected"'; ?>>77 months</option><option value="78 months" <?php if($row['remaining_term']==78) echo 'selected="selected"'; ?>>78 months</option><option value="79 months" <?php if($row['remaining_term']==79) echo 'selected="selected"'; ?>>79 months</option><option value="80 months" <?php if($row['remaining_term']==80) echo 'selected="selected"'; ?>>80 months</option><option value="81 months" <?php if($row['remaining_term']==81) echo 'selected="selected"'; ?>>81 months</option><option value="82 months" <?php if($row['remaining_term']==82) echo 'selected="selected"'; ?>>82 months</option><option value="83 months" <?php if($row['remaining_term']==83) echo 'selected="selected"'; ?>>83 months</option><option value="84 months" <?php if($row['remaining_term']==84) echo 'selected="selected"'; ?>>84 months (7 years)</option><option value="85 months" <?php if($row['remaining_term']==85) echo 'selected="selected"'; ?>>85 months</option><option value="86 months" <?php if($row['remaining_term']==86) echo 'selected="selected"'; ?>>86 months</option><option value="87 months" <?php if($row['remaining_term']==87) echo 'selected="selected"'; ?>>87 months</option><option value="88 months" <?php if($row['remaining_term']==88) echo 'selected="selected"'; ?>>88 months</option><option value="89 months" <?php if($row['remaining_term']==89) echo 'selected="selected"'; ?>>89 months</option><option value="90 months" <?php if($row['remaining_term']==90) echo 'selected="selected"'; ?>>90 months</option><option value="91 months" <?php if($row['remaining_term']==91) echo 'selected="selected"'; ?>>91 months</option><option value="92 months" <?php if($row['remaining_term']==92) echo 'selected="selected"'; ?>>92 months</option><option value="93 months" <?php if($row['remaining_term']==93) echo 'selected="selected"'; ?>>93 months</option><option value="94 months" <?php if($row['remaining_term']==94) echo 'selected="selected"'; ?>>94 months</option><option value="95 months" <?php if($row['remaining_term']==95) echo 'selected="selected"'; ?>>95 months</option><option value="96 months" <?php if($row['remaining_term']==96) echo 'selected="selected"'; ?>>96 months (8 years)</option><option value="97 months" <?php if($row['remaining_term']==97) echo 'selected="selected"'; ?>>97 months</option><option value="98 months" <?php if($row['remaining_term']==98) echo 'selected="selected"'; ?>>98 months</option><option value="99 months" <?php if($row['remaining_term']==99) echo 'selected="selected"'; ?>>99 months</option><option value="100 months" <?php if($row['remaining_term']==100) echo 'selected="selected"'; ?>>100 months</option><option value="101 months" <?php if($row['remaining_term']==101) echo 'selected="selected"'; ?>>101 months</option><option value="102 months" <?php if($row['remaining_term']==102) echo 'selected="selected"'; ?>>102 months</option></select><input type="submit" value="Add" style="display: none" data-wait="Please wait..." data-w-id="c5633638-eaa6-b16a-b819-0fd57d5d78cf" class="button w-button"></form>

      </div>
    </div>

      <?php endif; ?>

        <div id="remove-confirmation-overlay" class="overlay" style="display:none; z-index:1000">
          <h4 class="overlay-header">Are you sure?</h4>
          <p>You will lose all of the information that you have entered.</p><a href="#" id="cancelRemoval" class="hollow-button primary">Cancel</a><a href="#" id="sureRemoval" class="button right w-button">I&#x27;m sure</a></div>
        <div id="dark-screen">
        </div>
      </div>
    </div>
  </div>

  <p id="msg"></p>

  <div class="cta-section">
    <div class="w-container">
      <div class="w-row">
        <div class="column-2 w-col w-col-6 w-col-small-6 w-col-tiny-6">
        <a href="#" id="saveButton" class="hollow-button strong">Save</a></div>
        <div class="align-right w-col w-col-6 w-col-small-6 w-col-tiny-6"><a href="dashboard.php?user_id=<?php echo $user_id;?>" id="continueButton" class="button">Continue to Dashboard</a>
      </div>
    </div>
  </div>
  <div class="footer accent">
    <div class="w-container">
      <h1 class="footer-brand-text">Yada Yada Debt</h1>
      <div class="w-row">
        <div class="w-col w-col-6">
          <p>Yada Yada Debt&#x27;s goal it to help those that don&#x27;t get the time of day from Financial Advisors.</p>
          <div><a href="#" class="social-icon-link w-inline-block"><img src="images/social-03.svg" width="20"></a><a href="#" class="social-icon-link w-inline-block"><img src="images/social-18.svg" width="20"></a><a href="#" class="social-icon-link w-inline-block"><img src="images/social-09.svg" width="20"></a><a href="#" class="social-icon-link w-inline-block"><img src="images/social-06.svg" width="20"></a></div>
        </div>
        <div class="w-col w-col-3"><a href="#" class="footer-link">Money</a><a href="#" class="footer-link">Debt</a><a href="#" class="footer-link">Advice</a></div>
        <div class="w-col w-col-3"><a href="#" class="footer-link">About us</a><a href="#" class="footer-link">Legal</a></div>
      </div>
    </div>
  </div>
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
                document.getElementById("uid").value=user.uid;
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
</body>
</html>
