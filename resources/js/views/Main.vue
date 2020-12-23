<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4 class="font-weight-bolder">Calendar</h4>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <AddEvent></AddEvent>
                        </div>
                        <div class="col-md-9 mt-3">
                            <Calendar :events="events"></Calendar>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Calendar from "../components/Calendar";
    import AddEvent from "../components/AddEvent";

    export default {
        components: {
            Calendar, AddEvent
        },

        data() {
            return {
                events: {},
            }
        },

        mounted() {
            this.getEvents()
        },

        methods: {
            getEvents() {
                axios.get('/api/events')
                    .then(response => {
                        this.events = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        },
    }
</script>
