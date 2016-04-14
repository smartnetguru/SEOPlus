@extends('layouts.app', ['link' => 'Add URL'])
@section('content')

<div style="position: fixed; top: 80px; left: 5px; z-index: 9999;">
    <a href="{{URL::to('url_rank')}}/{{ $keyrank['url_id'] }}">
        <button class="btn bgm-red btn-float"><i class="zmdi zmdi-arrow-back"></i></button>
    </a>
</div>

<div class="col-md-10 col-md-offset-1">

    <div class="card">
        <div class="card-header bgm-blue  m-b-20">
            <h2>Keyword Rank Chart for<h3><div class="c-white text-uppercase"><div id="tittle"></div></div></h3></h2>
        </div>
        <div class="card-body card-padding">

            <div class="clearfix"></div>
            <div id="chartdiv" style="height: 35em; width: 100%;"></div>
        </div>
    </div>
    <div class="card">
        <div class="card-header bgm-blue">
        </div>
        <div class="card-header  m-b-20">
            <h2>Serarch Results for <h3><div class="c-blue text-uppercase">{{ $keyrank['keyword'] }}</div></h3></h2>
        </div>
        <div class="card-body card-padding">
            <blockquote class="m-b-25">
                <div class="clearfix"></div>


                <h4>Rank of {{ $keyrank['url'] }} for {{ $keyrank['keyword'] }} : {{ $keyrank['latest_rank'] }}</h4>
                <div class="clearfix"></div>
                <br>
                <h4>Top links</h4>
                <div class="clearfix"></div>

                    <?php $cc = 1; ?>
                    @if( !empty($res) )
                    @for( $i = 0; $i < count($res); $i++)
                        <h5>
                            {{ $cc }}<a href="http://{{ $res[$i] }}" @if($keyrank['latest_rank'] == $cc) style="color:red;"@endif > {{ $res[$i] }} </a>
                        </h5>
                        <div class="clearfix"></div>
                        <?php $cc++; ?>
                    @endfor
                    @endif

            </blockquote>
            Details over
        </div>

    </div>

</div>

@endsection @section('footer')

<script type="text/javascript">
    $(document).ready(function() {

        $('#tittle').text("{{ $keyrank['keyword'] }}");

        if ({{count($fetch)}} > 0) {

            var chart = AmCharts.makeChart("chartdiv", {
                "type": "serial",
                "theme": "light",
                "marginRight": 40,
                "marginLeft": 40,
                "marginTop": 40,
                "autoMarginOffset": 20,
                "dataDateFormat": "YYYY-MM-DD",
                "valueAxes": [{
                    "id": "v1",
                    "reversed": true,
                    "axisAlpha": 0,
                    "position": "left",
                    "ignoreAxisWidth": true
                }],
                "balloon": {
                    "borderThickness": 1,
                    "shadowAlpha": 0
                },
                "graphs": [{
                    "id": "g1",
                    "balloon": {
                        "drop": true,
                        "adjustBorderColor": false,
                        "color": "#ffffff"
                    },
                    "bullet": "round",
                    "bulletBorderAlpha": 1,
                    "bulletColor": "#FFFFFF",
                    "bulletSize": 5,
                    "hideBulletsCount": 50,
                    "lineThickness": 2,
                    "title": "red line",
                    "useLineColorForBulletBorder": true,
                    "valueField": "value",
                    "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
                }],
                "chartScrollbar": {
                    "graph": "g1",
                    "oppositeAxis": false,
                    "offset": 30,
                    "scrollbarHeight": 80,
                    "backgroundAlpha": 0,
                    "selectedBackgroundAlpha": 0.1,
                    "selectedBackgroundColor": "#888888",
                    "graphFillAlpha": 0,
                    "graphLineAlpha": 0.5,
                    "selectedGraphFillAlpha": 0,
                    "selectedGraphLineAlpha": 1,
                    "autoGridCount": true,
                    "color": "#AAAAAA"
                },
                "chartCursor": {
                    "pan": true,
                    "valueLineEnabled": true,
                    "valueLineBalloonEnabled": true,
                    "cursorAlpha": 1,
                    "cursorColor": "#258cbb",
                    "limitToGraph": "g1",
                    "valueLineAlpha": 0.2
                },
                "valueScrollbar": {
                    "oppositeAxis": false,
                    "offset": 50,
                    "scrollbarHeight": 10
                },
                "categoryField": "date",
                "categoryAxis": {
                    "parseDates": true,
                    "dashLength": 1,
                    "minorGridEnabled": true
                },
                "export": {
                    "enabled": true
                },

                "dataProvider": [@foreach($fetch as $i) {
                    "date": "{{$i['searched_at'] }}",
                    "value": "{{ $i['keyword_rank'] }}"
                }, @endforeach]
            });
            chart.addListener("rendered", zoomChart);

            zoomChart();

            function zoomChart() {
                chart.zoomToIndexes(chart.dataProvider.length - 40, chart.dataProvider.length - 1);
            }
        } else
            $('#chartdiv').html('<h3>Sorry, No previous search data available !!!</h3>').css('text-align', 'center');
    });
</script>

@endsection
