<thead>
    <tr id='column_name'>
    <th class="text-center align-middle">班級</th>
    @foreach($all_cloth as $column)

    <th class="text-center align-middle">{{ $column->property }}</th>
    @endforeach
    </tr>
</thead>
<tbody id='cloth_table'>
@foreach($class_name as $class_name)
    <tr>
    <th class="text-center align-middle">
        <a href="{{ route('report.class_order',$class_name->class_name) }}">{{ $class_name->class_name }}</a>
    </th>

    @foreach($all_cloth as $all_cloth_2)
        @php
            $cloth = $cloth_data->where('class_name', $class_name->class_name )
                                    ->where('size',$all_cloth_2->property);
            $accessory = $accessory_data->where('class_name', $class_name->class_name )
                                    ->where('color',$all_cloth_2->property);
        @endphp
        @if(!$cloth->isEmpty())
            <th class="text-center align-middle">{{ $cloth->first()->total }}</th>
        
        @elseif(!$accessory->isEmpty())
            <th class="text-center align-middle">{{ $accessory->first()->total }}</th>
        
        @else
            <th class="text-center align-middle">{{ 0 }}</th>
        @endif
    @endforeach
    </tr>
@endforeach
</tbody>
