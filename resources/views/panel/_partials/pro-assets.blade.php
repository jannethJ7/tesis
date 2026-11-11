@once

    @push('scripts')
        <script src="{{ asset('dashboard/assets/js/tesis/pro-views.js') }}?v={{ filemtime(public_path('dashboard/assets/js/tesis/pro-views.js')) }}"></script>
    @endpush
@endonce
