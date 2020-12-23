<template>
    <div>
        <form @submit.prevent="submitEvent">
            <div class="form-group">
                <label for="eventName">Event</label>
                <input type="text" class="form-control" id="eventName">
            </div>
            <div class="form-row">
                <div class="col">
                    <label for="fromDate">From</label>
                    <input type="date" class="form-control" id="fromDate">
                </div>
                <div class="col">
                    <label for="toDate">To</label>
                    <input type="date" class="form-control" id="toDate">
                </div>
            </div>
            <div class="form-check form-check-inline mt-3" v-for="day in days" :key="day.name">
                <input
                    v-model="event.days"
                    type="checkbox"
                    class="form-check-input"

                    :id="day.name"
                    :value="day.value">

                <label class="form-check-label" :for="day.name">{{ day.name }}</label>
            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data() {

            return {
                days: [
                    {
                        name: 'Sun',
                        value: 0
                    },
                    {
                        name: 'Mon',
                        value: 1
                    },
                    {
                        name: 'Tue',
                        value: 2
                    },
                    {
                        name: 'Wed',
                        value: 3
                    },
                    {
                        name: 'Thu',
                        value: 4
                    },
                    {
                        name: 'Fri',
                        value: 5
                    },
                    {
                        name: 'Sat',
                        value: 6
                    },
                ],

                event: {
                    to: '',
                    from: '',
                    days: [],
                    name: '',
                }
            }

        },

        methods: {
            submitEvent(){
                console.log('submit event')
            },
        },
    }
</script>

<style scoped>

</style>
