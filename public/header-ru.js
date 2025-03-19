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
            <a href="index-ru.html">
                <img src="images/logo.png" alt="Логотип IZIPAY" />
            </a>
        </div>

        <!-- Гамбургер-меню -->
        <div class="menu-toggle" aria-expanded="false">
            <div></div>
            <div></div>
            <div></div>
        </div>

        <!-- Мобильное меню -->
        <nav class="mobile-menu" aria-hidden="true">
            <ul>
                <li class="dropdown">
                    <a href="#">Продукт</a>
                    <ul class="dropdown-menu">
                        <li><a href="virtual-debit-card-ru.html">Виртуальная дебетовая карта</a></li>
                        <li><a href="physical-debit-card-ru.html">Физическая дебетовая карта</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Помощь</a>
                    <ul class="dropdown-menu">
                        <li><a href="faq-ru.html">Часто задаваемые вопросы</a></li>
                        <li><a href="legal-documents-ru.html">Юридические документы</a></li>
                        <li><a href="terms-conditions-ru.html">Условия и положения</a></li>
                        <li><a href="privacy-policy-ru.html">Политика конфиденциальности</a></li>
                        <li><a href="pricing-ru.html">Цены</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Компания</a>
                    <ul class="dropdown-menu">
                        <li><a href="about-us-ru.html">О нас</a></li>
                    </ul>
                </li>
            </ul>

            <!-- Кнопки авторизации для мобильной версии -->
            <div class="auth-links-mobile">
                <a href="login.php" class="btn login-btn">Войти</a>
                <a href="register.php" class="btn signup-btn">Регистрация</a>
            </div>

                    <!-- Смена языка в мобильном меню -->
                    <div class="language-selector-mobile">
                        <select id="language-switcher-mobile">
                            <option value="ru">🇷🇺 RU</option>
                            <option value="en">🇺🇸 EN</option>
                            <option value="nl">🇳🇱 NL</option>
                            <option value="fr">🇫🇷 FR</option>
                            <option value="it">🇮🇹 IT</option>
                            <option value="es">🇪🇸 ES</option>
                            <option value="de">🇩🇪 DE</option>
                            <option value="zh">🇨🇳 中文</option>
                            
                            
                        </select>
                    </div>
                    <style>@media (min-width: 768px) { /* Скрываем на десктопе */
                        .language-selector-mobile {
                            display: none;
                        }
                    }
                    </style>
                </nav>

        <!-- Ссылки для авторизации на десктопе -->
        <div class="auth-container">
            <div class="auth-links">
                <a href="login.php">Войти</a> | <a href="register.php">Регистрация</a>
            </div>
            <div class="language-selector">
                <select id="language-switcher">
                    <option value="ru">🇷🇺 RU</option>
                    <option value="en">🇺🇸 EN</option>
                    <option value="nl">🇳🇱 NL</option>
                    <option value="fr">🇫🇷 FR</option>
                    <option value="it">🇮🇹 IT</option>
                    <option value="es">🇪🇸 ES</option>
                    <option value="de">🇩🇪 DE</option>
                    <option value="zh">🇨🇳 中文</option>
                    
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
