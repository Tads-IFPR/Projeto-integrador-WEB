@extends('layouts.custom-guest')

@section('content')
<form method="POST" action="{{ route('register') }}" id="main-form">
    @csrf

    <div class="d-flex flex-column align-items-center justify-content-between w-100 h-100 py-5 inner-div">
        <h1>Sing Up</h1>
        <div class="d-flex flex-column align-items-center justify-content-center w-100">
            <div class="login-div-input">
                <x-input id="name"
                    class="d-block mt-1 w-100"
                    type="text"
                    name="name"
                    placeholder="Name"
                    :value="old('name')"
                    required
                    autofocus
                    autocomplete="username" />
        
                <x-input-error :messages="$errors->get('name')" />
            </div>

            <div class="mt-4 login-div-input">
                <x-input id="email"
                    class="d-block mt-1 w-100"
                    type="email"
                    name="email"
                    placeholder="E-mail"
                    required 
                    autocomplete="current-email" />
        
                <x-input-error :messages="$errors->get('email')" />
            </div>
        
            <div class="mt-4 login-div-input">
                <x-input id="password"
                    class="d-block mt-1 w-100"
                    type="password"
                    name="password"
                    placeholder="Password"
                    required 
                    autocomplete="new-password" />
        
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <div class="mt-4 login-div-input">
                <x-input id="password_confirmation"
                    class="d-block mt-1 w-100"
                    type="password"
                    name="password_confirmation"
                    placeholder="Confirm password"
                    required 
                    autocomplete="new-password" />
        
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>
            
            <div class="d-flex justify-content-end mt-1 login-div-input">
                <a class="link" href="{{ route('login') }}">
                    Already registered?
                </a>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-3 login-div-input">
            <x-button class="ms-3 px-4 py-1" id="login">
                {{ __('REGISTER') }}
            </x-button>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />
    </div>
</form>
@endsection

@push('styles')
    <style>
        .login-div-input {
            width: 70%;
        }

        #login {
            font-size: 1.2rem;
            font-weight: bolder;
            transform: scale(1, 1.1);
        }

        .link {
            color: var(--primary);
            font-size: .7rem;
            font-weight: bold;
            text-decoration: none;
            transition: color 150ms ease-out;
        }

        #remember {
            font-size: .7rem;
            font-weight: bold;
            color: var(--primary);
        }

        .link:hover {
            color: var(--secondary);
        }

        body {
            background-image: url("/imgs/bg-user.png");
            background-size: auto, 100%;
            background-repeat: no-repeat;
        }

        h1 {
            color: var(--primary);
            font-size: 3.5rem;
            font-weight: bolder;
            display: flex;
            justify-content: center;
            align-items: center;
            transform: scale(1, 1.1);
            -webkit-transform: scale(1, 1.1);
            -moz-transform: scale(1, 1.1);
            -ms-transform: scale(1, 1.1);
            -o-transform: scale(1, 1.1);
        }

        .inner-div {
            min-height: 80vh;
        }

        #main-form {
            width: 40vw;
            background-color: var(--dark-gray);
            box-shadow: var(--gray) -4px 4px 4px;
            border-radius: 1rem;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%)
        }

        @media screen and (max-width: 1200px) {
            #main-form {
                width: 60vw;
            }

            .inner-div {
                min-height: 50vh;
            }
        }

        @media screen and (max-width: 700px) {
            #main-form {
                width: 80vw;
            }
        }
    </style>
@endpush