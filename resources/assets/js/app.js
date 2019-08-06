
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

var vueRut = require('vue-rut');

Vue.use(vueRut);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('asignatura', require('./components/Asignatura.vue'));
Vue.component('curso', require('./components/Curso.vue'));
Vue.component('bienvenida', require('./components/Bienvenida.vue'));
Vue.component('personal', require('./components/Personal.vue'));
Vue.component('profesor', require('./components/Profesor.vue'));
Vue.component('apoderado', require('./components/Apoderado.vue'));
Vue.component('alumno', require('./components/Alumno.vue'));
Vue.component('asignaturaprofesor', require('./components/AsignaturaProfesor.vue'));
Vue.component('rol', require('./components/Rol.vue'));
Vue.component('usuariospersonal', require('./components/UsuarioPersonal.vue'));
Vue.component('usuariosprofesor', require('./components/UsuarioProfesor.vue'));
Vue.component('usuariosapoderado', require('./components/UsuarioApoderado.vue'));
Vue.component('asignaturaunprofesor', require('./components/AsignaturasUnProfesor.vue'));
Vue.component('asignaturacurso', require('./components/AsignaturaCursos.vue'));
Vue.component('comunicacionesapoderados', require('./components/ComunicacionesApoderados.vue'));
Vue.component('comunicacionescursos', require('./components/ComunicacionesCursos.vue'));
Vue.component('eventos', require('./components/Evento.vue'));
Vue.component('alumnosreport', require('./components/AlumnoReport.vue'));
Vue.component('comunicacionescursosreport', require('./components/ComunicacionCursoReport.vue'));
Vue.component('comunicacionesapodreport', require('./components/ComunicacionApodReport.vue'));


const app = new Vue({
    el: '#app',
    data :{
        menu : 0,
        rut : ''
    }
});
