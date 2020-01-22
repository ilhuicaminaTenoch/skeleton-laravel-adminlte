<template>
    <div class="card">
        <div class="card-header">
            <button type="button"  @click="abrirModal('persona', 'registrar')" class="btn btn-primary" >
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
                    <td v-text="usuario.estatus"></td>
                    <td v-text="usuario.rol"></td>
                </tr>
                </tbody>
            </table>
            <nav>
                <ul class="pagination">
                    <li class="page-item" v-if="paginacion.current_page > 1">
                        <a class="page-link" href="#" @click.prevent="cambiarPagina(paginacion.current_page - 1, buscar, criterio)">Ant</a>
                    </li>
                    <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                        <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page"></a>
                    </li>
                    <li class="page-item" v-if="paginacion.current_page < paginacion.last_page">
                        <a class="page-link" href="#" @click.prevent="cambiarPagina(paginacion.current_page + 1, buscar, criterio)" >Sig</a>
                    </li>
                </ul>
            </nav>

        </div>
        <!-- /.card-body -->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                buscar: '',
                criterio: 'nombre',
                usuarios: [],
                offset : 3,
                paginacion :{
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0
                },
            }
        },
        computed:{
            isActived: function () {
                return this.paginacion.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.paginacion.to) {
                    return [];
                }
                var from = this.paginacion.current_page - this.offset;
                if(from < 1) {
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if(to >= this.paginacion.last_page){
                    to = this.paginacion.last_page;
                }
                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods: {
            abrirModal(modelo, accion, data = []){
              console.log('se abre modal');
            },
            cambiarPagina(page, buscar, criterio){
                let me = this;
                me.paginacion.current_page = page;
                me.listarPersona(page, buscar, criterio);
            },

            listarPersona(page, buscar, criterio) {
                var url = '/user/listado?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(response => {
                   this.usuarios = response.data.usuarios.data;
                   this.paginacion = response.data.pagination;
                });

            },
        },
        created() {
            this.listarPersona(1, this.buscar, this.criterio);
        }
    }
</script>

