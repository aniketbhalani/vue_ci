<template>
    <!-- <div> -->
    <div class="container mt-3 p-4 ">
        <h2 class=" text-center mb-3">Mission Theme</h2>
        <table class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>theme id</th>
                        <th>title</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="missiontheme in missionthemes" :key="missiontheme.mission_theme_id">
                        <td>{{ missiontheme.mission_theme_id }}</td>
                        <td>{{ missiontheme.title }}</td>
                        <td>{{ getStatusLabel(missiontheme.status) }}</td>

                        <td>
                            <div>
                                <!-- <router-link :to="`/missiontheme/${missiontheme.skill_id}`" class="p-2 col border btn btn-primary">View</router-link> -->
                                <router-link :to="`/missiontheme/${missiontheme.mission_theme_id}/edit`"
                                    class="btn btn-outline-warning rounded-pill mt-3 px-4">Edit</router-link>&nbsp;&nbsp;
                                <button @click="deleteMissionTheme(missiontheme.mission_theme_id)" type="button"
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
            return status == '1' ? 'Active' : 'Inactive';
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
