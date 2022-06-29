<html>

<head>
    <title>Task App - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/css/app.css" rel="stylesheet">
    <script src="/js/app.js" defer></script>
</head>

<body class="{{ request()->route()->getName() }}">
    <nav class="navbar is-light" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="/">
                Task App
            </a>
            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false"
                data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>
        <div class="navbar-menu">
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        @section('navbar-item')
                            @foreach (['task.index' => 'Task list', 'task.create' => 'New Task', 'task.create_random' => 'Random Task'] as $name => $label)
                                <a @class([
                                    'navbar-item',
                                    'is-active' =>
                                        request()->route()->getName() === $name,
                                ]) href="{{ route($name) }}">{{ $label }}</a>
                            @endforeach
                        @show
                        @auth
                        <a class="'navbar-item'" href="{{ route('security.logout') }}">
                            Logout
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>
    @yield('content')

</body>

</html>
