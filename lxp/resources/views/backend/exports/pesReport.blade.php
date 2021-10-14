

<table class="table table-bordered">
    <thead>
        <tr>
            <th class="align-middle" rowspan="2">Areas</th>
            <th>Excellent</th>
            <th>Very Satisfactory</th>
            <th>Satisfactory</th>
            <th>Fair</th>
            <th>Poor</th>
            <th class="align-middle" rowspan="2">Total Respondent</th>
            <th colspan="2">Rating Per Item</th>
        </tr>
        <tr>
            <th>4.5-5</th>
            <th>4.5-3.49</th>
            <th>2.5-3.49</th>
            <th>1.5-2.49</th>
            <th>1.49-below</th>
            <th>Rate</th>
            <th>Adjective</th>
        </tr>
    </thead>
    <tbody>
        @foreach($full_questions as $key => $value)
            @if($key != "")
            <tr>
                <td colspan="9" class="font-weight-bold">{{$key}}</td> 
            </tr>
            @endif
                @if(!empty($value))
                    @foreach($value as $key_ans => $value_ans)
                        <tr>
                        <td class="font-weight-bold">{{$value_ans['question']}}</td>
                        <td> 
                            @if(isset($value_ans['stats'][5]))
                                {{ $value_ans['stats'][5] }}<br>
                                <span class="badge badge-info">
                                    {{ number_format(($value_ans['stats'][5]/$value_ans['respondents'])*100) }}%
                                </span>
                            @endif
                            
                        </td>
                        <td> 
                            @if(isset($value_ans['stats'][4]))
                                {{ $value_ans['stats'][4] }}<br>
                                <span class="badge badge-info">
                                    {{ number_format(($value_ans['stats'][4]/$value_ans['respondents'])*100) }}%
                                </span>
                            @endif
                        </td>
                        <td> 
                            @if(isset($value_ans['stats'][3]))
                                {{ $value_ans['stats'][3] }}<br>
                                <span class="badge badge-info">
                                    {{ number_format(($value_ans['stats'][3]/$value_ans['respondents'])*100) }}%
                                </span>
                            @endif
                        </td>
                        <td> 
                            @if(isset($value_ans['stats'][2]))
                                {{ $value_ans['stats'][2] }}<br>
                                <span class="badge badge-info">
                                    {{ number_format(($value_ans['stats'][2]/$value_ans['respondents'])*100) }}%
                                </span>
                            @endif
                        </td>
                        <td> 
                            @if(isset($value_ans['stats'][1]))
                                {{ $value_ans['stats'][1] }}<br>
                                <span class="badge badge-info">
                                    {{ number_format(($value_ans['stats'][1]/$value_ans['respondents'])*100) }}%
                                </span>
                            @endif
                        </td>
                        <td>
                            {{$value_ans['respondents']}}
                        </td>
                        <td>
                            {{$value_ans['rate']}}
                        </td>
                        <td>
                            {{$value_ans['adjective']}}
                        </td>
                    </tr>
                    @endforeach
                @endif
        @endforeach

        <tr><td colspan="9" class="font-weight-bold"></td></tr>

        @foreach($qtext_ans as $key => $value)
            <tr>
                <td colspan="9" class="font-weight-bold">
                    @if($key != "")
                        {{$key}}
                    @else
                        General Question
                    @endif
                </td>
            </tr>
            @foreach($value as $a_key => $a_value)
                <tr>
                    <td class="font-weight-bold">{{$a_key}}</td>
                </tr>
                @foreach($a_value as $k_ans => $v_ans)
                    <tr>
                        <td></td>
                        <td class="font-weight-bold">{{$v_ans}}</td>
                    <tr>
                @endforeach
            @endforeach
        @endforeach
    </tbody>
</table>