@extends('layouts.app')

@section('content')
<div id="all_events">
    @include('admin.event.includes.ajaxIndex')
</div>

<div class="col-md-4 pull-right">
    <div class="btn-group dropup" style="float:right">
        <a href="#" id="add_new_event" class="btn btn-primary">
            Create new Event
        </a>
    </div>
</div>


<div id="hidden_form" class="hidden">

    <h3>
        <span class="event_title title_20000">Create new event</span>
        <button data-id="0" class="btn btn-danger pull-right delete_event">
            Delete<i class="fa fa-trash"></i>
        </button>
    </h3>
    <div>



        {!! Form::open([
        'method' => 'POST',
        'name' => 'frm_update_event', 
        'route' => ['storeEvent'],
        'class' => 'form-horizontal',
        'data-index' => 20000
        ]) !!}

        @include('admin.event.includes.form',
        ['submitButtonText'  => 'Save'
        ])

        {!! Form::close() !!}
    </div>

</div>

<div class="hidden">
    <div id="dialog-confirm" title="Are you sure?">
        <p>
            <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
            <span class="modal_warning_text">
                This item will be permanently deleted and cannot be recovered. Are you sure?
            </span>
        </p>
    </div>

</div>


@push('scripts')
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/jquery-ui/themes/base/all.css') }}"/>
<script>
    $(function () {
        addAccordion();
    });

    function addAccordion(){
        $("#accordion").accordion({
            collapsible: true,
            active: false
        });
    }
    $("#all_events").on("submit", "form[name=frm_update_event]", function (e) {
        e.preventDefault();
        ajaxCaller($(this));
        return false;
    }); // end update event click event

    $("#all_events").on("click", ".delete_event", function (e) {
        e.preventDefault();
        var frm_caller = $(this).closest("form");
        var event_title = frm_caller.find("input[name=event_title]").val();

        var msgText = 'Are you sure that you want to Delete "' + event_title + '" event ?';

        // get the event id
        var event_id = $(this).attr('data-id');

        var isSaved = true;

        if (event_id == 0) {
            isSaved = false;
        }

        confirmDelete(msgText, frm_caller, isSaved);

        return false;
    }); // end delete event click event

    // click on add new button
    $("#add_new_event").click(function () {
//        addNewEvent();
        var new_form = $("#hidden_form").html();
        $("#accordion").append(new_form);
        // deactive all if opened
        $("#accordion").accordion("option", "active", false);
        // refresh to add the new added form
        $("#accordion").accordion("refresh");
        // open the new added form
        $(".title_20000").trigger("click");
        // scroll to form
        $('html,body').animate({
            scrollTop: $(".title_20000").offset().top},
                'slow');

        $(this).hide();
    });

    $("#all_events").on("submit", "form[name=frm_create_event]", function (e) {
        e.preventDefault();

        ajaxCaller($(this));
        return false;
    }); // end create event click event

    function confirmDelete(msgText, frmCaller, isSaved) {

        $("#dialog-confirm").find(".modal_warning_text").html(msgText);

        $("#dialog-confirm").dialog({
            resizable: false,
            height: "auto",
            modal: true,
            buttons: {
                "Delete event": function () {
                    if (isSaved) {
                        // call the ajax to delete the event
                        ajaxCaller(frmCaller);
                    } else {
                        $(".to_be_deleted").remove();
                    }
                    $(this).dialog("close");
                    $("#dialog-confirm").find(".modal_warning_text").html("");
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            }
        });
    }

    function ajaxCaller(frmCaller) {

        var url = frmCaller.attr("action");
        var requestData = frmCaller.serialize();
        var frmName = frmCaller.attr("name");

        var selSuccessMessage = $("#alert_messages .alert-success .content");
        var selSuccessMessageContainer = $("#alert_messages .alert-success");

        var selFailMessage = $("#alert_messages .alert-danger .content");
        var selFailMessageContainer = $("#alert_messages .alert-danger");

        selSuccessMessageContainer.hide();
        selFailMessageContainer.hide();

        // call the ajax method
        $.ajax({
            url: url,
            type: 'POST',
            data: requestData,
            success: function (retData) {
                if (retData.status === 'success') {
                    // show the deleted confirmation to the user
                    selSuccessMessage.html(retData.msg);
                    selSuccessMessageContainer.fadeIn(200);

                    // in case of success only
                    ajaxRefreshPage(retData.msg);

                } else {

                    selFailMessageContainer.fadeIn(200);

                    if (retData.msg instanceof Array || typeof retData.msg === 'object') {
                        // show the error messages
                        var alertContent = '<strong id="welcome">Please fix the following errors:</strong><br>';
                        selFailMessage.html(alertContent);

                        $.each(retData.msg, function (key, value) {
                            $('#' + key).addClass('has-error');
                            selFailMessage.html(selFailMessage.html() + value + '<br>');
                        });
                    } else {
                        selFailMessage.html(retData.msg);
                    }
                }
            },
            error: function (retData) {
                selFailMessage.html("Error , Please try again later");
                selFailMessageContainer.fadeIn(200);
            }
        });
    }


    function ajaxRefreshPage(message) {

        var selSuccessMessage = $("#alert_messages .alert-success .content");
        var selSuccessMessageContainer = $("#alert_messages .alert-success");

        var selFailMessage = $("#alert_messages .alert-danger .content");
        var selFailMessageContainer = $("#alert_messages .alert-danger");

        selSuccessMessageContainer.hide();
        selFailMessageContainer.hide();
        // call the ajax method
        $.ajax({
            url: '{!! route("indexEvent") !!}',
            type: 'GET',
            success: function (retData) {
                // refresh the whole page
                $("#all_events").html(retData);
                // add a message to notify the user
                selSuccessMessage.html(message);
                selSuccessMessageContainer.fadeIn(200);
            },
            error: function (retData) {
                selFailMessage.html("Error , Please refresh the page");
                selFailMessageContainer.fadeIn(200);
            },
            complete: function () {
                addAccordion();
                $("#accordion").accordion("refresh");
            }
        });
    }

</script>
@endpush  
@endsection
