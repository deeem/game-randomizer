<?php

namespace App\Http\Controllers;

use App\Rule;
use App\Http\Requests\StoreRuleRequest;
use App\Http\Requests\UpdateRuleRequest;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Requests\StoreRuleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRuleRequest $request)
    {
        $data = $request->only('title', 'body');

        Rule::create($data);

        return redirect()->route('rules.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rule  $rule
     * @return \Illuminate\Http\Response
     */
    public function show(Rule $rule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rule  $rule
     * @return \Illuminate\Http\Response
     */
    public function edit(Rule $rule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRuleRequest  $request
     * @param  \App\Rule  $rule
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRuleRequest $request, Rule $rule)
    {
        $data = $request->only('title', 'body');

        $rule->fill($data);
        $rule->save();

        return redirect()->route('rules.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rule  $rule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rule $rule)
    {
        //
    }
}
