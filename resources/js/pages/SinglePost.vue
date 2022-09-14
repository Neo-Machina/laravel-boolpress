<template>
    <div class="container">
        <h1>Single post</h1>

        {{ $route.params.slug }}
    </div>
</template>

<script>
export default {
    name: 'SinglePost',
    data() {
        return {

        }
    },
    mounted() {
        axios.get()
    }
}
</script>