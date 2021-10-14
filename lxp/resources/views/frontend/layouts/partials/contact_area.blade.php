<section id="contact-area" class="contact-area-section backgroud-style">
    <div class="container">
        <div class="contact-area-content">
            <div class="row">
                @if(config('contact_data') != "")
                @php
                $contact_data = contact_data(config('contact_data'));
                @endphp
                <div class="col-md-6">
                    <div class="contact-left-content ">
                        <div class="section-title  mb45 headline text-left">
                            <span class="subtitle ml42  text-uppercase">@lang('labels.frontend.layouts.partials.contact_us')</span>
                            <h2><span>@lang('labels.frontend.layouts.partials.get_in_touch')</span></h2>
                            <p>
                                {{ $contact_data["short_text"]["value"] }}
                            </p>
                        </div>

                        <div class="contact-address">
                            @if(($contact_data["primary_address"]["status"] == 1) || ($contact_data["secondary_address"]["status"] == 1))
                            <div class="contact-address-details">

                                <div class="address-icon relative-position text-center float-left">
                                    <i class="fas fa-address-card"></i>
                                </div>

                                <div class="address-details ul-li-block">
                                    <ul>
                                        <!-- @if($contact_data["primary_address"]["status"] == 1)
                                                    <li>
                                                        <span>@lang('labels.frontend.layouts.partials.primary'): </span>{{$contact_data["primary_address"]["value"]}}
                                                    </li>
                                                @endif

                                                @if($contact_data["secondary_address"]["status"] == 1)
                                                    <li>
                                                        <span>@lang('labels.frontend.layouts.partials.second'): </span>{{$contact_data["secondary_address"]["value"]}}
                                                    </li>
                                                @endif -->

                                        <li>
                                            <b>DSWD Field Office Cordillera (DSWD-CAR) </b> <br>
                                            <i class="fas fa-map-marker-alt"></i> <span> #40 Northdrive, Baguio City 2600, Philippines </span>
                                        </li>
                                        <li>
                                            <i class="fas fa-globe"></i> <span>Website: car.dswd.gov.ph</span>
                                        </li>
                                        <li>
                                            <i class="fas fa-envelope"></i> <span>Email: focar@dswd.gov.ph</span>
                                        </li>
                                        <li>
                                            <i class="fas fa-phone"></i> <span>Telephone Number: 661-0430</span>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            @endif

                            @if(($contact_data["primary_phone"]["status"] == 1) || ($contact_data["secondary_phone"]["status"] == 1))
                            <div class="contact-address-details">
                                <div class="address-icon relative-position text-center float-left">
                                    <!-- <i class="fas fa-phone"></i> -->
                                    <i class="fas fa-address-card"></i>
                                </div>
                                <div class="address-details ul-li-block">
                                    <ul>
                                        <!-- @if($contact_data["primary_phone"]["status"] == 1)
                                                    <li>
                                                        <span>@lang('labels.frontend.layouts.partials.primary'): </span>{{$contact_data["primary_phone"]["value"]}}
                                                    </li>
                                                @endif

                                                @if($contact_data["secondary_phone"]["status"] == 1)
                                                    <li>
                                                        <span>@lang('labels.frontend.layouts.partials.second'): </span>{{$contact_data["secondary_phone"]["value"]}}
                                                    </li>
                                                @endif -->

                                        <li>
                                            <b>Capacity Building Section </b> <br>
                                        </li>
                                        <li>
                                            <i class="fas fa-envelope"></i> <span>Email: cbs.focar@dswd.gov.ph</span>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            @endif

                            @if(($contact_data["primary_email"]["status"] == 1) || ($contact_data["secondary_email"]["status"] == 1))

                            <div class="contact-address-details">
                                <div class="address-icon relative-position text-center float-left">
                                    <i class="fas fa-address-card"></i>
                                </div>
                                <div class="address-details ul-li-block">
                                    <ul>
                                        <!-- @if($contact_data["primary_email"]["status"] == 1)
                                                    <li>
                                                        <span>@lang('labels.frontend.layouts.partials.primary'): </span>{{$contact_data["primary_email"]["value"]}}
                                                    </li>
                                                @endif

                                                @if($contact_data["secondary_email"]["status"] == 1)
                                                    <li>
                                                        <span>@lang('labels.frontend.layouts.partials.second'): </span>{{$contact_data["secondary_email"]["value"]}}
                                                    </li>
                                                @endif -->


                                        <li>
                                            <b>Information and Communication Technology Section</b> <br>
                                        </li>
                                        <li>
                                            <i class="fas fa-envelope"></i> <span>Email: ictsupport.focar@dswd.gov.ph</span>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="genius-btn mt60 gradient-bg text-center text-uppercase ul-li-block bold-font ">
                        <a href="{{route('contact')}}">@lang('labels.frontend.layouts.partials.contact_us') <i class="fas fa-caret-right"></i></a>
                    </div>
                </div>
                @if($contact_data["location_on_map"]["status"] == 1)
                <div class="col-md-6">
                    <div id="contact-map" class="contact-map-section">
                        {!! $contact_data["location_on_map"]["value"] !!}
                    </div>
                </div>
                @endif
                @else
                <h4>@lang('labels.general.no_data_available')</h4>
                @endif
            </div>
        </div>
    </div>
</section>
