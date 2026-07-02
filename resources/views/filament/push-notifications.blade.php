<div id="ehlikeyf-push-banner" style="display: none; position: fixed; bottom: 20px; right: 20px; z-index: 9999; max-width: 380px; font-family: sans-serif;" class="bg-white dark:bg-gray-900 border border-amber-500/30 dark:border-amber-500/20 shadow-2xl rounded-2xl p-4 transition-all duration-500 transform translate-y-4 opacity-0">
    <div style="display: flex; align-items: flex-start; gap: 12px;">
        <div style="padding: 8px; border-radius: 12px; background: rgba(245, 158, 11, 0.1); color: #d97706; flex-shrink: 0;">
            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
        </div>
        <div style="flex-grow: 1; display: flex; flex-direction: column; gap: 8px;">
            <h4 style="margin: 0; font-size: 14px; font-weight: 600; color: #111827;" class="dark:text-white">Anlık Bildirimleri Açın</h4>
            <p style="margin: 0; font-size: 12px; color: #6b7280;" class="dark:text-gray-400">Tarayıcınız veya sekmeler kapalı olsa dahi yeni rezervasyonları ve müşteri mesajlarını anında push bildirim olarak alın.</p>
            <div style="display: flex; align-items: center; gap: 8px; margin-top: 4px;">
                <button onclick="requestEhlikeyfPushPermission()" style="padding: 6px 12px; background: #d97706; border: none; border-radius: 8px; color: white; font-size: 12px; font-weight: 600; cursor: pointer; transition: background 0.2s;">Etkinleştir</button>
                <button onclick="dismissEhlikeyfPushBanner()" style="padding: 6px 12px; background: rgba(0,0,0,0.05); border: none; border-radius: 8px; color: #4b5563; font-size: 12px; font-weight: 600; cursor: pointer; transition: background 0.2s;" class="dark:bg-gray-800 dark:text-gray-300">Daha Sonra</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(initEhlikeyfPushNotification, 2000);
    });

    function initEhlikeyfPushNotification() {
        if (!('Notification' in window)) {
            return;
        }

        const banner = document.getElementById('ehlikeyf-push-banner');
        
        // If permission is default (not asked yet) and not dismissed in this session
        if (Notification.permission === 'default' && !sessionStorage.getItem('ehlikeyf_push_dismissed')) {
            banner.style.display = 'block';
            setTimeout(() => {
                banner.style.transform = 'translateY(0)';
                banner.style.opacity = '1';
            }, 100);
        }

        // Initialize service worker and subscription if permission is already granted
        if (Notification.permission === 'granted') {
            registerServiceWorkerAndSubscribe();
            startSubmissionPolling(); // Fallback dynamic polling for open dashboard pages
        }
    }

    function requestEhlikeyfPushPermission() {
        Notification.requestPermission().then(permission => {
            const banner = document.getElementById('ehlikeyf-push-banner');
            if (permission === 'granted') {
                banner.style.transform = 'translateY(20px)';
                banner.style.opacity = '0';
                setTimeout(() => banner.style.display = 'none', 500);
                
                // Register Service Worker and subscribe
                registerServiceWorkerAndSubscribe();
                startSubmissionPolling();

                // Show a test notification
                new Notification('Ehl-i Keyf Kaş', {
                    body: 'Harika! Anlık rezervasyon bildirimleri başarıyla aktif edildi.',
                    icon: '/logo.png'
                });
            } else {
                dismissEhlikeyfPushBanner();
            }
        });
    }

    function dismissEhlikeyfPushBanner() {
        const banner = document.getElementById('ehlikeyf-push-banner');
        banner.style.transform = 'translateY(20px)';
        banner.style.opacity = '0';
        setTimeout(() => banner.style.display = 'none', 500);
        sessionStorage.setItem('ehlikeyf_push_dismissed', 'true');
    }

    // --- Web Push Subscription Logic ---
    
    function urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding)
            .replace(/\-/g, '+')
            .replace(/_/g, '/');
     
        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);
     
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }

    function registerServiceWorkerAndSubscribe() {
        if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
            return;
        }

        navigator.serviceWorker.register('/sw.js')
            .then(registration => {
                console.log('Service Worker registered successfully');
                
                return registration.pushManager.getSubscription()
                    .then(subscription => {
                        if (subscription) {
                            sendSubscriptionToBackend(subscription);
                            return;
                        }
                        
                        if (Notification.permission === 'granted') {
                            subscribeUserToPush(registration);
                        }
                    });
            })
            .catch(error => {
                console.error('Service Worker registration failed:', error);
            });
    }

    function subscribeUserToPush(registration) {
        fetch('/admin/vapid-public-key')
            .then(res => res.json())
            .then(data => {
                const publicKey = data.publicKey;
                if (!publicKey) return;

                const applicationServerKey = urlBase64ToUint8Array(publicKey);
                
                return registration.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: applicationServerKey
                });
            })
            .then(subscription => {
                if (subscription) {
                    sendSubscriptionToBackend(subscription);
                }
            })
            .catch(err => {
                console.error('Failed to subscribe user to push:', err);
            });
    }

    function sendSubscriptionToBackend(subscription) {
        const key = subscription.getKey('p256dh');
        const token = subscription.getKey('auth');
        
        const rawKey = btoa(String.fromCharCode.apply(null, new Uint8Array(key)));
        const rawToken = btoa(String.fromCharCode.apply(null, new Uint8Array(token)));

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        fetch('/admin/push-subscribe', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                endpoint: subscription.endpoint,
                public_key: rawKey,
                auth_token: rawToken
            })
        })
        .then(res => res.json())
        .then(data => {
            console.log('Push subscription verified on server:', data);
        })
        .catch(err => console.error('Failed to sync push subscription', err));
    }

    // --- Tab-based unread polling fallback ---

    function startSubmissionPolling() {
        fetch('/admin/notifications-check')
            .then(res => res.json())
            .then(data => {
                if (data.latest_booking) {
                    if (!localStorage.getItem('ehlikeyf_last_booking_id')) {
                        localStorage.setItem('ehlikeyf_last_booking_id', data.latest_booking.id);
                    }
                }
                if (data.latest_feedback) {
                    if (!localStorage.getItem('ehlikeyf_last_feedback_id')) {
                        localStorage.setItem('ehlikeyf_last_feedback_id', data.latest_feedback.id);
                    }
                }
            })
            .catch(err => console.error('Failed to init polling', err));

        setInterval(() => {
            fetch('/admin/notifications-check')
                .then(res => res.json())
                .then(data => {
                    if (data.latest_booking) {
                        let lastId = localStorage.getItem('ehlikeyf_last_booking_id');
                        if (lastId && data.latest_booking.id > parseInt(lastId)) {
                            playNotificationSound();
                            new Notification('Yeni Masa Rezervasyonu! 🍽️', {
                                body: `${data.latest_booking.name} - ${data.latest_booking.party_size} Kişi, Saat: ${data.latest_booking.time}`,
                                icon: '/logo.png'
                            });
                        }
                        localStorage.setItem('ehlikeyf_last_booking_id', data.latest_booking.id);
                    }

                    if (data.latest_feedback) {
                        let lastId = localStorage.getItem('ehlikeyf_last_feedback_id');
                        if (lastId && data.latest_feedback.id > parseInt(lastId)) {
                            playNotificationSound();
                            new Notification('Yeni İletişim Mesajı! ✉️', {
                                body: `${data.latest_feedback.name} yeni bir mesaj gönderdi.`,
                                icon: '/logo.png'
                            });
                        }
                        localStorage.setItem('ehlikeyf_last_feedback_id', data.latest_feedback.id);
                    }
                })
                .catch(err => console.error('Error polling data', err));
        }, 10000);
    }

    function playNotificationSound() {
        try {
            let audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            let playBeep = (delay, freq) => {
                let osc = audioCtx.createOscillator();
                let gain = audioCtx.createGain();
                
                osc.connect(gain);
                gain.connect(audioCtx.destination);
                
                osc.frequency.value = freq;
                osc.type = 'sine';
                
                gain.gain.setValueAtTime(0, audioCtx.currentTime + delay);
                gain.gain.linearRampToValueAtTime(0.15, audioCtx.currentTime + delay + 0.05);
                gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + delay + 0.25);
                
                osc.start(audioCtx.currentTime + delay);
                osc.stop(audioCtx.currentTime + delay + 0.3);
            };

            playBeep(0, 880);
            playBeep(0.12, 1200);
        } catch (e) {
            console.log('AudioContext blocked', e);
        }
    }
</script>
