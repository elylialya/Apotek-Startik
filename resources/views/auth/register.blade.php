<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{asset('css/register.css')}}">
</head>
<body>
    
          <form action="{{ route('register.save') }}" method="POST" class="space-y-4 md:space-y-6">
          @csrf
         <div class="Login">
        <h2>REGISTER</h2>
        <div class="input-group">
            <input type="text" name="name" id="name"  required=""><span>Username</span>
        </div>
        <div class="input-group">
            <input type="email" name="email" id="email" required=""><span>Email</span>
        </div>
        <div class="input-group">
            <input type="password" name="password" id="password" required=""><span>Password</span>
        </div>
        <div class="input-group">
            <input type="password" name="password_confirmation" id="password_confirmation" required=""><span>Konfirmasi Password</span>
        </div>
        <div>
            <div class="checkbox">
                <input type="checkbox" id="signupCheck" />
                <label for="signupCheck">Saya menerima semua<span> syarat & ketentuan</span></label>
            </div>

            <!--button-->
            <div class="input-group">
                <td><button type="submit">Sign up</button></td>
                <td><a href="{{ route('login') }}"><button type="button">login</button></a>
            </div>
        </div>
    </div>
    </div>
                    </form>
                </div>
            </div>
        </div>
</body>

</html>