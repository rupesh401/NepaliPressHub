<template>
  <div>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  props: ["user"],
  data() {
    return {};
  },

  created() {
    this.$store.commit("updateUser", this.user);
  },
};
</script>
