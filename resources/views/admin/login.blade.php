<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #000; /* Black background */
            color: #fff;
            font-family: Arial, sans-serif;
        }
        .login-container {
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }
        .left-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .left-section img {
            max-width: 300px;
            height: auto;
        }
        .right-section {
            flex: 1;
            padding: 20px;
        }
        .login-form {
            max-width: 400px;
            margin: 0 auto;
        }
        .login-form h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #fff;
            border-radius: 5px;
            background: transparent;
            color: #fff;
        }
        .login-form button {
            width: 100%;
            padding: 10px;
            background-color: red;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-form button:hover {
            background-color: darkred;
        }
        .terms {
            text-align: center;
            margin-top: 10px;
        }
        .terms a {
            color: #ff6347;
            text-decoration: none;
        }
        .terms a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="left-section">
            <img src="{{ asset('img/logo.png') }}" alt="Logo"> <!-- Replace with your logo -->
        </div>
        <div class="right-section">
            <form class="login-form" action="{{ route('login') }}" method="POST">
                @csrf
                <h1>Login</h1>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
                <div class="terms">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label><br>
                    <a href="#">I agree to Terms of Service</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
