<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $header }} | {{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}"></script>
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ $header }}
                        </h2>
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="overflow-hidden sm:rounded-lg">
                        @if(session('create'))
                            <div class="alert alert-success text-center">{{ Emoji::checkMark() }} {{ session('create') }}</div>
                        @elseif(session('update'))
                            <div class="alert alert-success text-center">{{ Emoji::checkMark() }} {{ session('update') }}</div>
                        @elseif(session('delete'))
                            <div class="alert alert-success text-center">{{ Emoji::checkMark() }} {{ session('delete') }}</div>
                        @elseif(session('success'))
                            <div class="alert alert-success text-center">{{ Emoji::checkMark() }} {{ session('success') }}</div>
                        @elseif(session('danger'))
                            <div class="alert alert-danger text-center">{{ Emoji::crossMark() }} {{ session('danger') }}</div>
                        @endif
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        @stack('modals')

        @livewireScripts
        {{ $js ?? "" }}
        @include('layouts.deleteModal')
    </body>
</html>
