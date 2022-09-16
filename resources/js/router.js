import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import HomePage from './pages/HomePage.vue';
import AbouPage from './pages/AboutPage.vue';
import BlogPage from './pages/BlogPage.vue';
import SinglePost from './pages/SinglePost.vue';
import PageNotFound from './pages/PageNotFound.vue';
import ContactPage from './pages/ContactPage.vue';


const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            component: HomePage, 
            name: 'home'
        },
        {
            path: '/about',
            component: AbouPage, 
            name: 'about'
        },
        {
            path: '/blog',
            component: BlogPage, 
            name: 'blog'
        },
        {
            path: '/blog/:slug',
            component: SinglePost, 
            name: 'post'
        },
        {
            path: '/contact',
            component: ContactPage, 
            name: 'contact'
        },
        {
            path: '/*',
            component: PageNotFound, 
            name: 'notFound'
        }
    ]
  });

export default router;

