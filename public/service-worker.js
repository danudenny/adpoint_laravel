self.addEventListener('push', function(e) {

    if (!(self.Notification && self.Notification.permission === 'granted')) {
        return;
    }

    var data = e.data.json() || {};

    console.log(data);

    var image = data.image || 'https://sdk.pushy.me/web/assets/img/icon.png';
    var title = data.title || '';
    var body = data.message || '';

    var options = {
        body: body,
        icon: image,
        badge: image,
        data: {
            url: data.url
        }
    };

    e.waitUntil(self.registration.showNotification(title, options));
});

self.addEventListener('notificationclick', function(e) {
    e.notification.close();
    var url = e.notification.data.url;

    if (url) {
        e.waitUntil(clients.openWindow(url));
    }
});