<?php

require_once 'app/index.php';

?>
<html>
  <head>
    <title>Am I alone on this website?</title>
    <style>
      body {
        background-color: #000;
        transition-property: background-color;
        transition-timing-function: ease;
        transition-duration: 10s;
      }
      body.companion {
        background-color: #fff;
        transition-duration: 1s;
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
            setStatus( parseInt( request.responseText ) );

          } else {
            console.error('There was a problem with the request.');
          }
        }
      }

      setInterval(()=>{

        makeRequest();

      }, 2000);

    </script>
  </head>
  <body class="<?= $app->status(); ?>"><body>
</html>
