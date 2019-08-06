<script src="../app.js"></script>
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
                        <i class="fa fa-align-justify"></i> Alumnos
                        <button type="button" @click="mostrarForm('alumno','registrar',alumno)" class="btn btn-secondary">
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
                                    <input type="text" v-model="buscar" @keyup.enter="listarAlumno(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarAlumno(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
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
                                    <th>Curso</th>
                                    <th>Apoderado</th>
                                    <th>Telefono</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="alumno in arrayAlumno" :key="alumno.id">
                                    <td>
                                        <button type="button" @click="mostrarForm('alumno','modificar',alumno)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="alumno.condicion">                                            
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarAlumno(alumno.id)">
                                                <i class="icon-trash"></i>
                                            </button>                                        
                                        </template>
                                        <template v-else>                                            
                                            <button type="button" class="btn btn-info btn-sm" @click="activarAlumno(alumno.id)">
                                                <i class="icon-check"></i>
                                            </button>                                        
                                        </template>
                                    </td>
                                    <td v-text="alumno.rut"></td>
                                    <td v-text="alumno.nombre"></td>
                                    <td v-text="alumno.fecha_nac"></td>
                                    <td v-text="alumno.edad"></td>
                                    <td v-text="alumno.direccion"></td>
                                    <td v-text="alumno.nombre_comuna"></td>                                    
                                    <td v-text="alumno.curso_nombre + ' ' + alumno.curso_desc"></td>
                                    <td v-text="alumno.nombre_apoderado"></td>
                                    <td v-text="alumno.telefono_apoderado"></td>
                                    <td>
                                        <div v-if="alumno.condicion">
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
                                    <label class="form-control-label">Curso</label>
                                    <v-select
                                        :on-search="selectCurso"
                                        label="cursocom"
                                        :options="arrayCurso"
                                        placeholder="Buscar curso..."
                                        :onChange="getDatosCurso"
                                        v-model="cursoSeleccionado"
                                    >
                                     <template slot="option" slot-scope="option">
                                        {{ option.cursocom}}
                                    </template>

                                    </v-select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-control-label">Apoderado</label>
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
                            <div class="col-md-12">
                                <div v-show="errorAlumno" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjAlumno" :key="error" v-text="error"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-secondary" @click="ocultarForm()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarAlumno()">Guardar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="modificarAlumno()">Modificar</button>
                            </div>
                        </div>
                    </div>
                    </template>
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
                            <!-- modal despues -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarAlumno()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="modificarAlumno()">Modificar</button>
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
                alumno_id : 0,
                idcomuna : 0,
                idregion : 0,
                idcurso : 0,
                idapoderado : 0,
                listado:1,
                telefono : '',
                correo : '',
                idprovincia : 0,
                rut:'',
                nombre:'',
                fecha_nac : '2010-10-23',
                edad : 0,
                direccion : '',
                nombre_comuna : '',
                telefono_apoderado : '',
                curso_nombre : '',
                curso_desc : '',
                nombre_apoderado : '',
                arrayAlumno : [],
                modal : 0,
                tituloModal :  '',
                tipoAccion : 0,
                errorAlumno : 0,
                seleccionado : [],
                cursoSeleccionado : [],
                errorMostrarMsjAlumno : [],
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
                arrayCurso : [],
                arrayApoderado : [],
                
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
            listarAlumno(page, buscar, criterio){
                let me = this;
                var url = '/alumno?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayAlumno = respuesta.alumnos.data;
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

            selectCurso(search, loading){
                let me = this;
                loading(true)
                var url = '/curso/selectCurso?filtro='+search;
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta = response.data;
                    q: search
                    me.arrayCurso = respuesta.cursos;
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

            getDatosCurso(val1){
                let me = this;
                me.loading = true;
                me.idcurso = val1.id;
            },

            selectApoderado(search, loading){
                let me = this;
                loading(true)
                var url = '/apoderado/selectApoderado?filtro='+search;
                axios.get(url).then(function (response) {
                    //console.log(response);
                    let respuesta = response.data;
                    q: search
                    me.arrayApoderado = respuesta.apoderados;
                    loading(false)
                    //me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
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
                me.listarAlumno(page, buscar, criterio);
            },

            submitBday() {
                var Q4A;
                var Bdate = document.getElementById('bday').value;
                var Bday = +new Date(Bdate);
                Q4A = "" + ~~ ((Date.now() - Bday) / (31557600000));
                this.edad = Q4A;
                
            },

            registrarAlumno(){
                if (this.validarAlumno()) {
                    return;
                }

                let me =this;

                axios.post('/alumno/registrar', {
                    'rut' : this.rut,
                    'nombre': this.nombre,
                    'fecha_nac' : this.fecha_nac,
                    'edad' : this.edad,
                    'direccion' : this.direccion,
                    'idcomuna' : this.idcomuna,
                    'idcurso' : this.idcurso,
                    'idapoderado' : this.idapoderado
                })
                .then(function (response) {
                    me.ocultarForm();
                    me.listarAlumno(1, '', 'nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            modificarAlumno(){
                if (this.validarAlumno()) {
                    return;
                }

                let me =this;

                axios.put('/alumno/modificar', {
                    'rut' : this.rut,
                    'nombre': this.nombre,
                    'fecha_nac' : this.fecha_nac,
                    'edad' : this.edad,
                    'direccion' : this.direccion,
                    'idcomuna' : this.idcomuna,
                    'idcurso' : this.idcurso,
                    'idapoderado' : this.idapoderado,
                    'id': this.alumno_id
                })
                .then(function (response) {
                    me.ocultarForm();
                    me.listarAlumno(1, '', 'nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            desactivarAlumno(id){
                
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: '¿Estás seguro de desactivar el alumno seleccionado?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/alumno/desactivar', {
                        'id': id
                    })
                    .then(function (response) {
                        me.listarAlumno(1, '', 'nombre');                        
                        swalWithBootstrapButtons(
                        'Desactivado!',
                        'El alumno seleccionado se desactivó con éxito.',
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

            activarAlumno(id){
                
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: '¿Estas seguro de activar el alumno seleccionado?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/alumno/activar', {
                        'id': id
                    })
                    .then(function (response) {
                        me.listarAlumno(1, '', 'nombre');                        
                        swalWithBootstrapButtons(
                        'Activado!',
                        'El alumno seleccionado se activo con exito.',
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

            validarAlumno(){
                this.errorAlumno = 0;
                this.errorMostrarMsjAlumno = [];

                if (!this.nombre) {
                    this.errorMostrarMsjAlumno.push("El campo nombre no puede estar vacío");
                }

                if (!this.direccion) {
                    this.errorMostrarMsjAlumno.push("El campo dirección no puede estar vacío");
                }
                if (!this.rut) {
                    this.errorMostrarMsjAlumno.push("El campo rut no puede estar vacío");
                }

                if(this.idcomuna == 0){
                     this.errorMostrarMsjAlumno.push("Debe seleccionar una comuna");
                }

                if(!this.idcurso){
                     this.errorMostrarMsjAlumno.push("Debe seleccionar un curso");
                }

                if(!this.idapoderado){
                     this.errorMostrarMsjAlumno.push("Debe seleccionar un apoderado");
                }

                if(this.idregion == 0){
                     this.errorMostrarMsjAlumno.push("Debe seleccionar una región");
                }
                if(this.idprovincia == 0){
                     this.errorMostrarMsjAlumno.push("Debe seleccionar una provincia");
                }


                if (this.errorMostrarMsjAlumno.length) {
                    this.errorAlumno = 1;
                }

                return this.errorAlumno;
            },

            ocultarForm(){
                this.listado = 1;
            },

            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.rut = '';
                this.nombre = '';
                this.edad = '';
                this.direccion = '';
                this.idcomuna = '';
                this.idprovincia = '';
                this.idregion = '';
                this.idcurso = '';
                this.idapoderado = '';
            },

            mostrarForm(modelo, accion, data = []){
                switch (modelo) {
                    case 'alumno':
                    {
                        switch(accion){
                            case 'registrar':{
                                this.rut = '';
                                this.nombre = '';
                                this.edad = '';
                                this.direccion = '';
                                this.idcomuna = '';
                                this.idcurso = '';
                                this.idapoderado = '';
                                this.tituloModal = 'Registrar Alumno';
                                this.tipoAccion = 1;
                                this.seleccionado = {};
                                break;
                            }
                            case 'modificar':{
                                this.tituloModal= 'Modificar Alumno';
                                this.tipoAccion = 2;                                
                                this.alumno_id = data['id'];
                                this.rut = data['rut'];
                                this.nombre = data['nombre'];
                                this.fecha_nac = data['fecha_nac'];
                                this.edad = data['edad'];
                                this.direccion = data['direccion'];
                                this.idcomuna = data['idcomuna'];
                                this.idprovincia = data['idprovincia'];
                                this.idregion = data['idregion'];
                                this.nombre_comuna = data['nombre_comuna'];                             
                                this.idcurso = data['idcurso'];
                                this.curso_desc = data['curso_desc'];
                                this.curso_nombre = data['curso_nombre'];
                                this.idapoderado = data['idapoderado'];
                                this.nombre_apoderado = data['nombre_apoderado'];
                                this.idcurso = data['idcurso'];
                                this.cursocom = data['cursocom'];
                                this.selectProvincia(this.idregion);
                                this.selectComuna(this.idprovincia);
                                this.seleccionado = {id: this.idapoderado, nombre: this.nombre_apoderado};                                
                                this.cursoSeleccionado = {id: this.idcurso, cursocom: this.curso_nombre+' '+this.curso_desc};
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
            this.listarAlumno(1, this.buscar, this.criterio);
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
