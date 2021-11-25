require('./bootstrap');

import { createApp } from 'vue';

import CategoryComponent from  './components/CategoryComponent';

const app = createApp({
    components: {
        CategoryComponent,
    }
})

app.mount('#app');