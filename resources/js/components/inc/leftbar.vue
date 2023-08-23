<template>
    <div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
        <div class="nano">
            <div class="nano-content">
                <ul>
                    <li class="label">Site</li>
                    <li><a target="_blank" href="/"><i class="ti-layout-media-center-alt"></i> Visit Site </a></li>
                    <li class="label">Main</li>
                    <li :class="$route.path === '/dashboard' ? 'active' : ''">
                        <router-link to="dashboard">
                       <i class="ti-dashboard"></i> Dashboard
                        </router-link>
                    </li>

                    <li class="label">Main Dashboard</li>
                    <!-- <li  :class="$route.path === '/breaking_news' ? 'active' : ''">
                        <router-link to="breaking_news">
                            <i class="ti-receipt"></i> Breaking News
                        </router-link>
                    </li> -->
                    <li  :class="$route.path === '/manage_posts' ? 'active' : ''">
                        <router-link to="manage_posts">
                            <i class="ti-layout-media-left"></i> Posts
                        </router-link>
                    </li>
                    <li  :class="$route.path === '/manage_videos' ? 'active' : ''">
                        <router-link to="manage_videos">
                            <i class="ti-control-play"></i> Videos
                        </router-link>
                    </li>
                    <li  :class="$route.path === '/manage_ads' ? 'active' : ''">
                        <router-link to="manage_ads">
                            <i class="ti-layout-cta-left"></i> Ads
                        </router-link>
                    </li>
                    <li  :class="$route.path === '/manage_categories' ? 'active' : ''">
                        <router-link to="manage_categories">
                            <i class="ti-list"></i> Categories
                        </router-link>
                    </li>
                    <li  :class="$route.path === '/manage_provinces' ? 'active' : ''">
                        <router-link to="manage_provinces">
                            <i class="ti-location-pin"></i> Province
                        </router-link>
                    </li>
                    <li  :class="$route.path === '/manage_tags' ? 'active' : ''">
                        <router-link to="manage_tags">
                            <i class="ti-tag"></i> Tags
                        </router-link>
                    </li>
                    <li  :class="$route.path === '/manage_gallery' ? 'active' : ''">
                        <router-link to="manage_gallery">
                            <i class="ti-gallery"></i> Gallery
                        </router-link>
                    </li>
                    <li class="label">Manage</li>
                    <!-- <li  :class="$route.path === '/manage_emails' ? 'active' : ''">
                        <router-link to="manage_emails">
                            <i class="ti-email"></i> Emails
                        </router-link>
                    </li> -->
                    <li  :class="$route.path === '/manage_comments' ? 'active' : ''">
                        <router-link to="manage_comments">
                            <i class="ti-comment"></i> Comments
                        </router-link>
                    </li>
                    <li  :class="$route.path === '/manage_admins' ? 'active' : ''">
                        <router-link to="manage_admins">
                            <i class="ti-menu"></i> Admins
                        </router-link>
                    </li>
                    <li  :class="$route.path === '/my_profile' ? 'active' : ''">
                        <router-link to="my_profile">
                            <i class="ti-user"></i> My Profile
                        </router-link>
                    </li>
                    <li class="label">Settings</li>
                    <li  :class="$route.path === '/manage_live_matches' ? 'active' : ''">
                        <router-link to="manage_live_matches">
                            <i class="ti-blackboard"></i> Live Matchs
                        </router-link>
                    </li>
                    <li  :class="$route.path === '/manage_leagues' ? 'active' : ''">
                        <router-link to="manage_leagues">
                            <i class="ti-basketball"></i> Leagues
                        </router-link>
                    </li>
                    <li  :class="$route.path === '/manage_teams' ? 'active' : ''">
                        <router-link to="manage_teams">
                            <i class="ti-cup"></i> Teams
                        </router-link>
                    </li>
                    <li  :class="$route.path === '/manage_league_tables' ? 'active' : ''">
                        <router-link to="manage_league_tables">
                            <i class="ti-layout-grid4-alt"></i> Table Leagues
                        </router-link>
                    </li>
                    <li  :class="$route.path === '/manage_contacts' ? 'active' : ''">
                        <router-link to="manage_contacts">
                            <i class="ti-email"></i> Contacts
                        </router-link>
                    </li>
                    <li  :class="$route.path === '/manage_our_story' ? 'active' : ''">
                        <router-link to="manage_our_story">
                            <i class="ti-info-alt"></i> Our Story
                        </router-link>
                    </li>
                    <li  :class="$route.path === '/manage_advertise' ? 'active' : ''">
                        <router-link to="manage_advertise">
                            <i class="ti-image"></i> Advertise
                        </router-link>
                    </li>
                    <li class="label">Control</li>
                    <li><a href="/logout"><i class="ti-close"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {

        }
    }
}
</script>