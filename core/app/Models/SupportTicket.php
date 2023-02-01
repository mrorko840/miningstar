<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    public function fullname(): Attribute
    {
        return new Attribute(
            get: fn () => $this->name,
        );
    }

    public function username(): Attribute
    {
        return new Attribute(
            get: fn () => $this->email,
        );
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(
            get: fn () => $this->badgeData(),
        );
    }

    public function badgeData()
    {
        $html = '';
        if ($this->status == Status::TICKET_OPEN) {
            $html = '<span class="badge text-bg-success">' . trans("Open") . '</span>';
        } elseif ($this->status == Status::TICKET_ANSWER) {
            $html = '<span class="badge text-bg-primary">' . trans("Answered") . '</span>';
        } elseif ($this->status == Status::TICKET_REPLY) {
            $html = '<span class="badge text-bg-warning">' . trans("Customer Reply") . '</span>';
        } elseif ($this->status == Status::TICKET_CLOSE) {
            $html = '<span class="badge text-bg-dark">' . trans("Closed") . '</span>';
        }
        return $html;
    }

    public function priorityBadge(): Attribute
    {
        return new Attribute(
            get: fn () => $this->priorityBadgeData(),
        );
    }

    public function priorityBadgeData()
    {
        $html = '';
        if ($this->priority == Status::PRIORITY_LOW) {
            $html = '<span class="badge text-bg-dark">' . trans("Low") . '</span>';
        } elseif ($this->priority == Status::PRIORITY_MEDIUM) {
            $html = '<span class="badge text-bg-info">' . trans("Medium") . '</span>';
        } else {
            $html = '<span class="badge text-bg-warning">' . trans("High") . '</span>';
        }
        return $html;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supportMessage()
    {
        return $this->hasMany(SupportMessage::class);
    }
}
