<!--  This site was created in Webflow. http://www.webflow.com  -->
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

      var cloneAndAddFunctionality = function(inputBox) {
        $("#source-first").hide();
        $("#source-another").hide();
        $("#debt-selector-box").hide();
        $("#source-clickable").show();
        $("#saveButton").show();
        $("#continueButton").show();
        var copy = $(inputBox).clone();
        var newID = "real-" + userVar + "-" + copy.attr('id');
        copy = copy.attr("id",newID);
        copy.appendTo("#paste-area");
        var inputs = $("#"+ newID + ' :input[type!=submit]');
        inputs.each(function(){
          var newName = $(this).attr('name') + '-real-' + userVar;
          $(this).attr('name',newName);
        });
        userVar++;
        copy.show();
        $(".link2").click(function(){
          if($("#remove-confirmation-overlay").is(":visible")) {
            return false;
          }
          var current = $(this).parent().parent().parent().parent().parent();
          $("#remove-confirmation-overlay").show();
          $("#dark-screen").show();
          $("#sureRemoval").click(function() {
            $("#dark-screen").hide();
            $("#remove-confirmation-overlay").hide();
            current.remove();
            userVar--;
            if($("[id$=input-box]").length == 5) {
              $("#source-first").show();
              $("#debt-selector-box").show();
              $("#source-another").hide();
              $("#source-clickable").hide();
              $("#saveButton").hide();
              $("#continueButton").hide();
            }
          });
          $("#cancelRemoval").click(function() {
            $("#dark-screen").hide();
            $("#remove-confirmation-overlay").hide();
          });
        });
        copy.find("[id^=wf-form]").submit(function() {
          submitted++;
          return false;
        });
      }
      $("#saveButton").click(function() {
        //TODO: Add post functionality to save inputs

        //Ravi's code changes begin
        var input_names = document.getElementsByClassName('w-input');
        var dataString = "";

        //console.log first-name;

        $.each(input_names, function(index, obj) {
          console.log(obj.name + ": " + obj.value);
          dataString = dataString + obj.name + ":" + obj.value + ";";
        })
        $.ajax({
          type:"post",
          url:"php/debt-sources-backend.php?user_id=" + document.getElementById('uid').value,
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
        if(submitted == count) {
          $("#debt-selector-box").show();
          $("#source-another").show();
          $("#source-clickable").hide();
        }
        submitted = 0;
        count = 0;
      });
      $("#dropdown-credit-card").click(function(){ cloneAndAddFunctionality("#debt-credit-card-input-box") });
      $("#dropdown-student-loan").click(function(){ cloneAndAddFunctionality("#debt-student-loan-input-box") });
      $("#dropdown-payday-loan").click(function(){ cloneAndAddFunctionality("#debt-payday-loan-input-box") });
      $("#dropdown-loan").click(function(){ cloneAndAddFunctionality("#debt-loan-input-box") });
      $("#dropdown-legal-obligation").click(function(){ cloneAndAddFunctionality("#debt-legal-obligation-input-box") });
    });
  </script>
  <link href="https://daks2k3a4ib2z.cloudfront.net/img/favicon.ico" rel="shortcut icon" type="image/x-icon">
  <link href="https://daks2k3a4ib2z.cloudfront.net/img/webclip.png" rel="apple-touch-icon">
</head>
<body class="body">
  <?php
    $user_id = $_REQUEST['user_id'];
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
        <input type="hidden" name="uid" id="uid">
        <!-- Ravi's changes to include signon END-->
      </nav>
      <div class="hamburger-button white w-nav-button">
        <div class="w-icon-nav-menu"></div>
      </div>
    </div>
  </div>
  <div class="section-2">
    <div class="container-top-24 w-container">
      <h2 class="section-heading">What do you need help paying off?</h2>
      <div>
        <div id="paste-area"></div>
        <h4 id="source-clickable" class="heading-3 left link" style="display: none">Add another source</h4>
        <h4 id="source-first" class="heading-3 left">Enter your first source</h4>
        <h4 id="source-another" style="display: none" class="heading-3 left">Add another source</h4>
        <div id="debt-selector-box" class="div-block box">
          <div id="select-type" class="row w-row">
            <div class="debt-sources-type-elements w-col w-col-6">
              <div data-delay="0" class="dropdown w-dropdown">
                <div class="dropdown-toggle w-dropdown-toggle">
                  <div class="w-icon-dropdown-toggle"></div>
                  <div>Select a type...</div>
                </div>
                <nav class="dropdown-list w-dropdown-list">
                    <a href="#" id="dropdown-credit-card" class="debtsourcedropdown w-dropdown-link">Credit Card</a>
                    <a href="#" id="dropdown-student-loan" data-w-id="aca5c135-fd75-947d-a7f2-f07599f0d191" class="debtsourcedropdown w-dropdown-link">Student Loan</a>
                    <a href="#" id="dropdown-payday-loan" data-w-id="aca5c135-fd75-947d-a7f2-f07599f0d193" class="debtsourcedropdown w-dropdown-link">Payday Loan</a>
                    <a href="#" id="dropdown-loan" data-w-id="aca5c135-fd75-947d-a7f2-f07599f0d195" class="debtsourcedropdown w-dropdown-link">Loan</a>
                    <a href="#" id="dropdown-legal-obligation" data-w-id="aca5c135-fd75-947d-a7f2-f07599f0d197" class="debtsourcedropdown last w-dropdown-link">Legal Obligation</a>
                </nav>
              </div>
            </div>
            <div class="debt-sources-type-elements w-col w-col-6">
              <div id="icon-credit-card" class="icon regular"></div>
              <div id="icon-student-loan" class="icon solid"></div>
              <div id="icon-payday-loan" class="icon solid"></div>
              <div id="icon-loan" class="icon solid"></div>
              <div id="icon-legal-obligation" class="icon solid"></div>
            </div>
          </div>
          <div class="tooltip">
            <div>We use this information to help you prioritize which debt you should pay and how much.</div>
          </div>
        </div>
        <div id="debt-credit-card-input-box" data-w-id="2868bbbb-a940-b8ab-10e9-8bd8e9acd264" style="display:none" class="div-block box">
          <div id="credit-card-form" class="w-form">
            <div>
              <div class="row w-row">
                <div class="debt-sources-type-elements w-clearfix w-col w-col-6">
                  <h4 id="subsectionHeader-credit-card" class="heading">Credit Card</h4><a href="#" data-w-id="2868bbbb-a940-b8ab-10e9-8bd8e9acd28b" class="link2">Remove</a></div>
                <div class="debt-sources-type-elements w-col w-col-6">
                  <div id="icon-credit-card" class="icon regular"></div>
                  <div id="icon-student-loan" class="icon solid disabled"></div>
                  <div id="icon-payday-loan" class="icon solid disabled"></div>
                  <div id="icon-loan" class="icon solid disabled"></div>
                  <div id="icon-legal-obligation" class="icon solid disabled"></div>
                </div>
              </div>
            </div>
            <form autocomplete="off" id="wf-form-Credit-Card-Form" name="wf-form-Credit-Card-Form" data-name="Credit Card Form" class="ajax">
              <label for="Credit-Card-Nickname" class="form-label">Nickname</label>
              <input type="text" class="w-input" maxlength="256" name="Credit-Card-Nickname" data-name="Credit Card Nickname" placeholder="e.g. My Visa Fun Card" id="Credit-Card-Nickname" required="">
              <div class="data-descriptor">
                <div>At this point, what is your...</div>
              </div><label for="credit-card-balance" class="form-label">Balance</label>
              <input type="number" step="0.01" class="w-input" maxlength="256" name="credit-card-balance" data-name="Credit Card Balance" placeholder="e.g. $5,143.47" id="credit-card-balance" required="">
              <label for="credit-card-min-payment" class="form-label">Minimum Payment</label>
              <input type="number" step="0.01" class="w-input" maxlength="256" name="credit-card-min-payment" data-name="Credit Card Min Payment" placeholder="e.g. $35.43" id="credit-card-min-payment" required="">
              <label for="credit-card-apr" class="form-label">APR</label>
              <input type="number" step="0.01" class="w-input" maxlength="256" name="credit-card-apr" data-name="Credit Card Apr" placeholder="e.g. 29.99%" id="credit-card-apr" required="">
              <input type="submit" value="Add" style="display: none" data-wait="Please wait..." data-w-id="2868bbbb-a940-b8ab-10e9-8bd8e9acd2a8" class="button w-button"></form>
            <div class="w-form-done">
              <div>Thank you! Your submission has been received!</div>
            </div>
            <div class="w-form-fail">
              <div>Oops! Something went wrong while submitting the form.</div>
            </div>
          </div>
        </div>
        <div id="debt-credit-card-output-box" class="div-block box" style="display:none">
          <div id="credit-card-form-complete" class="w-form">
            <div>
              <div class="row w-row">
                <div class="debt-sources-type-elements w-clearfix w-col w-col-6">
                  <h4 id="subsectionHeader-credit-card" class="heading">Credit Card</h4>
                </div>
                <div class="debt-sources-type-elements w-col w-col-6">
                  <div id="icon-credit-card" class="icon regular"></div>
                  <div id="icon-student-loan" class="icon solid disabled"></div>
                  <div id="icon-payday-loan" class="icon solid disabled"></div>
                  <div id="icon-loan" class="icon solid disabled"></div>
                  <div id="icon-legal-obligation" class="icon solid disabled"></div>
                </div>
              </div>
            </div>
            <form id="wf-form-Credit-Card-Form-Complete" name="wf-form-Credit-Card-Form-Complete" data-name="Credit Card Form Complete"><label for="name" class="form-label">Nickname</label>
              <p id="credit-card-nickname-filled">My Alaska Air Visa Card</p>
              <div class="data-descriptor">
                <div>At this point, your...</div>
              </div><label for="balance" class="form-label">Balance</label>
              <p id="credit-card-balance-filled">$5,143.47</p><label for="min-payment" class="form-label">Minimum Payment</label>
              <p id="credit-card-minimum-payment-filled">$240.23</p><label for="apr" class="form-label">APR</label>
              <p id="credit-card-apr-filled">29.99%</p><a href="#" data-w-id="3800a360-7186-d993-2d90-86c5e92bb062" class="hollow-button primary">Edit</a><a href="#" class="ghost">Remove</a></form>
            <div class="w-form-done">
              <div>Thank you! Your submission has been received!</div>
            </div>
            <div class="w-form-fail">
              <div>Oops! Something went wrong while submitting the form.</div>
            </div>
          </div>
        </div>
        <div id="debt-student-loan-input-box" class="div-block box" style="display:none">
          <div id="student-loan-form" class="w-form">
            <div>
              <div id="select-type" class="row w-row">
                <div class="debt-sources-type-elements w-clearfix w-col w-col-6">
                  <h4 id="subsectionHeader-student-loan" class="heading">Student Loan</h4><a href="#" data-w-id="c5633638-eaa6-b16a-b819-0fd57d5d78b2" class="link2">Remove</a></div>
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
              <input type="text" class="w-input" maxlength="256" name="Student-Loan-Nickname" data-name="Student Loan Nickname" placeholder="e.g. For My Great Education" id="Student-Loan-Nickname" required="">
              <div class="data-descriptor">
                <div>At this point, what was your...</div>
              </div><label for="Student-Loan-Remaining-Balance" class="form-label">Remaining Balance</label>
              <input type="number" step="0.01" class="w-input" maxlength="256" name="Student-Loan-Remaining-Balance" data-name="Student Loan Remaining Balance" placeholder="e.g. $86,000.00" id="Original-Student-Loan-Amount" required="">
              <label for="Student-Loan-Interest-Rate" class="form-label">Interest Rate</label>
              <input type="number" step="0.01" class="w-input" maxlength="256" name="Student-Loan-Interest-Rate" data-name="Student Loan Interest Rate" placeholder="e.g.  4.45%" id="Student-Loan-Interest-Rate" required="">
              <label for="Student-Loan-Remain-Term" class="form-label">Remaining Term</label>
              <select id="Student-Loan-Remain-Term" name="Student-Loan-Remain-Term" data-name="Student Loan Remain Term" class="w-input" required="">
                <option value="">Select one...</option><option value="1 month">1 month</option><option value="2 months">2 months</option><option value="3 months">3 months</option><option value="4 months">4 months</option><option value="5 months">5 months</option><option value="6 months">6 months</option><option value="7 months">7 months</option><option value="8 months">8 months</option><option value="9 months">9 months</option><option value="10 months">10 months</option><option value="11 months">11 months</option><option value="12 months">12 months (1 year)</option><option value="13 months">13 months</option><option value="14 months">14 months</option><option value="15 months">15 months</option><option value="16 months">16 months</option><option value="17 months">17 months</option><option value="18 months">18 months</option><option value="19 months">19 months</option><option value="20 months">20 months</option><option value="21 months">21 months</option><option value="22 months">22 months</option><option value="23 months">23 months</option><option value="24 months">24 months (2 years)</option><option value="25 months">25 months</option><option value="26 months">26 months</option><option value="27 months">27 months</option><option value="28 months">28 months</option><option value="29 months">29 months</option><option value="30 months">30 months</option><option value="31 months">31 months</option><option value="32 months">32 months</option><option value="33 months">33 months</option><option value="34 months">34 months</option><option value="35 months">35 months</option><option value="36 months">36 months (3 years)</option><option value="37 months">37 months</option><option value="38 months">38 months</option><option value="39 months">39 months</option><option value="40 months">40 months</option><option value="41 months">41 months</option><option value="42 months">42 months</option><option value="43 months">43 months</option><option value="44 months">44 months</option><option value="45 months">45 months</option><option value="46 months">46 months</option><option value="47 months">47 months</option><option value="48 months">48 months (4 years)</option><option value="49 months">49 months</option><option value="50 months">50 months</option><option value="51 months">51 months</option><option value="52 months">52 months</option><option value="53 months">53 months</option><option value="54 months">54 months</option><option value="55 months">55 months</option><option value="56 months">56 months</option><option value="57 months">57 months</option><option value="58 months">58 months</option><option value="59 months">59 months</option><option value="60 months">60 months (5 years)</option><option value="61 months">61 months</option><option value="62 months">62 months</option><option value="63 months">63 months</option><option value="64 months">64 months</option><option value="65 months">65 months</option><option value="66 months">66 months</option><option value="67 months">67 months</option><option value="68 months">68 months</option><option value="69 months">69 months</option><option value="70 months">70 months</option><option value="71 months">71 months</option><option value="72 months">72 months (6 years)</option><option value="73 months">73 months</option><option value="74 months">74 months</option><option value="75 months">75 months</option><option value="76 months">76 months</option><option value="77 months">77 months</option><option value="78 months">78 months</option><option value="79 months">79 months</option><option value="80 months">80 months</option><option value="81 months">81 months</option><option value="82 months">82 months</option><option value="83 months">83 months</option><option value="84 months">84 months (7 years)</option><option value="85 months">85 months</option><option value="86 months">86 months</option><option value="87 months">87 months</option><option value="88 months">88 months</option><option value="89 months">89 months</option><option value="90 months">90 months</option><option value="91 months">91 months</option><option value="92 months">92 months</option><option value="93 months">93 months</option><option value="94 months">94 months</option><option value="95 months">95 months</option><option value="96 months">96 months (8 years)</option><option value="97 months">97 months</option><option value="98 months">98 months</option><option value="99 months">99 months</option><option value="100 months">100 months</option><option value="101 months">101 months</option><option value="102 months">102 months</option></select><input type="submit" value="Add" style="display: none" data-wait="Please wait..." data-w-id="c5633638-eaa6-b16a-b819-0fd57d5d78cf" class="button w-button"></form>
            <div class="w-form-done">
              <div>Thank you! Your submission has been received!</div>
            </div>
            <div class="w-form-fail">
              <div>Oops! Something went wrong while submitting the form.</div>
            </div>
          </div>
        </div>
        <div id="debt-student-loan-output-box" class="div-block box" style="display:none">
          <div id="student-loan-form-complete" class="w-form">
            <div>
              <div id="select-type" class="row w-row">
                <div class="debt-sources-type-elements w-clearfix w-col w-col-6">
                  <h4 id="subsectionHeader-student-loan" class="heading">Student Loan</h4>
                </div>
                <div class="debt-sources-type-elements w-col w-col-6">
                  <div id="icon-credit-card" class="icon regular disabled"></div>
                  <div id="icon-student-loan" class="icon solid"></div>
                  <div id="icon-payday-loan" class="icon solid disabled"></div>
                  <div id="icon-loan" class="icon solid disabled"></div>
                  <div id="icon-legal-obligation" class="icon solid disabled"></div>
                </div>
              </div>
            </div>
            <form id="wf-form-Student-Loan-Form-Complete" name="wf-form-Student-Loan-Form-Complete" data-name="Student Loan Form Complete"><label for="name" class="form-label">Nickname</label>
              <p id="Student-Loan-Nickname-Complete">For My Great Education</p>
              <div class="data-descriptor">
                <div>At this point, what was your...</div>
              </div><label for="balance" class="form-label">Remaining Balance</label>
              <p id="Original-Student-Loan-Amount-Complete">$86,000.00</p><label for="min-payment" class="form-label">Interest Rate</label>
              <p id="Student-Loan-Interest-Rate-Complete">4.45%</p><label for="apr" class="form-label">Remaining Term</label>
              <p id="Student-Loan-Remain-Term-Complete">43 months</p><a href="#" data-w-id="6b3939c3-00e4-bd5f-c57a-d0b33a7149f2" class="hollow-button primary">Edit</a><a href="#" class="ghost">Remove</a></form>
            <div class="w-form-done">
              <div>Thank you! Your submission has been received!</div>
            </div>
            <div class="w-form-fail">
              <div>Oops! Something went wrong while submitting the form.</div>
            </div>
          </div>
        </div>
        <div id="debt-payday-loan-input-box" class="div-block box" style="display:none">
          <div id="payday-loan-form" class="w-form">
            <div>
              <div id="select-type" class="row w-row">
                <div class="debt-sources-type-elements w-clearfix w-col w-col-6">
                  <h4 id="subsectionHeader-payday-loan" class="heading">Payday Loan</h4><a href="#" data-w-id="3ddb9951-50d1-3b02-708d-a904c024696b" class="link2">Remove</a></div>
                <div class="debt-sources-type-elements w-col w-col-6">
                  <div id="icon-credit-card" class="icon regular disabled"></div>
                  <div id="icon-student-loan" class="icon solid disabled"></div>
                  <div id="icon-payday-loan" class="icon solid"></div>
                  <div id="icon-loan" class="icon solid disabled"></div>
                  <div id="icon-legal-obligation" class="icon solid disabled"></div>
                </div>
              </div>
            </div>
            <form autocomplete="off" id="wf-form-Payday-Loan-Form" name="wf-form-Payday-Loan-Form" data-name="Payday Loan Form">
              <label for="Payday-Loan-Nickname" class="form-label">Nickname</label>
              <input type="text" class="w-input" maxlength="256" name="Payday-Loan-Nickname" data-name="Payday Loan Nickname" placeholder="e.g. A Quick Fix" id="Payday-Loan-Nickname" required="">
              <div class="data-descriptor">
                <div>So tell me, what was your...</div>
              </div><label for="Payday-Remaining-Balance" class="form-label">Remaining Balance</label>
              <input type="number" step="0.01" class="w-input" maxlength="256" name="Payday-Remaining-Balance" data-name="Payday Remaining Balance" placeholder="e.g. $1,000.00" id="Original-Payday-Loan-Amount" required="">
              <label for="Payday-Loan-Interest-Rate" class="form-label">Interest Rate</label>
              <input type="number" step="0.01" class="w-input" maxlength="256" name="Payday-Loan-Interest-Rate" data-name="Payday Loan Interest Rate" placeholder="e.g.  400%" id="Payday-Loan-Interest-Rate" required="">
              <label for="Payday-Loan-Remain-Term" class="form-label">Remaining Term</label>
              <select id="Payday-Remaining-Term" name="Legal-Obligation-Remaining-Term" data-name="Payday Remaining Term" class="w-input" required="">
                <option value="">Select one...</option><option value="1 month">1 month</option><option value="2 months">2 months</option><option value="3 months">3 months</option><option value="4 months">4 months</option><option value="5 months">5 months</option><option value="6 months">6 months</option><option value="7 months">7 months</option><option value="8 months">8 months</option><option value="9 months">9 months</option><option value="10 months">10 months</option><option value="11 months">11 months</option><option value="12 months">12 months (1 year)</option><option value="13 months">13 months</option><option value="14 months">14 months</option><option value="15 months">15 months</option><option value="16 months">16 months</option><option value="17 months">17 months</option><option value="18 months">18 months</option><option value="19 months">19 months</option><option value="20 months">20 months</option><option value="21 months">21 months</option><option value="22 months">22 months</option><option value="23 months">23 months</option><option value="24 months">24 months (2 years)</option><option value="25 months">25 months</option><option value="26 months">26 months</option><option value="27 months">27 months</option><option value="28 months">28 months</option><option value="29 months">29 months</option><option value="30 months">30 months</option><option value="31 months">31 months</option><option value="32 months">32 months</option><option value="33 months">33 months</option><option value="34 months">34 months</option><option value="35 months">35 months</option><option value="36 months">36 months (3 years)</option><option value="37 months">37 months</option><option value="38 months">38 months</option><option value="39 months">39 months</option><option value="40 months">40 months</option><option value="41 months">41 months</option><option value="42 months">42 months</option><option value="43 months">43 months</option><option value="44 months">44 months</option><option value="45 months">45 months</option><option value="46 months">46 months</option><option value="47 months">47 months</option><option value="48 months">48 months (4 years)</option><option value="49 months">49 months</option><option value="50 months">50 months</option><option value="51 months">51 months</option><option value="52 months">52 months</option><option value="53 months">53 months</option><option value="54 months">54 months</option><option value="55 months">55 months</option><option value="56 months">56 months</option><option value="57 months">57 months</option><option value="58 months">58 months</option><option value="59 months">59 months</option><option value="60 months">60 months (5 years)</option><option value="61 months">61 months</option><option value="62 months">62 months</option><option value="63 months">63 months</option><option value="64 months">64 months</option><option value="65 months">65 months</option><option value="66 months">66 months</option><option value="67 months">67 months</option><option value="68 months">68 months</option><option value="69 months">69 months</option><option value="70 months">70 months</option><option value="71 months">71 months</option><option value="72 months">72 months (6 years)</option><option value="73 months">73 months</option><option value="74 months">74 months</option><option value="75 months">75 months</option><option value="76 months">76 months</option><option value="77 months">77 months</option><option value="78 months">78 months</option><option value="79 months">79 months</option><option value="80 months">80 months</option><option value="81 months">81 months</option><option value="82 months">82 months</option><option value="83 months">83 months</option><option value="84 months">84 months (7 years)</option><option value="85 months">85 months</option><option value="86 months">86 months</option><option value="87 months">87 months</option><option value="88 months">88 months</option><option value="89 months">89 months</option><option value="90 months">90 months</option><option value="91 months">91 months</option><option value="92 months">92 months</option><option value="93 months">93 months</option><option value="94 months">94 months</option><option value="95 months">95 months</option><option value="96 months">96 months (8 years)</option><option value="97 months">97 months</option><option value="98 months">98 months</option><option value="99 months">99 months</option><option value="100 months">100 months</option><option value="101 months">101 months</option><option value="102 months">102 months</option></select><input type="submit" value="Add" style="display: none" data-wait="Please wait..." data-w-id="4c586f89-5d7c-5b89-448b-aae55028d0b9" class="button w-button"></form>
              <input type="submit" value="Add" style="display: none" data-wait="Please wait..." data-w-id="3ddb9951-50d1-3b02-708d-a904c0246988" class="button w-button"></form>
            <div class="w-form-done">
              <div>Thank you! Your submission has been received!</div>
            </div>
            <div class="w-form-fail">
              <div>Oops! Something went wrong while submitting the form.</div>
            </div>
          </div>
        </div>
        <div id="debt-payday-loan-output-box" class="div-block box" style="display:none">
          <div id="student-loan-form-complete" class="w-form">
            <div>
              <div id="select-type" class="row w-row">
                <div class="debt-sources-type-elements w-clearfix w-col w-col-6">
                  <h4 id="subsectionHeader-payday-loan" class="heading">Payday Loan</h4>
                </div>
                <div class="debt-sources-type-elements w-col w-col-6">
                  <div id="icon-credit-card" class="icon regular disabled"></div>
                  <div id="icon-student-loan" class="icon solid disabled"></div>
                  <div id="icon-payday-loan" class="icon solid"></div>
                  <div id="icon-loan" class="icon solid disabled"></div>
                  <div id="icon-legal-obligation" class="icon solid disabled"></div>
                </div>
              </div>
            </div>
            <form id="wf-form-Student-Loan-Form-Complete" name="wf-form-Student-Loan-Form-Complete" data-name="Student Loan Form Complete"><label for="name" class="form-label">Nickname</label>
              <p id="Payday-Loan-Nickname-Complete">A Quick Fix</p>
              <div class="data-descriptor">
                <div>At this point, what was your...</div>
              </div><label for="balance" class="form-label">Remaining Balance</label>
              <p id="Original-Payday-Loan-Amount-Complete">$1,000.00</p><label for="min-payment" class="form-label">Interest Rate</label>
              <p id="Payday-Loan-Interest-Rate-Complete">400%</p><label for="apr" class="form-label">Remaining Term</label>
              <p id="Payday-Loan-Remain-Term-Complete">3 weeks</p><a href="#" data-w-id="c1b3d00a-642f-a33f-23f5-3c348210a7e6" class="hollow-button primary">Edit</a><a href="#" class="ghost">Remove</a></form>
            <div class="w-form-done">
              <div>Thank you! Your submission has been received!</div>
            </div>
            <div class="w-form-fail">
              <div>Oops! Something went wrong while submitting the form.</div>
            </div>
          </div>
        </div>
        <div id="debt-loan-input-box" class="div-block box" style="display:none">
          <div id="loan-form" class="w-form">
            <div>
              <div id="select-type" class="row w-row">
                <div class="debt-sources-type-elements w-clearfix w-col w-col-6">
                  <h4 id="subsectionHeader-loan" class="heading">Loan</h4><a href="#" data-w-id="6061c2fa-9f89-d152-9cd0-270f3c2a2fe5" class="link2">Remove</a></div>
                <div class="debt-sources-type-elements w-col w-col-6">
                  <div id="icon-credit-card" class="icon regular disabled"></div>
                  <div id="icon-student-loan" class="icon solid disabled"></div>
                  <div id="icon-payday-loan" class="icon solid disabled"></div>
                  <div id="icon-loan" class="icon solid"></div>
                  <div id="icon-legal-obligation" class="icon solid disabled"></div>
                </div>
              </div>
            </div>
            <form autocomplete="off" id="wf-form-Loan-Form" name="wf-form-Loan-Form" data-name="Loan Form">
              <label for="Loan-Nickname" class="form-label">Nickname</label>
              <input type="text" class="w-input" maxlength="256" name="Loan-Nickname" data-name="Loan Nickname" placeholder="e.g. For My Car" id="Loan-Nickname" required="">
              <div class="data-descriptor">
                <div>So tell me, what was your...</div>
              </div><label for="Remaining-Loan-Balance" class="form-label">Remaining Loan Balance</label>
              <input type="number" step="0.01" class="w-input" maxlength="256" name="Remaining-Loan-Amount" data-name="Remaining Loan Amount" placeholder="e.g. $30,000.00" id="Original-Loan-Amount" required="">
              <label for="Loan-Interest-Rate" class="form-label">Interest Rate</label>
              <input type="number" step="0.01" class="w-input" maxlength="256" name="Loan-Interest-Rate" data-name="Loan Interest Rate" placeholder="e.g.  29.99%" id="Loan-Interest-Rate" required="">
              <label for="Loan-Remain-Term" class="form-label">Remaining Term</label><select id="Loan-Remain-Term" name="Loan-Remain-Term" data-name="Loan Remain Term" class="w-input" required="">
                <option value="">Select one...</option><option value="1 month">1 month</option><option value="2 months">2 months</option><option value="3 months">3 months</option><option value="4 months">4 months</option><option value="5 months">5 months</option><option value="6 months">6 months</option><option value="7 months">7 months</option><option value="8 months">8 months</option><option value="9 months">9 months</option><option value="10 months">10 months</option><option value="11 months">11 months</option><option value="12 months">12 months (1 year)</option><option value="13 months">13 months</option><option value="14 months">14 months</option><option value="15 months">15 months</option><option value="16 months">16 months</option><option value="17 months">17 months</option><option value="18 months">18 months</option><option value="19 months">19 months</option><option value="20 months">20 months</option><option value="21 months">21 months</option><option value="22 months">22 months</option><option value="23 months">23 months</option><option value="24 months">24 months (2 years)</option><option value="25 months">25 months</option><option value="26 months">26 months</option><option value="27 months">27 months</option><option value="28 months">28 months</option><option value="29 months">29 months</option><option value="30 months">30 months</option><option value="31 months">31 months</option><option value="32 months">32 months</option><option value="33 months">33 months</option><option value="34 months">34 months</option><option value="35 months">35 months</option><option value="36 months">36 months (3 years)</option><option value="37 months">37 months</option><option value="38 months">38 months</option><option value="39 months">39 months</option><option value="40 months">40 months</option><option value="41 months">41 months</option><option value="42 months">42 months</option><option value="43 months">43 months</option><option value="44 months">44 months</option><option value="45 months">45 months</option><option value="46 months">46 months</option><option value="47 months">47 months</option><option value="48 months">48 months (4 years)</option><option value="49 months">49 months</option><option value="50 months">50 months</option><option value="51 months">51 months</option><option value="52 months">52 months</option><option value="53 months">53 months</option><option value="54 months">54 months</option><option value="55 months">55 months</option><option value="56 months">56 months</option><option value="57 months">57 months</option><option value="58 months">58 months</option><option value="59 months">59 months</option><option value="60 months">60 months (5 years)</option><option value="61 months">61 months</option><option value="62 months">62 months</option><option value="63 months">63 months</option><option value="64 months">64 months</option><option value="65 months">65 months</option><option value="66 months">66 months</option><option value="67 months">67 months</option><option value="68 months">68 months</option><option value="69 months">69 months</option><option value="70 months">70 months</option><option value="71 months">71 months</option><option value="72 months">72 months (6 years)</option><option value="73 months">73 months</option><option value="74 months">74 months</option><option value="75 months">75 months</option><option value="76 months">76 months</option><option value="77 months">77 months</option><option value="78 months">78 months</option><option value="79 months">79 months</option><option value="80 months">80 months</option><option value="81 months">81 months</option><option value="82 months">82 months</option><option value="83 months">83 months</option><option value="84 months">84 months (7 years)</option><option value="85 months">85 months</option><option value="86 months">86 months</option><option value="87 months">87 months</option><option value="88 months">88 months</option><option value="89 months">89 months</option><option value="90 months">90 months</option><option value="91 months">91 months</option><option value="92 months">92 months</option><option value="93 months">93 months</option><option value="94 months">94 months</option><option value="95 months">95 months</option><option value="96 months">96 months (8 years)</option><option value="97 months">97 months</option><option value="98 months">98 months</option><option value="99 months">99 months</option><option value="100 months">100 months</option><option value="101 months">101 months</option><option value="102 months">102 months</option></select><input type="submit" value="Add" style="display: none" data-wait="Please wait..." data-w-id="6061c2fa-9f89-d152-9cd0-270f3c2a3002" class="button w-button"></form>
            <div class="w-form-done">
              <div>Thank you! Your submission has been received!</div>
            </div>
            <div class="w-form-fail">
              <div>Oops! Something went wrong while submitting the form.</div>
            </div>
          </div>
        </div>
        <div id="debt-loan-output-box" class="div-block box" style="display:none">
          <div id="student-loan-form-complete" class="w-form">
            <div>
              <div id="select-type" class="row w-row">
                <div class="debt-sources-type-elements w-clearfix w-col w-col-6">
                  <h4 id="subsectionHeader-loan" class="heading">Loan</h4>
                </div>
                <div class="debt-sources-type-elements w-col w-col-6">
                  <div id="icon-credit-card" class="icon regular disabled"></div>
                  <div id="icon-student-loan" class="icon solid disabled"></div>
                  <div id="icon-payday-loan" class="icon solid disabled"></div>
                  <div id="icon-loan" class="icon solid"></div>
                  <div id="icon-legal-obligation" class="icon solid disabled"></div>
                </div>
              </div>
            </div>
            <form id="wf-form-Student-Loan-Form-Complete" name="wf-form-Student-Loan-Form-Complete" data-name="Student Loan Form Complete"><label for="name" class="form-label">Nickname</label>
              <p id="Loan-Nickname-Complete">For My Car</p>
              <div class="data-descriptor">
                <div>So tell me, what was your...</div>
              </div><label for="balance" class="form-label">Remaining Loan Amount</label>
              <p id="Remaining-Loan-Amount-Complete">$30,000.00</p><label for="min-payment" class="form-label">Interest Rate</label>
              <p id="Loan-Interest-Rate-Complete">29.99%</p><label for="apr" class="form-label">Remaining Term</label>
              <p id="Loan-Remain-Term-Complete">27 months</p><a href="#" data-w-id="7f410d32-272c-d283-287f-417a583fedf0" class="hollow-button primary">Edit</a><a href="#" class="ghost">Remove</a></form>
            <div class="w-form-done">
              <div>Thank you! Your submission has been received!</div>
            </div>
            <div class="w-form-fail">
              <div>Oops! Something went wrong while submitting the form.</div>
            </div>
          </div>
        </div>
        <div id="debt-legal-obligation-input-box" class="div-block box" style="display:none">
          <div id="loan-form" class="w-form">
            <div>
              <div id="select-type" class="row w-row">
                <div class="debt-sources-type-elements w-clearfix w-col w-col-6">
                  <h4 id="subsectionHeader-legalObligatoin" class="heading">Legal Obligation</h4><a href="#" data-w-id="4c586f89-5d7c-5b89-448b-aae55028d09c" class="link2">Remove</a></div>
                <div class="debt-sources-type-elements w-col w-col-6">
                  <div id="icon-credit-card" class="icon regular disabled"></div>
                  <div id="icon-student-loan" class="icon solid disabled"></div>
                  <div id="icon-payday-loan" class="icon solid disabled"></div>
                  <div id="icon-loan" class="icon solid disabled"></div>
                  <div id="icon-legal-obligation" class="icon solid"></div>
                </div>
              </div>
            </div>
            <form autocomplete="off" id="wf-form-Loan-Form" name="wf-form-Loan-Form" data-name="Loan Form">
              <label for="Legal-Obligation-Nickname" class="form-label">Nickname</label>
              <input type="text" class="w-input" maxlength="256" name="Legal-Obligation-Nickname" data-name="Legal Obligation Nickname" placeholder="e.g. Child Support" id="Legal-Obligation-Nickname" required="">
              <div class="data-descriptor">
                <div>So tell me, what is your...</div>
              </div><label for="Legal-Obligation-Amount" class="form-label">Monthly Payment</label>
              <input type="number" step="0.01" class="w-input" maxlength="256" name="Legal-Obligation-Amount" data-name="Legal Obligation Amount" placeholder="e.g. $30,000.00" id="Legal-Obligation-Amount" required="">
              <label for="Legal-Obligation-Remaining-Term" class="form-label">Remaining Term</label>
              <select id="Legal-Obligation-Remaining-Term" name="Legal-Obligation-Remaining-Term" data-name="Legal Obligation Remaining Term" class="w-input" required="">
                <option value="">Select one...</option><option value="1 month">1 month</option><option value="2 months">2 months</option><option value="3 months">3 months</option><option value="4 months">4 months</option><option value="5 months">5 months</option><option value="6 months">6 months</option><option value="7 months">7 months</option><option value="8 months">8 months</option><option value="9 months">9 months</option><option value="10 months">10 months</option><option value="11 months">11 months</option><option value="12 months">12 months (1 year)</option><option value="13 months">13 months</option><option value="14 months">14 months</option><option value="15 months">15 months</option><option value="16 months">16 months</option><option value="17 months">17 months</option><option value="18 months">18 months</option><option value="19 months">19 months</option><option value="20 months">20 months</option><option value="21 months">21 months</option><option value="22 months">22 months</option><option value="23 months">23 months</option><option value="24 months">24 months (2 years)</option><option value="25 months">25 months</option><option value="26 months">26 months</option><option value="27 months">27 months</option><option value="28 months">28 months</option><option value="29 months">29 months</option><option value="30 months">30 months</option><option value="31 months">31 months</option><option value="32 months">32 months</option><option value="33 months">33 months</option><option value="34 months">34 months</option><option value="35 months">35 months</option><option value="36 months">36 months (3 years)</option><option value="37 months">37 months</option><option value="38 months">38 months</option><option value="39 months">39 months</option><option value="40 months">40 months</option><option value="41 months">41 months</option><option value="42 months">42 months</option><option value="43 months">43 months</option><option value="44 months">44 months</option><option value="45 months">45 months</option><option value="46 months">46 months</option><option value="47 months">47 months</option><option value="48 months">48 months (4 years)</option><option value="49 months">49 months</option><option value="50 months">50 months</option><option value="51 months">51 months</option><option value="52 months">52 months</option><option value="53 months">53 months</option><option value="54 months">54 months</option><option value="55 months">55 months</option><option value="56 months">56 months</option><option value="57 months">57 months</option><option value="58 months">58 months</option><option value="59 months">59 months</option><option value="60 months">60 months (5 years)</option><option value="61 months">61 months</option><option value="62 months">62 months</option><option value="63 months">63 months</option><option value="64 months">64 months</option><option value="65 months">65 months</option><option value="66 months">66 months</option><option value="67 months">67 months</option><option value="68 months">68 months</option><option value="69 months">69 months</option><option value="70 months">70 months</option><option value="71 months">71 months</option><option value="72 months">72 months (6 years)</option><option value="73 months">73 months</option><option value="74 months">74 months</option><option value="75 months">75 months</option><option value="76 months">76 months</option><option value="77 months">77 months</option><option value="78 months">78 months</option><option value="79 months">79 months</option><option value="80 months">80 months</option><option value="81 months">81 months</option><option value="82 months">82 months</option><option value="83 months">83 months</option><option value="84 months">84 months (7 years)</option><option value="85 months">85 months</option><option value="86 months">86 months</option><option value="87 months">87 months</option><option value="88 months">88 months</option><option value="89 months">89 months</option><option value="90 months">90 months</option><option value="91 months">91 months</option><option value="92 months">92 months</option><option value="93 months">93 months</option><option value="94 months">94 months</option><option value="95 months">95 months</option><option value="96 months">96 months (8 years)</option><option value="97 months">97 months</option><option value="98 months">98 months</option><option value="99 months">99 months</option><option value="100 months">100 months</option><option value="101 months">101 months</option><option value="102 months">102 months</option></select><input type="submit" value="Add" style="display: none" data-wait="Please wait..." data-w-id="4c586f89-5d7c-5b89-448b-aae55028d0b9" class="button w-button"></form>
            <div class="w-form-done">
              <div>Thank you! Your submission has been received!</div>
            </div>
            <div class="w-form-fail">
              <div>Oops! Something went wrong while submitting the form.</div>
            </div>
          </div>
        </div>
        <div id="debt-legal-obligation-output-box" class="div-block box" style="display:none">
          <div id="student-loan-form-complete" class="w-form">
            <div>
              <div id="select-type" class="row w-row">
                <div class="debt-sources-type-elements w-clearfix w-col w-col-6">
                  <h4 id="subsectionHeader-legalObligatoin" class="heading">Legal Obligation</h4>
                </div>
                <div class="debt-sources-type-elements w-col w-col-6">
                  <div id="icon-credit-card" class="icon regular disabled"></div>
                  <div id="icon-student-loan" class="icon solid disabled"></div>
                  <div id="icon-payday-loan" class="icon solid disabled"></div>
                  <div id="icon-loan" class="icon solid disabled"></div>
                  <div id="icon-legal-obligation" class="icon solid"></div>
                </div>
              </div>
            </div>
            <form id="wf-form-Student-Loan-Form-Complete" name="wf-form-Student-Loan-Form-Complete" data-name="Student Loan Form Complete"><label for="name" class="form-label">Nickname</label>
              <p id="Legal-Obligation-Nickname-Complete">Child Support</p>
              <div class="data-descriptor">
                <div>So tell me, what was your...</div>
              </div><label for="balance" class="form-label">Legal Obligation Amount</label>
              <p id="Legal-Obligation-Amount-Complete">$30,000.00</p><label for="apr" class="form-label">Remaining Term</label>
              <p id="Legal-Obligation-Remaining-Term-Complete">227 months</p><a href="#" data-w-id="b2a05eb3-c063-cd5c-b85a-119a6400c562" class="hollow-button primary">Edit</a><a href="#" class="ghost">Remove</a></form>
            <div class="w-form-done">
              <div>Thank you! Your submission has been received!</div>
            </div>
            <div class="w-form-fail">
              <div>Oops! Something went wrong while submitting the form.</div>
            </div>
          </div>
        </div>
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
        <a href="#" id="saveButton" style="display: none" class="hollow-button strong">Save</a></div>
        <div class="align-right w-col w-col-6 w-col-small-6 w-col-tiny-6"><a href="dashboard.php?user_id=<?php echo $user_id;?>" id="continueButton" style="display: none" class="button">Continue to Dashboard</a>
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
            $('#uid').text(user.uid);
            $('#first-name').text(user.displayName);
        }
        else {
            console.log('No user is signed in');
            window.location = "login.php"
        }
        //var user1 = firebase.auth().currentUser;
        //console.log (user1.uid);
    })
    document.getElementById("linkSignOut").addEventListener('click', function (event) {
        firebase.auth().signOut();
        console.log('User was signed out');
    })

  </script>
<!-- Ravi's changes to include signon END-->
</body>
</html>
