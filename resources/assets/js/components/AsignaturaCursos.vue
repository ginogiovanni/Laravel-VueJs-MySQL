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
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Cursos/Asignaturas
                        <button type="button" @click="abrirModal('curso','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripcion</option>
                                      <option value="jornada">Jornada</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarCurso(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarCurso(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Curso</th>
                                    <th>Alumno</th>
                                    <th>Asignatura</th>
                                    <th>Semestre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="curso in arrayCurso" :key="curso.id">
                                    <td v-text="curso.nombre +' '+ curso.descripcion"></td>
                                    <td v-text="curso.nombrealumno"></td>
                                    <td v-text="curso.nombreasignatura"></td>
                                    <td v-text="curso.semestre"></td>
                                    
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
                                    <label class="form-control-label col-md-3">Curso</label>
                                    <v-select class="col-md-9"
                                        :on-search="selectCurso"
                                        label="cursocom"
                                        :options="arrayCursoSelect"
                                        placeholder="Buscar curso..."
                                        :onChange="getDatosCurso"
                                    >
                                     <template slot="option" slot-scope="option">
                                        {{ option.cursocom}}
                                    </template>

                                    </v-select>
                                </div>
                                <div class="form-group row">
                                    <label class="form-control-label col-md-3" >Asignatura</label>
                                    <v-select class="col-md-9"
                                        :on-search="selectAsignatura"
                                        label="nombre"
                                        :options="arrayAsignatura"
                                        placeholder="Buscar asignaturas..."
                                        :onChange="getDatosAsignatura"
                                    >

                                    </v-select>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Semestre</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="semestre">
                                            <option value="" disabled>Seleccione</option>
                                            <option value="Primer Semestre">Primer Semestre</option>    
                                            <option value="Segundo Semestre">Segundo Semestre</option>    
                                        </select>                                       
                                    </div>
                                </div>
                                <div v-show="errorCurso" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjCurso" :key="error" v-text="error"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==0" class="btn btn-primary" @click="registrarCurso()">Guardar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="validarCursosAsignaturas()">Validar</button>
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
                curso_id : 0,
                nombre:'',
                descripcion:'',
                idcurso:0,
                asignatura:0,
                semestre: '',
                jornada:'',
                arrayCurso : [],
                idasignatura: 0,
                arrayAsignatura: [],
                arrayCursoSelect: [],
                arrayValidarCursosAsignaturas: [],
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
            }
        },
        methods : {
            listarCurso(page, buscar, criterio){
                let me = this;
                var url = '/cursosasignaturas?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayCurso = respuesta.cursosasignaturas.data;
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

            validarCursosAsignaturas(){
                this.tipoAccion = 0;
                
                let me = this;
                var url = '/cursosasignaturas/validarCursosAsignaturas?idasignatura='+me.idasignatura+'&idcurso='+me.idcurso+'&semestre='+me.semestre;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;                    
                    me.arrayValidarCursosAsignaturas = respuesta.resultados;
                    console.log(me.arrayValidarCursosAsignaturas);
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

            registrarCurso(){
                
                let me =this;
                if (this.validarCurso()) {
                    me.tipoAccion=1;
                     return;
                }

                
                console.log(me.curso + me.asignatura + me.semestre);

                axios.post('/cursosasignaturas/registrar', {
                    'idcurso': this.idcurso,
                    'idasignatura' : this.idasignatura,
                    'semestre' : this.semestre
                })
                .then(function (response) {
                    console.log(me.idcurso + me.idasignatura + me.semestre);
                    me.cerrarModal();
                    me.listarCurso(1, '', 'nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            modificarCurso(){
                if (this.validarCurso()) {
                    return;
                }

                let me =this;

                axios.put('/curso/modificar', {
                    'nombre': this.nombre,                    
                    'descripcion' : this.descripcion,
                    'jornada' : this.jornada,
                    'id': this.curso_id
                })
                .then(function (response) {
                    me.cerrarModal();
                    me.listarCurso(1, '', 'nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            desactivarCurso(id){
                
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: '¿Estás seguro de desactivar este curso?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/curso/desactivar', {
                        'id': id
                    })
                    .then(function (response) {
                        me.listarCurso(1, '', 'nombre');                        
                        swalWithBootstrapButtons(
                        'Desactivado!',
                        'El campo curso se desactivó con éxito.',
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

            selectCurso(search, loading){
                let me = this;
                loading(true)
                var url = '/curso/selectCurso?filtro='+search;
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta = response.data;
                    q: search
                    me.arrayCursoSelect = respuesta.cursos;
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


            activarCurso(id){
                
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: '¿Estas seguro de activar este curso?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/curso/activar', {
                        'id': id
                    })
                    .then(function (response) {
                        me.listarCurso(1, '', 'nombre');                        
                        swalWithBootstrapButtons(
                        'Activado!',
                        'El campo curso se activo con exito.',
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

            validarCurso(){
                
                this.errorCurso = 0;
                this.errorMostrarMsjCurso = [];
                
                //this.arrayValidarCursosAsignaturas = [];
                this.validarCursosAsignaturas();
                
                // if (this.jornada == "") {
                //     this.errorMostrarMsjCurso.push("Seleccione una jornada");
                // }
                if(!this.idcurso){
                     this.errorMostrarMsjCurso.push("Debe seleccionar un curso");
                }
                if(!this.idasignatura){
                     this.errorMostrarMsjCurso.push("Debe seleccionar una asignatura");
                }

                if(typeof this.validarCursosAsignaturas === 'undefined'){
                    this.errorMostrarMsjCurso.push("Debe seleccionar los registros");
                } 
                
                if(this.arrayValidarCursosAsignaturas.length > 0){
                     this.errorMostrarMsjCurso.push("La asignatura ya pertenece al curso seleccionado...");
                }else{
                }

                if (this.errorMostrarMsjCurso.length) {
                    this.errorCurso = 1;
                }

                return this.errorCurso;
            },

            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.nombre = '';
            },

            abrirModal(modelo, accion, data = []){
                switch (modelo) {
                    case 'curso':
                    {
                        switch(accion){
                            case 'registrar':{
                                this.modal = 1;
                                this.nombre = '';
                                this.tituloModal = 'Registrar Curso';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'modificar':{
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal= 'Modificar Curso';
                                this.tipoAccion = 2;                                
                                this.curso_id = data['id'];
                                this.nombre = data['nombre'];
                                this.descripcion = data['descripcion'];
                                this.jornada = data['jornada'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarCurso(1, this.buscar, this.criterio);
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
