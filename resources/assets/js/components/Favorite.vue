<template>
    <div v-bind:class="classes">
        <span v-text="count"></span>
        <i class="fas fa-heart" @click="toggle" data-toggle="tooltip" data-placement="top" v-bind:title="title"></i>
    </div>
</template>

<script>
    export default {
        props:['model'],
        data() {
            return {
                count : this.model.favoritesCount,
                isFavorited : this.model.isFavorited
            }
        },
        computed : {
            classes() {
                return ['d-inline', this.isFavorited ? 'text-danger' : 'text-muted'];
            },
            title() {
                return this.isFavorited ? 'Unfavorite' : 'Favorite';
            }
        },
        methods: {
            toggle() {
                return this.isFavorited ? this.unfavorite() : this.favorite();
            },
            path() {
                return '/favorite/' + this.model.favoritedType + '/' + this.model.id
            },
            favorite() {
                axios.post(this.path()); 
                this.isFavorited = true;
                this.count++;
                flash('You have favorited a ' + this.type);
            },
            unfavorite() {
                axios.delete(this.path()); 
                this.isFavorited = false;
                this.count--;
                flash('You have unfavorited a ' + this.type);
            },
        }
    }
</script>