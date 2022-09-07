<?php
require_once 'RepositoryInterface.php';

class UserDbRepository implements RepositoryInterface
{
    public function __construct(private readonly PDO $connect,)
    {
    }

    public function create(array $data)
    {
        try {
            $this->connect->beginTransaction();
            $this->connect->prepare('INSERT INTO users (email, name, password) VALUES (:email,:name,:password)')
                ->execute($data);

            $this->connect->commit();
        } catch (PDOException $e) {
            $this->connect->rollBack();
            var_dump('$e');
        }
    }

    public function read(int $id): object
    {
        return $this->connect
            ->query("SELECT * FROM users WHERE id=$id")
            ->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Get records from the table by filters.
     *
     * @param array $filters
     *   Conditions for select query.
     * Example: ['email' => ['test@user.com', 'test2@user.com']].
     * @param array $fields
     *   If you don't need all fields you can set some.
     * Example: ['email', 'password'].
     *
     * @return array
     *   Found records.
     */
    public function readMultiple(array $filters, array $fields = []): array
    {
        if ($fields && !array_diff($fields, User::FIELDS)) {
            $fields = implode(',', $fields);
        } else {
            $fields = 'users.*';
        }

        $where = [];
        $values = [];

        foreach ($filters as $filter => $value) {
            if ($value || $value === 0) {
                $value = (array)$value;
                $placeholders = implode(',', array_fill(0, count($value), '?'));
                $where[] = "$filter IN ($placeholders)";
                $values = [...$values, ...$value];
            } else {
                $where[] = "($filter IS NULL OR $filter='')";
            }
        }

        $where = implode(' AND ', $where);

        $s = $this->connect->prepare("SELECT id, $fields FROM users WHERE $where");
        $s->execute($values);

        return array_map('current', $s->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_OBJ));
    }

    public function readAll(bool $reverse = false): array
    {
        return array_map('current', $this->connect->query('SELECT id, u.* FROM users u')
            ->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_OBJ));
    }

    public function update(int $id, array $data)
    {
        try {
            $this->connect->beginTransaction();

            $set = implode(',', array_map(fn($field) => "$field=:$field", array_keys($data)));
            $statement = $this->connect->prepare("UPDATE users SET $set WHERE id=:id");
            $statement->execute(['id' => $id] + $data);

            $this->connect->commit();

        } catch (PDOException $e) {
            $this->connect->rollBack();
            var_dump($e);
        }
    }

    public function delete(int $id)
    {
        try {
            $this->connect->beginTransaction();

            $this->connect->prepare('DELETE FROM users WHERE id=?')->execute([$id]);

            $this->connect->commit();

        } catch (PDOException $e) {
            $this->connect->rollBack();
            var_dump($e);
        }
    }
}