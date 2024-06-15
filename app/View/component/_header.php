<nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">E-commerce</a>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active d-flex align-items-center gap-2" aria-current="page" href="/cart">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-bag-fill" viewBox="0 0 16 16">
                        <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4z"/>
                    </svg>
                    <?= (isset($_SESSION['cart'])) ? count($_SESSION['cart']) : 0; ?>
                </a>
            </li>

            <?php if (isset($_SESSION['user']['id'])): ?>
                <div class="dropdown dropdown-profile">
                    <button class="btn btn-outline-white dropdown-toggle rounded-1 text-muted" type="button"
                            id="dropdown-menu-profile" data-bs-toggle="dropdown" aria-expanded="false">
                        <span><?= $_SESSION['user']['email'] ?></span>
                    </button>
                    <ul class="dropdown-menu rounded-1" aria-labelledby="dropdown-menu-profile">
                        <li>
                            <a class="dropdown-item" href="/orders">Orders</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/logout">Logout</a>
                        </li>
                    </ul>
                </div>
            <?php else: ?>
                <ul class="d-flex gap-2 nav">
                    <li class="nav-item">
                        <a href="/login" class="btn btn-primary">Sign in</a>
                    </li>
                    <li class="nav-item">
                        <a href="/register" class="btn btn-outline-secondary">Register</a>
                    </li>
                </ul>
            <?php endif; ?>
        </ul>
    </div>
</nav>
