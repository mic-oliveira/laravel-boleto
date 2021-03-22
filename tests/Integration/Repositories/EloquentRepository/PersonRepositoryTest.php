<?php


namespace Boleto\Tests\Integration\Repositories\EloquentRepository;

use Boleto\Models\Person;
use Boleto\Repositories\Eloquent\PersonRepository;
use Boleto\Tests\TestCase;
use Illuminate\Support\Collection;

class PersonRepositoryTest extends TestCase
{
    private PersonRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new PersonRepository();
    }

    public function testGet()
    {
        $this->repository->create(['name' => 'User Test 1', 'cpf_cnpj'=>12345678910]);
        $this->assertDatabaseCount('people',1 );
        $this->assertInstanceOf(Collection::class, $this->repository->get());
    }

    public function testCreate()
    {

        $this->assertDatabaseCount('people',0);
        $person = ['name' => 'User Test 2', 'cpf_cnpj'=>12345678911];
        $p = $this->repository->create($person);
        $this->assertInstanceOf(Person::class, $p);
        $this->assertDatabaseHas('people', $person);
        $this->assertDatabaseCount('people',1);
    }

    public function testFind()
    {
        $this->repository->create(['name' => 'User Test 1', 'cpf_cnpj'=>12345678910]);
        $this->assertDatabaseCount('people',1);
        $this->assertInstanceOf(Person::class, $this->repository->find(1));
    }

    public function testUpdate()
    {
        $this->repository->create(['name' => 'User Test 1', 'cpf_cnpj'=>12345678910]);
        $this->assertDatabaseCount('people',1);
        $person = ['name' => 'User Test Updated', 'cpf_cnpj'=>12345678913];
        $this->assertInstanceOf(Person::class, $this->repository->update($person, 1));
        $this->assertDatabaseHas('people', $person);
    }

    public function testDelete()
    {
        $this->repository->create(['name' => 'User Test 1', 'cpf_cnpj'=>12345678910]);
        $this->assertDatabaseCount('people',1);
        $person = $this->repository->delete( 1);
        $this->assertInstanceOf(Person::class, $person);
        $this->assertSoftDeleted('people', ['id' => $person->id]);
    }

}
