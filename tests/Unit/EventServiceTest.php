<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Services\EventService;
use App\Repositories\EloquentEventRepository;
use App\Models\Event;
use App\Exceptions\EventException;

class EventServiceTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_it_creates_event_successfully()
    {
        // Mock de la façade DB pour que transaction n'aille pas sur la DB
        DB::shouldReceive('transaction')
            ->andReturnUsing(fn($callback) => $callback());

        // Mock du repository
        $event = new Event();
        $event->title = 'Test Event';

        $repoMock = Mockery::mock(EloquentEventRepository::class);
        $repoMock->shouldReceive('create')
                 ->with(['title' => 'Test Event'])
                 ->once()
                 ->andReturn($event);

        $service = new EventService($repoMock);

        $result = $service->create(['title' => 'Test Event']);

        $this->assertInstanceOf(Event::class, $result);
        $this->assertEquals('Test Event', $result->title);
    }

    public function test_it_throws_event_exception_on_query_exception()
    {
        DB::shouldReceive('transaction')
            ->andReturnUsing(fn($callback) => $callback());

        // Mock du repository pour simuler une QueryException factice
        $repoMock = Mockery::mock(EloquentEventRepository::class);
        $repoMock->shouldReceive('create')
                 ->andThrow(new class extends QueryException {
                     public function __construct() {} // constructeur vide pour test
                 });

        $service = new EventService($repoMock);

        $this->expectException(EventException::class);
        $this->expectExceptionMessage('Erreur lors de la création du Event.');

        $service->create(['title' => 'Fail Event']);
    }
}
