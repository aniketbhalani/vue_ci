<template>
    <div>
      <h2 v-if="isNewMissionSkill">Add</h2>
      <h2 v-else>Edit Mission Skill</h2>
        <form @submit.prevent="submitForm">
          <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input class="form-control" type="text" id="name" v-model="missionskill.skill_name" required />
          </div>
          <div>
            <label for="status">Status:</label>
            <select v-model="missionskill.status" id="status">
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>
          <button type="submit" v-if="isNewMissionSkill" class="btn btn-primary">Add</button>
          <button type="submit" v-else class="btn btn-primary">Update</button>
        </form>
    </div>
  </template>

  <script>
  import axios from 'axios';
  export default {
    data() {
      return {
        missionskill: {
          skill_name: '',
          status:1,
        }
      }
    },
    computed: {
      isNewMissionSkill() {
        return !this.$route.path.includes('edit');
      }
    },
    async created() {
      if (!this.isNewMissionSkill) {
        const response = await axios.get(`/api/missionskill/${this.$route.params.id}`);
        console.log(response);
        this.missionskill = response.data;
        console.log(this.missionskill);
      }
    },
    methods: {
      async submitForm() {
        try {
          if (this.isNewMissionSkill) {
            await axios.post('/api/missionskill', this.missionskill);
          } else {
            await axios.put(`/api/missionskill/${this.$route.params.id}`, this.missionskill);
          }
          this.$router.push('/missionskill');
        } catch (error) {
          console.error(error);
        }
      }
    }
  }
  </script>
