<template>
    <a href="#" v-on:click="toggleNav" v-text="text"></a> 
    <!-- v-bind:href="src" -->
</template>
<script>
export default {
    props: ['src', 'text'],
    methods: {
        toggleNav () {
            console.log('toggle-nav:nav-item');
            this.$emit('toggle-nav');
        }
    }
}
</script>
