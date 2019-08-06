<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Profesor</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Comunicaciones Apoderados
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre Apoderado</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarComunicacion(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarComunicacion(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Titulo Comunicación</th>
                                    <th>Mensaje</th>
                                    <th>Creador</th>
                                    <th>Apoderado</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="comunicaciones in arrayComunicacion" :key="comunicaciones.id">
                                    <td>
                                        <button type="button" @click="abrirModal('comunicaciones','modificar',comunicaciones)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="comunicaciones.estado">                                            
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarComunicacion(comunicaciones.id)">
                                                <i class="icon-trash"></i>
                                            </button>                                        
                                        </template>
                                        <template v-else>                                            
                                            <button type="button" class="btn btn-info btn-sm" @click="activarComunicacion(comunicaciones.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="comunicaciones.titulo"></td>
                                    <td v-text="comunicaciones.mensaje"></td>
                                    <td v-text="comunicaciones.nombreprofesor"></td>
                                    <td v-text="comunicaciones.nombreapoderado"></td>
                                    <td v-text="comunicaciones.created_at"></td>
                                    <td>
                                        <div v-if="comunicaciones.estado">
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
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" class="btn btn-primary" @click="modificarComunicacion()">Modificar</button>
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
                comunicacion_id : 0,
                titulo:'',
                mensaje:'',
                jornada:'',
                arrayComunicacion : [],
                modal : 0,
                tituloModal :  '',
                tipoAccion : 0,
                errorCurso : 0,
                errorMostrarMsjCurso : [],
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
            listarComunicacion(page, buscar, criterio){
                let me = this;
                var url = '/comunicacionesapoderados?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayComunicacion = respuesta.comunicaciones.data;
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
                me.listarCurso(page, buscar, criterio);
            },

            modificarComunicacion(){

                let me =this;

                axios.put('/comunicacionesapoderados/modificar', {
                    'titulo': this.titulo,                    
                    'mensaje' : this.mensaje,
                    'id': this.comunicacion_id
                })
                .then(function (response) {
                    me.cerrarModal();
                    me.listarComunicacion(1, '', 'nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            desactivarComunicacion(id){
                
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: '¿Estás seguro de desactivar esta comunicación?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/comunicacionesapoderados/desactivar', {
                        'id': id
                    })
                    .then(function (response) {
                        me.listarComunicacion(1, '', 'nombre');                        
                        swalWithBootstrapButtons(
                        'Desactivado!',
                        'La comunicación se desactivó con éxito.',
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

            activarComunicacion(id){
                
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: '¿Estas seguro de activar esta comunicación?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/comunicacionesapoderados/activar', {
                        'id': id
                    })
                    .then(function (response) {
                        me.listarComunicacion(1, '', 'nombre');                        
                        swalWithBootstrapButtons(
                        'Activado!',
                        'La comunicación se activo con exito.',
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

            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
            },

            abrirModal(modelo, accion, data = []){
                switch (modelo) {
                    case 'comunicaciones':
                    {
                        switch(accion){
                            
                            case 'modificar':{
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal= 'Modificar Comunicacion';
                                this.comunicacion_id = data['id'];                               
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
            this.listarComunicacion(1, this.buscar, this.criterio);
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
