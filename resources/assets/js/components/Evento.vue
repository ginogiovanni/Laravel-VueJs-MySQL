<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header" v-for="personal in arrayPersonal" :key="personal.id">
                        <i class="fa fa-align-justify"></i> Eventos
                        <button type="button" @click="abrirModal('evento','registrar',personal)" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="rut">Rut</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarEvento(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarEvento(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Título</th>
                                    <th>Mensaje</th>
                                    <th>Nombre Creador</th>
                                    <th>Rut Creador</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="evento in arrayEvento" :key="evento.id">
                                    <td>
                                        <button type="button" @click="abrirModal('evento','modificar',evento)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="evento.estado">                                            
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarEvento(evento.id)">
                                                <i class="icon-trash"></i>
                                            </button>                                        
                                        </template>
                                        <template v-else>                                            
                                            <button type="button" class="btn btn-info btn-sm" @click="activarEvento(evento.id)">
                                                <i class="icon-check"></i>
                                            </button>                                        
                                        </template>
                                    </td>
                                    <td v-text="evento.titulo"></td>
                                    <td v-text="evento.mensaje"></td>
                                    <td v-text="evento.nombre"></td>
                                    <td v-text="evento.rut"></td>
                                    <td>
                                        <div v-if="evento.estado">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1 ">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '' ]">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#"  @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Titulo</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="titulo" class="form-control" placeholder="Titulo Comunicacion" required="Este campo es requerido"  maxlength="100">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Mensaje</label>
                                    <div class="col-md-9">
                                        <textarea v-model="mensaje" rows="15" cols="60">
                                       
                                        </textarea> 
                                    </div>
                                </div>
                                <div v-show="errorEvento" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjEvento" :key="error" v-text="error"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarEvento()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="modificarEvento()">Modificar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->           
        </main>

</template>

<script>
    export default {
        data(){
            return{
                evento_id : 0,
                titulo:'',
                mensaje:'',
                idpersonal: 0,
                arrayPersonal: [],
                arrayEvento : [],
                modal : 0,
                tituloModal :  '',
                tipoAccion : 0,
                errorEvento : 0,
                errorMostrarMsjEvento : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },

                offset : 3,
                criterio : 'nombre',
                buscar : ''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            pagesNumber: function(){
                if (!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to){
                    pagesArray.push(from);
                    from++ ;
                }
                return pagesArray;
            }
        },
        methods : {
            listarEvento(page, buscar, criterio){
                let me = this;
                var url = '/evento?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayEvento = respuesta.eventos.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
            },

            cambiarPagina(page, buscar, criterio){
                let me = this;
                me.pagination.current_page = page;
                me.listarEvento(page, buscar, criterio);
            },

            selectPersonal(){
                let me = this;
                var url = '/personal/selectPersonalEvent';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta = response.data;
                    me.arrayPersonal = respuesta.personals;
                    console.log(me.idpersonal);
                    //me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
            },

            registrarEvento(){
                if (this.validarEvento()) {
                    return;
                }
                let me =this;

                axios.post('/evento/registrar', {
                    'titulo': this.titulo,
                    'mensaje' : this.mensaje,
                    'idpersonal' : this.idpersonal
                })
                .then(function (response) {
                    me.cerrarModal();
                    me.listarEvento(1, '', 'nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            modificarEvento(){
                if (this.validarEvento()) {
                    return;
                }

                let me =this;

                axios.put('/evento/modificar', {
                    'titulo': this.titulo,                    
                    'mensaje' : this.mensaje,
                    'id': this.evento_id
                })
                .then(function (response) {
                    me.cerrarModal();
                    me.listarEvento(1, '', 'nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            desactivarEvento(id){
                
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: '¿Estás seguro de desactivar este evento?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/evento/desactivar', {
                        'id': id
                    })
                    .then(function (response) {
                        me.listarEvento(1, '', 'nombre');                        
                        swalWithBootstrapButtons(
                        'Desactivado!',
                        'El evento se desactivó con éxito.',
                        'success'
                        )
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                }
                })
            },

            activarEvento(id){
                
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: '¿Estas seguro de activar este evento?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/evento/activar', {
                        'id': id
                    })
                    .then(function (response) {
                        me.listarEvento(1, '', 'nombre');                        
                        swalWithBootstrapButtons(
                        'Activado!',
                        'El campo evento se activo con exito.',
                        'success'
                        )
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                }
                })
            },

            validarEvento(){
                this.errorEvento = 0;
                this.errorMostrarMsjEvento = [];

                if (!this.titulo) {
                    this.errorMostrarMsjEvento.push("El titulo del evento no puede estar vacío");
                }
                if (!this.mensaje) {
                    this.errorMostrarMsjEvento.push("El mensaje del evento no puede estar vacío");
                }

                if (this.errorMostrarMsjEvento.length) {
                    this.errorEvento = 1;
                }

                return this.errorEvento;
            },

            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.titulo = '';
                this.mensaje = '';
            },

            abrirModal(modelo, accion, data = []){
                switch (modelo) {
                    case 'evento':
                    {
                        switch(accion){
                            case 'registrar':{
                                this.modal = 1;
                                this.nombre = '';
                                this.tituloModal = 'Registrar Evento';
                                this.tipoAccion = 1;         
                                this.idpersonal = data['id'];
                                break;
                            }
                            case 'modificar':{
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal= 'Modificar Evento';
                                this.tipoAccion = 2;                                
                                this.evento_id = data['id'];
                                this.titulo = data['titulo'];
                                this.mensaje = data['mensaje'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.selectPersonal();
            this.listarEvento(1, this.buscar, this.criterio);
        }
    }
</script>
<style>
.modal-content{
    width: 100% !important;
    position: absolute !important;
}
.mostrar{
    display: list-item !important;
    opacity: 1 !important;
    position: absolute !important;
    background-color: #3c29297a !important;
}
.div-error{
    display: flex;
    justify-content: center;
}
.text-error{
    color: red !important;
    font-weight: bold;
}
</style>
