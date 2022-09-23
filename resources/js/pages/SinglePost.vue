<template>
    <div class="container">
        <div v-if="single_post">
            <h1>{{ single_post.title }}</h1>

            <img class="w-25" v-if="single_post.cover" :src="single_post.cover" :alt="single_post.title">

            <div v-if="single_post.category"> 
                Category: {{ single_post.category.name }}
            </div>

            <div v-if="single_post.tags.length > 0">
                <span v-for="tag in single_post.tags" :key="tag.id" class="badge bg-success mr-2">{{ tag.name }}</span>
            </div>

            <div>{{ single_post.content }}</div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'SinglePost',
    data() {
        return {
            single_post: null
        }
    },
    mounted() {
        axios.get('/api/posts/' + this.$route.params.slug)
        .then((response) => {
            if(response.data.results) {
                this.single_post = response.data.results;
            } else {
                this.$router.push({name: 'notFound'});
            }
        })
    }
}
</script>