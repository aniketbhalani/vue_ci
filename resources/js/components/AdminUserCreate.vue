<template>
    <div class="container-fluid px-4 mt-4">
        <ul class="nav border-bottom">
            <span class="nav-link active fs-1"> User </span>
        </ul>
        <div v-if="successMessage" class="alert alert-success mt-3">
            {{ successMessage }}
        </div>
        <form @submit.prevent="submitForm">
            <div class="form-row py-4">
                <div class="form-check" v-for="avatarOption in avatarOptions" :key="avatarOption.value">
                    <input class="form-check-input" :value="avatarOption.value" type="radio" name="avatar"
                        :id="'avatar' + avatarOption.value" v-model="avatar" />
                    <label class="form-check-label" :for="'avatar' + avatarOption.value">
                        <img class="rounded-circle" :src="getAvatarImagePath(avatarOption.image)" :alt="avatarOption.alt" />
                    </label>
                </div>

                <div v-if="errors.avatar">
                    <div v-for="(error, index) in errors.avatar" :key="index" class="text-danger">
                        {{ error }}
                    </div>
                </div>
            </div>

            <!-- First Name field -->
            <div class="form-row">
                <div class="col-md-6">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" class="form-control" v-model="firstName" />
                    <div v-if="errors.first_name">
                        <div v-for="(error, index) in errors.first_name" :key="index" class="text-danger">
                            {{ error }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" class="form-control" v-model="lastName" />
                    <div v-if="errors.last_name">
                        <div v-for="(error, index) in errors.last_name" :key="index" class="text-danger">
                            {{ error }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email and Phone Number fields -->
            <div class="form-row">
                <div class="col-md-6">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" v-model="email" />
                    <div v-if="errors.email">
                        <div v-for="(error, index) in errors.email" :key="index" class="text-danger">
                            {{ error }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="phone_number">Phone Number</label>
                    <input type="tel" name="phone_number" class="form-control" v-model="phoneNumber" />
                    <div v-if="errors.phone_number">
                        <div v-for="(error, index) in errors.phone_number" :key="index" class="text-danger">
                            {{ error }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password and Confirm Password fields -->
            <div class="form-row">
                <div class="col-md-6">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" v-model="password" />
                    <div v-if="errors.password">
                        <div v-for="(error, index) in errors.passwrod" :key="index" class="text-danger">
                            {{ error }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="confirm_password">Confirm password</label>
                    <input type="password" name="confirm_password" class="form-control" v-model="confirmPassword" />
                    <div v-if="errors.confirm_password">
                        <div v-for="(error, index) in errors.confirm_password" :key="index" class="text-danger">
                            {{ error }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employee ID and Department fields -->
            <div class="form-row">
                <div class="col-md-6">
                    <label for="employee_id">Employee ID</label>
                    <input type="text" name="employee_id" class="form-control" v-model="employeeId" />
                    <div v-if="errors.employee_id">
                        <div v-for="(error, index) in errors.employee_id" :key="index" class="text-danger">
                            {{ error }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="department">Department</label>
                    <input type="text" name="department" class="form-control" v-model="department" />
                    <div v-if="errors.department">
                        <div v-for="(error, index) in errors.department" :key="index" class="text-danger">
                            {{ error }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label for="profile_text">About You</label>
                    <textarea class="form-control" id="profile_text" v-model="profileText"></textarea>
                    <div v-if="errors.profile_text">
                        <div v-for="(error, index) in errors.profile_text" :key="index" class="text-danger">
                            {{ error }}
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="form-row justify-content-start">
                    <div class="col-md-5">
                        <label for="country">Country</label>
                        <select name="country_id" class="form-control" id="country-dropdown" v-model="selectedCountryId"
                            @change="fetchCities(selectedCountryId)">
                            <option value="" disabled selected>Select Country</option>
                            <option v-for="country in countries" :value="country.country_id"
                                :selected="country.country_id === selectedCountryId" :key="country.country_id">
                                {{ country.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-5">
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
                        <div v-if="errors.city_id">
                            <div v-for="(error, index) in errors.city_id" :key="index" class="text-danger">
                                {{ error }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Role and Status fields -->
            <div class="form-row">
                <div class="col-md-6">
                    <label for="role">Role</label>
                    <select name="role" class="form-control" v-model="role">
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                    <div v-if="errors.role">
                        <div v-for="(error, index) in errors.role" :key="index" class="text-danger">
                            {{ error }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="status">Status</label>
                    <select name="status" class="form-control" v-model="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    <div v-if="errors.status">
                        <div v-for="(error, index) in errors.status" :key="index" class="text-danger">
                            {{ error }}
                        </div>
                    </div>
                </div>
            </div>

            <button class="btn btn-warning pull-right" type="submit">
                <i class="fa-solid fa-plus text-black"></i> Add
            </button>
            <!-- <a aria-label="cancel" class="btn mx-4 btn-secondary" href="/admin/user">Cancel</a> -->
            <router-link :to="`/admin/user`" class="p-2 col border btn btn-success">Cancel</router-link>
        </form>
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
            successMessage: ''
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
            axios
                .post("/api/admin/user", formData)
                .then((response) => {
                    this.successMessage = response.data.message;
                    console.log(response.data.message);
                })
                .catch((error) => {
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
        // Fetch cities on component mount if a country is already selected
        if (this.selectedCountryId) {
            this.fetchCities(this.selectedCountryId);
        }
    },
};
</script>
