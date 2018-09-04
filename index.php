<!DOCTYPE html>
<!--  This site was created in Webflow. http://www.webflow.com  -->
<!--  Last Published: Tue Aug 21 2018 12:08:16 GMT+0000 (UTC)  -->
<html data-wf-page="5ac55226016bff3188ced390" data-wf-site="5ac55225016bff3a51ced38b">
<head>
  <meta charset="utf-8">
  <title>Yada Yada Debt</title>
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
</head>
<body class="body">
  <div class="hero-with-nav">
    <div class="w-container">
      <div data-collapse="medium" data-animation="default" data-duration="400" class="navigation-bar top w-nav"><a href="#" class="brand-link left w-nav-brand"></a>
        <nav role="navigation" class="navigation-menu w-nav-menu">
          <a href="#" class="navigation-link w-nav-link">Home</a>
          <a href="#" class="navigation-link w-nav-link">About</a>
          <a href="#" class="navigation-link w-nav-link">Contact</a>
          <!-- Ravi's changes to include signon BEGIN-->
          <a href="/yadayada/login.php" class="navigation-link w-nav-link" id ="linkSignIn">Sign In</a>   <!-- TBD -->
          <a href="#" class="navigation-link w-nav-link" id ="linkSignOut">Sign Out</a>
          <!-- Ravi's changes to include signon END-->
        </nav>
        <div class="hamburger-button w-nav-button">
          <div class="w-icon-nav-menu"></div>
        </div>
      </div>
      <div class="hero-title-wrapper">
        <div class="icon gold">  </div>
        <h1 class="hero-heading">Yada Yada Debt</h1>
        <div class="hero-subheading">Your <strong>Get Out of Debt</strong> Planning Guide</div>
        <div><a href="dashboard.html" class="button hero-button">Get Started</a></div>
      </div>
    </div>
  </div>
  <div class="section">
    <div class="w-container">
      <div class="section-title-group">
        <h2 class="section-heading centered">How It Works</h2>
      </div>
      <div class="w-row">
        <div class="feature-column w-col w-col-4">
          <div class="step-callout">01</div>
          <h3 class="heading-3">Tell us what you owe</h3>
          <p>Provide a list of all your debt with the amount owed, interest rate and minimum monthly payment.</p>
        </div>
        <div class="feature-column w-col w-col-4">
          <div class="step-callout">02</div>
          <h3 class="heading-3">Get a payoff plan</h3>
          <p>Receive a monthly plan of how much you should pay for each debt with when they will be paid off by.</p>
        </div>
        <div class="feature-column w-col w-col-4">
          <div class="step-callout">03</div>
          <h3 class="heading-3">See your options</h3>
          <p>Receive ways on how you can pay less and understand the trade-offs.</p>
        </div>
      </div>
    </div>
  </div>
  <div class="fixed-image-section">
    <div class="w-container">
      <h1 class="page-heading">Image of the dashboard</h1>
      <div class="page-subheading">This is some text inside of a div block.</div>
    </div>
  </div>
  <div class="footer accent">
    <div class="w-container">
      <div class="w-row">
        <div class="w-col w-col-3">
          <h1 class="footer-brand-text">Yada Yada Debt</h1>
          <p>Yada Yada Debt&#x27;s goal it to help those that don&#x27;t get the time of day from Financial Advisors.</p>
          <div><a href="#" class="social-icon-link w-inline-block"><img src="images/social-03.svg" width="20"></a><a href="#" class="social-icon-link w-inline-block"><img src="images/social-18.svg" width="20"></a><a href="#" class="social-icon-link w-inline-block"><img src="images/social-09.svg" width="20"></a><a href="#" class="social-icon-link w-inline-block"><img src="images/social-06.svg" width="20"></a></div>
        </div>
        <div class="w-col w-col-3">
          <h5>PRODUCT</h5><a href="#" class="footer-link">Money</a><a href="#" class="footer-link">Footer Text Link</a><a href="#" class="footer-link">Footer Text Link</a><a href="#" class="footer-link">Footer Text Link</a></div>
        <div class="w-col w-col-3">
          <h5>SOCIAL</h5><a href="#" class="footer-link">Footer Text Link</a><a href="#" class="footer-link">Footer Text Link</a><a href="#" class="footer-link">Footer Text Link</a><a href="#" class="footer-link">Footer Text Link</a><a href="#" class="footer-link">Footer Text Link</a></div>
        <div class="w-col w-col-3">
          <h5>LEGAL</h5><a href="#" class="footer-link">Footer Text Link</a><a href="#" class="footer-link">Footer Text Link</a><a href="#" class="footer-link">Footer Text Link</a></div>
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
            }
            // If user is logged out then show log in button BUT hide the log out button and profile button
            else {
                document.getElementById("linkSignIn").style.display = 'inline-block';
                document.getElementById("linkSignOut").style.display = 'none';
            }
    })
    firebase.auth().onAuthStateChanged(user => {
        if (user) {
            console.log('User is signed in');
        }
        else {
            console.log('No user is signed in');
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
