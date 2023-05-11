<template>
  <highcharts :options="chartOptions" />
</template>

<script>
import { Chart } from 'highcharts-vue';

export default {
    name: 'LineChart',
    components: {
        highcharts: Chart
    },

    data() {
        return {
            chartOptions: {
                chart: {
                    height: 300,
                    type: 'areaspline',
                },

                title: {
                    text: null
                },

                yAxis: {
                    title: {
                        text: null
                    },
                    labels: {
                        style: {
                            fontSize: '15px'
                        }

                    }
                },

                xAxis: {
                    categories: [],
                    gridLineWidth: 1,
                    gridLineColor: '#444',
                    labels: {
                        formatter() {
                            const parts = this.value.split('-');

                            return `${parts[1]} / ${parts[2]}`
                        }
                    }
                },

                legend: {
                    title: {
                        text: 'In the past 7 days',
                        style: {
                            fontSize: '15px',
                        }
                    },
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    itemStyle: {
                        fontSize: '20px'
                    },
                    itemMarginTop: 25,
                    labelFormatter () {
                        return this.name;
                    }

                },

                plotOptions: {
                    series: {
                        marker: {
                            enabled: false,
                        }
                    }
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
            const response = await this.$http.get('/api/dashboard/history');
            this.history = response.data.data;

            await this.update()
        },

        update() {

             const totalStatusByName = {
                success: 0,
                fail: 0,
                error: 0
            };

            this.chartOptions.xAxis.categories = Object.keys(this.history);

            let success = [];
            let fail = [];
            let error = [];

            Object.values(this.history).forEach(item => {
                success.push(item.success);
                fail.push(item.fail);
                error.push(item.error);

                totalStatusByName.success += item.success;
                totalStatusByName.fail += item.fail;
                totalStatusByName.error += item.error;
            });

            this.chartOptions.series = [
                {
                    name: 'Passed',
                    data: success
                },
                {
                    name: 'Failed',
                    data: fail
                },
                {
                    name: 'Error',
                    data: error
                }
            ];

            const totalStatus = totalStatusByName.success + totalStatusByName.fail + totalStatusByName.error;

            this.chartOptions.series[0].name = totalStatusByName.success + ' Passed <br/><span style="font-size: 15px; color: #666; font-weight: normal">'
                + ((totalStatusByName.success * 100) / totalStatus).toFixed(2) + '% set to Passed</span>';

            this.chartOptions.series[1].name = totalStatusByName.fail + ' Failed <br/><span style="font-size: 15px; color: #666; font-weight: normal">'
                + ((totalStatusByName.fail * 100) / totalStatus).toFixed(2) + '% set to Fail</span>';

            this.chartOptions.series[2].name = totalStatusByName.error + ' Error <br/><span style="font-size: 15px; color: #666; font-weight: normal">'
                + ((totalStatusByName.error * 100) / totalStatus).toFixed(2) + ' set to Error</span>';

        }
    }
}
</script>
