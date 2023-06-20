<template>
    <div class="container-fluid mt-3 px-4 ">
        <div class="card ">
            <div class="card-header">
                <h2 class="text-center mb-1"> Banner </h2>
            </div>
            <div class="card-body">
                <table class="table-responsive">
                    <table class="table table-bordered ">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>image</th>
                                <th>text</th>
                                <th>sort_order</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center" v-for="banner in banners" :key="banner.banner_id">
                                <td>{{ banner.banner_id }}</td>
                                <td><img :src="`../../../storage/${banner.image}`" alt=""
                                        style="width:115px;height:115px;border-radius:100%;" /></td>
                                <td v-html="banner.text"></td>
                                <td>{{ banner.sort_order }}</td>
                                <td>
                                    <div>
                                        <!-- <router-link :to="`/products/${banner.banner_id}`" class="p-2 col border btn btn-primary">View</router-link> -->
                                        <router-link :to="`/banner/${banner.banner_id}/edit`"
                                            class="px-4 border btn btn-outline-warning rounded-pill">Edit</router-link>&nbsp;&nbsp;
                                        <button @click="deleteBanner(banner.banner_id)" type="button"
                                            class="px-3 border btn btn-outline-danger rounded-pill">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            banners: []
        }
    },
    async created() {
        try {
            const response = await axios.get('/api/banner');
            this.banners = response.data;
        } catch (error) {
            console.error(error);
        }
    },
    methods: {
        async deleteBanner(banner_id) {
            try {
                await axios.delete(`/api/banner/${banner_id}`);
                this.banners = this.banners.filter(banner => banner.banner_id !== banner_id);
            } catch (error) {
                console.error(error);
            }
        }
    }
}
</script>
