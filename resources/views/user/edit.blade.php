@extends('layouts.app')
@section('content')
    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data" id="main-form">
        @method('PUT')
        @csrf
        <x-input type="text" name="name" placeholder="Name" class="w-100" value="{{$user->name}}" />

        <x-input type="email" name="email" placeholder="Email" class="mt-3 w-100" value="{{$user->email}}" />

        <div class="d-flex justify-content-center">
            <x-button type="submit" id="submit" class="px-4 py-1 bolder mt-3">Save</x-button>
        </div>
    </form>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection

@push('styles')
<style>
    #submit {
        width: fit-content;
    }

    #main-form {
        width: 30vw;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translateX(-50%) translateY(-50%);
    }
</style>
@endpush
