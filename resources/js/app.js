require('./bootstrap');

import { createApp } from 'vue';

import CategoryComponent from  './components/CategoryComponent';
import BookComponent from  './components/BookComponent';
import DashboardComponent from  './components/DashboardComponent';



const app = createApp({
    components: {
        CategoryComponent,
        BookComponent,
        DashboardComponent
    }
})

app.mount('#app');