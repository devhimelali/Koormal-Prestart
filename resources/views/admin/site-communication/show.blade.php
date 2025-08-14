@extends('layouts.app')
@section('title', 'View Site Communications')
@section('content')
    <x-common.breadcrumb
        :title="'Details of Site Communication: ' . $siteCommunication->title"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('redirect')],
            ['label' => 'Site Communications', 'url' => route('site-communications.index')],
            ['label' => 'View']
        ]"/>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="card-title">Title: {{ $siteCommunication->title }}</h4>
                    <p class="card-category mb-0">Description: {{ $siteCommunication->description }}</p>
                    <p class="card-category mb-0">Date: {{ $siteCommunication->created_at->format('d-m-Y') }}</p>
                </div>
                <div class="card-body">
                    <div class="pdf-viewer">
                        @if ($siteCommunication && $siteCommunication->path !== null)
                            <iframe src="{{ route('site-communications.preview', basename($siteCommunication->path)) }}"
                                    width="100%" height="800px" style="border:none;"></iframe>
                        @else
                            <div class="alert alert-warning" role="alert">
                                The PDF file could not be found.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
