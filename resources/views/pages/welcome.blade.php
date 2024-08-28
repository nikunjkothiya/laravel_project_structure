@extends('layouts.app')

@section('content')
<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
        <a href="#" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    Echo.channel('user-mail-notification')
        .listen('MailNotificationSent', (e) => {
            // custome code
        });
</script>
@endpush