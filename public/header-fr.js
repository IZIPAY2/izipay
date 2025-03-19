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
            <a href="index-fr.html">
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
                    <a href="#">Produit</a>
                    <ul class="dropdown-menu">
                        <li><a href="virtual-debit-card-fr.html">Carte de débit virtuelle</a></li>
                        <li><a href="physical-debit-card-fr.html">Carte de débit physique</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Aide</a>
                    <ul class="dropdown-menu">
                        <li><a href="faq-fr.html">FAQ</a></li>
                        <li><a href="legal-documents-fr.html">Documents légaux</a></li>
                        <li><a href="terms-conditions-fr.html">Conditions générales</a></li>
                        <li><a href="privacy-policy-fr.html">Politique de confidentialité</a></li>
                        <li><a href="pricing-fr.html">Tarification</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Entreprise</a>
                    <ul class="dropdown-menu">
                        <li><a href="about-us-fr.html">À propos de nous</a></li>
                    </ul>
                </li>
            </ul>

            <!-- Boutons de connexion pour mobile -->
            <div class="auth-links-mobile">
                <a href="login.php" class="btn login-btn">Connexion</a>
                <a href="register.php" class="btn signup-btn">S'inscrire</a>
            </div>

            <!-- Sélecteur de langue pour mobile -->
            <div class="language-selector-mobile">
                <select id="language-switcher-mobile">
                    <option value="en">🇺🇸 EN</option>
                    <option value="nl">🇳🇱 NL</option>
                    <option value="fr" selected>🇫🇷 FR</option>
                    <option value="it">🇮🇹 IT</option>
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
            }</style>
        </nav>

        <!-- Liens de connexion sur desktop -->
        <div class="auth-container">
            <div class="auth-links">
                <a href="login.php">Connexion</a> | <a href="register.php">S'inscrire</a>
            </div>
            <div class="language-selector">
                <select id="language-switcher">
                    <option value="en">🇺🇸 EN</option>
                    <option value="nl">🇳🇱 NL</option>
                    <option value="fr" selected>🇫🇷 FR</option>
                    <option value="it">🇮🇹 IT</option>
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
