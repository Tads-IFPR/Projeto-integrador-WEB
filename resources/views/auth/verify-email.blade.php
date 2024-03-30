@extends('layouts.custom-guest')

@section('content')
<div id="main-form">
    <div class="d-flex flex-column align-items-center justify-content-around w-100 h-100 py-5 inner-div">
        <div>
            <h1 class="text-center">VERIFY EMAIL</h1>
            <p class="small-text">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </p>

            @if (session('status') == 'verification-link-sent')
                <p class="small-text" style="color: var(--secondary)">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </p>
            @endif
        </div>

        <div class="d-flex justify-content-evenly">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div class="d-flex align-items-center justify-content-center w-100">
                    <x-button class="ms-3 px-4 py-1 main-buttons">
                        {{ __('RESEND E-MAIL') }}
                    </x-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-button class="ms-3 px-4 py-1 main-buttons h-100">
                    {{ __('LOG OUT') }}
                </x-button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <style>
        .small-text {
            font-size: .8rem;
            padding: 1rem 2rem;
            padding-bottom: 0;
            margin-bottom: 0;
            text-align: center;
        }

        .login-div-input {
            width: 70%;
        }

        .main-buttons {
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
            font-size: 3rem !important;
            font-weight: bolder !important;
            display: flex;
            justify-content: center;
            align-items: center;
            transform: scale(1, 1.1) !important;
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
                min-height: 50vh;
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
