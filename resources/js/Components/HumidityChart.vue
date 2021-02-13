<script>
import {Line} from 'vue-chartjs';

function createChartData(temperatures) {
    let humiditiesAvg = [];
    let humiditiesMin = [];
    let humiditiesMax = [];

    temperatures.forEach((temp) => {
        humiditiesAvg.push({
            t: temp.created_at_bucket,
            y: temp['humidity_avg'],
        });

        humiditiesMin.push({
            t: temp.created_at_bucket,
            y: temp['humidity_min'],
        });

        humiditiesMax.push({
            t: temp.created_at_bucket,
            y: temp['humidity_max'],
        });
    });

    return {
        datasets: [
            {
                label: "Humidity (%) (Avg)",
                fill: false,
                borderColor: 'rgb(200,38,38)',
                borderWidth: 1,
                pointRadius: 0,
                data: humiditiesAvg,
                yAxisID: 'y-axis-1',
            },
            {
                label: "Humidity (%) (Min)",
                fill: false,
                borderColor: 'rgb(38,96,200)',
                borderWidth: 1,
                pointRadius: 0,
                data: humiditiesMin,
                yAxisID: 'y-axis-1',
            },
            {
                label: "Humidity (%) (Max)",
                fill: false,
                borderColor: 'rgb(38,96,200)',
                borderWidth: 1,
                pointRadius: 0,
                data: humiditiesMax,
                yAxisID: 'y-axis-1',
            },
        ],
    };
}

export default {
    extends: Line,
    props: {
        data: {
            type: Array,
            default: [],
        },
        title: {
            type: String,
            default: 'Humidity',
        },
    },
    mounted() {
        const chartData = createChartData(this.data);
        const options = {
            type: 'line',
            responsive: true,
            maintainAspectRatio: false,
            hoverMode: 'index',
            stacked: false,
            title: {
                display: true,
                text: this.title,
            },
            tooltips: {
                mode: 'x',
                intersect: false,
            },
            elements: {
                point: {
                    radius: 0,
                },
                line: {
                    tension: 0 // disables bezier curves
                }
            },
            scales: {
                xAxes: [
                    {
                        type: 'time',
                        time: {
                            tooltipFormat: 'MMM DD @ HH:mm',
                            displayFormats: {
                                minute: 'MMM DD @ HH:mm',
                            },
                            unit: 'minute',
                            unitStepSize: 15,
                        },
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 10,
                        },
                    }],
                yAxes: [
                    {
                        type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                        display: true,
                        position: 'left',
                        id: 'y-axis-1',
                        ticks: {
                            min: 0,
                            max: 100,
                        },
                    },
                ],
            },
            animation: {
                duration: 0 // general animation time
            },
            hover: {
                animationDuration: 0 // duration of animations when hovering an item
            },
            responsiveAnimationDuration: 0 // animation duration after a resize
        };
        // this.chartData is created in the mixin.
        // If you want to pass options please create a local options object
        this.renderChart(chartData, options);
    },
};
</script>
