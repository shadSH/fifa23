<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TechnoBase Dashboard - Login page</title>
    <link rel="icon" href="{{asset('img/icon.png')}}" type="image/x-icon">
    <style>
        @font-face {
            font-family: regular;
            src: url({{asset('fonts/Regular.otf')}});
        }

        @font-face {
            font-family: light;
            src: url({{asset('fonts/Light.otf')}});
        }

        html,
        body {
            padding: 0;
            margin: 0;
            width: 100%;
            height: 100%;
            font-family: 'regular';
        }

        .container {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .imgContainer {
            width: 50%;
            height: 100%;
            display: flex;
            align-items: center;
            background: #1E2832;
            justify-content: center;
        }

        @media screen and (max-width: 992px) {
            .imgContainer {

                width: 0 !important;
                overflow: hidden;

            }

            .fromContainer {
                width: 100% !important;
            }
        }

        .imgContainer img {
            width: 380px;
        }

        .fromContainer {
            width: calc(50% - 100px);
            padding: 0 50px;
        }

        .fromContainer form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
            margin: auto;
        }

        .fromContainer form h1 {
            text-align: center;
            color: #1E2832;
            margin: 0;
            margin-bottom: 1rem;
        }

        .fromContainer form > div {
            display: grid;
            width: 100%;
        }

        .fromContainer form > div label, .invalid-feedback {
            font-size: 14px;
            padding-bottom: 5px;
            font-family: 'light';
        }

        .fromContainer form > div input {
            height: 30px;
            padding: 0 8px;
            margin: 0;
            font-size: 12px;
            border-radius: 2px;
            font-family: 'light';
            border: 1px solid #d9d9d9;
        }

        .fromContainer form > div input:focus {
            outline: none;
        }

        .fromContainer form button {
            width: 200px;
            height: 40px;
            margin: 0;
            padding: 0;
            border: none;
            color: #fff;
            border-radius: 2px;
            font-family: 'regular';
            background: #1E2832;
            margin-top: 1.5rem;
        }

        .note {
            text-align: center;
            font-size: 14px;
            margin-top: 2rem;
            margin-bottom: 3rem;
            color: #00000073;
        }

        .designAndDeveloped {
            text-align: center;
            font-size: 12px;
            color: #00000073;
            font-family: 'Light';
        }

        .designAndDeveloped a {
            text-decoration: none;
            font-family: 'Regular';
            color: #1E2832;
        }

        .pointer {
            cursor: pointer;
        }

    </style>
</head>

<body>
<div class="container">
    <div class="imgContainer">
        <img src="{{asset('img/techno-login.aeafeb5b.png')}}" alt="logo">
    </div>
    <div class="fromContainer">
        <form method="POST" action="{{ route('login') }}" class="user">
            {{ csrf_field() }}
            <h1 style="color: #2C3F7C">TechnoBase Dashboard </h1>
            <div>
                <label for="email">Email</label>
                <input id="email" type="email" value=""
                       class="form-control form-control-user @error('email') is-invalid @enderror" name="email"
                       required autocomplete="email" autofocus aria-describedby="emailHelp"
                       placeholder="{{ __('sentence.Email') }}">
                @error('email')
                <span class="invalid-feedback" style="color:red" role="alert">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="password">Password</label>
                <input id="password" type="password" value=""
                       class="form-control form-control-user @error('password') is-invalid @enderror" name="password"
                       required autocomplete="current-password" placeholder="{{ __('sentence.Password') }}">
                @error('password')
                <span class="invalid-feedback " style="color:red" role="alert">
                                    {{ $message }}
                                    </span>
                @enderror
            </div>

            <button type="submit" class="pointer">Login</button>
        </form>
    </div>
</div>
</body>

</html>
