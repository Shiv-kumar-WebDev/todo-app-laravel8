<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Todo App</title>
    <style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    .container {
        width: 500px;
        margin: 20px auto;
    }

    .form {
        background-color: #eee;
        border-radius: 6px;
        padding: 20px;
        display: flex;
        align-items: center;
    }

    .input {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        flex: 1;
    }

    .input:focus,
    .add:focus {
        outline: none;
    }

    .add {
        border: none;
        background-color: #f44336;
        color: white;
        padding: 10px;
        border-radius: 6px;
        margin-left: 10px;
        cursor: pointer;
    }

    .tasks {
        background-color: #eee;
        margin-top: 20px;
        border-radius: 6px;
        padding: 20px;
    }

    .tasks .task {
        background-color: white;
        padding: 10px;
        border-radius: 6px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: 0.3s;
        cursor: pointer;
        border: 1px solid #ccc;
    }

    .tasks .task:not(:last-child) {
        margin-bottom: 15px;
    }

    .tasks .task:hover {
        background-color: #f7f7f7;
    }

    .tasks .task.done {
        opacity: 0.5;
        position: relative;
    }

    .task.done::after {
        position: absolute;
        content: "";
    }

    .tasks .task span {
        font-weight: bold;
        font-size: 10px;
        background-color: red;
        color: white;
        padding: 2px 6px;
        border-radius: 4px;
        cursor: pointer;
    }

    .delete-all {
        width: calc(100% - 25px);
        margin: auto;
        padding: 12px;
        text-align: center;
        font-size: 14px;
        color: white;
        background-color: #f44336;
        margin-top: 20px;
        cursor: pointer;
        border-radius: 4px;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="form">
            <input type="text" class="input" id="input" />
            <input type="submit" class="add" value="Add Task" />
        </div>
        <br>
        <div id="saved_data">

        </div>
        <!-- <div class="delete-all">Delete all</div> -->
    </div>

    <!-- js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
    // ajax
    $(document).ready(function() {

        var url = "{{ route('list') }}";

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: 'POST',
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: 'JSON',
            success: function(response) {
                // console.log(response.data.list.length)
                for(i=0;i<=response.data.list.length;i++){
                    // console.log(response.data.list[i].id)
                    $('#saved_data').append('<div id="item' + response.data.list[i].id + '"><br><div class="form"><input disabled value="' + response.data.list[i]['item'] +'" type="text" class="input" /><button class="delete add" value="' +
                    response.data.list[i].id + '" >Delete</button></div></div>');
                }
            },
            error: function(response) {}
        });
    });


    $(document).on('click', '.delete', function(){

        var id = $(this).val();


        event.preventDefault();

        var url = "{{ route('del') }}";

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id
            },
            dataType: 'JSON',
            success: function(response) {
                // alert(response.success)
                $('#item'+id).hide();
            },
            error: function(response) {}
        });
    });
    $(document).ready(function() {


        $('.add').on('click', function(event) {

            var input = $("#input").val();

            event.preventDefault();

            var url = "{{ route('add') }}";

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "input": input
                },
                dataType: 'JSON',
                success: function(response) {
                    $('#input').val('');
                    $('#saved_input').val(input);
                    // alert(response.success)
                    $('#saved_data').append(
                        '<div id="item' + response.id + '"><br><div class="form"><input disabled value="' + input +
                        '" type="text" class="input" /><button class="delete add" value="' +
                        response.id + '" >Delete</button></div></div>');
                },
                error: function(response) {}
            });
        });


    });
    
    </script>
</body>

</html>