<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>yadayada login</title>
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
    <h1>Welcome to yadayada</h1>
    <div id="firebaseui-auth-container"></div>
  </body>
</html>
