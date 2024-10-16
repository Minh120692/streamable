<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<style>
    body {
        font-family: 'Roboto', sans-serif;
    }
</style>

<body style="background-color:#f1f1f1;">
    <div class="container">
        <div class="row  justify-content-center align-items-center mt-2  ">
            <div class="col-4 ">
                <div class="card shadow" style="border-radius: 20px; ">
                    <div class="d-flex justify-content-center my-3">
                        <img style=" width: 200px; height: 40px;" src="./img/logoS.PNG" alt="">
                    </div>
                    <div class=" text-center">
                        <h3>Log in</h3>
                        <p class="pt-2">to continue to <strong>Streamable</strong></p>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3 custom-hover ">
                                <div class="border d-flex py-2"
                                    style="border-radius: 5px; justify-content: space-around" role="button"
                                    tabindex="0">
                                    <div><img style=" width: 18px; height: 18px;" src="./img/Logo-google-icon-PNG.png" alt="">
                                    </div>
                                    <p style="font-size: 14px; margin-bottom: 0px;">Tiếp tục sử dụng dịch vụ từ Google
                                    </p>
                                </div>
                                <style>
                                    .custom-hover:hover {
                                        background-color: #f8faff;
                                    }
                                </style>
                            </div>

                            <div class="mb-3 custom-hover d-flex justify-content-center ">
                                <div class="border d-flex py-2"
                                    style="border-radius: 5px; justify-content: space-around; align-items: center; width: 290px;"
                                    role="button" tabindex="0">
                                    <div><i style="color: #1977f2;" class="bi bi-facebook"></i>
                                    </div>
                                    <p style="font-size: 14px; margin-bottom: 0px; justify-content:center">Continue with Facebook </p>

                                </div>
                                <style>
                                    .custom-hover:hover {
                                        background-color: #f8faff;
                                    }
                                </style>
                            </div>
                            <div class="d-flex align-items-center mb-3" style="color: #cccccc;">
                                <div class="flex-grow-1 border-top"></div>
                                <span class="mx-2">or sign up with email</span>
                                <div class="flex-grow-1 border-top"></div>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" id="email" placeholder="Email address"
                                    required>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" id="password" placeholder="Password"
                                    required>
                            </div>


                            <button type="button" id="login" class="btn btn-secondary w-100"  disabled>Log in</button>
                        </form>
                    </div>
                    <div class="card-footer text-center py-4 " style="font-size: 14px; color:#9b9b9b;">
                        <p style="margin-bottom: 0;">By continuing, you accept our <a href="#">Terms of Service</a></p>
                        <p style="margin-bottom: 0;">and acknowledge receipt of our <a href="#">Privacy Policy</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container  ">
        <div class="d-flex justify-content-center">
            <div class="d-flex pt-3" style="align-items: flex-start; font-size: 14px;">
                <p style="color:#9b9b9b;margin-bottom: 0;">Don't have an account?</p>
                <button style="border: none; background-color:#f1f1f1;color: #555555;" type="button"><b
                        class="custom-hover">Sign up for
                        free</b></button>
            </div>
            <style>
                .custom-hover:hover {
                    color: black;
                    background-color: #f1f1f1
                }
            </style>

        </div>
        <div class="d-flex justify-content-center">
            <div class="d-flex" style="align-items: flex-start; font-size: 14px;">
                <button style="border: none; background-color:#f1f1f1;color: #555555;" type="button"><b
                        class="custom-hover">Forgot your password?</b></button>
            </div>
            <style>
                .custom-hover:hover {
                    color: black;
                    background-color: #f1f1f1
                }
            </style>
        </div>
    </div>
    <script>
        
        var emailInput = document.getElementById('email');
        var passwordInput = document.getElementById('password');
        var loginButton = document.getElementById('login');
    
        function checkInputs() {
            var emailValue = emailInput.value.trim();
            var passwordValue = passwordInput.value.trim();
    
            if (emailValue && passwordValue) {
                loginButton.disabled = false;
                loginButton.classList.remove('btn-secondary');
                loginButton.classList.add('btn-primary');
            } else {
                loginButton.disabled = true;
                loginButton.classList.remove('btn-primary');
                loginButton.classList.add('btn-secondary');
            }
        }
    
        emailInput.addEventListener('input', checkInputs);
        passwordInput.addEventListener('input', checkInputs);
    </script>
</body>

</html>