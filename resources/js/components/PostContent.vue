<template>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ post.title }}</h5>
            <p class="card-text">{{ cutText(post.content) }}</p>
            <router-link :to="{ name: 'post', params: {slug: post.slug} }" class="btn btn-primary">Read</router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: 'PostContent',
    props: {
        post: Object
    },
    methods: {
        cutText(text) {
            if(text.length > 100) {
                return text.slice(0, 100) + '...';
            } 
            return text;
        }
    }
}
</script>