<script>
    window.User = null;

    @if(auth()->check())
        window.User = @json(auth()->user())
    @endif
</script>
