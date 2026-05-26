const CACHE_NAME = 'pwa-app-v4';

const urlsToCache = [
  './',
  './index.html',
  './home.html',
  './manifest.json',
  './icons/icon-192.png',
  './icons/icon-512.png'
];


// INSTALAÇÃO

self.addEventListener('install', event => {

  event.waitUntil(

    caches.open(CACHE_NAME)

      .then(cache => {
        return cache.addAll(urlsToCache);
      })

      .then(() => self.skipWaiting())
  );
});


// ATIVAÇÃO

self.addEventListener('activate', event => {

  event.waitUntil(

    caches.keys()

      .then(keys => {

        return Promise.all(

          keys
            .filter(key => key !== CACHE_NAME)
            .map(key => caches.delete(key))
        );
      })

      .then(() => self.clients.claim())
  );
});


// FETCH

self.addEventListener('fetch', event => {

  event.respondWith(

    caches.match(event.request)

      .then(response => {

        return response || fetch(event.request);
      })
  );
});