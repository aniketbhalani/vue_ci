<template>
    <div>
        <h2 v-if="isNewMissionSkill" class=" mt-5 text-center">Create Mission Skill</h2>
        <h2 v-else class=" mt-5 text-center">Edit Mission Skill</h2>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <form @submit.prevent="submitForm">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input class="form-control" type="text" id="name" v-model="missionskill.skill_name" required />
            </div>
            <div>
                <label for="status">Status:</label>
                <select class="form-control" v-model="missionskill.status" id="status">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div>
                <button type="submit" v-if="isNewMissionSkill"
                    class="btn btn-outline-warning rounded-pill mt-3 px-4 float-end">Add</button>
                <router-link to="/missionskill" v-if="isNewMissionSkill"
                    class="btn btn-outline-secondary rounded-pill mt-3 px-3">Cancel</router-link>

                <button type="submit" v-else
                    class="btn btn-outline-warning rounded-pill mt-3 px-3 float-end">Update</button>
            </div>
        </form>
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
            missionskill: {
                skill_name: '',
                status: 1,
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
