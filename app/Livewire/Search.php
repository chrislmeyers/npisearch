<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Search extends Component
{
    public $searchData = [
        'first_name' => '',
        'last_name' => '',
        'number' => '',
        'taxonomy_description' => '',
        'city' => '',
        'state' => '',
        'postal_code' => '',
    ];
    public $apiDebug = 'Nothing to see here';
    public $results = [];
    public $count = 0;
    public $providerInfo = null;
    public $hasBeenSubmitted = false;
    public $params = [];
    public $limit = 50;
    public $skip = 0;
    public $last = false;
    public $message = '';

    private $apiUrl = 'https://npiregistry.cms.hhs.gov/api';
    private $apiVersion = '2.1';

    public function search() {
        $this->updateParams();
        $this->message = sprintf('Submitting with skip: %d and limit: %d', $this->params['skip'], $this->params['limit']);
        $response = Http::get($this->apiUrl, $this->params);
        // dd($response);
        if (!$response->ok()) {
            $this->errorStatus = $response->response->reasonPhrase;
            return;
        }
        $this->apiDebug = $response->body();

        $result = $response->object();
        if (!empty($result->Errors)) {
            dd($result->Errors);
        }
        
        $this->count = $result->result_count ?? 0;
        $this->results = $this->collectResults($result->results);
        $this->hasBeenSubmitted = true;
    }

    public function next() {
        if ($this->count === $this->limit) {
            $this->skip += $this->limit;
            $this->search();
        }
    }

    public function previous() {
        if ($this->skip >= $this->limit) {
            $this->skip -= $this->limit;
            $this->search();
        }
    }

    public function showProvider(string $npiNumber) {
        $params = [
            'version' => '2.1',
            'number' => $npiNumber,
        ];
        
        $response = Http::get($this->apiUrl, $params);
        $result = $response->object('results');
        // dd($this->params, $response, $result);
        $infoResults = $this->collectResults($result->results, true);
        $this->providerInfo = $infoResults[0] ?? null;
        // dd($this->providerInfo);
    }

    public function resetData() {
        foreach ($this->searchData as $param => $value) {
            $this->searchData[$param] = '';
        }
        $this->params = [];
        $this->results = [];
        $this->count = 0;
        $this->providerInfo = null;
        $this->hasBeenSubmitted = false;
        $this->limit = 50;
        $this->skip = 0;
        $this->last = false;
    }

    public function render()
    {
        return view('livewire.search');
    }

    private function updateParams() {
        $this->params['version'] = $this->apiVersion;
        foreach ($this->searchData as $param => $value) {
            if ($value !== '') {
                $this->params[$param] = $value;
            }
        }
        $this->params['limit'] = $this->limit;
        $this->params['skip'] = $this->skip;
    }

    private function collectResults(array $results, $showInfo = false): array {
        $newResults = [];

        foreach ($results as $result) {
            $item = new \stdClass();
            $item->number = $result->number;
            $item->name = sprintf('%s %s', $result->basic->first_name, $result->basic->last_name);

            $taxonomy = $result->taxonomies[0] ?? null;
            $item->providerType = $taxonomy?->desc ?? 'Empty';
            $item->providerState = $taxonomy?->state ?? 'Empty';
            $item->providerLicense = $taxonomy?->license ?? 'Empty';

            if ($showInfo) {
                $item->created = $result->created_epoch ?? '';
                $item->npiType = $result->enumeration_type ?? '';
                if (!empty($result->addresses)) {
                    $item->address = $result->addresses[0];
                }
            }

            $newResults[] = $item;
        }

        return $newResults;
    }
}