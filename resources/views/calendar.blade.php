@section('title', ' | Calendar Basic')
@extends('layouts.app')

@section('header')
	<x-navbar />
@endsection

@section('content')
	<?php
		$pageData = new \stdClass();

		$pageData = json_encode($pageData);
	?>

	<calendar-basic
		:page-data="{{ $pageData }}">
	</calendar-basic>
@endsection
