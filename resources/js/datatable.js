import Vue from 'vue';
import UsersList from './components/UsersList';

// import the styles
import 'vue-good-table/dist/vue-good-table.css'

new Vue({
    el: 'users-list',
    components:{
        UsersList
    }
});