<?php


namespace App\Search\Queries;

use App\Models\HowTo\HowtoStep;

class HowtoStepSearch extends Search
{
    use EloquentSearch;

    /**
     * @inheritDoc
     */
    protected function query() //: Builder
    {
        $query = HowtoStep::query();

        if ($this->params->search->hasFilter()) {
            $query
                ->where('name', 'like', '%'.$this->params->search->search.'%')
                ->orWhere('email', 'like', '%'.$this->params->search->search.'%')
                ->orWhere('username', 'like', '%'.$this->params->search->search.'%');
        }

        return $query;
    }
}