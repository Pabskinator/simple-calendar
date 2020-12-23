<template>
    <div>
        <form @submit.prevent="submitEvent">

            <div class="form-group">
                <label for="name">Event</label>
                <input
                    v-model="form.name"
                    id="name"
                    name="name"
                    type="text"
                    class="form-control"

                    :class="{'is-invalid': form.errors.has('name')}"

                    @keydown="form.errors.clear('name')">

                <span
                    v-text="form.errors.get('name')"
                    v-if="form.errors.has('name')"
                    class="text-danger">

                </span>
            </div>
            <div class="form-row">
                <div class="col">
                    <label for="from">From</label>
                    <input
                        v-model="form.from"
                        id="from"
                        name="from"
                        type="date"
                        class="form-control"

                        :class="{'is-invalid': form.errors.has('from')}"

                        @input="form.errors.clear('from')">

                    <span
                        v-text="form.errors.get('from')"
                        v-if="form.errors.has('from')"
                        class="text-danger">

                    </span>
                </div>

                <div class="col">
                    <label for="to">To</label>
                    <input
                        v-model="form.to"
                        id="to"
                        name="to"
                        type="date"
                        class="form-control"

                        :class="{'is-invalid': form.errors.has('to')}"

                        @input="form.errors.clear('to')">

                    <span
                        v-text="form.errors.get('to')"
                        v-if="form.errors.has('to')"
                        class="text-danger">

                    </span>
                </div>
            </div>
            <div class="mt-3">
                <div class="p-2" :class="{'border border-danger': form.errors.has('days')}">
                    <div class="form-check form-check-inline" v-for="day in days" :key="day.name">
                        <input
                            v-model="form.days"
                            type="checkbox"
                            class="form-check-input"

                            :id="day.name"
                            :value="day.value"

                            @input="form.errors.clear('days')">

                        <label class="form-check-label" :for="day.name">{{ day.name }}</label>
                    </div>
                </div>

                <div>
                    <span
                        v-text="form.errors.get('days')"
                        v-if="form.errors.has('days')"
                        class="text-danger">

                    </span>
                </div>
            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</template>

<script>
    import { alertMixin } from "../mixins/alertMixin";

    export default {
        mixins: [alertMixin],
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

                form: new Form({
                    to: '',
                    from: '',
                    days: [],
                    name: '',
                })
            }
        },

        methods: {
            submitEvent(){
                this.form
                    .post('/api/events')
                    .then(response => {
                        this.$emit('added')
                        this.showToast('', 'Event successfully saved!', 'success')
                        console.log(response);
                    })
                    .catch(error => {
                        console.log(error);
                        this.showToast('', 'Event not saved!', 'error')
                    })
            },
        },
    }
</script>

<style scoped>

</style>
