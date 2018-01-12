<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Platform;
use App\Game;


class UpdateGameRequest extends FormRequest
{
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
        $platformsIds = Platform::all()->pluck('id')->toArray();

        return [
            'name' => ['required', Rule::unique('games')->where(function ($query) {
                return $query->where('name', request('name'))->where('platform_id', request('platform_id'));
            })],
            'platform_id' => ['required', Rule::in($platformsIds)]
        ];
    }
}
