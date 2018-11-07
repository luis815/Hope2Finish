import Vue from 'vue'
import Router from 'vue-router'
import SampleHome from './views/SampleHome.vue'
import LandingPage from './views/LandingPage.vue'
import Profile from './views/Profile.vue'
import LogIn from './views/LogIn.vue'
import SignUp from './views/SignUp.vue'
import Home from './views/Home.vue'
import Upload from './views/Upload.vue'
import Watch from './views/Watch.vue'
import Kyros404 from './views/Kyros404'

Vue.use(Router);

export default new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [
        {
            path: '/',
            name: 'landing-page',
            component: LandingPage
        },
        {
            path: '/signup',
            name: 'signup',
            component: SignUp
        },
        {
            path: '/login',
            name: 'login',
            component: LogIn
        },
        {
            path: '/home',
            name: 'home',
            component: Home
        },
        {
            path: '/profile',
            name: 'profile',
            component: Profile
        },
        {
            path: '/upload',
            name: 'upload',
            component: Upload
        },
        {
            path: '/watch',
            name: 'watch',
            component: Watch
        },
        {
            path: '/sample-home',
            name: 'sample-home',
            component: SampleHome
        },
        {
            path: '/sample-about',
            name: 'sample-about',
            // route level code-splitting
            // this generates a separate chunk (about.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import(/* webpackChunkName: "about" */ './views/SampleAbout.vue')
        },
        {
            path: '/*',
            name: 'kyros-404',
            component: Kyros404
        }
    ]
})
