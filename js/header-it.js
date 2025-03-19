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
            <a href="index-it.html">
                <img src="images/logo.png" alt="Logo IZIPAY" />
            </a>
        </div>

        <!-- Menu hamburger -->
        <div class="menu-toggle" aria-expanded="false">
            <div></div>
            <div></div>
            <div></div>
        </div>

        <!-- Menu mobile -->
        <nav class="mobile-menu" aria-hidden="true">
            <ul>
                <li class="dropdown">
                    <a href="#">Prodotto</a>
                    <ul class="dropdown-menu">
                        <li><a href="virtual-debit-card-it.html">Carta di Debito Virtuale</a></li>
                        <li><a href="physical-debit-card-it.html">Carta di Debito Fisica</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Aiuto</a>
                    <ul class="dropdown-menu">
                        <li><a href="faq-it.html">FAQ</a></li>
                        <li><a href="legal-documents-it.html">Documenti Legali</a></li>
                        <li><a href="terms-conditions-it.html">Termini & Condizioni</a></li>
                        <li><a href="privacy-policy-it.html">Politica sulla Privacy</a></li>
                        <li><a href="pricing-it.html">Prezzi</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Azienda</a>
                    <ul class="dropdown-menu">
                        <li><a href="about-us-it.html">Chi Siamo</a></li>
                    </ul>
                </li>
            </ul>

            <!-- Pulsanti di accesso per la versione mobile -->
            <div class="auth-links-mobile">
                <a href="login.php" class="btn login-btn">Accedi</a>
                <a href="register.php" class="btn signup-btn">Registrati</a>
            </div>

            <!-- Selettore lingua nel menu mobile -->
            <div class="language-selector-mobile">
                <select id="language-switcher-mobile">
                    <option value="en">🇺🇸 EN</option>
                    <option value="nl">🇳🇱 NL</option>
                    <option value="fr">🇫🇷 FR</option>
                    <option value="it" selected>🇮🇹 IT</option>
                    <option value="es">🇪🇸 ES</option>
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

        <!-- Link di accesso per la versione desktop -->
        <div class="auth-container">
            <div class="auth-links">
                <a href="login.php">Accedi</a> | <a href="register.php">Registrati</a>
            </div>
            <div class="language-selector">
                <select id="language-switcher">
                    <option value="en">🇺🇸 EN</option>
                    <option value="nl">🇳🇱 NL</option>
                    <option value="fr">🇫🇷 FR</option>
                    <option value="it" selected>🇮🇹 IT</option>
                    <option value="es">🇪🇸 ES</option>
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
