@extends('voyager::master')

@section('page_title', __('voyager::generic.view').' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> {{ __('voyager::generic.viewing') }} {{ ucfirst($dataType->getTranslatedAttribute('display_name_singular')) }} &nbsp;

        @can('edit', $dataTypeContent)
            <a href="{{ route('voyager.'.$dataType->slug.'.edit', $dataTypeContent->getKey()) }}" class="btn btn-info">
                <i class="glyphicon glyphicon-pencil"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.edit') }}</span>
            </a>
        @endcan
        @can('delete', $dataTypeContent)
            @if($isSoftDeleted)
                <a href="{{ route('voyager.'.$dataType->slug.'.restore', $dataTypeContent->getKey()) }}" title="{{ __('voyager::generic.restore') }}" class="btn btn-default restore" data-id="{{ $dataTypeContent->getKey() }}" id="restore-{{ $dataTypeContent->getKey() }}">
                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.restore') }}</span>
                </a>
            @else
                <a href="javascript:;" title="{{ __('voyager::generic.delete') }}" class="btn btn-danger delete" data-id="{{ $dataTypeContent->getKey() }}" id="delete-{{ $dataTypeContent->getKey() }}">
                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.delete') }}</span>
                </a>
            @endif
        @endcan
        @can('browse', $dataTypeContent)
        <a href="{{ route('voyager.'.$dataType->slug.'.index') }}" class="btn btn-warning">
            <i class="glyphicon glyphicon-list"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.return_to_list') }}</span>
        </a>
        @endcan
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    @php
        $reports = \App\Models\Report::with('member')->where('sprint_id', $dataTypeContent->id)->get();
    @endphp

    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <!-- form start -->
                    <div class="row">
                    @foreach($dataType->readRows as $row)
                    <div class="col-md-6">
                        @php
                        if ($dataTypeContent->{$row->field.'_read'}) {
                            $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_read'};
                        }
                        @endphp
                        <div class="panel-heading" style="border-bottom:0;">
                            <h3 class="panel-title">{{ $row->getTranslatedAttribute('display_name') }}</h3>
                        </div>

                        <div class="panel-body" style="padding-top:0;">
                            @if (isset($row->details->view))
                                @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => 'read', 'view' => 'read', 'options' => $row->details])
                            @elseif($row->type == "image")
                                <img class="img-responsive"
                                     src="{{ filter_var($dataTypeContent->{$row->field}, FILTER_VALIDATE_URL) ? $dataTypeContent->{$row->field} : Voyager::image($dataTypeContent->{$row->field}) }}">
                            @elseif($row->type == 'multiple_images')
                                @if(json_decode($dataTypeContent->{$row->field}))
                                    @foreach(json_decode($dataTypeContent->{$row->field}) as $file)
                                        <img class="img-responsive"
                                             src="{{ filter_var($file, FILTER_VALIDATE_URL) ? $file : Voyager::image($file) }}">
                                    @endforeach
                                @else
                                    <img class="img-responsive"
                                         src="{{ filter_var($dataTypeContent->{$row->field}, FILTER_VALIDATE_URL) ? $dataTypeContent->{$row->field} : Voyager::image($dataTypeContent->{$row->field}) }}">
                                @endif
                            @elseif($row->type == 'relationship')
                                {{$reports->count()}} tasks
                            @elseif($row->type == 'select_dropdown' && property_exists($row->details, 'options') &&
                                    !empty($row->details->options->{$dataTypeContent->{$row->field}})
                            )
                                <?php echo $row->details->options->{$dataTypeContent->{$row->field}};?>
                            @elseif($row->type == 'select_multiple')
                                @if(property_exists($row->details, 'relationship'))

                                    @foreach(json_decode($dataTypeContent->{$row->field}) as $item)
                                        {{ $item->{$row->field}  }}
                                    @endforeach

                                @elseif(property_exists($row->details, 'options'))
                                    @if (!empty(json_decode($dataTypeContent->{$row->field})))
                                        @foreach(json_decode($dataTypeContent->{$row->field}) as $item)
                                            @if (@$row->details->options->{$item})
                                                {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                            @endif
                                        @endforeach
                                    @else
                                        {{ __('voyager::generic.none') }}
                                    @endif
                                @endif
                            @elseif($row->type == 'date' || $row->type == 'timestamp')
                                @if ( property_exists($row->details, 'format') && !is_null($dataTypeContent->{$row->field}) )
                                    {{ \Carbon\Carbon::parse($dataTypeContent->{$row->field})->formatLocalized($row->details->format) }}
                                @else
                                    {{ $dataTypeContent->{$row->field} }}
                                @endif
                            @elseif($row->type == 'checkbox')
                                @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                    @if($dataTypeContent->{$row->field})
                                    <span class="label label-info">{{ $row->details->on }}</span>
                                    @else
                                    <span class="label label-primary">{{ $row->details->off }}</span>
                                    @endif
                                @else
                                {{ $dataTypeContent->{$row->field} }}
                                @endif
                            @elseif($row->type == 'color')
                                <span class="badge badge-lg" style="background-color: {{ $dataTypeContent->{$row->field} }}">{{ $dataTypeContent->{$row->field} }}</span>
                            @elseif($row->type == 'coordinates')
                                @include('voyager::partials.coordinates')
                            @elseif($row->type == 'rich_text_box')
                                @include('voyager::multilingual.input-hidden-bread-read')
                                {!! $dataTypeContent->{$row->field} !!}
                            @elseif($row->type == 'file')
                                @if(json_decode($dataTypeContent->{$row->field}))
                                    @foreach(json_decode($dataTypeContent->{$row->field}) as $file)
                                        <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}">
                                            {{ $file->original_name ?: '' }}
                                        </a>
                                        <br/>
                                    @endforeach
                                @else
                                    <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($row->field) ?: '' }}">
                                        {{ __('voyager::generic.download') }}
                                    </a>
                                @endif
                            @else
                                @include('voyager::multilingual.input-hidden-bread-read')

                                @if($row->field == 'duration')
                                    <p>{{$dataTypeContent->{$row->field} }} week's </p>
                                @else
                                    <p>{{ $dataTypeContent->{$row->field} }}</p>
                                @endif
                            @endif
                        </div><!-- panel-body -->
                        @if(!$loop->last)
                            <hr style="margin:0;">
                        @endif
                    </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-sprint="{{$dataTypeContent->id}}">Create Report</button>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="exampleModalLabel">New Report for sprint <i><span style="font-weight: bold">{{$dataTypeContent->name}}</span></i></h4>
                            <hr/>
                        </div>
                        <div class="modal-body" style="margin-top: -30px">
                            <form>
                                <div class="form-group">
                                    <label for="memberId" class="col-form-label">Member</label>
                                    <select name="memberId" class="form-control select2" id="memberId">
                                        @php $members = \App\Models\Member::all() @endphp
                                        @foreach($members as $member)
                                            <option value="{{$member->id}}">{{$member->first_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">

                                    <label for="datetime" class="col-form-label">Date</label>
                                    <input type="date" class="form-control" name="datetime"
                                           placeholder="datetime" id="datetime" />

                                    <label for="previous" class="col-form-label">Previous Task</label>
                                    <textarea class="form-control" id="previous"></textarea>

                                    <label for="next" class="col-form-label">Next Task</label>
                                    <textarea class="form-control" id="next"></textarea>

                                    <label for="blocking" class="col-form-label">Blocking Task</label>
                                    <textarea class="form-control" id="blocking"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr />

        <table id="example" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Member name</th>
                    <th scope="col">Role</th>
                    <th scope="col">Previous task</th>
                    <th scope="col">Next task</th>
                    <th scope="col">Blocking task</th>

                </tr>
            </thead>
            <tbody>
                @foreach($reports as $key => $report)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{(new DateTime($report->datetime))->format('Y-m-d')}}</td>
                        <td>{{$report->member->first_name . ' ' . $report->member->last_name}}</td>
                        <td>{{$report->member->role}}</td>
                        <td>{{$report->previous}}</td>
                        <td>{{$report->next}}</td>
                        <td>{{$report->blocking}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('voyager.'.$dataType->slug.'.index') }}" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('voyager::generic.delete_confirm') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('javascript')

<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget); // Button that triggered the modal
        const sprintId = button.data('sprint'); // Extract info from data-* attributes
        console.log(sprintId);

        $('#submit').click(function(){
            const modal = $(this);
            const memberId = $('#memberId option:selected').val();
            const previous = $('#previous').val();
            const next = $('#next').val();
            const blocking = $('#blocking').val();
            const datetime = $('#datetime').val();
            const url = "{{route('voyager.reports.store')}}";
            let _token   = $('meta[name="csrf-token"]').attr('content');

            const fail = 'https://codepen.io/uxjulia/pen/d88ca4d7142a75937092ed02e8ddbcb1.html'

            $.ajax({
                url: url,
                type:"POST",
                data:{
                    sprint_id:sprintId,
                    member_id:memberId,
                    previous:previous,
                    next:next,
                    blocking:blocking,
                    datetime:datetime,
                    _token: _token
                },
                success:function(response){
                    $('#memberId option:selected').val("");
                    $('#previous').val("");
                    $('#next').val("");
                    $('#blocking').val("");
                    $('#datetime').val("");

                    alert("Repory created")

                },
                error: function(error) {
                    alert(error);
                }
            });
        });
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

        // modal.find('.modal-title').text('New message to ' + recipient)
        // modal.find('.modal-body input').val(recipient)
    })
</script>

<script>
    $(document).ready(function() {
    $('#example').DataTable();
} );
</script>
    @if ($isModelTranslatable)
        <script>
            $(document).ready(function () {
                $('.side-body').multilingual();
            });
        </script>
    @endif
    <script>
        var deleteFormAction;
        $('.delete').on('click', function (e) {
            var form = $('#delete_form')[0];

            if (!deleteFormAction) {
                // Save form action initial value
                deleteFormAction = form.action;
            }

            form.action = deleteFormAction.match(/\/[0-9]+$/)
                ? deleteFormAction.replace(/([0-9]+$)/, $(this).data('id'))
                : deleteFormAction + '/' + $(this).data('id');

            $('#delete_modal').modal('show');
        });

    </script>
@stop
