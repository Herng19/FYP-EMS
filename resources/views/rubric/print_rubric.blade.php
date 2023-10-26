<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>{{ $rubric->rubric_name }}</title>

    <style>
        th {
            text-align: center;
        }

        tr {
            align-items: center;
        }

        td {
            padding: 4px;
            text-align: center;
            word-break: break-word;
            width: 32px;
            max-width: 32px;
            font-size: 12px;
        }
        thead {
            margin: 4px 8px 8px 0px;
        }
    </style>
</head>
<body>
    <div style="font-weight: bold;">{{ $rubric->rubric_name }}</div>

    <hr/>
    
    <table style="width: 100%;">
        <thead>
            <tr>
                <th>Elements</th>
                <th>CO</th>
                <th>0</th>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>Weightage</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rubric->rubric_criterias as $i => $rubric_criteria)
                <tr class="spacer"><td style="height: 4px;"> </td></tr>
                <tr>
                    <td style="font-weight: bold; text-align: left; font-size: 14px;">{{ $i+1 }} {{ $rubric_criteria->criteria_name }}</td>
                </tr>
                @foreach ($rubric_criteria->sub_criterias as $j => $sub_criteria)
                    <tr>
                        <td style="padding-left: 12px; text-align: left; {{ ($j%2 == 0)? 'background-color: #f1f1f1': ''; }}">{{ $i+1 }}.{{ $j+1 }} {{ $sub_criteria->sub_criteria_name }}</td>
                        <td style="text-transform: uppercase; {{ ($j%2 == 0)? 'background-color: #f1f1f1': ''; }}">{{ $sub_criteria->co_level }}</td>
                        @foreach ($sub_criteria->criteria_scales as $scale)
                            @if( $scale->scale_level == 2 || $scale->scale_level == 4 )
                                <td style="color: rgb(100, 100, 100); {{ ($j%2 == 0)? 'background-color: #f1f1f1': ''; }}">{{ $scale->scale_description }}</td>
                            @else
                                <td style="{{ ($j%2 == 0)? 'background-color: #f1f1f1': ''; }}">{{ $scale->scale_description }}</td>
                            @endif
                        @endforeach
                        <td style="{{ ($j%2 == 0)? 'background-color: #f1f1f1': ''; }}">{{ $sub_criteria->weightage }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>