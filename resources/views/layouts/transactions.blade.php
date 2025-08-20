<html>
    <head>
        <title>@yield('title')</title>
        <link rel="stylesheet" href="{{asset('css/style.css')}}" >
        <script src="https://code.jquery.com/jquery.min.js"></script>
    </head>
    <body>

            <header>
                <div class="container">
                    @section('header')
                    <div class="header-title">
                        家計簿アプリ
                    </div>
                    @show

                    @auth
                    <div class="header-right">
                        <a href="/transactions/logout">ログアウト</a>
                    </div>
                    @else
                    @endauth
                </div>
            </header>
        <div class="body_container">            
            @yield('content')            
        </div>
            <footer>
                @section('footer')
                    copyright 2025 ai0515
                    @show
            </footer>


            @if (session('success'))
                <div id="snackbar" class="snackbar" role="status">
                    {{ session('success') }}
                </div>

                <script>
                    window.addEventListener('DOMContentLoaded', () => 
                    {
                        const el = document.getElementById('snackbar');
                        if (!el) return;
                    
                        requestAnimationFrame(() => el.classList.add('show'));
                        
                        const hide = () => { 
                            el.classList.remove('show'); 
                            setTimeout(()=>el.remove(), 500); 
                        };

                        const t = setTimeout(hide, 3000);
                        el.addEventListener('click', 
                            () => { 
                                clearTimeout(t); 
                                hide(); 
                            });
                    });
                </script>
            @endif
    </body>
</html>
