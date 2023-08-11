<template>
  <div>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-transparent">
      <div class="container">
        <div class="navbar-translate n_logo">
          <a class="navbar-brand" href="/">Shalom Development Organization</a>
          <button class="navbar-toggler" type="button">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
          </button>
        </div>
      </div>
    </nav>

    <div class="page-header">
      <div
        class="page-header-image"
        style="background-image: url(dash/assets/images/login.jpg)"
      ></div>
      <div class="container">
        <div class="col-md-12 col-12 content-center">
          <div class="card-plain col-10">
            <div class="header">
              <div class="logo-container">
                <img
                  style="width: 300px; object-fit: cover"
                  :src="`${public_asset}/tech-viewed-logo-white.png`"
                  alt="Tech Viewed"
                />
              </div>
              <h3>Blocked</h3>
            </div>
            <div class="content">
              <h5>
                Your blocked to access admin dashboard, <br />
                Please contact Shalom Development Organization <br />
                system admin to get access.
              </h5>
            </div>
            <div class="footer text-center">
              <Button @click="retunBack()" type="primary" size="large">
                <Icon type="md-arrow-back" /> Back
              </Button>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container">
          <nav>
            <ul>
              <li><a href="/contact">Contact Us</a></li>
              <li><a href="/about_us">About Us</a></li>
              <!-- <li><a href="#">FAQ</a></li> -->
            </ul>
          </nav>
          <div class="copyright">
            &copy;
            <span>
              Designed by <a href="kabwezalabs.com" target="_blank">Kabweza Labs</a>
            </span>
          </div>
        </div>
      </footer>
    </div>
  </div>
</template>

<script>
export default {
  metaInfo() {
    return {
      title: "Shadomby | Blocked",
      meta: [
        {
          name: "description",
          content: "Shalom Development Organization | Blocked",
        },
      ],
    };
  },
  data() {
    return {};
  },

  methods: {
    retunBack() {
      window.history.back();
    },
  },
};
</script>
<style scoped>
.authentication .card-plain {
  border-radius: 0.25rem;
  padding-bottom: 0.7rem;
  max-width: 100%;
}
</style>
