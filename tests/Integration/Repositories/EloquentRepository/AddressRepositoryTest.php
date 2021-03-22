<?php


namespace Boleto\Tests\Integration\Repositories\EloquentRepository;

use Boleto\Models\Address;
use Boleto\Repositories\Eloquent\AddressRepository;
use Boleto\Repositories\Eloquent\PersonRepository;
use Boleto\Tests\TestCase;
use Illuminate\Support\Collection;


class AddressRepositoryTest extends TestCase
{
    private AddressRepository $repository;
    private array $addressData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new AddressRepository();
        $person = app()->make(PersonRepository::class)->create(['name' => 'User Test', 'cpf_cnpj'=>12345678910]);
        $this->addressData = [
            'street' => 'Test Address',
            'complement' => 'Test',
            'number' => '5500',
            'neighborhood' => 'Test',
            'cep' => '99999999',
            'city' => 'Test',
            'UF' => 'RJ',
            'person_id' => $person->id,
        ];
    }

    public function testGet()
    {
        $this->assertInstanceOf(Collection::class, $this->repository->get());
    }

    public function testCreate()
    {
        $this->assertInstanceOf(Address::class, $this->repository->create($this->addressData));
        $this->assertDatabaseHas('addresses', $this->addressData);
        $this->assertDatabaseCount('addresses', 1);
    }

    public function testFind()
    {
        $this->repository->create($this->addressData);
        $this->assertDatabaseCount('addresses', 1);
        $this->assertInstanceOf(Address::class, $this->repository->find(1));
    }

    public function testUpdate()
    {
        $this->repository->create($this->addressData);
        $this->assertDatabaseCount('addresses', 1);
        $this->assertInstanceOf(Address::class, $this->repository->find(1));
    }

    public function testDelete()
    {
        $this->repository->create($this->addressData);
        $this->assertDatabaseCount('addresses',1);
        $person = $this->repository->delete( 1);
        $this->assertInstanceOf(Address::class, $person);
        $this->assertSoftDeleted('addresses', ['id' => $person->id]);
    }
}
