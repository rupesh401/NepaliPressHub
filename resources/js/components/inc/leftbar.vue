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
                    <li :class="$route.path === '/manage_posts' ? 'active' : ''">
                        <router-link to="manage_posts">
                            <i class="ti-layout-media-left"></i> Posts
                        </router-link>
                    </li>
                    <li :class="{ 'active open': postComponents }">
                        <a class="sidebar-sub-toggle" @click="togglePost">
                            <i class="ti-layers-alt"></i>
                            Post Components <span class="sidebar-collapse-icon ti-angle-down">
                            </span>
                        </a>
                        <ul>
                            <li>
                                <router-link to="manage_categories">
                                    <i class="ti-list"></i> Categories
                                </router-link>
                            </li>
                            <li>
                                <router-link to="manage_provinces">
                                    <i class="ti-location-pin"></i> Province
                                </router-link>
                            </li>
                            <li>
                                <router-link to="manage_tags">
                                    <i class="ti-tag"></i> Tags
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li :class="$route.path === '/manage_videos' ? 'active' : ''">
                        <router-link to="manage_videos">
                            <i class="ti-control-play"></i> Videos
                        </router-link>
                    </li>
                    <li :class="$route.path === '/manage_ads' ? 'active' : ''">
                        <router-link to="manage_ads">
                            <i class="ti-layout-cta-left"></i> Ads
                        </router-link>
                    </li>
                    <li :class="$route.path === '/manage_gallery' ? 'active' : ''">
                        <router-link to="manage_gallery">
                            <i class="ti-gallery"></i> Gallery
                        </router-link>
                    </li>
                    <li :class="{ 'active open': isActive }">
                        <a class="sidebar-sub-toggle" @click="toggleList">
                            <i class="ti-basketball"></i>
                            Football <span class="sidebar-collapse-icon ti-angle-down">
                            </span>
                        </a>
                        <ul>
                            <li>
                                <router-link to="manage_live_matches">
                                    <i class="ti-blackboard"></i> Live Matches
                                </router-link>
                            </li>
                            <li>
                                <router-link to="manage_leagues">
                                    <i class="ti-basketball"></i> Leagues
                                </router-link>
                            </li>
                            <li>
                                <router-link to="manage_teams">
                                    <i class="ti-cup"></i> Teams
                                </router-link>
                            </li>
                            <li>
                                <router-link to="manage_league_tables">
                                    <i class="ti-layout-grid4-alt"></i> Table Leagues
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li :class="{ 'active open': manageActive }">
                        <a class="sidebar-sub-toggle" @click="toggleManage">
                            <i class="ti-widgetized"></i>
                            Manage <span class="sidebar-collapse-icon ti-angle-down">
                            </span>
                        </a>
                        <ul>
                            <li>
                                <router-link to="manage_comments">
                                    <i class="ti-comment"></i> Comments
                                </router-link>
                            </li>
                            <li>
                                <router-link to="manage_admins">
                                    <i class="ti-menu"></i> Admins
                                </router-link>
                            </li>
                            <li>
                                <router-link to="my_profile">
                                    <i class="ti-user"></i> My Profile
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <!-- <li class="label">Manage</li> -->
                    <!-- <li  :class="$route.path === '/manage_emails' ? 'active' : ''">
                        <router-link to="manage_emails">
                            <i class="ti-email"></i> Emails
                        </router-link>
                    </li> -->
                    <li :class="{ 'active open': settingsActive }">
                        <a class="sidebar-sub-toggle" @click="toggleSettings">
                            <i class="ti-settings"></i>
                            Settings <span class="sidebar-collapse-icon ti-angle-down">
                            </span>
                        </a>
                        <ul>
                            <li>
                                <router-link to="manage_contacts">
                                    <i class="ti-email"></i> Contacts
                                </router-link>
                            </li>
                            <li>
                                <router-link to="manage_our_story">
                                    <i class="ti-info-alt"></i> Our Story
                                </router-link>
                            </li>
                            <li>
                                <router-link to="manage_advertise">
                                    <i class="ti-image"></i> Advertise
                                </router-link>
                            </li>
                        </ul>
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
            isActive: false,
            manageActive: false,
            settingsActive: false,
            postComponents: false
        };
    },
    created() {
        this.updateRouteState(this.$route);
    },
    watch: {
        $route(to) {
            this.updateRouteState(to);
        }
    },
    methods: {
        updateRouteState(to) {
            this.postComponents =
                to.path === "/manage_categories" ||
                to.path === "/manage_provinces" ||
                to.path === "/manage_tags";

            this.isActive =
                to.path === "/manage_live_matches" ||
                to.path === "/manage_leagues" ||
                to.path === "/manage_teams" ||
                to.path === "/manage_league_tables";

            this.manageActive =
                to.path === "/manage_comments" ||
                to.path === "/manage_admins" ||
                to.path === "/my_profile";
            
            this.settingsActive =
                to.path === "/manage_contacts" ||
                to.path === "/manage_our_story" ||
                to.path === "/manage_advertise";

            // console.log("Route updated:", to.path);
        },
        toggleList() {
            this.isActive = !this.isActive;
        },
        toggleManage() {
            this.manageActive = !this.manageActive;
        },
        toggleSettings() {
            this.settingsActive = !this.settingsActive;
        },
        togglePost() {
            this.postComponents = !this.postComponents;
        }
    }
};
</script>