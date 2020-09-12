require('./bootstrap');
import Vue from 'vue'
// 匯入 Hello.vue 檔，不需加副檔名
import Student_order_table from './components/Student_order_table'
import VueGoodTablePlugin from 'vue-good-table';

// import the styles
import 'vue-good-table/dist/vue-good-table.css'

Vue.use(VueGoodTablePlugin);
new Vue({
    // 找到 hello.blade.php 中指定的掛載點元素
    el: '#app',
  
    // 使用我們建立的 Hello(.vue) 元件
    components: { Student_order_table }
})
