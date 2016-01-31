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
			                                <i class="fa fa-globe"></i> Candidates List.
			                                <small class="pull-right">Date: 2/10/2014</small>
			                            </h2>
			                           
			                            <!-- /.Results Table -->
			                           	<div>
				                            
				                            <div class="box-body table-responsive">
				                                <table id="example1" class="table table-bordered table-striped">
				                                    <thead>
				                                        <tr>
				                                            <th>Candidates Name</th>
				                                            <th>Position</th>
				                                            <th>Motto</th>
				                                            <th>Actions</th>
				                                            
				                                        </tr>
				                                    </thead>
				                                    <tbody>
				                                    	@foreach($candidates as $candidate)
				                                        <tr>
				                                            <td>{{$candidate->User()->first()->First_Name.' '.$candidate->User()->first()->Last_Name}}</td>
				                                            <td>{{$candidate->Post()->first()->Post_Name}}</td>
				                                            <td>{{$candidate->Motto}}</td>
				                                            <td><button type="submit" class="btn btn-primary"  data-toggle="modal" data-target="#mysecondModal{{$candidate->id}}"  href="">Edit</button>
				                                            <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#mydeleteModal{{$candidate->id}}" href="" >Delete</button></td>
				                                           
				                                            <!-- Modal -->
															<div class="modal fade" id="mysecondModal{{$candidate->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
															  <div class="modal-dialog">
															    <div class="modal-content">
															      <div class="modal-header">
															        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
															        <h4 class="modal-title" id="myModalLabel">Edit Candidate</h4>
															      </div>
															      <div class="modal-body">
															       <form class="form-horizontal" role="form" action="{{URL::route('admin-edit-candidate-post')}}" method="post">
																	  <div class="form-group">
																	    
																	   <div class="form-group">
								                                            <label for="exampleInputEmail1">Registration Number</label>
								                                            <input disabled="disabled" required="required" type="text" class="form-control" name="Students_ID" value="{{$candidate->User()->first()->Identity_No}}" placeholder="Registration Number">
								                                        </div>
								                                        
								                                     
								                                        <!-- select -->
								                                        <div class="form-group">
								                                            <label>Post</label>
								                                            <select required="required" name="Post" class="form-control">
								                                                <option value="">Select</option> 
								                                            	@foreach($posts as $post)
								                                                	<option @if($candidate->Posts_Id == $post->id) selected="selected" @endif value="{{$post->id}}">{{$post->Post_Name}}</option>
								                                                @endforeach
								                                            </select>
								                                            @if($errors->has('Post'))
																			<p style="color:red;"> {{$errors->first('Post')}}</p>
																			@endif	
								                                        </div>
								                                        
								                                        <div class="form-group">
								                                            <label for="exampleInputEmail1">Motto</label>
								                                            <input name="Motto" required="required" type="text" value="{{$candidate->Motto}}" class="form-control" placeholder="Candidate's Motto">
								                                        	@if($errors->has('Motto'))
																			<p style="color:red;"> {{$errors->first('Motto')}}</p>
																			@endif	
								                                        </div> 
                                   
																	 
																	 <input type="hidden" name="Candidate_ID" value="{{$candidate->id}}">
																	 
																	  
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
															<div class="modal fade" id="mydeleteModal{{$candidate->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
															  <div class="modal-dialog">
															    <div class="modal-content">
															      <div class="modal-header">
															        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
															        <h4 class="modal-title" id="myModalLabel"> Confirm Delete</h4>
															      </div>
															      <div class="modal-body">
															       Are You Sure You Sure You Want To Delete?
															       <form id="deleteinfo" action="{{URL::route('admin-delete-candidate-post')}}" method="post">
															        <input type="hidden" id="Candidate_ID" name="Candidate_ID" value="{{$candidate->id}}">
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