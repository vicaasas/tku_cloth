<template>
    <vue-good-table
        :columns="columns"
        :rows="this.users"
        :search-options="{ enabled: true }"
        :pagination-options="{
            enabled: true,
            mode: 'pages',
            nextLabel: '下一頁',
            prevLabel: '上一頁',
            perPage: 5,

        }"
        :line-numbers="true"
        @on-page-change="onPerPageChange"
    >
        <template
            slot="table-row"
            slot-scope="props"
        >
            <span v-if="props.column.field === 'class_name'">
                {{props.row.class_name}}
            </span>
            <span v-else-if="props.column.field === 'student_name'">
                {{props.row.student_name}}
            </span>
            <span v-else-if="props.column.field === 'student_id'">
                {{props.row.student_id}}
            </span>
            <span v-else-if="props.column.field === 'type'">
                <!--<span class="badge badge-pill badge-default-outline" v-for="course in props.row.courses">{{course.code}}</span>-->
                {{props.row.type}}
            </span>
            <span v-else-if="props.column.field === 'size'">
                {{props.row.size}}
            </span>
            <span v-else-if="props.column.field === 'color'">
                {{props.row.color}}
            </span>
            <span v-else-if="props.column.field === 'state'">
                {{props.row.state}}
            </span>
            <span v-else-if="props.column.field === 'delete'">
                <!-- Button trigger modal -->
                <button
                    type="button"
                    class="btn btn-danger"
                    data-toggle="modal"
                    :data-target="`#ModalDelete${props.row.id}`"
                >
                    Delete
                </button>

                <!-- Modal -->
                <div
                    class="modal fade"
                    :id="`ModalDelete${props.row.id}`"
                    tabindex="-1"
                    role="dialog"
                    aria-labelledby="ModalLabel"
                    aria-hidden="true"
                >
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5
                                    class="modal-title"
                                    id="ModalLabel"
                                >Delete Data</h5>
                                <button
                                    type="button"
                                    class="close"
                                    data-dismiss="modal"
                                    aria-label="Close"
                                >
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div
                                        class="alert alert-danger"
                                        role="alert"
                                    >
                                        <h4 class="alert-heading">
                                            Alert!</h4>
                                        <p>Are you sure you want to delete?</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-dismiss="modal"
                                >Close</button>
                                <a
                                    type="button"
                                    class="btn btn-danger"
                                    :href="`/user/${props.row.id}/delete`"
                                >Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </span>
            <span v-else-if="props.column.field === 'edit'">
                <!-- Button trigger modal -->
                <button
                    type="button"
                    class="btn btn-primary"
                    data-toggle="modal"
                    :data-target="`#Modal${props.row.id}`"
                >
                    Edit
                </button>

                <!-- Modal -->
                <div
                    class="modal fade"
                    :id="`Modal${props.row.id}`"
                    tabindex="-1"
                    role="dialog"
                    aria-labelledby="ModalLabel"
                    aria-hidden="true"
                >
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form
                                method="post"
                                action="/user/update"
                                @submit="checkForm(props.row.id)"
                            >
                                <input
                                    type="hidden"
                                    name="_token"
                                    :value="csrf"
                                >
                                <input
                                    type="hidden"
                                    name="id"
                                    :value="props.row.id"
                                >
                                <div class="modal-header">
                                    <h5
                                        class="modal-title"
                                        id="ModalLabel"
                                    >Edit Data</h5>
                                    <button
                                        type="button"
                                        class="close"
                                        data-dismiss="modal"
                                        aria-label="Close"
                                    >
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="`InputEmail${props.row.id}`">Email address</label>
                                        <input
                                            type="email"
                                            class="form-control"
                                            :id="`InputEmail${props.row.id}`"
                                            aria-describedby="emailHelp"
                                            :value="props.row.email"
                                            name="email"
                                            required
                                        >
                                        <br />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        data-dismiss="modal"
                                    >Close</button>
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </span>
            <span v-else>
                {{ props.formattedRow[props.column.field] }}
            </span>
        </template>
    </vue-good-table>
</template>

<script>
    import {VueGoodTable} from 'vue-good-table';
    export default {
        props: ['users'],
        components: {
            VueGoodTable,
        },
        methods: {
            onPerPageChange: function (evt) {
                // { currentPage: 1, currentPerPage: 10, total: 5 }
                console.log(evt);
            }
        },
        data() {
            return {
                columns: [
                    {
                    label: '班級',
                    field: 'class_name',
                    },
                    {
                    label: '姓名',
                    field: 'student_name',
                    },
                    {
                    label: '學號',
                    field: 'student_id',
                    },
                    {
                    label: '學位',
                    field: 'type',
                    filterOptions: {
                        enabled: true, // enable filter for this column
                        placeholder: '選擇學位', // placeholder for filter input

                        filterDropdownItems: ['學士', '碩士', '博士'], // dropdown (with selected values) instead of text input
                        trigger: 'enter', //only trigger on enter not on keyup 
                    },
                    },
                    {
                    label: '衣服尺寸',
                    field: 'size',
                    filterOptions: {
                        enabled: true, // enable filter for this column
                        placeholder: '選擇尺寸', // placeholder for filter input

                        filterDropdownItems: ['S', 'M', 'L','XL'], // dropdown (with selected values) instead of text input
                        trigger: 'enter', //only trigger on enter not on keyup 
                    },
                    },
                    {
                    label: '配件顏色(領巾 或 帽穗、披肩)',
                    field: 'color',
                    },
                    {
                    label: '訂單狀態',
                    field: 'state',
                    },
                    {
                    label: 'Delete',
                    field: 'delete',
                    },
                    {
                    label: 'Edit',
                    field: 'edit',
                    },
                ],
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
    };

</script>
