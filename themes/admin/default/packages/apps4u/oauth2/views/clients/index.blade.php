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
    jQuery(document).ready(function($) {

    });
</script>
@stop

{{-- Page content --}}
@section('page')
<header class="page__header">
    <nav class="page__navigation">
        @widget('platform/menus::nav.show', array(1, 1,'navigation nav nav-tabs', admin_uri()))
    </nav>

    <div class="page__title">

        <h1><span class="total"></span> {{ trans('apps4u/media::general.title') }}</h1>

    </div>
</header>
<section id="apps4u-oauth2" class="page__content">

    <header class="clearfix">
        <h1>{{ trans('apps4u/oauth2::general.title') }}</h1>

        <nav class="tertiary-navigation pull-right">
            @widget('platform/menus::nav.show', array(2, 1, 'nav nav-pills', admin_uri()))
        </nav>
    </header>

    <hr>

    <section class="content">

        <h3>{{ trans('apps4u/oauth2::general.byline') }}</h3>
        <div class="data-grid">
            <header class="data-grid__header">

            </header>
        </div>

    </section>

</section>
@stop

