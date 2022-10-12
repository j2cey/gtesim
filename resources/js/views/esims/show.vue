<template>
    <div class="card">
        <header>
            <div class="card-header-title row">
                <div class="col-md-3 col-sm-8 col-12">
                    <span class="text-purple text-sm">

                    </span>
                </div>
                <div class="col-md-3 col-sm-4 col-12 text-right">
                    <span class="text text-sm">
                        <a v-if="can('esim-edit')" type="button" class="btn btn-tool text-warning" data-toggle="tooltip" @click="editEsim(esim)">
                            <i class="fa fa-pencil-square-o"></i>
                        </a>
                        <a v-if="can('esim-delete')" type="button" class="btn btn-tool text-danger" @click="deleteEsim(esim)">
                            <i class="fas fa-trash"></i>
                        </a>
                    </span>
                </div>
            </div>
            <!-- /.user-block -->
        </header>
        <!-- /.card-header -->
        <div class="card-content">

            <div class="row">

                <div class="col-md-12">

                    <form role="form">
                        <div class="form-group row">
                            <label for="esim_id" class="col-sm-2 col-form-label text-xs">ID</label>
                            <div class="col-sm-10">
                                <input readonly type="text" class="form-control form-control-sm border-0" style="background-color: white" id="esim_id" name="id" placeholder="Type" v-model="esim.id">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="imsi" class="col-sm-2 col-form-label text-xs">IMSI</label>
                            <div class="col-sm-10">
                                <input readonly type="text" class="form-control form-control-sm border-0" style="background-color: white" id="imsi" name="imsi" placeholder="Type" v-model="esim.imsi">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="iccid" class="col-sm-2 col-form-label text-xs">ICCID</label>
                            <div class="col-sm-10">
                                <input readonly type="text" class="form-control form-control-sm border-0" style="background-color: white" id="iccid" name="iccid" placeholder="iccid" v-model="esim.iccid">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ac" class="col-sm-2 col-form-label text-xs">AC</label>
                            <div class="col-sm-10">
                                <input readonly type="text" class="form-control form-control-sm border-0" style="background-color: white" id="ac" name="ac" placeholder="ac" v-model="esim.ac">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pin" class="col-sm-2 col-form-label text-xs">PIN</label>
                            <div class="col-sm-2">
                                <input readonly type="text" class="form-control form-control-sm border-0" style="background-color: white" id="pin" name="pin" placeholder="pin" v-model="esim.pin">
                            </div>

                            <label for="puk" class="col-sm-2 col-form-label text-xs">PUK</label>
                            <div class="col-sm-2">
                                <input readonly type="text" class="form-control form-control-sm border-0" style="background-color: white" id="puk" name="puk" placeholder="puk" v-model="esim.puk">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pin2" class="col-sm-2 col-form-label text-xs">PIN 2</label>
                            <div class="col-sm-2">
                                <input readonly type="text" class="form-control form-control-sm border-0" style="background-color: white" id="pin2" name="pin2" placeholder="pin2" v-model="esim.pin2">
                            </div>

                            <label for="puk2" class="col-sm-2 col-form-label text-xs">PUK 2</label>
                            <div class="col-sm-2">
                                <input readonly type="text" class="form-control form-control-sm border-0" style="background-color: white" id="puk2" name="puk2" placeholder="puk2" v-model="esim.puk2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="eki" class="col-sm-2 col-form-label text-xs">EKI</label>
                            <div class="col-sm-2">
                                <input readonly type="text" class="form-control form-control-sm border-0" style="background-color: white" id="eki" name="eki" placeholder="eki" v-model="esim.eki">
                            </div>

                            <label for="adm1" class="col-sm-2 col-form-label text-xs">ADM 1</label>
                            <div class="col-sm-2">
                                <input readonly type="text" class="form-control form-control-sm border-0" style="background-color: white" id="adm1" name="adm1" placeholder="adm1" v-model="esim.adm1">
                            </div>

                            <label for="opc" class="col-sm-2 col-form-label text-xs">OPC</label>
                            <div class="col-sm-2">
                                <input readonly type="text" class="form-control form-control-sm border-0" style="background-color: white" id="opc" name="opc" placeholder="opc" v-model="esim.opc">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="created_at" class="col-sm-2 col-form-label text-xs">Created at</label>
                            <div class="col-sm-10">
                                <!--<input readonly type="text" class="form-control form-control-sm border-0" style="background-color: white" id="created_at" name="created_at" placeholder="created_at" v-model="esim.created_at">-->
                                <span id="created_at" class="text text-sm">
                                    <small>
                                        {{ esim.created_at | formatDate  }}
                                    </small>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="updated_at" class="col-sm-2 col-form-label text-xs">Updated at</label>
                            <div class="col-sm-10">
                                <!--<input readonly type="text" class="form-control form-control-sm border-0" style="background-color: white" id="updated_at" name="updated_at" placeholder="updated_at" v-model="esim.updated_at">-->
                                <span id="updated_at" class="text text-sm">
                                    <small>
                                        {{ esim.updated_at | formatDate  }}
                                    </small>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="technologieesim" class="col-sm-2 col-form-label text-xs">Technologie</label>
                            <div class="col-sm-10">
                                <span v-if="esim.technologieesim" id="technologieesim" class="text text-sm">{{ esim.technologieesim.libelle }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="statutesim" class="col-sm-2 col-form-label text-xs">Statut</label>
                            <div class="col-sm-10">
                                <span v-if="esim.technologieesim" id="statutesim" class="text text-sm">
                                    <StatutEsim :statutesim_prop="esim.statutesim" :model_type_prop="esim.model_type" :model_id_prop="esim.id"></StatutEsim>
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-xs">
                                <span class="text text-align-left">Client</span>
                                <span class="text text-align-right">
                                    <b-button v-if="can('esim-attach') && esim.statutesim.code === 'nouveau'" size="is-small" type="is-success is-light" @click="$emit('create_new_clientesim', esim.id)"><i class="fas fa-paperclip"></i></b-button>
                                </span>
                            </label>
                            <div class="col-sm-10">
                                <div class="card-body p-0">
                                    <div class="card-body table-responsive p-0" style="min-height: 200px;">
                                        <table class="table m-0">
                                            <thead>
                                            <tr class="tw-text-xs">
                                                <th>Numero</th>
                                                <th>Nom</th>
                                                <th>Prénom</th>
                                                <th>Date</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr key="esim.phonenum.id" class="tw-text-xs" v-if="esim.phonenum && esim.phonenum.hasphonenum">
                                                <td><div class="text tw-text-xs border-right">{{ esim.phonenum.numero }}</div></td>
                                                <td><div class="text tw-text-xs border-right">
                                                    <a v-if="can('esim-show')" class="text text-sm text-primary" data-toggle="tooltip" @click="showClientEsim(esim.phonenum.hasphonenum)">
                                                        <small>{{ esim.phonenum.hasphonenum.nom_raison_sociale }}</small>
                                                    </a>
                                                </div></td>
                                                <td><div class="text tw-text-xs border-right">{{ esim.phonenum.hasphonenum.prenom }}</div></td>
                                                <td>{{ esim.phonenum.created_at | formatDate }}</td>
                                                <td>
                                                    <div class="text tw-text-xs">
                                                        <a v-if="can('clientesim-print')" type="button" class="btn btn-tool btn-sm text-success" data-toggle="tooltip" @click="showPreviewPDF(esim.phonenum)">
                                                            <i class="fa fa-print"></i>
                                                        </a>
                                                        <a v-if="can('clientesim-esim-attach')" type="button" class="btn btn-tool btn-sm text-warning" data-toggle="tooltip" :disabled="loading" @click="changePhoneNumEsim(esim.phonenum, esim.phonenum.hasphonenum)">
                                                            <i class="fa fa-recycle"></i>
                                                        </a>
                                                        <a v-if="can('clientesim-deletephone')" type="button" class="btn btn-tool btn-sm text-danger" data-toggle="tooltip" :disabled="loading" @click="deletePhoneNum(esim.phonenum, esim.phonenum.hasphonenum)">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-xs">
                                <span v-if="can('esimstate-list')" class="text text-align-left">Etats (Historique)</span>
                                <span class="text text-align-right">

                                </span>
                            </label>
                            <div class="col-sm-10">
                                <EsimState v-if="can('esimstate-list')" :esimstates_prop="esim.states"></EsimState>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
        <!-- /.card-body -->
        <AddUpdateEsim :esim_prop="esim"></AddUpdateEsim>
        <clientesim-addupdate></clientesim-addupdate>
    </div>
</template>

<script>
    import AddUpdateEsim from "./addupdate.vue";
    import EsimBus from "./esimBus";
    import ClientEsimServices from '../clientesims/clientEsimServices'
    import ClientEsimBus from "../clientesims/clientesimBus";

    class Esim {
        constructor(esim) {
            this.imsi = esim.imsi || ''
            this.iccid = esim.iccid || ''
            this.ac = esim.ac || ''
            this.pin = esim.pin || ''
            this.puk = esim.puk || ''
            this.eki = esim.eki || ''
            this.pin2 = esim.pin2 || ''
            this.puk2 = esim.puk2 || ''
            this.adm1 = esim.adm1 || ''
            this.opc = esim.opc || ''

            this.created_at = esim.created_at || ''
            this.updated_at = esim.updated_at || ''

            this.statutesim = esim.statutesim || {}
            this.technologieesim = esim.technologieesim || {}
            this.phonenum = esim.phonenum || {}
        }
    }

    export default {
        name: "esim-show",
        props: {
            esim_prop: {}
        },
        components: {
            AddUpdateEsim,
            StatutEsim: () => import('../esimstatuses/inline-display'),
            EsimState: () => import('../esimstates/list')
        },
        mounted() {
            ClientEsimBus.$on('clientesim_created', (newesimclient) => {
                this.reloadEsim()
            })

            EsimBus.$on('esim_updated', (updesim) => {
                if (this.esim.id === updesim.id) {
                    this.esim = updesim
                }
            })

            ClientEsimBus.$on('phonenum_esim_changed', ({phonenum, clientesim}) => {
                if (this.esim.phonenum && this.esim.phonenum.hasphonenum.id === clientesim.id) {
                    // reload esim
                    this.reloadEsim()
                }
            })

            ClientEsimBus.$on('phonenum_deleted', ({phonenum, clientesim}) => {
                if (this.esim.phonenum && this.esim.phonenum.hasphonenum.id === clientesim.id) {
                    // reload esim
                    this.reloadEsim()
                }
            })
        },
        created() {

        },
        data() {
            return {
                esim: this.esim_prop,
                index: this.index_prop,
                collapse_icon: 'fas fa-chevron-down',
                loading: false,
            }
        },
        methods: {
            reloadEsim() {
                axios.get(`/esims.fetchone/${this.esim.id}`)
                    .then(({data}) => this.esim = data);
            },
            editEsim(esim) {
                this.$emit('edit_esim', esim)
            },
            showClientEsim(clientesim) {
                ClientEsimServices.showClientEsim(clientesim)
            },
            showPreviewPDF(phonenum) {
                ClientEsimServices.showPreviewPDF(phonenum)
            },
            deleteEsim(esim) {
                this.$swal({
                    html: '<small>Voulez-vous vraiment supprimer cette eSIM ?</small>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non'
                }).then((result) => {
                    if(result.value) {
                        axios.delete(`/esims/${esim.uuid}`)
                            .then(resp => {

                                console.log('esim delete resp: ', resp)

                                this.$swal({
                                    html: '<small>Esim supprimé avec succès !</small>',
                                    icon: 'success',
                                    timer: 3000
                                }).then(() => {
                                    EsimBus.$emit('esimaction_deleted', {key, resp})
                                })
                            }).catch(error => {
                            window.handleErrors(error)
                        })

                    } else {
                        // stay here
                    }
                })
            },
            changePhoneNumEsim(phonenum, clientesim) {
                ClientEsimServices.changePhoneNumEsim(phonenum, clientesim)
            },
            deletePhoneNum(phonenum, clientesim) {
                ClientEsimServices.deletePhoneNum(phonenum, clientesim)
            },
            removePhoneNum(phonenum) {
                let phonenumIndex = this.esim.phonenums.findIndex(p => {
                    return phonenum.id === p.id
                })
                if (phonenumIndex !== -1) {
                    this.esim.phonenums.splice(phonenumIndex, 1)
                }
            },
            collapseClicked() {
                if (this.collapse_icon === 'fas fa-chevron-down') {
                    this.collapse_icon = 'fas fa-chevron-up';
                } else {
                    this.collapse_icon = 'fas fa-chevron-down';
                }
            }
        },
        computed: {
            displayTitle() {
                return this.esim.imsi + ' ' + this.esim.iccid
            },
            currentCollapseIcon() {
                return this.collapse_icon;
            }
        }
    }
</script>

<style scoped>

</style>
