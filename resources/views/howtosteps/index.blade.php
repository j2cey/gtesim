@extends('app', ['page_title' => "Comment Faire ?"])

@section('app_content')

    <section class="section">

        <div class="container">

            <div class="tw-bg-white tw-shadow-md tw-rounded tw-px-3 md:tw-px-8 tw-pt-3 md:tw-pt-6 tw-pb-3 md:tw-pb-8 tw-mb-4">

                <div class="tw-mb-4">

                    <h2 class="tw-text-blue-600 tw-text-sm tw-font-bold tw-mb-3 tw-border-b tw-border-gray-400 tw-pb-2">
                        <span class="text text-align-left">Trucs & Astuces pour Prendre la Main</span>
                        <span class="text text-align-right">
                            @can('howtostep-create')
                                <b-button size="is-small" type="is-info is-light" @click="$emit('create_new_howtostep', -1)"><i class="fas fa-plus"></i></b-button>
                            @endcan
                        </span>
                    </h2>

                    <!-- SEARCH FORM -->

                    <search-form
                        group="howtostep-search"
                        url="{{ route('howtosteps.fetch') }}"
                        :params="{
                            search: '',
                            per_page: {{ $defaultPerPage }},
                            page: 1,
                            order_by: 'id:desc',
                            createdat_from: '',
                            createdat_to: '',
                            status: '',
                            }"
                        v-slot="{ params, update, change, clear, processing }"
                    >

                        <form class="tw-grid tw-grid-cols-10 tw-col-gap-4 tw-pb-3 tw-border-b tw-border-gray-400">
                            <div class="tw-col-span-4 md:tw-col-span-2">

                            </div>

                            <div class="tw-col-span-4 md:tw-col-span-2">

                            </div>

                            {{--                            TODO: PB de rafraichissement des parametres de filtre--}}

                            <div class="tw-col-span-4 md:tw-col-span-6">
                                <label class="tw-block tw-uppercase tw-tracking-wide tw-text-gray-700 tw-text-xs tw-font-bold tw-mb-2" for="search">
                                    Recherche
                                </label>
                                <div class="tw-relative">
                                    <span
                                        v-if="params.search"
                                        @click="clear({ search: '' })"
                                        class="tw-absolute tw-top-0 tw-right-0 tw-mt-4 mr-4 tw-text-gray-500 tw-cursor-pointer"
                                    >
                                        <times-circle
                                            class="tw-fill-current tw-h-4 tw-pointer-events-none"
                                        ></times-circle>
                                    </span>
                                    <input
                                        v-model="params.search"
                                        @input="update"
                                        @keydown.enter.prevent
                                        type="text"
                                        id="search"
                                        name="search"
                                        class="tw-appearance-none tw-block tw-w-full tw-bg-gray-200 focus:tw-bg-white tw-text-gray-700 tw-border tw-border-gray-400 focus:tw-border-gray-500 tw-rounded-sm tw-py-3 tw-pl-4 tw-pr-10 tw-mb-3 md:tw-mb-0 tw-leading-tight focus:tw-outline-none"
                                        placeholder="Rechercher..."
                                    >
                                </div>
                            </div>
                        </form>

                    </search-form>

                    <!--/ SEARCH FORM -->


                    <!-- RESULTS -->

                    <search-results group="howtostep-search" v-slot="{ total, records }">

                        <div class="tw-text-sm">

                            <div class="tw-flex tw-flex-wrap tw-p-4 tw-bg-gray-700 tw-text-white tw-rounded-sm">
                                <div class="tw-flex-auto tw-pr-3">Total : @{{ total }}</div>
                            </div>

                            <template v-if="records.length">

                                <table class="table-auto">
                                    <thead>
                                    <tr>
                                        <th class="tw-px-4 tw-py-2">#</th>
                                        <th class="tw-px-4 tw-py-2">Rubrique</th>
                                        <th class="tw-px-4 tw-py-2">Description</th>
                                        <th class="tw-px-4 tw-py-2"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="record in records"
                                        :key="record.id"
                                        class="tw-px-4 tw-border-b tw-border-dashed tw-border-gray-400 tw-text-gray-700 hover:tw-bg-gray-100"
                                    >
                                        <td class="tw-px-4 tw-py-2">
                                            <span class="tw-text-sm">@{{ record.id }}</span>
                                        </td>
                                        <td class="tw-px-4 tw-py-2">
                                            <span class="tw-text-sm">@{{ record.title }}</span>
                                        </td>
                                        <td class="tw-px-4 tw-py-2">
                                            <span class="tw-text-sm">@{{ record.description }}</span>
                                        </td>

                                        <td class="tw-px-4 tw-py-2">
                                            @can('howtostep-edit')
                                                <a @click="$emit('edit_howtostep', record)" class="tw-inline-block tw-mr-3 tw-text-green-500">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                </a>
                                            @endcan
                                            @can('howtostep-show')
                                                <a :href="record.show_url" class="tw-inline-block tw-mr-3 tw-text-orange-500">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>

                            </template>

                            <div
                                v-else
                                class="tw-flex tw-flex-wrap tw-p-4 border-b tw-border-dashed tw-border-gray-400 tw-text-gray-700"
                            >
                                Aucune Donnee
                            </div>

                        </div>

                    </search-results>

                    <!--/ RESULTS -->


                    <!-- PAGINATION -->

                    <search-pagination group="howtostep-search" :always-show="true"></search-pagination>

                    <!--/ PAGINATION -->

                </div>

                <clientesim-addupdate></clientesim-addupdate>
            </div>
        </div>

    </section>

@endsection
