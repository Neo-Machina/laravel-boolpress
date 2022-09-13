<template>
    <div>
        <MainHeader />

        <main>
            <router-view></router-view>
        </main>
    </div>
</template>


<script>
import MainHeader from '../components/MainHeader.vue';

export default {
    name: 'App',
    components: {
        MainHeader
    }
    
}    
</script>
