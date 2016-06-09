<!--Login page-->
<!doctype html>
<html>
  <head>
    <script src="../static\lib\jquery-2.2.4.js"></script>
    <link href="../static\lib\bootstrap-3.3.6-dist\css\bootstrap.min.css" type="text/css" rel="stylesheet" />
    <script src="../static\lib\bootstrap-3.3.6-dist\js\bootstrap.min.js"></script>
    <meta charset="utf-8">
    <title>Login - NBT</title>
  </head>
  <body>
    <div class="container">
      <h1>Login</h1>
      <div class="alert alert-danger" id="login-failed-alert" style="display:none;">Oops, username or password does not match, try again.</div>
      <div class="alert alert-success" id="login-success-alert" style="display:none;">Login successful, you will be redirected in 2 seconds.</div>
      <form role="form">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" class="form-control" id="username" placeholder="Enter Username">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" placeholder="Enter Password">
        </div>
        <button class="btn btn-primary" id="login-button" type="button">Login</button>
      </form>
    </div>
  </body>
</html>
<script type="text/javascript">
  //Event binding for login button
  //Fire an API request to login
  $("#login-button").click(function(){
    $.ajax({
      url:"../api/",
      type:"POST",
      data:{
        action:"login",
        username:$("#username").val(),
        password:$("#password").val()
      },
      dataType:"json",
      success:function(data){
        if(data["status"] == "success"){ //Login successful
          $("#login-failed-alert").slideUp();
          $("#login-success-alert").slideDown();
          setTimeout(function(){
            window.location = "../admin";
          },2000);
        } else { //Login failed
          $("#login-failed-alert").slideDown();
        }
      }
    });
  });
</script>
