import Echo from 'laravel-echo';

window.Reverb = require('reverb-js');

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: process.env.MIX_REVERB_KEY,
    cluster: process.env.MIX_REVERB_CLUSTER,
    forceTLS: true
});
Echo.private(`chat.${receiverId}`)
    .listen('MessageSent', (e) => {
        console.log(e.message);
    });

