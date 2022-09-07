<?php

class Comment
{
    const FIELDS = [
        'id',
        'text',
        'user_id',
        'token',
        'create_data',
    ];

    /**
     * @var CommentDbRepository
     */
    private RepositoryInterface $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


    public function add(string $text, int $user_id): void
    {
        $this->repository->create([
            'text' => trim($text),
            'user_id' => $user_id,
            'token' => md5($_SERVER['REQUEST_TIME']),
        ]);
    }

    public function update(string $token, string $text)
    {
        $data = [];

        if ($text) {
            $data['text'] = $text;
        }

        $id = $this->repository->readMultiple(['token' => $token], ['id']);
        $id = reset($id)->id;

        if ($data) {
            $this->repository->update($id, $data);
        }
    }

    public function delete(string $token): void
    {
        $this->repository->deleteByToken($token);
    }

    public function canEdit(string $token, string $user_id): bool
    {
        if ($record = $this->repository->readMultiple(['token' => $token])) {
            $record = reset($record);

            return $record->user_id == $user_id;
        }

        return FALSE;
    }

    public function get(int $id): object
    {
        return $this->repository->read($id);
    }

    public function getAll(bool $reverse = false): array
    {
        return $this->repository->readAll($reverse);
    }

    public function getMultiple(array $filters, array $fields = []): array
    {
        return $this->repository->readMultiple($filters, $fields);
    }

    public function buildComments(?stdClass $user = null)
    {
        foreach ($this->getAll(true) as $comment) {
            $data_token = $comment->token;

            if ($user && $comment->user_id == $user->id) {
                echo "<div class='comment' data-token='$data_token'>";
                echo '<p class="comment-text">' . strip_tags($comment->text) . '</p><div class="client-edit"><button  class="edit btn"><img src="assets/edit.svg" alt="edit"></button><button class="delete btn"><img src="assets/delete.svg" alt="bin"></button></div>' . '</p><div><p>' . $comment->user_name . '</p><p>' . $comment->create_date . '</p></div>';
            } else {
                echo '<div class="comment">';

                echo '<p class="comment-text">' . strip_tags($comment->text) . '</p><div><p>' . $comment->user_name . '</p><p>' . $comment->create_date . '</p></div>';
            }

            echo '</div>';
        }
    }
}