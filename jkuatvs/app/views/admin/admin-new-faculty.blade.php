@include('admin.layout.header')
		<aside class="right-side">
			<section class="content">
				@include('admin.layout.global')
		        <!-- /.contents goes in here -->
		          <!-- general form elements -->
                            <div style="padding-left:30px;" class="box box-primary">
                                <div class="box-header">
                                	@if(Session::has('global'))
										<span style="color:red;"> </span>
									@endif 
                                    <h3 class="box-title">Register Faculty</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form role="form" action="{{URL::route('admin-new-faculty-post')}}" method="post" style="width:60%">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Faculty Name</label>
                                            <input type="text" class="form-control" required="required " name="Faculty_Name" placeholder="Faculty Name">
                                        	@if($errors->has('Faculty_Name'))
											<p style="color:red;"> {{$errors->first('Faculty_Name')}}</p>
											@endif	
                                        </div>
										<div class="form-group">
                                            <label for="exampleInputEmail1">Faculty Alias</label>
                                            <input type="text" required="required" class="form-control"name="Faculty_Alias" placeholder="Faculty Alias">
                                       		@if($errors->has('Faculty_Alias'))
											<p style="color:red;"> {{$errors->first('Faculty_Alias')}}</p>
											@endif	
                                        </div>                                        
                                       <!-- textarea -->
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" rows="3" name="Description" placeholder="Enter ..."></textarea>
                                        	@if($errors->has('Description'))
											<p style="color:red;"> {{$errors->first('Description')}}</p>
											@endif	
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