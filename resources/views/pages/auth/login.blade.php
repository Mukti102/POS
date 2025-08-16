<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <meta name="description" content="POS - Bootstrap Admin Template" />
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects" />
    <meta name="author" content="Dreamguys - Bootstrap Admin Template" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Login - {{setting('site_name')}}</title>

    <link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.jpg" />

    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />

    <link rel="stylesheet" href="/assets/plugins/fontawesome/css/fontawesome.min.css" />
    <link rel="stylesheet" href="/assets/plugins/fontawesome/css/all.min.css" />

    <link rel="stylesheet" href="/assets/css/style.css" />
</head>

<body class="account-page">
    <div class="main-wrapper">
        <form action="{{ route('login') }}" method="POST" class="account-content">
            @csrf
            <div class="login-wrapper">
                <div class="login-content">
                    <div class="login-userset">
                        <div class="login-logo">
                            <img src="{{ asset('storage/' . setting('logo')) }}" alt="img" />
                        </div>
                        <div class="login-userheading">
                            <h3>Sign In</h3>
                            <h4>Please login to your account</h4>
                        </div>
                        <div class="form-login">
                            <label>Email</label>
                            <div class="form-addons">
                                <input type="text" name="email" placeholder="Enter your email address" />
                                <img src="/assets/img/icons/mail.svg" alt="img" />
                            </div>
                        </div>
                        <div class="form-login">
                            <label>Password</label>
                            <div class="pass-group">
                                <input type="password" class="pass-input" name="password"
                                    placeholder="Enter your password" />
                                <span class="fas toggle-password fa-eye-slash"></span>
                            </div>
                        </div>
                        <div class="d-flex gap-2" style="align-items: center">
                           <input type="checkbox" name="remember" style="width: 15px">
                           <span class="fs-7">Remember Me</span>
                        </div>
                        <div class="form-login">
                            <button type="submit" class="btn btn-login" href="index.html">Sign In</button>
                        </div>
                    </div>
                </div>
                <div class="login-img">
                    <img src="/assets/img/login.jpg" alt="img" />
                </div>
            </div>
        </form>
    </div>

    <script src="/assets/js/jquery-3.6.0.min.js"></script>

    <script src="/assets/js/feather.min.js"></script>

    <script src="/assets/js/bootstrap.bundle.min.js"></script>

    <script src="/assets/js/script.js"></script>
</body>

</html>
