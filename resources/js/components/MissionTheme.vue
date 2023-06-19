<template>
    <!-- <div> -->
    <div class="container-fluid mt-3 px-4 ">

        <div class="card ">
            <div class="card-header">
                <h2 class=" text-center mb-3">Mission Theme</h2>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="relative max-w-xs">
                        <!-- <form class="m-0" action="{{ route('cmspage.index') }}" method="GET"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="rb">
                                <div class="input-group">
                                    <span class="input-group-text rbc">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M23.111 20.058l-4.977-4.977c.965-1.52 1.523-3.322 1.523-5.251 0-5.42-4.409-9.83-9.829-9.83-5.42 0-9.828 4.41-9.828 9.83s4.408 9.83 9.829 9.83c1.834 0 3.552-.505 5.022-1.383l5.021 5.021c2.144 2.141 5.384-1.096 3.239-3.24zm-20.064-10.228c0-3.739 3.043-6.782 6.782-6.782s6.782 3.042 6.782 6.782-3.043 6.782-6.782 6.782-6.782-3.043-6.782-6.782zm2.01-1.764c1.984-4.599 8.664-4.066 9.922.749-2.534-2.974-6.993-3.294-9.922-.749z" />
                                        </svg>
                                    </span>
                                    <input type="text" name="s" value="{{ request()->input('s') }}"
                                        placeholder="search" class="form-control rbc">
                                </div>
                            </div>
                        </form> -->
                    </div>
                    <router-link :to="`/missiontheme/create`"
                        class="btn btn-outline-warning rounded-pill mt-1 px-4">Add</router-link>
                </div>
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
        </div>
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
