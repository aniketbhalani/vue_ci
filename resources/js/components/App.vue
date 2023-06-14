<!-- <template>
    <div class="container">
      <header>
        <div class="px-3 py-2 bg-dark text-white">
          <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
              <router-link to="/" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                <img src="https://laraveltuts.com/wp-content/uploads/2022/06/logo-dark.webp" style="height:60px;"/>
              </router-link>
              <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                <li>
                    <router-link to="/" class="nav-link text-white" style="text-decoration: none; color: white;"><svg class="bi d-block mx-auto mb-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M4.5 21q-.625 0-1.063-.438T3 19.5v-1.9l4-3.55V21H4.5ZM8 21v-4h8v4H8Zm9 0v-8.2L12.725 9l3.025-2.675l4.75 4.225q.25.225.375.513t.125.612V19.5q0 .625-.438 1.063T19.5 21H17ZM3 16.25v-4.575q0-.325.125-.625t.375-.5L11 3.9q.2-.2.463-.287T12 3.525q.275 0 .537.088T13 3.9l2 1.775L3 16.25Z"/></svg>Home</router-link>
                </li>
                <li>
                    <router-link to="/products/create" class="nav-link text-white" style="text-decoration: none; color: white;"><svg class="bi d-block mx-auto mb-1" width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M7 9h10V7H7v2Zm11 14q-2.075 0-3.538-1.463T13 18q0-2.075 1.463-3.538T18 13q2.075 0 3.538 1.463T23 18q0 2.075-1.463 3.538T18 23Zm-.5-2h1v-2.5H21v-1h-2.5V15h-1v2.5H15v1h2.5V21ZM3 21V3h18v8.7q-.725-.35-1.463-.525T18 11q-.275 0-.513.013t-.487.062V11H7v2h6.1q-.425.425-.787.925T11.675 15H7v2h4.075q-.05.25-.063.488T11 18q0 .825.15 1.538T11.675 21H3Z"/></svg>Add Product</router-link>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </header>
      <div class="card">
        <div class="card-body">
          <div class="container-fluid">
            <router-view></router-view>
          </div>
        </div>
      </div>
    </div>
    </template>
    <script>
    export default {
      name: 'App'
    }
    </script> -->


<template>
    <div class="wrapper"    >
        <div class="section">
            <div class="top_navbar">
                <div class="hamburger" @click="toggleBodyClass">
                    <a href="#">
                        <i class="fas fa-bars"></i>
                    </a>
                </div>
            </div>
            <router-view></router-view>
        </div>
        <div class="sidebar">
            <div class="profile">
                <!-- <img src="https://1.bp.blogspot.com/-vhmWFWO2r8U/YLjr2A57toI/AAAAAAAACO4/0GBonlEZPmAiQW4uvkCTm5LvlJVd_-l_wCNcBGAsYHQ/s16000/team-1-2.jpg"
                    alt="profile_picture"> -->
                <h3>Ci Platform</h3>
                <p>Designer</p>
            </div>
            <ul>
                <li>
                    <a href="#" class="active">
                        <span class="icon"><i class="fas fa-home"></i></span>
                        <span class="item">Home</span>
                    </a>
                </li>
                <li>
                    <a href="/cmspage">
                        <span class="icon"><i class="fas fa-desktop"></i></span>
                        <span class="item">My Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/">
                        <span class="icon"><i class="fas fa-user-friends"></i></span>
                        <span class="item">People</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon"><i class="fas fa-tachometer-alt"></i></span>
                        <span class="item">Perfomance</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon"><i class="fas fa-database"></i></span>
                        <span class="item">Development</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon"><i class="fas fa-chart-line"></i></span>
                        <span class="item">Reports</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon"><i class="fas fa-user-shield"></i></span>
                        <span class="item">Admin</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon"><i class="fas fa-cog"></i></span>
                        <span class="item">Settings</span>
                    </a>
                </li>
            </ul>
        </div>

    </div>

</template>



<script>
// import Sidebar from './sidebar.vue';

export default {
    name: "App",
    // components: { Sidebar },
    methods: {
    toggleBodyClass() {
      document.querySelector("body").classList.toggle("active");
    }
  }
}
</script>
<style>

@import url('https://use.fontawesome.com/releases/v5.8.1/css/all.css');

* {
    list-style: none;
    text-decoration: none !important;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Open Sans', sans-serif;
}

body {
    background: #f5f6fa;
}  ol, ul {
   padding-left: 0rem !important;
 }

.wrapper .sidebar {
    background: rgb(241, 187, 7);
    position: fixed;
    top: 0;
    left: 0;
    width: 225px;
    height: 100%;
    padding: 20px 0;
    transition: all 0.5s ease;
}

.wrapper .sidebar .profile {
    margin-bottom: 30px;
    text-align: center;
}

.wrapper .sidebar .profile img {
    display: block;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    margin: 0 auto;
}

.wrapper .sidebar .profile h3 {
    color: #ffffff;
    margin: 10px 0 5px;
}

.wrapper .sidebar .profile p {
    color: rgb(206, 240, 253);
    font-size: 14px;
}

.wrapper .sidebar ul li a {
    display: block;
    padding: 13px 30px;
    border-bottom: 1px solid #10558d;
    color: rgb(241, 237, 237);
    font-size: 16px;
    position: relative;
}

.wrapper .sidebar ul li a .icon {
    color: #dee4ec;
    width: 30px;
    display: inline-block;
}



.wrapper .sidebar ul li a:hover,
.wrapper .sidebar ul li a.active {
    color: #0c7db1;

    background: white;
    border-right: 2px solid rgb(5, 68, 104);
}

.wrapper .sidebar ul li a:hover .icon,
.wrapper .sidebar ul li a.active .icon {
    color: #0c7db1;
}

.wrapper .sidebar ul li a:hover:before,
.wrapper .sidebar ul li a.active:before {
    display: block;
}

.wrapper .section {
    width: calc(100% - 225px);
    margin-left: 225px;
    transition: all 0.5s ease;
}

.wrapper .section .top_navbar {
    background: rgb(7, 105, 185);
    height: 50px;
    display: flex;
    align-items: center;
    padding: 0 30px;

}

.wrapper .section .top_navbar .hamburger a {
    font-size: 28px;
    color: #f4fbff;
}

.wrapper .section .top_navbar .hamburger a:hover {
    color: #a2ecff;
}



body.active .wrapper .sidebar {
    left: -225px;
}

body.active .wrapper .section {
    margin-left: 0;
    width: 100%;
}

</style>

