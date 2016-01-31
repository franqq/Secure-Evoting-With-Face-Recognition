@include('voter.layout.header')
		<aside class="right-side">
			<section class="content">
		        <!-- /.contents goes in here -->
		         @include('voter.layout.global')
		          <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="row">
			                       
			                    </div>
                                <!-- form start -->
                                <form role="form">
                                	
                                     <div class="col-xs-12">
                                     	
			                            <h2 style="margin-left:10px;margin-right:10px;" class="page-header">
			                                <i class="fa fa-globe"></i> Vote for {{$post->Post_Name}}.
			                                <small class="pull-right">Date: 2/10/2014</small>
			                            </h2>
			                            @foreach($candidates as $candidate)
				                            <div style="margin-left;10px;margin-bottom:20px;height:98px;width:100%;border:ridge; border-width:1px;padding:3px;border-color:#eeeeee;float:left;">
					                            <div style="height:90px;width:90px;float:left;">{{HTML::image($candidate->Photo)}}</div>
					                        	<div style="height:90px;float:left;margin-left:20px;font-size:14pt;"><b>Name:</b> {{$candidate->User()->first()->First_Name.' '.$candidate->User()->first()->Last_Name}} <br />
					                        		<b>Motto:</b> {{$candidate->Motto}}
					                        	</div>
					                        	<div style="float:right;margin:30px;">
					                        		 <label>
		                                                <input name="{{$post->Post_Name}}" value="{{$candidate->id}}" type="radio"> Vote for this Candidate
		                                            </label>
					                        	</div>
				                        	</div>
				                        @endforeach
			                        	
			                        	.   	
			                        	
			                        	<div style="margin-left:30px;float:left;">
	                                        <button type="submit" class="btn btn-success">Save</button>
	                                    </div>
	                                    <div style="margin-right:30px;float:right;">
	                                       <button onclick="window.location.href='{{URL::route('voter-vote-next-get',$post->id)}}'" type="button" class="btn btn-primary">Next</button>
	                                    </div>
			                        </div><!-- /.col -->

                                    <div style="visibility:hidden;" class="box-footer">
                                        <button type="submit" class="btn btn-primary"></button>
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