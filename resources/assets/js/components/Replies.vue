<template> 
    <div>
        <div v-for="(reply, index) in items" :key='reply.id'>
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>
        <br>
        <paginator :dataSet="dataSet" @updated="fetch"></paginator>
        <br>
        <new-reply :endpoint="this.endpoint" @posted="add"></new-reply>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import NewReply from '../components/NewReply.vue';
    import collection from '../mixins/collection.js';
    export default {
        props: ['endpoint'],
        components : { Reply, NewReply },
        mixins: [collection],
        data() {
            return {
                dataSet: false,
            }
        },
        created() {
            this.fetch();
        },
        methods: {
            url(page) {
                if(!page) {
                    let query = location.search.match(/page=(\d+)/);

                    page = query ? query[1] : 1;
                }
                return this.endpoint + '?page=' + page;
            },
            fetch(page) {
                axios.get(this.url(page))
                    .then(this.refresh);
            },
            refresh({data}) {
                this.dataSet = data;
                this.items = data.data;
                window.scrollTo(0,0);
            }
        }
    }
</script>

