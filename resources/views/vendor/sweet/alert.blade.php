@if (Session::has('sweet_alert.alert'))
    <script>
        sweetAlert({!! Session::get('sweet_alert.alert') !!});
    </script>
@endif