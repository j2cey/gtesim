<?php


namespace App\Traits\Esim;

use App\Models\Esims\Esim;

trait HasEsim
{
    public function esim() {
        return $this->belongsTo(Esim::class, 'esim_id');
    }

    public function attachEsim($esim_id) {
        $esim = Esim::getFirstFree($esim_id);

        $esim->setStatutAttribution();

        $this->esim()->associate($esim);
        $this->save();

        $this->esim->saveQrcode();
        $this->save();

        $esim->setStatutAttribue();

        return $this->load(['esim','esim.qrcode']);
    }

    public function changeEsim($esim_id) {

        $old_esim = $this->esim;

        $this->esim()->dissociate();
        $this->attachEsim($esim_id);

        $old_esim->setStatutFree();

        return $this;
    }

    public function dettachEsim() {

        $esim = $this->esim;

        if ($esim) {
            $this->esim()->dissociate()->save();

            $esim->setStatutFree();
        }
        return $this;
    }

    public static function bootHasEsim()
    {
        static::deleting(function ($model) {
            $model->dettachEsim();
        });
    }
}
