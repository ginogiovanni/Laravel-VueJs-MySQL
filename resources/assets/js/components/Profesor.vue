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
                        <i class="fa fa-align-justify"></i> Profesores
                        <button type="button" @click="mostrarForm('profesor','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <template v-if="listado">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="rut">Rut</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarProfesor(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarProfesor(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Rut</th>
                                    <th>Nombre</th>
                                    <th>Fecha nac</th>
                                    <th>Edad</th>
                                    <th>Dirección</th>
                                    <th>Comuna</th>
                                    <th>Teléfono</th>
                                    <th>Correo</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="profesor in arrayProfesor" :key="profesor.id">
                                    <td>
                                        <button type="button" @click="mostrarForm('profesor','modificar',profesor)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="profesor.condicion">                                            
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarProfesor(profesor.id)">
                                                <i class="icon-trash"></i>
                                            </button>                                        
                                        </template>
                                        <template v-else>                                            
                                            <button type="button" class="btn btn-info btn-sm" @click="activarProfesor(profesor.id)">
                                                <i class="icon-check"></i>
                                            </button>                                        
                                        </template>
                                    </td>
                                    <td v-text="profesor.rut"></td>
                                    <td v-text="profesor.nombre"></td>
                                    <td v-text="profesor.fecha_nac"></td>
                                    <td v-text="profesor.edad"></td>
                                    <td v-text="profesor.direccion"></td>
                                    <td v-text="profesor.nombre_comuna"></td>                                    
                                    <td v-text="profesor.telefono"></td>
                                    <td v-text="profesor.correo"></td>
                                    <td>
                                        <div v-if="profesor.condicion">
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
                    </template>

                    <template v-else>
                    <div class="card-body">
                         <h4 v-text="tituloModal"></h4>
                        <div class="form-group row border">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="text-input">Rut</label>
                                    <input type="text" v-rut v-model="rut" class="form-control" placeholder="Ingrese un RUT valido" required="Campo obligatorio" maxlength="15">                                        
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="text-input">Nombre completo</label>
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del alumno" required="Este campo es requerido" pattern="[a-zA-Z ñÑáéíóúÁÉÍÓÚ]*" maxlength="80" title="Solamente letras, sin numeros">                                        
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label" for="text-input">Fecha nacimiento</label>
                                    <input type="date" v-model="fecha_nac"  class="form-control" id="bday" v-on:change="submitBday()" placeholder="">                                        
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="text-input">Edad</label>
                                    <input type="text" v-model="edad" pattern="[0-9]*" maxlength="2" required="Este campo es requerido" title="Solamente Numeros, sin letras" class="form-control" placeholder="10">                                        
                                </div>
                            </div>    
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-control-label" for="text-input">Dirección</label>
                                    <input type="text" v-model="direccion" class="form-control" maxlength="90" placeholder="La dirección 2245" required="Este campo es requerido">                                        
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="text-input">Región</label>                                    
                                    <select class="form-control" v-model="idregion" v-on:click="selectProvincia(idregion)">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="region in arrayRegion" :key="region.id" :value="region.id" v-text="region.nombre"></option>    
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="text-input">Provincia</label>
                                    <select class="form-control" v-model="idprovincia" v-on:click="selectComuna(idprovincia)">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="provincia in arrayProvincia" :key="provincia.id" :value="provincia.id" v-text="provincia.nombre" ></option>    
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="text-input">Comuna</label>
                                    <select class="form-control" v-model="idcomuna">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="comuna in arrayComuna" :key="comuna.id" :value="comuna.id" v-text="comuna.nombre"></option>    
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="text-input">Teléfono</label>
                                    <input type="text" v-model="telefono" class="form-control" placeholder="226418756" pattern="[0-9]*" maxlength="10" required="Este campo es requerido" title="Solamente Numeros, sin letras">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-control-label" for="text-input">Correo</label>
                                    <input type="email" v-model="correo" class="form-control" placeholder="nombre@correo.cl">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div v-show="errorProfesor" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjProfesor" :key="error" v-text="error"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-secondary" @click="ocultarForm()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarProfesor()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="modificarProfesor()">Modificar</button>
                            </div>
                        </div>
                    </div>
                    </template>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Fin del modal-->           
        </main>

</template>

<script>

    export default {
        
        data(){
            return{
                profesor_id : 0,
                idcomuna : 0,
                idregion : 0,
                telefono : '',
                correo : '',
                listado:1,
                idprovincia : 0,
                rut:'',
                nombre:'',
                fecha_nac : '2010-10-23',
                edad : 0,
                direccion : '',
                nombre_comuna : '',
                arrayProfesor : [],
                modal : 0,
                tituloModal :  '',
                tipoAccion : 0,
                errorProfesor : 0,
                errorMostrarMsjProfesor : [],
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
                arrayComuna : [],
                arrayRegion : [],
                arrayProvincia : [],
                
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
            },
            
        },
        methods : {
            listarProfesor(page, buscar, criterio){
                let me = this;
                var url = '/profesor?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayProfesor = respuesta.profesores.data;
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

            selectRegion(){
                let me = this;
                var url = '/region/selectRegion';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta = response.data;
                    me.arrayRegion = respuesta.regiones;
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

            submitBday() {
                var Q4A;
                var Bdate = document.getElementById('bday').value;
                var Bday = +new Date(Bdate);
                Q4A = "" + ~~ ((Date.now() - Bday) / (31557600000));
                this.edad = Q4A;
                
            },

            selectProvincia(idregion){
                let me = this;
                var url = '/provincia/selectProvincia?region='+idregion;
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta = response.data;
                    me.arrayProvincia = respuesta.provincias;
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

            selectComuna(idprovincia){
                let me = this;
                var url = '/comuna/selectComuna?provincia='+idprovincia;
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta = response.data;
                    me.arrayComuna = respuesta.comunas;
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

            cambiarPagina(page, buscar, criterio){
                let me = this;
                me.pagination.current_page = page;
                me.listarProfesor(page, buscar, criterio);
            },

            registrarProfesor(){
                if (this.validarProfesor()) {
                    return;
                }

                let me =this;

                axios.post('/profesor/registrar', {
                    'rut' : this.rut,
                    'nombre': this.nombre,
                    'fecha_nac' : this.fecha_nac,
                    'edad' : this.edad,
                    'direccion' : this.direccion,
                    'idcomuna' : this.idcomuna,
                    'telefono' : this.telefono,
                    'correo' : this.correo
                })
                .then(function (response) {
                    me.ocultarForm();
                    me.listarProfesor(1, '', 'nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            modificarProfesor(){
                if (this.validarProfesor()) {
                    return;
                }

                let me =this;

                axios.put('/profesor/modificar', {
                    'rut' : this.rut,
                    'nombre': this.nombre,
                    'fecha_nac' : this.fecha_nac,
                    'edad' : this.edad,
                    'direccion' : this.direccion,
                    'idcomuna' : this.idcomuna,
                    'telefono' : this.telefono,
                    'correo' : this.correo,
                    'id': this.profesor_id
                })
                .then(function (response) {
                    me.ocultarForm();
                    me.listarProfesor(1, '', 'nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            desactivarProfesor(id){
                
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: '¿Estás seguro de desactivar el profesor seleccionado?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/profesor/desactivar', {
                        'id': id
                    })
                    .then(function (response) {
                        me.listarProfesor(1, '', 'nombre');                        
                        swalWithBootstrapButtons(
                        'Desactivado!',
                        'El profesor seleccionado se desactivó con éxito.',
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

            activarProfesor(id){
                
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: '¿Estas seguro de activar el profesor seleccionado?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/profesor/activar', {
                        'id': id
                    })
                    .then(function (response) {
                        me.listarProfesor(1, '', 'nombre');                        
                        swalWithBootstrapButtons(
                        'Activado!',
                        'El profesor seleccionado se activo con exito.',
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

            validarProfesor(){
                this.errorProfesor = 0;
                this.errorMostrarMsjProfesor = [];

              if (!this.nombre) {
                    this.errorMostrarMsjProfesor.push("El campo nombre no puede estar vacío");
                }

                if (!this.direccion) {
                    this.errorMostrarMsjProfesor.push("El campo dirección no puede estar vacío");
                }
                if (!this.rut) {
                    this.errorMostrarMsjProfesor.push("El campo rut no puede estar vacío");
                }

                if(this.idcomuna == 0){
                     this.errorMostrarMsjProfesor.push("Debe seleccionar una comuna");
                }
                if(this.idregion == 0){
                     this.errorMostrarMsjProfesor.push("Debe seleccionar una región");
                }
                if(this.idprovincia == 0){
                     this.errorMostrarMsjProfesor.push("Debe seleccionar una provincia");
                }

                if (this.errorMostrarMsjProfesor.length) {
                    this.errorProfesor = 1;
                }

                return this.errorProfesor;
            },

            
            ocultarForm(){
                this.listado = 1;
            },

            mostrarForm(modelo, accion, data = []){
                switch (modelo) {
                    case 'profesor':
                    {
                        switch(accion){
                            case 'registrar':{
                                this.modal = 1;
                                this.rut = '';
                                this.nombre = '';
                                this.edad = '';
                                this.direccion = '';
                                this.idcomuna = '';
                                this.telefono = '';
                                this.correo = '';
                                this.tituloModal = 'Registrar Profesor';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'modificar':{
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal= 'Modificar Profesor';
                                this.tipoAccion = 2;                                
                                this.profesor_id = data['id'];
                                this.rut = data['rut'];
                                this.nombre = data['nombre'];
                                this.fecha_nac = data['fecha_nac'];
                                this.edad = data['edad'];
                                this.direccion = data['direccion'];
                                this.idcomuna = data['idcomuna'];
                                this.idprovincia = data['idprovincia'];
                                this.idregion = data['idregion'];
                                this.nombre_comuna = data['nombre_comuna'];
                                this.telefono = data['telefono'];
                                this.correo = data['correo'];                                
                                this.selectProvincia(this.idregion);
                                this.selectComuna(this.idprovincia);
                                break;
                            }
                        }
                    }
                }
                this.listado = 0;
                this.selectRegion();
               
            }
            
        },
        mounted() {
            this.listarProfesor(1, this.buscar, this.criterio);
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
