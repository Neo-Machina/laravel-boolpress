<template>
    <div class="card h-100">
        <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ post.title }}</h5>

            <img class="w-50 middle mx-auto d-block" v-if="post.cover" :src="post.cover" :alt="post.title">

            <p class="card-text flex-grow-1">{{ cutText(post.content) }}</p>
          
            <router-link :to="{ name: 'post', params: {slug: post.slug} }" class="btn btn-primary w-25">Read</router-link>        
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