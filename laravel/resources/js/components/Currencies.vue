<template>
    <div>

        <b-row>
            <b-col md="6" class="my-1">
                <b-form-group horizontal label="Filter" class="mb-0">
                    <b-input-group>
                        <b-form-input v-model="filter" placeholder="Type to Search"/>
                        <b-input-group-append>
                            <b-btn :disabled="!filter" @click="filter = ''">Clear</b-btn>
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>
            </b-col>
        </b-row>

        <b-table :sort-by.sync="sortBy"
                 :sort-desc.sync="sortDesc"
                 :items="items"
                 :filter="filter"
                 :fields="fields">

        </b-table>

        <p>
            Sorting By: <b>{{ sortBy }}</b>,
            Sort Direction: <b>{{ sortDesc ? 'Descending' : 'Ascending' }}</b>
        </p>
    </div>
</template>

<style>
    .text-green {
        color: darkgreen;
    }

    .text-red {
        color: darkred;
    }

    .text-gray {
        color: dimgray;
    }
</style>

<script>
    import {Datatable} from 'bootstrap';

    export default {
        name: 'Currencies',
        data() {
            return {
                filter: null,
                sortBy: 'change24h',
                sortDesc: true,
                fields: [
                    {key: 'name', sortable: true},
                    {key: 'avg', sortable: true},
                    {key: 'change24h', sortable: true},
                ],
                items: []
            };
        },
        methods: {
            getTable: async function () {
                try {
                    const {data} = await this.$http.get(`${this.API}/crypto/table`);

                    data.forEach(function (element) {

                        element._cellVariants = [];

                        // switch(true) better here, but people do not like it
                        if (element.avg < element.avg_prev) {
                            element._cellVariants.avg = 'danger';
                        } else if (element.avg === element.avg_prev) {
                            element._cellVariants.avg = 'default';
                        } else if (element.avg > element.avg_prev) {
                            element._cellVariants.avg = 'success';
                        }

                        if (element.change24h < element.change24h_prev) {
                            element._cellVariants.change24h = 'danger';
                        } else if (element.change24h === element.change24h_prev) {
                            element._cellVariants.change24h = 'default';
                        } else if (element.change24h > element.change24h_prev) {
                            element._cellVariants.change24h = 'success';
                        }
                    });

                    this.items = data;
                    console.log(data);
                } catch (error) {
                    console.error(error);
                }
            },
        },
        components: {
            'datatable': Datatable,
        },
        mounted() {
            this.getTable();

            setInterval(function () {
                this.getTable();
            }.bind(this), 3000);
        },
    }
</script>
