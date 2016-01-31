@include('faceauth.layout.header')
		<aside >
			<section class="content">
		        <!-- /.contents goes in here -->
		        <div class="alert alert-success alert-dismissable">
			        <i class="fa fa-ban"></i>
			        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			        <b>Face Recognition!</b> The system needs to perform the second phase of authentication, please allow the browser to access your webcam.
			    </div> 
		          <!-- general form elements -->
                            <div align="center" class="box box-primary">
                                
                              	<script>// <![CDATA[
								navigator.getUserMedia = (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia ); 
								if (navigator.getUserMedia) {
									navigator.getUserMedia({
										video:true,
										audio:false
									},
									function(stream) { /* do-say something */ },
									function(error) {
										alert('Something went wrong. (error code ' + error.code + ')');
										return false;
									});
								} else {
									alert("Sorry, the browser you are using doesn't support the HTML5 webcam API");
									return false; 
								}
								// ]]></script>
								
								<script>// <![CDATA[
								// Put event listeners into place
									window.addEventListener("DOMContentLoaded", function() {
										// Grab elements, create settings, etc.
										var canvas = document.getElementById("canvas"),
											context = canvas.getContext("2d"),
											video = document.getElementById("video"),
											videoObj = { "video": true },
											image_format= "jpeg",
											jpeg_quality= 85,
											errBack = function(error) {
												console.log("Video capture error: ", error.code); 
											};
								
										$("#video").fadeIn("slow");
										$("#canvas").fadeOut("slow");
										// Put video listeners into place
										if(navigator.getUserMedia) { // Standard
											navigator.getUserMedia(videoObj, function(stream) {
												video.src = stream;
												video.play();
												$("#snap").show();
												
											}, errBack);
										} else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
											navigator.webkitGetUserMedia(videoObj, function(stream){
												video.src = window.webkitURL.createObjectURL(stream);
												video.play();
												$("#snap").show();
											}, errBack);
										} else if(navigator.mozGetUserMedia) { // moz-prefixed
											navigator.mozGetUserMedia(videoObj, function(stream){
												video.src = window.URL.createObjectURL(stream);
												video.play();
												$("#snap").show();
											}, errBack);
										}
										// video.play();       these 2 lines must be repeated above 3 times
										// $("#snap").show();  rather than here once, to keep "capture" hidden
										//                     until after the webcam has been activated.  
										
										
								
										// Get-Save Snapshot - image 
										document.getElementById("snap").addEventListener("click", function() {
											context.drawImage(video, 0, 0, 640, 480);
											// the fade only works on firefox?
											$("#video").fadeOut("slow");
											$("#canvas").fadeIn("slow");
											$("#snap").hide();
											$("#reset").show();
											$("#upload").show();
										});
										// reset - clear - to Capture New Photo
										document.getElementById("reset").addEventListener("click", function() {
											$("#video").fadeIn("slow");
											$("#canvas").fadeOut("slow");
											$("#snap").show();
											$("#reset").hide();
											$("#upload").hide();
										});
										// Upload image to sever 
										document.getElementById("upload").addEventListener("click", function(){
											var dataUrl = canvas.toDataURL("image/jpeg", 0.85);
											$("#uploading").show();
											$.ajax({
												type: "POST",
												url: "http://127.0.0.1/jkuatvs/faceauth/",
												data: { 
													imgBase64: dataUrl
												},
												success: function(data){
													document.location.href="http://127.0.0.1/jkuatvs/";
												}
											}).done(function(msg) {
												document.location.href="http://127.0.0.1/jkuatvs/";
											});
										});
									}, false);
								// ]]></script>
								
								<div class="camcontent">
									<video id="video" autoplay="autoplay" width="533" height="400"></video>
									<canvas id="canvas" width="533" height="400"> </canvas>
								</div>
								
								 <!-- send the face photo to the server -->
								 <script type="text/javascript">
							         <!--
							            function sendFacePhoto() {
							                var dataUrl = canvas.toDataURL("image/jpeg", 0.85);
							                //Load form
							                 document.getElementById("facephoto").value  = dataUrl;
							                 document.getElementById("facephotoform").submit();
							            }
							         //-->
							      </script>
							      
							      <!-- Hidden form to pass the image data -->
							      <form id="facephotoform" action="{{URL::route('faceauth-post')}}" enctype="multipart/form-data" method="post" style="width:85%">
							     	 <input type="hidden" id="facephoto" name="facephoto">
							     	 {{Form::token()}}
							      </form>
								
								<!-- Font awsome icons used in buttons -->
									<div class="cambuttons" style="margin-top: 10px;">
										<button id="snap" class="btn btn-default btn-lg" style="display: none;"> <i class="fa fa-camera"></i> Take picture </button>
										<button id="reset" class="btn btn-default btn-lg" style="display: none;"> <i class="fa fa-camera"></i> Take new picture </button>
										<button onclick="sendFacePhoto()" id="upload" class="btn btn-default btn-lg" style="display: none;"> <i class="fa fa-save"></i> Login </button>
										<span id="uploading" style="display: none;"> Authenticating. . . </span>
										<span id="uploaded" style="display: none;"> Authentication Successful. <a> Return </a> </span></div>
									&nbsp;
									<div id="camFeedback"></div>
	                            </div><!-- /.box -->
	          </section>
	      </aside>
        </div><!-- ./wrapper -->



        <!-- jQuery 2.0.2 -->
        {{HTML::script('http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js')}}
        <!-- jQuery UI 1.10.3 -->
        {{HTML::script('js/jquery-ui-1.10.3.min.js')}}
        <!-- Bootstrap -->
        {{HTML::script('js/bootstrap.min.js')}}
        <!-- Morris.js charts -->
        {{HTML::script('//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js')}}
        {{HTML::script('js/plugins/morris/morris.min.js')}}
        <!-- Sparkline -->
        {{HTML::script('js/plugins/sparkline/jquery.sparkline.min.js')}}
        <!-- jvectormap -->
        {{HTML::script('js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}
        {{HTML::script('js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}
        <!-- jQuery Knob Chart -->
        {{HTML::script('js/plugins/jqueryKnob/jquery.knob.js')}}
        <!-- daterangepicker -->
        {{HTML::script('js/plugins/daterangepicker/daterangepicker.js')}}
        <!-- datepicker -->
        {{HTML::script('js/plugins/datepicker/bootstrap-datepicker.js')}}
        <!-- Bootstrap WYSIHTML5 -->
        {{HTML::script('js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}
        <!-- iCheck -->
        {{HTML::script('js/plugins/iCheck/icheck.min.js')}}

        <!-- AdminLTE App -->
        {{HTML::script('js/AdminLTE/app.js')}}

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        {{HTML::script('js/AdminLTE/dashboard.js')}}

        <!-- AdminLTE for demo purposes -->
        {{HTML::script('js/AdminLTE/demo.js')}}

    </body>
</html>