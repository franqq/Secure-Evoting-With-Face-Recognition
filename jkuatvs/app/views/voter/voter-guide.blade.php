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
			                                <i class="fa fa-globe"></i> Voters' Guide.
			                                <small class="pull-right">Date: 2/10/2014</small>
			                            </h2>
			                            
			                            <p>
			                            	The student councils promote the interests of students within JKUAT. The annual student council elections are an opportunity for students to show their involvement with education and the University.
										</p>
										<p>
											Each faculty has its own Faculty Student Council, and there is a Central Student Council (CSR) for the entire University. The individual faculty student councils convene with the deans of their respective faculties, and the Central Student Council convenes with the Rector Magnificus of the Executive Board. All students enrolled at JKUAT are eligible to vote for candidates in the annual elections for both the faculty student councils and the Central Student Council.
										</p>
										<p>
											The Central Voting Office has set a voting period for the 2015-2016 student council elections. The elections will take place from 2 to 5 June. All students who are eligible to vote will receive official communication on 1 June.
			                        	</p>
			                        	
			                        	
			                        	
			                        	
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