<template>
  <highcharts :options="chartOptions" />
</template>

<script>
import { Chart } from 'highcharts-vue';

export default {
        name: 'BarChart',

        components: {
            highcharts: Chart
        },

        props: {
            data: {
                type: Array,
                default: () => ({}),
            }
        },

        data() {
            return {
                chartOptions: {
                    chart: {
                        height: 60,
                        type: 'bar',
                    },

                    title: {
                        text: ''
                    },

                    xAxis: {
                        categories: ['Count'],
                        visible: false
                    },

                    yAxis: {
                        visible: false
                    },

                    legend: {
                        enabled: false
                    },

                    plotOptions: {
                        series: {
                            stacking: 'normal'
                        }
                    },

                    series: [],
                },
            }
        },

        mounted(){
            this.chartOptions.series = this.data;
        }
    }
</script>
