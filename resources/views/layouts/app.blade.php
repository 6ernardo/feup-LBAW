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
                <div>
                    <h1><a href="{{ url('/feed') }}">UPConnect</a></h1>
                    <span class="tooltip">(?)<span class="tooltiptext">Return to the Main Page at any time by clicking UPConnect</span></span>
                </div>
                @if (Auth::check())
                    <div>
                        <a class="button" href="{{ url('/logout') }}"> Logout </a> 
                        <a href="{{ url('/user/'.Auth::user()->user_id) }}"> <span>{{ Auth::user()->name }}</span> </a>
                        <span class="tooltip">(?)<span class="tooltiptext">You are logged in! Logout or click on your username to see your profile!</span></span>
                    </div>
                @elseif(request()->route()->getName() != 'login' &&
                        request()->route()->getName() != 'register')
                	<div> 
                        <a class="button" href="{{ url('/login') }}"> Login </a>
                	    <a class="button" href="{{ url('/register') }}"> Register </a>
                        <span class="tooltip">(?)<span class="tooltiptext">You are not logged in! Login or Register to make posts and follow accounts!</span></span>
                    </div>
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
