<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Booking Detail</div>

                        <div class="card-body">
                            ID: {{bookingDetail.id}}<br>
                            Pod Name: {{bookingDetail.pod_name}}<br>
                            User: {{bookingDetail.user_name}}<br>
                            Phone: {{bookingDetail.phone}}<br>
                            Price: {{bookingDetail.price}}<br>
                            Status: {{bookingDetail.status}}<br>
                            Booking Date: {{bookingDetail.booking_date}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data () {
        return {
            bookingId: null,
            bookingDetail: null,
            url: 'api/booking/1'
        }
    },
    beforeRouteEnter (to, from, next) {
        axios.get('api/booking/'+to.params.id).then(({ error, data }) =>
            next(vm => vm.setData(error, data))

        )
    },
    methods: {
        setData (err, data) {
            if (err) {
                this.error = err.toString()
            } else {
                this.bookingDetail = data.data
            }
        },
        getBookingDetail(){
            const fetchedId = this.$route.path.split( '/' );
            console.log(fetchedId)
            axios.get('api/booking/'+fetchedId[3]).then(({ data }) =>
                this.bookingDetail = data.data
            );
        },
    },
    created() {
        // this.getBookingDetail();
    },
    mounted() {
        // this.getBookingDetail(this.url);
        // this.url = 'api/booking/' + this.$route.params.id
    }
}
</script>
