<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Support;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;

class EventWindow implements IVerifiableEvent, Arrayable, Jsonable, JsonSerializable
{
    /** @var DateTimeInterface $start */
    protected $start;

    /** @var DateTimeInterface $end */
    protected $end;

    public function __construct(DateTimeInterface $start, DateTimeInterface $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function getStartTime(): DateTimeInterface
    {
        return $this->start;
    }

    public function getEndTime(): DateTimeInterface
    {
        return $this->end;
    }

    public function getAttendees(): array
    {
        return [];
    }

    public function toArray(): array
    {
        return [
            'start' => Carbon::create($this->start)->toISOString(),
            'end' => Carbon::create($this->end)->toISOString()
        ];
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
