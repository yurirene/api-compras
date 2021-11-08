<template>
    <q-list bordered>
        <div  v-for="(categoria, i) in lista" :key="i">
            
            <q-separator />
            <q-item-label header class="bg-teal-1">
                <i class="las  la-lg la-bell"></i> {{categoria.categoria}}
            </q-item-label>
            <q-separator />
            
            <q-item clickable v-ripple  v-for="(item, j) in categoria.produtos" :key="j" @click="clicou(item.id);">
                <q-item-section>
                    {{ item.produto }}
                </q-item-section>
                <q-item-section avatar >
                    {{ item.quantidade }}
                </q-item-section>
                
            </q-item>
        </div>
        
    </q-list>
    
</template>
<script>
import { defineComponent } from 'vue'

export default defineComponent({
    name: 'List',
    props: {
        lista: {
            type: Array,
            required: true
        }
    },
    methods: {
        clicou: function(value) {
            this.$emit('clickLista', value);
        }
    }
})
</script>
