document.addEventListener("DOMContentLoaded", function() {
    // Проверяем, подключен ли уже footer.css
    if (!document.querySelector('link[href="css/footer.css"]')) {
        const link = document.createElement("link");
        link.rel = "stylesheet";
        link.href = "css/footer.css";
        document.head.appendChild(link);
    }

    const footerHTML = `
    <footer>
        <div class="footer-container">
            <div class="footer-links">
                <a href="https://x.com/izipay_official?s=21" target="_blank"><img src="images/x-icon.png" alt="X (Twitter)"></a>
                <a href="https://t.me/izipay_official" target="_blank"><img src="images/telegram-icon.png" alt="Telegram"></a>
                <a href="https://www.instagram.com/izipay_official?igsh=ZWp1MzZudGV4N3J0&utm_source=qr" target="_blank"><img src="images/instagram-icon.png" alt="Instagram"></a>
                <a href="https://www.tiktok.com/@izipay_official?_t=ZM-8tc882TBrnR&_r=1" target="_blank"><img src="images/tiktok-icon.png" alt="TikTok"></a>
                <a href="https://www.linkedin.com/in/izi-pay-2b4509336/?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=ios_app" target="_blank"><img src="images/linkedin-icon.png" alt="LinkedIn"></a>
                <a href="https://www.youtube.com/@izipay_official" target="_blank"><img src="images/youtube-icon.png" alt="YouTube"></a>
            </div>
            
            <div class="footer-legal">
                <p>© IZIPAY Ltd 2025</p>        
            </div>
            
            <div class="footer-email">
                <p>Contact us: <a href="mailto:support@izipay.me">support@izipay.me</a></p>
            </div>
            
            <!-- Горизонтальная линия -->
            <hr class="footer-line">

            <!-- Меню под линией -->
            <div class="footer-menu">
                <div class="menu-column">
                    <h4>Product</h4>
                    <ul>
                        <li><a href="virtual-debit-card.html">Virtual Debit Card</a></li>
                        <li><a href="physical-debit-card.html">Physical Debit Card</a></li>
                    </ul>
                </div>
                <div class="menu-column">
                    <h4>Help</h4>
                    <ul>
                        <li><a href="faq.html">FAQ</a></li>
                        <li><a href="legal-documents.html">Legal Documents</a></li>
                        <li><a href="terms-conditions.html">Terms & Conditions</a></li>
                        <li><a href="privacy-policy.html">Privacy Policy</a></li>
                        <li><a href="pricing.html">Pricing</a></li>
                    </ul>
                </div>
                <div class="menu-column">
                    <h4>Company</h4>
                    <ul>
                        <li><a href="about-us.html">About Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>`;

    document.body.insertAdjacentHTML("beforeend", footerHTML);
});
