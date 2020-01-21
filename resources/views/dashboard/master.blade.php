<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="base-url" content="{{ url('/dashboard') }}">
  <meta name="api-url" content="{{ url('/api/v1/dashboard') }}">
  <meta name="root-url" content="{{ url('/') }}">
  <meta name="g-recaptcha-site_key" content="{{ env('NOCAPTCHA_SITEKEY') }}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{ mix('css/dashboard/app.css') }}">
</head>

<body>
    <div id="app">
        <main-layout v-if="! isInitializing">
            <section class="section">
                <router-view></router-view>
            </section>
        </main-layout>
    </div>

    <script src="{{ mix('js/dashboard/app.js') }}"></script>
    <script src="/assets/editors/ckeditor/ckeditor.js"></script>
</body>

</html>
