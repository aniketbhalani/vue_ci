<template>
    <div>
        <div class="container-fluid position-sticky" style="top:0%;background-color: white;z-index:999;">
            <button class="btn" name="header-toggle" id="main_header_btn" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
        <div class="container">
            <h2 class="mt-5 mx-4">Privacy and Cookies Policy</h2>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="container mt-5 d-none d-lg-block" style="height: 100%;">
                        <div class="col-sm-10" style="position: sticky;top:20%;">
                            <ul class="customnav flex-column justify-content" style="list-style:none;padding-left:0;">
                                <li v-for="policy in policies" :key="policy.id" class="nav-item">
                                    <a :href="`#${policy.slug}`" style="cursor: pointer;text-decoration:none;">
                                        <div class="d-flex justify-content-between">
                                            <span class="nav-link text-dark pl-3 py-2">{{ policy.title }}</span>
                                            <img src="../../../public/Images/right-arrow1.png" alt="right-arrow"
                                                style="width:15px;height:15px;padding-right:10px;">
                                        </div>
                                    </a>
                                    <hr>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="container">
                        <div class="row">
                            <div class="mt-5">
                                <div class="col-sm-9">
                                    <div v-for="policy in policies" :key="policy.id" class="tab-content">
                                        <div :id="policy.slug" class="tab-pane fade show active" role="tabpanel">
                                            <h3 class="mt-3">{{ policy.title }}</h3>
                                            <p class="mt-3" style="line-height: 1.5;" v-html="policy.text"></p>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
export default {
    data() {
        return {
            policies: [],
        };
    },
    async created() {
        axios.get('/api/policies')
            .then(response => {
                this.policies = response.data;
            })
            .catch(error => {
                console.error(error);
            });

        $('.nav-link').on('click', function () {
            $('.customnavbar-collapse').removeClass('show');
        });

        $('a[href*="#"]').on('click', function (e) {
            e.preventDefault();
            var target = $(this.hash);
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 1000);
                $('.customnavbar-collapse').removeClass('show');
            }
        });
    },
    // methods: {
    //   fetchPolicies() {
    //     axios.get('/api/policies')
    //       .then(response => {
    //         this.policies = response.data;
    //         console.log(response.data);
    //       })
    //       .catch(error => {
    //         console.error(error);
    //       });
    //   },
    // },
};
</script>





