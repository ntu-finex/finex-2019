<?php 
    session_start();
    include('inc/header.php');
    require('secure/connect.php');
    if(isset($_SESSION['teamName']) == ""){
        header("Location: index.php");
    }
    if(isset($_POST['submit'])){
        include('php/account_creation_process.php'); //function for processing account creation
    }
?>

<body>
    <br>
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                    <div class="container">
                        <!-- title -->
                        <div class="text-center">
                            <h1>FINEX 2019 Account Creation</h1>                        
                            <caption>Please fill in the below form.</caption>
                        </div>
                        <hr>
                        <!-- registration form -->
                        <div>
                            <form id="my-form" name="my-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <div class="form-group row">
                                    <label for="teamName" class="col-md-4 col-form-label text-md-right">Team Name</label>
                                    <div class="col-md-6">
                                        <input type="text" id="teamName" class="form-control" name="teamName" placeholder="Enter your team name" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="captainemail" class="col-md-4 col-form-label text-md-right">Captain's E-Mail Address</label>
                                    <div class="col-md-6">
                                        <input type="email" id="captainEmail" class="form-control" name="captainEmail" placeholder="Enter captain's email">
                                    </div>
                                </div>

                                <!-- <div class="form-group row">
                                    <label for="twoemail" class="col-md-4 col-form-label text-md-right">Member's E-Mail Address</label>
                                    <div class="col-md-6">
                                        <input type="email" id="twoemail" class="form-control" name="twoemail" placeholder="Enter member's email (optional)">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="threeemail" class="col-md-4 col-form-label text-md-right">Member's E-Mail Address</label>
                                    <div class="col-md-6">
                                        <input type="email" id="threeemail" class="form-control" name="threeemail" placeholder="Enter member's email (optional)">
                                    </div>
                                </div> -->

                                <div class="form-group row">
                                    <label for="contactNumber" class="col-md-4 col-form-label text-md-right">Contact Number</label>
                                    <div class="col-md-6">
                                        <input type="text" id="contactNumber" class="form-control" placeholder="Enter contact number" name="contactNumber">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                    <div class="col-md-6">
                                        <input type="password" id="password" class="form-control" placeholder="Enter password" name="password">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="confirm_pw" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                    <div class="col-md-6">
                                        <input type="password" id="confirm_pw" class="form-control" placeholder="Enter password again" name="confirm_pw">
                                    </div>
                                </div>

                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary" name="submit">
                                        Register
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

</html>

<script>

    $(function(){
        $("#my-form").validate({
            rules:{
                teamName:{
                    required: true,
                },
                captainEmail:{
                    required: true,
                    email: true,
                },
                contactNumber:{
                    required:true,
                },
                password:{
                    required:true,
                },
                confirm_pw:{
                    required:true,
                    equalTo: "#password",
                },
            },
            messages:{
                    confirm_pw:{
                        equalTo: "Please enter the same password",
                    }
                }
        })
    });
</script>

<style>
    .error{
        border-color: red;
    }
</style>
