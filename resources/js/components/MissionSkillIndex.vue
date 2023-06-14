<template>
    <div>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">skill id</th>
                <th scope="col">Skill</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                <tr v-for="missionskill in missionskills" :key="missionskill.skill_id">
                    <td>{{ missionskill.skill_id }}</td>
                    <td>{{ missionskill.skill_name }}</td>
                    <td>{{ getStatusLabel(missionskill.status) }}</td>

                    <td>
                      <div class="row gap-3">
                        <!-- <router-link :to="`/missionskill/${missionskill.skill_id}`" class="p-2 col border btn btn-primary">View</router-link> -->
                        <router-link :to="`/missionskill/${missionskill.skill_id}/edit`" class="p-2 col border btn btn-success">Edit</router-link>
                        <button @click="deleteMissionSkill(missionskill.skill_id)" type="button" class="p-2 col border btn btn-danger">Delete</button>
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
      missionskills: []
    }
  },
  async created()    {
    try {
      const response = await axios.get('/api/missionskill');
      this.missionskills = response.data;
    } catch (error) {
      console.error(error);
    }
  },
  methods: {
    getStatusLabel(status) {
    return status === '1' ? 'Active' : 'Inactive';
  },
    async deleteMissionSkill(skill_id) {
      try {
        await axios.delete(`/api/missionskill/${skill_id}`);
        this.missionskills = this.missionskills.filter(missionskill => missionskill.skill_id !== skill_id);
      } catch (error) {
        console.error(error);
      }
    }
  }
}
</script>
