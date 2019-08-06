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
                        <i class="fa fa-align-justify"></i> Mis Asignaturas
                        <!-- <button type="button" @click="abrirModal('asignaturaprofesor','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp; Nuevo
                        </button> -->
                    </div>
                    
                    <template v-if="cursos">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="dia" selected>Día</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarMisAsignaturas(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarMisAsignaturas(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Asignatura</th>
                                    <th>Día</th>
                                    <th>Hora Inicio</th>
                                    <th>Hora Fin</th>
                                    <th>semestre</th>
                                    <th>Curso</th>
                                    <th>Profesor Jefe</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(misasignaturas, i) in arrayMisAsignaturas" :key="i">
                                    <td>
                                        <button type="submit" @click="mostrarAlumnos(misasignaturas)" class="btn btn-success btn-sm"><i class="fa fa-search"></i> Ver</button>
                                        <button type="button" @click="abrirModalComunicacionCurso('comunicacionCursos','registrar', misasignaturas)" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>&nbsp; Comunicacion
                                         </button>
                                    </td>
                                    <td v-text="misasignaturas.nombreasignatura"></td>
                                    <td v-text="misasignaturas.dia"></td>
                                    <td v-text="misasignaturas.hora_inicio"></td>
                                    <td v-text="misasignaturas.hora_fin"></td>
                                    <td v-text="misasignaturas.semestre"></td>
                                    <td v-text="misasignaturas.nombrecurso +' '+ misasignaturas.descripcioncurso"></td>                                    
                                    <td>
                                        <div v-if="misasignaturas.jefe">
                                            <span class="badge badge-success">Si</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-warning">No</span>
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
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre" selected>Nombre</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="alumnosPorCurso(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="alumnosPorCurso(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Rut</th>
                                    <th>Nombre Alumno</th>
                                    <th>Nombre Apoderado</th>
                                    <th>Telefono Apoderado</th>
                                    <th>Curso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(alumnosPorCurso, i) in arrayAlumnosPorCurso" :key="`A-${i}`">
                                    <td>
                                         <button type="button" @click="abrirModal('alumnosPorCurso','modificar', alumnosPorCurso)" class="btn btn-success btn-sm"><i class="fa fa-search"></i>&nbsp; Notas
                                         </button>
                                         <button type="button" @click="abrirModalComunicacion('alumnosPorCurso','registrar', alumnosPorCurso)" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>&nbsp; Comunicacion
                                         </button>
                                    </td>
                                    <td v-text="alumnosPorCurso.rut"></td>
                                    <td v-text="alumnosPorCurso.nombre"></td>
                                    <td v-text="alumnosPorCurso.nombre_apoderado"></td>
                                    <td v-text="alumnosPorCurso.telefono_apoderado"></td>
                                    <td v-text="alumnosPorCurso.curso_nombre +' '+ alumnosPorCurso.curso_desc"></td>
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
                        <button type="button" class="btn btn-secondary" @click="ocultarAlumnos()">Cerrar</button>
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
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nota 1</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nota1" class="form-control" pattern="[0-9.]+" required="Este campo es requerido" maxlength="3" title="Solo Numeros">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nota 2</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nota2" class="form-control" pattern="[0-9.]+" required="Este campo es requerido" maxlength="3" title="Solo Numeros" >                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nota 3</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nota3" class="form-control" pattern="[0-9.]+" required="Este campo es requerido" maxlength="3" title="Solo Numeros">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nota 4</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nota4" class="form-control" pattern="[0-9.]+" required="Este campo es requerido" maxlength="3" title="Solo Numeros">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nota 5</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nota5" class="form-control" pattern="[0-9.]+" required="Este campo es requerido" maxlength="3" title="Solo Numeros">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nota 6</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nota6" class="form-control" pattern="[0-9.]+" required="Este campo es requerido" maxlength="3" title="Solo Numeros">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nota 7</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nota7" class="form-control" pattern="[0-9.]+" required="Este campo es requerido" maxlength="3" title="Solo Numeros">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nota 8</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nota8" class="form-control" pattern="[0-9.]+" required="Este campo es requerido" maxlength="3" title="Solo Numeros">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nota 9</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nota9" class="form-control" pattern="[0-9.]+" required="Este campo es requerido" maxlength="3" title="Solo Numeros">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nota 10</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nota10" class="form-control" pattern="[0-9.]+" required="Este campo es requerido" maxlength="3" title="Solo Numeros">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nota 11</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nota11" class="form-control" pattern="[0-9.]+" required="Este campo es requerido" maxlength="3" title="Solo Numeros">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nota 12</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nota12" class="form-control" pattern="[0-9.]+" required="Este campo es requerido" maxlength="3" title="Solo Numeros">                                        
                                    </div>
                                </div>
                                <!-- <div v-show="errorAsignatura" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjAsignatura" :key="error" v-text="error"></div>
                                    </div>
                                </div> -->
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" class="btn btn-primary" @click="modificarNotas()">Modificar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->

            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalComunicacion}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModalComunicacion"></h4>
                            <button type="button" class="close" @click="cerrarModalComunicacion()" aria-label="Close">
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
                                <div v-show="errorComunicacionApod" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjComunicacionApod" :key="error" v-text="error"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModalComunicacion()">Cerrar</button>
                            <button type="button" class="btn btn-primary" @click="registrarComunicacion()">Enviar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->

            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalComunicacionCurso}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModalComunicacionCurso"></h4>
                            <button type="button" class="close" @click="cerrarModalComunicacion()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Titulo</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="tituloCurso" class="form-control" placeholder="Titulo Comunicacion" required="Este campo es requerido"  maxlength="100">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Mensaje</label>
                                    <div class="col-md-9">
                                        <textarea v-model="mensajeCurso" rows="15" cols="60">
                                       
                                        </textarea> 
                                    </div>
                                </div>
                                <div v-show="errorComunicacionCurso" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjComunicacionCurso" :key="error" v-text="error"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModalComunicacionCurso()">Cerrar</button>
                            <button type="button" class="btn btn-primary" @click="registrarComunicacionCurso()">Registrar</button>
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
                errorComunicacionCurso : 0,
                errorMostrarMsjComunicacionCurso : [],
                errorComunicacionApod : 0,
                errorMostrarMsjComunicacionApod : [],
                arrayMisAsignaturas : [],
                arrayAlumnosPorCurso : [],
                idcurso : 0,
                idasignatura: 0,
                idapoderado: 0,
                idprofesor: 0,
                idprofesorCurso: 0,
                idcursoCurso: 0,
                semestre: '',
                titulo: '',
                tituloCurso: '',
                mensaje: '',
                mensajeCurso: '',
                cursos: 1,
                nota1: 0.0,
                nota2: 0.0,
                nota3: 0.0,
                nota4: 0.0,
                nota5: 0.0,
                nota6: 0.0,
                nota7: 0.0,
                nota8: 0.0,
                nota9: 0.0,
                nota10: 0.0,
                nota11: 0.0,
                nota12: 0.0,
                notas_id: 0,
                
                modal : 0,
                modalComunicacion: 0,
                modalComunicacionCurso: 0,
                tituloModal :  '',
                tituloModalComunicacion :  '',
                tituloModalComunicacionCurso :  '',

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
            },
            
        },
        methods : {
            cambiarPagina(page, buscar, criterio){
                let me = this;
                me.pagination.current_page = page;
                me.listarMisAsignaturas(page, buscar, criterio);
            },

            registrarComunicacion(){
                if (this.validarComunicacionApod()) {
                     return;
                }
                let me =this;

                axios.post('/comunicacionesapoderados/registrar', {
                    'titulo': this.titulo,
                    'mensaje' : this.mensaje,
                    'idprofesor' : this.idprofesor,
                    'idapoderado' : this.idapoderado
                })
                .then(function (response) {
                    me.cerrarModalComunicacion();
                    me.alumnosPorCurso(1, '', 'nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            registrarComunicacionCurso(){
                if (this.validarComunicacionCurso()) {
                     return;
                }
                let me =this;

                axios.post('/comunicacionescursos/registrar', {
                    'titulo': this.tituloCurso,
                    'mensaje' : this.mensajeCurso,
                    'idprofesor' : this.idprofesorCurso,
                    'idcurso' : this.idcursoCurso
                })
                .then(function (response) {
                    me.cerrarModalComunicacionCurso();
                    me.listarMisAsignaturas(1, '', 'nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            listarMisAsignaturas(page, buscar, criterio){
                let me = this;
                var url = '/getasignaturaprofesor?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayMisAsignaturas = respuesta.asignaturasprofesores.data;
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

            alumnosPorCurso(page, buscar, criterio){
                let me = this;
                var url = '/alumno/porcurso?filtro='+me.idcurso+'&page='+page+'&buscar='+buscar+'&criterio='+criterio+'&idasignatura='+me.idasignatura+'&idcurso='+me.idcurso+'&semestre='+me.semestre;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayAlumnosPorCurso = respuesta.alumnos.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
            },
            modificarNotas(){

                let me =this;

                axios.put('/cursosasignaturas/modificar', {
                    'nota1' : this.nota1,
                    'nota2' : this.nota2,
                    'nota3' : this.nota3,
                    'nota4' : this.nota4,
                    'nota5' : this.nota5,
                    'nota6' : this.nota6,
                    'nota7' : this.nota7,
                    'nota8' : this.nota8,
                    'nota9' : this.nota9,
                    'nota10' : this.nota10,
                    'nota11' : this.nota11,
                    'nota12' : this.nota12,
                    'id': this.notas_id
                })
                .then(function (response) {
                    me.cerrarModal();
                    me.alumnosPorCurso(1, '', 'nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            ocultarAlumnos(){
                this.cursos = 1;
            },
            mostrarAlumnos(data = []){
                this.idcurso = data['idcurso'];
                this.idasignatura = data['idasignatura'];
                this.semestre = data['semestre'];
                this.cursos = 0;
                this.alumnosPorCurso(1, this.buscar, this.criterio);
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
            },
            
            cerrarModalComunicacion(){
                this.modalComunicacion = 0;
                this.tituloModalComunicacion = '';
            },

             abrirModalComunicacion(modelo, accion, data = []){
                switch (modelo) {
                    case 'alumnosPorCurso':
                    {
                        switch(accion){
                            case 'registrar':{
                                this.tituloModalComunicacion= 'Enviar comunicación a ' +data['nombre_apoderado'];
                                this.modalComunicacion = 1;
                                this.idprofesor = data['idprofesor'];
                                this.idapoderado = data['idapoderado'];
                                this.titulo = data['titulo'];
                                this.mensaje = data['mensaje'];
                                break;
                            }
                        }
                    }
                }
            },
            cerrarModalComunicacionCurso(){
                this.modalComunicacionCurso = 0;
                this.tituloModalComunicacionCurso = '';
            },

            abrirModalComunicacionCurso(modelo, accion, data = []){
                switch (modelo) {
                    case 'comunicacionCursos':
                    {
                        switch(accion){
                            case 'registrar':{
                                this.tituloModalComunicacionCurso= 'Enviar comunicación al curso ' +data['nombrecurso'] + ' '+ data['descripcioncurso'];
                                this.modalComunicacionCurso = 1;
                                this.idprofesorCurso = data['idprofesor'];
                                this.idcursoCurso = data['idcurso'];
                                break;
                            }
                        }
                    }
                }
            },

            abrirModal(modelo, accion, data = []){
                switch (modelo) {
                    case 'alumnosPorCurso':
                    {
                        switch(accion){
                            case 'modificar':{
                                this.tituloModal= 'Ingresar/Modificar Notas';
                                this.modal = 1;                              
                                this.notas_id = data['id'];
                                this.nota1 = data['nota1'];
                                this.nota2 = data['nota2'];
                                this.nota3 = data['nota3'];
                                this.nota4 = data['nota4'];
                                this.nota5 = data['nota5'];
                                this.nota6 = data['nota6'];
                                this.nota7 = data['nota7'];
                                this.nota8 = data['nota8'];
                                this.nota9 = data['nota9'];
                                this.nota10 = data['nota10'];
                                this.nota11 = data['nota11'];
                                this.nota12 = data['nota12'];
                                break;
                            }
                        }
                    }
                }
            },

            validarComunicacionCurso(){
                this.errorComunicacionCurso = 0;
                this.errorMostrarMsjComunicacionCurso = [];

                if (!this.tituloCurso) {
                    this.errorMostrarMsjComunicacionCurso.push("El titulo de la comunicación no puede estar vacío");
                }
                if (!this.mensajeCurso) {
                    this.errorMostrarMsjComunicacionCurso.push("El mensaje de la comunicación no puede estar vacío");
                }

                if (this.errorMostrarMsjComunicacionCurso.length) {
                    this.errorComunicacionCurso = 1;
                }

                return this.errorComunicacionCurso;
            },

            validarComunicacionApod(){
                this.errorComunicacionApod = 0;
                this.errorMostrarMsjComunicacionApod = [];

                if (!this.tituloApod) {
                    this.errorMostrarMsjComunicacionApod.push("El titulo de la comunicación no puede estar vacío");
                }
                if (!this.mensajeApod) {
                    this.errorMostrarMsjComunicacionApod.push("El mensaje de la comunicación no puede estar vacío");
                }

                if (this.errorMostrarMsjComunicacionApod.length) {
                    this.errorComunicacionApod = 1;
                }

                return this.errorComunicacionApod;
            }
        },
        mounted() {
            this.listarMisAsignaturas(1, this.buscar, this.criterio);
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
.modal-body {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
}
</style>