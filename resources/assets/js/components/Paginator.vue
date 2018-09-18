<template>
    <ul class="pagination" v-if="shouldPaginate">
        <li class="page-item" v-show="prevUrl">
        <a class="page-link" href="#" aria-label="Previous" @click.prevent="prev">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
        </a>
        </li> 
        <li class="page-item" v-show="nextUrl">
        <a class="page-link" href="#" aria-label="Next" @click.prevent="next">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
        </a>
        </li>
    </ul> 
</template>

<script>
export default {
    props: ['dataSet'],
    data() {
        return {
            page: 1,
            prevUrl: false,
            nextUrl: false,
        }
    },
    watch: {
        dataSet() {
            this.page = this.dataSet.current_page,
            this.prevUrl = this.dataSet.prev_page_url,
            this.nextUrl = this.dataSet.next_page_url
        },
    },
    computed: {
        shouldPaginate() {
            return !! this.prevUrl || !! this.nextUrl;
        }
    },
    methods: {
        broadcast(page) {
            this.$emit('updated', page).refreshURL();
        },
        next() {
            this.broadcast(++this.page);
        },
        prev() {
            this.broadcast(--this.page);
        },
        refreshURL() {
            history.pushState(null, null, '?page=' + this.page);
        }
    }
};
</script>

