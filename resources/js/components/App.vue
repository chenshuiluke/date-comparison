<template>
    <div class="card">
        <div class="card-content">
            <p class="title is-4">Please enter two dates.</p>
            <b-field label="First Date">
                <b-datepicker
                    v-model="date_one"
                    :show-week-number="true"
                    placeholder="Click to select..."
                    icon="calendar-today"
                    trap-focus>
                </b-datepicker>
            </b-field>

            <b-field label="Second Date">
                <b-datepicker
                    v-model="date_two"
                    :show-week-number="true"
                    placeholder="Click to select..."
                    icon="calendar-today"
                    trap-focus>
                </b-datepicker>
            </b-field>
            <b-button type="is-link" :disabled="!isFormValid" v-on:click="submit">Submit</b-button>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import * as moment from 'moment';
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                date_one: null,
                date_two: null
            };
        },
        computed: {
            isFormValid: function() {
                console.log("here");
                return this.date_one != null && this.date_two != null;
            }
            
        },
        methods: {
            submit() {
                const format_str = 'M/D/YYYY';
                axios.get(`/api/calculate`, {
                    params: {
                        date_one: moment(this.date_one).format(format_str),
                        date_two: moment(this.date_two).format(format_str)
                    }
                })
                .then((response) => {
                    alert("The number of days between the two dates is: " + response.data.result);
                })
                .catch((err) => {
                    alert("An error has taken place. Please recheck your connection or try again later.")
                });
            }
        }
    }
</script>
