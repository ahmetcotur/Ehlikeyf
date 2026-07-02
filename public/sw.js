self.addEventListener('push', function (event) {
    if (!event.data) {
        return;
    }

    try {
        const payload = event.data.json();
        const title = payload.title || 'Ehl-i Keyf Kaş';
        const options = {
            body: payload.body || '',
            icon: payload.icon || '/logo.png',
            badge: payload.badge || '/logo.png',
            data: {
                url: payload.url || '/admin'
            }
        };

        event.waitUntil(
            self.registration.showNotification(title, options)
        );
    } catch (e) {
        // Fallback if data is plain text
        const text = event.data.text();
        event.waitUntil(
            self.registration.showNotification('Ehl-i Keyf Kaş', {
                body: text,
                icon: '/logo.png',
                data: {
                    url: '/admin'
                }
            })
        );
    }
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();
    
    let url = '/admin';
    if (event.notification.data && event.notification.data.url) {
        url = event.notification.data.url;
    }

    event.waitUntil(
        clients.matchAll({ type: 'window' }).then(windowClients => {
            for (let i = 0; i < windowClients.length; i++) {
                let client = windowClients[i];
                if (client.url.includes(url) && 'focus' in client) {
                    return client.focus();
                }
            }
            if (clients.openWindow) {
                return clients.openWindow(url);
            }
        })
    );
});
