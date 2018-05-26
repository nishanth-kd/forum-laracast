<template>
    <div class="links">
        <nav-item v-on:toggle-nav="toggleNav" v-bind:key="link.src" v-bind:src="link.src"  v-bind:text="link.text" v-for="link in links"></nav-item>
    </div>
</template>
<script>
export default {
    props: ['links'],
    methods: {
        toggleNav () {
            console.log('toggle-nav:navitgation');
            this.$emit('toggle-nav');
        }
    }
}
</script>
