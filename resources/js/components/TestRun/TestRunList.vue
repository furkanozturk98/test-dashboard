<template>
  <div>
    <h4 v-if="!isDashboard">
      Test Runs
    </h4>

    <div v-if="items && statuses">
      <b-link v-for="(item) in items" :key="item.id" @click="showDetails(item.id)">
        <div class="card mb-2">
          <div class="pt-3 pl-3">
            <h4>
              {{ item.title || 'Untitled' }}
            </h4>

            <div class="row">
              <div class="col-6">
                <i class="fas fa-file-alt " style="margin-bottom: 3px; padding: 2px; font-size: 1.4rem" /> By {{ item.created_by }} on {{ item.created_at }}
              </div>

              <div class="col-4">
                <bar-chart style="margin-top: -15px;" :data="getBarChartData(item.id)" />
              </div>

              <div class="col-2">
                {{ calculatePassedTestPercentage(item.id) }} %
              </div>
            </div>
          </div>
        </div>
      </b-link>

      <a v-if="(lastPage > 1 && isDashboard)" class="btn btn-primary" href="/list">Show All</a>

      <b-pagination
        v-if="!isDashboard"
        v-model="currentPage"
        :total-rows="totalRows"
        :per-page="perPage"
        align="right"
        @input="changePage"
      />
    </div>
  </div>
</template>

<script>
    import BarChart from '../charts/TestRunStatuses';

    export default {
        name: 'TestRunList',

        components: {
            barChart: BarChart
        },

        props: {

            isDashboard: {
                type: Boolean,
                default: null
            },

        },

        data() {
            return {
                items: null,
                statuses: null,
                lastPage: 0,
                totalRows: 0,
                currentPage: 1,
                perPage: 10,
            }
        },

        mounted() {
            this.fetch();
        },

        methods: {
            getBarChartData(key) {

                const status = this.statuses[key];

                return [
                    {
                        name: 'success',
                        data: [status.success]
                    },
                    {
                        name: 'fail',
                        data: [status.fail]
                    },
                    {
                        name: 'error',
                        data: [status.error]
                    }
                ]
            },

            calculatePassedTestPercentage(key) {

                const status = this.statuses[key];

                const sum = status.success + status.fail + status.error;

                return ((status.success * 100) / sum).toFixed(2);
            },
            async fetch(){

              await this.getTestRuns();

              await this.getTestRunStatuses();

            },
            async getTestRuns() {

                const response = await this.$http.get('/api/test-runs?page='+this.currentPage);
                this.items = response.data.data;

                this.lastPage = response.data.meta.last_page;

                this.currentPage =  response.data.meta.current_page;
                this.totalRows = response.data.meta.total;

            },
            async getTestRunStatuses(){
                const response = await this.$http.get('/api/test-run-statuses?from='+this.items[this.items.length-1].id+'&to='+this.items[0].id);
                this.statuses = response.data.data;
            },
            changePage(){
                this.fetch();
            },
            showDetails(id) {
                window.location.href = '/details/' + id;
            }
        }
    }
</script>

<style scoped>
    a, a:visited, a:hover, a:focus {
        color: black !important;
        text-decoration: none;
    }
</style>
