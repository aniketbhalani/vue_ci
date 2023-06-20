<template>
    <div class="container-fluid mt-4 px-4">
        <div v-if="successMessage" class="alert alert-success mt-3">
            {{ successMessage }}
        </div>
        <div class="card">
            <div class="card-header">
                <h2 class="text-center mb-3">Mission Application</h2>
            </div>
            <div class="card-body">
                <!-- <table class="table table-responsive border-start border-end"> -->

                <table class="table-responsive">

                    <table class="table table-bordered">
                        <thead style="background-color: #F8F9FC">
                            <tr>
                                <th class="fs-5 py-4 px-3 font-weight-light" width="300px">Mission Title</th>
                                <th class="fs-5 py-4 font-weight-light" width="300px">Mission Id</th>
                                <th class="fs-5 py-4 font-weight-light" width="300px">User Id</th>
                                <th class="fs-5 py-4 font-weight-light" width="300px">User Name</th>
                                <th class="fs-5 py-4 font-weight-light" width="300px">Applied Date</th>
                                <th class="fs-5 py-4 font-weight-light text-center" width="300px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="mt in data" :key="mt.mission_application_id">
                                <td class="px-3">{{ mt.mission.title }}</td>
                                <td>{{ mt.mission.mission_id }}</td>
                                <td v-if="mt.user && mt.user.user_id">{{ mt.user.user_id }}</td>
                                <td>
                                    <template v-if="mt.user && mt.user.first_name && mt.user.last_name">
                                        {{ mt.user.first_name }} {{ mt.user.last_name }}
                                    </template>
                                </td>
                                <td>{{ mt.applied_at }}</td>
                                <td class="d-flex justify-content-center ">
                                    <span :id="'application_status_a_' + mt.mission_application_id"
                                        class="border rounded px-2 py-1 text-success border-success"
                                        v-if="mt.approval_status === 'APPROVE'">
                                        Accepted
                                    </span>

                                    <a :id="'application_a_' + mt.mission_application_id"
                                        @click="approveApplication(mt.mission_application_id)"
                                        v-if="mt.approval_status !== 'APPROVE'">
                                        <img src="../../../public/Images/correct-icon.svg" alt="hello"
                                            style="width: 20px; height: 20px;">
                                    </a>

                                    <span :id="'application_status_r_' + mt.mission_application_id"
                                        class="border rounded px-2 py-1 text-danger border-danger"
                                        v-if="mt.approval_status === 'DECLINE'">
                                        Rejected
                                    </span>

                                    <a :id="'application_r_' + mt.mission_application_id"
                                        @click="rejectApplication(mt.mission_application_id)"
                                        v-if="mt.approval_status !== 'DECLINE'">
                                        <img src="../../../public/Images/cancle-icon.svg" alt="hello"
                                            style="width: 20px; height: 20px;">
                                    </a>
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
import axios from "axios";
export default {
    data() {
        return {
            data: [], // Initialize the data array
            successMessage: '',
        };
    },
    async created() {
        // Fetch mission applications data from the backend API
        this.fetchMissionApplications();
    },
    methods: {
        fetchMissionApplications() {
            // Make an API request to fetch mission applications data
            // Adjust the URL endpoint based on your Laravel backend route
            axios.get('/api/admin/mission-applications').then((response) => {
                this.data = response.data; // Update the data array with the fetched data
            }).catch((error) => {
                console.error(error);
            });
        },
        approveApplication(applicationId) {
            // Make an API request to approve the mission application
            // Adjust the URL endpoint based on your Laravel backend route
            axios.get('/api/admin/approve-application', {
                params: {
                    mission_application_id: applicationId,
                },
            }).then((response) => {
                console.log(response.data);
                this.successMessage = response.data.message;
                // Update the application status in the frontend
                const application = this.data.find((mt) => mt.mission_application_id === applicationId);
                if (application) {
                    application.approval_status = 'APPROVE';
                }
            }).catch((error) => {
                console.error(error);
            });
        },
        rejectApplication(applicationId) {
            // Make an API request to reject the mission application
            // Adjust the URL endpoint based on your Laravel backend route
            axios.get('/api/admin/reject-application', {
                params: {
                    mission_application_id: applicationId,
                },
            }).then((response) => {
                console.log(response.data);
                this.successMessage = response.data.message;
                // Update the application status in the frontend
                const application = this.data.find((mt) => mt.mission_application_id === applicationId);
                if (application) {
                    application.approval_status = 'DECLINE';
                }
            }).catch((error) => {
                console.error(error);
            });
        },
    },
};
</script>
