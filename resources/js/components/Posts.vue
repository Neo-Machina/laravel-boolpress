<template>
    <section>
        <div class="container">
            <h1 class="mt-3">Posts List</h1>

            <div class="row row-cols-3">
                <div v-for="post in posts" :key="post.id" class="col mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ post.title }}</h5>
                            <p class="card-text">{{ cutText(post.content) }}</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: 'Posts',
    data() {
        return {
            posts: []
        };
    },
    methods: {
        getPosts() {
            axios.get('http://127.0.0.1:8000/api/posts')
            .then((response) => {
                this.posts = response.data.results;
            });
        },
        cutText(text) {
            if(text.length > 100) {
                return text.slice(0, 100) + '...';
            } 
            return text;
        }
    },
    mounted() {
        this.getPosts();
    }
}
</script>