<link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/iziToast.min.css') }}">
<script src="{{ asset($activeTemplateTrue.'js/iziToast.min.js') }}"></script>

@if(session()->has('notify'))
    @foreach(session('notify') as $msg)
        <script type="text/javascript">
            "use strict";
            iziToast.{{ $msg[0] }}({message:"{{ $msg[1] }}", position: "topRight"});
        </script>
    @endforeach
@endif

@if ($errors->any())
    @php
        $collection = collect($errors->all());
        $errors = $collection->unique();
    @endphp
    <script>
        "use strict";
        @foreach ($errors as $error)
        iziToast.error({
            message: '{{ $error }}',
            position: "topRight"
        });
        @endforeach
    </script>
@endif
<script>
"use strict";
    function notify(status,message) {
        iziToast[status]({
            message: message,
            position: "topRight"
        });
    }
</script>
