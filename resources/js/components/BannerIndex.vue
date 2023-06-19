<template>
    <div>
        <div class="container mt-3 p-4 ">
        <h2 class=" text-center mb-3">Banner</h2>
        <table class="table-responsive">
            <table class="table table-bordered">
            <thead>
              <tr>
                <th>id</th>
                <th>image</th>
                <th>text</th>
                <th>sort_order</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
                <tr v-for="banner in banners" :key="banner.banner_id">
                    <td>{{ banner.banner_id }}</td>
                    <td>{{ banner.image }}</td>
                    <td>{{ banner.text }}</td>
                    <td>{{ banner.sort_order }}</td>
                    <td>
                      <div>
                        <!-- <router-link :to="`/products/${banner.banner_id}`" class="p-2 col border btn btn-primary">View</router-link> -->
                        <router-link :to="`/banner/${banner.banner_id}/edit`" class="btn btn-outline-warning rounded-pill mt-3 px-4">Edit</router-link>&nbsp;&nbsp;
                        <button @click="deleteBanner(banner.banner_id)" type="button" class="btn btn-outline-danger rounded-pill mt-3 px-3">Delete</button>
                      
                      </div>
                    </td>
                </tr>
            </tbody>
        </table>
        </table>
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
