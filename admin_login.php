<?php
    session_start();
    include('inc/admin_header.php');
    require('secure/connect.php');

    if(isset($_SESSION['teamName']) != ""){ //if logged in
        header("Location: admin_dashboard.php");
    }
    if(isset($_POST['submit'])){
        include('php/admin_login_process.php');
    }
?>

<body>
    <div class="container">
    <br>
    <div class="row justify-content-center">
            <div class="col-md-8">
                    <div class="container">
                        <!-- title -->
                        <div class="text-center">
                            <h1>STATION LOGIN</h1>                        
                        </div>
                        <hr>
                        <!-- login form -->
                        <br>
                        <div>
                            <form id="my-form" name="my-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <div class="form-group row">
                                    <label for="station" class="col-md-4 col-form-label text-md-right">Team Name</label>
                                    <div class="col-md-6">
                                        <input type="text" id="station" class="form-control" name="station" placeholder="Enter your station name" autofocus>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                    <div class="col-md-6">
                                        <input type="password" id="password" class="form-control" placeholder="Enter password" name="password">
                                    </div>
                                </div>
                                
                                <br>

                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-login btn-block" name="submit">
                                        <img id="img-1" src="images/finexrunning.png" width=8% height=auto>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>

</body>

<style>
    .btn.btn-login{
        background: rgb(16,32,66);       
    }
    .btn.btn-login:hover{
        background: rgb(16,40,66);
    }
    label.error{
        color: red;
    }
</style>

<script>
    $(function(){
        $("#my-form").validate({
            rules:{
                station:{
                    required: true,
                },
                password:{
                    required:true,
                }
            }
        })
    })
</script>