<template>
    <v-app>
        <Header/>
        <v-main>
            <v-container class="pt-10">
                <slot name="content"/>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import Header from '../components/Header.vue'

export default {
    name: 'BaseLayout',
    components: {
        Header,
    },
}
</script>

<style scoped>
.pt-10 {
    padding-top: 40px;
}
</style>
