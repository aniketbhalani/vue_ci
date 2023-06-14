<template>
    <div>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">id</th>
                <th scope="col">image</th>
                <th scope="col">text</th>
                <th scope="col">sort_order</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                <tr v-for="banner in banners" :key="banner.banner_id">
                    <td>{{ banner.banner_id }}</td>
                    <td>{{ banner.image }}</td>
                    <td>{{ banner.text }}</td>
                    <td>{{ banner.sort_order }}</td>
                    <td>
                      <div class="row gap-3">
                        <!-- <router-link :to="`/products/${banner.banner_id}`" class="p-2 col border btn btn-primary">View</router-link> -->
                        <router-link :to="`/banner/${banner.banner_id}/edit`" class="p-2 col border btn btn-success">Edit</router-link>
                        <button @click="deleteBanner(banner.banner_id)" type="button" class="p-2 col border btn btn-danger">Delete</button>
                      </div>
                    </td>
                </tr>
            </tbody>
        </table>
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
