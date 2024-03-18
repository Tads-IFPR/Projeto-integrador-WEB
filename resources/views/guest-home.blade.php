@extends('layouts.custom-guest')

@section('content')
    <nav class="d-flex justify-content-between px-4 py-2 align-items-center" id="navbar">
        <div>
            <a href="{{route('home')}}">TOJOJA</a>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <a href="{{route('login')}}">SING IN</a>
            <div class="pipe mx-2"></div>
            <a href="{{route('register')}}">SING UP</a>
        </div>
    </nav>
    <main class="px-3">
        <div class="d-flex justify-content-end h-70 mb-5">
            <div class="d-flex align-items-center justify-content-center flex-column w-80">
                <h1 class="text-effect mb-5">UPLOAD HERE<br>LISTEN EVERYWHERE</h1>
                <a href="{{route('register')}}" class="button-default px-3 py-1 cfs-1-5 bold fit-content">Create account</a>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-center flex-column w-80 ch110">
            <h2 style="font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 48;">
                BUILD WITH <span class="material-symbols-outlined cfs-3-5 green">favorite</span><br>TO COMMUNITY
            </h2>
            <p class="text-center bold mb-5">Open source project, that everyone<br>can contribute adn share</p>
            <a href="{{route('register')}}" class="button-default px-3 py-1 cfs-1-5 bold fit-content">Try Free</a>
        </div>
    </main>
    <footer>
        <nav class="d-flex justify-content-between px-4 py-2 align-items-center h-100">
            <div>
                <a href="{{route('home')}}">®TOJOJA - {{date('Y')}}</a>
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <a href="https://github.com/Tads-IFPR/Projeto-integrador-WEB" target="_blank">GITHUB</a>
                <div class="pipe mx-2"></div>
                <a href="#">ABOUT US</a>
            </div>
        </nav>
    </footer>
@endsection

@push('styles')
    <style>
        .cfs-3-5 {
            font-size: 3.5rem;
        }

        .cfs-1-5 {
            font-size: 1.5rem;
        }

        .green {
            color: var(--primary);
        }

        main {
            background-image: url('/imgs/guest-bg.png');
            background-size: 80vw;
            background-position-y: top 2rem;
            background-position-x: 5vw;
            background-repeat: no-repeat;
        }

        .fit-content {
            width: fit-content;
        }

        .h-70 {
            height: 70vh;
        }

        .ch110 {
            height: 110vh;
        }

        .h-80 {
            height: 80vh;
        }

        .w-80 {
            width: 80%;
        }

        p {
            font-size: 1.6rem;
        }

        h1,
        h2 {
            font-size: 4rem;
            font-weight: bold;
            text-align: center;
        }

        .pipe {
            height: 1.5rem;
            border-right: 3px solid var(--white) ;
            width: 1px;
        }

        #navbar {
            height: 3.75rem;
        }

        footer {
            height: 4rem;
        }

        nav {
            background: var(--dark-gray);
        }

        nav a {
            font-weight: 700;
            font-size: .75em;
        }

        nav > div {
            height: fit-content;
        }

        a {
            color: var(--white);
            text-decoration: none;
        }
    </style>
@endpush