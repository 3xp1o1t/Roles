<template>
    <main class="main">
        <br>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card">
                    <div class="card-header h3">
                        <i class="fa fa-align-justify"></i> PRODUCTS
                        <button type="button" class="btn btn-secondary float-right ml-1">
                            <i class="icon-plus"></i>&nbsp;NUEVA
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <select class="form-control col-md-4" v-model="tabla">
                                        <option value="nombre">NOMBRE</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarCategorias(1,buscar, tabla)" class="form-control" id="busqueda" placeholder="BUSCAR POR LIBROS, CD, DVD, ETC..." autofocus>
                                    <button type="submit" @click="listarCategorias(1, buscar, tabla)" class="btn btn-primary"><i class="fa fa-search"></i> BUSCAR</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-responsive-sm table-bordered table-hover">
                            <thead class="thead-dark">
                            <tr>
                                <th>OPCIÓN</th>
                                <th>NOMBRE</th>
                                <th>DESCRIPTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="product in arrayProductos" :key="product.id">
                                <td>
                                    <template v-if="puede_editar">
                                        <button type="button" class="btn btn-warning btn-sm" @click="abrirModal(1, product)">
                                            Edit
                                        </button>
                                    </template>
                                     &nbsp;
                                    <button type="button" class="btn btn-danger btn-sm" @click="eliminarCategoria(product.id)">
                                        Delete
                                    </button>
                                </td>
                                <td v-text="product.name"></td>
                                <td v-text="product.description"></td>
                            </tr>
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, tabla)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, tabla)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, tabla)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    export default {
        props:{
            'puede_editar': false
        },
        data() {
            return {
                mostrarMR: false,
                accion: 0,
                tituloVentana: '',
                arrayProductos:[],
                id: 0,
                nombre: '',
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                tabla: "name",
                buscar: '',
                errorCategoria : 0,
                errorMostrarMsjCategoria : []
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods: {
            abrirModal(accion, data=[]) {
                switch(accion){
                    case 0:
                    {
                        this.tituloVentana = 'AGREGAR';
                        this.nombre = '';
                        this.mostrarMR = true;
                        this.accion = 0;
                        this.errorMostrarMsjCategoria = [];
                        this.errorCategoria = 0;
                        break;
                    }
                    case 1:
                    {
                        this.tituloVentana = 'ACTUALIZAR';
                        this.nombre = data['nombre'];
                        this.id = data['id'];
                        this.mostrarMR = true;
                        this.accion = 1;
                        this.errorMostrarMsjCategoria = [];
                        this.errorCategoria = 0;
                        break;
                    }

                }
            },
            listarCategorias(page, buscar, tabla){
                let me = this;
                let url = '/products/create?page=' + page + '&buscar=' + buscar + '&tabla=' + tabla;
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    me.arrayProductos = respuesta.data;
                    me.pagination.current_page = respuesta.current_page;
                    me.pagination.from = respuesta.from;
                    me.pagination.last_page = respuesta.last_page;
                    me.pagination.per_page = respuesta.per_page;
                    me.pagination.to = respuesta.to;
                    me.pagination.total = respuesta.total;
                }).catch(function (error) {
                    //
                })
            },
            cambiarPagina(page, buscar, tabla){
                let me = this;
                me.pagination.current_page = page;
                me.listarCategorias(page, buscar, tabla);
            },
            registrarCategoria(){
                if(this.validarCategoria()){
                    return;
                }
                let me = this;
                axios.post('/categoria/store',{
                    'nombre': this.nombre,
                }).then(function (response) {
                    me.mostrarMR = false;
                    me.listarCategorias(1,'','nombre');
                }).catch(error => {
                    let msjFinal = '';
                    for (const i in error.response.data.errors){
                        msjFinal += error.response.data.errors[i] + "<br>";
                    }
                    me.mostrarMR = false;
                });
            },
            actualizarCategoria(){
                if(this.validarCategoria()){
                    return;
                }
                let me = this;
                axios.put('/categoria/update',{
                    'nombre': this.nombre,
                    'id': this.id
                }).then(function (response) {
                    me.mostrarMR = false;
                    me.listarCategorias(1,'','nombre');
                }).catch(error => {
                    let msjFinal = '';
                    for (const i in error.response.data.errors){
                        msjFinal += error.response.data.errors[i] + "<br>";
                    }
                    me.mostrarMR = false;
                })
            },
            accionesTeclado(event){
                switch (event.srcKey) {
                    case 'salir':
                        this.mostrarMR=false;
                        break;
                    case 'buscar':
                        document.getElementById('busqueda').focus();
                        break;
                }
            },
            validarCategoria(){
                this.errorCategoria = 0;
                this.errorMostrarMsjCategoria = [];
                if(!this.nombre) this.errorMostrarMsjCategoria.push('LA CATEGORIA NO PUEDE IR VACIA.');
                if(this.errorMostrarMsjCategoria.length) this.errorCategoria = 1;
                return this.errorCategoria;
            },
            eliminarCategoria(id){}

        },
        mounted() {
            this.listarCategorias(1, this.buscar, this.tabla);
        }
    }
</script>
<style>
    .input-width-cat{
        width: 250px;
    }
    .vue-window-modal .vue-window-modal-header h2{
        color: #FFFFFF;
    }
    .vue-window-modal .vue-window-modal-header{
        padding: 2px;
    }
    form{
        margin-top: 15px;
    }
    .vue-window-modal .vue-window-modal-header {
        background-color: #29363d;
    }
    .vue-window-modal .vue-window-modal-header img {
        right: 3px;
        top: 10px;
    }
    .div-error{
        display: flex;
        justify-content: center;
        color: #FF0000;
    }
</style>
