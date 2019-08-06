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
                        <i class="fa fa-align-justify"></i> Reporte de comunicaciones por curso
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="">
                                    <v-select
                                        :on-search="selectCurso"
                                        label="cursocom"
                                        :options="arrayCurso"
                                        placeholder="Buscar curso..."
                                        :onChange="getDatosCurso"
                                    >
                                     <template slot="option" slot-scope="option">
                                        {{ option.cursocom}}
                                    </template>

                                    </v-select>
                                    <br>
                                    <button type="submit" @click="listarReporte(1)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm" v-if="condicion">
                            <thead>
                                <tr>
                                    <th>Creador</th>
                                    <th>Título</th>
                                    <th>Mensaje</th>
                                    <th>Fecha Creación</th>
                                    <th>Curso</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="comunicacion in arrayComu" :key="comunicacion.id">
                                    <td v-text="comunicacion.nombreprofesor"></td>
                                    <td v-text="comunicacion.titulo"></td>
                                    <td v-text="comunicacion.mensaje"></td>
                                    <td v-text="comunicacion.created_at"></td>
                                    <td v-text="comunicacion.nombre + ' ' + comunicacion.descripcion"></td>
                                    <td>
                                        <div v-if="comunicacion.estado">
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
        </main>

</template>

<script>
 import vSelect from 'vue-select';
    export default {
        data(){
            return{
                arrayComu: [],
                arrayCurso: [],
                idcurso: 0,
                condicion: 0,

                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },

                offset : 3,
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
            listarReporte(page){
                this.condicion = 1;
                let me = this;
                var url = '/comucursos/report?buscar='+me.idcurso;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayComu = respuesta.comunicaciones.data;
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
                me.listarReporte(page, buscar, criterio);
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
        },
        mounted() {
            
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
