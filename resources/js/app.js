/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import axios from 'axios';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Authorization'] = 'Bearer ' + window.api_token;

Vue.prototype.$http = axios;

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

import HighchartsVue from 'highcharts-vue'
import Highcharts from 'highcharts'
import HighchartsNoData from 'highcharts/modules/no-data-to-display';
import highchartsOptions from './highcharts-options';

Highcharts.setOptions(highchartsOptions)

HighchartsNoData(Highcharts);

Vue.use(HighchartsVue);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/TestRunForm.vue -> <example-component></example-component>
 */

import TestRunForm from './components/TestRun/TestRunForm';
import TestRunList from './components/TestRun/TestRunList';
import TestRunDetailsList from './components/TestRun/TestRunDetailsList';
import TestRunDashboard from './components/Dashboard/TestRunDashboard';
import TestCountsByStatuses from './components/charts/TestCountsByStatuses.vue'
import TestCountsByDuration from './components/charts/TestCountsByDurationColumn.vue'
import Navbar from './components/Navbar';

Vue.component('test-run-form', TestRunForm);
Vue.component('test-run-list', TestRunList);
Vue.component('test-run-details-list', TestRunDetailsList);
Vue.component('test-run-dashboard', TestRunDashboard);
Vue.component('navbar', Navbar);
Vue.component('test-counts-by-statuses', TestCountsByStatuses);
Vue.component('test-counts-by-duration', TestCountsByDuration);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

new Vue({
    el: '#app',
});
