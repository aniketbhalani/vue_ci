<template>
    <div>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">theme id</th>
                <th scope="col">title</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                <tr v-for="missiontheme in missionthemes" :key="missiontheme.mission_theme_id">
                    <td>{{ missiontheme.mission_theme_id }}</td>
                    <td>{{ missiontheme.title }}</td>
                    <td>{{ getStatusLabel(missiontheme.status) }}</td>

                    <td>
                      <div class="row gap-3">
                        <!-- <router-link :to="`/missiontheme/${missiontheme.skill_id}`" class="p-2 col border btn btn-primary">View</router-link> -->
                        <router-link :to="`/missiontheme/${missiontheme.mission_theme_id}/edit`" class="p-2 col border btn btn-success">Edit</router-link>
                        <button @click="deleteMissionTheme(missiontheme.mission_theme_id)" type="button" class="p-2 col border btn btn-danger">Delete</button>
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
      missionthemes: []
    }
  },
  async created() {
    try {
      const response = await axios.get('/api/missiontheme');
      this.missionthemes = response.data;
    } catch (error) {
      console.error(error);
    }
  },
  methods: {
    getStatusLabel(status) {
    return status === '1' ? 'Active' : 'Inactive';
  },
    async deleteMissionTheme(mission_theme_id) {
      try {
        await axios.delete(`/api/missiontheme/${mission_theme_id}`);
        this.missionthemes = this.missionthemes.filter(missiontheme => missiontheme.mission_theme_id !== mission_theme_id);
      } catch (error) {
        console.error(error);
      }
    }
  }
}
</script>
