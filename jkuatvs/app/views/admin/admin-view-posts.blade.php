@include('admin.layout.header')
		<aside class="right-side">
			<section class="content">
		        <!-- /.contents goes in here -->
		        @include('admin.layout.global')
		          <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="row">
			                       
			                    </div>
                                <!-- form start -->
                                <form role="form">
                                	
                                     <div class="col-xs-12">
			                            <h2 style="margin-left:10px;margin-right:10px;" class="page-header">
			                                <i class="fa fa-globe"></i> List of Posts.
			                                <small class="pull-right">Date: 2/10/2014</small>
			                            </h2>
			                           
			                            <!-- /.Results Table -->
			                           	<div>
				                            
				                            <div class="box-body table-responsive">
				                                <table id="example1" class="table table-bordered table-striped">
				                                    <thead>
				                                        <tr>
				                                            <th>Post Name</th>
				                                            <th>Actions</th>				                                            
				                                        </tr>
				                                    </thead>
				                                    <tbody>
				                                    	@foreach($posts as $post)
				                                        <tr>
				                                            <td>{{$post->Post_Name}}</td>
				                                            <td><button type="submit" class="btn btn-primary"  data-toggle="modal" data-target="#mysecondModal{{$post->id}}"  href="">Edit</button>
				                                            <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#mydeleteModal{{$post->id}}" href="" >Delete</button></td>
				                                           
				                                            <!-- Modal -->
															<div class="modal fade" id="mysecondModal{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
															  <div class="modal-dialog">
															    <div class="modal-content">
															      <div class="modal-header">
															        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
															        <h4 class="modal-title" id="myModalLabel">Edit Post</h4>
															      </div>
															      <div class="modal-body">
															       <form class="form-horizontal" role="form" action="{{URL::route('admin-edit-post-post')}}" method="post">
																	  <div class="form-group">
																	    
																	   <label for="Name" class="col-sm-2 control-label">Name</label>
																	    <div class="col-sm-10" style="margin-bottom:15px;">
																	      <input type="text" class="form-control" id="Post_Name" name="Post_Name" required="required" 
																	      placeholder="Enter Post Name*" value="{{$post->Post_Name}}" />
																	    </div>
																	     @if($errors->has('Post_Name'))
																	         <div style="color:#990000; text-align:center;">{{$errors->first('Post_Name')}}</div>
																	     @endif
																	    
																	   
																	    
																	    <label for="Description" class="col-sm-2 control-label">Description</label>
																	    <div class="col-sm-10" style="margin-bottom:15px;">
																	      <input type="text" class="form-control" id="Description" name="Description" 
																	      placeholder="Enter Description*" value="{{$post->Description}}" />
																	    </div>
																	     @if($errors->has('Description'))
																	         <div style="color:#990000; text-align:center;">{{$errors->first('Description')}}</div>
																	     @endif
																	    
																	     
																	     
																	 
																	 <input type="hidden" name="Post_ID" value="{{$post->id}}">
																	 
																	  
																	  <div class="form-group">
																	    <div class="col-sm-offset-2 col-sm-10">
																	    </div>
																	  </div>
																	  {{Form::token()}}
															
															      </div>
															      <div class="modal-footer">
															        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															        <button type="submit" class="btn btn-primary">Save changes</button>
															      </div>
															      </form>
															    </div>
															  </div>
															</div>
															</div>
				                                           
				                                            <!--Delete Modal -->
															<div class="modal fade" id="mydeleteModal{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
															  <div class="modal-dialog">
															    <div class="modal-content">
															      <div class="modal-header">
															        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
															        <h4 class="modal-title" id="myModalLabel"> Confirm Delete</h4>
															      </div>
															      <div class="modal-body">
															       Are You Sure You Sure You Want To Delete?
															       <form id="deleteinfo" action="{{URL::route('admin-delete-post-post')}}" method="post">
															        <input type="hidden" id="Post_ID" name="Post_ID" value="{{$post->id}}">
															        {{Form::token()}}
															      
															      </div>
															      <div class="modal-footer">
															        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
															        <button type="submit" class="btn btn-danger">Yes</button>
															      </div>
															       </form>
															    </div>
															  </div>
															</div>
				                                        </tr>  
				                                        @endforeach
				                                                                          
				                                    </tbody>
				                                </table>
				                            </div><!-- /.box-body -->
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