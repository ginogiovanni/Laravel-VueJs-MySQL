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
                        <i class="fa fa-align-justify"></i> Asignaturas y Profesores
                        <button type="button" @click="mostrarForm('asignaturaprofesor','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp; Nuevo
                        </button>
                    </div>
                    
                    <template v-if="listado">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="dia">Día</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarAsignaturaProfesor(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarAsignaturaProfesor(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre Prof</th>
                                    <th>Asignatura</th>
                                    <th>Curso</th>
                                    <th>Día</th>
                                    <th>Hora Inicio</th>
                                    <th>Hora Fin</th>
                                    <th>Semestre</th>
                                    <th>Profesor Jefe</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="asignaturaprofesor in arrayAsignaturaProfesor" :key="asignaturaprofesor.id">
                                    <td>
                                        <button type="button" @click="mostrarForm('asignaturaprofesor','modificar', asignaturaprofesor)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="asignaturaprofesor.condicion">                                            
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarAsignaturaProfesor(asignaturaprofesor.id)">
                                                <i class="icon-trash"></i>
                                            </button>                                        
                                        </template>
                                        <template v-else>                                            
                                            <button type="button" class="btn btn-info btn-sm" @click="activarAsignaturaProfesor(asignaturaprofesor.id)">
                                                <i class="icon-check"></i>
                                            </button>                                        
                                        </template>
                                    </td>
                                    <td v-text="asignaturaprofesor.nombreprofesor"></td>
                                    <td v-text="asignaturaprofesor.nombreasignatura"></td>
                                    <td v-text="asignaturaprofesor.nombrecurso"></td>
                                    <td v-text="asignaturaprofesor.dia"></td>
                                    <td v-text="asignaturaprofesor.hora_inicio"></td>
                                    <td v-text="asignaturaprofesor.hora_fin"></td>
                                    <td v-text="asignaturaprofesor.semestre"></td>                                   
                                    <td>
                                        <div v-if="asignaturaprofesor.jefe">
                                            <span class="badge badge-success">Si</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-warning">No</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div v-if="asignaturaprofesor.condicion">
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
                                    <label class="form-control-label">Apoderado</label>
                                    <v-select
                                        :on-search="selectProfesor"
                                        label="nombre"
                                        :options="arrayProfesor"
                                        placeholder="Buscar profesores..."
                                        :onChange="getDatosProfesor"
                                        v-model="seleccionado"
                                    >
                                     <template slot="option" slot-scope="option">
                                        {{ "Nombre: "+option.nombre + " Rut: " +  option.rut}}
                                    </template>

                                    </v-select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">Asignatura</label>
                                    <v-select
                                        :on-search="selectAsignatura"
                                        label="nombre"
                                        :options="arrayAsignatura"
                                        placeholder="Buscar asignaturas..."
                                        :onChange="getDatosAsignatura"
                                        v-model="asigSeleccionada"
                                    >

                                    </v-select>
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="text-input">Día</label>
                                    <select class="form-control" v-model="dia">
                                        <option value="" disabled>Seleccione</option>
                                        <option value="Lunes">Lunes</option>
                                        <option value="Martes">Martes</option>
                                        <option value="Miércoles">Miércoles</option>  
                                        <option value="Jueves">Jueves</option>
                                        <option value="Viernes">Viernes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label" for="text-input">Hora inicio</label>
                                    <input type="text" v-model="hora_inicio" class="form-control" maxlength="5" placeholder="09:45" required="Campo Requerido">
                                </div>
                            </div>    
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label" for="text-input">Hora fin</label>
                                    <input type="text" v-model="hora_fin"  class="form-control" placeholder="09:45" maxlength="5">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label" for="text-input">Semestre</label>
                                    <select class="form-control" v-model="semestre">
                                        <option value="Primer Semestre">Primer Semestre</option>
                                        <option value="Segundo Semestre">Segundo Semestre</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label" for="text-input">Profesor Jefe</label>
                                    <select class="form-control" v-model="jefe">
                                        <option value="0">No</option>
                                        <option value="1">Si</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div v-show="errorAsignaturaProfesor" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjAsignaturaProfesor" :key="error" v-text="error"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-secondary" @click="ocultarForm()">Cerrar</button>
                               <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarAsignaturaProfesor()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="modificarAsignaturaProfesor()">Modificar</button>
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
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                

                                

                                

                               
                                
                                
                                
                                
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            
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
                asignaturaprofesor_id : 0,
                idprofesor : 0,
                idasignatura : 0,
                idcurso : 0,
                dia : '',
                hora_inicio : '',
                hora_fin:'',
                jefe : 0,
                listado:1,
                semestre: '',
                nombreprofesor : '',
                nombreasignatura : '',
                nombrecurso : '',
                descripcioncurso : '',
                arrayAsignaturaProfesor : [],
                seleccionado : [],
                asigSeleccionada : [],
                cursoSeleccionado : [],
                modal : 0,
                tituloModal :  '',
                tipoAccion : 0,
                errorAsignaturaProfesor : 0,
                errorMostrarMsjAsignaturaProfesor : [],
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
                arrayCurso : [],
                arrayProfesor : [],
                arrayAsignatura : [],
                
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
            listarAsignaturaProfesor(page, buscar, criterio){
                let me = this;
                var url = '/asignaturaprofesor?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayAsignaturaProfesor = respuesta.asignaturasprofesores.data;
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

            selectProfesor(search, loading){
                let me = this;
                loading(true)
                var url = '/profesor/selectProfesor?filtro='+search;
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta = response.data;
                    q: search
                    me.arrayProfesor = respuesta.profesores;
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
            

            getDatosProfesor(val1){
                let me = this;
                me.loading = true;
                me.idprofesor = val1.id;
            },

            selectAsignatura(search, loading){
                let me = this;
                loading(true)
                var url = '/asignatura/selectAsignatura?filtro='+search;
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta = response.data;
                    q: search
                    me.arrayAsignatura = respuesta.asignaturas;
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

            getDatosAsignatura(val2){
                let me = this;
                me.loading = true;
                me.idasignatura = val2.id;
            },

            cambiarPagina(page, buscar, criterio){
                let me = this;
                me.pagination.current_page = page;
                me.listarAsignaturaProfesor(page, buscar, criterio);
            },

            registrarAsignaturaProfesor(){
                if (this.validarAsignaturaProfesor()) {
                    return;
                }

                let me =this;

                axios.post('/asignaturaprofesor/registrar', {
                    'idprofesor' : this.idprofesor,
                    'idasignatura': this.idasignatura,
                    'idcurso' : this.idcurso,
                    'dia' : this.dia,
                    'hora_inicio' : this.hora_inicio,
                    'hora_fin' : this.hora_fin,
                    'semestre' : this.semestre,
                    'jefe' : this.jefe
                })
                .then(function (response) {
                    me.ocultarForm();
                    me.listarAsignaturaProfesor(1, '', 'nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            modificarAsignaturaProfesor(){
                if (this.validarAsignaturaProfesor()) {
                    return;
                }

                let me =this;

                axios.put('/asignaturaprofesor/modificar', {
                    'idprofesor' : this.idprofesor,
                    'idasignatura': this.idasignatura,
                    'idcurso' : this.idcurso,
                    'dia' : this.dia,
                    'hora_inicio' : this.hora_inicio,
                    'hora_fin' : this.hora_fin,
                    'jefe' : this.jefe,
                    'semestre' : this.semestre,
                    'id': this.asignaturaprofesor_id
                })
                .then(function (response) {
                    me.ocultarForm();
                    me.listarAsignaturaProfesor(1, '', 'nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            desactivarAsignaturaProfesor(id){
                
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: '¿Estás seguro de desactivar el campo seleccionado?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/asignaturaprofesor/desactivar', {
                        'id': id
                    })
                    .then(function (response) {
                        me.listarAsignaturaProfesor(1, '', 'nombre');                        
                        swalWithBootstrapButtons(
                        'Desactivado!',
                        'El campo seleccionado se desactivó con éxito.',
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

            activarAsignaturaProfesor(id){
                
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: '¿Estas seguro de activar el campo seleccionado?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/asignaturaprofesor/activar', {
                        'id': id
                    })
                    .then(function (response) {
                        me.listarAsignaturaProfesor(1, '', 'nombre');                        
                        swalWithBootstrapButtons(
                        'Activado!',
                        'El campo seleccionado se activo con exito.',
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

            validarAsignaturaProfesor(){
                this.errorAsignaturaProfesor = 0;
                this.errorMostrarMsjAsignaturaProfesor = [];

                if (!this.hora_fin) {
                    this.errorMostrarMsjAsignaturaProfesor.push("Debe ingresar la hora final");
                }

                if (!this.hora_inicio) {
                    this.errorMostrarMsjAsignaturaProfesor.push("Debe ingresar la hora de inicio");
                }

                if (this.dia == "") {
                    this.errorMostrarMsjAsignaturaProfesor.push("Debe seleccionar un día");
                }
                
                if(!this.idprofesor){
                     this.errorMostrarMsjAsignaturaProfesor.push("Debe seleccionar un profesor");
                }

                if(!this.idcurso){
                     this.errorMostrarMsjAsignaturaProfesor.push("Debe seleccionar un curso");
                }

                if(!this.idasignatura){
                     this.errorMostrarMsjAsignaturaProfesor.push("Debe seleccionar una asignatura");
                }

                if (this.errorMostrarMsjAsignaturaProfesor.length) {
                    this.errorAsignaturaProfesor = 1;
                }

                return this.errorAsignaturaProfesor;
            },

            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.idprofesor = '';
                this.idasignatura = '';
                this.idcurso = '';
                this.dia = '';
                this.hora_inicio = '';
                this.hora_fin = '';
                this.jefe = '';
            },

            ocultarForm(){
                this.listado = 1;
            },

            mostrarForm(modelo, accion, data = []){
                switch (modelo) {
                    case 'asignaturaprofesor':
                    {
                        switch(accion){
                            case 'registrar':{
                                this.idprofesor = '';
                                this.idasignatura = '';
                                this.idcurso = '';
                                this.dia = '';
                                this.hora_inicio = '';
                                this.hora_fin = '';
                                this.semestre = '';
                                this.tituloModal = 'Registrar Asignatura Profesor';
                                this.tipoAccion = 1;
                                this.seleccionado = {};
                                this.asigSeleccionada = {};
                                this.cursoSeleccionado = {};
                                break;
                            }
                            case 'modificar':{
                                this.tituloModal= 'Modificar Asignatura Profesor';
                                this.tipoAccion = 2;                
                                this.idprofesor = data['idprofesor'];
                                this.idasignatura = data['idasignatura'];
                                this.idcurso = data['idcurso'];
                                this.dia = data['dia'];
                                this.hora_inicio = data['hora_inicio'];
                                this.hora_fin = data['hora_fin'];
                                this.jefe = data['jefe'];
                                this.semestre = data['semestre'];
                                this.nombreprofesor = data['nombreprofesor'];
                                this.nombreasignatura = data['nombreasignatura'];
                                this.nombrecurso = data['nombrecurso'];
                                this.asignaturaprofesor_id = data['id'];
                                this.seleccionado = {id: this.idprofesor, nombre: this.nombreprofesor};
                                this.asigSeleccionada = {id: this.idasignatura, nombre: this.nombreasignatura};
                                this.cursoSeleccionado = {id: this.idcurso, nombre: this.nombrecurso};
                                break;
                            }
                        }
                    }
                }
                
                this.listado = 0;
               
            }
            
        },
        mounted() {
            this.listarAsignaturaProfesor(1, this.buscar, this.criterio);
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
