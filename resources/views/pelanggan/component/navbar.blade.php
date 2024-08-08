<nav class="navbar navbar-dark navbar-expand-lg" style="background-color: #A67B5B">
    <div class="container">
        <a class="navbar-brand" href="#">
            <span class="brand-part1">Neko</span><span class="brand-part2">Neko</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end gap-4" id="navbarSupportedContent">
            <ul class="navbar-nav gap-4 align-items-center">
                <li class="nav-item">
                    <a class="nav-link {{ Request::path() == '/' ? 'active' : '' }}" aria-current="page" href="/">Home / Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::path() == 'contact' ? 'active' : '' }}" href="/contact">Contact Us</a>
                </li>
                @auth('user')
                    <div class="select" tabindex="0" role="button">
                        <div class="text-links">
                            <div class="d-flex gap-2 align-items-center">
                                <img src="{{ asset('assets/images/' . Auth::guard('user')->user()->foto) }}" class="rounded-circle" style="width: 50px;" alt="">
                                <div class="d-flex flex-column text-white">
                                    <p class="m-0" style="font-weight: 700; font-size:14px;">{{ Auth::guard('user')->user()->name }}</p>
                                    <p class="m-0" style="font-size:12px">{{ Auth::guard('user')->user()->email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="links-login text-white" id="links-login">
                            <a href="logout_pelanggan" style="text-decoration: none" role="button" tabindex="0">Keluar</a>
                        </div>
                    </div>
                @else
                    <li class="nav-item">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Login | Register
                        </button>
                    </li>
                @endauth
                <li class="nav-item">
                    <div class="notif">
                        <a href="/transaksi" class="fs-5 nav-link {{ Request::path() == 'transaksi' ? 'active' : '' }}">
                            <i class="fa fa-bag-shopping"></i> <span style="font-size: 0.8em;">Cart</span>
                        </a>
                        @if (Auth::guard('user')->check() && $countCart)
                            <div class="circle">{{ $countCart }}</div>
                        @endif
                    </div>
                </li>
                
            </ul>
        </div>
    </div>
</nav>

<script>
    $(".text-links").click(function(e) {
        e.preventDefault();
        var $linksLogin = $("#links-login");
        if ($linksLogin.hasClass("activeLogin")) {
            $linksLogin.removeClass("activeLogin");
        } else {
            $linksLogin.addClass("activeLogin");
        }
    });
</script>
