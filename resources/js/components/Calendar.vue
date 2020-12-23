<template>
    <div>
        <div v-for="month in events.months_and_days" :key="month.month_name">
            <h2 class="font-weight-bolder">{{ month.month_name }}</h2>

            <div
                v-for="(date, index) in month.dates"
                class="border-top border-bottom p-2"

                :class="{'bg-success': date.active}"
                :key="index">

                <div class="row">
                    <div class="col-md-2">
                        {{ date.date }}
                    </div>
                    <div class="col-md-10">
                        <span v-if="date.active">{{ date.name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            events: {
                type: Object,
                default: {
                    events: [],
                    months_and_days: [{
                        month_name: '',
                        dates: []
                    }]
                }
            }
        },

        data() {
            return {

            }
        },

        methods: {},
    }
</script>
