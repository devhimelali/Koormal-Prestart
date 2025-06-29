@extends('layouts.app')
@section('title', 'Rotation Settings')
@section('content')
    <x-common.breadcrumb :title="'Rotation Settings'" :breadcrumbs="[['label' => 'Dashboard', 'url' => route('redirect')], ['label' => 'Rotation Settings']]" />
@endsection
