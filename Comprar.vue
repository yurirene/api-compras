<template>
    <list :lista="lista"></list>
</template>

<script>
import List from 'src/components/List.vue';
import { api } from 'boot/axios';
import { defineComponent } from 'vue';

export default defineComponent({
    components: { List },
    name: 'PageCompras',
    data() {
        return {
            lista: []
        }
    },
    methods: {
        getLista: function() {
            api.get('api/lista')
            .then((response) => {
                this.lista = response.data
            });
        }
    },
    mounted() {
        this.getLista();
    }
});
</script>
