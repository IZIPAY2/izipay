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
            <a href="index-de.html">
                <img src="images/logo.png" alt="IZIPAY-Logo" />
            </a>
        </div>

        <!-- Hamburger-Menü -->
        <div class="menu-toggle" aria-expanded="false">
            <div></div>
            <div></div>
            <div></div>
        </div>

        <!-- Mobiles Menü -->
        <nav class="mobile-menu" aria-hidden="true">
            <ul>
                <li class="dropdown">
                    <a href="#">Produkt</a>
                    <ul class="dropdown-menu">
                        <li><a href="virtual-debit-card-de.html">Virtuelle Debitkarte</a></li>
                        <li><a href="physical-debit-card-de.html">Physische Debitkarte</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Hilfe</a>
                    <ul class="dropdown-menu">
                        <li><a href="faq-de.html">FAQ</a></li>
                        <li><a href="legal-documents-de.html">Rechtliche Dokumente</a></li>
                        <li><a href="terms-conditions-de.html">Allgemeine Geschäftsbedingungen</a></li>
                        <li><a href="privacy-policy-de.html">Datenschutzrichtlinie</a></li>
                        <li><a href="pricing-de.html">Preise</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Unternehmen</a>
                    <ul class="dropdown-menu">
                        <li><a href="about-us-de.html">Über uns</a></li>
                    </ul>
                </li>
            </ul>

            <!-- Anmeldebuttons für die mobile Version -->
            <div class="auth-links-mobile">
                <a href="login.php" class="btn login-btn">Anmelden</a>
                <a href="register.php" class="btn signup-btn">Registrieren</a>
            </div>

            <!-- Sprachwechsel im mobilen Menü -->
            <div class="language-selector-mobile">
                <select id="language-switcher-mobile">
                    <option value="en">🇺🇸 EN</option>
                    <option value="nl">🇳🇱 NL</option>
                    <option value="fr">🇫🇷 FR</option>
                    <option value="it">🇮🇹 IT</option>
                    <option value="es">🇪🇸 ES</option>
                    <option value="de" selected>🇩🇪 DE</option>
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
        
        <!-- Anmelde-Links für die Desktop-Version -->
        <div class="auth-container">
            <div class="auth-links">
                <a href="login.php">Anmelden</a> | <a href="register.php">Registrieren</a>
            </div>
            <div class="language-selector">
                <select id="language-switcher">
                    <option value="en">🇺🇸 EN</option>
                    <option value="nl">🇳🇱 NL</option>
                    <option value="fr">🇫🇷 FR</option>
                    <option value="it">🇮🇹 IT</option>
                    <option value="es">🇪🇸 ES</option>
                    <option value="de" selected>🇩🇪 DE</option>
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
