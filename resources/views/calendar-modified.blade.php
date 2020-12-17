@section('title', ' | Calendar Advance')
@extends('layouts.app')

@section('header')
	<x-navbar />
@endsection

@section('content')
	<?php
		$pageData = new \stdClass();

		$pageData = json_encode($pageData);
	?>

	<calendar-advance
		:page-data="{{ $pageData }}">
	</calendar-advance>
@endsection
