<template>
    <section>
        <div class="container">
            <h2 class="mt-3 mb-3">Posts List</h2>

            <div class="row row-cols-3">
                <div v-for="post in posts" :key="post.id" class="col mb-4">
                    <PostContent  :post="post"/>
                </div>
            </div>

            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item" :class="{ disabled: $route.query.page == 1 }">
                        <a class="page-link" href="#" @click.prevent="changePageQuery(+$route.query.page - 1)">Previous</a>
                    </li>
                    <li v-for="page in last_page" :key="page" class="page-item" :class="{ active: page === $route.query.page }">
                        <a class="page-link" href="#" @click.prevent="changePageQuery(page)">{{ page }}</a>
                    </li>
                    <li class="page-item" :class="{ disabled: $route.query.page == last_page }">
                        <a class="page-link" href="#" @click.prevent="changePageQuery(+$route.query.page + 1)">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </section>
</template>

<script>
import PostContent from './PostContent.vue';

export default {
    name: 'Posts',
    components: {
        PostContent
    },
    data() {
        return {
            posts: [],
            last_page: null,
        };
    },
    methods: {
        getPosts() {
            axios.get('/api/posts', {
                params: {
                    page: this.$route.query.page
                }
            })
            .then((response) => {
                this.posts = response.data.results.data;
                this.last_page = response.data.results.last_page;
            });
        },
        changePageQuery(numberPage) {
            this.$router.replace({name: 'blog', query: {page: numberPage}});

            this.getPosts();
        }
    },
    mounted() {
        this.getPosts();
    }
}
</script>