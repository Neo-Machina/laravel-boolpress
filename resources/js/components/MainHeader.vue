<template>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li v-for="(link, index) in menuLinks" :key="index" class="nav-item">
                            <router-link :to="setRouteQuery(link.routeName)" class="nav-link">{{ link.label }}</router-link>
                        </li>

                        <li>
                            <a href="/admin" class="nav-link">Admin</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
export default {
    name: 'MainHeader',
    data() {
        return {
            menuLinks: [
                {
                    label: 'Home',
                    routeName: 'home'
                },
                {
                    label: 'About',
                    routeName: 'about'
                },
                {
                    label: 'Blog',
                    routeName: 'blog'
                },
                {
                    label: 'Contact',
                    routeName: 'contact'
                }
            ]
        }
    },
    methods: {
        setRouteQuery(routeName) {
            if(routeName == 'blog') {
                return { name: routeName, query: { page: 1 } };
            } 
            
            return { name: routeName };
            
        }
    }
}
</script>