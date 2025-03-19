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
            <a href="index-zh.html">
                <img src="images/logo.png" alt="IZIPAY 标志" />
            </a>
        </div>

        <!-- 汉堡菜单 -->
        <div class="menu-toggle" aria-expanded="false">
            <div></div>
            <div></div>
            <div></div>
        </div>

        <!-- 移动菜单 -->
        <nav class="mobile-menu" aria-hidden="true">
            <ul>
                <li class="dropdown">
                    <a href="#">产品</a>
                    <ul class="dropdown-menu">
                        <li><a href="virtual-debit-card-zh.html">虚拟借记卡</a></li>
                        <li><a href="physical-debit-card-zh.html">实体借记卡</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">帮助</a>
                    <ul class="dropdown-menu">
                        <li><a href="faq-zh.html">常见问题</a></li>
                        <li><a href="legal-documents-zh.html">法律文件</a></li>
                        <li><a href="terms-conditions-zh.html">条款与条件</a></li>
                        <li><a href="privacy-policy-zh.html">隐私政策</a></li>
                        <li><a href="pricing-zh.html">价格</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">公司</a>
                    <ul class="dropdown-menu">
                        <li><a href="about-us-zh.html">关于我们</a></li>
                    </ul>
                </li>
            </ul>

            <!-- 移动版登录按钮 -->
            <div class="auth-links-mobile">
                <a href="login.php" class="btn login-btn">登录</a>
                <a href="register.php" class="btn signup-btn">注册</a>
            </div>

            <!-- 移动版语言选择 -->
            <div class="language-selector-mobile">
                <select id="language-switcher-mobile">
                    <option value="en">🇺🇸 EN</option>
                    <option value="nl">🇳🇱 NL</option>
                    <option value="fr">🇫🇷 FR</option>
                    <option value="it">🇮🇹 IT</option>
                    <option value="es">🇪🇸 ES</option>
                    <option value="de">🇩🇪 DE</option>
                    <option value="zh" selected>🇨🇳 中文</option>
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
        <!-- 桌面版登录按钮 -->
        <div class="auth-container">
            <div class="auth-links">
                <a href="login.php">登录</a> | <a href="register.php">注册</a>
            </div>
            <div class="language-selector">
                <select id="language-switcher">
                    <option value="en">🇺🇸 EN</option>
                    <option value="nl">🇳🇱 NL</option>
                    <option value="fr">🇫🇷 FR</option>
                    <option value="it">🇮🇹 IT</option>
                    <option value="es">🇪🇸 ES</option>
                    <option value="de">🇩🇪 DE</option>
                    <option value="zh" selected>🇨🇳 中文</option>
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
