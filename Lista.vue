<template>
    <div >
        <q-page padding>
            <q-card class="my-card q-mb-md">
                <q-item>
                    <q-item-section>
                        <q-item-label>Adicionar Item na Lista</q-item-label>
                    </q-item-section>
                </q-item>

                <q-separator />
                <q-card-section>
                    <q-form ref="formulario"> 
                        <q-select 
                            rounded outlined 
                            v-model="tipo" 
                            :options="categorias" 
                            label="Categoria" 
                            class="q-mb-sm" 
                            @update:model-value="categoriaSelecionada()"
                            :rules="[val => !!val || 'Este campo é obrigatório']" 
                        />
                        <q-select 
                            rounded outlined 
                            v-model="nome" 
                            :options="produtos" 
                            label="Produto" 
                            class="q-mb-sm"
                            :rules="[val => !!val || 'Este campo é obrigatório']" 
                        />
                        <q-input 
                            rounded outlined 
                            v-model.number="quantidade" 
                            type="number"
                            label="Quantidade"  
                            class="q-mb-sm"
                            :rules="[val => !!val || 'Este campo é obrigatório']"  
                        />
                    </q-form>
                    <q-btn :loading="loading"  class="full-width" icon-right="send" label="Adicionar" color="primary" @click="adicionarNaLista()"/>
                </q-card-section>
            </q-card>
            
            <list :lista="lista"  @clickLista="clicou"></list>
            
            <q-dialog v-model="modal.show" :position="modal.position">
                <q-card style="width: 350px" :class="modal.classe">
                    <q-card-section class="text-white text-center">
                        {{ modal.texto}}
                    </q-card-section>
                </q-card>
            </q-dialog>
            <q-dialog v-model="confirm" persistent>
                <q-card>
                    <q-card-section class="row items-center">
                        <q-avatar icon="close" color="negative" text-color="white" />
                        <span class="q-ml-sm">Deseja Remover o Item da Lista?</span>
                    </q-card-section>

                    <q-card-actions align="right">
                        <q-btn flat label="Não" color="primary" v-close-popup @click="this.id_exclusao=0" />
                        <q-btn flat label="Confirmar" color="primary" v-close-popup @click="excluir(this.id_exclusao)" :loading="loading" />
                    </q-card-actions>
                </q-card>
            </q-dialog>
        </q-page>
    </div>
</template>
<script>

import { api } from 'boot/axios'
import List from 'src/components/List.vue';


export default {
  components: { List },
    data() {
        return {
            nome: null,
            tipo: null,
            quantidade: null,
            categorias: [],
            produtos: [],
            loading: false,
            modal: { 
                show: false,
                position: 'top',
                classe: '',
                texto: ''
            },
            lista: [],
            confirm: false,
            id_exclusao: 0
        }
    },
    methods: {
        adicionarNaLista: function () {
            this.loading = true;
            this.$refs.formulario.validate()
            .then((sucesso) => {
                if (sucesso) {
                    const dados = new FormData()
                    dados.append('produto_id', this.nome.value)
                    dados.append('quantidade', this.quantidade)

                    api.post('/api/lista', dados)
                        .then((response) => {
                            this.loading = false;
                            if (response.status == 200) {
                                this.modal.show = true;
                                this.modal.classe = 'bg-positive';
                                this.modal.texto = response.data.message;
                            } else {
                                this.modal.show = true;
                                this.modal.classe = 'bg-negative';
                                this.modal.texto = response.data.message;
                            }
                            this.getLista();
                        });

                    setTimeout(() => {
                       this.modal.show = false;
                    }, 2000);
                }
            })
        },
        categoriaSelecionada: function () {
            api.get('api/produtos/' + this.tipo.value)
            .then((response) => {
                this.produtos = response.data;
            })
        },
        getLista: function() {
            api.get('api/lista')
            .then((response) => {
                this.lista = response.data
            });
        },
        clicou: function(value) {
            this.id_exclusao = value;
            this.confirm = true;
        },
        excluir: function(value) {
            this.loading = true;
            const dados = new FormData();
            dados.append('produto_id', value)
            api.post('/api/excluir-produto-lista', dados)
                .then((response) => {
                    this.loading = false;
                    if (response.status == 200) {
                        this.modal.show = true;
                        this.modal.classe = 'bg-positive';
                        this.modal.texto = response.data.message;
                    } else {
                        this.modal.show = true;
                        this.modal.classe = 'bg-negative';
                        this.modal.texto = response.data.message;
                    }
                    this.getLista();
                });

            setTimeout(() => {
                this.modal.show = false;
            }, 2000);
        }
    },
    mounted() {
        api.get('api/categorias')
        .then((response) => {
            this.categorias = response.data
        });

        this.getLista();
    }
}
</script>