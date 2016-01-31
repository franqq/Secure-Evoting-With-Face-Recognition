@include('superadmin.layout.header')
		<aside class="right-side">
			<section class="content">
		        <!-- /.contents goes in here -->
		        @include('superadmin.layout.global')
		          <!-- general form elements -->
                            <div style="padding-left:30px;" class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">New Administrator</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                            <form role="form" action="{{URL::route('super-admin-new-admin-post')}}" enctype="multipart/form-data" method="post" style="width:85%">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">ID Number</label>
                                            <input type="text" class="form-control" required="required" name="Identity_No" placeholder="ID Number">
                                        	@if($errors->has('Identity_No'))
											<p style="color:red;"> {{$errors->first('Identity_No')}}</p>
											@endif
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email Address</label>
                                            <input type="email" class="form-control" name="Email" required="required" placeholder="Enter Email">
                                        	@if($errors->has('Email'))
											<p style="color:red;"> {{$errors->first('Email')}}</p>
											@endif
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Phone Number</label>
                                            <input type="text" class="form-control" name="Phone_Number" required="required" maxlength="10" placeholder="Enter Email">
                                        	@if($errors->has('Phone_Number'))
											<p style="color:red;"> {{$errors->first('Phone_Number')}}</p>
											@endif
                                        </div>
                                        
                                         <div class="form-group">
                                            <label for="exampleInputEmail1">First Name</label>
                                            <input type="text" class="form-control" name="First_Name" required="required" placeholder="First Name">
                                        	@if($errors->has('First_Name'))
											<p style="color:red;"> {{$errors->first('First_Name')}}</p>
											@endif
                                        </div>
                                         <div class="form-group">
                                            <label for="exampleInputEmail1">Last Name</label>
                                            <input type="text" class="form-control" name="Last_Name" required="required" placeholder="Last Name">
                                        	@if($errors->has('Last_Name'))
											<p style="color:red;"> {{$errors->first('Last_Name')}}</p>
											@endif
                                        </div>
                                        
                                        
                                        <div class="form-group" style="margin-bottom:100px;" >
                                        	<span style="float: left;">
	                                            <label style="" for="exampleInputFile">Voter Photo 1</label>
	                                            <input name="Photo_1" required="required" type="file">
                                            </span>
                                            <span style="float:left; margin-left:20px;">
	                                            <label for="exampleInputFile">Voter Photo 2</label>
	                                            <input name="Photo_2" required="required" type="file" >
                                            </span>
                                             <span style="float:left; margin-left:20px;">
	                                            <label for="exampleInputFile">Voter Photo 3</label>
	                                            <input name="Photo_3" required="required" type="file">
                                            </span>
                                        </div>
                                      
                                      
                                        
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                    	{{Form::token()}}
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div><!-- /.box -->
	          </section>
	      </aside>
        </div><!-- ./wrapper -->



        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- Morris.js charts -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="js/plugins/morris/morris.min.js" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- datepicker -->
        <script src="js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="js/AdminLTE/dashboard.js" type="text/javascript"></script>

        <!-- AdminLTE for demo purposes -->
        <script src="js/AdminLTE/demo.js" type="text/javascript"></script>

    </body>
</html>