<?php

namespace App\Http\Controllers\HowTos;

use Illuminate\View\View;
use App\Models\HowTos\HowToThread;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Http\Resources\SearchCollection;
use App\Http\Requests\HowToThread\FetchRequest;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Resources\HowTos\HowToThreadResource;
use App\Http\Requests\HowToThread\StoreHowToThreadRequest;
use App\Http\Requests\HowToThread\UpdateHowToThreadRequest;
use App\Repositories\Contracts\IHowToThreadRepositoryContract;

class HowToThreadController extends Controller
{
    /**
     * @var IHowToThreadRepositoryContract
     */
    private $repository;

    /**
     * ClientEsimController constructor.
     *
     * @param IHowToThreadRepositoryContract $repository [description]
     */
    public function __construct(IHowToThreadRepositoryContract $repository) {
        $this->repository = $repository;
    }

    /**
     * Fetch records.
     *
     * @param  FetchRequest     $request [description]
     * @return SearchCollection          [description]
     */
    public function fetch(FetchRequest $request): SearchCollection
    {
        return new SearchCollection(
            $this->repository->search($request), HowToThreadResource::class
        );
    }

    public function fetchall() {
        return HowToThread::all();
    }

    public function read($id, $posi) {
        $howtothread = HowToThread::where('id', $id)->first();
        return view('howtothreads.read')
            ->with('howtothread', $howtothread)
            ->with('posi', $posi);
    }

    /**
     * Display products page.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */
    public function index()
    {
        return view('howtothreads.index')
            ->with('perPage', new Collection(config('system.per_page')))
            ->with('defaultPerPage', config('system.default_per_page'));
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
     * @param StoreHowToThreadRequest $request
     * @return HowToThreadResource|void
     */
    public function store(StoreHowToThreadRequest $request)
    {
        $howtothread = HowToThread::createNew(
            $request->title,
            $request->description,
            $request->code,
            $request->tags
        );
        return new HowToThreadResource($howtothread);
    }

    /**
     * Display the specified resource.
     *
     * @param HowToThread $howtothread
     * @return Application|Factory|\Illuminate\Contracts\View\View|void
     */
    public function show(HowToThread $howtothread)
    {
        return view('howtothreads.show')
            ->with('howtothread', $howtothread);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param HowToThread $howtothread
     * @return void
     */
    public function edit(HowToThread $howtothread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateHowToThreadRequest $request
     * @param HowToThread $howtothread
     * @return HowToThreadResource|void
     */
    public function update(UpdateHowToThreadRequest $request, HowToThread $howtothread)
    {
        $howtothread->updateOne(
            $request->title,
            $request->description,
            $request->code,
            $request->tags
        );
        return new HowToThreadResource($howtothread);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param HowToThread $howtothread
     * @return void
     */
    public function destroy(HowToThread $howtothread)
    {
        //
    }
}
