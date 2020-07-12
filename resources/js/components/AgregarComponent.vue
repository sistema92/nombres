<template>
<div class="container container-task">
    <div class="row">
        <div class="col-md-6">

            <!--FORMULARIO DE BUSQUEDA-->
            <nav class="navbar navbar-light float-right" role="search">
                <div class="form-inline">
                    <input type="search" v-model="buscador" class="form-control mr-sm-2" placeholder="Buscar por Nombre"
                    aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0"
                @click="buscardatos">Buscar</button>
            </div>
            </nav>

            <label><h2>Lista de Registrados</h2></label>

            <table class="table text-center">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Edad</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="listado in listados">
                        <td v-text="listado.nombre"></td>
                        <td v-text="listado.apellido"></td>
                        <td v-text="listado.edad"></td>
                        <button class="btn"  @click="cargarDatos(listado)">Modificar</button>
                        <button class="btn" @click="deleteNombre(listado)">Borrar</button>

                    </tr>

                </tbody>
            </table>
    <nav class="Page navigation example">
<ul class="pagination">
<li class="page-item">
<a class="page-link" href="#" aria-label="Previous" v-on:click="fetchPagination(pagination.prev_page_url)"
:disabled="!pagination.prev_page_url">
    <span aria-hidden="true">&laquo;</span>
</a>
</li>
<li class="page-item"> <a class="page-link" href="#">{{ pagination.current_page}}</a></li>
<li class="page-item"> <a class="page-link" href="#">{{pagination.last_page}}</a></li>

<li  class="page-item">
<a class="page-link" href="#" aria-label="Previous" v-on:click="fetchPagination(pagination.next_page_url)"
:disabled="!pagination.next_page_url">
    <span aria-hidden="true">&raquo;</span>
</a>
</li>

</ul>
</nav>


        </div>




            <div class="col-md-6" v-if="modoeditar">
                    <div  class="form-group">
                        <label for="nombre">Nombre</label>
                        <span v-if="!nombre" style="color:red;">Requerido*</span>
                        <input type="text" class="form-control" v-model="nombres.nombre">

                        <label>Apellido</label>
                        <span v-if="!apellido" style="color:red;">Requerido*</span>
                        <input type="text" class="form-control"  v-model="nombres.apellido" >

                        <label>Edad</label>
                        <span v-if="!edad" style="color:red;">Requerido*</span>
                        <input type="text" class="form-control" v-model="nombres.edad">
                    </div>

                     <div class="container-buttons">
                        <button  class="btn btn-warning" @click="updateDatos(nombres)">Actuliazar</button>
                        <button  class="btn btn-success" @click="vaciarDatos">Cancelar</button>
                    </div>

            </div>

            <div class="col-md-6" v-else>
                    <div  class="form-group">
                        <label for="nombre">Nombre</label>
                        <span v-if="!nombre" style="color:red;">Requerido*</span>
                        <input type="text" class="form-control" v-model="nombre">

                        <label>Apellido</label>
                        <span v-if="!apellido" style="color:red;">Requerido*</span>
                        <input type="text" class="form-control"  v-model="apellido" >

                        <label>Edad</label>
                        <span v-if="!edad" style="color:red;">Requerido*</span>
                        <input type="text" class="form-control" v-model="edad">
                    </div>

                    <div class="container-buttons">
                        <button  class="btn btn-success" @click="guardarDatos">Agregar</button>
                    </div>

            </div>





    </div>

</div>
</template>

<script>

import axios from 'axios';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/src/sweetalert2.scss';

  export default {
        data(){
            return{

                nombre:'',
                apellido:'',
                edad:'',
                modoeditar:false,
                listados:[],
                nombres:{id:'',nombre:'',apellido:'',edad:''},
                pagination:[], //VARIABLE DE PAGINACION
                url:'Nombre', //VARIABLE DE PAGINACION
                 url2:'Buscar', //VARIABLE DE PAGINACION
                buscador:'',

            }
        },
        methods:{
            guardarDatos:function(){

                //VALIDACION DE CAMPOS VACIOS
                if(this.nombre.trim() === '' || this.apellido.trim() === ''
                || this.edad.trim() === ''){
                Swal.fire({
                icon: 'info',
                title: 'Hay Campos Requeridos que debes llenar',
                showConfirmButton: false,
                timer: 1000
                });

                return;
                     }

                let me=this;
                let url='Nombre';
                axios.post(url,{
                    nombre:this.nombre,
                    apellido:this.apellido,
                    edad:this.edad
                     }).then((res)=>{
                         me.mostrardatos();
                         this.nombre='';
                         this.apellido='';
                         this.edad='';
                            const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1000,
                            timerProgressBar: true,
                            onOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                            });

                            Toast.fire({
                            icon: 'success',
                            title: 'Se guardado Existosamente'
                            });
                     }).catch(function(error){
                         console.log(error);
                     });

            },
            //LISTAR LOS DATOS
            mostrardatos:function(){
                let me=this;
                //let url='Nombre';
                axios.get(this.url).then(res=>{

                    me.listados=res.data.data;
                    me.makepaginacion(res.data); //PASA LA VARIABLE PAGINATION AL CONTROLADOR
                }).catch(function(error){
                         console.log(error);
                     });


            },

            //BUSCAR LOS DATOS (NOMBRE)
            buscardatos:function(){
                let me=this;
                //let url='Nombre';
                axios.get('Buscar?nombre='+this.buscador).then(res=>{
                    console.log(res.data);
                     me.listados=res.data.data;
                      me.makepaginacion(res.data); //PASA LA VARIABLE PAGINATION AL CONTROLADOR
                }).catch(function(error){
                         console.log(error);
                     });

            },


            //PASAR LOS DATOS AL FORMULARIO
            cargarDatos:function(data){
                    this.nombres.id=data.id;
                    this.nombres.nombre=data.nombre;
                    this.nombres.apellido=data.apellido;
                    this.nombres.edad=data.edad;
                    this.modoeditar=true;
            },
            deleteNombre:function(data){
                var id=data.id;
                axios.delete('Nombre/'+id).then(res=>{

                const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1000,
                            timerProgressBar: true,
                            onOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                            });

                            Toast.fire({
                            icon: 'danger',
                            title: 'Se Elimino Existosamente'
                            });
                 this.mostrardatos();
                this.vaciarDatos();


                }).catch(function(error){
                   console.log($error);
                });

            },
            updateDatos:function(nombres){
                var id=this.nombres.id;
                this.modoeditar=true;
                let me =this;

                axios.put('Nombre/'+id,{nombre:nombres.nombre,
                apellido:nombres.apellido,
                edad:nombres.edad}).then(res=>{
                    me.modoeditar=false;
                    me.mostrardatos();
                    me.vaciarDatos();

                }).catch(function(error){
                   console.log($error);
                });


            },
            vaciarDatos:function(){
                this.modoeditar=false;
                this.nombre="";
                this.apellido="";
                this.edad="";

            },//FUNCION PARA PAGINACION PARA LA LISTA DE NOTA
makepaginacion:function(data){
let pagination={
current_page:data.current_page,
last_page:data.last_page,
next_page_url:data.next_page_url,
prev_page_url:data.prev_page_url
};
this.pagination=pagination;
},
fetchPagination:function(url){
this.url=url;
this.mostrardatos();

},




        },
        created(){
            this.mostrardatos();
        }
    }
</script>
