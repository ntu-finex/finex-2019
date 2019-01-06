<?php 
    include('inc/header.php');
    require('secure/connect.php');
    
   include('auth/account_creation_process.php'); //function for processing account creation
?>

<body>
    <?php include('inc/navbar.php'); ?>
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
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Team Name</label>
                                    <div class="col-md-6">
                                        <input type="text" id="name" class="form-control" name="name" placeholder="Enter your team name" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="captainemail" class="col-md-4 col-form-label text-md-right">Captain's E-Mail Address</label>
                                    <div class="col-md-6">
                                        <input type="email" id="captainemail" class="form-control" name="captainemail" placeholder="Enter captain's email">
                                    </div>
                                </div>

                                <div class="form-group row">
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
                                </div>

                                <div class="form-group row">
                                    <label for="contact_number" class="col-md-4 col-form-label text-md-right">Contact Number</label>
                                    <div class="col-md-6">
                                        <input type="text" id="contact_number" class="form-control" placeholder="Enter contact number" name="contact_number">
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
                name:{
                    required: true,
                },
                captainemail:{
                    required: true,
                    email: true,
                },
                twoemail:{
                    required: true,
                    email: true,
                },
                threeemail:{
                    required: true,
                    email: true,
                },
                contact_number:{
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
