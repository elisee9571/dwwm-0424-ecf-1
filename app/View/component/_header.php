<nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">E-commerce</a>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/">Home</a>
            </li>

            <?php if (isset($_SESSION['user']['id'])): ?>
                <div class="dropdown dropdown-profile">
                    <button class="btn btn-outline-white dropdown-toggle rounded-1 text-muted" type="button"
                            id="dropdown-menu-profile" data-bs-toggle="dropdown" aria-expanded="false">
                        <span><?= $_SESSION['user']['email'] ?></span>
                    </button>
                    <ul class="dropdown-menu rounded-1" aria-labelledby="dropdown-menu-profile">
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
