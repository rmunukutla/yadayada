<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Yada Yada Register or Login</title>
    <link href="css/normalize.css" rel="stylesheet" type="text/css">
    <link href="css/webflow.css" rel="stylesheet" type="text/css">
    <link href="css/yadayadadebt.webflow.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js" type="text/javascript"></script>
    <script type="text/javascript">WebFont.load({  google: {    families: ["Inconsolata:400,700","Merriweather:300,300italic,400,400italic,700,700italic,900,900italic","Roboto:300,regular,500"]  }});</script>

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
    <script type="text/javascript">
      // FirebaseUI config.
      var uiConfig = {
        signInSuccessUrl: 'http://localhost:8888/yadayada/',        // TBD
        signInOptions: [
          // Leave the lines as is for the providers you want to offer your users.
          firebase.auth.GoogleAuthProvider.PROVIDER_ID,
          firebase.auth.EmailAuthProvider.PROVIDER_ID,
        ],
        // tosUrl and privacyPolicyUrl accept either url string or a callback
        // function.
        // Terms of service url/callback.
        tosUrl: '<your-tos-url>',                                   // TBD
        // Privacy policy url/callback.
        privacyPolicyUrl: function() {
          window.location.assign('<your-privacy-policy-url>');      // TBD
        }
      };
      // Initialize the FirebaseUI Widget using Firebase.
      var ui = new firebaseui.auth.AuthUI(firebase.auth());
      // The start method will wait until the DOM is loaded.
      ui.start('#firebaseui-auth-container', uiConfig);
    </script>
  </head>

  <body>
    <!-- The surrounding HTML is left untouched by FirebaseUI.
         Your app may use that space for branding, controls and other customizations.-->
                                    <div data-collapse="medium" data-animation="default" data-duration="400" class="navigation-bar dark w-nav">
         <div class="w-container">
           <a href="index.html" class="brand-link white w-nav-brand">
             <h1 class="brand-text">Yada Yada Debt</h1>
             <div class="icon gold nav-icons">  </div>
           </a>
           <nav role="navigation" class="navigation-menu w-nav-menu"><a href="index.html" class="navigation-link white w-nav-link" style="max-width: 940px;">Home</a><a href="#" class="navigation-link white w-nav-link" style="max-width: 940px;">About</a><a href="#" class="navigation-link white w-nav-link" style="max-width: 940px;">Contact</a></nav>
           <div class="hamburger-button white w-nav-button">
             <div class="w-icon-nav-menu"></div>
           </div>
         </div>
       <div class="w-nav-overlay" data-wf-ignore=""></div></div>
       <div class="section-2">
         <div class="container-top-24 w-container">
           <h1 class="section-heading">Let's Get Started</h1>
           <div class="section">
             <div id="firebaseui-auth-container"></div>
           </div>
         </div>
       </div>
  </body>
</html>
