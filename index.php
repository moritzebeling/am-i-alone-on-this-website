<?php

require_once 'app/index.php';

$app = new App();

?>
<html>
  <head>
    <title>Am I alone on this website?</title>
    <style>
      body {
        background-color: #ccc;
        transition: background-color 1s ease;
      }
      body.alone {
        background-color: #ccc;
      }
      body.companion {
        background-color: #fff;
      }
    </style>
    <script>

      const id = '<?= $app->id; ?>';

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

      let request;

      function makeRequest() {
        request = new XMLHttpRequest();

        if (!request) {
          alert('Giving up :( Cannot create an XMLHTTP instance');
          return false;
        }
        request.onreadystatechange = alertContents;
        request.open('GET', '/api.php?id='+id);
        request.send();
      }

      function alertContents() {
        let companions;
        if (request.readyState === XMLHttpRequest.DONE) {
          if (request.status === 200) {
            companions = request.responseText;
            console.log( companions );
            return companions;
          } else {
            console.error('There was a problem with the request.');
          }
        }
      }

      setInterval(()=>{

        let check = makeRequest();
        setStatus( check );

      }, 2000);

    </script>
  </head>
  <body class="<?= $app->status(); ?>"><body>
</html>
