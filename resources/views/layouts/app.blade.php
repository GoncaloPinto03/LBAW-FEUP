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
        <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.17.0/font/bootstrap-icons.css" rel="stylesheet">-->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
        <link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/sidebar.css') }}" rel="stylesheet">
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
        <link href="{{ url('css/article_home.css') }}" rel="stylesheet">
        <link href="{{ url('css/profile.css')}}" rel="stylesheet">
        <link href="{{ url('css/edit_profile.css')}}" rel="stylesheet">
        <link href="{{ url('css/admin_page.css') }}" rel="stylesheet">
        <link href="{{ url('css/footer.css') }}" rel="stylesheet">
        <link href="{{ url('css/about.css') }}" rel="stylesheet">
        <link href="{{ url('css/register.css') }}" rel="stylesheet">

        <!--<link href="{{ url('css/article_solo.css') }}" rel="stylesheet">-->

        

        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer>
        </script>
    </head>
    <body>
        <main>
            @yield('topbar')
            @yield('sidebar')
            <section id="content">
                @yield('content')
            </section>
            @yield('footer')

        </main>
    </body>
</html>