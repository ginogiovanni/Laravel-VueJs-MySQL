@extends('principal')
@section('contenido')

@if(Auth::check())
    @if(Auth::user()->idrol == 1)  
        <template v-if="menu==0">
            <bienvenida></bienvenida>
        </template>
        <template v-if="menu==1">
            <asignatura></asignatura>
        </template>
        <template v-if="menu==2">
            <curso></curso>
        </template>
        <template v-if="menu==3">
            <personal></personal>
        </template>
        <template v-if="menu==4">
            <profesor></profesor>
        </template>
        <template v-if="menu==5">
            <apoderado></apoderado>
        </template>
        <template v-if="menu==6">
            <alumno></alumno>
        </template>
        <template v-if="menu==7">
            <asignaturaprofesor></asignaturaprofesor>
        </template>
        <template v-if="menu==8">
            <rol></rol>
        </template>
        <template v-if="menu==9">
            <usuariospersonal></usuariospersonal>
        </template>
        <template v-if="menu==10">
            <usuariosprofesor></usuariosprofesor>
        </template>
        <template v-if="menu==11">
            <usuariosapoderado></usuariosapoderado>        
        </template>
        <template v-if="menu==12">
            <asignaturacurso></asignaturacurso>        
        </template>
        
        <template v-if="menu==15">
            <eventos></eventos>        
        </template>
        <template v-if="menu==17">
            <alumnosreport></alumnosreport>        
        </template>
        <template v-if="menu==18">
            <comunicacionescursosreport></comunicacionescursosreport>    
        </template>
        <template v-if="menu==19">
            <comunicacionesapodreport></comunicacionesapodreport>    
        </template>
    @elseif(Auth::user()->idrol == 2)  

        <template v-if="menu==0">
            <bienvenida></bienvenida>
        </template>
        
        <template v-if="menu==12">
            <asignaturaunprofesor></asignaturaunprofesor>
        </template>

        <template v-if="menu==14">
            <comunicacionesapoderados></comunicacionesapoderados>    
        </template>
        <template v-if="menu==16">
            <comunicacionescursos></comunicacionescursos>    
        </template>
    @else
    @endif
@endif


@endsection
