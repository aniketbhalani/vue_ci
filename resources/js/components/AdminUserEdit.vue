<template>
    <div class="container-fluid px-4 mt-4">
        <div v-if="successMessage" class="alert alert-success mt-3">
            {{ successMessage }}
        </div>
        <div class="card">
            <div class="card-header">
                <h2 class="text-center">Edit User</h2>
            </div>
            <div class="card-body">
                <form @submit.prevent="submitForm">
                    <div class="form-row py-4">
                        <div class="form-check" v-for="avatarOption in avatarOptions" :key="avatarOption.value">
                            <input class="form-check-input" :value="avatarOption.value" type="radio" name="avatar"
                                :id="'avatar' + avatarOption.value" v-model="avatar"
                                :checked="avatarOption.value === avatar" />
                            <label class="form-check-label" :for="'avatar' + avatarOption.value">
                                <img class="rounded-circle" :src="getAvatarImagePath(avatarOption.image)"
                                    :alt="avatarOption.alt" />
                            </label>
                        </div>

                        <!-- Error handling for avatar field -->
                        <div class="text-danger" v-if="errors.avatar">
                            {{ errors.avatar[0] }}
                        </div>
                    </div>

                    <!-- First Name field -->
                    <div class="form-group">
                        <div class="row">
                            <div class=" col-lg-6 col-md-6">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" class="form-control" v-model="firstName" />
                                <div class="text-danger" v-if="errors.first_name">{{ errors.first_name[0] }}</div>
                            </div>
                            <div class=" col-lg-6 col-md-6">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" class="form-control" v-model="lastName" />
                                <div class="text-danger" v-if="errors.last_name">{{ errors.last_name[0] }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Email and Phone Number fields -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" v-model="email" />
                                <div class="text-danger" v-if="errors.email">{{ errors.email[0] }}</div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label for="phone_number">Phone Number</label>
                                <input type="tel" name="phone_number" class="form-control" v-model="phoneNumber" />
                                <div class="text-danger" v-if="errors.phone_number">{{ errors.phone_number[0] }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Password and Confirm Password fields -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" v-model="password" />
                                <div class="text-danger" v-if="errors.password">{{ errors.password[0] }}</div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label for="confirm_password">Confirm password</label>
                                <input type="password" name="confirm_password" class="form-control"
                                    v-model="confirmPassword" />
                                <div class="text-danger" v-if="errors.confirm_password">{{ errors.confirm_password[0] }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Employee ID and Department fields -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <label for="employee_id">Employee ID</label>
                                <input type="text" name="employee_id" class="form-control" v-model="employeeId" />
                                <div class="text-danger" v-if="errors.employee_id">{{ errors.employee_id[0] }}</div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label for="department">Department</label>
                                <input type="text" name="department" class="form-control" v-model="department" />
                                <div class="text-danger" v-if="errors.department">{{ errors.department[0] }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="profile_text">About You</label>
                                <textarea class="form-control" id="profile_text" v-model="profileText"></textarea>
                                <div class="text-danger" v-if="errors.profile_text">{{ errors.profile_text[0] }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- <div> -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <label for="country">Country</label>
                                <select name="country_id" class="form-control" id="country-dropdown"
                                    v-model="selectedCountryId" @change="fetchCities(selectedCountryId)">
                                    <option value="" disabled selected>Select Country</option>
                                    <option v-for="country in countries" :value="country.country_id"
                                        :selected="country.country_id === selectedCountryId" :key="country.country_id">
                                        {{ country.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label for="city">City</label>
                                <select class="form-control" name="city_id" id="city-dropdown" v-model="selectedCityId">
                                    <option v-if="!selectedCityId" value="" disabled>
                                        Select City
                                    </option>
                                    <option v-for="city in getCitiesForSelectedCountry" :value="city.city_id"
                                        :selected="city.city_id === selectedCityId" :key="city.city_id">
                                        {{ city.name }}
                                    </option>
                                </select>
                                <div class="text-danger" v-if="errors.city_id">{{ errors.city_id[0] }}</div>
                            </div>
                        </div>
                    </div>
                    <!-- Role and Status fields -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <label for="role">Role</label>
                                <select name="role" class="form-control" v-model="role">
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                                <div class="text-danger" v-if="errors.role">{{ errors.role[0] }}</div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label for="status">Status</label>
                                <select name="status" class="form-control" v-model="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <div class="text-danger" v-if="errors.status">{{ errors.status[0] }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- <button class="btn btn-warning pull-right" type="submit">
                <i class="fa-solid fa-plus text-black"></i> Add
            </button>
            <router-link :to="`/admin/user`" class="p-2 col border btn btn-success">Cancel</router-link> -->

                </form>
            </div>
            <div class="card-footer">
                <button class="btn btn-outline-warning rounded-pill mt-3 px-4 float-end" type="submit">
                    Update
                </button>
                <!-- <button type="submit" v-if="isNewCms"
                                class="btn btn-outline-warning rounded-pill mt-3 px-4 float-end">Add</button> -->
                <router-link :to="`/admin/user`"
                    class="btn btn-outline-secondary rounded-pill mt-3 px-3">Cancel</router-link>

                <!-- <button type="submit" v-else
                                class="btn btn-outline-warning rounded-pill mt-3 px-3 float-end">Update</button> -->
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            avatarOptions: [
                { value: "Images/volunteer1.png", image: "volunteer1.png", alt: "Volunteer 1" },
                { value: "Images/volunteer2.png", image: "volunteer2.png", alt: "Volunteer 2" },
                { value: "Images/volunteer3.png", image: "volunteer3.png", alt: "Volunteer 3" },
                { value: "Images/volunteer4.png", image: "volunteer4.png", alt: "Volunteer 4" },
                { value: "Images/volunteer5.png", image: "volunteer5.png", alt: "Volunteer 5" },
                { value: "Images/volunteer6.png", image: "volunteer6.png", alt: "Volunteer 6" },
                { value: "Images/volunteer7.png", image: "volunteer7.png", alt: "Volunteer 7" },
                { value: "Images/volunteer8.png", image: "volunteer8.png", alt: "Volunteer 8" },
                { value: "Images/volunteer9.png", image: "volunteer9.png", alt: "Volunteer 9" },

                // Add more avatar options as needed
            ],
            avatar: null,
            firstName: "",
            lastName: "",
            email: "",
            phoneNumber: "",
            password: "",
            confirmPassword: "",
            employeeId: "",
            department: "",
            role: "user",
            status: 1,
            profileText: "",
            selectedCountryId: null,
            selectedCityId: null,

            countries: [],
            cityDropdowns: [],
            errors: {},
            successMessage: '',
        };
    },
    methods: {
        getAvatarImagePath(image) {
            return "/Images/" + image;
        },
        submitForm() {
            this.errors = {};
            const formData = {
                avatar: this.avatar,
                first_name: this.firstName,
                last_name: this.lastName,
                email: this.email,
                phone_number: this.phoneNumber,
                password: this.password,
                confirm_password: this.confirmPassword,
                employee_id: this.employeeId,
                department: this.department,
                role: this.role,
                status: this.status,
                profile_text: this.profileText,
                country_id: this.selectedCountryId,
                city_id: this.selectedCityId,
            };
            // axios
            //   .post("/api/admin/user", formData)
            //   .then((response) => {
            //       this.successMessage = response.data.message;
            //       console.log(response.data.message);
            //   })
            //   .catch((error) => {
            //     if (error.response.status === 422) {
            //       this.errors = error.response.data.errors;
            //     } else {
            //       // Handle other types of errors
            //     }
            //   });
            axios
                .put(`/api/admin/user/${this.$route.params.id}`, formData)
                .then((response) => {
                    console.log(this.formData);
                    console.log(response.data.message);
                    this.successMessage = response.data.message;
                })
                .catch((error) => {
                    // Handle error
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        // Handle other types of errors
                    }
                });



        },
        fetchCities(countryId) {
            axios
                .post("/api/fetch-city", {
                    country_id: countryId,
                    _token: "{{ csrf_token() }}",
                })
                .then((response) => {
                    const index = this.cityDropdowns.length;
                    this.cityDropdowns.push({
                        selectedCityId: null,
                        cities: response.data.cities,
                    });
                    this.selectedCityId = null;
                })
                .catch((error) => {
                    // Handle error
                });
        },
    },
    computed: {
        getCitiesForSelectedCountry() {
            const index = this.cityDropdowns.length - 1;
            return this.cityDropdowns[index] ? this.cityDropdowns[index].cities : [];
        },
    },
    async created() {
        axios
            .get("/api/fetch-countries")
            .then((response) => {
                this.countries = response.data.countries;
            })
            .catch((error) => {
                // Handle error
            });

        axios
            .get(`/api/admin/user/${this.$route.params.id}`)
            .then((response) => {
                this.firstName = response.data.first_name;
                this.lastName = response.data.last_name;
                this.email = response.data.email;
                this.phoneNumber = response.data.phone_number;

                this.employeeId = response.data.employee_id;
                this.department = response.data.department;
                this.status = response.data.status;
                this.profileText = response.data.profile_text;
                this.selectedCountryId = response.data.country_id;
                this.selectedCityId = response.data.city_id;
                this.avatar = response.data.avatar;

                //console.log(this.avatarOptions.value);

                //console.log(this.formData);
            })
            .catch((error) => {
                console.log(error);
            });

        if (this.selectedCountryId) {
            this.fetchCities(this.selectedCountryId);
        }
    },
};
</script>


