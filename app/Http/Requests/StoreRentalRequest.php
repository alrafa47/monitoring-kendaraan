<?php

namespace App\Http\Requests;

use App\Models\Transport;
use Illuminate\Foundation\Http\FormRequest;

class StoreRentalRequest extends FormRequest
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
        $transports = Transport::where('status', true)->get();
        return [
            'driver' => 'required|exists:employees,id',
            'transport' => 'required|in:' . $transports->implode('id', ','),
        ];
    }
}
