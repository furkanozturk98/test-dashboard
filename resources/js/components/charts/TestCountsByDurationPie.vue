<template>
  <highcharts :options="chartOptions" />
</template>

<script>
    import { Chart } from 'highcharts-vue';

    export default {
        name: 'PieChart',

        components: {
            highcharts: Chart
        },

        props: {
            testRunId: {
                type: Number,
                default: null
            },
            avgDuration: {
                type: Number,
                default: null
            }
        },

        data() {
            return {
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
                            innerSize: '45%',
                        }
                    },

                    tooltip: {
                        pointFormat: '{point.y} (<b>{point.percentage:.1f}%</b>)'
                    },

                    title: {
                        text: 'Avg<br>Duration<br>'+this.avgDuration,
                        align: 'center',
                        verticalAlign: 'middle',
                        y: 0,
                        style: {
                            color: '#a4a4a4',
                            fontSize: 15,
                            fontWeight: 'bold'
                        }
                    },
                    colors: ['#7eb500','#0090e7','#d5e742','#ffab00','#e84c3d'],
                    series: [],
                },
            }
        },

        mounted() {
            this.fetch();
        },

        methods: {

            async fetch() {

                const response = await this.$http.get('/api/test-duration-count/' + this.testRunId);

                const data = Object.keys(response.data.data).map(key => ({ name: key, y: response.data.data[key] }));

                this.chartOptions.series = [{ data }];

            }
        },

    }
</script>
