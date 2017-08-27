<?php

namespace App\Http\Controllers;

use App\NoteModel;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class NotesController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Request $request)
    {
        $query = NoteModel::orderBy('created_at', 'desc');

        if ($request->has('search') && mb_strlen($request->input('search')) > 2) {
            $this->filterNotesByTitle($request, $query);
        }

        return $query->paginate(9);
    }

    private function filterNotesByTitle(Request $request, Builder $query)
    {
        $query->where('title', 'like', '%' . $request->input('search') . '%');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return NoteModel
     */
    public function store(Request $request)
    {
        $this->validate($request, NoteModel::getRules());

        return NoteModel::create($request->all());
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy(int $id)
    {
        NoteModel::destroy($id);

        return response('OK', 200);
    }
}
