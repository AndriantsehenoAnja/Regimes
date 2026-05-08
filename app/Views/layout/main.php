<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title><?= $this->renderSection('title') ?></title>

    <link rel="stylesheet" href="<?= base_url('/style/layout-main.css') ?>">
</head>

<body>

    <!-- ── Navbar ───────────────────────────────────────── -->
    <nav class="navbar">
        <!-- Logo -->
        <div class="navbar-left">
            <a href="<?= base_url('') ?>" class="navbar-brand">

                <div class="logo-icon">
                    <svg viewBox="0 0 24 24" width="18" height="18">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                </div>

                <div class="brand-name">
                    Comme J'aime
                </div>

            </a>
        </div>

        <!-- Navigation -->
        <div class="navbar-center">

            <a href="<?= base_url('') ?>"
               class="nav-item <?= (uri_string() == '') ? 'active' : '' ?>">
                
                <svg viewBox="0 0 24 24">
                    <rect width="7" height="9" x="3" y="3" rx="1"/>
                    <rect width="7" height="5" x="14" y="3" rx="1"/>
                    <rect width="7" height="9" x="14" y="12" rx="1"/>
                    <rect width="7" height="5" x="3" y="16" rx="1"/>
                </svg>

                Accueil
            </a>

            <a href="<?= base_url('') ?>"
               class="nav-item <?= (uri_string() == 'programme') ? 'active' : '' ?>">

                <svg viewBox="0 0 24 24">
                    <line x1="8" y1="6" x2="21" y2="6"/>
                    <line x1="8" y1="12" x2="21" y2="12"/>
                    <line x1="8" y1="18" x2="21" y2="18"/>
                    <line x1="3" y1="6" x2="3.01" y2="6"/>
                    <line x1="3" y1="12" x2="3.01" y2="12"/>
                    <line x1="3" y1="18" x2="3.01" y2="18"/>
                </svg>

                Programme de régime
            </a>

            <a href="<?= base_url('/code/form') ?>"
               class="nav-item <?= (uri_string() == 'code') ? 'active' : '' ?>">

                <svg viewBox="0 0 24 24">
                    <line x1="8" y1="6" x2="21" y2="6"/>
                    <line x1="8" y1="12" x2="21" y2="12"/>
                    <line x1="8" y1="18" x2="21" y2="18"/>
                    <line x1="3" y1="6" x2="3.01" y2="6"/>
                    <line x1="3" y1="12" x2="3.01" y2="12"/>
                    <line x1="3" y1="18" x2="3.01" y2="18"/>
                </svg>

                Code
            </a>

        </div>
        <!-- End Navigation -->

        <!-- User -->
        <a href="<?= base_url('gold/form') ?>">Option Gold</a>
        <div class="navbar-right">

            <a href="<?= base_url('login') ?>" class="user-row">

                <div class="avatar">
                    J
                </div>

                <div class="user-info">
                    <div class="name">Test</div>
                    <div class="role">Admin</div>
                </div>


            </a>

        </div>

    </nav>

    <!-- ── Main Content ────────────────────────────────── -->
    <main class="main-content">
        <?= $this->renderSection('content') ?>
    </main>

</body>
</html>