<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Requests\Setting\UpdateSettingRequest;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $all_settings = Setting::all()->toArray();

        //dd($all_settings);

        $tree = $this->buildTree($all_settings);
        $tree_clean = $this->cleanTree($tree);
        dd($tree,$tree_clean);
    }

    public function fetch() {
        $settings = Setting::all();

        return $settings;
    }

    function buildTree(array $elements, $parentId = 0) {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['group_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[$element['name']] = $element;
            }
        }

        return $branch;
    }

    private function cleanTree($tree) {
        $final_tree = [];
        foreach ($tree as $key => $item) {
            if (isset($item['children'])) {
                $final_tree[$key]['default'] = $item['value'];
                $final_tree[$item['name']] = $this->cleanTree($item['children']);
            } else {
                $final_tree[$key] = isset($item['value']) ? $this->getParsedValue($item) : $item;
            }
        }
        return $final_tree;
    }

    private function getParsedValue($setting) {
        if ($setting['value'] === null) {
            return $setting['value'];
        } elseif ($setting['type'] === "string") {
            return $setting['value'];
        } elseif ($setting['type'] === "integer") {
            return (int)$setting['value'];
        } elseif ($setting['type'] === "bool") {
            return (bool)$setting['value'];
        } elseif ($setting['type'] === "float") {
            return (float)$setting['value'];
        } elseif ($setting['type'] === "array") {
            return explode($setting['array_sep'], $setting['value']);
        }
        return $setting['value'];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Setting $setting
     * @return void
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Setting $setting
     * @return void
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSettingRequest $request
     * @param Setting $setting
     * @return Setting
     */
    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        $setting->update([
            'value' => $request->value,
            'type' => $request->type,
            'array_sep' => $request->array_sep,
            'description' => $request->description,
        ]);

        $setting->setGroup($request->group, true);

        return $setting->load('group');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Setting $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
