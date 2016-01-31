<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>AdminLTE | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
         {{HTML::style('css/bootstrap.min.css')}}
        <!-- font Awesome -->
        {{HTML::style('css/font-awesome.min.css')}}
        <!-- Theme style -->
        {{HTML::style('css/AdminLTE.css')}}

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">Sign In</div>
             <form action="{{URL::route('login-post')}}" method="post">
                <div class="body bg-gray">
                	@if(Session::has('global'))
                		<p style="color:#990000">{{Session::get('global')}}</p>
					@endif
                	<div class="form-group">
                		<select required="required" name="User_Level" class="form-control">
                			<option value="admin">Administrator</option>
                			<option value="voter">Voter</option>
                		</select>
                		@if($errors->has('User_Level'))
						<p style="color:red;"> {{$errors->first('User_Level')}}</p>
			 			@endif	
                    </div>
                    <div class="form-group">
                        <input required="required"  type="text" name="Identity_No" class="form-control" placeholder="Identity Number"/>
                    	@if($errors->has('Identity_No'))
						<p style="color:red;"> {{$errors->first('Identity_No')}}</p>
						@endif
                    </div>
                    <div class="form-group">
                        <input type="password" required="required" name="Password" class="form-control" placeholder="Enter Password"/>
                   		@if($errors->has('Password'))
						<p style="color:red;"> {{$errors->first('Password')}}</p>
						@endif
                    </div>          
                   
                </div>
                <div class="footer"> 
                	{{Form::token()}}                                                              
                    <button type="submit" class="btn bg-olive btn-block">Continue</button>  
                    
                    <p><a href="#">I forgot my password</a></p>
                    
                    <a href="register.html" class="text-center">Register as a voter</a>
                </div>
            </form>

            
        </div>


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../../js/bootstrap.min.js" type="text/javascript"></script>        

    </body>
</html>