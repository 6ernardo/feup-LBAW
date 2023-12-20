<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer>
        </script>
        <script type="text/javascript" src={{ url('js/search.js') }} defer> 
        </script>
    </head>
    <body>
        <main>
            <header>
                <h1><a href="{{ url('/feed') }}">UPConnect</a></h1>
                @if (Auth::check())
                    <a class="button" href="{{ url('/logout') }}"> Logout </a> 
                    <a href="{{ url('/user/'.Auth::user()->user_id) }}"> <span>{{ Auth::user()->name }}</span> </a>
                @elseif(request()->route()->getName() != 'login' &&
                        request()->route()->getName() != 'register')
                	<a class="button" href="{{ url('/login') }}"> Login </a>
                	<a class="button" href="{{ url('/register') }}"> Register </a>
                @endif
                @if (Auth::check() && Auth::user()->isAdmin())
                    <a class="button" href="{{ url('/admindashboard') }}">Admin Dashboard</a>
                @endif
                <a class="button" id="search_button" href="{{ url('/searchQuestionForm') }}"> Search </a>
            </header>
            <section id="content">
                @yield('content')
            </section>
        </main>
        <footer>
            <nav>
                <a href="{{ url('/tags') }}">Tags</a>
                <a href="{{ url('/aboutus') }}">About Us</a>
                <a href="{{ url('/mainfeatures') }}">Main Features</a>
                <a href="{{ url('/contacts') }}">Contacts Page</a>
            </nav>
        </footer>
    </body>
</html>
