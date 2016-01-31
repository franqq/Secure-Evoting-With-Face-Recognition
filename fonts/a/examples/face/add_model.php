<!--

    This example shows how start the KeyLemonJS to a modal to an existing identity

-->
<!Doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>KeyLemon js version 2.1</title>  
  <script src="../../frontend/keylemon.min.js" ></script>
</head>
<body>
  <?php
      // import KeyLemon file
      require_once '../../backend/keylemon.php';

      // create an instance of KeyLemon class
      $keylemon = new KeyLemon();
   
      // we assume that $identity_id contains the identity into which
      // the new model will be added
      $keylemon->set_identity($identity_id);
   
  ?>
  <div id="container">
  <script>
        require(['keylemon'], function (keylemon) {
              keylemon.init({
                  modality : "face",
                  func : "add_model",
                  target : '#container',
                  backendUrl : "../../backend",
                  bundlePath : "../../frontend",
                  floating : false,
                  preview : {
                      width : 320,
                      height: 240
                  },
                  faceDetect :  true,
                  eyeBlink :    true,
                  nbAuthenticationMax : 2,
                  bootstrap :   true,
                  fontawesome : true,
                  onFinish : function(authenticated, liveness){ 
                      alert("authenticated : " + authenticated + "\nliveness : " + liveness)
                  },
                  onInitialized : function(){
                      // Library completely loaded and intialized
                  }
            })
        })
    </script>
</body>
</html>
