<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                
                <!-- início do card de busca -->
                <card-component titulo="Busca de Pedidos">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component titulo="Número Pedido" id="inputId" id-help="idHelp" >
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                                </input-container-component>                   
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="Status Pedido" id="inputStatus" id-help="statusHelp" >
                                    <select type="select" class="form-control" id="inputStatus" aria-describedby="statusHelp" placeholder="Status do Pedido" v-model="busca.status">
                                        <option value="solicitado">Solicitado</option>
                                        <option value="aprovado">Aprovado</option>
                                        <option value="cancelado">Cancelado</option>
                                    </select>
                                </input-container-component>
                            </div>
                        </div>
                    </template>
                    
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button>
                    </template>
                </card-component>
                <!-- fim do card de busca -->


                <!-- início do card de listagem de pedidos -->
                <card-component titulo="Listagem de Pedidos">
                    <template v-slot:conteudo>
                        <table-component 
                            :dados="pedidos.data"
                            :visualizar="{visivel: false}"
                            :atualizar="{visivel: false}"
                            :aprovar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalAprovarPedido'}"
                            :cancelar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalCancelarPedido'}"
                            :titulos="{
                                id: {titulo: 'Num. Pedido', tipo: 'texto'},
                                nome: {titulo: 'Nome Cliente', tipo: 'texto'},
                                data_ida: {titulo: 'Data Ida', tipo: 'texto'},
                                data_volta: {titulo: 'Data Volta', tipo: 'texto'},
                                destino: {titulo: 'Destino', tipo: 'texto'},
                                status: {titulo: 'Status', tipo: 'texto'},
                            }"
                        ></table-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li v-for="l, key in pedidos.links" :key="key" 
                                        :class="l.active ? 'page-item active' : 'page-item'" 
                                        @click="paginacao(l)"
                                    >
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>

                        </div>
                    </template>
                </card-component>
                <!-- fim do card de listagem de pedidos -->
            </div>
        </div>        

        <!-- início do modal de visualização de pedido -->
        <modal-component id="modalAprovarPedido" titulo="Aprovar Pedido">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Nome do Passageiro" id="atualizarNome" id-help="atualizarNomeHelp">
                        <input type="text" class="form-control" id="atualizarNome" aria-describedby="atualizarNomeHelp" placeholder="Nome do Passageiro" v-model="$store.state.item.nome" disabled>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Data Ida" id="atualizarDataIda" id-help="atualizarDataIdaHelp">
                        <input type="text" class="form-control" id="atualizarDataIda" aria-describedby="atualizarDataIdaHelp" placeholder="Data Ida" v-model="$store.state.item.data_ida" disabled>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Data Volta" id="atualizarDataVolta" id-help="atualizarDataVoltaHelp">
                        <input type="text" class="form-control" id="atualizarDataVolta" aria-describedby="atualizarDataVoltaHelp" placeholder="Nome do Passageiro" v-model="$store.state.item.data_volta" disabled>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Destino da Viagem" id="destino" id-help="destinoHelp">
                        <input type="text" class="form-control" id="destino" aria-describedby="destinoHelp" placeholder="Destino Desejado" v-model="$store.state.item.destino" disabled>
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="aprovarOuCancelar('aprovado')">Aprovar</button>
            </template>
        </modal-component>
        <!-- fim do modal de visualização de pedido -->

        <!-- início do modal de atualização de pedido -->
        <modal-component id="modalCancelarPedido" titulo="Cancelar Pedido">

            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Nome do Passageiro" id="atualizarNome" id-help="atualizarNomeHelp">
                        <input type="text" class="form-control" id="atualizarNome" aria-describedby="atualizarNomeHelp" placeholder="Nome do Passageiro" v-model="$store.state.item.nome" disabled>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Data Ida" id="atualizarDataIda" id-help="atualizarDataIdaHelp">
                        <input type="text" class="form-control" id="atualizarDataIda" aria-describedby="atualizarDataIdaHelp" placeholder="Data Ida" v-model="$store.state.item.data_ida" disabled>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Data Volta" id="atualizarDataVolta" id-help="atualizarDataVoltaHelp">
                        <input type="text" class="form-control" id="atualizarDataVolta" aria-describedby="atualizarDataVoltaHelp" placeholder="Nome do Passageiro" v-model="$store.state.item.data_volta" disabled>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Destino da Viagem" id="destino" id-help="destinoHelp">
                        <input type="text" class="form-control" id="destino" aria-describedby="destinoHelp" placeholder="Destino Desejado" v-model="$store.state.item.destino" disabled>
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="aprovarOuCancelar('cancelado')">Cancelar</button>
            </template>
        </modal-component>
        <!-- fim do modal de atualização de pedido -->
    </div>
</template>

<script>
import Paginate from './Paginate.vue'
    export default {
  components: { Paginate },
        data() {
            return {
                urlBase: 'http://localhost:8000/api/v1/pedido',
                urlPaginacao: '',
                urlFiltro: '',
                nomeCliente: '',
                data_ida: '',
                data_volta: '',
                destino: '',
                transacaoStatus: '',
                transacaoDetalhes: {},
                pedidos: { data: [] },
                busca: { id: '', nome: '' }
            }
        },
        methods: {
            aprovarOuCancelar($status) {

                let formData = new FormData();
                formData.append('_method', 'patch')
                formData.append('nome', this.$store.state.item.nome)
                formData.append('data_ida', this.$store.state.item.data_ida)
                formData.append('data_volta', this.$store.state.item.data_volta)
                formData.append('destino', this.$store.state.item.destino)
                formData.append('status', $status)

               
                let url = this.urlBase + '/' + this.$store.state.item.id

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }

                axios.post(url, formData, config)
                    .then(response => {
                        console.log('Resposta de Sucesso:', response);
                        this.$store.state.transacao.status = 'sucesso';
                        this.$store.state.transacao.mensagem = 'Pedido atualizado com sucesso!';
                        this.carregarLista();
                    })
                    .catch(errors => {
                        console.log('Erro Capturado:', errors.response);
                        this.$store.state.transacao.status = 'erro';
                        this.$store.state.transacao.mensagem = errors.response ? errors.response.data.message : 'Erro desconhecido';
                        this.$store.state.transacao.dados = errors.response ? errors.response.data.errors : {};
                    });
            },
            pesquisar() {

                let filtro = ''

                for(let chave in this.busca) {

                    if(this.busca[chave]) {
                        if(filtro != '') {
                            filtro += ";"
                        }
                    
                        filtro += chave + ':like:' + this.busca[chave]
                    }
                }
                if(filtro != '') {
                    this.urlPaginacao = 'page=1'
                    this.urlFiltro = '&filtro='+filtro
                } else {
                    this.urlFiltro = ''
                }

                this.carregarLista()
            },
            paginacao(l) {
                if(l.url) {
                    this.urlPaginacao = l.url.split('?')[1]
                    this.carregarLista() //requisitando novamente os dados para nossa API
                }
            },
            carregarLista() {

                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro
                
                axios.get(url)
                    .then(response => {
                        this.pedidos = response.data
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            }
        },
        mounted() {
            this.carregarLista()
        }
    }
</script>
