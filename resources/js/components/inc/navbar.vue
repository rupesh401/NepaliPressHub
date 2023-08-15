<template>
    <div class="header">
        <div class="pull-left">
            <div class="logo"><a><span>SportsNews Admin</span></a></div>
            <div @click="toggleSidebar()" class="hamburger sidebar-toggle" :class="{ 'is-active': isActive }">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </div>
        <div class="pull-right p-r-15">
            <ul>
                <template>
                    <li class="header-icon dib">
                        <img class="avatar-img" :src="`${url_api}uploads/admins/${$store.state.userInfos.profile_image}`" alt="" />
                        <span class="user-avatar">{{ $store.state.userInfos.full_name }} <i
                                class="ti-angle-dowx f-s-10"></i></span>
                        <!-- <div class="drop-down dropdown-profile">
                            <div class="dropdown-content-body">
                                <ul>
                                    <li>
                                        <router-link to="/my_profile">
                                            <i class="ti-user"></i>
                                            <span>Profile</span>
                                        </router-link>
                                    </li>
                                    <li><a href="/logout"><i class="ti-power-off"></i> <span>Logout</span></a></li>
                                </ul>
                            </div>
                        </div> -->
                    </li>
                </template>
            </ul>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            hideSidebar: false,
            isActive: false,
            
        };
    },
    watch: {
        // Watch for changes to hideSidebar and update the body class
        hideSidebar(newValue) {
            this.updateBodyClass(newValue);
        },
    },
    methods: {
        toggleSidebar() {
            this.hideSidebar = !this.hideSidebar;
            this.isActive = !this.isActive;
            this.updateBodyClass(this.hideSidebar);
        },
        updateBodyClass(hideSidebar) {
            this.$nextTick(() => {
                if (hideSidebar) {
                    document.body.classList.add('sidebar-hide');
                } else {
                    document.body.classList.remove('sidebar-hide');
                }
            });
        },
        // ... Other methods ...
    },
};
</script>
