<div class="pt-32 pb-24 md:pt-40 md:pb-32 bg-brand-light text-brand-dark min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-5xl font-light text-brand-dark mb-12 text-center">{{ $slug === 'privacy-policy' ? __('Privacy Policy') : __('Terms of Service') }}</h1>
        
        <div class="prose prose-brand max-w-none text-gray-600 font-light leading-relaxed">
            @if($slug === 'privacy-policy')
                @if(app()->getLocale() === 'tr')
                    <h2>Gizlilik Politikası</h2>
                    <p>Ehl-i Keyf Kaş Kaş olarak, gizliliğinize saygı duyuyor ve kisisel verilerinizi korumaya önem veriyoruz. Bu politika, sitemizi ziyaret ettiginizde veya hizmetlerimizi kullandiginizda bilgilerinizi nasil topladigimizi ve kullandigimizi aciklar.</p>
                    <h3>Veri Toplama</h3>
                    <p>Adiniz, e-posta adresiniz ve telefon numaraniz gibi bilgileri yalnizca rezervasyon veya iletisim talepleriniz dogrultusunda toplariz.</p>
                    <h3>Veri Kullanimi</h3>
                    <p>Topladigimiz bilgiler rezervasyonlarinizi yönetmek ve size daha iyi hizmet sunmak amaciyla kullanilir. Bilgileriniz kesinlikle ücüncü sahislarla paylasilmaz.</p>
                @else
                    <h2>Privacy Policy</h2>
                    <p>At Ehl-i Keyf Kaş Kaş, we respect your privacy and are committed to protecting your personal data. This policy explains how we collect and use your information when you visit our site or use our services.</p>
                    <h3>Data Collection</h3>
                    <p>We only collect information such as your name, email address, and phone number when you make a reservation or submit a contact request.</p>
                    <h3>Data Usage</h3>
                    <p>The information we collect is used solely to manage your reservations and provide you with better service. Your information will never be shared with third parties.</p>
                @endif
            @else
                @if(app()->getLocale() === 'tr')
                    <h2>Hizmet Şartları</h2>
                    <p>Ehl-i Keyf Kaş Kaş web sitesini ve hizmetlerini kullanarak asagidaki sartlari kabul etmis olursunuz.</p>
                    <h3>Rezervasyonlar</h3>
                    <p>Web sitemiz veya telefon araciligiyla yapilan rezervasyonlar müsaitlik durumuna baglidir. Gecikme veya iptal durumlarinda lütfen bizi onceden bilgilendirin.</p>
                    <h3>Kullanim Kosullari</h3>
                    <p>Bu web sitesinin icerigi, yalnizca genel bilgi amaclidir ve haber verilmeksizin degistirilebilir.</p>
                @else
                    <h2>Terms of Service</h2>
                    <p>By using the Ehl-i Keyf Kaş Kaş website and services, you agree to the following terms and conditions.</p>
                    <h3>Reservations</h3>
                    <p>Reservations made through our website or via phone are subject to availability. Please notify us in advance of any delays or cancellations.</p>
                    <h3>Conditions of Use</h3>
                    <p>The content of this website is for your general information only and is subject to change without notice.</p>
                @endif
            @endif
        </div>
    </div>
</div>
