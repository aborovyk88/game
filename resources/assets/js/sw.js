const CACHE = 'network-or-cache-v1';
const timeout = 400;

self.addEventListener('install', (event) => {
    console.log('Installed');
    event.waitUntil(
        caches.open(CACHE).then((cache) => cache.addAll([
                '/js/app.js',
                '/js/game.js',
                '/js/login.js',
                '/js/user-list.js',
                '/js/user-manage.js',

                '/css',

                '/fonts'
            ])
        ));
});

self.addEventListener('activate', (event) => {
    console.log('Activated');
});

self.addEventListener('fetch', (event) => {
    console.log('Loading query to server');
    event.respondWith(fromNetwork(event.request, timeout)
        .catch((err) => {
            return fromCache(event.request);
        }));
});

function fromNetwork(request, timeout) {
    return new Promise((fulfill, reject) => {
        let timeoutId = setTimeout(reject, timeout);
        fetch(request).then((response) => {
            clearTimeout(timeoutId);
            fulfill(response);
        }, reject);
    });
}

function fromCache(request) {
    return caches.open(CACHE).then((cache) =>
        cache.match(request).then((matching) =>
            matching || Promise.reject('no-match')
        ));
}
