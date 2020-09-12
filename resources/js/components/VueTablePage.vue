
<script>
export default {
    props: {
        total: {type: Number},
        perPage: {type: Number, default: 10},
        pageChanged:{type: Function},
        perPageChanged:{type: Function}
    },
    data() {
        return {
            current: 0,
            pages: 1
        }
    },
    created() {
        console.log(this.pageChanged);  // <---------- This will return undefined on production
        this.calPageCount();
    },
    methods: {
        setPage(page) {
            this.current = page;
            this.pageChanged({currentPage: this.current + 1});
        },
        previous() {
            if (this.current > 0)
                this.setPage(this.current - 1)
        },
        next() {
            if (this.current < this.pages)
                this.setPage(this.current + 1)
        },
        setPerPage(perPage) {
            this.perPage = perPage;
            this.calPageCount();
            this.perPageChanged({currentPerPage: this.perPage});
        },
        calPageCount() {
            if (this.total > this.perPage) {
                this.pages = Math.round(this.total / this.perPage);
                console.log(this.pages);
            }
            else {
                this.pages = 1
                this.setPage(0);
            }
        }
    }
}
</script>