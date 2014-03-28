@extends('templates/default')

{{-- Page title --}}
@section('title')
{{ trans('platform/users::groups/general.title') }} ::
@parent
@stop

{{-- Queue Assets --}}
{{ Asset::queue('apps4u-oauth2', 'apps4u/oauth2::css/style.css', 'bootstrap') }}
{{ Asset::queue('apps4u-oauth2', 'apps4u/oauth2::js/script.js', 'jquery') }}
{{ Asset::queue('apps4u-oauth2', 'apps4u/oauth2::less/styles.less' 'bootstrap') }}
{{ Asset::queue('tempo', 'js/vendor/tempo/tempo.js', 'jquery') }}
{{ Asset::queue('data-grid', 'js/vendor/cartalyst/data-grid.js', 'tempo') }}

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

        <h1>{{ trans('apps4u/oauth2::general.title') }}</h1>

    </div>
</header>
<section id="apps4u-oauth2" class="page__content">
    <section class="content">

        <h3>{{ trans('apps4u/oauth2::general.byline') }}</h3>

    </section>

</section>

@stop
@section('page__footer')
<section id="oauth-admin-footer">


</section>
@stop

