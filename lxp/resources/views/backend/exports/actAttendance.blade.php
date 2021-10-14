

<table class="table table-bordered">
    <thead>
        <tr>                
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Position</th>
            <th>Province</th>
            <th>Municipality</th>
        </tr>
    </thead>
    <tbody>  
    
    @foreach($users as $key => $value)
        <tr>
            <td>{{$value->first_name}}</td> 
            <td>{{$value->middle_name}}</td> 
            <td>{{$value->last_name}}</td> 
            <td>{{$value->position}}</td> 
            <td>{{$prov[$value->province]}}</td> 
            <td>{{$mun[$value->city]}}</td>
        </tr>
    @endforeach
    </tbody>
</table>