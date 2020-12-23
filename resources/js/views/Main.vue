<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h3>Calendar</h3>
            </div>
            <div class="card-body">

            </div>
        </div>
    </div>
</template>

<script>

export default {

    props: [],

    data() {

        return {}

    },

    mounted() {
        this.getEvents()
    },

    methods: {
        getEvents(){
            axios.get('/api/events')
                .then(({data}) => console.log(data));
        },
    },

}

</script>

<style scoped>

</style>
