document.addEventListener('DOMContentLoaded', function () {
    // Подключаем CSS
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = 'css/header.css';
    document.head.appendChild(link);

    // Добавляем HTML-код хедера
    const headerHTML = `
    <header>
        <div class="logo">
            <a href="index-es.html">
                <img src="images/logo.png" alt="Logotipo de IZIPAY" />
            </a>
        </div>

        <!-- Menú hamburguesa -->
        <div class="menu-toggle" aria-expanded="false">
            <div></div>
            <div></div>
            <div></div>
        </div>

        <!-- Menú móvil -->
        <nav class="mobile-menu" aria-hidden="true">
            <ul>
                <li class="dropdown">
                    <a href="#">Producto</a>
                    <ul class="dropdown-menu">
                        <li><a href="virtual-debit-card-es.html">Tarjeta de Débito Virtual</a></li>
                        <li><a href="physical-debit-card-es.html">Tarjeta de Débito Física</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Ayuda</a>
                    <ul class="dropdown-menu">
                        <li><a href="faq-es.html">Preguntas Frecuentes</a></li>
                        <li><a href="legal-documents-es.html">Documentos Legales</a></li>
                        <li><a href="terms-conditions-es.html">Términos y Condiciones</a></li>
                        <li><a href="privacy-policy-es.html">Política de Privacidad</a></li>
                        <li><a href="pricing-es.html">Precios</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Empresa</a>
                    <ul class="dropdown-menu">
                        <li><a href="about-us-es.html">Sobre Nosotros</a></li>
                        
                    </ul>
                </li>
            </ul>

            <!-- Botones de inicio de sesión para la versión móvil -->
            <div class="auth-links-mobile">
                <a href="login.php" class="btn login-btn">Iniciar Sesión</a>
                <a href="register.php" class="btn signup-btn">Registrarse</a>
            </div>

            <!-- Cambio de idioma en el menú móvil -->
            <div class="language-selector-mobile">
                <select id="language-switcher-mobile">
                    <option value="en">🇺🇸 EN</option>
                    <option value="nl">🇳🇱 NL</option>
                    <option value="fr">🇫🇷 FR</option>
                    <option value="it">🇮🇹 IT</option>
                    <option value="es" selected>🇪🇸 ES</option>
                    <option value="de">🇩🇪 DE</option>
                    <option value="zh">🇨🇳 中文</option>
                    <option value="ru">🇷🇺 RU</option>
                </select>
            </div>
            <style>@media (min-width: 768px) { 
                .language-selector-mobile {
                    display: none;
                }
            }
            </style>
        </nav>

        <!-- Enlaces de inicio de sesión en escritorio -->
        <div class="auth-container">
            <div class="auth-links">
                <a href="login.php">Iniciar Sesión</a> | <a href="register.php">Registrarse</a>
            </div>
            <div class="language-selector">
                <select id="language-switcher">
                    <option value="en">🇺🇸 EN</option>
                    <option value="nl">🇳🇱 NL</option>
                    <option value="fr">🇫🇷 FR</option>
                    <option value="it">🇮🇹 IT</option>
                    <option value="es" selected>🇪🇸 ES</option>
                    <option value="de">🇩🇪 DE</option>
                    <option value="zh">🇨🇳 中文</option>
                    <option value="ru">🇷🇺 RU</option>  
                </select>
            </div>
        </div>
    </header>
    `;

    document.body.insertAdjacentHTML('afterbegin', headerHTML);

    // Логика меню и переключения языков
    const menuToggle = document.querySelector('.menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');
    const languageSwitcherDesktop = document.getElementById("language-switcher");
    const languageSwitcherMobile = document.getElementById("language-switcher-mobile");

    function toggleMenu() {
        const isOpen = mobileMenu.classList.contains('active');
        mobileMenu.classList.toggle('active');
        menuToggle.setAttribute('aria-expanded', !isOpen);
        mobileMenu.setAttribute('aria-hidden', isOpen);
    }

    menuToggle.addEventListener('click', toggleMenu);

    function switchLanguage(event) {
        let selectedLanguage = event.target.value;
        let currentPage = window.location.pathname;

        // Определяем поддерживаемые языки
        const languageMap = ["ru", "nl", "fr", "it", "es", "de", "zh"];

        // Убираем текущий языковой суффикс, если он есть
        languageMap.forEach(lang => {
            currentPage = currentPage.replace(`-${lang}`, "");
        });

        // Добавляем новый язык, если он не английский
        let newPage = selectedLanguage === "en" ? currentPage : currentPage.replace(".html", `-${selectedLanguage}.html`);

        // Перенаправляем пользователя
        window.location.href = newPage;
    }

    languageSwitcherDesktop.addEventListener("change", switchLanguage);
    languageSwitcherMobile.addEventListener("change", switchLanguage);
});
