self.addEventListener('push', function(e) {

    if (!(self.Notification && self.Notification.permission === 'granted')) {
        return;
    }

    var data = e.data.json() || {};
    console.log(data);

    var image = data.image || 'https://aps.jaladara.com/uploads/favicon/07vbhUtSLagrkDL3t4H8HaHxV2UBtC0m0qTM4Y46.png';
    var title = data.title || '';
    var body = data.message || '';

    var options = {
        body: body,
        icon: image,
        badge: image,
        data: {
            url: 'aps.jaladara.com'
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