<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MessagesWithStatusIfReadResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'message' => $this->message,
            'status' => $this->status,
            'type' => $this->type,
            'company' => $this->company_id,
            'startDate' => Carbon::make($this->start_date)->format('Y-m-d'),
            'endDate' => Carbon::make($this->end_date)->format('Y-m-d'),
            'isRead' => $this->isRead
        ];
    }
}
