@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Settings</h1>
        </div>

        <div class="card card-secondary">
            <div class="card-header">
                <h4>All Settings</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="tab-content no-padding" id="myTab2Content">
                            <div class="tab-pane fade show active" id="general-setting" role="tabpanel"
                                aria-labelledby="home-tab4">
                                <div class="card">
                                    <div class="card-body border">
                                        <form action="{{ route('admin.general-setting.update') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="">Site Name</label>
                                                <input type="text" class="form-control" name="site_name"
                                                    value="{{ config('settings.site_name') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Default Currency</label>
                                                <select name="site_default_currency" id=""
                                                    class="select2 form-control">
                                                    @foreach (config('currencys.currency_list') as $currency)
                                                        <option @selected(config('settings.site_default_currency') === $currency) value="{{ $currency }}">
                                                            {{ $currency }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Currency Icon</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ config('settings.site_currency_icon') }}"
                                                            name="site_currency_icon">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Currency Icon Position</label>
                                                        <select name="site_currency_icon_position" id=""
                                                            class="select2 form-control">
                                                            <option @selected(config('settings.site_currency_icon_position') === 'right') value="right">Right
                                                            </option>
                                                            <option @selected(config('settings.site_currency_icon_position') === 'left') value="left">Left
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-dark">Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
