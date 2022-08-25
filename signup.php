<?php 
    session_start();
    if(isset($_SESSION['userId'])) {
        header("Location:./notes");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Note Down</title>
    <link rel="stylesheet" href="./assets/css/login.css">
</head>
<body>


    <div class="login">
        <form class="signup-form" autocomplete="off">
            <div class="input">
                <input type="text" name="name" placeholder="Full Name" />
            </div>
            <div class="input">
                <input type="email" name="email" placeholder="Email Address" />
            </div>
            <div class="input">
                <input type="password" name="password" placeholder="Password" />
            </div>
            <button type="submit">Sign Up <span class="btn-spin"></span></button>
            <p><a href="./">Login</a></p>
        </form>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $(".signup-form").on("submit", function(e){
                e.preventDefault();

                $('.signup-form').find('button .btn-spin').css({display: 'flex'})

                let signupForm = new FormData(this);

                $.ajax({
                    url: "./crud/login-signup/signup",
                    type: "POST",
                    data: signupForm,
                    contentType: false,
                    processData: false,
                    success: function (data) {

                        
                        if(data.status == true) {
                            setTimeout(() => {
                                window.location = "./";
                            }, 1000);
                        }else if(data.status == false) {
                            setTimeout(() => {
                                alert(data.message);
                                $('.signup-form').find('button .btn-spin').css({display: 'none'});
                                $('[name="email"]').focus();
                            }, 500);
                        }
                        
                    }
                });

            });
        });
    </script>
    
</body>
</html>