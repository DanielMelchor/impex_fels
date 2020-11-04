<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('css')

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/index.css') }}">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

</head>
<body  data-spy="scroll" data-target="#navbar" data-offset="57">
    <nav id="header" class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
              
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
              <ul class="navbar-nav ml-auto">
                <!--Comprobamos si el status esta a true y existe más de un lenguaje-->
                @if (config('locale.status') && count(config('locale.languages')) > 1)
                    <div class="top-right links">
                        @foreach (array_keys(config('locale.languages')) as $lang)
                            @if ($lang != App::getLocale())
                                <a href="{!! route('lang.swap', $lang) !!}">
                                        {!! $lang !!} <small>{!! $lang !!}</small>
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
              </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        <div class="row">
            <div class="col-md-12" style="text-align: center;">
                <img src="{{ asset('assets/logos/logo-impex-blue.png') }}" alt="Grupo Amad logo">
            </div>
        </div>
        <hr>
        @yield('content')
    </main>
</body>
@yield('js')
</html>
