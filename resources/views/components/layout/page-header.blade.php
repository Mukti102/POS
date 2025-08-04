@props(['title' => 'sss','subtitle' => 'ssss'])

<div class="page-header">
    <div class="page-title">
        <h4>{{ $title }}</h4>
        <h6>{{ $subtitle }}</h6>
    </div>
    {{$slot}}
</div>
