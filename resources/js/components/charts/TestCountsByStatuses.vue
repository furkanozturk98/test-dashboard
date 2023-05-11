<template>
  <highcharts :options="chartOptions" />
</template>

<script>
import { Chart } from 'highcharts-vue';

export default {
    name: 'TestCountsByStatuses',

    components: {
        highcharts: Chart
    },

    props: {
        testRunId: {
           type: Number,
            default: null
        }
    },

    data: () => ({
        chartOptions: {
            chart: {
                height: 300,
                type: 'pie',
            },

            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true,
                    innerSize: '40%',
                }
            },

            tooltip: {
                pointFormat: '{point.y} (<b>{point.percentage:.1f}%</b>)'
            },

            title: {
                text: null
            },

            series: [],
        },
    }),

    mounted() {
        this.fetch();
    },

    methods: {

        async fetch() {

            const response = await this.$http.get('/api/test-run-statuses?test_run_id='+this.testRunId);

            const statuses = {
                'success': 0,
                'fail': 0,
                'error': 0
            };

            const data = Object.keys(statuses).map(key => ({ name: key, y: response.data.data[this.testRunId][key] }));
            this.chartOptions.series = [{ data }];

        }
    },

}
</script>
