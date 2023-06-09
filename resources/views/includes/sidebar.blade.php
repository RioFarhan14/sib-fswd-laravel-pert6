<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            @if (Auth::user()->role->name == 'Admin' || Auth::user()->role->name == 'Staff')
            <div class="sb-sidenav-menu-heading">Core</div>
            <a class="nav-link" href="{{ asset('Dasboard') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>
            @endif
            @if (Auth::user()->role->name == 'Admin')
            <div class="sb-sidenav-menu-heading">Content</div>
            <a class="nav-link" href="{{ route('slider.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-image"></i></div>
                Slider
            </a>
            @endif

            <div class="sb-sidenav-menu-heading">Management</div>
            @if (Auth::user()->role->name == 'Admin' || Auth::user()->role->name == 'Staff')
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                Product
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('brand.index') }}">Brand</a>
                    <a class="nav-link" href="{{ route('Category.index') }}">Category</a>
                    <a class="nav-link" href="{{ route('Product.index') }}">Product</a>
                </nav>
            </div>
            @endif

            @if (Auth::user()->role->name == 'Admin')
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                aria-expanded="false" aria-controls="collapsePages">
                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                Users
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('Role.index') }}">Role</a>
                    <a class="nav-link" href="{{ route('User.index') }}">User</a>
                </nav>
            </div>
            @endif
            @if (Auth::user()->role->name == 'user')
            <a class="nav-link" href="{{ route('Product.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                Product
            </a>
            @endif
        </div>
    </div>
    <div class="sb-sidenav-footer" style="text-transform: uppercase">
        <div class="small">Logged in as:</div>
        {{ Auth::user()->name }} ({{ Auth::user()->role->name }})
    </div>
</nav>