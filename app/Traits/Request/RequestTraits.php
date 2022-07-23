<?php


namespace App\Traits\Request;

use JsonException;
use App\Models\User;
use App\Models\Status;
use App\Models\Esims\ClientEsim;
use App\Models\HowTos\HowToType;
use Spatie\Permission\Models\Role;

trait RequestTraits
{
    public function getCheckValue($field): int
    {
        $formInput = $this->all();
        if (array_key_exists($field, $formInput)) {
            if (is_null($formInput[$field])) {
                return 0;
            }
            return ($formInput[$field] === "true" || $formInput[$field] === "1" || $formInput[$field] === true) ? 1 : 0;
        }
        return 0;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function decodeJsonField($value) {
        try {
            return json_decode($value, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
        }
    }

    public function setRelevantRole($value, $json_decode_before = false): ?Role
    {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        if ($value) {
            return Role::where('id', $value['id'])->first();
        }
        return null;
    }

    public function setCheckOrOptionValue($value): int
    {
        if (is_null($value) || $value === "null") {
            $value = null;
        }
        if ($value === "true") {
            $value = true;
        }
        if ($value === "false") {
            $value = false;
        }
        return (int)$value;
    }

    public function setRelevantUser($value, $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? User::where('id', $value['id'])->first() : null;
    }

    public function setRelevantClientEsim($value, $field = 'id', $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? ClientEsim::where($field, $value[$field])->first() : null;
    }

    public function setRelevantHowToType($value, $field = 'id', $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? HowToType::where($field, $value[$field])->first() : null;
    }

    public function setRelevantStatus($value, $field = 'id', $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? Status::where($field, $value[$field])->first() : null;
    }

    public function setRelevantIdsList($value, $json_decode_before = false): ?array
    {
        if (is_null($value) || empty($value)) {
            return null;
        }

        if ($json_decode_before) {
            $value = $this->decodeJsonField($value);
        }
        if (is_null($value) || empty($value)) {
            return null;
        }

        $ids = [];
        foreach ($value as $item) {
            $ids[] = $item['id'];
        }
        return $ids;
    }
}
