<template>
  <highcharts :options="chartOptions" />
</template>

<script>
    import { Chart } from 'highcharts-vue';

    export default {
        name: 'TestCountsByDuration',

        components: {
            highcharts: Chart
        },

        props: {
            testRunId: {
                type: Number,
                default: null
            },
        },

        data() {
            return {
                chartOptions: {
                    chart: {
                        type: 'column',
                        height: 300,
                    },

                    xAxis: {
                        type: 'category',
                        labels: {
                            style: {
                                color: '#a4a4a4'
                            }
                        },

                        title: {
                            text: 'Duration (ms)',
                            style: {
                                color: '#a4a4a4'
                            }
                        }

                    },

                    yAxis: {
                        title: {
                            text: 'Count',
                            style: {
                                color: '#a4a4a4'
                            }
                        },

                        labels: {
                            style: {
                                color: '#a4a4a4'
                            }
                        }

                    },
                    legend: {
                        enabled: false
                    },

                    plotOptions: {
                        series: {
                            borderWidth: 0,
                            dataLabels: {
                                enabled: true,
                                format: '{point.y}',
                                style: {
                                    color: '#d8d8db'
                                }
                            }
                        }
                    },

                    tooltip: {
                        pointFormat: 'Tests: <b>{point.y}</b>'
                    },

                    title: {
                       text : null
                    },

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
