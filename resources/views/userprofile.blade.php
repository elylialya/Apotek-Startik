<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/profile.css')}}">
    <title>Profil</title>
</head>
<body>
    <div class="text">
        <h1>User Profile</h1>
    </div>
               
<form method="POST" action="{{ route('user.profile.store') }}" enctype="multipart/form-data">

    @csrf
    
 <div class="container">
    <div class="profile">
 <label for="name" class="form-label">Foto</label>

<input id="profile_image" type="file" class="form-control @error('profile_image') is-invalid @enderror" name="profile_image" value="{{ old('profile_image') }}"  autocomplete="profile_image">

@error('avatar')
        <strong>{{ $message }}</strong>

    </span>

@enderror
</div>

<div class="foto">
<img src="profil_images/{{ auth()->user()->profile_image }}">
    
</div>
    <div class="content">
        <div class="input">
            <div class="nama">
        <label for="name" class="form-label">Nama:</label>

<input class="form-control" type="text" id="name" name="name" value="{{ auth()->user()->name }}" autofocus="" ><br>

@error('name')

    <span role="alert" class="text-danger">
        <strong>{{ $message }}</strong>

    </span>

@enderror
</div>

<div class="email">
<label for="email" class="form-label">Email:</label>

<input class="form-control" type="text" id="email" name="email" value="{{ auth()->user()->email }}" autofocus="" ><br>

@error('email')

    <span role="alert" class="text-danger">

        <strong>{{ $message }}</strong>

    </span>

@enderror
</div>


<div class="no">
<label for="phone" class="form-label">No Hp: </label>
<input class="form-control" type="text" id="phone" name="phone" value="{{ auth()->user()->phone }}" autofocus="" ><br>
@error('phone')

    <span role="alert" class="text-danger">
        <strong>{{ $message }}</strong>

    </span>

@enderror
</div>




<div class="alamat">
<label for="city" class="form-label">Alamat: </label>

<input class="form-control" type="text" id="address" name="address" value="{{ auth()->user()->address }}" autofocus="" ><br>

@error('address')

    <span role="alert" class="text-danger">

        <strong>{{ $message }}</strong>

    </span>

@enderror
</div>

<button type="submit" >
    {{ __('Upload Profile') }}
   
</button>
        </div>
    </div>
    </form>
    
    <div class="btn1">
	<a href="{{ route('home') }}"><button type="button" class="btn1">kembali</button></a>
	</div>
</body>
</html>