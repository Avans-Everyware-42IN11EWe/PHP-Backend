/** @jsx React.DOM */

var dashboard = function() {
    var Graphs = React.createClass({
        componentDidMount: function() {
            d3.json('/admin/graph.json', function(data) {
                nv.addGraph(function() {
                    console.log(data);
                    var chart = nv.models.stackedAreaChart()
                                    .x(function(d) { return d[0] })
                                    .y(function(d) { return d[1] })
                                    .clipEdge(true)
                                    .useInteractiveGuideline(false)
                            ;

                    chart.xAxis
                            .showMaxMin(true)
                            .tickFormat(function(d) { return d3.time.format('%x')(new Date(d * 1000)) });

                    chart.yAxis
                            .tickFormat(d3.format(',r'));

                    d3.select('#chart svg')
                            .datum(data)
                            .transition().duration(100).call(chart);

                    nv.utils.windowResize(chart.update);

                    return chart;
                });
            });
        },
        render: function() {
            return (
                <div id="chart">
                    <svg style={{height: '400px', width: '100%'}}></svg>
                </div>
            );
        }
    });

    React.renderComponent(<Graphs />, document.getElementById('view'));
};