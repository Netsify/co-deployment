<?php

namespace App\Services;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Log;

/**
 * Сервис для работы с базой знаний
 *
 * Class KnowledgeBaseService
 * @package App\Services
 */
class KnowledgeBaseService
{
    private $_article;
    private $_user;

    /**
     * KnowledgeBaseService constructor.
     * @param Article $article
     * @param User $user
     */
    public function __construct(Article $article, User $user)
    {
        $this->_article = $article;
        $this->_user = $user;
    }

    /**
     * Создаём статью
     *
     * @param array|null $tags
     * @return bool
     */
    public function createArticle(array $tags = null, array $files = null): bool
    {
        $article = $this->_user->articles()->save($this->_article);

        if (!$article) {
            Log::error('Не удалось создать статью', [
                'article' => $this->_article->toArray(),
                'user' => $this->_user->toArray()
            ]);

            return false;
        }

        $this->_article = $article;

        if (!$this->setTagsToArticle($tags)) {
            Log::error('Не удалось добавить теги к статье', [
                'article' => $this->_article,
                'tags'    => $tags
            ]);

            return false;
        }

        foreach ($files as $file) {
            // создание файлов в отдельной таблице
        }

        return true;
    }

    /**
     * Обновляет статью
     *
     * @param array|null $tags
     * @return bool
     */
    public function updateArticle(array $tags = null): bool
    {
        if (!$this->_article->save()) {
            return false;
        }

        if (!$this->setTagsToArticle($tags)) {
            Log::error('Не удалось изменить теги у статьи', [
                'article' => $this->_article,
                'tags'    => $tags
            ]);

            return false;
        }

        return true;
    }

    /**
     * Добавляет теги к статье или удаляет
     *
     * @param array $tags
     * @return int
     */
    private function setTagsToArticle(array $tags): int
    {
        return empty($tags) ? $this->_article->tags()->detach() : count($this->_article->tags()->sync($tags));
    }
}
