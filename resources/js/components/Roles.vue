<template>
    <div class="main">
        <div class="card">
            <div class="card-header">
                <button type="button" @click="abrirModal('rol', 'registrar')" class="btn btn-primary"
                        data-toggle="modal" data-target="#modal-default">
                    <i class="fa fa-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" v-model="buscar" @keyup.enter="listarPersona(1, buscar, criterio)"
                                   class="form-control" placeholder="Texto a buscar">
                            <button type="submit" @click="listarPersona(1, buscar, criterio)" class="btn btn-primary"><i
                                class="fa fa-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </div>
                <table class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                        <th>Opciones</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estatus</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="rol in roles" :key="rol.id">
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" @click="abrirModal('rol', 'actualizar', rol)">
                                <i class="fa fa-pen"></i>
                            </button>
                            <template v-if="rol.activo">
                                <button type="button" class="btn btn-secondary btn-sm" @click="desactivarRol(rol.id)">
                                    <i class="fa fa-check"></i>
                                </button>
                            </template>
                            <template v-else>
                                <button type="button" class="btn btn-danger btn-sm" @click="activarRol(rol.id)">
                                    <i class="fa fa-trash"></i>
                                </button>

                            </template>
                        </td>
                        <td v-text="rol.nombre"></td>
                        <td v-text="rol.descripcion"></td>
                        <td>
                            <template v-if="rol.activo">
                                <span class="badge bg-primary">Activo</span>
                            </template>
                            <template v-else>
                                <span class="badge bg-danger">Desactivo</span>
                            </template>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="paginacion.current_page > 1">
                            <a class="page-link" href="#"
                               @click.prevent="cambiarPagina(paginacion.current_page - 1, buscar, criterio)">Ant</a>
                        </li>
                        <li class="page-item" v-for="page in pagesNumber" :key="page"
                            :class="[page == isActived ? 'active' : '']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)"
                               v-text="page"></a>
                        </li>
                        <li class="page-item" v-if="paginacion.current_page < paginacion.last_page">
                            <a class="page-link" href="#"
                               @click.prevent="cambiarPagina(paginacion.current_page + 1, buscar, criterio)">Sig</a>
                        </li>
                    </ul>
                </nav>

            </div>
            <!-- /.card-body -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="rol">Rol</label>
                                        <input type="text" class="form-control" :class="hasErrorNombre" id="rol"
                                               name="nombre" v-model="nombre" placeholder="Introduce rol">
                                    </div>
                                    <div class="form-group">
                                        <label for="descripcion">Descripcion</label>
                                        <textarea  class="form-control" :class="hasErrorDescripcion" id="descripcion"
                                                   name="email" v-model="descripcion" placeholder="Introduce descripcion"></textarea>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarRol()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarRol()">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                arrayRoles: [],
                buscar: '',
                criterio: 'nombre',
                errorRol: '',
                roles: [],
                offset: 10,
                modal: 0,
                descripcion: '',
                tituloModal: '',
                paginacion: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0
                },
                errorRol: 0,
                hasErrorDescripcion: '',
                hasErrorNombre: '',
                allerros: [],
                nombre: '',
                tipoAccion : 0,
                idRol: 0,
            }
        },
        computed: {
            isActived: function () {
                return this.paginacion.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function () {
                if (!this.paginacion.to) {
                    return [];
                }
                var from = this.paginacion.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if (to >= this.paginacion.last_page) {
                    to = this.paginacion.last_page;
                }
                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods: {
            abrirModal(modelo, accion, data = []) {
                switch (modelo) {
                    case 'rol':
                        //this.modal = 1;
                        $('#modal-default').modal('show');
                        switch (accion) {
                            case 'registrar':
                                this.tipoAccion = 1;
                                this.tituloModal = "Registro de Roles";
                                this.nombre = "";
                                this.descripcion = "";
                                this.activo = 0;
                                break;
                            case 'actualizar':
                                this.tituloModal = "Actualizar rol";
                                this.nombre = data['nombre'];
                                this.descripcion = data['descripcion'];
                                this.tipoAccion = 2;
                                this.idRol = data['id'];
                                break
                        }
                        break;
                }
            },
            actualizarRol(){
                if (this.validarRol()){
                    return;
                }
                let me = this;
                axios.put('/rol/actualizar',{
                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'activo': 1,
                    'id': this.idRol
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarPersona(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });

            },
            cambiarPagina(page, buscar, criterio) {
                let me = this;
                me.paginacion.current_page = page;
                me.listarPersona(page, buscar, criterio);
            },
            cerrarModal() {
                $('#modal-default').modal('hide');
                this.nombre = '';
                this.tituloModal = '';
                this.descripcion = '';
                this.idRol = 0;
            },
            listarPersona(page, buscar, criterio) {
                var url = '/rol/listado?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(response => {
                    this.roles = response.data.roles.data;
                    this.paginacion = response.data.pagination;
                });

            },
            registrarRol() {
                if (this.validarRol()) {
                    return
                }
                let me = this;
                axios.post('/rol/registrar', {
                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'activo': 1
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarPersona(1, '', 'nombre');
                }).catch((error) => {
                    console.log(error);
                    this.allerros = error.response.data.errors;
                    this.success = false;
                });
            },
            validarRol() {
                let valido = 0;
                if (this.nombre.length === 0){
                    this.hasErrorNombre = 'is-invalid';
                    this.$toastr.e("ERROR", "El nombre. No puede estar vacio");
                    valido = 1;
                }else{
                    this.hasErrorNombre =  'is-valid';
                }
                 if (this.descripcion.length === 0){
                     this.hasErrorDescripcion = 'is-invalid';
                     this.$toastr.e("ERROR", "La descripón. No puede estar vacia");
                     valido = 1;
                 }else{
                     this.hasErrorDescripcion =  'is-valid';
                 }

                return valido;
            },
            desactivarRol(id){
                Swal.fire({
                    title: '¿Estás seguro de, desactivar este rol?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, desactivar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        let me = this;
                        axios.put('/rol/desactivar',{
                            'id' : id
                        }).then(function (response) {
                            me.listarPersona(1,'','nombre');
                            Swal.fire(
                                'Desactivado!',
                                'Tu rol ha sido desactivado',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });
                    }
                });
            },
            activarRol(id){
                Swal.fire({
                    title: '¿Esta seguro de activar este rol?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, activar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        let me = this;
                        axios.put('/rol/activar',{
                            'id' : id
                        }).then(function (response) {
                            me.listarPersona(1,'','nombre');
                            Swal.fire(
                                'Activado!',
                                'Tu rol ha sido activado',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });
                    }
                });
            }
        },
        created() {
            this.listarPersona(1, this.buscar, this.criterio);
        }
    }
</script>

