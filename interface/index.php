<?php

require_once 'app/index.php';

$app = new App();

?>
<html>
  <head>
    <title>Am I alone on this website?</title>
    <style>
      body {
        background-color: #000;
        transition: background-color 1s ease;
      }
      body.alone {
        background-color: #000;
      }
      body.companion {
        background-color: #fff;
      }
    </style>
    <script>

      const id = '<?= $app->id(); ?>';

      function setStatus( companions = 0 ){
        if( companions === 0 ){
          document.body.classList.remove('companion');
          document.body.classList.add('alone');
          document.title = 'You are alone on this website.';
        } else {
          document.body.classList.remove('alone');
          document.body.classList.add('companion');
          document.title = 'You have '+companions+' companions on this website.';
        }
      }

      let httpRequest;

      function makeRequest() {
        httpRequest = new XMLHttpRequest();

        if (!httpRequest) {
          alert('Giving up :( Cannot create an XMLHTTP instance');
          return false;
        }
        httpRequest.onreadystatechange = alertContents;
        httpRequest.open('GET', 'test.html');
        httpRequest.send();
      }

      function alertContents() {
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
          if (httpRequest.status === 200) {
            alert(httpRequest.responseText);
          } else {
            alert('There was a problem with the request.');
          }
        }
      }

      setInterval(()=>{

        setStatus( Math.floor( Math.random() * 5 ) );

      }, 2000);

    </script>
  </head>
  <body class="<?= $app->status(); ?>"><body>
</html>
