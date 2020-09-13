<template>
  <div>
    <vue-good-table 
    ref="order-table"
      :columns="columns"
      :rows="rows"
      :search-options="{
        enabled: true,
        placeholder: '搜尋',
      }"
      :pagination-options="{
        enabled: true,
        mode: 'pages',
        nextLabel: '下一頁',
        prevLabel: '上一頁',
        perPage: 5,

      }"
      :select-options="{ 
        enabled: true ,
        selectOnCheckboxOnly: true,
        selectionText: '筆資料已選擇',
        clearSelectionText: '清除',
      }"
      :line-numbers="true"
      @on-column-filter="check_accessory"
      @on-row-click="onRowClick"
      @on-selected-rows-change="select_rows"

      @on-select-all="onSelectAll"
      >
      <template 
        slot="table-row" 
        slot-scope="rows"
        >
        <span v-if="rows.column.field === 'class_name'">
            {{rows.row.class_name}}
        </span>
        <span v-else-if="rows.column.field === 'student_name'">
            {{rows.row.student_name}}
        </span>
        <span v-else-if="rows.column.field === 'student_id'">
            {{rows.row.student_id}}
        </span>
        <span v-else-if="rows.column.field === 'type'">
            <!--<span class="badge badge-pill badge-default-outline" v-for="course in props.row.courses">{{course.code}}</span>-->
            {{rows.row.type}}
        </span>
        <span v-else-if="rows.column.field === 'size'">
            {{rows.row.size}}
        </span>
        <span v-else-if="rows.column.field === 'color'">
            {{rows.row.color}}
        </span>
        <span v-else-if="rows.column.field === 'state'" >
          <span v-if="rows.row.state == 0">
            未繳費未歸還保證金
          </span>
          <span v-if="rows.row.state == 1">
            衣物歸還
          </span>
        </span>
        <span v-else-if="rows.column.field === 'edit'" >
          <span v-if="rows.row.vgtSelected==true">
            <button type="button" class="btn btn-primary" :id="rows.row.originalIndex"  data-target="#editModal" :disabled="false" @click="open_model">編輯</button>
          </span>
          <span v-else>
            <button type="button" class="btn btn-primary" :id="rows.row.originalIndex" data-toggle="modal" data-target="#editModal" :disabled="true">編輯</button>
          </span>
        </span>
      </template>

    <div slot="selected-row-actions">
      
      <div ref="vuemodal" data-backdrop="false" class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editModalLabel">編輯訂單</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form v-on:submit.prevent="edit_order" >  <!--action="edit_order" method="post"-->
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">學號:</label>
                  <input class="form-control" name="student_id" :value="edit_data.student_id" readonly>
                </div>
                <div class="form-group">
                  <label for="message-text" class="col-form-label">姓名:</label>
                  <input class="form-control" name="student_name" :value="edit_data.student_name" readonly>
                </div>
                <div class="form-group">
                  <label for="message-text" class="col-form-label">學位:</label>
                  <input class="form-control" name="type" :value="edit_data.type" readonly>
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">衣服尺寸:</label>
                  <input type="text" class="form-control" name="size" :value="edit_data.size">
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">配件顏色:</label>
                  <input type="text" class="form-control" name="color" :value="edit_data.color">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                  <button type="submit" class="btn btn-primary">確定</button>
                </div>
              </form>
            </div>

          </div>
        </div>
      </div>

      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#returnModal">
        歸還
      </button>
      <!-- Modal -->
      <div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="returnModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="returnModalLabel">歸還衣服</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              您確定歸還衣服
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal" @click="return_cloth">確定</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteModal">
        刪除
      </button>
      <!-- Modal -->
      <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel">刪除訂單</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              您確定要刪除訂單
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal" @click="delete_order">確定</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    </vue-good-table>
  </div>
</template>

<script>
//Vue.prototype.$http = axios;

export default {
  name: 'order_table',
  props: {
    student_order:{

    },
  },
  methods:{

    onSelectAll:function(data_all){
      console.log(data_all);
      //this.$refs['order-table'].selectAllInternal();
      //console.log(typeof(data_all));
      //console.log(this.select_column_data);
      data_all.selectedRows.forEach(element => {
        var index=this.select_column_data.findIndex(x => x.originalIndex == element.originalIndex);
        console.log(element);
        if(index==-1){
          console.log('not found');
          var btn_able=document.getElementById(element.originalIndex);
          if(btn_able.disabled==true){
            btn_able.disabled=false;
          }
          else{
            btn_able.disabled=true;
          }
        }

      });
    },
    onRowClick: function(data){
      //console.log(data);
      var btn_able=document.getElementById(data.pageIndex);
      
      if(data.selected==true){
        this.edit_data=data.row;
        btn_able.disabled=false;
      }
      else{
        this.edit_data=[];
        btn_able.disabled=true;
      }
    },
    check_accessory : function(params) {
    // params.columnFilters - filter values for each column in the following format:
    // {field1: 'filterTerm', field3: 'filterTerm2')
      console.log(params);
      console.log(params.columnFilters.type);
      if(params.columnFilters.type=='學士'){
        //console.log(this.columns[5].label);
        this.columns[5].label="配件顏色(領巾)";
      }
      else if(params.columnFilters.type=='碩士'){
        //console.log(this.columns[5].label);
        this.columns[5].label="配件顏色(帽穗、披肩)";
      }
      else if(params.columnFilters.type=='博士'){
        this.columns[5].label="配件顏色(無)";
      }
      else{
        this.columns[5].label="配件顏色(領巾 或 帽穗、披肩)";
      }
    },
    select_rows : function(params){
      //temp_order
      //console.log(params);
      //console.log(params.selectedRows);
      //params.selectedRows[0].state=0;
      //this.$refs[]
      if(params.selectedRows.length>0){
        //var temp_order=params.selectedRows;
        //console.log(temp_order[temp_order.length-1].student_id);
        //console.log(this.select_column_data.length);
        // if(this.select_column_data.length<=params.selectedRows.length){
        //   temp_order.forEach(element => {
        //     if(document.getElementById(element.student_id).disabled=true){
        //       document.getElementById(element.student_id).disabled=false;
        //     }
        //   });
        // }
        // else{
        //   this.select_column_data.forEach(element => {
        //     var index=temp_order.findIndex(x => x.student_id == element.student_id);
        //     if(index == -1){
        //       document.getElementById(element.student_id).disabled=true;
        //     }
        //   });
        // }
        this.select_column_data=params.selectedRows;
      }
      else{
        //document.getElementById(this.select_column_data[0].student_id).disabled=true;
        
        // this.select_column_data.forEach(element => {
        //   console.log(element.student_id);
        //   document.getElementById(element.student_id).disabled=true;
        // });
        this.select_column_data=[];
      }
    },
    return_cloth : function(){
//console.log(this.student_order);
      var select_column=this.select_column_data;
      var rows = this.rows;
      //rows.slice(1);
      axios.post("return_cloth", {
          select_column_data: select_column,
      })
      .then(function (response) {
        console.log(rows);
        // select_column.shift();
        // console.log(select_column[0]);
        //select_column[0]=null;
        select_column.forEach(element => {
          var index=rows.findIndex(x => x.student_id == element.student_id);
          rows[index].state=1;
        });

      })
      .catch(function(error) {
          console.log('失敗');
      })
    },
    delete_order:function(){
      var select_column=this.select_column_data;
      var rows = this.rows;
      
      axios.post("delete_order", {
          select_column_data: select_column,
      })
      .then(function (response) {
          select_column.forEach(element => {
            var index=rows.findIndex(x => x.student_id == element.student_id);
            rows.splice(index,1);
          });
      })
      .catch(function(error) {
          console.log('失敗');
      })
    },
    open_model: function(){
      console.log(1);
      //document.getElementById('editModal').style.display="block";
      //$('#editModal').modal("toggle");
      //$('#editModal').modal("show");
      $('#editModal').modal("show").on('hide', function() { 
          $('#editModal').modal('hide');
      });
    },
    edit_order: function(submitEvent){

      var order_data=submitEvent.target.elements;
      var rows = this.rows;
      var vm = this;
      var select_column_data = this.select_column_data;
      console.log(order_data);
      //this.$refs.addComponent.$refs.vuemodal.show()
      //this.$refs['vuemodal'].hide()

      //document.getElementById('editModal').setAttribute('aria-hidden',false);

      axios.post("edit_order", {
          student_id: order_data.student_id.value,
          type: order_data.type.value,
          size: order_data.size.value,
          color: order_data.color.value,
      })
      .then(function (response) {
 
          var index=rows.findIndex(x => x.student_id == order_data.student_id.value);
          rows[index].size=order_data.size.value;
          rows[index].color=order_data.color.value;
          select_column_data.forEach(element => {
        //console.log(element);
            vm.$set(rows[element.originalIndex], 'vgtSelected', true);
          });
          $('#editModal').modal("hide");
      })
      .catch(function(error) {
          console.log('失敗');
      })

      //console.log(this.select_column_data);
      
    }
  },
  // beforeMount(){
  //   this.init()
  // },
  data(){
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
          type: 'number',
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
          width: '150px',
        },
        {
          label: '訂單狀態',
          field: 'state',
          type: 'number',
          filterOptions: {
            enabled: true, // enable filter for this column
            placeholder: '選擇訂單狀態', // placeholder for filter input

            filterDropdownItems: 
            [
              {value:0 , text:'未繳費未歸還保證金'},
              {value:1 , text:'衣物歸還'},
            ],
            trigger: 'enter', //only trigger on enter not on keyup 
          },
        },
        {
          label: '編輯',
          field: 'edit',
        }

      ],
      rows: this.student_order,
      select_column_data:[],
      edit_data:[],
      //csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    };
  },

};
</script>
