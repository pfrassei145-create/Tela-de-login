const CACHE_NAME = 'login-app-v1';

const urlsToCache = [
    '/',
    '/index.html',
    '/style.css',
    '/script.js'
];

// Instalação
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(urlsToCache))
    );
});

// Ativação
self.addEventListener('activate', event => {
    console.log('Service Worker ativado');
});

// Interceptação de requisições
self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => response || fetch(event.request))
    );
});
