@extends('templates/default')

{{-- Page title --}}
@section('title')
{{ trans('platform/users::groups/general.title') }} ::
@parent
@stop

{{-- Queue Assets --}}
{{ Asset::queue('apps4u-oauth2', 'apps4u/oauth2::css/style.css', 'bootstrap') }}
{{ Asset::queue('apps4u-oauth2', 'apps4u/oauth2::js/script.js', 'jquery') }}

{{-- Partial Assets --}}
@section('assets')
@parent
@stop

{{-- Inline Styles --}}
@section('styles')
@parent
@stop

{{-- Inline Scripts --}}
@section('scripts')
@parent
<script>
    jQuery(document).ready(function ($) {

    });
</script>
@stop

{{-- Page content --}}
@section('content')
<section id="apps4u-oauth2">

    <header class="clearfix">
        <h1>{{ trans('apps4u/oauth2::general.title') }}</h1>

        <nav class="tertiary-navigation pull-right">

        </nav>
    </header>

    <hr>

    <section class="content">

        <h3>{{ trans('apps4u/oauth2::general.byline') }}</h3>

    </section>
    Front Index Oauth2
</section>
@stop

