import Vue from 'vue'
import Router from 'vue-router'
//import { component } from 'vue/types/umd'
import ExampleComponent from './components/ExampleComponent'
import LaravelVueGoodTable from './components/LaravelVueGoodTable'
import VueGoodTablePlugin from 'vue-good-table';
Vue.use(VueGoodTablePlugin);
// import the styles
import 'vue-good-table/dist/vue-good-table.css'
Vue.use(Router)

const routes = [
    {
        path:'/asd/c-vue-route',
        component : ExampleComponent,
    },
    {
        path:'/asd/my-new',
        component : LaravelVueGoodTable,
    }
]
export default new Router({
    mode : 'history',
    routes
})