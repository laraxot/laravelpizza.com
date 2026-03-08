<?php

namespace Modules\EventFeedbackType\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\EventFeedbackType\Database\Factories\EventFeedbackTypeFactory;

class EventFeedbackType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    protected static function newFactory()
    {
        return EventFeedbackTypeFactory::new();
    }

    public function feedbacks()
    {
        return $this->hasMany(\Modules\EventFeedback\App\Models\EventFeedback::class);
    }
}