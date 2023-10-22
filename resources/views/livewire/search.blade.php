<div id="search-page">
    <div id="left-container">
        <div class="form-container padded-container">
            <div class="heading">Search the database</div>
            @if(!empty($errorMessages))
                <div class="error-container">
                    <p>Errors</p>
                    <ul>
                    @foreach($errorMessages as $message)
                        <li>{{$message}}</li>
                    @endforeach
                    </ul>
                </div>
            @endif
            <form wire:submit="search">
                <div class="form-field">
                    <div class="form-label">
                        <label for="organization_name">Organization Name:</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="organization_name" wire:model="searchData.organization_name">
                        <a wire:click="clearField('organization_name')">clear</a>
                    </div>
                </div>

                <div class="form-field">
                    <div class="form-label">
                        <label for="first_name">First Name:</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="first_name" wire:model="searchData.first_name">
                        <a wire:click="clearField('first_name')">clear</a>
                    </div>
                </div>

                <div class="form-field">
                    <div class="form-label">
                        <label for="last_name">Last Name:</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="last_name" wire:model="searchData.last_name">
                        <a wire:click="clearField('last_name')">clear</a>
                    </div>
                </div>

                <div class="form-field">
                    <div class="form-label">
                        <label for="number">NPI Number:</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="number" wire:model="searchData.number">
                        <a wire:click="clearField('number')">clear</a>
                    </div>
                </div>

                <div class="form-field">
                    <div class="form-label">
                        <label for="taxonomy_description">Taxonomy:</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="taxonomy_description" wire:model="searchData.taxonomy_description">
                        <a wire:click="clearField('taxonomy_description')">clear</a>
                    </div>
                </div>

                <div class="form-field">
                    <div class="form-label">
                        <label for="city">City:</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="city" wire:model="searchData.city">
                        <a wire:click="clearField('city')">clear</a>
                    </div>
                </div>

                <div class="form-field">
                    <div class="form-label">
                        <label for="state">State:</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="state" wire:model="searchData.state">
                        <a wire:click="clearField('state')">clear</a>
                    </div>
                </div>

                <div class="form-field">
                    <div class="form-label">
                        <label for="postal_code">Zip:</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="postal_code" wire:model="searchData.postal_code">
                        <a wire:click="clearField('postal_code')">clear</a>
                    </div>
                </div>

                <div class="form-button">
                    <div wire:loading>Working...</div>
                    <button type="button" wire:click="resetData">Reset All</button>
                    <button type="submit">Search</button>
                </div>
            </form>
        </div>
        @if(!empty($providerInfo))
            <div class="padded-container">
                <div class="provider-info">
                    <div class="heading">Provider Information</div>
                    <div class="padded-container">
                        <div class="provider-info-block">
                            <div class="provider-label">NPI:</div>
                            <div class="provider-value">{{$providerInfo->number}}</div>
                        </div>
                        <div class="provider-info-block">
                            <div class="provider-label">Created:</div>
                            <div class="provider-value">{{$providerInfo->created}}</div>
                        </div>
                        <div class="provider-info-block">
                            <div class="provider-label">Name:</div>
                            <div class="provider-value">{{$providerInfo->name}}</div>
                        </div>
                        <div class="provider-info-block">
                            <div class="provider-label">Taxonomy Name:</div>
                            <div class="provider-value">{{$providerInfo->providerType}}</div>
                        </div>
                        <div class="provider-info-block">
                            <div class="provider-label">Taxonomy State:</div>
                            <div class="provider-value">{{$providerInfo->providerState}}</div>
                        </div>
                        <div class="provider-info-block">
                            <div class="provider-label">Taxonomy License:</div>
                            <div class="provider-value">{{$providerInfo->providerLicense}}</div>
                        </div>
                        <div class="provider-info-block">
                            <div class="provider-label">NPI Type:</div>
                            <div class="provider-value">{{$providerInfo->npiType}}</div>
                        </div>
                        @if(!empty($providerInfo->address))
                            <div class="provider-info-block">
                                <div class="provider-label">Address:</div>
                                <div class="provider-value">
                                    {{$providerInfo->address->address_1 ?? ''}}
                                    @if(!empty($providerInfo->address->address_2))
                                        <br />{{$providerInfo->address->address_2}}
                                    @endif
                                    <br />{{$providerInfo->address->city ?? ''}}, {{$providerInfo->address->state ?? ''}} {{$providerInfo->address->postal_code ?? ''}}
                                </div>
                            </div>
                            <div class="provider-info-block">
                                <div class="provider-label">Phone:</div>
                                <div class="provider-value">{{$providerInfo->address->telephone_number ?? ''}}</div>
                            </div>
                        @endif
                        <div class="provider-info-block">
                            <div class="provider-label">NPI Page:</div>
                            <div class="provider-value">
                                <a href="https://npiregistry.cms.hhs.gov/provider-view/{{$providerInfo->number}}" target="_blank">
                                    https://npiregistry.cms.hhs.gov/provider-view/{{$providerInfo->number}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div id="right-container">
        <div class="result-list padded-container">
            <div class="heading">Search Results</div>
            @if(count($results) > 0)
                <div class="prev-next-block">
                    @if($skip > 0)
                        <button wire:click="previous">Previous</button>
                    @endif
                    @if($count === $limit)
                        <button wire:click="next">Next</button>
                    @endif
                </div>
                @foreach($results as $result)
                    <div class="result-element" wire:click.prevent="showProvider({{ $result->number }})">
                        {{$result->number}}: {{$result->name}}, {{$result->providerType}}, {{$result->providerState}}
                    </div>
                @endforeach
                <div class="prev-next-block">
                    @if($skip > 0)
                        <button wire:click="previous">Previous</button>
                    @endif
                    @if($count === $limit)
                        <button wire:click="next">Next</button>
                    @endif
                </div>
            @elseif($hasBeenSubmitted)
                No results
            @endif
        </div>
    </div>
</div>
