<template>
    <div class="main">
        <div class="card">
            <div class="card-header">
                <button type="button" @click="abrirModal('usuario', 'registrar')" class="btn btn-primary"
                        data-toggle="modal" data-target="#modal-default">
                    <i class="fa fa-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                                <option value="nombre">Nombre</option>
                                <option value="email">Email</option>
                            </select>
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
                        <th>Email</th>
                        <th>Estatus</th>
                        <th>Perfil</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="usuario in usuarios" :key="usuario.id">
                        <td>
                            <button type="button" class="btn btn-warning btn-sm">
                                <i class="fa fa-pen"></i>
                            </button>
                            <template v-if="usuario.estatus">
                                <button type="button" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </template>
                            <template v-else>
                                <button type="button" class="btn btn-info btn-sm">
                                    <i class="fa fa-check"></i>
                                </button>
                            </template>
                        </td>
                        <td v-text="usuario.nombre"></td>
                        <td v-text="usuario.email"></td>
                        <td>
                            <template v-if="usuario.estatus">
                                <span class="badge bg-primary">Activo</span>
                            </template>
                            <template v-else>
                                <span class="badge bg-danger">Desactivo</span>
                            </template>
                        </td>
                        <td v-text="usuario.rol"></td>
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
        <div class="modal fade" :class="{'mostrar': modal}" id="modal-default" style="display: none;" aria-hidden="true">
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
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" :class="hasErrorNombre" id="nombre"
                                               name="nombre" v-model="nombre" placeholder="Nombre completo">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" :class="hasErrorEmail" id="email"
                                               name="email" v-model="email" placeholder="Introduce email">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" :class="hasErrorPassword"
                                               id="password" name="password" v-model="password"
                                               placeholder="Contraseña">
                                    </div>
                                    <div class="form-group">
                                        <label>Rol</label>
                                        <select class="form-control" :class="hasErrorIdRol" v-model="idRol">
                                            <option value="0" selected>Seleccione una opcion</option>
                                            <option v-for="rol in arrayRoles" :key="rol.id" :value="rol.id"
                                                    v-text="rol.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="registrarUsuario()">Guardar</button>
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
                errorUsuario: '',
                usuarios: [],
                offset: 3,
                modal: 0,
                email: '',
                idRol: 0,
                tituloModal: '',
                paginacion: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0
                },
                password: '',
                errorUsuario: 0,
                hasErrorEmail: '',
                hasErrorPassword: '',
                hasErrorIdRol: '',
                hasErrorNombre: '',
                allerros: [],
                nombre: '',
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
                this.selectRol();
                switch (modelo) {
                    case 'usuario':
                        this.modal = 1;
                        switch (accion) {
                            case 'registrar':
                                this.tituloModal = "Registro de uusarios";
                                break;
                        }
                        break;
                }
            },
            cambiarPagina(page, buscar, criterio) {
                let me = this;
                me.paginacion.current_page = page;
                me.listarPersona(page, buscar, criterio);
            },
            cerrarModal() {
                this.modal = 0;
                this.nombre = '';
                this.tituloModal = '';
                this.email = '';
                this.password = '';
                this.idRol = 0;
            },
            listarPersona(page, buscar, criterio) {
                var url = '/user/listado?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(response => {
                    this.usuarios = response.data.usuarios.data;
                    this.paginacion = response.data.pagination;
                });

            },
            selectRol() {
                let me = this;
                var url = '/rol/select-rol';
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayRoles = respuesta.roles;
                }).catch(function (error) {
                    console.log(error);
                });
            },
            registrarUsuario() {
                if (this.validarUsuario()) {
                    return
                }
                let me = this;
                axios.post('/user/registrar', {
                    'nombre': this.nombre,
                    'email': this.email,
                    'password': this.password,
                    'idRol': this.idRol,
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
            validarUsuario() {
                let valido = 0;
                if (this.nombre.length === 0){
                    this.hasErrorEmail = 'is-invalid';
                    this.$toastr.e("ERROR", "El nombre. No puede estar vacio");
                    valido = 1;
                }else{
                    this.hasErrorEmail =  'is-valid';
                }
                 if (this.email.length === 0){
                     this.hasErrorEmail = 'is-invalid';
                     this.$toastr.e("ERROR", "El email. No puede estar vacio");
                     valido = 1;
                 }else{
                     this.hasErrorEmail =  'is-valid';
                 }

                if (this.password.length === 0){
                    this.hasErrorPassword = 'is-invalid';
                    this.$toastr.e("SERROR", "La contrasena. No puede estar vacia");
                    valido = 1;

                }else{
                    this.hasErrorEmail =  'is-valid';
                }
                if (this.idRol === 0){
                    this.hasErrorIdRol = 'is-invalid';
                    this.$toastr.e("ERROR", "Selecciona un Rol");
                    valido = 1;
                }else{
                    this.hasErrorIdRol =  'is-valid';
                }
                return valido;
            },
        },
        created() {
            this.listarPersona(1, this.buscar, this.criterio);
        }
    }
</script>

