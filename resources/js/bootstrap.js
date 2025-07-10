// Import Bootstrap's JavaScript bundle (for components like modals, dropdowns, tooltips, etc.)
import 'bootstrap';

/**
 * Load Axios, a promise-based HTTP client for the browser.
 * It's configured to automatically send the CSRF token from cookies,
 * which Laravel expects for secure requests.
 */
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * (Optional) Laravel Echo Setup — for real-time event broadcasting.
 * Echo works with tools like Pusher to listen for server-side events via websockets.
 * Uncomment and configure if your app uses real-time features.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
