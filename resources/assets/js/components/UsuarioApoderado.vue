<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Usuarios apoderados
                        <button type="button" @click="abrirModal('usuarioapoderado','registrar')" class="btn btn-secondary">
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
                                    <input type="text" v-model="buscar" @keyup.enter="listarUsuarioApoderado(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarUsuariosApoderado(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Rut</th>
                                    <th>Nombre</th>
                                    <th>Usuario</th>
                                    <th>Rol</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="usuariosapoderado in arrayUsuarioApoderado" :key="usuariosapoderado.iduser">
                                    <td>
                                        <button type="button" @click="abrirModal('usuarioapoderado','modificar', usuariosapoderado)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="usuariosapoderado.condicion">                                            
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarUsuarioApoderado(usuariosapoderado.iduser)">
                                                <i class="icon-trash"></i>
                                            </button>                                        
                                        </template>
                                        <template v-else>                                            
                                            <button type="button" class="btn btn-info btn-sm" @click="activarUsuarioApoderado(usuariosapoderado.iduser)">
                                                <i class="icon-check"></i>
                                            </button>                                        
                                        </template>
                                    </td>
                                    <td v-text="usuariosapoderado.rut"></td>
                                    <td v-text="usuariosapoderado.nombre"></td>
                                    <td v-text="usuariosapoderado.usuario"></td>
                                    <td v-text="usuariosapoderado.nombrerol"></td>
                                    <td v-text="usuariosapoderado.descripcion"></td>
                                    <td>
                                        <div v-if="usuariosapoderado.condicion">
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
                                <div class="form-group row" v-if="modificarApo">
                                    <label class="col-md-3 form-control-label" for="text-input">Apoderado</label>
                                    <div class="col-md-9">
                                        <v-select
                                        :on-search="selectApoderado"
                                        label="nombre"
                                        :options="arrayApoderado"
                                        placeholder="Buscar apoderados..."
                                        :onChange="getDatosApoderados"
                                        v-model="seleccionado"
                                    >
                                     <template slot="option" slot-scope="option">
                                        {{ "Nombre: "+option.nombre + " Rut: " +  option.rut}}
                                    </template>

                                    </v-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Usuario</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="usuario" class="form-control" placeholder="Ingrese nombre de usuario">                                        
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Contraseña</label>
                                    <div class="col-md-9">
                                        <input type="password" v-model="password" class="form-control" placeholder="Ingrese una contraseña">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Rol</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idrol" v-on:click="selectRol()">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="roles in arrayRol" :key="roles.id" :value="roles.id" v-text="roles.nombre + ' | ' +roles.descripcion" ></option>    
                                        </select>                                       
                                    </div>
                                </div>
                                <div v-show="errorUsuarioApoderado" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjUsuarioApoderado" :key="error" v-text="error"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarUsuarioApoderado()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="modificarUsuarioApoderado()">Modificar</button>
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
    import vSelect from 'vue-select';
    export default {
        
        data(){
            return{
                usuarioapoderado_id : 0,
                idusuario: 0,
                idrol: 0,
                idapoderado : 0,
                rut:'',
                nombre:'',
                usuario:'',
                modificarApo : 1, 
                password:'',
                nombrerol:'',
                seleccionado : [],
                descripcion:'',
                arrayUsuarioApoderado : [],
                modal : 0,
                tituloModal :  '',
                tipoAccion : 0,
                errorUsuarioApoderado : 0,
                errorMostrarMsjUsuarioApoderado : [],
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
                buscar : '',
                arrayRol : [],
                arrayApoderado : []
                
            }
        },        
        components:{
            vSelect
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
            },
            
        },
        methods : {
            listarUsuarioApoderado(page, buscar, criterio){
                let me = this;
                var url = '/userapoderado?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayUsuarioApoderado = respuesta.apoderados.data;
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

            selectRol(){
                let me = this;
                var url = '/rol/selectRol';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta = response.data;
                    me.arrayRol = respuesta.roles;
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
            selectApoderado(search, loading){
                let me = this;
                loading(true)
                var url = '/apoderado/selectApoderadoUser?filtro='+search;
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta = response.data;
                    q: search
                    me.arrayApoderado = respuesta.apoderados;
                    loading(false)
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

            getDatosApoderados(val1){
                let me = this;
                me.loading = true;
                me.idapoderado = val1.id;
            },

            cambiarPagina(page, buscar, criterio){
                let me = this;
                me.pagination.current_page = page;
                me.listarUsuarioApoderado(page, buscar, criterio);
            },

            registrarUsuarioApoderado(){
                if (this.validarUsuarioApoderado()) {
                    return;
                }

                let me =this;

                axios.post('/userapoderado/registrar', {
                    'idapoderado' : this.idapoderado,
                    'usuario' : this.usuario,
                    'password': this.password,
                    'idrol' : this.idrol
                })
                .then(function (response) {
                    me.cerrarModal();
                    me.listarUsuarioApoderado(1, '', 'nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            modificarUsuarioApoderado(){
                if (this.validarUsuarioApoderado()) {
                    return;
                }

                let me =this;

                axios.put('/userapoderado/modificar', {
                    'usuario' : this.usuario,
                    'password': this.password,
                    'idrol' : this.idrol,
                    'edad' : this.edad,
                    'id': this.iduser
                })
                .then(function (response) {
                    me.cerrarModal();
                    me.listarUsuarioApoderado(1, '', 'nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            desactivarUsuarioApoderado(id){
                
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: '¿Estás seguro de desactivar el usuario apoderado seleccionado?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/userapoderado/desactivar', {
                        'id': id
                    })
                    .then(function (response) {
                        me.listarUsuarioApoderado(1, '', 'nombre');                        
                        swalWithBootstrapButtons(
                        'Desactivado!',
                        'El usuario apoderado seleccionado se desactivó con éxito.',
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

            activarUsuarioApoderado(id){
                
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: '¿Estas seguro de activar el usuario apoderado seleccionado?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/userapoderado/activar', {
                        'id': id
                    })
                    .then(function (response) {
                        me.listarUsuarioApoderado(1, '', 'nombre');                        
                        swalWithBootstrapButtons(
                        'Activado!',
                        'El usuario apoderado seleccionado se activo con exito.',
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

            validarUsuarioApoderado(){
                this.errorUsuarioApoderado = 0;
                this.errorMostrarMsjUsuarioApoderado = [];

                if (!this.usuario) {
                    this.errorMostrarMsjUsuarioApoderado.push("El nombre no puede estar vacio");
                }

                if (!this.password) {
                    this.errorMostrarMsjUsuarioApoderado.push("la direccion no puede estar vacio");
                }


                if (this.errorMostrarMsjUsuarioApoderado.length) {
                    this.errorUsuarioApoderado = 1;
                }

                return this.errorUsuarioApoderado;
            },

            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.usuario = '';
                this.modificarApo = 1; 
                this.password = '';
            },

            abrirModal(modelo, accion, data = []){
                switch (modelo) {
                    case 'usuarioapoderado':
                    {
                        switch(accion){
                            case 'registrar':{
                                this.modal = 1;
                                this.usuario = '';
                                this.passoword = '';
                                this.tituloModal = 'Registrar Usuario Apoderado';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'modificar':{
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal= 'Modificar Usuario Apoderado';
                                this.tipoAccion = 2;         
                                this.modificarApo = 0;                        
                                this.iduser = data['iduser'];
                                this.usuario = data['usuario'];
                                this.password = data['password'];
                                this.idrol = data['idrol'];
                                this.idapoderado = data['idapoderado'];  
                                break;
                            }
                        }
                    }
                }
                this.selectRol();
            }
            
        },
        mounted() {
            this.listarUsuarioApoderado(1, this.buscar, this.criterio);
        }
        
    }
      
</script>
<style>
.modal-content{
    width: 100% !important;
    position: absolute !important;
}
.modal-body {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
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
