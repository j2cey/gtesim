<?php

namespace App\Http\Controllers\Employes;

use Illuminate\Http\Response;
use App\Models\Employes\PhoneNum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePhoneNumRequest;
use App\Http\Requests\UpdatePhoneNumRequest;

class PhoneNumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(): void
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePhoneNumRequest $request
     * @return void
     */
    public function store(StorePhoneNumRequest $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param PhoneNum $phonenum
     * @return void
     */
    public function show(PhoneNum $phonenum): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PhoneNum $phonenum
     * @return void
     */
    public function edit(PhoneNum $phonenum): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePhoneNumRequest $request
     * @param PhoneNum $phonenum
     * @return void
     */
    public function update(UpdatePhoneNumRequest $request, PhoneNum $phonenum): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PhoneNum $phonenum
     * @return Response|null|void
     */
    public function destroy(PhoneNum $phonenum): ?Response
    {
        //
    }
}
