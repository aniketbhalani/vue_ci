<template>
    <div class="container mt-3 p-4 ">
        <h2 class=" text-center mb-3">Mission Skill</h2>
        <table class="table-responsive">
            <table class="table table-bordered">
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
                            <div>
                                <!-- <router-link :to="`/missionskill/${missionskill.skill_id}`" class="p-2 col border btn btn-primary">View</router-link> -->
                                <router-link :to="`/missionskill/${missionskill.skill_id}/edit`"
                                    class="btn btn-outline-warning rounded-pill mt-3 px-4">Edit</router-link>&nbsp;&nbsp;
                                <button @click="deleteMissionSkill(missionskill.skill_id)" type="button"
                                    class="btn btn-outline-danger rounded-pill mt-3 px-3">Delete</button>
                            </div>

                        </td>
                    </tr>
                </tbody>
            </table>
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
    async created() {
        try {
            const response = await axios.get('/api/missionskill');
            this.missionskills = response.data;
        } catch (error) {
            console.error(error);
        }
    },
    methods: {
        getStatusLabel(status) {
            return status == '1' ? 'Active' : 'Inactive';
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
