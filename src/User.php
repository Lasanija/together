<?php

class User
{
    const FIELDS = [
        'id',
        'email',
        'name',
        'password',
        'reg_data',
    ];

    private RepositoryInterface $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function add(string $email, string $password, ?string $name = NULL): void
    {
        $this->repository->create([
            'email'=> trim($email),
            'password'=> md5($password),
            'name'=> trim($name ?:NULL),
        ]);
    }

    public function update(int $id, string $email = '', string $password = '', ?string $name = NULL){
        $data = [];

        if ($email){
            $data['email'] = $email;
        }
        if ($name){
            $data['name'] = $name;
        }
        if ($password){
            $data['password'] = $password;
        }

        if ($data){
            $this->repository->update($id,$data);
        }
    }

    public function delete(int $id):void{
        $this->repository->delete($id);
    }

    public function canLogin(string $email, string $password): bool
    {
        if ($record = $this->repository->readMultiple(['email'=>$email], ['password'])){
            $record = reset($record);

            return $record->password == md5($password);
        }

        return FALSE;
    }

    public function get(int $id):object{
        return $this->repository->read($id);
    }

    public function getAll():array{
        return $this->repository->readAll();
    }

    public function getMultiple(array $filters, array $fields = []):array{
        return $this->repository->readMultiple($filters,$fields);
    }
}