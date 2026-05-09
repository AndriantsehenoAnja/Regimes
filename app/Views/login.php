<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Comme J'aime</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            max-width: 450px;
            width: 100%;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card {
            background: white;
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .logo-icon svg {
            width: 32px;
            height: 32px;
            stroke: white;
            fill: none;
            stroke-width: 2;
        }

        .logo h2 {
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .logo p {
            color: #6b7280;
            font-size: 14px;
            margin-top: 8px;
        }

        /* Alertes */
        .alert-error {
            background: #fee2e2;
            border-left: 4px solid #ef4444;
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #991b1b;
            font-size: 14px;
            animation: shake 0.3s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .alert-icon {
            font-size: 20px;
        }

        /* Form group */
        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            font-size: 18px;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            cursor: pointer;
            font-size: 18px;
            user-select: none;
        }

        /* Options */
        .login-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            font-size: 13px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            cursor: pointer;
            gap: 8px;
            color: #6b7280;
        }

        .checkbox-label input {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: #667eea;
        }

        .forgot-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #764ba2;
        }

        /* Bouton */
        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 14px 24px;
            font-size: 16px;
            font-weight: 700;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 24px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Séparateur */
        .divider {
            text-align: center;
            position: relative;
            margin-bottom: 24px;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            background: white;
            padding: 0 16px;
            position: relative;
            color: #9ca3af;
            font-size: 13px;
        }

        /* Lien inscription */
        .signup-link {
            text-align: center;
        }

        .signup-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .signup-link a:hover {
            color: #764ba2;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card {
                padding: 32px 24px;
            }
            
            .logo h2 {
                font-size: 24px;
            }
            
            .form-control {
                padding: 12px 16px 12px 44px;
                font-size: 14px;
            }
        }

        /* Animation chargement */
        .btn-login.loading {
            position: relative;
            color: transparent;
        }

        .btn-login.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid white;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo">
                <div class="logo-icon">
                    <svg viewBox="0 0 24 24" width="32" height="32">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                </div>
                <h2>Comme J'aime</h2>
                <p>Connectez-vous à votre compte</p>
            </div>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert-error">
                    <span class="alert-icon">⚠️</span>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert-success" style="background: #d1fae5; border-left-color: #10b981; color: #065f46;">
                    <span class="alert-icon">✅</span>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('/authenticate') ?>" method="POST" id="loginForm">
                <?= csrf_field() ?>
                
                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <div class="input-group">
                        <span class="input-icon">📧</span>
                        <input type="email" id="email" name="email" class="form-control" 
                               placeholder="jean.dupont@email.com" required autocomplete="email">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-icon">🔒</span>
                        <input type="password" id="password" name="password" class="form-control" 
                               placeholder="••••••••" required autocomplete="current-password">
                        <span class="password-toggle" onclick="togglePassword()">👁️</span>
                    </div>
                </div>

                <div class="login-options">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember" id="remember">
                        <span>Se souvenir de moi</span>
                    </label>
                    <a href="#" class="forgot-link">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="btn-login" id="loginBtn">
                    Se connecter
                </button>

                <div class="divider">
                    <span>ou</span>
                </div>

                <div class="signup-link">
                    <a href="<?= base_url('inscription1') ?>">
                        Créer un nouveau compte
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleBtn = document.querySelector('.password-toggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleBtn.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleBtn.textContent = '👁️';
            }
        }

        // Animation de chargement lors de la soumission
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('loginBtn');
            btn.classList.add('loading');
            btn.disabled = true;
        });

        // Validation basique du formulaire
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if (!email || !password) {
                e.preventDefault();
                alert('Veuillez remplir tous les champs');
                const btn = document.getElementById('loginBtn');
                btn.classList.remove('loading');
                btn.disabled = false;
            }
        });

        // Animation au focus des champs
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.01)';
            });
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>