<table>
    <thead>
    <tr>
        <th>Sprint</th>
        <th>Started</th>
        <th>Duration</th>
        <th>Status</th>
        <th>Ended</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $sprints->name }}</td>
            <td>{{ $sprints->started }}</td>
            <td>{{ $sprints->duration }} week's</td>
            <td>{{ $sprints->status }}</td>
            <td>
               @php
                    $time = (new \DateTime($sprints->started))->add(new DateInterval("P" . $sprints->duration . "W"))->format("Y-m-d");
                    $ended = $sprints->status == 'done' ? $time : '-'
               @endphp
                {{$ended}}
            </td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Role</th>
        <th>Previous Task</th>
        <th>Next Task</th>
        <th>Blocking Task</th>
        <th>Date Time</th>
    </tr>
    </thead>
    <tbody>

        @foreach($sprints->report as $key => $report)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $report->member->first_name }} {{ $report->member->last_name }}</td>
                <td>{{ $report->member->role }}</td>
                <td>{{ $report->previous }}</td>
                <td>{{ $report->next }}</td>
                <td>{{ $report->blocking }}</td>
                <td>{{ $report->datetime }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
