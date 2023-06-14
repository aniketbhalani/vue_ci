// /**
//  * First we will load all of this project's JavaScript dependencies which
//  * includes Vue and other libraries. It is a great starting point when
//  * building robust, powerful web applications using Vue and Laravel.
//  */

// import './bootstrap';
// import { createApp } from 'vue';

// /**
//  * Next, we will create a fresh Vue application instance. You may then begin
//  * registering components with the application instance so they are ready
//  * to use in your application's views. An example is included for you.
//  */

// const app = createApp({});

// import ExampleComponent from './components/ExampleComponent.vue';
// app.component('example-component', ExampleComponent);

// /**
//  * The following block of code may be used to automatically register your
//  * Vue components. It will recursively scan this directory for the Vue
//  * components and automatically register them with their "basename".
//  *
//  * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
//  */

// // Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
// //     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// // });

// /**
//  * Finally, we will attach the application instance to a HTML element with
//  * an "id" attribute of "app". This element is included with the "auth"
//  * scaffolding. Otherwise, you will need to add an element yourself.
//  */

// app.mount('#app');
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';

// Import components
import App from './components/App.vue';
import ProductList from './components/ProductList.vue';
import ProductForm from './components/ProductForm.vue';
import Product from './components/Product.vue';
import CmsIndex from './components/CmsIndex.vue';
import CmsForm from './components/CmsForm.vue';
import BannerIndex from './components/BannerIndex.vue';
import BannerForm from './components/BannerForm.vue';
import MissionSkillIndex from './components/MissionSkillIndex.vue';
import MissionSkillForm from './components/MissionSkillForm.vue';
import MissionThemeIndex from './components/MissionThemeIndex.vue';
import MissionThemeForm from './components/MissionThemeForm.vue';
import AdminLogin from './components/AdminLogin.vue';
import UserLogin from './components/UserLogin.vue';
import UserRegistrationForm from './components/UserRegistrationForm.vue';
import UserForgotPassword from './components/UserForgotPassword.vue';
import UserResetPassword from './components/UserResetPassword.vue';
import AdminForgotPassword from './components/AdminForgotPassword.vue';
import AdminResetPassword from './components/AdminResetPassword.vue';
import PrivacyPolicy from './components/PrivacyPolicy.vue';
import AdminUserForm from './components/AdminUserForm.vue';
const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', component: ProductList },
        { path: '/products/create', component: ProductForm },
        { path: '/products/:id', component: Product },
        { path: '/products/:id/edit', component: ProductForm },
        { path: '/cmspage', component: CmsIndex },
        { path: '/cmspage/create', component: CmsForm },
        { path: '/cmspage/:id/edit', component: CmsForm },
        { path: '/banner', component: BannerIndex },
        { path: '/banner/create', component: BannerForm },
        { path: '/banner/:id/edit', component: BannerForm },
        { path: '/missionskill', component: MissionSkillIndex },
        { path: '/missionskill/create', component: MissionSkillForm },
        { path: '/missionskill/:id/edit', component: MissionSkillForm },
        { path: '/missiontheme', component: MissionThemeIndex },
        { path: '/missiontheme/create', component: MissionThemeForm },
        { path: '/missiontheme/:id/edit', component: MissionThemeForm },
        { path: '/admin/login', component: AdminLogin },
        { path: '/user/login', component: UserLogin },
        { path: '/user/register', component: UserRegistrationForm },
        { path: '/user/forgot', component: UserForgotPassword },
        { path: '/user/forgot-password/:token', component: UserResetPassword },
        { path: '/admin/forgot', component: AdminForgotPassword },
        { path: '/admin/forgot-password/:token', component: AdminResetPassword },
        { path: '/policies', component: PrivacyPolicy },
        { path: '/admin/user', component: AdminUserForm },
    ]
});
const app = createApp(App);
app.use(router);
app.mount('#app');
