require('./bootstrap');

import { createApp } from 'vue';

import CategoryComponent from  './components/CategoryComponent';
import BookComponent from  './components/BookComponent';

const app = createApp({
    components: {
        CategoryComponent,
        BookComponent,
    }
})

app.mount('#app');