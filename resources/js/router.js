import Vue from 'vue'
import Router from 'vue-router'
import homepage from './components/pages/homepage'
import dashboard from './components/pages/admin/dashboard'
import login from './components/pages/auth/login'
import blocked from './components/pages/auth/blocked'
import addNewAdmin from './components/pages/admin/addNewAdmin'
import profile from './components/pages/admin/profile'
import managePost from './components/pages/admin/managePost'
import contact from './components/pages/admin/contact'
import aboutUs from './components/pages/admin/manageAboutUs'
import manageTags from './components/pages/admin/manageTags'
import manageCategory from './components/pages/admin/manageCategory'
import manageProvince from './components/pages/admin/manageProvince'
import manageVideo from './components/pages/admin/manageVideo'
import comments from './components/pages/admin/manageComment'
import breakingNews from './components/pages/admin/breakingNews'
import manageEmails from './components/pages/admin/manageEmails'
import manageGallery from './components/pages/admin/manageGallery'
import manageAds from './components/pages/admin/manageAds'

Vue.use(Router)

const routes = [
    { path: '/home_page', component: homepage },
    { path: '/dashboard', component: dashboard },
    { path: '/login', component: login },
    { path: '/blocked', component: blocked },
    { path: '/manage_admins', component: addNewAdmin },
    { path: '/my_profile', component: profile },
    { path: '/manage_posts', component: managePost },
    { path: '/manage_contacts', component: contact },
    { path: '/manage_our_story', component: aboutUs },
    { path: '/manage_tags', component: manageTags },
    { path: '/manage_videos', component: manageVideo },
    { path: '/manage_categories', component: manageCategory },
    { path: '/manage_provinces', component: manageProvince },
    { path: '/manage_comments', component: comments },
    { path: '/breaking_news', component: breakingNews },
    { path: '/manage_emails', component: manageEmails },
    { path: '/manage_gallery', component: manageGallery },
    { path: '/manage_ads', component: manageAds },
]

export default new Router({
    mode: 'history',
    routes 
})