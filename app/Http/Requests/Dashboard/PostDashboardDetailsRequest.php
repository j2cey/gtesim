<?php

namespace App\Http\Requests\Dashboard;

use App\Traits\Charts\EsimCharts;
use App\Models\Employes\Departement;

/**
 * Class PostDashboardDetailsRequest
 * @package App\Http\Requests\Dashboard
 *
 * @property Departement $departement
 * @property array $period
 */
class PostDashboardDetailsRequest extends DashboardRequest
{
    use EsimCharts;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            //'departements' => $this->setRelevantIdsList( $this->input('sel_departements'), false ),
            'departement' => $this->setRelevantDepartement( $this->input('sel_departement'), 'id', false ),
            'period' => $this->setPeriod(),
        ]);
    }

    private function setPeriod() {
        $sel_period = $this->input('sel_period');
        if ( is_null( $sel_period ) ) {
            return null;
        }
        if ( is_null( $sel_period[0] ) || is_null( $sel_period[1] ) ) {
            return null;
        }

        return $this->getFreePeriod( str_replace(["T23:",".000Z"], [" ",":00"],$sel_period[0] ), str_replace(["T23:",".000Z"], [" ",":00"],$sel_period[1] ) );
    }
}