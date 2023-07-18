<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login From</title>
    <link rel="stylesheet" type="text/css" href="adminLogin/style.css"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto:900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
    
    <div class="container">

        <div class="img">
            <img src="adminLogin/logo.png" alt="" style="width: 150px;">
        </div>

        <div class="login-container">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h2>Welcome</h2>
                <div class="input-div one ">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        
                        <input type="email" class="input" id="email" name="email" placeholder="Email" required>
                    </div>
                </div>
                <!-- -->
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="input-div two">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div>
                       
                        <input type="password" class="input" id="password" placeholder="Password" name="password" required>
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <!--<a href="">Forgot Password?</a>-->
                <input type="submit" class="btn" value="Login">
            </form>
        </div>

    </div>
    <script type="text/javascript" src="adminLogin/main.js"></script>
</body>
</html>
