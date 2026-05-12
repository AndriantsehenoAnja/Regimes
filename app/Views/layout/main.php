<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title><?= $this->renderSection('title') ?></title>

    <!-- Stylesheet - CSS Moderne (SCSS compilé) -->
    <link rel="stylesheet" href="<?= base_url('/style/main.css') ?>">
</head>

<body>

    <!-- ── Navbar ───────────────────────────────────────── -->
    <nav class="navbar">

        <!-- Logo -->
        <div class="navbar-left">

            <a href="<?= base_url('/') ?>" class="navbar-brand">

                <div class="logo-icon">
                    <svg viewBox="0 0 24 24" width="18" height="18">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                </div>

                <div class="brand-name">
                    Gomme Ton Ventre
                </div>

            </a>

        </div>

        <!-- Navigation -->
        <div class="navbar-center">

            <!-- Accueil -->
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

            <?php if(!session()->get("isAdmin")): ?>
<!-- Programmes -->
            <a href="<?= base_url('/programme1') ?>"
               class="nav-item <?= (uri_string() == 'programme1') ? 'active' : '' ?>">

                <svg viewBox="0 0 24 24">
                    <line x1="8" y1="6" x2="21" y2="6"/>
                    <line x1="8" y1="12" x2="21" y2="12"/>
                    <line x1="8" y1="18" x2="21" y2="18"/>
                    <line x1="3" y1="6" x2="3.01" y2="6"/>
                    <line x1="3" y1="12" x2="3.01" y2="12"/>
                    <line x1="3" y1="18" x2="3.01" y2="18"/>
                </svg>

                Programmes de regimes
            </a>
<?php endif; ?>

            <?php if(!session()->get("isAdmin")): ?>
<!-- Code -->
            <a href="<?= base_url('code/form') ?>"
               class="nav-item <?= (uri_string() == 'code/form') ? 'active' : '' ?>">

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
<?php endif; ?>

            <?php if(!session()->get("isAdmin")): ?>
<!-- Mes Achats -->
            <a href="<?= base_url('mes-regimes') ?>"
               class="nav-item <?= (uri_string() == 'mes-regimes') ? 'active' : '' ?>">
                <svg viewBox="0 0 24 24">
                    <rect width="20" height="14" x="2" y="5" rx="2" ry="2"></rect>
                    <line x1="2" y1="10" x2="22" y2="10"></line>
                </svg>
                Mes Achats
            </a>
            <?php endif; ?>
            
            <a href="<?= base_url('/activite') ?>"
               class="nav-item <?= (uri_string() == 'activite') ? 'active' : '' ?>">

                <svg viewBox="0 0 24 24">
                    <line x1="8" y1="6" x2="21" y2="6"/>
                    <line x1="8" y1="12" x2="21" y2="12"/>
                    <line x1="8" y1="18" x2="21" y2="18"/>
                    <line x1="3" y1="6" x2="3.01" y2="6"/>
                    <line x1="3" y1="12" x2="3.01" y2="12"/>
                    <line x1="3" y1="18" x2="3.01" y2="18"/>
                </svg>

                Activite 
            </a>
            <a href="<?= base_url('/regimes') ?>"
               class="nav-item <?= (uri_string() == 'regimes') ? 'active' : '' ?>">

                <svg viewBox="0 0 24 24">
                    <line x1="8" y1="6" x2="21" y2="6"/>
                    <line x1="8" y1="12" x2="21" y2="12"/>
                    <line x1="8" y1="18" x2="21" y2="18"/>
                    <line x1="3" y1="6" x2="3.01" y2="6"/>
                    <line x1="3" y1="12" x2="3.01" y2="12"/>
                    <line x1="3" y1="18" x2="3.01" y2="18"/>
                </svg>

                Nos regimes 
            </a>

            <?php if(session()->get('isAdmin')): ?>
            <!-- Dashboard Admin -->
            <a href="<?= base_url('admin/dashboard') ?>"
               class="nav-item <?= (uri_string() == 'admin/dashboard') ? 'active' : '' ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                Tableau de bord
            </a>

            <!-- Validation Codes (Admin Only) -->
            <a href="<?= base_url('codes/validation') ?>"
               class="nav-item <?= (uri_string() == 'codes/validation') ? 'active' : '' ?>">
                <svg viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
                Validation Codes
            </a>
            <a href="<?= base_url('codes/create') ?>"
               class="nav-item <?= (uri_string() == 'codes/create') ? 'active' : '' ?>">
                <svg viewBox="0 0 24 24">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Créer un Code
            </a>
            <?php endif; ?>


            <?php if(!session()->get("isAdmin")): ?>
<!-- Gold -->
            <a href="<?= base_url('gold/form') ?>"
               class="nav-item <?= (uri_string() == 'gold/form') ? 'active' : '' ?>">

                <svg viewBox="0 0 24 24">
                    <line x1="12" y1="2" x2="15" y2="8"/>
                    <line x1="15" y1="8" x2="22" y2="9"/>
                    <line x1="22" y1="9" x2="17" y2="14"/>
                    <line x1="17" y1="14" x2="18" y2="21"/>
                    <line x1="18" y1="21" x2="12" y2="18"/>
                    <line x1="12" y1="18" x2="6" y2="21"/>
                    <line x1="6" y1="21" x2="7" y2="14"/>
                    <line x1="7" y1="14" x2="2" y2="9"/>
                    <line x1="2" y1="9" x2="9" y2="8"/>
                    <line x1="9" y1="8" x2="12" y2="2"/>
                </svg>

                Gold
            </a>
<?php endif; ?>

        </div>
        <!-- End Navigation -->


        <!-- User -->
        <div class="navbar-right">
            <?php if(session()->has('user')){ ?>
                <?php $user = session()->get('user'); ?>
                <?php if(isset($user)){ ?>
                
                <?php if(!session()->get('isAdmin')): ?>
                <?php if(!session()->get("isAdmin")): ?>
<?php if(!session()->get("isAdmin")): ?>
<!-- Solde -->
                <div class="nav-item">
                    Solde :
                    <?= $user['solde'] ?> Ar
                </div>
<?php endif; ?>
<?php endif; ?>
                <?php endif; ?>
                
                <!-- User -->
                <a href="<?= base_url('/profile') ?>" class="user-row">
                    
                    <div class="avatar">
                        <?= strtoupper($user['nom'][0]) ?>
                    </div>

                    <div class="user-info">
                        <div class="name">
                            <?= $user['nom'] ?>
                        </div>
                        
                        <?php if($user['is_gold']){ ?>
                        <div class="role">
                            Gold
                        </div>
                        <?php } ?>
                        
                    </div>
                    
                </a>

                <!-- Logout -->
                <a href="<?= base_url('logout') ?>"
                class="nav-item">
                
                Logout
                
                </a>
                
                <?php }} else { ?>

                <!-- Login -->
                <a href="<?= base_url('login') ?>"
                   class="nav-item">

                    Login

                </a>

                <!-- Register -->
                <a href="<?= base_url('inscription1') ?>"
                   class="nav-item">

                    Sign Up

                </a>

            <?php } ?>

        </div>

    </nav>

    <!-- ── Main Content ────────────────────────────────── -->
    <main class="main-content">
        <?= $this->renderSection('content') ?>
    </main>

</body>
</html>