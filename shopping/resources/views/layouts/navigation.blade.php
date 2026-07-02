<div class="bg-white border-bottom py-3 px-4 shadow-sm">
    <div class="d-flex align-items-center justify-content-between">
        <!-- Logo -->
        <div class="mb-3 mb-md-0">
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center">
                <i class="fa-solid fa-bag-shopping fa-xl text-primary me-2"></i>
                <span class="fw-bold text-dark">Shopping Lists</span>
            </a>
        </div>

        <!-- Authenticated Menu -->
        @auth
        <div class="d-flex align-items-center">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary me-2">
                <i class="fa-solid fa-house me-1"></i>Dashboard
            </a>
            <a href="{{ route('shopping-lists.index') }}" class="btn btn-outline-secondary me-2">
                <i class="fa-solid fa-clipboard-list me-1"></i>Lists
            </a>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary me-2">
                <i class="fa-solid fa-box me-1"></i>Products
            </a>
        </div>

        <!-- User Dropdown -->
        <div class="dropdown">
            <button class="btn btn-link text-decoration-none p-0" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-circle-user me-1"></i>
                {{ session()->get('user')['name'] ?? session()->get('user')['email'] ?? 'User' }}
                <i class="fa-solid fa-chevron-down ms-2"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="fa-solid fa-user me-2"></i>Profile
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fa-solid fa-sign-out-alt me-2"></i>Log Out
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        @else
        <!-- Guest Links -->
        <div class="d-flex align-items-center">
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                <i class="fa-solid fa-box me-1"></i>Browse
            </a>
            <a href="{{ route('shopping-list.create') }}" class="btn btn-success">
                <i class="fa-solid fa-plus me-1"></i>New List
            </a>
            @if(route('register'))
            <a href="{{ route('register') }}" class="btn btn-outline-primary">Sign Up</a>
            @endif
            @if(route('login'))
            <a href="{{ route('login') }}" class="btn btn-outline-primary">Log In</a>
            @endif
        </div>
        @endauth
    </div>
</div>
