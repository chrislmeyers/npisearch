<div id="search-page">
    <div id="left-container">
        <div class="form-container padded-container">
            <div class="heading">Search the database</div>
            <form wire:submit="search">
                <div class="form-field">
                    <div class="form-label">
                        <label for="first_name">First Name:</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="first_name" wire:model="searchData.first_name">
                    </div>
                </div>

                <div class="form-field">
                    <div class="form-label">
                        <label for="last_name">Last Name:</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="last_name" wire:model="searchData.last_name">
                    </div>
                </div>

                <div class="form-field">
                    <div class="form-label">
                        <label for="number">NPI Number:</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="number" wire:model="searchData.number">
                    </div>
                </div>

                <div class="form-field">
                    <div class="form-label">
                        <label for="taxonomy_description">Description:</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="taxonomy_description" wire:model="searchData.taxonomy_description">
                    </div>
                </div>

                <div class="form-field">
                    <div class="form-label">
                        <label for="city">City:</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="city" wire:model="searchData.city">
                    </div>
                </div>

                <div class="form-field">
                    <div class="form-label">
                        <label for="state">State:</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="state" wire:model="searchData.state">
                    </div>
                </div>

                <div class="form-field">
                    <div class="form-label">
                        <label for="postal_code">Zip:</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="postal_code" wire:model="searchData.postal_code">
                    </div>
                </div>

                <div class="form-button">
                    <button type="button" wire:click="resetData">Reset Data</button>
                    <button type="submit">Search</button>
                </div>
            </form>
        </div>
        @if(!empty($providerInfo))
            <div class="provider-info padded-container">
                <div class="heading">Provider Information</div>
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
            </div>
        @endif
    </div>
    <div id="right-container">
        <!-- <div>
            <p>Limit: {{$limit}}</p>
            <p>Skip: {{$skip}}</p>
            <p>Count: {{$count}}</p>
            <p>{{$message}}</p>
        </div> -->
        <div class="result-list padded-container">
            <div class="heading">Results</div>
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
