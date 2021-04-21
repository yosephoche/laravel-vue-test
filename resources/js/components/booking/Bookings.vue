<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
              <span class="block text-gray-600 text-sm text-left font-bold mb-2"
              >Booking Date</span
              >
              <v-date-picker v-model="range" is-range :masks="masks">
                  <template v-slot="{ inputValue, inputEvents }">
                      <input
                          class="px-2 py-1 border rounded focus:outline-none focus:border-blue-300"
                          :value="inputValue.start"
                          v-on="inputEvents.start"
                      />

                      <input
                          class="px-2 py-1 border rounded focus:outline-none focus:border-blue-300"
                          :value="inputValue.end"
                          v-on="inputEvents.end"
                      />
                  </template>
              </v-date-picker>
              <button type="button" class="btn btn-sm btn-primary" @click="filterBookingDate">
                  <i class="fa fa-plus-square"></i>
                  Filter
              </button>
              <div>
                  <vue-good-table
                      :columns="columns"
                      :rows="rows"
                      :pagination-options="{
                          enabled: true
                      }"
                      perPage="perPage"
                      @on-per-page-change="onPageChange"
                  >
                      <template slot="table-row" slot-scope="props">
                          <span v-if="props.column.field == 'pod_name'">
                              <router-link v-bind:to="'/booking/detail/' + props.row.id">{{props.row.pod_name}}</router-link>
<!--                              <router-link :to="{ path: '/booking/detail/' + props.row.id, params: {id: props.row.id } }">{{props.row.pod_name}}</router-link>-->
                          </span>
                          <span v-else>
                              {{props.formattedRow[props.column.field]}}
                          </span>
                      </template>
                  </vue-good-table>

              </div>


            <!-- /.card -->
          </div>
        </div>

    </div>
  </section>
</template>

<script>
    import Vue from 'vue'

    import Calendar from 'v-calendar/lib/components/calendar.umd'
    import DatePicker from 'v-calendar/lib/components/date-picker.umd'

    import 'vue-good-table/dist/vue-good-table.css'
    import { VueGoodTable } from 'vue-good-table';

    import VCalendar from 'v-calendar'
    Vue.use(VCalendar)
    export default {

      components: {
          VueGoodTable,
          Calendar,
          DatePicker,
      },
        columnFilterFn: function(data, filterString) {
            const x = parseInt(filterString);
            return data >= x - 3 && data <= x + 3;
        },
        data () {
            return {
                range: {
                    start: new Date(2021, 0, 6),
                    end: new Date(2021, 0, 23),
                },
                masks: {
                    input: 'YYYY-MM-DD',
                },
                showDropdowns: true,
                perPage: 10,

                columns: [
                    {
                        label: 'ID',
                        field: 'id',
                    },
                    {
                        label: 'Pod Name',
                        field: 'pod_name',
                        // type: 'number',
                        filterOptions: {
                            styleClass: 'class1', // class to be added to the parent th element
                            enabled: true, // enable filter for this column
                            placeholder: 'Filter Pod Name', // placeholder for filter input
                            // filterValue: 'Jane', // initial populated value for this filter
                            // filterDropdownItems: [], // dropdown (with selected values) instead of text input
                            filterFn: this.columnFilterFn, //custom filter function that
                            // trigger: 'enter', //only trigger on enter not on keyup
                        },
                    },
                    {
                        label: 'User',
                        field: 'user_name',
                        // type: 'number',
                    },
                    {
                        label: 'Phone',
                        field: 'phone',
                        // type: 'number',
                    },
                    {
                        label: 'Status',
                        field: 'status',
                        // type: 'number',
                        filterOptions: {
                            styleClass: 'class1', // class to be added to the parent th element
                            enabled: true, // enable filter for this column
                            placeholder: 'Filter Status', // placeholder for filter input
                            // filterValue: 'Jane', // initial populated value for this filter
                            filterDropdownItems: ['Active', 'In-Active'], // dropdown (with selected values) instead of text input
                            // filterFn: this.columnFilterFn, //custom filter function that
                            // trigger: 'enter', //only trigger on enter not on keyup
                        },
                    },
                    {
                        label: 'Price',
                        field: 'price',
                        type: 'number',
                    },
                    {
                        label: 'Booking Date',
                        field: 'booking_date',
                        type: 'date',
                        dateInputFormat: 'yyyy-MM-dd',
                        dateOutputFormat: 'MMM do yy',
                    },

                ],
                rows: []
            }
        },
        methods: {
          filterBookingDate() {
              let startDate = this.range.start.toISOString()
              let endDate = this.range.end.toDateString()
              console.log(startDate)
              axios.get('api/booking?start_date=' + startDate + '&end_date=' + endDate)
                  .then(({ data }) => (this.rows = data.data));
          },

          onPageChange(params) {
              this.perPage = params.currentPerPage
          },

          getResults(page = 1) {
              console.log(this.dateRange)
              this.$Progress.start();

              axios.get('api/booking?page=' + page).then(({ data }) => (this.bookings = data.data));

              this.$Progress.finish();
          },
          loadProducts(){

            // if(this.$gate.isAdmin()){
            //   axios.get("api/booking").then(({ data }) => (this.bookings = data.data));
              axios.get("api/booking").then(({ data }) => (this.rows = data.data));
            // }
          },
        },
        mounted() {

        },
        created() {
            this.$Progress.start();

            this.loadProducts();

            this.$Progress.finish();
        },
        filters: {
            truncate: function (text, length, suffix) {
                return text.substring(0, length) + suffix;
            },
        },
        computed: {
          dates() {
              return this.days.map(day => day.date);
          },
          filteredItems() {
            return this.autocompleteItems.filter(i => {
              return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
            });
          },
        },
    }
</script>
