<script>
import {Line} from 'vue-chartjs';

const commonOptions = {
    type: 'line',
    stacked: false,
    responsive: true,
    maintainAspectRatio: false,
    scales: {
        xAxes: [
            {
                type: 'time',
                time: {
                    tooltipFormat: 'MMM DD hh:mm A',
                    displayFormats: {
                        minute: 'MMM DD \n hh:mm a',
                    },
                    unit: 'minute',
                    unitStepSize: 60,
                },
                ticks: {
                    source: 'data',
                    autoSkip: true,
                    maxTicksLimit: 8,
                },
            }],
        yAxes: [
            {
                type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                display: true,
                position: 'left',
                id: 'y-axis-1',
                ticks: {
                    precision: 0,
                    callback: function(value, index, values) {
                        return value + '°C';
                    },
                },
            },
        ],
    },
    animation: {
        duration: 0, // general animation time
    },
    hover: {
        animationDuration: 0, // duration of animations when hovering an item
    },
    responsiveAnimationDuration: 0, // animation duration after a resize
};

const sparkOptions = {
    legend: {
        display: false,
    },
    title: {
        display: false,
    },
    elements: {
        point: {
            radius: 0,
        },
        line: {
            tension: 0, // disables bezier curves
        },
    },
    tooltips: {
        enabled: false,
    },
    scales: {
        xAxes: [
            {
                display: false,
                type: 'time',
                time: {
                    tooltipFormat: 'MMM DD hh:mm A',
                    displayFormats: {
                        minute: 'MMM DD \n hh:mm a',
                    },
                    unit: 'minute',
                    unitStepSize: 60,
                },
                ticks: {
                    source: 'data',
                    autoSkip: true,
                    maxTicksLimit: 8,
                },
            }],
        yAxes: [
            {
                type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                display: true,
                position: 'left',
                id: 'y-axis-1',
                ticks: {
                    precision: 0,
                    callback: function(value, index, values) {
                        return value + '°C';
                    },
                },
            },
        ],

    },
};

const defaultOptions = {
    hoverMode: 'index',

    title: {
        display: true,
    },
    tooltips: {
        mode: 'index',
        intersect: false,
    },
    elements: {
        point: {
            radius: 0,
        },
        line: {
            tension: 0, // disables bezier curves
        },
    },
};

export default {
    extends: Line,
    props: {
        spark: {
            type: Boolean,
            default: false,
        },
        data: {
            type: Array,
            default: [],
        },
        title: {
            type: String,
            default: 'Temperature (°C)',
        },
    },
    mounted() {
        const chartData = formatData(this.data);
        const defaults = this.spark ? sparkOptions : defaultOptions;
        const options = {
            ...commonOptions,
            ...defaults,
            title: {
                display: true,
                text: this.title,
            },
        };

        console.log(options.scales.yAxes);
        // this.chartData is created in the mixin.
        // If you want to pass options please create a local options object
        this.renderChart(chartData, options);
    },
};

function formatData(rows) {
    let min = [];
    let max = [];
    let avg = [];

    rows.forEach((row) => {
        max.push({t: row.created_at_bucket, y: row.temperature_max});
        min.push({t: row.created_at_bucket, y: row.temperature_min});
        avg.push({t: row.created_at_bucket, y: row.temperature_avg});
    });

    return {
        datasets: [
            {
                label: 'Min',
                fill: '1',
                backgroundColor: 'rgba(4,117,241,0.1)',
                borderColor: false,
                borderWidth: 0,
                pointRadius: 0,
                data: min,
                yAxisID: 'y-axis-1',
            },
            {
                label: 'Max',
                fill: '0',
                backgroundColor: 'rgba(4,117,241,0.1)',
                borderColor: false,
                borderWidth: 0,
                pointRadius: 0,
                data: max,
                yAxisID: 'y-axis-1',
            },
            {
                label: 'Average',
                fill: false,
                borderColor: 'rgb(200,38,38)',
                borderWidth: 1,
                pointRadius: 0,
                data: avg,
                yAxisID: 'y-axis-1',
            },
        ],
    };
}
</script>
