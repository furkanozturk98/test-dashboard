@extends('layouts.app')

@section('content')

    <div class="row mb-4 widgets">
        <div class="col-md-3">
            <div class="card widget-date">
                <div>
                    <div class="icon">
                        <i class="far fa-calendar-alt"></i>
                    </div>

                    <div class="info">
                        <div class="value">{{ $testRun->created_at->toDateString() }}</div>
                        <div class="title">Date</div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col">
            <div class="card widget-tests">
                <div>
                    <div class="icon">
                        <i class="fas fa-search"></i>
                    </div>

                    <div class="info">
                        <div class="value">{{ $testRun->tests }}</div>
                        <div class="title">Tests</div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col">
            <div class="card widget-duration">
                <div>
                    <div class="icon">
                        <i class="far fa-clock"></i>
                    </div>

                    <div class="info">
                        <div class="value">{{ gmdate('i:s', $testRun->time) }}</div>
                        <div class="title">Duration</div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col">
            <div class="card widget-success">
                <div>
                    <div class="icon">
                        <i class="fas fa-check"></i>
                    </div>

                    <div class="info">
                        <div class="value">{{ $status['success'] }}</div>
                        <div class="title">Success</div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col">
            <div class="card widget-fail">
                <div>
                    <div class="icon">
                        <i class="fas fa-times"></i>
                    </div>

                    <div class="info">
                        <div class="value">{{ $status['fail'] }}</div>
                        <div class="title">Failure</div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="row mb-4">

        <div class="col-md-3">
            <test-counts-by-statuses :test-run-id="{{ $testRun->id }}"></test-counts-by-statuses>
        </div>

        <div class="col-md-9">
            <test-counts-by-duration :test-run-id="{{ $testRun->id }}"></test-counts-by-duration>
        </div>

    </div>

    @include('_table')
@endsection
