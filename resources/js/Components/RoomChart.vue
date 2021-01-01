<script>
import {Line} from 'vue-chartjs';
import moment from 'moment';

function createChartData(temperatures) {
    let temps = [];
    let humidities = [];
    let labels = [];

    temperatures.forEach(({temperature, humidity, created_at}) => {
        labels.push(moment(created_at).fromNow());
        // labels.push(moment(created_at).format('MMM DD h:mm:ss a'));
        temps.push(temperature);
        humidities.push(humidity);
    });

    return {
        labels: labels,
        datasets: [
            {
                label: 'Temperature',
                data: temps,
                yAxisID: 'y-axis-1'
            },
            {
                label: 'Humidity',
                data: humidities,
                yAxisID: 'y-axis-2'
            },
        ],
    };
}

export default {
    extends: Line,
    props: {
        temperatures: {
            type: Array,
            default: [],
        },
    },
    mounted() {
        const chartData = createChartData(this.temperatures);
        const options = {
            responsive: true,
            hoverMode: 'index',
            stacked: false,
            title: {
                display: true,
                text: 'Chart.js Line Chart - Multi Axis'
            },
            scales: {
                xAxes: [{
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 5
                    }
                }],
                yAxes: [{
                    type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                    display: true,
                    position: 'left',
                    id: 'y-axis-1',
                }, {
                    type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                    display: true,
                    position: 'right',
                    id: 'y-axis-2',

                    // grid line settings
                    gridLines: {
                        drawOnChartArea: false, // only want the grid lines for one axis to show up
                    },
                }],
            }
        };
        // this.chartData is created in the mixin.
        // If you want to pass options please create a local options object
        this.renderChart(chartData, options);
    },
};
</script>
