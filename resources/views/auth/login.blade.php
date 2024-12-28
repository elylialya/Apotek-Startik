<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <title>Login</title>
   
</head>
<body>

                    <form class="space-y-4 md:space-y-6" method="post" action="{{ route('login.action') }}">
                        @csrf
                        <div class="Login">
      <h2>LOGIN</h2>

            <!--input-->
            <div class="input-group">
                <input type="email" name="email" id="email" required=""><span>Email</span> 
            </div>
            <div class="input-group">
                <input type="password" name="password" id="password" required=""><span>Password</span>
            </div>
            <div class="Forgot">
                <a>Belum Memiliki akun?</a> <span><a href="{{ route('register') }}">Daftar Sekarang</a>
            </div>

            <!--button-->
                <div class="input-group">
                    <td><a href="landingpage1.html"><button type="submit">Login</button></a>
                    <td><a href="{{ route('register') }}"><button type="button">Register</button></a>
                </div>
            </div>
            </div>
            </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>