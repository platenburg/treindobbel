@php
    // Get the app URL, remove protocol and www
    $appUrl = str_replace(['https://', 'http://', 'www.'], '', config('app.url'));
@endphp
@if (config('app.plausible_domain') != null)
    <script defer data-domain="{{ $appUrl }}" src="{{ config('app.plausible_domain') }}/js/script.outbound-links.js">
    </script>
@endif
